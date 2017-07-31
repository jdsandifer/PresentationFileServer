<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

/**
 * Interface for file transfer protocols (like rsync, smbclient, scp).
 */
interface FileTransferProtocol
{
    /**
     * Tries to perform a directory read command
     * to see if there's a good connection to the specified
     * client computer.
     */
    public function checkConnection( $computer, $server );
    
    /**
     * Tries to perform a directory read command
     * to see what files are on the client computer.
     */
    public function directoryList( $computer, $server );
    
    /**
     * Pulls a file from the client to the server. Takes file, client, and server
     * objects as parameters.
     */
    public function pullFile( $file, $computer, $server );
    
    /**
     * Pushes a file to a client from the server. Takes file, client, and server
     * objects as parameters.
     */
    public function pushFile( $file, $computer, $server );
    
}
