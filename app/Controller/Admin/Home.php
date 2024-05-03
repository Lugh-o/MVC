<?php 

namespace app\Controller\Admin;

use \app\Http\Request;
use app\Utils\View;

class Home extends Page {

    /**
     * Metodo responsavel por renderizar a view de home do painel
     * @param Request $request
     * @return string
     */
    public static function getHome($request){
        $content = View::render('admin/modules/home/index', []);

        return parent::getPanel('Home -> WDEV', $content, 'home');   
    }
}
