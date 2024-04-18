<?php 

use \app\Http\Response;
use \app\controller\pages;

//rota home
$obRouter->get('/', [
    function(){
        return new Response(200, pages\home::getHome());
    }
]);

//rota sobre
$obRouter->get('/sobre', [
    function(){
        return new Response(200, pages\about::getAbout());
    }
]);

//rota depoimentos
$obRouter->get('/depoimentos', [
    function(){
        return new Response(200, pages\testimony::getTestimonies());
    }
]);

//rota depoimentos (INSERT)
$obRouter->post('/depoimentos', [
    function($request){
        return new Response(200, pages\testimony::insertTestimony($request));
    }
]);

