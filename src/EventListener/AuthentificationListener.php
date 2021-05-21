<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class AuthentificationListener {
    /** @var RequestStack $requestStack */
    protected $requestStack;

    /** @var UserRepository $userRepository */
    protected $userRepository;

    /**
     * AuthentificationListener constructor.
     *
     * @param RequestStack $requestStack
     * @param UserRepository $userRepository
     */
    public function __construct(RequestStack $requestStack, UserRepository $userRepository)
    {
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload['academy'] = null;
        $payload['guild']   = null;

        $payload = $event->getData();
        $user = $this->userRepository->findOneBy(['email' => $payload['email']]);

        if ($user->getAcademy()) {
            $payload['academy']['id'] = $user->getAcademy()->getId();
            $payload['academy']['name'] = $user->getAcademy()->getName();
        }

        if ($user->getGuild()) {
            $payload['guild']['id'] = $user->getGuild()->getId();
            $payload['guild']['name'] = $user->getGuild()->getName();
        }

        $event->setData($payload);
    }
}