<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\App\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAllFilters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-all-filters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->getModels() as $model) {
            try {
                Artisan::call('make:filter', ['model' => $model['name']]);
            } catch (\Exception $exception) {
            }

        }
    }

    private function getModels()
    {
        $models = collect(File::allFiles(app_path('Models')))
            ->map(function (\SplFileInfo $file) {
                return [
                    'name' => Str::replace('.'.$file->getExtension(), '', $file->getFilename()),
                ];
            })
//            ->pluck('filename')
            ->all();
        //            ->(); // Reset the array keys

        // Print out the models found
        return $models;
    }
}
