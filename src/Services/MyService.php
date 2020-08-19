<?php


namespace App\Services;


class MyService
{

    /**
     * MyService constructor.
     */
    public function __construct(MySecondService $secondService)
    {
        dump($secondService);
    }
}