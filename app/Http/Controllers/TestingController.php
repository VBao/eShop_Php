<?php

namespace App\Http\Controllers;

use App\Dto\FullLaptopModel;
use App\Http\Resources\ShowListResource;
use App\Models\Product\Laptop\laptopSpec;
use App\Service\ILaptopService;
use App\Service\IProductService;
use Illuminate\Http\Request;


class TestingController extends Controller
{
    private IProductService $info;
    private ILaptopService $laptop;

    /**
     * TestingControler constructor.
     * @param IProductService $info
     * @param ILaptopService $laptop
     */
    public function __construct(IProductService $info, ILaptopService $laptop)
    {
        $this->info = $info;
        $this->laptop = $laptop;
    }

    public function testing()
    {
        return response()->json(new ShowListResource(new FullLaptopModel(2)));
    }
    public function testing1($keywords)
    {
        return response()->json($this->info->search($keywords));
    }
    public function testing2($request)
    {
        return response()->json($this->info->search($request));
    }
    public function testing3()
    {
        $lap = laptopSpec::where('id', 21)->get(['cpu_id','ram_id','rom_id'])->first();

        return response()->json($lap->cpu_id);
    }
    public function testing4(Request $request)
    {
        if ($request->laptop)
        return response()->json($request);
    }
}
