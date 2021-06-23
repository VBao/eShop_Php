<?php

namespace App\Service\Impl;

use App\Service\IValidate;
use Illuminate\Http\Request;

class ValidateImpl implements IValidate
{

    public function checkPost(Request $request): ?array
    {
        if (!isset($request->info) || !isset($request->spec) || !isset($request->image)) {
            $err = 'Missing {';
            if (!isset($request->info)) {
                $err = $err . 'info, ';
            }
            if (!isset($request->spec)) {
                $err = $err . 'spec, ';
            }
            if (!isset($request->image)) {
                $err = $err . 'image, ';
            }
            $err = trim($err, ', ');
            return ['error' => $err . '} component'];
        } else {
            return null;
        }
    }
}
