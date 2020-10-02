<?php

namespace App\Helper;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MercureJWTProvider
{
    /**
     * @var string
     */
    protected $secret;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenGenerator;

    /**
     * MercureJWTProvider constructor.
     *
     * @param string $secret
     */
    public function __construct(string $secret, TokenStorageInterface $tokenGenerator)
    {
        $this->secret = $secret;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @return string
     */
    public function __invoke(): string
    {
        $user = $this->tokenGenerator->getToken()->getUser();

        return (new Builder())
            ->withClaim('mercure', [
                'subscribe' => ["*"],
                'publish' => ["*"],
                'payload' => [
                    'username' => $user->getEmail(),
                ],
            ])
            ->getToken(new Sha256(), new Key($this->secret));
    }
}