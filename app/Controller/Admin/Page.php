<?php 

namespace app\Controller\Admin;

use \app\Utils\View;

class Page{
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
}