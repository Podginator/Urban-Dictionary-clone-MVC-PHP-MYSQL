<?php
/**
 * Define a custom exception class
 */
class InvalidCSV extends Exception
{
    protected $message = "The CSV file passed in has Errors.";
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
    	$message = $this->message . " " . $message;
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}