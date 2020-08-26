<?php


namespace App\Repository;


use App\Models\User;
use App\RepositoryContracts\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserRepositoryImpl implements UserRepository
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserRepositoryImpl constructor.
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findByEmail($email): ?Model
    {
        return $this->user
            ->newQuery()
            ->where('email', $email)
            ->first();
    }

    /**
     * @param  array  $userDetails
     * @return User
     */
    public function createUser(array $userDetails): User
    {
        $userDetails = (object)$userDetails;
        $user = new User();
        $user->email = strtolower($userDetails->email);
        $user->name = $userDetails->name;
        $user->password = Hash::make($userDetails->password);
        $user->save();
        return $user;
    }
}
