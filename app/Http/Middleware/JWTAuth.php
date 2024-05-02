<?php 

namespace App\Http\Middleware;

use \app\Model\Entity\User;
use \app\Http\Request;
use \app\Http\Response;
use \Firebase\JWT\Key;
use \Firebase\JWT\JWT;

class JWTAuth {

    /**
     * Metodo responsavel por retornar uma instancia de usuario autenticado
     * @param Request $request
     * @return User
     */
    private function getJWTAuthUser($request){
        $headers = $request->getHeaders();

        //token jwt puro
        $jwt = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : '';

        
        $decode = (array)JWT::decode($jwt, new Key(getenv('JWT_KEY'), 'HS256'));
        try {
        } catch (\Exception $e) {
            throw new \Exception("Token invalido", 403);
        }


        $email = $decode['email'] ?? '';

        //Busca usuario por email
        $obUser = User::getUserByEmail($email);
        
        return $obUser instanceof User ? $obUser : false;
    }   

    /**
     * Metodo repsonsavel por validar o acesso via JWT AUTH
     * @param Request $request
     * @return boolean
     */
    private function auth($request) {
        if($obUser = $this->getJWTAuthUser($request)){
            $request->user = $obUser;
            return true;
        }
        throw new \Exception('Acesso negado', 403);
    }

    /**
     * Metodo responsavel por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response 
     */
    public function handle($request, $next) {
        $this->auth($request);

        return $next($request);
    }

}