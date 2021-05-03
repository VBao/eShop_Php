<?php


namespace App\Service;


use App\Dto\Laptop\postLaptopDto;

interface ILaptopService
{
    public function getSpecsIndex(int $id);
    public function getList();
    public function getSpecs(int $lapId);
    public function update();
    public function getForm();
    public function create(postLaptopDto $lap);
}
