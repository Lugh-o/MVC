<?php 

namespace app\controller\pages;
use \app\utils\View;
use \app\model\entity\Organization;

class About extends Page{
    
    public static function getAbout(){
        $obOrganization = new Organization;

        $content = View::render('pages/about',[
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site' => $obOrganization->site
        ]);
        return parent::getPage('SOBRE - WDEV', $content);
    }
}

?>