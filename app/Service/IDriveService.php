<?php


namespace App\Service;


interface IDriveService
{
    public function getForm();

    public function create($drive, $id);

    public function update($drive);

    public function get($id);

    public function list();

    public function index();

    public function getSpecsAdmin($id);

    public function filter(array $filter);

    public function filterCheck(array $brand_list, array $capacity_list, array $type_list): array;

    public function postFilter(array $brand_list, array $capacity_list, array $type_list, array $price);

}
