<?php 
namespace app\model\entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony {

    /**
     * ID do depoimento
     * @var integer
     */
    public $id;
    
    /**
     * Nome do usuario que fez o depoimento
     * @var string
     */
    public $nome;
        
    /**
     * Mensagem do depoimento
     * @var string
     */
    public $mensagem;
        
    /**
     * Data de publicação do depoimento
     * @var string
     */
    public $data;

    /**
     * Método responsável por cadastrar a instancia atual na db
     * @return boolean
     */
    public function cadastrar(){
        $this->data = date("Y-m-d H:i:s");
        
        //insere no banco de dados
        $this->id = (new Database('depoimentos'))->insert([
            'nome'=> $this->nome,
            'mensagem'=> $this->mensagem,
            'data'=> $this->data
        ]);

        echo '<pre>';
        print_r($this);
        echo '</pre>';
        exit;
    }

    


}