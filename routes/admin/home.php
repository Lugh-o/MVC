<?php 

use \app\Http\Response;
use \app\Controller\Admin;

//rota admin
$obRouter->get('/admin', [
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Home::getHome($request));
    }
]);
