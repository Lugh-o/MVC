<?php 

use \app\Http\Response;
use \app\Controller\Api;


//rota raiz da api
$obRouter->get('/api/v1', [
    'middlewares' => [
        'api'
    ],
    function($request){
        return new Response(200, Api\Api::getDetails($request), 'application/json');
    }
]);