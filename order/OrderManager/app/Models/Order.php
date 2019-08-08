<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    public static function initModel(string $description)
    {
        $order=new self();
        $order->description=$description;
        $order->number=uniqid('',true);
        $order->status_id=Status::CREATED;
        return $order;
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
