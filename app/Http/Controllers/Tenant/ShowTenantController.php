<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Application\Tenant\TenantExecutor;
use App\Domain\Tenant\TenantId;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowTenantController extends Controller
{
    public function __invoke(
        string $id,
        TenantExecutor $executor,
    ): JsonResponse {
        $tenant = $executor->getByIdOrFail(new TenantId($id));

        return (new TenantResource($tenant))
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
