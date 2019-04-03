<?php

namespace App\Http\Controllers;



use App\Models\BillingAddress;
use App\Models\PaymentMethod;
use App\Models\User;
use Cartalyst\Stripe\Exception\StripeException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     *
     */
    public function disbursementMethods()
    {

    }

    /**
     * @OA\Post(
     *     path="/account/payment_methods",
     *     tags={"Account"},
     *     summary="Create a new payment method",
     *     @OA\RequestBody(
     *          description="create payment method",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="token",
     *                      description="Token form stripe",
     *                      type="string",
     *                      example="av12312vsdasd"
     *                  ),
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Createa a comment successfully"
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error"
     *     )
     * )
     * @param Request $request
     *
     * @return UserResource
     */
    public function paymentMethods(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        try {
            $customer = Stripe::customers()->create([
                'email' => $user->email,
                'source' => $request->get('token')
            ]);

            $user->stripe_customer_id = $customer['id'];
            $user->save();
        } catch (StripeException $e) {
            return abort($e->getCode(), $e->getMessage());
        }


//        $charge = Stripe::charges()->create([
//           'customer' => $customer['id'],
//           'currency' => 'AUD',
//           'amount'   => 0
//        ]);
//
//        dd($charge);
        $card = $customer['sources']['data'][0];
        if (!$paymentMethod = $user->paymentMethod) {
            $paymentMethod = new PaymentMethod();
        }

        $paymentMethod->kind = 'card';
        $paymentMethod->active = true;
        $paymentMethod->last_four = $card['last4'];
        $paymentMethod->exp_month = $card['exp_month'];
        $paymentMethod->exp_year = $card['exp_year'];
        $paymentMethod->brand = $card['brand'];
        $user->paymentMethod()->save($paymentMethod);

        return new UserResource($user);
    }

    /**
     * @OA\Post(
     *     path="/account/billing-address",
     *     tags={"Account"},
     *     summary="Create a new billing-address",
     *     @OA\RequestBody(
     *          description="Create data format",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="address_line_1",
     *                      description="Billing address line 1",
     *                      type="string",
     *                      example="This is a bid comment"
     *                  ),
     *                  @OA\Property(
     *                      property="address_line_2",
     *                      description="Billing address line 1",
     *                      type="string",
     *                      example=""
     *                  ),
     *                  @OA\Property(
     *                      property="country",
     *                      description="Country",
     *                      type="string",
     *                      example="This is a bid comment"
     *                  ),
     *                  @OA\Property(
     *                      property="postcode",
     *                      description="Post code",
     *                      type="string",
     *                      example="This is a bid comment"
     *                  ),
     *                  @OA\Property(
     *                      property="state",
     *                      description="State",
     *                      type="string",
     *                      example="This is a bid comment"
     *                  ),
     *                  @OA\Property(
     *                      property="suburb",
     *                      description="Suburb",
     *                      type="string",
     *                      example="This is a bid comment"
     *                  ),
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Createa a comment successfully"
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error"
     *     )
     * )
     * @param Request $request
     *
     * @return UserResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postBillingAddress(Request $request)
    {
        $this->validate($request, $this->rules());
        /** @var User $user */
        $user = $request->user();

        if ($user->stripe_customer_id) {
            $customer = Stripe::customers()->find($user->stripe_customer_id);
        } else {
            $customer = Stripe::customers()->create([
                'email' => $user->email,
            ]);

            $user->stripe_customer_id = $customer['id'];
            $user->save();
        }

        if (!$billingAddress = $user->billingAddress) {
            $billingAddress = new BillingAddress();
        }

        $billingAddress->address_line_1 = $request->get('address_line_1');
        $billingAddress->address_line_2 = $request->get('address_line_2');
        $billingAddress->country = $request->get('country');
        $billingAddress->postcode = $request->get('postcode');
        $billingAddress->state = $request->get('state');
        $billingAddress->suburb = $request->get('suburb');
        $user->billingAddress()->save($billingAddress);

        return new UserResource($user);
    }


    public function deleteBillingAddress(Request $request)
    {
        $user = $request->user();

        $user->billingAddress->delete();

        return new UserResource($user);
    }

    protected function rules()
    {
        return [
            'address_line_1' => 'required',
            'country'        => 'required',
            'postcode'       => 'required',
            'state'          => 'required',
            'suburb'         => 'required',
        ];
    }
}
