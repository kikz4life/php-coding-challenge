<?php

namespace Tests\Unit;

use App\Exceptions\CustomerImportException;
use App\Services\CustomerImporterService;
use App\Services\RandomUserApiService;
use Doctrine\ORM\EntityManagerInterface;
use App\Doctrine\Customer;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CustomerImporterServiceTest extends TestCase
{
    public function test_successfully_import_customers()
    {
        $fakeResponse = [
            'results' => [
                [
                    'name' => ['first' => 'John', 'last' => 'Doe'],
                    'email' => 'john@example.com',
                    'login' => ['username' => 'johndoe', 'password' => 'password123'],
                    'gender' => 'male',
                    'location' => ['country' => 'Australia', 'city' => 'Sydney'],
                    'phone' => '123456789',
                ]
            ]
        ];

        Http::fake([
            '*' => Http::response($fakeResponse, 200)
        ]);

        $api = new RandomUserApiService();

        $em = $this->createMock(EntityManagerInterface::class);

        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Customer::class));

        $em->expects($this->once())
            ->method('flush');

        $service = new CustomerImporterService($em, $api);

        // Act
        $count = $service->import(1);

        // Assert
        $this->assertEquals(1, $count);
    }

    public function test_api_failure_throws_exception()
    {
        Http::fake([
            '*' => Http::response([], 500)
        ]);

        $api = new RandomUserApiService();
        $em = $this->createMock(EntityManagerInterface::class);

        $service = new CustomerImporterService($em, $api);

        $this->expectException(CustomerImportException::class);
        $this->expectExceptionMessage('Customer import failed: API request failed.');

        $service->import(1);
    }

    public function test_invalid_response_structure_throws_exception()
    {
        Http::fake([
            '*' => Http::response(['unexpected' => 'structure'], 200)
        ]);

        $api = new RandomUserApiService();
        $em = $this->createMock(EntityManagerInterface::class);

        $service = new CustomerImporterService($em, $api);

        $this->expectException(CustomerImportException::class);

        $service->import(1);
    }
}
