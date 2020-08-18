<?php


namespace App\Services;


class MyService
{

    /**
     * MyService constructor.
     */
    public function __construct($param, $param2, $adminEmail, $globalParam)
    {
        dump($param);
        dump($param2);
        dump($adminEmail);
        dump($globalParam);
    }
}