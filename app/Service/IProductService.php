<?php
namespace App\Service;
use App\Dto\Info\postInfoDto;

interface IProductService{
    public function getInfos();
    public function getIndex();
    public function getByType($id);
    public function getById($id);
    public function search($keyword);
    public function searchByType($keyword);
    public function searchByBrand($keyword);
    public function create(postInfoDto $info);
    public function createImages($images,$id);
    public function getImages($id);
    public function putImage($images,$id);
    public function putInfo(postInfoDto $newInfo);
}
