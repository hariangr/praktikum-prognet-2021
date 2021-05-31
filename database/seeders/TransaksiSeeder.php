<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $id_user = DB::table('users')->pluck('id');
        $id_kurir = DB::table('couriers')->pluck('id');

        for($i=10;$i<=100;$i++){
            $create_transaction = DB::table('transactions')->insert([
                'id' => $i,
                'timeout' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
                'address' => $faker->address,
                'regency' => 'denpasar',
                'province' => 'bali',
    			'total' => $faker->numberBetween($min = 25000, $max = 200000),
                'shipping_cost' => $faker->numberBetween($min = 25000, $max = 200000),
                'sub_total' => $faker->numberBetween($min = 25000, $max = 200000),
                'user_id' => $faker->randomElement($id_user),
                'courier_id' => $faker->randomElement($id_kurir),
                'proof_of_payment' => '',
                'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
                'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
                'status' => 'success',
    		]);
            
            $id_produk = DB::table('products')->pluck('id');

            DB::table('transaction_details')->insert([
                'id' => $i,
                'transaction_id' => $i,
                'product_id' => $faker->randomElement($id_produk),
                'qty' => $faker->numberBetween($min = 1, $max = 50),
                'discount' => $faker->numberBetween($min = 25000, $max = 50000),
                'selling_price' => $faker->numberBetween($min = 25000, $max = 200000),
    			'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
                'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
    		]);
        }
    }
}
