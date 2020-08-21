<?php


namespace App\Events;


use Laminas\EventManager\Event;

class VideoCreatedEvent extends Event
{

    /**
     * VideoCreatedEvent constructor.
     */
    public function __construct($video)
    {
        $this->video = $video;
    }
}