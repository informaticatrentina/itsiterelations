<?php

/**
 * Estrazione delle estensioni installate
 * per il cluster di Informatica Trentina SpA
 * 
 * @author Stefano Ziller <stefano.ziller@infotn.it>
 */
class ITExtensionsManager
{
    private $EXTENSION = '/extension';
    
    private $current_dir = NULL;
    private $extension_list = NULL;
    
    /**
     * Inizializza le strutture principali
     */
    public function ITExtensionsManager()
    {
        $this->current_dir = getcwd();
        
        $this->extension_list = scandir( $this->current_dir . $this->EXTENSION );
    }
    
    /**
     * Genera un array con tutte le estensioni
     * 
     * @return array
     */
    public function fetchExtensions()
    {
        $result = array();
        
        foreach( $this->extension_list as $dir ){
            if( is_dir( $this->current_dir . $this->EXTENSION . '/' . $dir ) ){
                if($dir !== '.' && $dir !== '..'){
                    $result[] = $dir;
                }
            }
        }
        
        return $result;
    }
    
    /**
     * Genera un array con le estensioni e le loro dipendenze
     * 
     * @param array $extensions Elenco estensioni installate
     * @return array
     */
    public function fetchExtensionsDependencies( $extensions )
    {
        $result = array();
        
        foreach( $extensions as $dir ){
            $extension = array();
            
            // Nome dell'estensione
            $extension['Extension'] = $dir;
            
            // controllo se esiste il composer.json
            $filename = $this->current_dir . $this->EXTENSION . '/' . $dir . '/composer.json';
            if( file_exists ( $filename ) ){
                $composer = file_get_contents( $filename );
                $composer_json = json_decode($composer, true);
                $extension['Dependencies'] = $composer_json['require'];
            }
            
            $result[] = $extension;
        }
        
        return $result;
    }
}
