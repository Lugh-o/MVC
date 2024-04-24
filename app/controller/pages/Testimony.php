<?php 

namespace app\Controller\Pages;
use \app\Utils\View;
use \app\Http\Request;

use \app\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page{
    
    /**
     * Metodo responsável por obter a renderização dos itens de depoimentos para a página
     * @param Request
     * @param Pagination
     * @return string
     */
    private static function getTestimonyItems($request, &$obPagination){
        $items = '';

        //Quantidade total de registros
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //Pagina atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instancia de paginacao
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());
       
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
            $items .= View::render('pages/testimony/item',[
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data))
            ]);
        }
        return $items;
    }

    /**
     * Método responsável por retornar o conteúdo de depoimentos
     * @param Request 
     * @return string
     */
    public static function getTestimonies($request){
        $content = View::render('pages/testimonies',[
            'items' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
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
        return self::getTestimonies($request);
    }

}