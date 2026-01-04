<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Application\Common\UseCaseExecutor;
use App\Application\Tenant\Command\CreateTenantCommand;
use App\Application\Tenant\Handler\CreateTenantHandler;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateTenantController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        Request $request,
        CreateTenantHandler $handler,
    ): JsonResponse {
        $request->validate([
            'name' => 'required|string|min:1|max:255',
        ]);

        $command = new CreateTenantCommand(
            name: $request->get('name'),
        );

        $tenant = $this->executor->run($command, fn () => ($handler)($command));

        return (new TenantResource($tenant))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
