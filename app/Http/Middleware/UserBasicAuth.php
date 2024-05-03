<?php 

namespace App\Http\Middleware;

use \app\Model\Entity\User;
use \app\Http\Request;
use \app\Http\Response;

class UserBasicAuth {

    /**
     * Metodo responsavel por retornar uma instancia de usuario autenticado
     * @return User
     */
    private function getBasicAuthUser(){
        //Verifica a existencia dos dados de acesso
        if(!isset($_SERVER['PHP_AUTH_USER']) or !isset($_SERVER['PHP_AUTH_PW'])){
            return false;
        }        
        //Busca usuario por email
        $obUser = User::getUserByEmail($_SERVER['PHP_AUTH_USER']);
        if(!$obUser instanceof User){
            return false;
        }

        //Valida a senha e retorna o usuario
        return password_verify($_SERVER['PHP_AUTH_PW'], $obUser->senha) ? $obUser : false;
    }   

    /**
     * Metodo repsonsavel por validar o acesso via HTTP BASIC AUTH
     * @param Request $request
     * @return boolean
     */
    private function basicAuth($request) {
        if($obUser = $this->getBasicAuthUser()){
            $request->user = $obUser;
            return true;
        }
        throw new \Exception('Usuario ou senha invalidos', 403);
    }

    /**
     * Metodo responsavel por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response 
     */
    public function handle($request, $next) {
        $this->basicAuth($request);

        return $next($request);
    }
}