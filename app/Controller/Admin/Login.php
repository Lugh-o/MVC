<?php 

namespace app\Controller\Admin;

use \app\Http\Request;
use app\Utils\View;
use app\model\entity\User;
use app\Session\Admin\Login as SessionAdminLogin;

class Login extends Page {
 
    /**
     * Metodo responsavel por retornar a renderizacao da pagina de login
     * @param Request $request
     * @param string $errorMessage
     * @return string
     */
    public static function getLogin($request, $errorMessage = null){

        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        $content = View::render('admin/login', [
            'status' => $status
        ]);

        return parent::getPage('Login - WDEV', $content);
    }

    /**
     * Método responsável por definir o login do usuário
     * @param Request $request
     */
    public static function setLogin($request){
        //post vars
        $postVars = $request->getPostVars();
        $email = $postVars['email'] ?? '';
        $senha = $postVars['password'] ?? '';

        //BUSCA O USUARIO PELO EMAIL
        $obUser = User::getUserByEmail($email);
        if(!$obUser instanceof User){
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }

        if(!password_verify($senha, $obUser->senha)){
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }

        //Cria a sessão de login
        SessionAdminLogin::login($obUser);
        
        //redireciona o usuario para a rota admin
        $request->getRouter()->redirect('/admin');
    }

    /**
     * Método responsável por deslogar o usuário
     * @param Request $request
     */
    public static function setLogout($request){
        SessionAdminLogin::logout();

        //redireciona para a tela de login
        $request->getRouter()->redirect('/admin/login');

    }
}
