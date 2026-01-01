<?php
namespace App\Application\AuditLog;

use App\Application\AuditLog\Command\CreateAuditLogCommand;
use App\Application\AuditLog\Command\ListAuditLogCommand;
use App\Application\AuditLog\Command\ShowAuditLogCommand;
use App\Application\AuditLog\Handler\CreateAuditLogHandler;
use App\Application\AuditLog\Handler\ListAuditLogHandler;
use App\Application\AuditLog\Handler\ShowAuditLogHandler;
use App\Application\AuditLog\Interface\AuditLogServiceInterface;
use App\Domain\AuditLog\AuditLog;

final readonly class AuditLogService implements AuditLogServiceInterface
{

    public function __construct(
        private ListAuditLogHandler $list,
        private ShowAuditLogHandler $show,
        private CreateAuditLogHandler $create,
    )
    {
    }

    public function list(ListAuditLogCommand $command): array
    {
        return ($this->list)($command);
    }

    public function create(CreateAuditLogCommand $command): void
    {
        ($this->create)($command);
    }

    public function show(ShowAuditLogCommand $command): AuditLog
    {
        return ($this->show)($command);
    }
}
