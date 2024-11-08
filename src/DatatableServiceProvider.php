<?php

namespace Nicotc\Datatable;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Nicotc\Datatable\Http\Livewire\Datatable;

class DatatableServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {

        // Cargar las vistas del paquete
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'datatable');

        // Registrar los componentes de Livewire
        Livewire::component('datatable', Datatable::class);




        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // Registrar la configuración del paquete
        $this->mergeConfigFrom(__DIR__.'/../config/datatable.php', 'datatable');

        // Registrar el servicio que proporciona el paquete.
        $this->app->singleton('datatable', function ($app) {
            return new Datatable;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['datatable'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publicar el archivo de configuración.
        $this->publishes([
          __DIR__.'/../resources/views' => resource_path('views/vendor/datatable'),
      ], 'datatable.views');

    }
}
