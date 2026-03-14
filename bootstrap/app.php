<?php

use App\Core\Config;
use App\Core\Database;
use App\Core\Env;
use App\Core\Router;
use App\Core\Session;

require __DIR__ . '/autoload.php';

Env::load(base_path('.env'));
Config::load([
    'app' => require base_path('config/app.php'),
]);

date_default_timezone_set(config('app.timezone', 'UTC'));

Session::start();
Database::initialize();

$router = new Router();
require base_path('routes/web.php');

return $router;
