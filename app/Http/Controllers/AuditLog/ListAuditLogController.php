<?php

declare(strict_types=1);

namespace App\Http\Controllers\AuditLog;

use App\Application\AuditLog\Command\ListAuditLogCommand;
use App\Application\AuditLog\Handler\ListAuditLogHandler;
use App\Application\Common\UseCaseExecutor;
use App\Application\Common\Query\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ListAuditLogController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    )
    {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        ListAuditLogHandler $handler,
    ): JsonResponse {
        $request->validate([
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
        ]);

        $page = $request->integer('page') ?: 1;
        $limit = $request->integer('limit') ?: 1000;

        $command = new ListAuditLogCommand(
            pageRequest: new PageRequest(page: $page, limit: $limit),
        );

        $auditLogs = $this->executor->run($command, fn() => ($handler)($command));

        return AuditLogResource::collection($auditLogs)
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
