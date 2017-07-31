<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

class FilePushToClientFromServer extends NoMagicFunctions
{
    private $file = null;
    private $client = null;
    private $server = null;
    private $adminName = null;
    private $transferProtocol = null;
    
    /**
     * @param file File object that represents the file to transfer.
     * @param client Client object that represents the computer to pull from.
     * @param server (optional) Server object that represents the host server.
     * @param adminName (optional) Name of admin user if this was done by admin.
     */
    public function __construct( $file, $client, $server = null, $adminName = null ) {
        $this->file = $file;
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
     * Runs the actual file transfer.
     */
    public function run() {
        // Run file transfer command
        $transferResult = $this->transferProtocol->pushFile( $this->file, $this->client, $this->server );
        
        // Log results
        if ( $transferResult === "SUCCESS" ) {
            // log file transfer
            $logMessage = "Pushed {$this->file->name()} to {$this->client->room()} {$this->client->type()} via {$this->transferProtocol}.";
            $adminPushed = ( $this->adminName !== null );
            if ( $adminPushed ) {
                Log::fileTransfer( $logMessage, null, $this->adminName );
            } else {
                Log::fileTransfer( $logMessage, $this->file->presenterName() );
            }
        } else {
            // log error
            $errorMessage = "File push error: {$transferResult}";
            Log::error( $errorMessage );
        }
    }
}
