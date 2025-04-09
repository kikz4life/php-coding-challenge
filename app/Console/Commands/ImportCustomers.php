<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CustomerImporterService;


class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers from randomuser.me';

    public function __construct(protected CustomerImporterService $importer)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting customer import...');

        try {
            $imported = $this->importer->import(
                config('customers.customer_fetch_count')
            );

            $this->info("Successfully imported {$imported} customers");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error importing customers: ' . $e->getMessage());
            return Command::FAILURE;
        }

    }
}
