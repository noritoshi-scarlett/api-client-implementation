<?php

namespace Kamil\MerceApi\Exception;

trait ExceptionTrait
{

    /**
     * Gets a string representation of the thrown object
     * @return string Returns the `string` representation of the thrown object.
     */
    public function __toString()
    {
    }

    /**
     * Gets the exception code
     * Returns the error code associated with the thrown object.
     * @return int Returns the exception code as `int` in Exception but possibly as other type in Exception descendants (for example as `string` in PDOException).
     */
    public function getCode()
    {
    }

    /**
     * Gets the file in which the object was created
     * Get the name of the file in which the thrown object was created.
     * @return string Returns the filename in which the thrown object was created.
     */
    public function getFile()
    {
    }

    /**
     * Gets the line on which the object was instantiated
     * Returns the line number where the thrown object was instantiated.
     * @return int Returns the line number where the thrown object was instantiated.
     */
    public function getLine()
    {
    }

    /**
     * Gets the message
     * Returns the message associated with the thrown object.
     * @return string Returns the message associated with the thrown object.
     */
    public function getMessage()
    {
    }

    /**
     * Returns the previous Throwable
     * Returns any previous Throwable (for example, one provided as the third parameter to Exception::__construct()).
     * @return Throwable|null Returns the previous Throwable if available, or `null` otherwise.
     */
    public function getPrevious()
    {
    }

    /**
     * Gets the stack trace
     * Returns the stack trace as an `array`.
     * @return array Returns the stack trace as an `array` in the same format as debug_backtrace().
     */
    public function getTrace()
    {
    }

    /**
     * Gets the stack trace as a string
     * @return string Returns the stack trace as a string.
     */
    public function getTraceAsString()
    {
    }
}