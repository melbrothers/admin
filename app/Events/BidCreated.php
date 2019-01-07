<?php

namespace App\Events;


use App\Bid;

class BidCreated extends Event
{

    /**
     * @var Bid
     */
    private $bid;

    /**
     * Create a new event instance.
     *
     * @param Bid $bid
     */
    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }
}