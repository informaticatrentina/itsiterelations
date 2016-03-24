<?php

/**
 * Estrazione delle dipendenze tra siteaaccess ed estensioni
 * per il cluster di Informatica Trentina SpA
 * 
 * @author Stefano Ziller <stefano.ziller@infotn.it>
 * @author Marco Stambul <marco.stambul@infotn.it>
 */
class ITRelationsManager
{
    private $SITEACCESS = '/settings/siteaccess';
    
    private $current_dir = NULL;
    private $siteaccess_list = NULL;
    
    /**
     * Trova le estensioni attive di un determinato siteaccess.
     * 
     * @param type $siteaccess
     * @return array
     */
    private function findActiveExtensions( $siteaccess )
    {
        $activeExtensions = array();
        $rootDIR = $this->current_dir . $this->SITEACCESS . '/' . $siteaccess;
        
        $siteINI = eZINI::instance('site.ini.append.php', $rootDIR);
        $siteINI->parseFile($rootDIR . '/site.ini.append.php');

        if( $siteINI instanceof eZINI ){
            if( $siteINI->hasVariable('ExtensionSettings', 'ActiveAccessExtensions') ){
                $activeExtensions = $siteINI->variable('ExtensionSettings', 'ActiveAccessExtensions');
            }
        }
        
        return $activeExtensions;
    }
    
    /**
     * Inizializza le strutture principali
     */
    public function ITRelationsManager()
    {
        $this->current_dir = getcwd();
        
        $this->siteaccess_list = scandir( $this->current_dir . $this->SITEACCESS );
    }
    
    
    /**
     * Genera un array con tutte le dipendenze
     * 
     * @return array
     */
    public function fetchRelations()
    {
        $result = array();
        
        foreach( $this->siteaccess_list as $dir ){
            if( is_dir( $this->current_dir . $this->SITEACCESS . '/' . $dir ) ){
                // Assumo che il nome dei siteaccess sia numerico di 3 cifre
                if( strlen($dir)===3 && is_numeric($dir) ){
                    $site = array();
                    $site['Site'] = $dir;
                    $site['FrontEndExtensions'] = $this->findActiveExtensions( $dir );
                    
                    // Assumo esistenza di (admin, debug, deu, eng)
                    $site['AdminExtensions'] = $this->findActiveExtensions( $dir."admin" );
                    $site['DebugExtensions'] = $this->findActiveExtensions( $dir."debug" );
                    $site['EngExtensions'] = $this->findActiveExtensions( $dir."eng" );
                    $site['DeuExtensions'] = $this->findActiveExtensions( $dir."deu" );
                    
                    $result[] = $site;
                }
            }
        }
        
        return $result;
    }
}