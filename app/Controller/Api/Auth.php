<?php

namespace app\Controller\Api;

use app\Model\Entity\User;
use \Firebase\JWT\JWT;

class Auth extends Api {
    /**
     * Metodo responsavel por gerar um token JWT
     * @param Request $request
     * @return array
     */
    public static function generateToken($request){
        $postVars = $request->getPostVars();
        
        //valida os campos obrigadorios
        if(!isset($postVars['email']) or !isset($postVars['senha'])){
            throw new \Exception("Os campos 'email' e 'senha' sao obrigatorios", 400);
        }

        //Valida o usuario e a senha
        $obUser = User::getUserByEmail($postVars["email"]);
        if(!$obUser instanceof User or !password_verify($postVars['senha'],$obUser->senha)){
            throw new \Exception("O usuario ou senha sao invalidos", 400);
        }

        $payload = [
            'email' => $obUser->email
        ];
        
        return [
            'token' => JWT::encode($payload, getenv('JWT_KEY'), 'HS256')
        ];
    }
}