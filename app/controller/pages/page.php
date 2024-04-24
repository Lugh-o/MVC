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
        
        foreach($pages as $page){
            //altera a pagina
            $queryParams['page'] = $page['page'];

            $link = $url.'?'.http_build_query($queryParams);
            
            $links .= View::render('pages/pagination/link',[
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        return View::render('pages/pagination/box',[
            'links' => $links
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