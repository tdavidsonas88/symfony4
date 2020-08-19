<?php


namespace App\Services;


class MyService
{

    /**
     * MyService constructor.
     */
    public function __construct($one)
    {
        dump('hi!');
        dump($one);
    }

}