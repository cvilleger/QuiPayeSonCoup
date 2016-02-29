<?php
namespace AppBundle\Listener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ControllerListener
{
    public function onCoreController(FilterControllerEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            $_controller = $event->getController();
            if (isset($_controller[0])) {
                $controller = $_controller[0];
                if (method_exists($controller, 'preExecute')) {
                    $redirectUrl = $controller->preExecute($event->getRequest());
                    if (!is_null($redirectUrl)) {
                        $event->setController(function () use ($redirectUrl) {
                            return new RedirectResponse($redirectUrl);
                        });
                    }
                }
            }
        }
    }
}
