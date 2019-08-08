<?php

namespace App\Console\Commands;

use App\Models\Status;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class PublishDictionaries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PublishDictionaries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    private $modelsJsonMappings = [
        'statuses' => Status::class
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->modelsJsonMappings as $name => $models) {
            $this->info("Publishing {$name}");
            $this->publish($models::all(), $name);
        }
    }

    private function publish(Collection $models, string $name): void
    {
        $mappingArray = $models->map(function ($model) {
            return $model->getAttributes();
        });
        Storage::disk('mapping')
            ->put($name . '.json', json_encode($mappingArray, JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE));
    }
}
