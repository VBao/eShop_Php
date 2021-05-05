<?php

namespace App\Http\Controllers;

use App\Dto\Info\postInfoDto;
use App\Dto\Laptop\postLaptopDto;
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

    public function testing(Request $request)
    {
        $res=[];
        $info=new postInfoDto;
        $specs=new postLaptopDto();
        foreach($request->info as $key =>$val) $info->$key=$val;
        $specs->id=$info->id;
        foreach($request->specs as $key =>$val) $specs->$key=$val;
        $res['info']=$this->info->putInfo($info);
        $res['specs']=$this->laptop->putLaptop($specs);
        $res['images']=$this->info->putImage($request->images,$info->id);
        return response()->json(['result'=>'updated']);
    }
}
