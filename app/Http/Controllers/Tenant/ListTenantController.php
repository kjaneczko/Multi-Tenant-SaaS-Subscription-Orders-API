<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Application\Common\Query\PageRequest;
use App\Application\Common\UseCaseExecutor;
use App\Application\Tenant\Command\ListTenantCommand;
use App\Application\Tenant\Handler\ListTenantHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ListTenantController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        ListTenantHandler $handler,
    ): JsonResponse {
        $request->validate([
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
        ]);

        $page = $request->integer('page') ?: 1;
        $limit = $request->integer('limit') ?: 1000;

        $command = new ListTenantCommand(new PageRequest($page, $limit));

        $tenants = $this->executor->run($command, fn () => ($handler)($command));

        return TenantResource::collection($tenants)->response()->setStatusCode(Response::HTTP_OK);
    }
}
