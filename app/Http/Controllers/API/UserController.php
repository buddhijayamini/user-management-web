<?php

namespace App\Http\Controllers\API;

use App\Classes\ApiCatchErrors;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\Common\ErrorResponse;
use App\Http\Resources\Common\SuccessResponse;
use App\Http\Resources\LoginResource;
use App\Repositories\User\UserInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function login(UserLoginRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $data =  $this->userInterface->login($data);
            DB::commit();
            if (!isset($data->token)){
                return (new ErrorResponse(['message' => $data->message]))->response()->setStatusCode(422);
            }
            $data = new LoginResource($data);
            return new SuccessResponse(
            [
                'data' => $data
            ]);
        } catch (Exception $e) {
            ApiCatchErrors::rollback($e);
        }
    }

    public function logOut()
    {
        $user = Auth::user()->token();
        $user->revoke();

        return new SuccessResponse(['massage'=>'logout successfully']);
    }
}
