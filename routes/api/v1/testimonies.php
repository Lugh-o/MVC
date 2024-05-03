<?php 

use \app\Http\Response;
use \app\Controller\Api;

//rota de listagem de depoimentos
$obRouter->get('/api/v1/testimonies', [
    'middlewares' => [
        'api',
        'cache'
    ],
    function($request){
        return new Response(200, Api\Testimony::getTestimonies($request), 'application/json');
    }
]);

//rota de consulta individual de depoimentos
$obRouter->get('/api/v1/testimonies/{id}', [
    'middlewares' => [
        'api',
        'cache'
    ],
    function($request, $id){
        return new Response(200, Api\Testimony::getTestimony($request, $id), 'application/json');
    }
]);

//rota de cadastro de depoimentos
$obRouter->post('/api/v1/testimonies', [
    'middlewares' => [
        'api',
        'jwt-auth'
    ],
    function($request){
        return new Response(201, Api\Testimony::setNewTestimony($request), 'application/json');
    }
]);

//rota de atualizacao de depoimentos
$obRouter->put('/api/v1/testimonies/{id}', [
    'middlewares' => [
        'api',
        'jwt-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Testimony::setEditTestimony($request, $id), 'application/json');
    }
]);

//rota de exclusao de depoimentos
$obRouter->delete('/api/v1/testimonies/{id}', [
    'middlewares' => [
        'api',
        'jwt-auth'
    ],
    function($request, $id){
        return new Response(200, Api\Testimony::setDeleteTestimony($request, $id), 'application/json');
    }
]);