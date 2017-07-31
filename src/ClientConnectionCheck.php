<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

class ClientConnectionCheck extends NoMagicFunctions
{
    private $client = null;
    private $server = null;
    private $adminName = null;
    private $transferProtocol = null;
    
    /**
     * @param client Client object that represents the computer with which to check connection.
     * @param server (optional) Server object that represents the host server.
     * @param adminName (optional) Name of admin user who started the connection check.
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
     * Runs the actual connection check.
     */
    public function run() {
        // Run connection check and record result.
        $transferResult = $this->transferProtocol->checkConnection( $this->client, $this->server );
        
        // Log results
        if ( $transferResult === "SUCCESS" ) {
            // log file transfer
            $logMessage = "Confirmed connection to {$this->client->room()} {$this->client->type()} at {$this->client->ipAddress()} via {$this->transferProtocol}.";
            Log::networkCheck( $logMessage, $this->adminName );
            return "SUCCESS";
        } else {
            // log error
            $errorMessage = "Connection check error: {$transferResult}";
            Log::error( $errorMessage );
            return "ERROR";
        }
    }
}
