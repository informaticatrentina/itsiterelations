<?php

/**
 * Estrae l'elenco delle estensioni installate sul cluster
 * 
 * Parametro 1 Format (JSON)
 * Parametro 2 Dependencies (TRUE/FALSE)
 */

$http = eZHTTPTool::instance();
$tpl = eZTemplate::factory();

$module = $Params['Module'];
$format = $Params['Format'];
$dependencies = $Params['Dependencies'];

try{
    $itExtensionsManager = new ITExtensionsManager();

    $itExtensions = $itExtensionsManager->fetchExtensions();
    $itExtensionsDependencies = $itExtensionsManager->fetchExtensionsDependencies( $itExtensions );
} catch (Exception $ex) {
    $result = array( 'error' => $ex->getMessage() ); 
}
// Visualizzazione nel formato desiderato
if($format === 'JSON'){
    header('Content-Type: application/json');
    
    if( strtoupper($dependencies) === 'TRUE'){
        echo json_encode( $itExtensionsDependencies );
    }
    else{
        echo json_encode( $itExtensions );
    }
    
    eZExecution::cleanExit();
}
else{
    
    $tpl->setVariable( 'extensions', json_encode( $itExtensionsDependencies ));
    
    $Result['content'] = $tpl->fetch( "design:itsiterelations/extensions.tpl" );
    $Result['path'] = array( array( 'url' => '/',
                                    'text' => 'Home' ) ,
                             array( 'url' => false,
                                    'text' => ezpI18n::tr( 'module/relations', 'Extensions Dependencies' ) ) );
}
