<?php

namespace App\Http\Controllers\User;

use App\Application\Shared\Query\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Infrastructure\Database\User\UserPersistenceMapper;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ListUserController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
            'tenant_id' => 'nullable|uuid',
            'role' => 'nullable|string|in:admin,manager,user',
            'is_active' => 'nullable|boolean',
        ]);

        $page = $request->integer('page') ?: 1;
        $limit = $request->integer('limit') ?: 100;

        $query = UserModel::query()->orderByDesc('created_at');

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->string('tenant_id')->toString());
        }

        if ($request->filled('role')) {
            $query->where('role', $request->string('role')->toString());
        }

        if ($request->has('is_active')) {
            $query->where('is_active', (bool) $request->boolean('is_active'));
        }

        $models = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        $users = $models
            ->map(fn (UserModel $m) => UserPersistenceMapper::toDomain($m))
            ->all();

        return (UserResource::collection($users))->response()->setStatusCode(Response::HTTP_OK);
    }
}
