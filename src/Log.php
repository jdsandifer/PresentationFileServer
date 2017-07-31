<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

require_once __DIR__.'/../autoLoader.php';

/**
 * This class is a static class for logging info to the database.
 * Each function logs a specific kind of message.
 */
class Log extends NoMagicFunctions
{
    public static function error( $errorMessage ) {
        $safeErrorMessage = Log::truncateMessageForDb( $errorMessage );
      
        // Put the given error message in the database
        $internalDatabase = Log::internalDbConnection();
        $insert = $internalDatabase->prepare( "INSERT INTO Reports ( rAdmin, rTask, rNote ) VALUES ( 'SERVER RUN', 'Error Reporting', :error )" );
        $insert->bindValue( ':error', $safeErrorMessage );
        $insert->execute();
    }
    
    public static function fileTransfer( $fileMessage, $presenterName = null, $adminName = null ) {
        $safeMessage = Log::truncateMessageForDb( $fileMessage );
      
        // Put the given file transfer message in the database
        $internalDatabase = Log::internalDbConnection();
        $insert = $internalDatabase->prepare( "INSERT INTO Reports ( rAdmin, rPresenter, rTask, rNote ) VALUES ( :adminName, :presenterName, 'File Management', :fileMessage )" );
        $insert->bindValue( ':adminName', $adminName );
        $insert->bindValue( ':presenterName', $presenterName );
        $insert->bindValue( ':fileMessage', $safeMessage );
        $insert->execute();
    }
    
    public static function info( $message ) {
        $safeMessage = Log::truncateMessageForDb( $message );
      
        // Put the given message in the database
        $internalDatabase = Log::internalDbConnection();
        $insert = $internalDatabase->prepare( "INSERT INTO Reports ( rAdmin, rTask, rNote ) VALUES ( 'SERVER RUN', 'Information Reporting', :message )" );
        $insert->bindValue( ':message', $safeMessage );
        $insert->execute();
    }
    
    public static function networkCheck( $networkMessage, $adminName = null ) {
        $safeMessage = Log::truncateMessageForDb( $networkMessage );
      
        // Put the given network checking message in the database
        $internalDatabase = Log::internalDbConnection();
        $insert = $internalDatabase->prepare( "INSERT INTO Reports ( rAdmin, rTask, rNote ) VALUES ( :adminName, 'Network Checking', :networkMessage )" );
        $insert->bindValue( ':adminName', $adminName );
        $insert->bindValue( ':networkMessage', $safeMessage );
        $insert->execute();
    }
    
    
    private static function internalDbConnection() {
        // Create a database connection object (PDO)
        $sqlServerDsn = "mysql:host=localhost;dbname=*****;charset=utf8mb4";    // (database name hidden)
        $login = "";    // (hidden)
        $password = "";    // (hidden)
        $options = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT => false
            );
        $internalDatabase = new PDO( $sqlServerDsn, $login, $password, $options );
        
        return $internalDatabase;
    }
    
    private static function truncateMessageForDb( $message ) {
        // Make the message fit in the database - not sure what the max is exactly, but we need to control it's length.
        // This is a good length for now until someone has time to research it.
        return substr( $message, 0, 750 );
    }
}
