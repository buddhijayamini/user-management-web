<?php

namespace App\Http\Controllers\API;

use App\Classes\ApiCatchErrors;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\Common\ErrorResponse;
use App\Http\Resources\Common\PaginationResource;
use App\Http\Resources\Common\SuccessResponse;
use App\Http\Resources\EmployeeResource;
use App\Repositories\Employee\EmployeeInterface;
use App\Repositories\User\UserInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    protected $employeeInterface, $userInterface;

    public function __construct(EmployeeInterface $employeeInterface, UserInterface $userInterface)
    {
        $this->employeeInterface = $employeeInterface;
        $this->userInterface = $userInterface;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $data = $this->employeeInterface->getPaginated();

        return new SuccessResponse([
            'data' => EmployeeResource::collection($data),
            'pagination' => new PaginationResource($data)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(EmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();
            $this->userInterface->store($validatedData);

            $validatedData['user_id'] = Auth::user()->id;
            if(Auth::user()->id == 1){
                $validatedData['status'] = 1;
            }else{
                $validatedData['status'] = 0;
            }

            if($request->hasFile('profile_image'))
            {
                $file = $request->file('profile_image');
                $filename = $validatedData['user_id'].'.png';//$file->getClientOriginalName()
                $path = $file->storeAs('profiles', $filename);
                $validatedData['profile_image']=json_encode($path);
            }
            
            $data = $this->employeeInterface->store($validatedData);
            DB::commit();

            return new SuccessResponse(
                [
                    'data' => new EmployeeResource($data),
                ],
            );
        } catch (Exception $e) {
            return ApiCatchErrors::rollback($e);
        }
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(int $id)
    {
        try {
            $data = $this->employeeInterface->getById($id);

            return new SuccessResponse(
                [
                    'data' => new EmployeeResource($data),
                ],
            );
        } catch (Exception $e) {
            return ApiCatchErrors::rollback($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(EmployeeRequest $request, int $id)
    {
        DB::beginTransaction();
        try{
                $details = $request->validated();
                $data = $this->employeeInterface->update($id, $details);
                DB::commit();

                if($data){
                    $record = $this->employeeInterface->getById($id);
                    return new SuccessResponse(
                        [
                            'data' => new EmployeeResource($record),
                            'message' => 'Employee updated Successfully.'
                        ],
                    );
                }else{
                    return new ErrorResponse(
                        [
                            'message' => 'Employee can not be Updated.'
                        ],
                    );
                }
        }catch(Exception $e){
            return ApiCatchErrors::rollback($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(int $id)
    {
        DB::beginTransaction();
        try{
            if(Auth::user()->id = 1){
                $data = $this->employeeInterface->destroy($id);
                DB::commit();

                if($data){
                    return new SuccessResponse(
                        [
                            'message' => 'Employee deleted Successfully with Comments.'
                        ],
                    );
                }else{
                    return new ErrorResponse(
                        [
                            'message' => 'Employee can not be Deleted with Comments.'
                        ],
                    );
                }
             }
        }catch(Exception $e){
            return ApiCatchErrors::rollback($e);
        }
    }
}
