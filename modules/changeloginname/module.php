<?php


$Module = array('name'=>'ChangeLoginName');

$ViewList = array();
$ViewList['update']= array( 'script'=>'update.php',
                            'params'=>array('NodeID'),
                            'single_post_actions'=> array('ChangeLoginName' => 'ChangeLoginName'));




?>
