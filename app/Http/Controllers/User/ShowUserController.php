<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Application\User\UserExecutor;
use App\Domain\User\UserId;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowUserController extends Controller
{
    public function __invoke(
        string $id,
        UserExecutor $executor,
    ): JsonResponse {
        $user = $executor->getByIdOrFail(new UserId($id));

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_OK);
    }
}
