<?php 

namespace app\Controller\Admin;

use \app\Http\Request;
use \app\Utils\View;
use \app\Model\Entity\User as EntityUser;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Page {

    /**
     * Metodo responsável por obter a renderização dos itens de usuarios para a página
     * @param Request
     * @param Pagination
     * @return string
     */
    private static function getUserItems($request, &$obPagination){
        $items = '';

        //Quantidade total de registros
        $quantidadeTotal = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
        
        //Pagina atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        //instancia de paginacao
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 8);

        $results = EntityUser::getUsers(null, 'id DESC', $obPagination->getLimit());
       
        while($obUser = $results->fetchObject(EntityUser::class)){
            $items .= View::render('admin/modules/users/item',[
                'id'=> $obUser->id,
                'nome' => $obUser->nome,
                'email' => $obUser->email
            ]);
        }
        return $items;
    }

    /**
     * Metodo responsavel por renderizar a view de listagem de usuarios
     * @param Request $request
     * @return string
     */
    public static function getUsers($request){
        $content = View::render('admin/modules/users/index', [
            'itens' => self::getUserItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        return parent::getPanel('Usuarios -> WDEV', $content, 'users');   
    }

    /**
     * Metodo responsavel por retornar o formulario de cadastro de um novo usuario
     * @param Request $request
     * @return string
     */
    public static function getNewUser($request){
        $content = View::render('admin/modules/users/form', [
           'title' => 'Cadastrar usuário',
           'nome' => '',
           'email' => '',
           'status' => self::getStatus($request)
        ]);

        return parent::getPanel('Cadastrar usuario -> WDEV', $content, 'users');   
    }

    /**
     * Metodo responsavel por cadastrar um usuario no banco
     * @param Request $request
     */
    public static function setNewUser($request){
        $postVars = $request->getPostVars();
       
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['senha'] ?? '';

        $obUser = EntityUser::getUserByEmail($email);
        if($obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/users/new?status=duplicated');
        }

        $obUser = new EntityUser;
        $obUser->nome = $nome;
        $obUser->email = $email;
        $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
        $obUser->cadastrar();
        
        //redireciona o usuario
        $request->getRouter()->redirect('/admin/users/'.$obUser->id.'/edit?status=created');
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
                return Alert::getSuccess('Usuário criado com sucesso');
            case 'updated':
                return Alert::getSuccess('Usuário atualizado com sucesso');
            case 'deleted':
                return Alert::getSuccess('Usuário excluído com sucesso');              
            case 'duplicated':
                return Alert::getError('O e-mail digitado já está sendo utilizado por outro usuário');
            default:
                return '';
        }
    }

    /**
     * Metodo responsavel por retornar o formulario de edicao de um usuario
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getEditUser($request, $id){

        //obtem o usuario da database
        $obUser = EntityUser::getUserById($id);
        
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/users');
        }

        $content = View::render('admin/modules/users/form', [
           'title' => 'Editar Usuário',
           'nome' => $obUser->nome,
           'email' => $obUser->email,
           'status' => self::getStatus($request)
        ]);

        return parent::getPanel('Editar Usuário -> WDEV', $content, 'users');   
    }

    /**
     * Metodo responsavel por gravar a atualizacao de um usuario
     * @param Request $request
     * @param integer $id
     */
    public static function setEditUser($request, $id){

        //obtem o usuario da database
        $obUser = EntityUser::getUserById($id);
        
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/users');
        }

        $postVars = $request->getPostVars();

        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $senha = $postVars['password'] ?? '';

        $obUserEmail = EntityUser::getUserByEmail($email);
        if($obUserEmail instanceof EntityUser && $obUserEmail->id != $id){
            $request->getRouter()->redirect('/admin/users/'.$id.'/edit?status=duplicated');
        }

        $obUser ->nome = $nome;
        $obUser ->email = $email;
        $obUser ->senha = password_hash($senha, PASSWORD_DEFAULT);
        $obUser->atualizar();

        //redireciona o usuario
       $request->getRouter()->redirect('/admin/users/'.$obUser->id.'/edit?status=updated');  
    }

    /**
     * Metodo responsavel por retornar o formulario de exclusao de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public static function getDeleteUser($request, $id){
        //obtem o usuario da database
        $obUser = EntityUser::getUserById($id);
                
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/users');
        }

        $content = View::render('admin/modules/users/delete', [
           'nome' => $obUser->nome,
           'email' => $obUser->email,
        ]);

        return parent::getPanel('Excluir usuário -> WDEV', $content, 'users');   
    }

    /**
     * Metodo responsavel por excluir um usuário
     * @param Request $request
     * @param integer $id
     */
    public static function setDeleteUser($request, $id){
        //obtem o usuario da database
        $obUser = EntityUser::getUserById($id);
                        
        if(!$obUser instanceof EntityUser){
            $request->getRouter()->redirect('/admin/users');
        }

        $obUser->excluir();

        //redireciona o usuario
       $request->getRouter()->redirect('/admin/users?status=deleted');  
    }
}