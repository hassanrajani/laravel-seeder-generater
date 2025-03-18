<?php

namespace Zainularfeen\SeederGenerator;

use Illuminate\Support\ServiceProvider;
use Zainularfeen\SeederGenerator\Console\GenerateSeedersCommand;

class SeederGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register command
        $this->commands([
            GenerateSeedersCommand::class,
        ]);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Console/stubs/seeder.stub' => base_path('stubs/seeder.stub'),
        ], 'seeder-stubs');
    }
}
