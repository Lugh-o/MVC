<?php 

namespace app\Controller\Pages;
use \app\Utils\View;
use \app\Model\Entity\Organization;

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