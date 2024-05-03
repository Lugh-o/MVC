<?php 

use \app\Http\Response;
use \app\Controller\Api;

//rota de listagem de usuarios
$obRouter->get('/api/v1/users', [
    'middlewares' => [
        'api',
        'jwt-auth',
        'cache'
    ],
    function($request){
        return new Response(200, Api\User::getUsers($request), 'application/json');
    }
]);

//rota de consulta do usuario atual
$obRouter->get('/api/v1/users/me', [
    'middlewares' => [
        'api',
        'jwt-auth'
    ],
    function($request){
        return new Response(200, Api\User::getCurrentUser($request), 'application/json');
    }
]);

//rota de consulta individual de usuarios
$obRouter->get('/api/v1/users/{id}', [
    'middlewares' => [
        'api',
        'jwt-auth',
        'cache'
    ],
    function($request, $id){
        return new Response(200, Api\User::getUser($request, $id), 'application/json');
    }
]);

//rota de cadastro de usuarios
$obRouter->post('/api/v1/users', [
    'middlewares' => [
        'api',
        'jwt-auth'
    ],
    function($request){
        return new Response(201, Api\User::setNewUser($request), 'application/json');
    }
]);

//rota de atualizacao de usuarios
$obRouter->put('/api/v1/users/{id}', [
    'middlewares' => [
        'api',
        'jwt-auth'
    ],
    function($request, $id){
        return new Response(200, Api\User::setEditUser($request, $id), 'application/json');
    }
]);

//rota de exclusao de usuarios
$obRouter->delete('/api/v1/users/{id}', [
    'middlewares' => [
        'api',
        'jwt-auth'
    ],
    function($request, $id){
        return new Response(200, Api\User::setDeleteUser($request, $id), 'application/json');
    }
]);