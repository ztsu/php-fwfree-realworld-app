<?php

namespace Realworld\App\Handler\Users\Post;

use Psr\Http\Message\ServerRequestInterface;
use Realworld\Domain\Model\User;

/**
 * Data from POST request on /api/users
 */
class RequestDto
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @param ServerRequestInterface $request
     * @return RequestDto
     */
    public static function create(ServerRequestInterface $request)
    {
        $username = "";
        $email = "";
        $password = "";

        $body = $request->getParsedBody();

        if (array_key_exists("user", $body)) {
            if (array_key_exists("username", $body["user"])) {
                $username = (string)$body["user"]["username"];
            }
            if (array_key_exists("email", $body["user"])) {
                $email = (string)$body["user"]["email"];
            }
            if (array_key_exists("password", $body["user"])) {
                $password = (string)$body["user"]["password"];
            }
        }

        return new self($username, $email, $password);
    }

    /**
     * @return User
     */
    public function toUser(): User
    {
        return User::create($this->username, $this->email, $this->password);
    }
}