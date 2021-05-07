<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Service\IProductService;
use Illuminate\Http\Request;

class InfoController extends Controller
{

    private IProductService $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }
//
//    public function list( $getType,$page = 1)
//    {
//        return response()->json(array_slice($this->infos->getInfosFull(), 15 * ($page - 1), 15),200);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->productService->getIndex();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search($keywords)
    {
        return response()->json($this->productService->search($keywords));
    }

}
