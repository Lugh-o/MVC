<?php 
namespace app\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use \app\Http\Middleware\Queue as MiddlewareQueue;

class Router {
    /**
     * URL Completa do projeto (raiz)
     * @var string
     */
    private $url = '';
    /**
     * Prefixo de todas as rotas
     * @var string
     */
    private $prefix = '';

    /**
     * Índice das rotas
     * @var array
     */
    private $routes = [];

    /**
     * Instância de Request
     * @var Request
     */
    private $request;

    /**
     * Content Type padrao do response
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Método responsável por iniciar a classe
     * @param string $url
     */
    public function __construct($url) {
        $this->request = new Request($this);
        $this->url     = $url;
        $this->setPrefix();
    }

    /**
     * Metodo responsavel por alterar o valor do contentType
     * @param string $contentType
     */
    public function setContentType($contentType) {
        $this->contentType = $contentType;
    }

    /**
     * Método responsável por definir o prefixo das rotas
     */
    private function setPrefix(){
        $parseURL = parse_url($this->url);
        $this->prefix = $parseURL['path'] ?? '';
    }

    /**
     * Método responsável por adicionar uma rota na classe
     * @param string $method
     * @param string $route
     * @param array $params     
     */
    private function addRoute($method, $route, $params = []){
        //validação dos parametros
        foreach($params as $key=>$value){
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //Middlewares da rota
        $params['middlewares'] = $params['middlewares'] ?? [];

        //variaveis da rota
        $params['variables'] = [];
        
        $patternVariable = '/{(.*?)}/';

        if(preg_match_all($patternVariable, $route, $matches)){
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';

        //adiciona a rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Método responsável por definir uma rota de GET
     * @param string $route
     * @param array $params
     */
    public function get($route, $params = []){
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de POST
     * @param string $route
     * @param array $params
     */
    public function post($route, $params = []){
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de PUT
     * @param string $route
     * @param array $params
     */
    public function put($route, $params = []){
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de DELETE
     * @param string $route
     * @param array $params
     */
    public function delete($route, $params = []){
        return $this->addRoute('DELETE', $route, $params);
    }

    /**
     * Método responsável por retornar a URI desconsiderando o prefixo
     * @return string
     */
    public function getUri(){
        $uri = $this->request->getUri();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        return rtrim(end($xUri), '/') == '' ? end($xUri) : rtrim(end($xUri), '/'); 
    }

    /**
     * Método responsável por retornar os dados da rota atual
     * @return array
     */
    private function getRoute(){
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();
        foreach($this->routes as $patternRoute=>$methods){
            //se a uri bate com o padrao
            if(preg_match($patternRoute, $uri, $matches)){
                //verifica o metodo
                if(isset($methods[$httpMethod])){
                    unset($matches[0]);

                    //variaveis processadas
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    return $methods[$httpMethod]; //parametros da rota
                }
                throw new Exception("Método não permitido", 405);
            }
        }
        throw new Exception("URL não encontrada", 404);
    }

    /**
     * Método responsável por executar a rota atual
     * @return Response 
     */
    public function run(){
        try{
            $route = $this->getRoute();

            //verifica o controlador
            if(!isset($route['controller'])){
                throw new Exception("A URL não pôde ser processada", 500);
            }
            $args = [];

            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            //RETORNA A EXECUCAO DA FILA DE MIDDLEWARES
            return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request); 

        } catch(Exception $e){
            return new Response($e-> getCode(), $this->getErrorMessage($e->getMessage()), $this->contentType);
        }
    }

    /**
     * Metodo responsavel por retornar a mensagem de erro de acordo com o contentType
     * @param string $message
     * @return mixed
     */
    private function getErrorMessage($message){
        switch($this->contentType){
            case 'application/json':
                return [
                    'error' => $message
                ];
            default:
                return $message;
        }
    }

    /**
     * Método responsável por retornar a URL atual
     * @return string
     */
    public function getCurrentUrl(){
        return $this->url.$this->getUri();
    }

    /**
     * Método responsável por redirecionar a URL
     * @param string $route
     */
    public function redirect($route){
        $url = $this->url.$route;
        
        //executa o redirect
        header('location: ' .$url);
        exit;
    }
}