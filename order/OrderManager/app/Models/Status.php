<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public const CREATED = 1;

    public const IN_WORK = 2;

    public const COMPLETE = 3;

    public const ABORTED = 4;

    public $timestamps = false;
    //
}
