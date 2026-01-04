<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Application\Common\UseCaseExecutor;
use App\Application\User\Command\ShowUserCommand;
use App\Application\User\Handler\ShowUserHandler;
use App\Domain\User\UserId;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowUserController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        string $id,
        ShowUserHandler $handler,
    ): JsonResponse {
        $command = new ShowUserCommand(new UserId($id));

        $user = $this->executor->run($command, fn () => ($handler)($command));

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_OK);
    }
}
