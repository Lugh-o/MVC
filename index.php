<?php 
require './vendor/autoload.php';

use \app\Http\Router;
use \app\utils\View;

define('URL', 'http://localhost:8000');

View::init([
    'URL' => URL
]);

$obRouter = new Router(URL);

include __DIR__.'/routes/pages.php';

//imprime o response da rota
$obRouter->run()
            ->sendResponse();
