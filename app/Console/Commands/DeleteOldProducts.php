<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class DeleteOldProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Product::where('status','draft')->delete();
        $this->info('Draft Products Deleted');

    }
}
