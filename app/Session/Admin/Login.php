<?php 

namespace app\Session\Admin;

use app\Model\Entity\User;

class Login {

    /**
     * Método responsável por iniciar a sessão
     * 
     */
    private static function init(){
        //verifica se a sessao nao esta ativa
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    /**
     * Método responsável por criar o login do usuário
     * @param User $obUser
     * @return boolean
     */
    public static function login($obUser) {
        self::init();

        //define a sessão do usuario
        $_SESSION['admin']['usuario'] = [
            'id' => $obUser->id,
            'nome' => $obUser->nome,
            'email'=> $obUser->email
        ];

        return true;
    }

    /**
     * Método responsável por verificar se o usuário está logado
     * @return boolean
     */
    public static function isLogged() {
        self::init();
        return isset($_SESSION['admin']['usuario']['id']);
    }

    /**
     * Método responsável por executar o logout do usuário
     * @return boolean
     */
    public static function logout() {
        self::init();
        //desloga o usuario
        unset($_SESSION['admin']['usuario']);
        return true;
    }
}