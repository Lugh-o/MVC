<?php 

namespace app\Controller\Pages;
use \app\Utils\View;
use \app\Http\Request;
use \WilliamCosta\DatabaseManager\Pagination;

class Page{
    /**
     * Método responsável por renderizar o cabeçalho da página
     * @return string
     */
    private static function getHeader(){
        return View::render('pages/header');
    }

    /**
     * Método responsável por renderizar o layout de paginação
     * @param Request
     * @param Pagination
     * @return string
     */
    public static function getPagination($request, $obPagination){
        $pages = $obPagination->getPages();
        
        if(count($pages) <= 1) return '';

        $links = '';

        //URL atual sem gets
        $url = $request->getRouter()->getCurrentUrl();
        
        //GET
        $queryParams = $request->getQueryParams();
        
        $currentPage = $queryParams['page'] ?? 1;
        
        $limit = getenv('PAGINATION_LIMIT');

        //inicio da paginação
        $middle = ceil($limit/2);
        $start = $middle > $currentPage ? 0 : $currentPage - $middle;

        //ajusta o final da paginação
        $limit += $start;

        //ajusta o inicio
        if($limit > count($pages)){
            $diff = $limit - count($pages);
            $start -= $diff;
        }

        if($start > 0){
            $links .= self::getPaginationLink($queryParams, $url, reset($pages), '<<');

        }


        foreach($pages as $page){
            //verifica o start da paginação
            if($page['page'] <= $start) continue;

            if($page['page'] > $limit) {
                $links .= self::getPaginationLink($queryParams, $url, end($pages), '>>');
                break;
            }

            $links .= self::getPaginationLink($queryParams, $url, $page);
        }

        return View::render('pages/pagination/box',[
            'links' => $links
        ]);
    }

    /**
     * Método responsável por retornar um link da paginação
     * @param array $queryParams
     * @param array $page
     * @param string $url
     * @return string
     */
    private static function getPaginationLink($queryParams, $url, $page, $label = null){

        $queryParams['page'] = $page['page'];

        $link = $url.'?'.http_build_query($queryParams);
        
        return View::render('pages/pagination/link',[
            'page' => $label ?? $page['page'],
            'link' => $link,
            'active' => $page['current'] ? 'active' : ''
        ]);
    }

    /**
     * Método responsável por renderizar o rodapé da página
     * @return string
     */
    private static function getFooter(){
        return View::render('pages/footer');
    }

    /**
     * Método responsável por retornar o conteúdo {view} da nossa página genérica
     * @return string
     */
    public static function getPage($title, $content){
        return View::render('pages/page',[
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ]);
    }
}