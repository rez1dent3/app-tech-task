<?php

namespace App\JsonApi\Event;

use App\JsonApi\Controller\JsonApiInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class HeadersListener implements EventSubscriberInterface
{

    /**
     * @param ControllerEvent $event
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (\is_array($controller)) {
            $controller = \current($controller);
        }

        if ($controller instanceof JsonApiInterface) {
            /**
             * Servers MUST respond with a 415 Unsupported Media Type status code if a request specifies the header
             * Content-Type: application/vnd.api+json with any media type parameters.
             *
             * @see https://jsonapi.org/format/#content-negotiation
             */
            $request = $event->getRequest();
            $contentType = $request->headers->get('Content-Type');
            if (!$contentType || \strpos($contentType, "application/vnd.api+json") === false) {
                throw new HttpException(415, 'Unsupported Media Type');
            }

            /**
             * Servers MUST respond with a 406 Not Acceptable status code if a request’s Accept header
             * contains the JSON:API media type and all instances of that media type
             * are modified with media type parameters.
             *
             * @see https://jsonapi.org/format/#content-negotiation
             */
            $contentType = $request->headers->get('Accept');
            if (!$contentType || \strpos($contentType, "application/vnd.api+json") === false) {
                throw new HttpException(406, 'Not Acceptable');
            }
        }
    }

    /**
     * @return \array[][]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

}
