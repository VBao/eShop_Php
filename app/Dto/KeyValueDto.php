<?php
namespace App\Dto;
class KeyValueDto{
    public int $id;
    public String $value;

    /**
     * @param int $id
     * @param String $value
     */
    public function __construct(int $id, string $value)
    {
        $this->id = $id;
        $this->value = $value;
    }


}
