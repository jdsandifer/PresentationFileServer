<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

/**
 * This is a factory for file transfer protocol commands.
 * 
 * This allows protocols to be created with out the calling objects knowing
 * about the specifics of which protocol is for which computer type.
 */
class FileTransferProtocols extends NoMagicFunctions
{
    /**
     * Returns the correct protocol object based on the type of computer.
     */
    public static function createFor( $computerType ) {
        // Create the best protocol for the specific type of computer
        switch ( $computerType ) {
            case "MAC":
                $newFileTransferProtocol = new SecondProtocol();    // (object name changed)
                break;
            case "PC":
                $newFileTransferProtocol = new FirstProtocol();    // (object name changed)
                break;
            default:
                throw new Exception( "Can't create file transfer protocol: unknown computer type" );
                break;
        }
        
        // Return the protocol (only gets here if protocol creation succeeded above)
        return $newFileTransferProtocol;
    }
}
