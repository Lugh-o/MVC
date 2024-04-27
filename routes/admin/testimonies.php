<?php 

use \app\Http\Response;
use \app\Controller\Admin;

//rota de listagem de depoimentos
$obRouter->get('/admin/testimonies', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);

//rota de cadastro de um novo depoimento
$obRouter->get('/admin/testimonies/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Testimony::getNewTestimony($request));
    }
]);

//rota de cadastro de um novo depoimento (post)
$obRouter->post('/admin/testimonies/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Testimony::setNewTestimony($request));
    }
]);

//rota de edicao de um depoimento
$obRouter->get('/admin/testimonies/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request, $id){
        if(!is_numeric($id)){
            throw new \Exception("O id '".$id."' não é válido", 400);
         }
        return new Response(200, Admin\Testimony::getEditTestimony($request, $id));
    }
]);

//rota de edicao de um depoimento (post)
$obRouter->post('/admin/testimonies/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request, $id){
        if(!is_numeric($id)){
            throw new \Exception("O id '".$id."' não é válido", 400);
         }
        return new Response(200, Admin\Testimony::setEditTestimony($request, $id));
    }
]);

//rota de exclusao de um depoimento
$obRouter->get('/admin/testimonies/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\Testimony::getDeleteTestimony($request, $id));
    }
]);

//rota de exclusao de um depoimento (post)
$obRouter->post('/admin/testimonies/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request, $id){
        return new Response(200, Admin\Testimony::setDeleteTestimony($request, $id));
    }
]);
