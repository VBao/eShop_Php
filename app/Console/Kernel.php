<?php

namespace App\Console;

use App\Models\Product\productInfo;
use App\Models\ProductDiscount;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function (){
            $products = productInfo::where('discount', true)->get();
            if ($products == null) return;
            foreach ($products as $product) {
                $discount = ProductDiscount::query()->where('product_id', '=', $product->id)->first();
                if (strtotime($discount) - strtotime(now()) < 0) {
                    $product->discount = false;
                    $product->save();
                }
            }
        })->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
