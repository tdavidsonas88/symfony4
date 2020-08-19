<?php


namespace App\Services;


class MySecondService
{

    /**
     * MySecondService constructor.
     */
    public function __construct()
    {
        dump('from second service');
    }

    public function someMethod()
    {
        return ' hello ! ';
    }

}