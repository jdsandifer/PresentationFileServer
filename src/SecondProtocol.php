<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

class SecondProtocol extends NoMagicFunctions implements FileTransferProtocol
{
    /**
     * The constructor takes no arguments because all info 
     * will come from the objects passed to the function created
     * and returned by the transferFunction() method below.
     */
    public function __construct( ) {

    }


    /**
     * Tries to perform a directory read command
     * to see if there's a good connection to the specified
     * client computer.
     */
    public function checkConnection( $client, $server ) {
        $transferCommand = ""    // set ssh password (hidden)
            .""    // options (hidden)
            ."";    // other options (hidden)
                
        $transferResult = shell_exec( $transferCommand );

        // Check the result and convert result to a standard error format.
        $resultContainsCorrectDots = ( strpos($transferResult, ' .') !== false ) && ( strpos($transferResult, ' ..') !== false ) ;    // i.e. shows the standard directories
        if ( $resultContainsCorrectDots ) {
            return "SUCCESS";   // if the result listed directiories in it, then it worked
        } else {
            return "({$this}) {$transferCommand}\n{$transferResult}";    // return command and error 
        }
    }
    
    /**
     * Tries to perform a directory read command
     * to see what files are on a computer.
     */
    public function directoryList( $client, $server ) {
        $transferCommand = ""    // set ssh password (hidden)
            .""    // options (hidden)
            ."";    // more options (hidden)
        
        // Run the command and gather the result (output from shell) and the elapsed timed
        $startTime = microtime( true );        
        $transferResult = shell_exec( $transferCommand );
        $elapsedTime = microtime( true ) - $startTime;
        $secondsWithThreeDecimals = number_format( $elapsedTime, 3 );
        $timeStamp = "Directory listing in {$secondsWithThreeDecimals} sec\n";

        // Check the result and convert result to a standard error format.
        $resultContainsCorrectDots = ( strpos($transferResult, ' .') !== false ) && ( strpos($transferResult, ' ..') !== false );    // i.e. shows the standard directories
        if ( $resultContainsCorrectDots ) {
            return $timeStamp . $transferResult;   // if the result listed directiories in it, then it worked and return that (with timestamp)
        } else {
            return $timeStamp . "({$this}) {$transferCommand}\n{$transferResult}";    // return command and error (with timestamp)
        }
    }

    /**
     * Pulls a file from the client to the server. Takes file, client, and server
     * objects as parameters.
     */
    public function pullFile( $file, $client, $server ) {
        // Make sure we have a file name - will cause problems instead of just erroring without it!
        $noFileName = ( $file->name() === null ) || ( $file->name() === "" );
        if ( $noFileName ) {
          return "({$this}) Can't pull - no file name given";
        }
      
        $transferCommand = ""    // shell command (hidden)
            .""    // options (hidden)
            ."";    // other options (hidden)
                
        $transferResult = shell_exec( $transferCommand );

        // Check the result and convert result to a standard error format.
        $resultContainsWordError = ( strpos($transferResult, 'error') !== false );
        if ( ! $resultContainsWordError ) {
        return "SUCCESS";   // if the result didn't include "error", then it worked
        } else {
            return "({$this}) {$transferCommand}\n{$transferResult}";    // return command and error 
        }
    }

    /**
     * Pushes a file to a client from the server. Takes file, client, and server
     * objects as parameters.
     */
    public function pushFile( $file, $client, $server ) {
        // Make sure we have a file name - will cause problems instead of just erroring without it!
        $noFileName = ( $file->name() === null ) || ( $file->name() === "" );
        if ( $noFileName ) {
          return "({$this}) Can't push - no file name given";
        }
        
        $transferCommand = ""    // shell command (hidden)
            .""    // options (hidden)
            ."";    // more options (hidden)
                
        $transferResult = shell_exec( $transferCommand );

        // Check the result and convert result to a standard error format.
        $resultContainsWordError = ( strpos($transferResult, 'error') !== false );
        if ( ! $resultContainsWordError ) {
        return "SUCCESS";   // if the result didn't include "error", then it worked
        } else {
            return "({$this}) {$transferCommand}\n{$transferResult}";    // return command and error
        }
    }

    public function __toString() {
        return "SecondProtocol";
    }
}
