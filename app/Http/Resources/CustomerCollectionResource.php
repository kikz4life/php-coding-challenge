<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollectionResource extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($customer) {
            return [
                'full_name' => $customer->getFirstName() . ' ' . $customer->getLastName(),
                'email' => $customer->getEmail(),
                'country' => $customer->getCountry(),
            ];
        });
    }
}
