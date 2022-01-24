<?php
namespace Simplecode\Contracts;
interface Middleware{
    public function setNext(Middleware $middleware);
}