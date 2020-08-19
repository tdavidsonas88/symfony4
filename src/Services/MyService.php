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

    public function someAction()
    {
        dump($this->service->doSomething2());
    }
}