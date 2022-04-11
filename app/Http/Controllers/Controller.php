<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller
{
//    protected ILaptopService $laptopService;
//    protected IDriveService $driveService;
//
//    /**
//     * @param ILaptopService $laptopService
//     * @param IDriveService $driveService
//     */
//    public function __construct(ILaptopService $laptopService, IDriveService $driveService)
//    {
//        $this->laptopService = $laptopService;
//        $this->driveService = $driveService;
//    }

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="L5 OpenApi",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="darius@matulionis.lt"
     *      ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

//    public function test(Request $request): JsonResponse
//    {
//        $data = $this->driveService->postFilter($request->drive['brand'], $request->drive['capacity'], $request->drive['type'], $request->price, $request->keywords);
//
//        return response()->json($data);
//    }
}
