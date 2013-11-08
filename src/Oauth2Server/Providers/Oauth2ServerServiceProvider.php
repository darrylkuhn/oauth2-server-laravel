<?php namespace Oauth2Server\Providers;

use Illuminate\Support\ServiceProvider;
use \Config;

class Oauth2ServerServiceProvider extends ServiceProvider 
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ( ! Config::get('oauth2server') )
        {
            throw new Exception('Oauth2Server not configured. See: docs');
        }

        $this->app['Oauth2Server'] = $this->app->share(function($app)
        {
            switch (Config::get('oauth2server.storage_engine') )
            { 
                case: 'pdo'
                    $storage = new OAuth2\Storage\Pdo( 
                        DB::connection(Config::get('oauth2server.connection_name'))->getPdo() 
                    );
                case: 'redis'
                    $storage = new OAuth2\Storage\Redis( Cache::connection() );
                default:
                    throw new Exception('No valid storage engine specified. Supported engines include: pdo and redis.');
                    break;
            }

            return new OAuth2\Server($storage, Config::get('oauth') );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('Oauth2Server');
    }
}