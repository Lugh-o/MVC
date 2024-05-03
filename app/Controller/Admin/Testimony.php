<?php 

namespace app\Controller\Admin;

use \app\Http\Request;
use \app\Utils\View;
use \app\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page {

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
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 8);

        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());
       
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
            $items .= View::render('admin/modules/testimonies/item',[
                'id'=> $obTestimony->id,
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data))
            ]);
        }
        return $items;
    }

    /**
     * Metodo responsavel por renderizar a view de listagem de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request){
        $content = View::render('admin/modules/testimonies/index', [
            'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        return parent::getPanel('Depoimentos -> WDEV', $content, 'testimonies');   
    }

    /**
     * Metodo responsavel por retornar o formulario de cadastro de um novo depoimento
     * @param Request $request
     * @return string
     */
    public static function getNewTestimony($request){
        $content = View::render('admin/modules/testimonies/form', [
           'title' => 'Cadastrar depoimento',
           'nome' => '',
           'mensagem' => '',
           'status' => ''
        ]);

        return parent::getPanel('Cadastrar depoimento -> WDEV', $content, 'testimonies');   
    }

    /**
     * Metodo responsavel por cadastrar um depoimento do banco
     * @param Request $request
     */
    public static function setNewTestimony($request){
       $postVars = $request->getPostVars();
       
       $obTestimony = new EntityTestimony;
       $obTestimony->nome = $postVars['nome'] ?? '';
       $obTestimony->mensagem = $postVars['mensagem'] ?? '';
       $obTestimony->cadastrar();
       
       //redireciona o usuario
       $request->getRouter()->redirect('/admin/testimonies/'.$obTestimony->id.'/edit?status=created');
    }

    /**
     * Metodo responsavel por retornar a mensagem de status
     * @param Request $request
     * @return string
     */
    private static function getStatus($request){
        $queryParams = $request->getQueryParams();
        
        if(!isset($queryParams['status'])) return '';

        switch($queryParams['status']){
            case 'created':
                return Alert::getSuccess('Depoimento criado com sucesso');
            case 'updated':
                return Alert::getSuccess('Depoimento atualizado com sucesso');
            case 'deleted':
                return Alert::getSuccess('Depoimento excluído com sucesso');   
            default:
                return '';           
        }
    }

    /**
     * Metodo responsavel por retornar o formulario de edicao de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditTestimony($request, $id){

        //obtem o depoimento da database
        $obTestimony = EntityTestimony::getTestimonyById($id);
        
        if(!$obTestimony instanceof EntityTestimony){
            $request->getRouter()->redirect('/admin/testimonies');
        }

        $content = View::render('admin/modules/testimonies/form', [
           'title' => 'Editar depoimento',
           'nome' => $obTestimony->nome,
           'mensagem' => $obTestimony->mensagem,
           'status' => self::getStatus($request)
        ]);

        return parent::getPanel('Editar depoimento -> WDEV', $content, 'testimonies');   
    }

    /**
     * Metodo responsavel por gravar a atualizacao de um depoimento
     * @param Request $request
     * @param integer $id
     */
    public static function setEditTestimony($request, $id){

        //obtem o depoimento da database
        $obTestimony = EntityTestimony::getTestimonyById($id);
        
        if(!$obTestimony instanceof EntityTestimony){
            $request->getRouter()->redirect('/admin/testimonies');
        }

        $postVars = $request->getPostVars();

        $obTestimony ->nome = $postVars['nome'] ?? $obTestimony ->nome;
        $obTestimony ->mensagem = $postVars['mensagem'] ?? $obTestimony ->mensagem;

        $obTestimony->atualizar();

        //redireciona o usuario
       $request->getRouter()->redirect('/admin/testimonies/'.$obTestimony->id.'/edit?status=updated');  
    }

    /**
     * Metodo responsavel por retornar o formulario de exclusao de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteTestimony($request, $id){

        //obtem o depoimento da database
        $obTestimony = EntityTestimony::getTestimonyById($id);
        
        if(!$obTestimony instanceof EntityTestimony){
            $request->getRouter()->redirect('/admin/testimonies');
        }

        $content = View::render('admin/modules/testimonies/delete', [
           'nome' => $obTestimony->nome,
           'mensagem' => $obTestimony->mensagem,
        ]);

        return parent::getPanel('Excluir depoimento -> WDEV', $content, 'testimonies');   
    }

    /**
     * Metodo responsavel por excluir um depoimento
     * @param Request $request
     * @param integer $id
     */
    public static function setDeleteTestimony($request, $id){

        //obtem o depoimento da database
        $obTestimony = EntityTestimony::getTestimonyById($id);
        
        if(!$obTestimony instanceof EntityTestimony){
            $request->getRouter()->redirect('/admin/testimonies');
        }

        $obTestimony->excluir();

        //redireciona o usuario
       $request->getRouter()->redirect('/admin/testimonies?status=deleted');  
    }
}