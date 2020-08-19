<?php


namespace App\Services;


class MyService
{

    use OptionalServiceTrait;

    /**
     * MyService constructor.
     */
    public function __construct(MySecondService $secondService)
    {
    }
}