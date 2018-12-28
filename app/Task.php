<?php
/**
 * Created by PhpStorm.
 * User: Lixing
 * Date: 2018-12-20
 * Time: 21:11
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}