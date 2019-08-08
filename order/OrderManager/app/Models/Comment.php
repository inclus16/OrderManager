<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;

    public static function initModel(string $content):self
    {
        $comment=new self();
        $comment->content=$content;
        return $comment;
    }

    public function setOrderId(int $orderId):self
    {
        $this->order_id=$orderId;
        return $this;
    }

    public function setNumber(int $number):self
    {
        $this->number=$number;
        return $this;
    }
}
