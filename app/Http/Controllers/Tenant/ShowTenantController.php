<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Application\Common\UseCaseExecutor;
use App\Application\Tenant\Command\ShowTenantCommand;
use App\Application\Tenant\Handler\ShowTenantHandler;
use App\Domain\Tenant\TenantId;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowTenantController extends Controller
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
        string            $id,
        ShowTenantHandler $handler,
    ): JsonResponse {
        $command = new ShowTenantCommand(new TenantId($id));

        $tenant = $this->executor->run($command, fn() => ($handler)($command));

        return (new TenantResource($tenant))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
