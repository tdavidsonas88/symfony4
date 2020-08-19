<?php


namespace App\Services;


use Doctrine\ORM\Event\PostFlushEventArgs;

class MyService implements ServiceInterface
{

    /**
     * MyService constructor.
     */
    public function __construct()
    {
        dump('hello from MyService!');
    }
}