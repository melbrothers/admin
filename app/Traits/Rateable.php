<?php

namespace App\Traits;


use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait Rateable
{
    private $defaultRatingBreakdown = [
        '1' => 0,
        '2' => 0,
        '3' => 0,
        '4' => 0,
        '5' => 0
    ];

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    /**
     *
     * @var $round
     * @return mixed
     */
    public function averageRating($round = null)
    {
        $rating = $this->ratings()->avg('rating');

        if ($round) {
         return \round($rating, $round);
        }

        return $rating;
    }

    /**
     * @param            $data
     * @param Model      $author
     *
     * @return Rating
     */
    public function rating($data, Model $author)
    {
        return (new Rating())->createRating($this, $data, $author);
    }

    /**
     * @param $id
     * @param $data
     * @param $parent
     *
     * @return mixed
     */
    public function updateRating($id, $data, Model $parent = null)
    {
        return (new Rating())->updateRating($id, $data);
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteRating($id)
    {
        return (new Rating())->deleteRating($id);
    }
}
