<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository.
 */
class UserRepository implements UserInterface
{
    public function store(array $data) : object
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->type = 2;
        $user->save();

        $token = $user->createToken('user_token')->accessToken;

        return (object) ['token' => $token, 'user' => $user];
    }



    /**
     * @return object
     */
    public function login(array $data): object
    {
        $user = User::where('email', $data['email'])->first();

        if ($user == null) {
            return (object) ["message" => 'User does not exist'];
        }

        //check admin or staff
        if($user['type']){
            if($user->type == 1){
                $userType = (object) ["message" => 'User is a admin'];
            }

            if($user->type == 2){
                $userType = (object) ["message" => 'User is a staff'];
            }
        }

            $token = $user->createToken('user_token')->accessToken;

            return (object) [
                'token' => $token,
                'user' => $user,
                'user_type' => $userType,
            ];
    }
}
