<?php

namespace App\Http\Controllers\AuditLog;

use App\Application\AuditLog\AuditLogService;
use App\Application\AuditLog\Command\ListAuditLogCommand;
use App\Application\Shared\Query\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListAuditLogController extends Controller
{
    public function __invoke(
        Request $request,
        AuditLogService $service,
    ): JsonResponse
    {
        $request->validate([
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
        ]);

        $page = $request->integer('page') ?: 1;
        $limit = $request->integer('limit') ?: 1000;

        $auditLogs = $service->list(new ListAuditLogCommand(
            pageRequest: new PageRequest(page: $page, limit: $limit),
        ));

        return AuditLogResource::collection($auditLogs)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
