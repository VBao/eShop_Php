<?php


namespace App\Service;


use App\Dto\Laptop\postLaptopDto;

interface ILaptopService
{
    public function getSpecsIndex(int $id);
    public function getList();
    public function getSpecs(int $lapId,bool $update);
    public function update();
    public function getForm();
    public function create(postLaptopDto $lap);
    public function putLaptop(postLaptopDto $lap);
    public function getSpecsAdmin(int $id);
    public function filter(array $filter);
    public function index();
}
