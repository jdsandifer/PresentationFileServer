<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

class FirstProtocol extends NoMagicFunctions implements FileTransferProtocol
{
    /**
     * The constructor takes no arguments because all info 
     * will come from the objects passed to the function created
     * and returned by the methods below.
     */
    public function __construct( ) {
        
    }
    
    /**
     * Tries to look at a directory on the client computer
     * to see if there's a good connection to the specified
     * client computer.
     */
    public function checkConnection( $client, $server ) {
        $transferCommand = "timeout 0.1"    // max time to let command run is 100 msec
            .""    // shell command (hidden)
            .""    // removes warning line at beginning of output (hidden)
            .""    // other options (hidden)
            ."";    // pipe error output to standard output so we get both (hidden)
            
                
        // Run the command and gather the result (output from shell)
        $transferResult = shell_exec( $transferCommand );
            
        // Check the result and convert result to a standard error format.
        $resultContainsCorrectDots = ( strpos($transferResult, ' . ') !== false ) && ( strpos($transferResult, ' .. ') !== false ) ;    // i.e. shows the standard directories
        if ( $resultContainsCorrectDots ) {
            return "SUCCESS";   // if the result listed directiories in it, then it worked
        } else {
            // return this protocol's name, the command, and the error
            return "({$this}) {$transferCommand}\n{$transferResult}";
        }
    }
    
    /**
     * Tries to perform a directory read command
     * to see what files are on a computer.
     */
    public function directoryList( $client, $server ) {
        $transferCommand = "timeout 0.1"    // max time to let command run is 100 msec
            .""    // shell command (hidden)
            .""    // removes warning line at beginning of output (hidden)
            .""    // other options (hidden)
            ."";    // pipe error output to standard output so we get both (hidden)
            
        // Run the command and gather the result (output from shell) and the elapsed timed
        $startTime = microtime( true );
        $transferResult = shell_exec( $transferCommand );
        $elapsedTime = microtime( true ) - $startTime;
        $secondsWithThreeDecimals = number_format( $elapsedTime, 3 );
        $timeStamp = "Directory listing in {$secondsWithThreeDecimals} sec\n";
        
        // Check the result and convert result to a standard error format.
        $resultContainsCorrectDots = ( strpos($transferResult, ' . ') !== false ) && ( strpos($transferResult, ' .. ') !== false ) ;    // i.e. shows the standard directories
        if ( $resultContainsCorrectDots ) {
            return  $timeStamp . $transferResult;   // if the result listed directiories in it, then it worked and we return that (with timestamp)
        } else {
            // return this protocol's name, the command, and the error (with timestamp)
            return $timeStamp . "({$this}) {$transferCommand}\n{$transferResult}";
        }
    }
    
    /**
     * Pulls a file from the client to the server. Takes file, client, and server
     * objects as parameters.
     */
    public function pullFile( $file, $client, $server ) {
        $transferCommand = ""    // shell command (hidden)
            .""    // removes warning line at beginning of output (hidden)
            .""    // other options (hidden)
            ."";    // pipe error output to standard output so we get both (hidden)
                
        // Run the command and gather the result (output from shell)
        $transferResult = shell_exec( $transferCommand );
            
        // Check the result and convert result to a standard error format.
        $resultContainsWordGetting = ( strpos($transferResult, 'getting') !== false );
        if ( $resultContainsWordGetting ) {
            return "SUCCESS";   // if the result had "getting" in it, then it worked
        } else {
            // return this protocol's name, the command, and the error
            return "({$this}) $transferCommand}\n{$transferResult}";
        }
    }
    
    /**
     * Pushes a file to a client from the server. Takes file, client, and server
     * objects as parameters.
     */
    public function pushFile( $file, $client, $server ) {
        $transferCommand = ""    // shell command (hidden)
            .""    // removes warning line at beginning of output (hidden)
            .""    // other options (hidden)
            ."";    // info about file and computers (hidden)
        
        // Run the command and gather the result (output from shell)
        $transferResult = shell_exec( $transferCommand );
            
        // Check the result and convert it to a standard error format.
        $resultContainsWordPutting = ( strpos( $transferResult, 'putting' ) !== false );
        if ( $resultContainsWordPutting ) {
            return "SUCCESS";   // if the result had "putting" in it, then it worked
        } else {
            // return this protocol's name, the command, and the error
            return "({$this}) $transferCommand}\n{$transferResult}";
        }
    }
    
    public function __toString() {
        return "FirstProtocol";
    }
}
