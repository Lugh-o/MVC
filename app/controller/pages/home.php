<?php 

namespace app\controller\pages;
use \app\utils\View;
use \app\model\entity\Organization;

class Home extends Page{
    
    public static function getHome(){
        $obOrganization = new Organization;

        $content = View::render('pages/home',[
            'name' => $obOrganization->name
        ]);
        return parent::getPage('Home', $content);
    }
}

?>