<?php 

use \app\Http\Response;
use \app\Controller\Admin;

//rota admin
$obRouter->get('/admin', [
    function(){
        return new Response(200, 'Admin :)');
    }
]);

//rota login
$obRouter->get('/admin/login', [
    function($request){
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

//rota login post
$obRouter->post('/admin/login', [
    function($request){
        echo '<pre>';
        print_r(password_hash('teste123', PASSWORD_DEFAULT));
        echo '</pre>';
        exit;
        echo '<pre>';
        print_r($request->getPostVars());
        echo '</pre>';
        exit;
        return new Response(200, Admin\Login::getLogin($request));
    }
]);