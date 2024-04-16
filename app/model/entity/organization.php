<?php 
namespace app\model\entity;
//exemplo de retorno do banco de dados
class Organization {
    /**
     * ID da organização
     * @var integer
     */
    public $id = 1;
    /**
     * Nome da organização
     * 
     * @var string
     */
    public $name = 'Canal WDEV';
    /**
     * Site da organização
     * @var string
     */
    public $site = 'https://youtube.com/wdevoficial';
    /**
     * Descrição da organização
     * @var string
     */
    public $description = 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Assumenda totam distinctio vel, beatae temporibus iure aliquid velit! Temporibus, corrupti maxime quaerat sint illo eveniet, exercitationem ipsum vitae, commodi cum recusandae?';
}


?>