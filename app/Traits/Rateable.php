<?php

namespace App\Traits;


use App\Rating;
use Illuminate\Database\Eloquent\Model;

trait Rateable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
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
    public function averageRating($round= null)
    {
        if ($round) {
            return $this->ratings()
                        ->selectRaw('ROUND(AVG(rating), '.$round.') as averageRateable')
                        ->pluck('averageRateable');
        }
        return $this->ratings()
                    ->selectRaw('AVG(rating) as averageRateable')
                    ->pluck('averageRateable');
    }

    /**
     *
     * @return mixed
     */
    public function countRating()
    {
        return $this->ratings()
                    ->selectRaw('count(rating) as countRateable')
                    ->pluck('countRateable');
    }


    /**
     * @param            $data
     * @param Model      $author
     * @param Model|null $parent
     *
     * @return Rating
     */
    public function rating($data, Model $author, Model $parent = null)
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
