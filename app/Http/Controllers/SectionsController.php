<?php

namespace App\Http\Controllers;

use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = sections::all();

        return view('section.section',compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'section_name' => 'required|unique:sections|max:255',

        ],[
            'section_name.required' => 'يجب ادخال اسم القسم ',
            'section_name.unique' => 'هذا القسم مسجل مسبقا',

        ]);


            sections::create([
                'section_name' =>$request->section_name,
                'description' =>$request->description,
                'created_by' =>(Auth::user()->name),

            ]);
            session()->flash('add','تم الاضافه بنجاح');
            return redirect('/sections');
        }



    /**
     * Display the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $id  = $request->id;
       $this->validate($request,[
           'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
           'description' => 'required',
       ],[
           'section_name.required' => 'يجب ادخال اسم القسم ',
           'section_name.unique' => 'هذا القسم مسجل مسبقا',
           'description.required' => 'يجب ادخال وصف القسم  ',

       ]);

       $section = sections::find($id);
       $section->update([
          'section_name'  => $request->section_name,
           'description'  => $request->description,
       ]);

        session()->flash('edit','تم الاضافه بنجاح');
        return redirect('/sections');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();


        session()->flash('delete','تم الحذف بنجاح');
        return redirect('/sections');

    }
}
