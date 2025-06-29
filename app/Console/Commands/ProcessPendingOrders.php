<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-pending-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::where('status', Order::STATUS_PENDING)
            ->where('created_at', '<', now()->subHours(24))
            ->update(['status' => Order::STATUS_CANCELLED]);

        $this->info('Pending orders processed successfully.');
        }
}
