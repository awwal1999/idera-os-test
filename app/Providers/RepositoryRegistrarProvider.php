<?php


namespace App\Providers;


use App\Repository\CinemaRepositoryImpl;
use App\Repository\CinemaShowRepositoryImpl;
use App\Repository\ShowRepositoryImpl;
use App\Repository\UserRepositoryImpl;
use App\RepositoryContracts\CinemaRepository;
use App\RepositoryContracts\CinemaShowRepository;
use App\RepositoryContracts\ShowRepository;
use App\RepositoryContracts\UserRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryRegistrarProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        UserRepository::class => UserRepositoryImpl::class,
        ShowRepository::class => ShowRepositoryImpl::class,
        CinemaRepository::class => CinemaRepositoryImpl::class,
        CinemaShowRepository::class => CinemaShowRepositoryImpl::class
    ];

    public function provides()
    {
        return array_keys($this->singletons);
    }
}
