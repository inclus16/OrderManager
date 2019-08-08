<?php

use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     */
    public function run()
    {
        try {
            $statusNames = '(\'новая\'), (\'в работе\'), (\'решена\'), (\'отклонена\')';
            \Illuminate\Support\Facades\DB::insert('INSERT INTO statuses(name) VALUES ' . $statusNames);
        }catch (Illuminate\Database\QueryException $exception){
            dump("Already seeded");
        }
    }
}
