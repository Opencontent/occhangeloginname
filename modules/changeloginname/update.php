<?php

$Module = $Params['Module'];
if ( !$Module instanceof eZModule )
{
    eZExecution::cleanExit();
}

$NodeID = $Params['NodeID'];
$http = new eZHTTPTool();
$node = eZContentObjectTreeNode::fetch( $NodeID );

$tpl = eZTemplate::factory();


if ( $node instanceof eZContentObjectTreeNode )
{
    $object = $node->attribute('object');
    $message = false;
    $newLogin = ChangeLoginName::findLoginName( $object );
    $showForm = ChangeLoginName::findUserAttribute( $object );

    if ( !$showForm )
    {
        $message = "Non trovo attributi di tipo ezuser nell'oggetto selezionato";
    }

    if ( $http->hasPostVariable( 'new_login_name' ) )
    {
        $newLogin = $http->postVariable( 'new_login_name' );
    }

    if ( $Module->currentAction() == 'ChangeLoginName' )
    {
        try
        {
            ChangeLoginName::run( $newLogin, $object );
            eZContentCacheManager::clearContentCache( $object->attribute( 'id' ) );
            eZUser::purgeUserCacheByUserId( $object->attribute( 'id' ) );
            $Module->redirectTo( $node->attribute( 'url_alias' ) );
        }
        catch( Exception $e )
        {
            $message = $e->getMessage();
        }
    }

    $tpl->setVariable( 'message', $message );
    $tpl->setVariable( 'current_node', $node );
    $tpl->setVariable( 'login_name', $newLogin );
    $tpl->setVariable( 'show_form', $showForm );
    $Result['content']=$tpl->fetch('design:changeloginname/update.tpl');

}
else
{
    $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
}