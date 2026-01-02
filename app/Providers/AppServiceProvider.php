<?php

namespace App\Providers;

use App\Application\AuditLog\AuditLogService;
use App\Application\AuditLog\Interface\AuditLogServiceInterface;
use App\Application\Product\Interface\ProductRepositoryInterface;
use App\Application\Shared\Interface\PasswordHashGeneratorInterface;
use App\Application\Shared\Interface\SlugGeneratorInterface;
use App\Application\Shared\Interface\UuidGeneratorInterface;
use App\Application\Tenant\Interface\TenantServiceInterface;
use App\Application\Tenant\TenantService;
use App\Application\User\Interface\UserRepositoryInterface;
use App\Domain\AuditLog\Interface\AuditLogQueryInterface;
use App\Domain\AuditLog\Interface\AuditLogWriterInterface;
use App\Domain\Tenant\Interface\TenantRepositoryInterface;
use App\Infrastructure\Database\AuditLog\AuditLogQueryEloquent;
use App\Infrastructure\Database\AuditLog\AuditLogWriterEloquent;
use App\Infrastructure\Database\Product\ProductRepositoryEloquent;
use App\Infrastructure\Database\Tenant\TenantRepositoryEloquent;
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
    public function register(): void {
        $this->app->bind(UuidGeneratorInterface::class, UuidGenerator::class);
        $this->app->bind(SlugGeneratorInterface::class, SlugGenerator::class);
        $this->app->bind(PasswordHashGeneratorInterface::class, PasswordHashGenerator::class);

        $this->app->bind(AuditLogServiceInterface::class, AuditLogService::class);
        $this->app->bind(AuditLogQueryInterface::class, AuditLogQueryEloquent::class);
        $this->app->bind(AuditLogWriterInterface::class, AuditLogWriterEloquent::class);

        $this->app->bind(TenantServiceInterface::class, TenantService::class);
        $this->app->bind(TenantRepositoryInterface::class, TenantRepositoryEloquent::class);

        $this->app->bind(ProductRepositoryInterface::class, ProductRepositoryEloquent::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
