<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function rateable()
    {
        return $this->morphTo();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * @param Model $rateable
     * @param $data
     * @param Model $author
     *
     * @return static
     */
    public function createRating(Model $rateable, $data, Model $author, Model $rateableOn)
    {
        $rating = new static();
        $rating->fill(array_merge($data, [
            'author_id' => $author->id,
            'rateable_on_id' => $rateableOn->id,
            'rateable_on_type' => get_class($rateableOn),
        ]));
        $rateable->ratings()->save($rating);

        return $rating;
    }

    /**
     * @param $id
     * @param $sort
     * @return mixed
     */
    public function getAllRatings($id, $sort = 'desc')
    {
        $rating = $this
            ->select('*')
           ->where('rateable_id', $id)
           ->orderBy('created_at', $sort)
           ->get();

        return $rating;
    }
}
