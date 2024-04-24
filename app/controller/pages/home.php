<?php 

namespace app\Controller\Pages;
use \app\Utils\View;
use \app\Model\Entity\Organization;

class Home extends Page{
    
    public static function getHome(){
        $obOrganization = new Organization;

        $content = View::render('pages/home',[
            'name' => $obOrganization->name
        ]);
        return parent::getPage('Home', $content);
    }
}