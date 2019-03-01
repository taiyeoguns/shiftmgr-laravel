<?php

namespace App\Services;

use App\Repositories\UserRepository;

class ShiftService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
}
