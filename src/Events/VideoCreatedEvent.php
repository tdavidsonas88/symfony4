<?php


namespace App\Events;



use Symfony\Component\EventDispatcher\EventDispatcher;

class VideoCreatedEvent extends EventDispatcher
{

    /**
     * VideoCreatedEvent constructor.
     */
    public function __construct($video)
    {
        $this->video = $video;
    }
}