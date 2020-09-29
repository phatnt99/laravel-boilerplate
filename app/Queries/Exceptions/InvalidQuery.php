<?php


namespace App\Queries\Exceptions;


use Flugg\Responder\Exceptions\Http\HttpException;

class InvalidQuery extends HttpException
{
    protected $status = 400;

    protected $errorCode = 'invalid_query';
}