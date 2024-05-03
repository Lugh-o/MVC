<?php 

use \app\Http\Response;
use \app\Controller\Api;

//rota de autorizacao da api
$obRouter->post('/api/v1/auth', [
    'middlewares' => [
        'api'
    ],
    function($request){
        return new Response(201, Api\Auth::generateToken($request), 'application/json');
    }
]);