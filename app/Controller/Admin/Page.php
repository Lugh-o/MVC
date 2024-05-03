<?php 

namespace app\Controller\Admin;

use \app\Utils\View;
use \app\Http\Request;
use \WilliamCosta\DatabaseManager\Pagination;

class Page{

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
            
            $links .= View::render('admin/pagination/link',[
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        return View::render('admin/pagination/box',[
            'links' => $links
        ]);

    }

    /**
     * Modulos disponivel no painel
     * @var array
     */
    private static $modules = [
        'home' => [
            'label' => 'Home',
            'link' => URL.'/admin',
        ],
        'testimonies' => [
            'label' => 'Depoimentos',
            'link' => URL.'/admin/testimonies',
        ],
        'users' => [
            'label' => 'Usuários',
            'link' => URL.'/admin/users',
        ]
    ];

    /**
     * Metodo responsavel por retornar o conteudo (view) da estrutura generica da pagina do painel
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content){
        return View::render('admin/page',[
            'title' => $title,
            'content'=> $content
        ]);
    }

    /**
     * Metodo responsavel por renderizar a view do menu do painel
     * @param string $currentModule
     * @return string
     */
    private static function getMenu($currentModule){
        //links do menu
        $links = '';

        //itera os modulos
        foreach(self::$modules as $hash=>$module){
            $links .= View::render('admin/menu/link',[
                'label' => $module['label'],
                'link'=> $module['link'],
                'current' => $hash == $currentModule ? 'text-danger' : ''
            ]);
        }

        return View::render('admin/menu/box',[
            'links' => $links
        ]); 
    }

    /**
     * Metodo responsavel por renderizar a view do painel com conteudos dinamicos
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */
    public static function getPanel($title, $content, $currentModule){

        //renderiza a view do painel
        $contentPanel = View::render('admin/panel', [
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);

        //retorna a pagina renderizada
        return self::getPage($title, $contentPanel);
    }
}