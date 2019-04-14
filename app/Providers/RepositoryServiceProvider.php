<?php

namespace App\Providers;

use App\Repositories\ManagerRepository;
use App\Repositories\ManagerRepositoryEloquent;
use App\Repositories\MemberRepository;
use App\Repositories\MemberRepositoryEloquent;
use App\Repositories\ShiftRepository;
use App\Repositories\ShiftRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserRepository::class => UserRepositoryEloquent::class,
        ShiftRepository::class => ShiftRepositoryEloquent::class,
        ManagerRepository::class => ManagerRepositoryEloquent::class,
        MemberRepository::class => MemberRepositoryEloquent::class,
    ];
}
