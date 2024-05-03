<?php

namespace app\Controller\Api;

use app\Http\Request;
use WilliamCosta\DatabaseManager\Pagination;

class Api {

    /**
     * Metodo responsavel por retornar os detalhes da API
     * @param Request $request
     * @return array
     */
    public static function getDetails($request){
        return [
            'nome' => 'API - WDEV',
            'versao' => 'v1.0.0',
            'autor' => 'Lucas Falcao',
            'email' => 'lughfalcao@gmail.com'
        ];
    }

    /**
     * Metodo responsavel por retornar os detalhes da paginacao
     * @param Request $request
     * @param Pagination $obPagination
     * @return array
     */
    protected static function getPagination($request, $obPagination){
        $queryParams = $request->getQueryParams();
        
        $pages = $obPagination->getPages();
        
        return [
            'paginaAtual' => isset($queryParams['page']) ? (int)$queryParams['page'] :1,
            'quantidadePaginas' => !empty($pages) ? count($pages) : 1
        ];
    }
}