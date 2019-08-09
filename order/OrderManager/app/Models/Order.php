<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    public static function initModel(string $description): self
    {
        $order = new self();
        $order->description = $description;
        $order->number = uniqid('', true);
        $order->status_id = Status::CREATED;
        return $order;
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function setStatusById(int $statusId): self
    {
        $this->status_id = $statusId;
        return $this;
    }



    public function addComment(Comment $comment): Comment
    {
        $comment->setOrderId($this->id);
        return $this->setCommentNumber($comment);
    }

    private function setCommentNumber(Comment $comment): Comment
    {
        $existingComments = $this->comments;
        if ($existingComments->isEmpty()){
            return $comment->setNumber(1);
        }
        return $comment->setNumber($existingComments->last()->number+1);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
