<?php

namespace App\Http\Resources\Account;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class ListUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'gender' => $this->gender,
            'is_admin' => (bool)$this->is_admin,
            'order' => Order::where('user_id', '=', $this->id)->count()];
    }
}
