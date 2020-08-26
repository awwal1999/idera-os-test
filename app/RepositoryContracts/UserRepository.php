<?php


namespace App\RepositoryContracts;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserRepository
{
    /**
     * @param $email
     * @return Model | User
     */
    public function findByEmail($email): ?Model;

    /**
     * @param  array  $userDetails
     * @return User
     */
    public function createUser(array $userDetails): User;
}
