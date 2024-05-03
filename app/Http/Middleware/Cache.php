<?php 

namespace App\Http\Middleware;

use app\Utils\Cache\File as CacheFile;
use app\Http\Request;
use app\Http\Response;

class Cache {

    /**
     * Método responsavel por verificar se a request atual podde ser cacheada
     * @param Request $request
     * @return boolean
     */
    private function isCachable($request){
        //valida o tempo de cache
        if(getenv("CACHE_TIME") <= 0) return false;

        //valida o metodo de requisiçao
        if($request->getHttpMethod() != "GET") return false;

        //valida o header de cache
        $headers = $request->getHeaders();
        if(isset($headers["Cache-Control"]) && $headers["Cache-Control"] == 'no-cache') return false;

        return true;
    }

    /**
     * Método responsável por retornar a hash do cache
     * @param Request $request
     * @return string
     */
    private function getHash($request){
        //uri da rota
        $uri = $request->getRouter()->getUri();
        
        $queryParams = $request->getQueryParams();
        $uri .= !empty($queryParams) ? '?'.http_build_query($queryParams) : '';
        
        //remove as barras e retorna a hash
        return rtrim('route-'.preg_replace('/[^0-9a-zA-Z]/', '-', ltrim($uri, '/')), '-');
    }

    /**
     * Metodo responsavel por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response 
     */
    public function handle($request, $next) {
        //Verifica se a request atual é cacheavel
        if(!$this->isCachable($request)) return $next($request);
        
        $hash = $this->getHash($request);

        //Retorna os daddos do cache
        return CacheFile::getCache($hash, getenv("CACHE_TIME"), function() use($request, $next){
            return $next($request);
        });
    }

}