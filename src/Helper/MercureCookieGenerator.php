<?php

namespace App\Helper;

use App\Entity\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;

class MercureCookieGenerator
{
    /**
     * @var string
     */
    protected $secret;

    /**
     * MercureCookieGenerator constructor.
     * @param string $secret
     */
    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param User $user
     * @return string
     */
    public function generate(User $user): string
    {
        return (new Builder())
            // set other appropriate JWT claims, such as an expiration date
            ->withClaim('mercure', [
                'subscribe' => ["*"],
                'publish' => ["*"],
                'payload' => [
                    'username' => $user->getEmail(),
                ]

            ]) // can also be a URI template, or *
            ->getToken(new Sha256(), new Key($this->secret));
    }
}