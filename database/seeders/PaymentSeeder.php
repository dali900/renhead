<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
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
            Payment::factory(10)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
