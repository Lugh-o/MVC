<?php 

namespace App\Http\Middleware;

use app\Http\Request;
use app\Http\Response;

class Api {

    /**
     * Metodo responsavel por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response 
     */
    public function handle($request, $next) {
        $request->getRouter()->setContentType('application/json');

        return $next($request);
    }
}