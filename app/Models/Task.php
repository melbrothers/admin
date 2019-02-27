<?php

namespace App\Models;

use App\IndexConfigurator\TaskIndexConfigurator;
use App\ScoutElastic\Migratable;
use App\ScoutElastic\Searchable;
use App\Traits\Commentable;
use App\Traits\Rateable;
use App\Traits\SluggableHelpers;
use App\Traits\Attachable;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use Sluggable, SluggableHelpers, Attachable, Commentable, Searchable, Migratable, Rateable;

    const STATE_POSTED = 'posted';
    const STATE_ASSIGNED = 'assigned';
    const STATE_COMPLETED = 'completed';
    const STATE_OVERDUE = 'overdue';
    const STATE_DRAFT = 'draft';
    const STATE_EXPIRED = 'expired';
    const STATE_CLOSED = 'closed';

    const STATES = [self::STATE_POSTED, self::STATE_ASSIGNED, self::STATE_CLOSED, self::STATE_COMPLETED, self::STATE_OVERDUE, self::STATE_DRAFT, self::STATE_EXPIRED];

    protected $with = ['sender', 'bids', 'comments', 'attachments'];

    protected $guarded = [];

    protected $indexConfigurator = TaskIndexConfigurator::class;

    // Here you can specify a mapping for a model fields.
    protected $mapping = [
        'properties' => [
            'name' => [
                'type' => 'text',
            ],
            'description' => [
                'type' => 'text',
            ],
            'deadline' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss||yyyy-MM-dd\'T\'HH:mm:ssZZ'
            ],
            'online_or_phone' => [
                'type' => 'boolean'
            ],
            'state' => [
              'type' => 'keyword'
            ],
            'location' => [
                'properties' => [
                    'display_name' => [
                        'type' => 'text',
                    ],
                    'coordinate' => [
                        'type' => 'geo_point'
                    ]
                ],
                'type' => 'nested'
            ],
            'created_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss||yyyy-MM-dd\'T\'HH:mm:ssZZ'
            ],
            'updated_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss||yyyy-MM-dd\'T\'HH:mm:ssZZ'
            ],
        ]
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'specified_times' => 'array',
        'deadline' => 'datetime:Y-m-d\TH:i:sP',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deadline',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('bidCount', function (Builder $builder) {
           $builder->withCount('bids');
        });
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        unset($array['location_id']);
        $array['location']['display_name'] = $this->location->display_name;
        $array['location']['coordinate'] = [$this->location->longitude, $this->location->latitude];
        return $array;
    }

    public function searchableAs()
    {
        return '_doc';
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function runner()
    {
        return $this->hasOne(User::class, 'id','runner_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['name'],
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function bid($price, $body, $user = null)
    {
        $bid = new Bid;
        $bid->price = $price;
        $bid->fee = Bid::fee($price);
        $bid->gst = Bid::gst($price);
        $bid->runner()->associate($user ?: Auth::user());
        $this->bids()->save($bid);
        $bid->comment($body);

        return $bid;
    }
}
