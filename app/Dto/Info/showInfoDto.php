<?php


namespace App\Dto\Info;


use DateTime;

class showInfoDto
{
    public int $id;
    public string $name;
    public string $description;
    public int $guarantee;
    public int $price;
    public int $brand_id;
    public int $type_id;
    public DateTime $created_at;
    public DateTime $updated_at;

}
