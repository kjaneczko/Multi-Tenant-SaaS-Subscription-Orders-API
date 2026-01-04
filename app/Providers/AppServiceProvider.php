<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Context\Interface\RequestContextProviderInterface;
use App\Application\Common\Interface\PasswordHashGeneratorInterface;
use App\Application\Common\Interface\SlugGeneratorInterface;
use App\Application\Common\Interface\UuidGeneratorInterface;
use App\Domain\AuditLog\Interface\AuditLogQueryInterface;
use App\Domain\AuditLog\Interface\AuditLogWriterInterface;
use App\Domain\Payment\Interface\PaymentQueryInterface;
use App\Domain\Payment\Interface\PaymentRepositoryInterface;
use App\Domain\Product\Interface\ProductQueryInterface;
use App\Domain\Product\Interface\ProductRepositoryInterface;
use App\Domain\Tenant\Interface\TenantQueryInterface;
use App\Domain\Tenant\Interface\TenantRepositoryInterface;
use App\Domain\User\Interface\UserQueryInterface;
use App\Domain\User\Interface\UserRepositoryInterface;
use App\Infrastructure\Context\LaravelRequestContextProvider;
use App\Infrastructure\Database\AuditLog\AuditLogQueryEloquent;
use App\Infrastructure\Database\AuditLog\AuditLogWriterEloquent;
use App\Infrastructure\Database\Payment\PaymentQueryEloquent;
use App\Infrastructure\Database\Payment\PaymentRepositoryEloquent;
use App\Infrastructure\Database\Product\ProductQueryEloquent;
use App\Infrastructure\Database\Product\ProductRepositoryEloquent;
use App\Infrastructure\Database\Tenant\TenantQueryEloquent;
use App\Infrastructure\Database\Tenant\TenantRepositoryEloquent;
use App\Infrastructure\Database\User\UserQueryEloquent;
use App\Infrastructure\Database\User\UserRepositoryEloquent;
use App\Infrastructure\PasswordHashGenerator;
use App\Infrastructure\SlugGenerator;
use App\Infrastructure\UuidGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->bind(SlugGeneratorInterface::class, SlugGenerator::class);
        $this->app->bind(PasswordHashGeneratorInterface::class, PasswordHashGenerator::class);

        $this->app->bind(AuditLogQueryInterface::class, AuditLogQueryEloquent::class);
        $this->app->bind(AuditLogWriterInterface::class, AuditLogWriterEloquent::class);

        $this->app->bind(TenantRepositoryInterface::class, TenantRepositoryEloquent::class);
        $this->app->bind(TenantQueryInterface::class, TenantQueryEloquent::class);

        $this->app->bind(ProductRepositoryInterface::class, ProductRepositoryEloquent::class);
        $this->app->bind(ProductQueryInterface::class, ProductQueryEloquent::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepositoryEloquent::class);
        $this->app->bind(UserQueryInterface::class, UserQueryEloquent::class);

        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepositoryEloquent::class);
        $this->app->bind(PaymentQueryInterface::class, PaymentQueryEloquent::class);

        $this->app->bind(RequestContextProviderInterface::class, LaravelRequestContextProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
