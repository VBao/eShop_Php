<?php


namespace App\Service;


use Illuminate\Http\Request;

interface IValidate
{
    public function checkPost(Request $request);
}
