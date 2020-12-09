<?php

namespace App\Http\Controllers;

use App\products;
use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        $products = products::all();
        return view('products.products' , compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'description' => 'required',
            'section_id' => 'required',
        ],[
            'product_name.required' => 'يجب ادخال اسم القسم ',
            'product_name.unique' => 'هذا القسم مسجل مسبقا',
            'description.required' => 'يجب ادخال وصف القسم  ',

        ]);

        products::create([
            'product_name' =>$request->	product_name,
            'description' =>$request->description,
            'section_id' =>$request->section_id,

        ]);
        session()->flash('add','تم الاضافه بنجاح');

        return redirect('/products');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id= sections::where('section_name',$request->section_name)->first()->id;

        $products = products::findOrFail($request->id);

        $products->update([
            'product_name' => $request->product_name,
            'section_id' => $id,
            'description' => $request->description,


        ]);

        session()->flash('edit','تم تعديل المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

      $products =products::findOrFail($request->id);
      $products->delete();

        session()->flash('delete','تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
