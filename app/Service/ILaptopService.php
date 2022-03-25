<?php


namespace App\Service;


use App\Dto\Laptop\postLaptopDto;

interface ILaptopService
{
    public function getSpecsIndex(int $id);

    public function getList();

    public function getSpecs(int $lapId, bool $update = false);

    public function update();

    public function getForm();

    public function create(postLaptopDto $lap);

    public function putLaptop(postLaptopDto $lap);

    public function getSpecsAdmin(int $id);

    public function filter(array $filter);

    public function index();

    public function filterCheck(array $brand_id_list, array $ram_id_list, array $screen_id_list, array $cpu_id_list): array;

    public function postFilter(array $brand_id_list, array $ram_list, array $screen_list, array $cpu_list, array $price, string $search = null);
}
