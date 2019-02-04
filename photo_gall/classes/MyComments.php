<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/connection/qb_database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
//include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_script.php'); 


class MyComments {

    // constructor
    function MyComments() {
    }

    // return comments block
    function getComments($msg_id) {

        /*
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/posts.php');
    $postWidgetObjHome=new postWidget();
    return $postWidgetObjHome->getPostCommentsById($msg_id);
    */
     
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/post_extra.php');    
     $QbSecurity=new QB_SqlInjection();
    $postWidgetObjHome=new post_extra();
    return '<div style="width: 80%; padding: 5px 10px;" class="pull-left rp'.$QbSecurity->QB_AlphaID($msg_id).'">'.$postWidgetObjHome->extra_widget("", $msg_id, $QbSecurity->QB_AlphaID($msg_id), 1).'</div>';
    
    
    
    
        
        
       

    }

    
}
