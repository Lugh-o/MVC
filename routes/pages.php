<?php 

use \app\Http\Response;
use \app\Controller\pages;

//rota home
$obRouter->get('/', [
    'middlewares' => [
        'cache'
    ],
    function(){
        return new Response(200, Pages\Home::getHome());
    }
]);

//rota sobre
$obRouter->get('/sobre', [
    'middlewares' => [
        'cache'
    ],
    function(){
        return new Response(200, Pages\About::getAbout());
    }
]);

//rota depoimentos
$obRouter->get('/depoimentos', [
    'middlewares' => [
        'cache'
    ],
    function($request){
        return new Response(200, Pages\Testimony::getTestimonies($request));
    }
]);

//rota depoimentos (INSERT)
$obRouter->post('/depoimentos', [
    function($request){
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);