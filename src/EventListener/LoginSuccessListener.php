<?php
use Symfony\Component\Security\Http\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginSuccessListener
{
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $id = $user->getId();
        $url = $event->getRequest()->getSession()->get('_target_path');

        if ($url !== null) {
            $url .= '?id=' . $id;
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }
}
