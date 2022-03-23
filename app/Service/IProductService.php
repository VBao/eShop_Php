<?php

namespace App\Service;

use App\Dto\Info\postInfoDto;

interface IProductService
{
    public function getInfos();

    public function getIndex();

    public function getByType($id);

    public function getById($id);

    public function searchByType($keyword);

    public function searchByBrand(int $brand_id,string $keyword);

    public function create(postInfoDto $info);

    public function createImages($images, $id);

    public function getImages($id);

    public function putImage($images, $id);

    public function putInfo(postInfoDto $newInfo);

    public function brandIndex();

    public function getStatus();

    public function changeStatus(int $product_id,int $status);

    public function discountGetList();

}
