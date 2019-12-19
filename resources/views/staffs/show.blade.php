@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            Staffs
        </h1>

    </div>
    <div id="page-inner">

      <!-- /. ROW  -->

      <div class="row">

         <div class="col-xs-12">
            
            @if(Session::has('success'))
               <div class="alert alert-info">                  
                     <strong>Success:</strong> {{ Session::get('success') }}
               </div>
            @endif
            
         </div>

         <div class="col-xs-12">
            <div class="panel panel-info">
               <div class="panel-heading">
                  Staff Details
               </div>

               <div class="panel-body">
                  <div class="body-content body-content-half">
                    <h5 class="body-content-title">Name of the Staff:</h5>
                    <p class="body-content-info"> {{ strip_tags($staff->name) }} </p>
                  </div>
                  <div class="body-content body-content-half">
                    <h5 class="body-content-title">Staff Email:</h5>
                    <p class="body-content-info"> {{ strip_tags($staff->email) }} </p>
                  </div>                   
                  <div class="body-content body-content-half">
                    <h5 class="body-content-title">Staff Department:</h5>
                    <p class="body-content-info"> {{ strip_tags($staff->dept_name) }} </p>
                  </div>
                  <div class="clearfix"></div>

                  <div class="text-center">
                    <a href="{{ route('staffs.edit', $staff->id) }}" class="btn btn-info btn-sm admin-form-button"><i class="fa fa-edit "></i> Edit</a>
                    <form action="{{ route('staffs.destroy', $staff->id) }}" method="POST" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                      <button class="btn btn-danger btn-sm admin-form-button"><i class="fa fa-trash-o"></i> Delete</button>
                    </form>
                  </div>

               </div>

               <div class="panel-footer text-center">
                  <a href="{{ route('staffs.index') }}" class="btn btn-primary "> See All Staffs <i class="fa fa-angle-double-right"></i></a>
               </div>
               
            </div>
         </div>

      </div>


      <footer><p>All right reserved. Template by: <a href="http://daffodil.ac">MindHunters Group</a></p>


      </footer>
   </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->

@endsection