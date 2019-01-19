<?php

namespace App;


use App\Traits\Attachable;
use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    use Attachable, Commentable;

    protected $with = ['replies', 'attachments'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

}