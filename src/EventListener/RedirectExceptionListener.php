<?php



namespace  Mbdax\MicrosoftGraphBundle\EventListener;

use Mbdax\MicrosoftGraphBundle\Exception\RedirectException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * @author Abdellah Rabh
 * @email abderabh@gmail.com
 * @create date 2017-05-10 01:20:29
 * @modify date 2017-05-10 01:20:29
 * @desc  redirect exception listener
*/
class RedirectExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof RedirectException) {
            $event->setResponse($event->getException()->getRedirectResponse());
        }
    }
}