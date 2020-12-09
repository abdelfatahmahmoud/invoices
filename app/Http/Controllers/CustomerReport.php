<?php

namespace App\Http\Controllers;

use App\invoices;
use App\sections;
use Illuminate\Http\Request;

class CustomerReport extends Controller
{
    public function index(){

        $sections = sections::all();
        return view('report.customers_report',compact('sections'));

    }


    public function search_customer(Request $request){


// في حالة البحث بدون التاريخ

        if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {


            $invoices = invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = sections::all();
            return view('report.customers_report',compact('sections'))->withDetails($invoices);


        }


        // في حالة البحث بتاريخ

        else {

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = invoices::whereBetween('invoice_date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = sections::all();
            return view('report.customers_report',compact('sections'))->withDetails($invoices);


        }



    }
}
