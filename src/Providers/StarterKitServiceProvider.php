<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\CreateAllFilters;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\FilterCommand;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\MakeApi;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\MakeDto;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\MakeService;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\StubPublishStubsCommand;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Http\Middleware\TokenMiddleware;

class StarterKitServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                commands: [
                    StubPublishStubsCommand::class,
                    CreateAllFilters::class,
                    FilterCommand::class,
                    MakeApi::class,
                    MakeDto::class,
                    MakeService::class
                ],
            );
            $this->app->booted(function () {
                Artisan::call('stub:publish --force');
            });
        }


    }
}