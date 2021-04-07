<?php

namespace App\EventDispatcher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class PrenomSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'addPrenomtoAttributes',
            'kernel.controller' => 'test1',
            'kernel.response' => 'test2',

        ];
    }

    public function addPrenomtoAttributes(RequestEvent $requestEvent)
    {
        $requestEvent->getRequest()->attributes->set('prenom', 'damien');
    }

    public function test1()
    {
    }

    public function test2()
    {
    }
}
