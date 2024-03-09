<?php

declare(strict_types=1);

namespace App\Nsign\Question\Domain;

use App\Shared\Nsign\Domain\DisplayName;
use App\Shared\Nsign\Domain\Reputation;
use App\Shared\Nsign\Domain\UserId;
use App\Shared\Nsign\Domain\UserType;

final class Owner
{
    public function __construct(
        private readonly ?UserId $id,
        private readonly ?Reputation $reputation,
        private readonly UserType $userType,
        private readonly ?DisplayName $displayName
    ) {
    }

    public function id(): ?UserId
    {
        return $this->id;
    }

    public function reputation(): ?Reputation
    {
        return $this->reputation;
    }

    public function userType(): UserType
    {
        return $this->userType;
    }

    public function displayName(): ?DisplayName
    {
        return $this->displayName;
    }


}