<?php

namespace App\Traits;


use App\Models\Attachment;

trait Attachable
{
    public function attach($path)
    {
        $attachment = new Attachment();
        $attachment->path = $path;
        $attachment->attachable_id = $this->id;
        $attachment->attachable_type = get_class($this);
        $this->attachments()->save($attachment);
    }
}
