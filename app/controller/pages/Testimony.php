<?php 

namespace app\controller\pages;
use \app\utils\View;
use \app\Http\Request;
use \app\model\entity\Testimony as EntityTestimony;

class Testimony extends Page{
    
    public static function getTestimonies(){
        $content = View::render('pages/testimonies',[

        ]);
        return parent::getPage('Depoimentos -> WDEV', $content);
    }

    /**
     * Método responsável por cadastrar um depoimento
     * @param Request $request
     * @return string
     */
    public static function insertTestimony($request){
        $postVars = $request->getPostVars();
        
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();
        return self::getTestimonies();
    }

}