<?php


namespace App\Service;


interface IDriveService
{
    public function getForm();
    public function create($drive,$id);
    public function update($drive);
    public function get($id);
    public function list();
    public function index();
    public function filter(array $filter);

}
