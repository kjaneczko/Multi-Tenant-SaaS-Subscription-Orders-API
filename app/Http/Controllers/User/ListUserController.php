<?php

namespace App\Http\Controllers\User;

use App\Application\Shared\Query\PageRequest;
use App\Application\User\Interface\UserQueryInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListUserController extends Controller
{
    public function __invoke(Request $request, UserQueryInterface $query): JsonResponse
    {
        $request->validate([
            'page' => 'sometimes|integer|min:1',
            'limit' => 'sometimes|integer|min:1|max:100',
            'tenant_id' => 'sometimes|uuid',
            'role' => 'sometimes|string|in:admin,manager,user',
            'is_active' => 'sometimes|boolean',
        ]);

        $pageRequest = new PageRequest(
            page: $request->integer('page', 1),
            limit: $request->integer('limit', 25),
        );

        $tenantId = $request->filled('tenant_id')
            ? $request->string('tenant_id')->toString()
            : null;

        $role = $request->filled('role')
            ? $request->string('role')->toString()
            : null;

        $isActive = $request->has('is_active')
            ? $request->boolean('is_active')
            : null;

        $users = $query->paginate($pageRequest, $tenantId, $role, $isActive);

        return UserResource::collection($users)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
