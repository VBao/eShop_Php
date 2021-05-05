<?php


namespace App\Dto\Laptop;


use App\Dto\Info\showInfoDto;

class updateLaptopDto
{
    public showInfoDto $info;
    public showSpecsDto $spec;
    public listSpecsLaptopDto $specList;
    public array $images;
}
