<?php 
namespace App\Model\Entity;

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

        $this->id = (new Database('depoimentos'))->insert([
            'nome'=> $this->nome,
            'mensagem'=>$this->mensagem,
            'data'=> $this->data
        ]);
        
        return true;
    }

    /**
     * Método responsável por atualizar os dados do banco a instancia atual na db
     * @return boolean
     */
    public function atualizar(){

        return (new Database('depoimentos'))->update('id = '.$this->id, [
            'nome'=> $this->nome,
            'mensagem'=>$this->mensagem,
        ]);
    }

    /**
     * Método responsável por excluir um elemento da db
     * @return boolean
     */
    public function excluir(){
        return (new Database('depoimentos'))->delete('id = '.$this->id);
    }

    /**
     * Metodo responsavel por retornar um depoimento com base no seu ID
     * @param integer $id
     * @return Testimony
     */
    public static function getTestimonyById($id){ 
        return self::getTestimonies('id = '.$id)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar Depoimentos
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $field
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*'){
        return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
    }
}