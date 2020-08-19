<?php


namespace App\Services;


use Doctrine\ORM\Event\PostFlushEventArgs;

class MyService
{

    /**
     * MyService constructor.
     */
    public function __construct()
    {
        dump('hello!');
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        dump('hello postFlush!');
        dump($args);
    }

    public function clear()
    {
        dump('clear ... ');
    }

}