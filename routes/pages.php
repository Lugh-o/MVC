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
$obRouter->get('/about', [
    function(){
        return new Response(200, pages\about::getAbout());
    }
]);

//rota dinâmica
$obRouter->get('/pagina/{idPagina}/{acao}', [
    function($idPagina, $acao){
        return new Response(200, 'Página '.$idPagina.' - '.$acao);
    }
]);



?>