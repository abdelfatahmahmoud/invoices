<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\invoices;
use App\invoices_attachments;
use App\invoices_details;
use App\sections;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AddInvoices;

use Maatwebsite\Excel\Facades\Excel;



class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();

        return view('invoices.Add_invoices',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

 // return $request;

        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_commission' => $request->Amount_Commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعه',
            'value_status' => 2,
            'note' => $request->note,

        ]);

        $invoice_id = invoices::latest()->first()->id;

        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoices_number' => $request->invoice_number,
            'products' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);


        if ($request->hasFile('pic')){

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name=$image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoices_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoices_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/'. $invoice_number), $imageName);

        }



        //$user = User::first();
        //$user->notify(new AddInvoice($invoice_id));
       // Notification::send($user, new AddInvoices($invoice_id));

        $user = User::get();
       // $user = User::where('roles_name' == ['admin']);

        //$user = DB::table('users')->select('*')->where('roles_name','["admin"]')->first();
        $invoices = invoices::latest()->first();

        Notification::send($user, new \App\Notifications\Add_New_Invoice($invoices));


        session()->flash('add', 'تم اضافة الفاتورة بنجاح');
        return back();



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = invoices::where('id',$id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_commission' => $request->Amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعه',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoices_attachments::where('invoices_id', $id)->first();

        $id_page =$request->id_page;


        if (!$id_page==2) {

            if(!empty($Details->invoices_number)){

                Storage::disk('public_uploads')->deleteDirectory($Details->invoices_number);
            }


            $invoices->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');

        }

        else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }



    }


    public function getProducts($id){

        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }



    public function Status_Update($id, Request $request)
    {
        $invoices = invoices::findOrFail($id);

        if ($request->status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->status,
                'payment_date' => $request->payment_date,
            ]);

            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoices_number' => $request->invoice_number,
                'products' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->status,
                'Value_Status' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->status,
                'Payment_date' => $request->Payment_date,
            ]);
            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoices_number' => $request->invoice_number,
                'products' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->status,
                'Value_Status' => 3,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');

    }
    public function Invoice_Paid()
    {
        $invoices = Invoices::where('value_status', 1)->get();
        return view('invoices.invoice_paid',compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = Invoices::where('value_status',2)->get();
        return view('invoices.invoice_unpaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoices::where('value_status',3)->get();
        return view('invoices.invoice_Partial',compact('invoices'));
    }

    public function Print_invoice($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.Print_invoice',compact('invoices'));
    }
    public function export()
    {

     return Excel::download(new InvoicesExport, 'invoices.xlsx');
      //  return (new InvoicesExport)->download('invoices.html', \Maatwebsite\Excel\Excel::HTML);
    }
    public function MarkAsRead_all (Request $request)
    {

        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }


    }

}
