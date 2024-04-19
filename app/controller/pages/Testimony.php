<?php 

namespace app\controller\pages;
use \app\utils\View;
use \app\Http\Request;
use \app\model\entity\Testimony as EntityTestimony;

class Testimony extends Page{
    
    /**
     * Metodo responsável por obter a renderização dos itens de depoimentos para a página
     * @return string
     */
    private static function getTestimonyItems(){
        $items = '';

        $results = EntityTestimony::getTestimonies(null, 'id DESC');
       
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
            $items .= View::render('pages/testimony/item',[
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data))
            ]);
        }
        return $items;
    }

    public static function getTestimonies(){
        $content = View::render('pages/testimonies',[
            'items' => self::getTestimonyItems()
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