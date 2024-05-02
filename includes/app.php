<?php 

require './vendor/autoload.php';

use \app\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;
use \app\Http\Middleware\Queue as MiddlewareQueue;

Environment::load(__DIR__.'/../');

Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

define('URL', getenv('URL'));

View::init([
    'URL' => URL
]);

//DEFINE O MAPEAMENTO DE MIDDLEWARES
MiddlewareQueue::setMap([
    'maintenance' => \app\Http\Middleware\Maintenance::class,
    'required-admin-logout' => \app\Http\Middleware\RequireAdminLogout::class,
    'required-admin-login' => \app\Http\Middleware\RequireAdminLogin::class,
    'api' => \app\Http\Middleware\Api::class,
    'user-basic-auth' => \app\Http\Middleware\UserBasicAuth::class,
    'jwt-auth' => \app\Http\Middleware\JWTAuth::class

]);

//DEFINE O MAPEAMENTO DE MIDDLEWARES PADROES (EXECUTADOS EM TODAS AS ROTAS)
MiddlewareQueue::setDefault([
    'maintenance'
]);
