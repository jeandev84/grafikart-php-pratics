<?php
use Grafikart\Container\Container;
use Grafikart\Templating\Layout;

$app = Container::instance();

$app['root'] = dirname(__DIR__);
$app->singleton('config', function ($app) {
   return new \Grafikart\Config\Config([
      'app'      => require $app['root'] . "/config/app.php",
      'database' => require $app['root'] . "/config/database.php"
   ]);
});
$app->singleton('database', function ($app) {
   return new \Grafikart\Database\Connection\PdoConnection(
       $app['config']['database']['dsn'],
       $app['config']['database']['username'],
       $app['config']['database']['password'],
       $app['config']['database']['options']
   );
});
$app['router'] = function ($app) {
    return (require $app['root'] .'/routes/web.php');
};
$app['view'] = function ($app) {
    return new Layout($app['root'] ."/views/layouts/default.php");
};


return $app;