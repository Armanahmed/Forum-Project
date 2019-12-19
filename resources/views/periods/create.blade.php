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

            @if(Session::has('danger'))
               <div class="alert alert-danger">                  
                     <strong>Danger:</strong> {{ Session::get('danger') }}
               </div>
            @endif

            @if(count($errors) > 0)
            <div class="alert alert-danger" role="alert">
               <strong>Errors:</strong>
               <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
            @endif
            
         </div>
         <div class="col-xs-12">
            <div class="panel panel-info">
               <div class="panel-heading">
                  <div class="card-title">
                     <div class="title">Create A Session</div>
                  </div>
               </div>
               <div class="panel-body">
                  <form action="{{ route('periods.store') }}" method="POST" data-parsley-validate>
                  {{ csrf_field() }}
                     <div class="form-group">
                        <label for="period_name">Session Name</label>
                        <input type="text" class="form-control" id=" period_name" name="period_name" placeholder="Enter Session Name" minlength="3" required>
                     </div>

                     <div class="form-group">
                        <label for="depts">Department Name</label>
                        <select class="selectbox form-control" id="depts" name="depts">                           
                        
                           @foreach($departments as $department)
                              <option value="{{ strip_tags($department->id) }}">{{ strip_tags($department->dept_name) }}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="form-group">
                        <label for="period_desc">Session Description</label>
                        <textarea type="text" class="form-control" rows="4" id=" period_desc" name="period_desc" placeholder="Enter Session Description" minlength="15" required></textarea>
                     </div>

                     <div class="form-group col-sm-6 pad-left">
                        <label for="closure_date">Closure Date</label>
                        <?php $date[0]->add(new DateInterval('P2Y')); ?>
                        <input type="date" class="form-control" id="closure_date" name="closure_date" min="{{$currentdate->format('Y-m-d')}}" max="{{$date[0]->format('Y-m-d')}}">
                     </div>

                     <div class="form-group col-sm-6 pad-right">
                        <label for="   final_date">Final Date</label>
                        <?php $date[1]->add(new DateInterval('P2Y')); ?>
                        <input type="date" class="form-control" id="final_date" name="final_date" min="{{$currentdate->format('Y-m-d')}}" max="{{$date[1]->format('Y-m-d')}}">
                     </div>
                     <button type="submit" class="btn btn-default btn-info admin-form-button">Create Session</button>
                     <a href="{{ route('periods.index') }}" class="btn btn-danger admin-form-button"> Cancel <i class="fa fa-angle-double-right"></i></a>
                  </form>
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