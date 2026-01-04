<?php

declare(strict_types=1);

namespace App\Http\Controllers\AuditLog;

use App\Application\AuditLog\Command\ShowAuditLogCommand;
use App\Application\AuditLog\Handler\ShowAuditLogHandler;
use App\Application\AuditLog\Interface\AuditLogServiceInterface;
use App\Application\Common\UseCaseExecutor;
use App\Domain\AuditLog\AuditLogId;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowAuditLogController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,)
    {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(
        string $id,
        ShowAuditLogHandler $handler,
    ): JsonResponse {
        $command = new ShowAuditLogCommand(new AuditLogId($id));
        $auditLog = $this->executor->run($command, fn() => ($handler)($command));

        return (new AuditLogResource($auditLog))
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
