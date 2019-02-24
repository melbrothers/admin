<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

class CreditCardController extends Controller
{

    /**
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules($request));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'card_number' => ['required', new CardNumber],
            'expiration_year' => ['required', new CardExpirationYear($request->get('expiration_month'))],
            'expiration_month' => ['required', new CardExpirationMonth($request->get('expiration_year'))],
            'cvc' => ['required', new CardCvc($request->get('card_number'))]
        ];
    }
}
