<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\Providers;

use Illuminate\Support\ServiceProvider;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\CreateAllFilters;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\FilterCommand;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\MakeApi;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\MakeDto;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\MakeService;

class StarterKitServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                commands: [
                    CreateAllFilters::class,
                    FilterCommand::class,
                    MakeApi::class,
                    MakeDto::class,
                    MakeService::class
                ],
            );
        }
    }
}