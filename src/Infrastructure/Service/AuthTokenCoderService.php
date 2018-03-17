<?php

namespace Realworld\Infrastructure\Service;

use Firebase\JWT\JWT;
use Realworld\Domain\Model\UserAuthToken;
use Realworld\Domain\Service\AuthTokenCoderServiceInterface;

/**
 * Encodes and decodes AuthToken with JWT
 */
class AuthTokenCoderService implements AuthTokenCoderServiceInterface
{
    const ALG = "HS256";

    /**
     * @var JWT
     */
    private $firebase;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * @param JWT $jwt
     * @param string $privateKey
     */
    public function __construct(JWT $jwt, string $privateKey)
    {
        $this->firebase = $jwt;
        $this->privateKey = $privateKey;
    }

    /**
     * @param UserAuthToken $token
     * @return string
     */
    public function encode(UserAuthToken $token): string
    {
        return $this->firebase::encode(
            [
                "sub" => $token->email,
                "name" => $token->name,
            ],
            $this->privateKey,
            self::ALG
        );
    }

    /**
     * @param string $encodedToken
     * @return UserAuthToken
     */
    public function decode(string $encodedToken): UserAuthToken
    {
        $token = $this->firebase::decode($encodedToken, $this->privateKey, [self::ALG]);

        return new UserAuthToken($token->name, $token->sub);
    }
}