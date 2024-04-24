<?php 

namespace app\Controller\Admin;

use \app\Http\Request;
use App\Utils\View;

class Login extends Page {
    /**
     * Metodo responsavel por retornar a renderizacao da pagina de login
     * @param Request $request
     * @return string
     */
    public static function getLogin($request){
        $content = View::render('admin/login', []);

        return parent::getPage('Login - WDEV', $content);
    }

}
