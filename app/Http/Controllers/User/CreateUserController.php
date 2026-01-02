<?php

namespace App\Http\Controllers\User;

use App\Application\Shared\Interface\PasswordHashGeneratorInterface;
use App\Application\User\Command\CreateUserCommand;
use App\Application\User\Handler\CreateUserHandler;
use App\Application\User\Interface\UserRepositoryInterface;
use App\Domain\Email;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use App\Domain\User\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController extends Controller
{
    public function __invoke(
        Request $request,
        CreateUserHandler $handler,
        UserRepositoryInterface $users,
        PasswordHashGeneratorInterface $passwordHash,
    ): JsonResponse {
        $request->validate([
            'tenant_id' => 'required|uuid',
            'name' => 'required|string|min:1|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|string|in:admin,manager,user',
        ]);

        $command = new CreateUserCommand(
            tenantId: new TenantId($request->string('tenant_id')->toString()),
            name: $request->string('name')->toString(),
            email: new Email($request->string('email')->toString()),
            password: $passwordHash->generate($request->string('password')->toString()),
            role: UserRole::from($request->string('role')->toString()),
        );

        $id = $handler($command);

        $user = $users->getById(new UserId($id->toString()));

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
