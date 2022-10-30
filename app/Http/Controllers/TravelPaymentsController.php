<?php

namespace App\Http\Controllers;

use App\Models\TravelPayment;
use Illuminate\Http\Request;
use App\Http\Resources\TravelPaymentResource;
use App\Http\Resources\TravelPaymentResourcePaginated;

class TravelPaymentsController extends Controller
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
            'total_amount' => 'required|numeric',
        ]);

        $data = $request->only(['user_id', 'total_amount']);
        $travelPayment = TravelPayment::create($data);
        if(!$travelPayment){
            return $this->responseErrorCreatingModel();
        }

        return $this->responseSuccess([
            'travel_payment' => TravelPaymentResource::make($travelPayment)
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
        $travelPayment = TravelPayment::find($id);
        if(!$travelPayment){
            return $this->responseNotFound();
        }

        return $this->responseSuccess([
            'travel_payment' => TravelPaymentResource::make($travelPayment)
        ]);
    }

    /**
     * Display resource collection.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPayments()
    {
        $travelPayments = TravelPayment::all();

        return $this->responseSuccess([
            'payments' => TravelPaymentResourcePaginated::collection($travelPayments)
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
        $travelPayment = TravelPayment::find($id);
        if(!$travelPayment){
            return $this->responseNotFound();
        }

        $request->validate([
            'user_id' => 'sometimes|required|numeric',
            'total_amount' => 'sometimes|required|numeric',
        ]);

        $data = $request->only(['user_id', 'total_amount']);
        $updated = $travelPayment->update($data);
        if(!$updated){
            return $this->responseErrorCreatingModel();
        }

        return $this->responseSuccess([
            'travel_payment' => TravelPaymentResource::make($travelPayment)
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
        $travelPayment = TravelPayment::find($id);
        if(!$travelPayment){
            return $this->responseNotFound();
        }

        if(!$travelPayment->delete()){
            return $this->responseErrorDeletingModel();
        }

        return $this->responseSuccess();
    }
}
