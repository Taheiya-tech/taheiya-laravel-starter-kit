<?php

namespace TaheiyaTech\TaheiyaLaravelStarterKit\Providers;

use Illuminate\Contracts\Http\Kernel;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\CreateAllFilters;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\FilterCommand;
use TaheiyaTech\TaheiyaLaravelStarterKit\App\Console\InstallCommand;
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
                    MakeService::class,
                    InstallCommand::class
                ],
            );
            $this->app->booted(function () {
                Artisan::call('stub:publish --force');
                Artisan::call('install:starter-kit');
            });
        }
        $this->publishes([
            __DIR__. '/../docker-compose.yml' => base_path('docker-compose.yml'),
            __DIR__. '/../config/phpstan.neon' => base_path('phpstan.neon'),
            __DIR__. '/../nginx' => base_path('nginx'),
            __DIR__. '/../containers/nginx.Dockerfile' => base_path('nginx.Dockerfile'),
            __DIR__. '/../containers/php.Dockerfile' => base_path('php.Dockerfile'),
            __DIR__. '/../.dockerignore' => base_path('.dockerignore'),
            __DIR__. '/../config/.husky' => base_path('.husky'),
            __DIR__. '/../config/package.json' => base_path('package.json'),
        ], 'taheiya-laravel-starter-kit');

    }
}