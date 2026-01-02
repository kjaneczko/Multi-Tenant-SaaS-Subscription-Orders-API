<?php

namespace App\Http\Controllers\User;

use App\Application\User\Interface\UserRepositoryInterface;
use App\Domain\User\UserId;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowUserController extends Controller
{
    public function __invoke(
        string $id,
        UserRepositoryInterface $users,
    ): JsonResponse {
        $user = $users->getById(new UserId($id));

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_OK);
    }
}
