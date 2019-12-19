@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            Department 
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

         <div class="col-md-8 col-xs-12">
            <div class="panel panel-info">
               <div class="panel-heading">
                  Department Details
               </div>
               <div class="panel-body">
                  <div class="body-content">
                    <h5 class="body-content-title">Name of the Department:</h5>
                    <p class="body-content-info"> {{ strip_tags($department->dept_name)}} </p>
                  </div>
                  <div class="body-content">
                    <h5 class="body-content-title">Department Coordinator:</h5>
                    <p class="body-content-info"> {{ strip_tags($department->name) }} </p>
                  </div>
                  <div class="body-content">
                    <h5 class="body-content-title">Department Description:</h5>
                    <p class="body-content-info body-content-desc"> {{ strip_tags($department->dept_detail)}} </p>
                  </div>                 

               </div>
            </div>
         </div>

         <div class="col-md-4 col-xs-12">
            <div class="panel panel-info">
               <div class="panel-heading">
                  Info Panel
               </div>
               <div class="panel-body">
                  <p><span><strong>Created At: </strong></span> <span>{{ date('M j, Y h:ia', strtotime($department->created_at)) }}</span></p>
                  <p><span><strong>Updated At: </strong></span> <span>{{ date('M j, Y h:ia', strtotime($department->updated_at)) }}</span></p>
                  <div class="text-center">
                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-info btn-sm admin-form-button"><i class="fa fa-edit "></i> Edit</a>
                    <!-- <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                      <button class="btn btn-danger btn-sm admin-form-button"><i class="fa fa-trash-o"></i> Delete</button>
                    </form> -->
                  </div>
               </div>
               <div class="panel-footer text-center">
                  <a href="{{ route('departments.index') }}" class="btn btn-primary "><i class="fa fa-files-o"></i> See All Departments</a>
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