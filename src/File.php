<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

/**
 * Class for encapsulating file data
 */
class File extends NoMagicFunctions {
    private $name;    // actual name on disk (both client and server)
    private $nameToDisplay;    // name shown to client in browser
    private $id;    // AutoID from database (placeholder - may not be needed)
    
    // info about this file's presenter
    private $presenterName;
    private $presenterId;   // presenter ID from database (placeholder - may not be needed)
    
    public function __construct( $name, $nameToDisplay, $presenterName = "" ) {
        $this->name = $name;
        $this->nameToDisplay = $nameToDisplay;
        $this->presenterName = $presenterName;
    }
    
    /**
     * @return The string in $name
     */
    public function name() {
        return $this->name;
    }
    
    /**
     * @return The string in $nameToDisplay
     */
    public function nameToDisplay() {
        return $this->nameToDisplay;
    }
    
    /**
     * @return The string in $presenterName
     */
    public function presenterName() {
        return $this->presenterName;
    }
}
