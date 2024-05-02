<?php

namespace app\Controller\Api;

use \app\Model\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Api {

    /**
     * Metodo responsavel por retornar os usuarios cadastrados
     * @param Request $request
     * @return array
     */
    public static function getUsers($request){
        return [
            'usuarios' => self::getUserItems($request, $obPagination),
            'paginacao' => parent::getPagination($request, $obPagination)    
        ];
    }

    /**
     * Metodo responsável por obter a renderização dos itens de usuarios para a api
     * @param Request
     * @param Pagination
     * @return array
     */
    private static function getUserItems($request, &$obPagination){
        $items = [];

        //Quantidade total de registros
        $quantidadeTotal = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        //Pagina atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instancia de paginacao
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);

        $results = EntityUser::getUsers(null, 'id ASC', $obPagination->getLimit());
       
        while($obUser = $results->fetchObject(EntityUser::class)){
            $items[] = [
                'id' => (int)$obUser->id,
                'nome' => $obUser->nome,
                'email' => $obUser->email
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
    public static function getUser($request, $id){
        if(!is_numeric($id)){
            throw new \Exception("O id ".$id." nao e valido", 400);
        }

        $obUser = EntityUser::getUserById($id);
        if(!$obUser instanceof EntityUser){
            throw new \Exception("O usuario ".$id." nao foi encontrado", 404);
        }

            return [
                'id' => (int)$obUser->id,
                'nome' => $obUser->nome,
                'email' => $obUser->email
            ];
    }

    /**
     * Metodo responsavel por cadastrar um novo usuario
     * @param Request $request
     */
    public static function setNewUser($request){
        $postVars = $request->getPostVars();
        
        //valida os campos obrigatorios
        if(!isset($postVars['nome']) or !isset($postVars['email']) or !isset($postVars['senha'])){
            throw new \Exception("Os campos 'nome', 'email' e 'senha' sao obrigatorios", 400);
        }

        //valida a duplicacao de usuarios
        $obUserEmail = EntityUser::getUserByEmail($postVars["email"]);
        if($obUserEmail instanceof EntityUser){
            throw new \Exception("O email '".$postVars['email']."' ja esta em uso", 400);
        }

        //novo depoimento
        $obUser = new EntityUser;
        $obUser->nome = $postVars["nome"];
        $obUser->email = $postVars["email"];
        $obUser->senha = password_hash($postVars["senha"], PASSWORD_DEFAULT);
        $obUser->cadastrar();

        return [
            'id' => (int)$obUser->id,
            'nome' => $obUser->nome,
            'mensagem' => $obUser->email
        ];
    }

    /**
     * Metodo responsavel por atualizar um usuario
     * @param Request $request
     */
    public static function setEditUser($request, $id){
        $postVars = $request->getPostVars();

         //valida os campos obrigatorios
         if(!isset($postVars['nome']) or !isset($postVars['email']) or !isset($postVars['senha'])){
            throw new \Exception("Os campos 'nome', 'email' e 'senha' sao obrigatorios", 400);
        }

        $obUser = EntityUser::getUserById($id);
        if(!$obUser instanceof EntityUser){
            throw new \Exception("O usuario ".$id." nao foi encontrado", 404);
        }

        //valida a duplicacao de usuarios
        $obUserEmail = EntityUser::getUserByEmail($postVars["email"]);
        if($obUserEmail instanceof EntityUser && $obUserEmail->id != $obUser->id){
            throw new \Exception("O email '".$postVars['email']."' ja esta em uso", 400);
        }

        //atualiza o usuario
        $obUser->nome = $postVars["nome"];
        $obUser->email = $postVars["email"];
        $obUser->senha = password_hash($postVars["senha"], PASSWORD_DEFAULT);
        $obUser->atualizar();

        return [
            'id' => (int)$obUser->id,
            'nome' => $obUser->nome,
            'mensagem' => $obUser->email
        ];
    }

    /**
     * Metodo responsavel por atualizar um novo depoimento
     * @param Request $request
     */
    public static function setDeleteUser($request, $id){
        $obUser = EntityUser::getUserById($id);
        if(!$obUser instanceof EntityUser){
            throw new \Exception("O usuario ".$id." nao foi encontrado", 404);
        }

        //previne a exclusao do proprio cadastro
        if($obUser->id == $request->user->id){
            throw new \Exception("Nao e possivel excluir o cadastro atualmente conectado", 404);
        }

        $obUser->excluir();

        return [
            'sucesso' => true
        ];
    }

}