<?php

// namespace Srs;    // caused errors and may not be necessary so commented out for now

/**
 * Parent class for all classes/objects to deactivate
 * magic functions and avoid unexpected functionality and errors
 * when trying to access non-existent/private variables or methods
 */
abstract class NoMagicFunctions {
    
    /**
     * Make magic call function throw an error instead of working
     * so it's clear when something tries to run a non-existent/private method
     */
    function __call( $methodName, $aguments ) {
        throw new \Exception("Bad class access: Tried to call an inaccessible method - {$methodName}()");
    }
    
    /**
     * Make magic get function throw an error instead of working
     * so it's clear when something tries to access a non-existent/private
     * variable directly or a private function
     */
    function __get( $variableName ) {
        throw new \Exception("Bad class access: Tried to get an inaccessible member variable - {$variableName}");
    }
    
    
    /*
     * Make magic set function throw an error instead of working
     * so it's clear when something tries to set a non-existent/private
     * variable directly or define a new function
     */
    function __set( $variableName, $newValue ) {
        throw new \Exception("Bad class access: Tried to set an inaccessible member variable - {$variableName}");
    }
}
