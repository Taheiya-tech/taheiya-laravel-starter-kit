<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\App\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;

class MakeApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        Artisan::call('make:model', ['name' => $this->argument('model'), 'm' => true, 'f' => true, 's' => true]);
        Artisan::call('make:controller', ['--model' => $this->argument('model'), '--api' => true, 'name' => 'API/V1/'.$this->argument('model').'Controller']);
        Artisan::call('make:service', ['model' => $this->argument('model')]);
        Artisan::call('make:dto', ['model' => $this->argument('model')]);
        Artisan::call('make:resource', ['name' => 'V1/'.$this->argument('model').'Resource']);
        Artisan::call('make:resource', ['name' => 'V1/'.$this->argument('model').'Collection', '-c' => true]);
        Artisan::call('make:request', ['name' => 'V1/'.$this->argument('model').'/'.'Store'.$this->argument('model').'Request']);
        Artisan::call('make:request', ['name' => 'V1/'.$this->argument('model').'/'.'Update'.$this->argument('model').'Request']);
    }
}
