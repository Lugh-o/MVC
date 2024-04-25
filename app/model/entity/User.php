<?php 
namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class User {
    /**
     * ID do usuário
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário
     * @var string
     */
    public $nome;

    /**
     * E-mail do usuário
     * @var string
     */
    public $email;

    /**
     * Senha do usuário
     * @var string
     */
    public $senha;

    /**
     * Método responsável por retornar um usuário com base em seu email
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email) {
        return (new Database('usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
    
    }


}