<?php

namespace App\JsonApi\Event;

use App\JsonApi\Response\JsonApiResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseListener implements EventSubscriberInterface
{

    /**
     * @param ResponseEvent $event
     */
    public function onKernelResponsePost(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        if ($response instanceof JsonApiResponse) {
            $response
                ->headers
                ->set('Content-Type', 'application/vnd.api+json; charset=utf8')
            ;
        }
    }

    /**
     * @return \array[][]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponsePost',
        ];
    }

}
