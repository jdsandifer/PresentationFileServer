<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

/**
 * Class for encapsulating server computer info
 * (internal or external server)
 */
class Server extends NoMagicFunctions {
    private $name;    // "AV_SERVER_1", "AV_SERVER_2", or "WEB_SERVER"
    private $ipAddress;    // string like "10.0.0.17"
    private $filesFolder;    // string with path like "/var/html/Files/"
                             // IMPORTANT: must include trailing "\" or "/"
    private $login;    // username to use to login remotely
    private $password;   // password to use to login remotely
    private $hostName;    // string like "www.occproduction.com" (if applicable) or empty ""
    
    public function __construct( $name, $ipAddress, $filesFolder, $login = "", $password = "", $hostName = "" ) {
        // make sure name string is uppercase and a valid choice
        $upperCaseName = mb_strtoupper( $name, 'ASCII');
        $isValidName = ( 
            ( $upperCaseName === 'AV_SERVER_1' ) 
            || ( $upperCaseName === 'AV_SERVER_2' ) 
            || ( $upperCaseName === 'WEB_SERVER' )
        );
        if ( $isValidName ) {
            $this->name = $upperCaseName;
        } else {        
            throw new Exception( "Could not construct Server: bad name - {$name} - for server" );
        }
        
        // make sure ip address is valid
        $isValidIpAddress = filter_var( $ipAddress, FILTER_VALIDATE_IP );
        if ( $isValidIpAddress ) {
            $this->ipAddress = $ipAddress;
        } else {
            throw new Exception( "Could not construct Server: bad IP address - {$ipAddress} - for {$this->name}" );
        }
        
        $this->filesFolder = $filesFolder;
        $this->login = $login;
        $this->password = $password;
        
        // make sure host name is valid if present
        $isValidDomainName = $this->isValidDomainName($hostName);
        $isEmptyDomainName = $hostName === "";
        if ( $isValidDomainName || $isEmptyDomainName ) {
            $this->hostName = $hostName;
        } else {
            throw new Exception( "Could not construct Server: bad domain - {$hostName} - for {$this->name}" );
        }
    }
    
    /**
     * @return The name string
     */
    public function name() {
        return $this->name;
    }
    
    /**
     * @return The ip address string like "10.0.0.100"
     */
    public function ipAddress() {
        return $this->ipAddress;
    }
    
    /**
     * @return The path to the Files folder like "/var/html/Files"
     */
    public function filesFolder() {
        return $this->filesFolder;
    }
    
    /**
     * @return The login username string
     */
    public function login() {
        return $this->login;
    }
    
    /**
     * @return The password string
     */
    public function password() {
        return $this->password;
    }
    
    /**
     * @return The hostname string like "http://www.occproduction.com"
     */
    public function hostName() {
        return $this->hostName;
    }
    
    /**
     * Validates a domain name (host name)
     * 
     * @param $domainNameToTest is a string like "www.occproduction.com"
     * @return boolean - true for valid domain, false otherwise
     */
    private function isValidDomainName( $domainNameToTest ) {
        $hasOnlyValidChars = preg_match( "/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domainNameToTest );
        $hasValidTotalLength = preg_match ("/^.{1,253}$/", $domainNameToTest );
        $hasValidLengthForEachLabel = preg_match( "/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domainNameToTest );
        
        return ( $hasOnlyValidChars && $hasValidTotalLength && $hasValidLengthForEachLabel );
    }
}
