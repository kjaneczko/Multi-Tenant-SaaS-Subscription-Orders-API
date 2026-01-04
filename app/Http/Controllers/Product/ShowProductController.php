<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Application\Common\UseCaseExecutor;
use App\Application\Product\Command\ShowProductCommand;
use App\Application\Product\Handler\ShowProductHandler;
use App\Domain\Product\ProductId;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowProductController extends Controller
{
    public function __construct(
        private readonly UseCaseExecutor $executor,
    ) {}

    /**
     * @throws \Throwable
     */
    public function __invoke(
        string $id,
        ShowProductHandler $handler,
    ): JsonResponse {
        $command = new ShowProductCommand(new ProductId($id));

        $product = $this->executor->run($command, fn () => ($handler)($command));

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_OK)
        ;
    }
}
