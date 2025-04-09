<?php

namespace App\Http\Resources;

use App\Doctrine\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Customer $this */
        return [
            'full_name' => $this->getFirstName() . ' ' . $this->getLastName(),
            'email' => $this->getEmail(),
            'username' => $this->getUsername(),
            'gender' => $this->getGender(),
            'country' => $this->getCountry(),
            'city' => $this->getCity(),
            'phone' => $this->getPhone(),
        ];
    }
}
