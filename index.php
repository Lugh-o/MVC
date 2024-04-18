<?php 

require __DIR__.'/includes/app.php';


use \app\Http\Router;

$obRouter = new Router(URL);

include __DIR__.'/routes/pages.php';

//imprime o response da rota
$obRouter->run()
            ->sendResponse();
