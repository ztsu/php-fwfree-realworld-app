<?php

namespace Realworld\App\Handler\ProfilesFollowings\Post;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Realworld\Domain\Model\UserAuthToken;
use Realworld\App\Common\ResponseDto\ProfileResponseDto;
use Realworld\App\Handler\Exception\UnauthorizedRequestException;
use Realworld\App\Handler\HandlerInterface;
use Realworld\App\Middleware\AuthMiddleware;
use Realworld\Domain\Repository\UsersRepositoryInterface;
use Realworld\Domain\Service\FollowUserByUsernameService;

/**
 * Handles POST /api/profiles/:username/follow
 */
class ProfilesFollowingsPostHandler implements HandlerInterface
{
    /**
     * @var FollowUserByUsernameService
     */
    private $service;

    /**
     * @var UsersRepositoryInterface
     */
    private $users;

    public function __construct(
        FollowUserByUsernameService $service,
        UsersRepositoryInterface $users
    ) {
        $this->service = $service;
        $this->users = $users;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws UnauthorizedRequestException
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        /**
         * @var $encodedToken UserAuthToken
         */
        $token = $request->getAttribute(AuthMiddleware::ATTR_NAME);
        if ($token == null) {
            throw new UnauthorizedRequestException();
        }

        $follower = $this->users->getByName($token->name);

        $dto = RequestDto::create($request);

        $following = $this->service->run($dto->username, $follower->id);

        $user = $this->users->getById($following->followedUserId);

        $respDto = new ResponseDto(ProfileResponseDto::create($user, true));

        $respDto->writeTo($response);

        return $response;
    }
}