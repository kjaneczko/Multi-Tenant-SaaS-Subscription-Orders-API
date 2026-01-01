<?php

namespace App\Http\Resources;

use App\Domain\User\User;
use App\Infrastructure\Database\User\UserPersistenceMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @property User $resource
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;

        return UserPersistenceMapper::toPersistence($user);
    }
}
