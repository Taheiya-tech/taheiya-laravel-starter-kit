<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\App\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:starter-kit';

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
        $this->callSilent('vendor:publish', ['--tag' => 'taheiya-laravel-starter-kit']);
        $this->info('[Your-package-name] was installed successfully.');
    }
}
