<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TravelPayment;
use Illuminate\Database\Seeder;

class TravelPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::regular()->get();
        foreach ($users as $user){
            TravelPayment::factory(10)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
