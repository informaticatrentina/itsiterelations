<?php

/**
 * Estrae le dipendenze di tutti i siteaccess installati
 * con le relative estensioni
 * 
 * Se impostato formato JSON l'estrazione avviene in questo formato
 * 
 */

$http = eZHTTPTool::instance();
$tpl = eZTemplate::factory();

$module = $Params['Module'];
$format = $Params['Format'];

// Carico le dipendenze tra siti ed estensioni
$siteextensions = array();
try{
    $itRelationsManager = new ITRelationsManager();

    $siteextensions = $itRelationsManager->fetchRelations();
} catch (Exception $ex) {
    $siteextensions = array( 'error' => $ex->getMessage() ); 
}

// Visualizzazione nel formato desiderato
if($format === 'JSON'){
    header('Content-Type: application/json');
    echo json_encode( $siteextensions );    
    eZExecution::cleanExit();
}
else{
    $tpl->setVariable( 'siteextensions', json_encode($siteextensions));
    
    // Tutte le estensioni installate
    $itExtensionsManager = new ITExtensionsManager();
    $itExtensions = $itExtensionsManager->fetchExtensions();
    $tpl->setVariable( 'extensions', json_encode($itExtensions));
    //
    
    $Result['content'] = $tpl->fetch( "design:itsiterelations/siteextensions.tpl" );
    $Result['path'] = array( array( 'url' => '/',
                                    'text' => 'Home' ) ,
                             array( 'url' => false,
                                    'text' => ezpI18n::tr( 'module/relations', 'Site - Extensions Dependencies' ) ) );
}