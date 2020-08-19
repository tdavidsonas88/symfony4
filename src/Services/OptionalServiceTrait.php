<?php


namespace App\Services;


trait OptionalServiceTrait
{
    private $service;

    /**
     * @required
     * @param MySecondService $second_service
     */
    public function setSecondService(MySecondService $second_service)
    {
        $this->service = $second_service;
    }
}