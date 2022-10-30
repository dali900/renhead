<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentApprovalResource;
use App\Http\Resources\PaymentApprovalResourcePaginated;
use App\Models\PaymentApproval;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentApprovalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getApprovals(Request $request)
    {
        $paymentApproval = PaymentApproval::paginate($request->perPage ?? 100);

        return $this->responseSuccess([
            'payments' => PaymentApprovalResourcePaginated::make($paymentApproval)
        ]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getApproval($id)
    {
        $paymentApproval = PaymentApproval::find($id);
        if(!$paymentApproval){
            return $this->responseNotFound();
        }
    
        return $this->responseSuccess([
            'payment' => PaymentApprovalResource::make($paymentApproval)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'payment_type' => 'required|string',
            'payment_id' => 'required|numeric',
            'status' => 'required|string|in:APPROVED,REJECTED',
        ]);

        $data = $request->only(['user_id', 'payment_type', 'payment_id', 'status']);
        $paymentApproval = PaymentApproval::create($data);
        if(!$paymentApproval){
            return $this->responseErrorCreatingModel();
        }
        //$paymentApproval->load('paymentable');
        return $this->responseSuccess([
            'payment' => PaymentApprovalResource::make($paymentApproval)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $paymentApproval = PaymentApproval::find($id);
        if(!$paymentApproval){
            return $this->responseNotFound();
        }

        $request->validate([
            'user_id' => 'required|numeric',
            'payment_type' => 'required|string',
            'payment_id' => 'required|numeric',
            'status' => 'required|string|in:APPROVED,REJECTED',
        ]);

        $data = $request->only(['user_id', 'payment_type', 'payment_id', 'status']);
        $updated = $paymentApproval->update($data);
        if(!$updated){
            return $this->responseErrorCreatingModel();
        }

        return $this->responseSuccess([
            'payment' => PaymentApprovalResource::make($paymentApproval)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentApproval = PaymentApproval::find($id);
        if(!$paymentApproval){
            return $this->responseNotFound();
        }

        if(!$paymentApproval->delete()){
            return $this->responseErrorDeletingModel();
        }

        return $this->responseSuccess();
    }

    /**
     * Get approved payments report
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserApprovedPayments()
    {
        $approvers = User::with(['paymentApprovals' => function ($query) {
            $query->approved();
        }, 'paymentApprovals.paymentable'])->approver()->get();

        $userReport = [];
        foreach($approvers as $approver){
            $sum = 0;
            foreach($approver->paymentApprovals as $paymentApproval){
                $paymentable = $paymentApproval->payment;
                if($paymentable){
                    $sum += $paymentable->total_amount;
                }
            }
            $userReport[] = [
                'user_id' => $approver->id,
                'user_name' => $approver->first_name.' '.$approver->last_name,
                'sum' => $sum,
            ];
        }

        return $userReport;
    }
}
