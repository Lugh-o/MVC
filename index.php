<?php 

require __DIR__.'/includes/app.php';

use \app\Http\Router;

$obRouter = new Router(URL);

include __DIR__.'/routes/pages.php';
include __DIR__.'/routes/admin.php';
include __DIR__.'/routes/api.php';

//imprime o response da rota
$obRouter->run()
            ->sendResponse();
