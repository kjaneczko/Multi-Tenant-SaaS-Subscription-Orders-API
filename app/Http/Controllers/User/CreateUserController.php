<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Application\Common\Interface\PasswordHashGeneratorInterface;
use App\Application\Common\UseCaseExecutor;
use App\Application\User\Command\CreateUserCommand;
use App\Application\User\Handler\CreateUserHandler;
use App\Domain\Email;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateUserController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        CreateUserHandler $handler,
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

        $user = $this->executor->run($command, fn () => ($handler)($command));

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
