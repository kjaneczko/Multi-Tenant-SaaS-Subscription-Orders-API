<?php

namespace App\Http\Controllers\AuditLog;

use App\Application\AuditLog\Command\ShowAuditLogCommand;
use App\Application\AuditLog\Interface\AuditLogServiceInterface;
use App\Domain\AuditLog\AuditLogId;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowAuditLogController extends Controller
{
    public function __invoke(
        string $id,
        AuditLogServiceInterface $service,
    ): JsonResponse
    {
        $auditLog = $service->show(new ShowAuditLogCommand(new AuditLogId($id)));

        return (new AuditLogResource($auditLog))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
