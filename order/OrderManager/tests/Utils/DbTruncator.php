<?php
/**
 * Created by PhpStorm.
 * User: inclus
 * Date: 08.08.2019
 * Time: 21:14
 */

namespace Tests\Utils;

use Illuminate\Support\Facades\DB;

trait DbTruncator
{

    public function truncateOrders()
    {
        DB::table('orders')->truncate();
    }

}