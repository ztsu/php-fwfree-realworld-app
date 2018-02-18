<?php

namespace Realworld\App\Authentication;

use Firebase\JWT\JWT;

/**
 * Encodes and decodes AuthToken with JWT
 */
class TokenService
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
     * @param AuthToken $token
     * @return string
     */
    public function encode(AuthToken $token): string
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
     * @return AuthToken
     */
    public function decode(string $encodedToken): AuthToken
    {
        $token = $this->firebase::decode($encodedToken, $this->privateKey, [self::ALG]);

        return new AuthToken($token->name, $token->sub);
    }
}