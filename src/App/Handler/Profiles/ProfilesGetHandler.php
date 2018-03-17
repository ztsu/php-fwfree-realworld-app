<?php

namespace Realworld\App\Handler\Profiles;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Realworld\App\Common\ResponseDto\ProfileResponseDto;
use Realworld\App\Handler\HandlerInterface;
use Realworld\Domain\Exception\DomainExceptionInterface;
use Realworld\Domain\Service\CheckUserFollowedByUserService;

/**
 * Handles GET /api/profiles/:username
 */
class ProfilesGetHandler implements HandlerInterface
{
    /**
     * @var CheckUserFollowedByUserService
     */
    private $service;

    /**
     * @param CheckUserFollowedByUserService $service
     */
    public function __construct(CheckUserFollowedByUserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $req = RequestDto::create($request);

        try {
            $following = $this->service->check($req->username, 0);

        } catch (DomainExceptionInterface $exception) {
            $following = false;
        }

        $profile = new ProfileResponseDto("", "", "", $following);

        $response = (new ResponseDto($profile))->writeTo($response);

        return $response;
    }

}

