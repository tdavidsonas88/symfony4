<?php


namespace App\Services;


class MySecondService implements ServiceInterface
{

    /**
     * MySecondService constructor.
     */
    public function __construct()
    {
        dump('hello from second service!');
    }

    public function someMethod()
    {
        return ' hello ! ';
    }

}