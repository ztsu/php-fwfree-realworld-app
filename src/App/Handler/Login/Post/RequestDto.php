<?php

namespace Realworld\App\Handler\Login\Post;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Data from POST request to /api/users/login
 */
class RequestDto
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email , string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @param ServerRequestInterface $request
     * @return RequestDto
     */
    public static function create(ServerRequestInterface $request): self
    {
        $body = $request->getParsedBody();
        $email = "";
        $password = "";

        if (is_array($body) && array_key_exists("user", $body)) {
            if (array_key_exists("email", $body["user"])) {
                $email = $body["user"]["email"];
            }

            if (array_key_exists("password", $body["user"])) {
                $password = $body["user"]["password"];
            }
        }

        return new self($email, $password);
    }
}