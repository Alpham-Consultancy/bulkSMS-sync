<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       // private $api_id = "API22696046255";



    public function customers($id)
    {
        //
        $customers = User::where('user_id', $id)->get();

        $response = [
            'message' => 'customers ',
            'customers' => $customers,
        ];
        
        return response($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadCustomers(Request $request, $id)
    {
        //
        $request->validate([
              'file' => 'required|mimes:ods,xlx,csv|max:5048',
        ]);

        

    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function sendSMS(Request $request, $id)
    {
        //
        $request->validate([
            'message' => 'required',
         ]);
             
     

     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
