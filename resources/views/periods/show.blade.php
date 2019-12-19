@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            Session
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
                  Session Details
               </div>
               <div class="panel-body">
                  <div class="body-content">
                    <h5 class="body-content-title">Name of the Session:</h5>
                    <p class="body-content-info"> {{ strip_tags($period->period_name)}} </p>
                  </div>
                  <div class="body-content">
                    <h5 class="body-content-title">Session Department:</h5>
                    <p class="body-content-info"> {{ strip_tags($period->department->dept_name) }} </p>
                  </div>
                  <div class="body-content">
                    <h5 class="body-content-title">Session Description:</h5>
                    <p class="body-content-info body-content-desc"> {{ strip_tags($period->period_desc)}} </p>
                  </div> 
               </div>
            </div>
         </div>

         <div class="col-md-4 col-xs-12">
            <div class="panel panel-info">
               <div class="panel-heading">
                 Session Info
               </div>
               <div class="panel-body">
                  <p><span><strong>Close Date: </strong></span> <span>{{ date('M j, Y', strtotime($period->closure_date)) }}</span></p>
                  <p><span><strong>Final Date: </strong></span> <span>{{ date('M j, Y', strtotime($period->final_date)) }}</span></p>
                  <div class="text-center">
                    <a href="{{ route('periods.edit', $period->id) }}" class="btn btn-info btn-sm  admin-form-button"><i class="fa fa-edit"></i> Edit</a>
                    <!-- <form action="{{ route('periods.destroy', $period->id) }}" method="POST" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                      <button class="btn btn-danger btn-sm admin-form-button"><i class="fa fa-trash-o"></i> Delete</button>
                    </form> -->
                  </div>
               </div>
               <div class="panel-footer text-center">
                  <a href="{{ route('periods.index') }}" class="btn btn-primary "> See All Sessions <i class="fa fa-angle-double-right"></i></a>
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