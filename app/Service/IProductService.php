<?php
namespace App\Service;
use App\Dto\Info\postInfoDto;

interface IProductService{
    public function getInfos();
    public function getIndex();
    public function create(postInfoDto $info);
    public function createImages($images,$id);
}
