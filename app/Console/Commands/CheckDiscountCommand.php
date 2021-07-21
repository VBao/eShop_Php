<?php

namespace App\Console\Commands;

use App\Models\Product\productInfo;
use App\Models\ProductDiscount;
use Illuminate\Console\Command;

class CheckDiscountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if discount is turn off or not';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = productInfo::all();
        foreach ($products as $product) {
            $discounts = ProductDiscount::query()->where('product_id', '=', $product->id)->get();
            if ($discounts == null) continue;
            $start_max = null;
            $checkDiscount = null;
            foreach ($discounts as $discount) {
                if ($start_max == null) {
                    $start_max = $discount->start_date;
                }
                if ($discount->start_date < now() && $discount->start_date >= $start_max) {
                    $start_max = $discount->start_date;
                    $checkDiscount = $discount;
                }
            }
            if ($checkDiscount != null) {
                error_log($checkDiscount->end_date > now());
                $product->discount = $checkDiscount->end_date > now();
                $product->save();
            }
        }
    }
}
