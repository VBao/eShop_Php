<?php

namespace App\Http\Controllers;

use App\Dto\FullLaptopModel;
use App\Http\Resources\ShowListResource;
use App\Service\ILaptopService;
use App\Service\IProductService;

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
}
