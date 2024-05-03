<?php 

use \app\Http\Response;
use \app\Controller\Admin;

//rota de listagem de usuarios
$obRouter->get('/admin/users', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\User::getUsers($request));
    }
]);

//rota de cadastro de um novo usuario
$obRouter->get('/admin/users/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\User::getNewUser($request));
    }
]);

//rota de cadastro de um novo usuario (post)
$obRouter->post('/admin/users/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\User::setNewUser($request));
    }
]);

//rota de edicao de um usuario
$obRouter->get('/admin/users/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request, $id){
        if(!is_numeric($id)){
            throw new \Exception("O id '".$id."' não é válido", 400);
         }
        return new Response(200, Admin\User::getEditUser($request, $id));
    }
]);

//rota de edicao de um usuario (post)
$obRouter->post('/admin/users/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request, $id){
        if(!is_numeric($id)){
            throw new \Exception("O id '".$id."' não é válido", 400);
         }
        return new Response(200, Admin\User::setEditUser($request, $id));
    }
]);

//rota de exclusao de um usuario
$obRouter->get('/admin/users/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\User::getDeleteUser($request, $id));
    }
]);

//rota de exclusao de um usuario (post)
$obRouter->post('/admin/users/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\User::setDeleteUser($request, $id));
    }
]);