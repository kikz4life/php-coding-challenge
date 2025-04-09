<?php

namespace App\Http\Controllers;

use App\Doctrine\Customer;
use App\Http\Resources\CustomerCollectionResource;
use App\Http\Resources\CustomerResource;
use Doctrine\ORM\EntityManagerInterface;

class CustomerController extends Controller
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(): CustomerCollectionResource
    {
        $customers = $this->entityManager
            ->getRepository(Customer::class)
            ->findAll();

        return new CustomerCollectionResource($customers);
    }

    public function show($id): CustomerResource|\Illuminate\Http\JsonResponse
    {
        $customer = $this->entityManager
            ->getRepository(Customer::class)
            ->find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return new CustomerResource($customer);
    }
}
