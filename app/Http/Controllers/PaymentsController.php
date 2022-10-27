<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;

class PaymentsController extends Controller
{

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
            'total_amount' => 'required|number',
        ]);

        $data = $request->only(['user_id', 'total_amount']);
        $payment = Payment::create($data);
        if(!$payment){
            return $this->responseErrorCreatingModel();
        }

        return $this->responseSuccess([
            'payment' => PaymentResource::make($payment)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPayment($id)
    {
        $payment = Payment::find($id);
        if(!$payment){
            return $this->responseNotFound();
        }

        return $this->responseSuccess([
            'payment' => PaymentResource::make($payment)
        ]);
    }

    /**
     * Display resource collection.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayments()
    {
        $payments = Payment::all();

        return $this->responseSuccess([
            'payments' => PaymentResource::collection($payments)
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
        $payment = Payment::find($id);
        if(!$payment){
            return $this->responseNotFound();
        }

        $request->validate([
            'user_id' => 'sometimes|required|numeric',
            'total_amount' => 'sometimes|required|number',
        ]);

        $data = $request->only(['user_id', 'total_amount']);
        $payment = Payment::update($data);
        if(!$payment){
            return $this->responseErrorCreatingModel();
        }

        return $this->responseSuccess([
            'payment' => PaymentResource::make($payment)
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
        $payment = Payment::find($id);
        if(!$payment){
            return $this->responseNotFound();
        }

        if(!$payment->delete()){
            return $this->responseErrorDeletingModel();
        }

        return $this->responseSuccess();
    }
}
