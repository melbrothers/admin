<?php

namespace App\Http\Controllers;


use App\Bid;
use App\Events\BidCreated;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\Bid as BidResource;

/**
 * Class BidController
 *
 * @package App\Http\Controllers
 * @group Bid Management
 */
class BidController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param Task $task
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Task $task)
    {
        $this->authorize('review', [Bid::class, $task]);

        return BidResource::collection($task->bids);
    }

    /**
     * Create a bid
     *
     * @bodyParam price
     * @bodyParam comment
     *
     * @param Request $request
     * @param Task    $task
     *
     * @return BidResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Task $task)
    {
        $this->authorize('create', [Bid::class, $task]);
        /** @var User $user */
        $user = $request->user();
        $bid = $user->bid($task, $request->get('price'), $request->get('comment'));

        event(new BidCreated($bid));

        return new BidResource($bid);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function review()
    {

    }
}