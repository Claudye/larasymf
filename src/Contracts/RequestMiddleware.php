<?php
namespace Simplecode\Contracts;

use Simplecode\Protocole\Http\Request;

interface RequestMiddleware{
    public function handle(Request $request);
}