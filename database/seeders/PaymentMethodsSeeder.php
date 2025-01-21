<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->delete();

        $payment_methods = [
            "Pay",
            "Quick Pay",
            "Other Online Payments",
            "Draft",
            'View Draft',
            "Online Orders",
            "Pay Later",
            "Recent Transactions",
            "Bank Transfer"
        ];

        foreach ($payment_methods as $payment_method) {
            PaymentMethod::create([
                'name' => $payment_method,
                "is_default" => 1,
                "is_active" => 1
            ]);
        }
    }
}
