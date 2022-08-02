<?php

namespace App\Http\Controllers\API;

use App\Classes\ApiCatchErrors;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\Common\ErrorResponse;
use App\Http\Resources\Common\PaginationResource;
use App\Http\Resources\Common\SuccessResponse;
use App\Http\Resources\CompanyResource;
use App\Repositories\Company\CompanyInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    protected $companyInterface;

    public function __construct(CompanyInterface $companyInterface)
    {
        $this->companyInterface = $companyInterface;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $data = $this->companyInterface->getPaginated();

        return new SuccessResponse([
            'data' => CompanyResource::collection($data),
            'pagination' => new PaginationResource($data)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CompanyRequest $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();

            if($request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $filename = $validatedData['name'].'.png';//$file->getClientOriginalName()
                $path = $file->storeAs('logo', $filename);
                $validatedData['logo']=json_encode($path);
            }

            if($request->hasFile('cover_images'))
         {
            //  $image = $request->file('cover_images');
            //  $paths  = [];
            // foreach($image as $file1){
            //     $filename1 = $validatedData['name'].'-'. $file1->getClientOriginalName();
            //     $paths[] = $file1->storeAs('covers', $filename1);

            // }
            $file1 = $request->file('cover_images');
            $filename1 = $validatedData['name'].'.png';//$file->getClientOriginalName()
            $paths = $file1->storeAs('covers', $filename1);
             $validatedData['cover_images']=json_encode($paths);
        }

            $data = $this->companyInterface->store($validatedData);
            DB::commit();

            return new SuccessResponse(
                [
                    'data' => new CompanyResource($data),
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
            $data = $this->companyInterface->getById($id);

            return new SuccessResponse(
                [
                    'data' => new CompanyResource($data),
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
    public function update(CompanyRequest $request, int $id)
    {
        DB::beginTransaction();
        try{
            if(Auth::user()->id = 1){
                $details = $request->validated();
                $data = $this->companyInterface->update($id, $details);
                DB::commit();

                if($data){
                    $record = $this->companyInterface->getById($id);
                    return new SuccessResponse(
                        [
                            'data' => new CompanyResource($record),
                            'message' => 'Company updated Successfully.'
                        ],
                    );
                }else{
                    return new ErrorResponse(
                        [
                            'message' => 'Company can not be Updated.'
                        ],
                    );
                }
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
                $data = $this->companyInterface->destroy($id);
                DB::commit();

                if($data){
                    return new SuccessResponse(
                        [
                            'message' => 'Company deleted Successfully with Comments.'
                        ],
                    );
                }else{
                    return new ErrorResponse(
                        [
                            'message' => 'Company can not be Deleted with Comments.'
                        ],
                    );
                }
             }
        }catch(Exception $e){
            return ApiCatchErrors::rollback($e);
        }
    }
}
