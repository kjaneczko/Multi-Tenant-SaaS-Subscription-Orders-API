<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Application\Common\Query\PageRequest;
use App\Application\Tenant\Command\ListTenantCommand;
use App\Application\Tenant\Interface\TenantServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ListTenantController extends Controller
{
    public function __invoke(
        Request $request,
        TenantServiceInterface $service,
    ): JsonResponse {
        $request->validate([
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
        ]);

        $page = $request->integer('page') ?: 1;
        $limit = $request->integer('limit') ?: 1000;

        $tenants = $service->list(new ListTenantCommand(new PageRequest($page, $limit)));

        return TenantResource::collection($tenants)->response()->setStatusCode(Response::HTTP_OK);
    }
}
