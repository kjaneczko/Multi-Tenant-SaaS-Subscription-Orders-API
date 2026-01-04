<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Application\Tenant\Command\CreateTenantCommand;
use App\Application\Tenant\Interface\TenantServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateTenantController extends Controller
{
    public function __invoke(
        Request $request,
        TenantServiceInterface $service,
    ): JsonResponse {
        $request->validate([
            'name' => 'required|string|min:1|max:255',
        ]);

        $command = new CreateTenantCommand(
            name: $request->get('name'),
        );

        $tenant = $service->create($command);

        return (new TenantResource($tenant))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
