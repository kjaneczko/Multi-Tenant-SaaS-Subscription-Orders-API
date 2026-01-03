<?php

namespace App\Http\Controllers\AuditLog;

use App\Application\AuditLog\AuditLogService;
use App\Application\AuditLog\Command\CreateAuditLogCommand;
use App\Domain\AuditLog\EntityType;
use App\Domain\MetaJsonString;
use App\Domain\Tenant\TenantId;
use App\Domain\User\UserId;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateAuditLogController extends Controller
{
    public function __invoke(
        Request $request,
        AuditLogService $service,
    ): JsonResponse
    {
        $request->validate([
            'actor_user_id' => 'required|string|exists:users,id',
            'action' => 'required',
            'entity_id' => 'required|string',
            'entity_type' => [
                Rule::in(EntityType::values()),
            ],
            'tenant_id' => 'required|string|exists:tenants,id',
            'meta' => 'required|json',
        ]);

        $service->create(new CreateAuditLogCommand(
            tenantId: new TenantId($request->get('tenant_id')),
            actorUserId: new UserId($request->get('actor_user_id')),
            action: $request->get('action'),
            entityType: EntityType::from($request->get('entity_type')),
            entityId: $request->get('entity_id'),
            meta: new MetaJsonString($request->get('meta')),
        ));

        return response()->json()->setStatusCode(Response::HTTP_CREATED);
    }
}
