<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class VideoCreatedSubscriber implements EventSubscriberInterface
{
    public function onVideoCreatedEvent($event)
    {
        dump($event->video->title);
    }

    public function onKernelResponse1(ResponseEvent $event)
    {
        $response = new Response('dupa');
//        $event->setResponse($response);
        dump('1');
    }

    public function onKernelResponse2(ResponseEvent $event)
    {
        $response = new Response('dupa');
//        $event->setResponse($response);
        dump('2');
    }

    public static function getSubscribedEvents()
    {
        return [
//            'video.created.event' => 'onVideoCreatedEvent',
//            KernelEvents::RESPONSE => [
//                ['onKernelResponse1', 1],
//                ['onKernelResponse2', 2],
//            ]
        ];
    }
}
