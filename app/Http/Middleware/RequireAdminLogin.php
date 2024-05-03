<?php 

namespace app\Http\Middleware;

use app\Http\Request;
use app\Http\Response;
use app\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogin {

    /**
     * Metodo responsavel por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response 
     */
    public function handle($request, $next) {
        //verifica se o usuario está logado
        if(!SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin/login');
        }
        //continua a execução
        return $next($request);
    }
}