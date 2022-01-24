<?php
namespace Simplecode\Contracts;
/**
 * Un contract entre les models
 */
interface ModelInterface{
    /***
     * Create a table of this model if not exist
     */
    public static function createTable();
}