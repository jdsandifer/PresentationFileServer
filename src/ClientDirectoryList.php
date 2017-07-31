<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

class ClientDirectoryList extends NoMagicFunctions
{
    private $client = null;
    private $server = null;
    private $adminName = null;
    private $transferProtocol = null;
    
    /**
     * @param client Client object that represents the computer with which to read directory.
     * @param server (optional) Server object that represents the host server.
     * @param adminName (optional) Name of admin user who started the directory.
     */
    public function __construct( $client, $server = null, $adminName = null ) {
        $this->client = $client;
        
        if ( $server !== null ) {
            $this->server = $server;
        } else {
            // Assume AV_SERVER_1 if not provided.
            $this->server = new Server( "AV_SERVER_1", "10.0.0.100", "/var/www/html/Files/" );
        }
        
        if ( $adminName !== null ) {
            $this->adminName = $adminName;
        }
        
        $clientComputerType = $this->client->type();
        
        // Use the factory function to figure out which file transfer protocol we need
        // and return the correct type of object
        $this->transferProtocol = FileTransferProtocols::createFor( $clientComputerType );
    }
    
    /**
     * Runs the actual directory list.
     */
    public function run() {
        // Run connection check and record result.
        $transferResult = $this->transferProtocol->directoryList( $this->client, $this->server );
        return $transferResult;
    }
}
