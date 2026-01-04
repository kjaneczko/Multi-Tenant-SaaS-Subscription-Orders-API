<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Application\Common\Query\PageRequest;
use App\Application\Common\UseCaseExecutor;
use App\Application\User\Command\ListUserCommand;
use App\Application\User\Handler\ListUserHandler;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListUserController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        ListUserHandler $handler,
    ): JsonResponse {
        $request->validate([
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:100',
            'tenant_id' => 'sometimes|uuid',
            'role' => [
                'sometimes',
                'string',
                Rule::in(UserRole::values()),
            ],
            'is_active' => 'sometimes|boolean',
        ]);

        $pageRequest = new PageRequest(
            page: $request->integer('page', 1),
            limit: $request->integer('limit', 25),
        );

        $tenantId = $request->filled('tenant_id')
            ? new TenantId($request->string('tenant_id')->toString())
            : null;

        $role = $request->filled('role')
            ? UserRole::from($request->string('role')->toString())
            : null;

        $isActive = $request->has('is_active')
            ? $request->boolean('is_active')
            : null;

        $command = new ListUserCommand(
            pageRequest: $pageRequest,
            tenantId: $tenantId,
            role: $role,
            isActive: $isActive,
        );

        $users = $this->executor->run($command, fn () => ($handler)($command));

        return UserResource::collection($users)
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
