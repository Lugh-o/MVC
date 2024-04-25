<?php 

namespace app\Http\Middleware;

use app\Http\Response;
use app\Http\Request;

class Queue {

    /**
     * Mapeamento de middlewares
     * @var array
     */
    private static $map = [];

    /**
     * Mapeamento de middlewares que serão carregados em todas as rotas
     * @var array
     */
    private static $default = [];	


    /**
     * Fila de middlewares a serem executados
     * @var array
     */
    private $middlewares = [];

    /**
     * Funcao de execucao do controlador
     * @var Closure
     */
    private $controller;

    /**
     * Argumentos da funcao do controlador
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Metodo responsavel por construir a classe de fila
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares, $controller, $controllerArgs) {
        $this->middlewares = array_merge(self::$default, $middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs; 
    }

    /**
     * Metodo responsavel por definir o mapeamento de middlewares
     * @param array $map
     */
    public static function setMap($map) {
        self::$map = $map;
    }

        /**
     * Metodo responsavel por definir o mapeamento de middlewares
     * @param array $default
     */
    public static function setDefault($default) {
        self::$default = $default;
    }


    /**
     * Metodo responsavel por executar o proximo nivel da fila de middlewares
     * @param Request $request
     * @return Response
     */
    public function next($request){
        //VERIFICA SE A FILA ESTA VAZIA
        if(empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);
        
        //MIDDLEWARE
        $middleware = array_shift($this->middlewares);
        
        //VERIFICA O MAPEAMENTO
        if(!isset(self::$map[$middleware])) {
            throw new \Exception("Problemas ao processar o middleware da requisição", 500);
        }

        //NEXT
        $queue = $this;
        $next = function($request) use($queue){
            return $queue->next($request);
        };

        //executa o middleware
        return (new self::$map[$middleware])->handle($request, $next);


    }

}