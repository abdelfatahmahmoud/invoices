@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->

                <!-- this is message error  -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <!-- start add products -->
                @if(session()->has('add'))
                    <div class="alert alert-success">
                        <strong>{{session()->get('add')}}</strong>
                    </div>
                @endif
                <!-- end add products -->

                <!-- start edit products -->
                @if(session()->has('edit'))
                    <div class="alert alert-success">
                        <strong>{{session()->get('edit')}}</strong>
                    </div>
                @endif
                <!-- end edit products -->


                <!-- start edit products -->
                @if(session()->has('delete'))
                    <div class="alert alert-danger">
                        <strong>{{session()->get('delete')}}</strong>
                    </div>
                @endif
                <!-- end edit products -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card mg-b-20">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <a class="modal-effect btn btn-outline-primary " data-effect="effect-super-scaled" data-toggle="modal" href="#modaldemo1">اضافه قسم</a>

                                </div>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table key-buttons text-md-nowrap" >
                                        <thead>
                                        <tr>
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">اسم المنتج</th>
                                            <th class="border-bottom-0">اسم القسم</th>
                                            <th class="border-bottom-0">الملاحظات</th>
                                            <th class="border-bottom-0">العمليات</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td>{{$product->id}}</td>
                                            <td>{{$product->product_name}}</td>
                                            <td>{{$product->sections->section_name}}</td>
                                            <td>{{$product->description}}</td>
                                            <td>
                                                <a class="modal-effect btn btn-sm   btn-info" data-effect="effect-scale"
                                                   data-id="{{$product->id}}"
                                                  data-product_name="{{$product->product_name}}"
                                                   data-section_name="{{$product->sections->section_name}}"
                                                   data-description="{{$product->description}}"
                                                   data-toggle="modal" href="#modaldemo8"
                                                   title="تعديل"> تعديل</a>  <!-- End button edit -->

                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                   data-id="{{$product->id}}" data-product_name="{{$product->product_name}}"
                                                   data-toggle="modal" href="#modaldemo9"
                                                   title="حذف">حذف</a><!-- End button Delete -->
                                            </td>         <!-- end btn -->




                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Basic modal -->
                    <div class="modal" id="modaldemo1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">اضافه منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('products.store')}}" method="post">
                                        {{csrf_field()}}

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">اسم المنتج</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" required >
                                        </div>

                                        <label class="my-1 mr-2" for="inlineForCustomSelectPref">القسم</label>
                                        <select name="section_id" id="section_id" class="form-control" required>
                                            <option value="" selected disabled>-- حدد القسم --</option>
                                       @foreach($sections as $section)

                                           <option value="{{$section->id}}">{{$section->section_name}}</option>
                                            @endforeach
                                        </select>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">تاكيد</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Basic modal -->

                    <!--edit form-->
                    <div class="modal" id="modaldemo8">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title"> تعديل المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="products/update" method="post">
                                        {{method_field('patch')}}
                                        {{csrf_field()}}

                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id" value="">
                                            <label for="exampleInputEmail1">اسم المنتج</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name" required >
                                        </div>

                                        <label class="my-1 mr-2" for="inlineForCustomSelectPref">القسم</label>
                                        <select name="section_name" id="section_name" class="form-control" required>
                                            <option value="" selected disabled>-- حدد القسم --</option>
                                            @foreach($sections as $section)

                                                <option >{{$section->section_name}}</option>
                                            @endforeach
                                        </select>


                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">تاكيد</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end edit form-->

                    <!--delete form-->
                    <div class="modal" id="modaldemo9">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title"> حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="products/destroy" method="post">
                                        {{method_field('delete')}}
                                        {{csrf_field()}}

                                        <div class="form-group">
                                            <p>هل انت متاكد من الحذف</p>
                                            <input type="hidden" name="id" id="id" value="">

                                            <input type="text" class="form-control" id="product_name" name="product_name" required >
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end delete form-->

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>

    <!-- models js -->
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

    <script>

        $('#modaldemo8').on('show.bs.modal',function (event) {

            var button = $(event.relatedTarget)
            var id = button.data('id')
            var  product_name = button.data('product_name')
            var  section_name = button.data('section_name')
            var  description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);


        })

    </script>

    <script>

        $('#modaldemo9').on('show.bs.modal',function (event) {

            var button = $(event.relatedTarget)
            var id = button.data('id')
            var  product_name = button.data('product_name')

            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);

        })

    </script>

@endsection
