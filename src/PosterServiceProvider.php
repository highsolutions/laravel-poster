<?php 

namespace HighSolutions\Poster;

use HighSolutions\Poster\Console\FetchCommand;
use HighSolutions\Poster\Services\Poster;
use Illuminate\Support\ServiceProvider;

class PosterServiceProvider extends ServiceProvider 
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->_loadViews();

        $this->_manageRoutes();

        $this->_basicRegister();

        $this->_commandsRegister();        

        $this->_managerRegister();    
    }

    protected function _loadViews()
    {
        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewPath, 'laravel-poster');
        $this->publishes([
            $viewPath => resource_path('assets/views/vendor/laravel-poster'),
        ], 'views');
    }

    protected function _manageRoutes()
    {
        include __DIR__ . '/../routes/routes.php';
    }

    private function _basicRegister() 
    {
        $configPath = __DIR__ . '/../config/laravel-poster.php';
        $this->mergeConfigFrom($configPath, 'laravel-poster');
        $this->publishes([
            $configPath => config_path('laravel-poster.php')
        ], 'config');
    }

    private function _commandsRegister() 
    {
        foreach($this->commandsList() as $name => $class) {
            $this->initCommand($name, $class);
        }
    }

    protected function commandsList()
    {
        return [
            'fetch' => FetchCommand::class,
        ];
    }

    private function initCommand($name, $class)
    {
        $this->app->singleton("command.laravel-poster.{$name}", function($app) use ($class) {
            return new $class($app['laravel-poster']);
        });

        $this->commands("command.laravel-poster.{$name}");
    }

    private function _managerRegister() 
    {
        $this->app->singleton('laravel-poster', function($app) {
            return $app->make(Poster::class);
        });
    }

    /**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->loadMigrations();
	}

    protected function loadMigrations()
    {
        $migrationPath = __DIR__.'/../database/migrations';
        $this->publishes([
            $migrationPath => base_path('database/migrations'),
        ], 'migrations');
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
            'laravel-poster',
            'command.laravel-poster.fetch',
        ];
	}

}
