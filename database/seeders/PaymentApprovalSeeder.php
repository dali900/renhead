<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['APPROVED', 'REJECTED'];
        $approverIds = User::approver()->get('id')->pluck('id')->toArray();

        $payments = Payment::get();
        foreach ($payments as $payment){
            $approveAll = rand(0,1);
            foreach ($approverIds  as $approverId) {
                $statusIndex = array_rand($statuses);
                $status = $statuses[$statusIndex];
                PaymentApproval::factory(1)->create([
                    'user_id' => $approverId,
                    'status' => $approveAll ? 'APPROVED' : $status,
                    'payment_id' => $payment->id,
                    'payment_type' => Payment::class,
                ]);
            }
        }

        $travelPayments = TravelPayment::get();
        foreach ($travelPayments as $travelPayment){
            $approveAll = rand(0,1);
            foreach ($approverIds  as $approverId) {
                $statusIndex = array_rand($statuses);
                $status = $statuses[$statusIndex];
                PaymentApproval::factory(1)->create([
                    'user_id' => $approverId,
                    'status' => $approveAll ? 'APPROVED' : $status,
                    'payment_id' => $travelPayment->id,
                    'payment_type' => TravelPayment::class,
                ]);
            }
        }
    }
}
