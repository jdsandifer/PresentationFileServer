<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

/**
 * Class for encapsulating client computer info
 * (presentation and speaker ready room computers)
 */
class Client extends NoMagicFunctions {
    private $room;    // room where computer is located like "B117"
    private $type;    // "MAC" or "PC" (might include OS later)
    private $ipAddress;    // local network as a string like "10.0.0.17"
    private $filesFolder;    // string with path like "/var/html/Files/"
                             // IMPORTANT: must include trailing "/" or "\"
    private $login;    // username to use to login remotely
    private $password;   // password to use to login remotely
    
    public function __construct( $room, $type, $ipAddress, $filesFolder, $login, $password ) {
        $this->room = $room;
        
        // make sure type string is uppercase and a valid choice
        $upperCaseType = mb_strtoupper( $type, 'ASCII');
        $isValidType = ( ( $upperCaseType === 'MAC' ) || ( $upperCaseType === 'PC' ) );
        if ( $isValidType ) {
            $this->type = $upperCaseType;
        } else {        
            throw new Exception("Could not construct Client: bad type - {$type} - for computer in {$room}");
        }
        
        // make sure ip address is valid
        $isValidIpAddress = filter_var($ipAddress, FILTER_VALIDATE_IP);
        if ( $isValidIpAddress ) {
            $this->ipAddress = $ipAddress;
        } else {
            throw new Exception("Could not construct Client: bad IP address - {$ipAddress} - for computer in {$room}");
        }
        
        $filesFolderSpecified = ( $filesFolder !== null );
        if ( $filesFolderSpecified ) {
            $this->filesFolder = $filesFolder;
        } else if ( !$filesFolderSpecified && $this->type === "PC" ) {
            $this->filesFolder = "/ShowFiles/";
        } else if ( !$filesFolderSpecified && $this->type === "MAC" ) {
            $this->filesFolder = "/Users/Shared/ShowFiles/";
        } else {
            $this->filesFolder = "/badComputerType/";    // this will show up in error output
        }
        
        $this->login = $login;
        $this->password = $password;
    }
    
    /**
     * @return The room name string
     */
    public function room() {
        return $this->room;
    }
    
    /**
     * @return The type string
     */
    public function type() {
        return $this->type;
    }
    
    /**
     * @return The ip address string
     */
    public function ipAddress() {
        return $this->ipAddress;
    }
    
    /**
     * @return The path to the Files folder like "C:\ShowFiles"
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
}
