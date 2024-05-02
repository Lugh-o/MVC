<?php

namespace app\Controller\Api;

use \app\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Api {

    /**
     * Metodo responsavel por retornar os depoimentos cadastrados
     * @param Request $request
     * @return array
     */
    public static function getTestimonies($request){
        return [
            'depoimentos' => self::getTestimonyItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)    
        ];
    }

    /**
     * Metodo responsável por obter a renderização dos itens de depoimentos para a página
     * @param Request
     * @param Pagination
     * @return array
     */
    private static function getTestimonyItems($request, &$obPagination){
        $items = [];

        //Quantidade total de registros
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //Pagina atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instancia de paginacao
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());
       
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
            $items[] = [
                'id' => (int)$obTestimony->id,
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => $obTestimony->data
            ];
        }
        return $items;
    }

    /**
     * Metodo responsavel por retornar os detalhes de um depoimento
     * @param Request $request
     * @param integer $id
     * @return array
     */
    public static function getTestimony($request, $id){
        if(!is_numeric($id)){
            throw new \Exception("O id ".$id." nao e valido", 400);
        }


        $obTestimony = EntityTestimony::getTestimonyById($id);
        if(!$obTestimony instanceof EntityTestimony){
            throw new \Exception("O depoimento ".$id." nao foi encontrado", 404);
        }

            return [
                'id' => (int)$obTestimony->id,
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => $obTestimony->data
            ];
    }

    /**
     * Metodo responsavel por cadastrar um novo depoimento
     * @param Request $request
     */
    public static function setNewTestimony($request){
        $postVars = $request->getPostVars();
        
        //valida os campos obrigatorios
        if(!isset($postVars['nome']) or !isset($postVars['mensagem'])){
            throw new \Exception("Os campos 'nome' e 'mensagem' sao obrigatorios", 400);
        }

        //novo depoimento
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars["nome"];
        $obTestimony->mensagem = $postVars["mensagem"];
        $obTestimony->cadastrar();

        return [
            'id' => (int)$obTestimony->id,
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'data' => $obTestimony->data
        ];
    }

    /**
     * Metodo responsavel por atualizar um novo depoimento
     * @param Request $request
     */
    public static function setEditTestimony($request, $id){
        $postVars = $request->getPostVars();
        
        //valida os campos obrigatorios
        if(!isset($postVars['nome']) or !isset($postVars['mensagem'])){
            throw new \Exception("Os campos 'nome' e 'mensagem' sao obrigatorios", 400);
        }
    
        //busca o depoimento no banco
        $obTestimony = EntityTestimony::getTestimonyById($id);
        if(!$obTestimony instanceof EntityTestimony){
            throw new \Exception("O depoimento ".$id." nao foi encontrado", 404);
        }

        //novo depoimento
        $obTestimony->nome = $postVars["nome"];
        $obTestimony->mensagem = $postVars["mensagem"];
        $obTestimony->atualizar();

        return [
            'id' => (int)$obTestimony->id,
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'data' => $obTestimony->data
        ];
    }

    /**
     * Metodo responsavel por atualizar um novo depoimento
     * @param Request $request
     */
    public static function setDeleteTestimony($request, $id){
        //busca o depoimento no banco
        $obTestimony = EntityTestimony::getTestimonyById($id);
        if(!$obTestimony instanceof EntityTestimony){
            throw new \Exception("O depoimento ".$id." nao foi encontrado", 404);
        }

        $obTestimony->excluir();

        return [
            'sucesso' => true
        ];
    }

}