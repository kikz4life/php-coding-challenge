<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Doctrine\Customer;
use App\Exceptions\CustomerImportException;

class CustomerImporterService
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected RandomUserApiService $api
    ) {}

    /**
     * @throws CustomerImportException
     */
    public function import(int $count): int
    {
        try {
            $customers = $this->api->fetchCustomers($count);
            $importedCount = 0;

            foreach ($customers as $data) {
                $email = $data['email'];

                $existing = $this->em->getRepository(Customer::class)->findOneBy(['email' => $email]);

                $customer = $existing ?? new Customer();

                $customer->setFirstName($data['name']['first']);
                $customer->setLastName($data['name']['last']);
                $customer->setEmail($email);
                $customer->setUsername($data['login']['username']);
                $customer->setGender($data['gender']);
                $customer->setCountry($data['location']['country']);
                $customer->setCity($data['location']['city']);
                $customer->setPhone($data['phone']);
                $customer->setPassword(md5($data['login']['password']));

                $this->em->persist($customer);
                $importedCount++;
            }

            $this->em->flush();

            return $importedCount;
        } catch (\Exception $e) {
            throw new CustomerImportException('Customer import failed: ' . $e->getMessage());
        }

    }
}
