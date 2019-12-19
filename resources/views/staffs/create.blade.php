@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            Staff 
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
                     <div class="title">Add Staff</div>
                  </div>
               </div>
               <div class="panel-body">
                  <form action="{{ route('staffs.store') }}" method="POST" data-parsley-validate>
                  {{ csrf_field() }}
                     <div class="form-group">
                        <label for="name">Staff Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" minlength="3" required>
                     </div>

                     <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                     </div>

                     <div class="form-group custom-checkbox">
                        <label for="password" v-if="!auto_password">Passwrod</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Passwrod" v-if="!auto_password" minlength="6" required>
                        <input type="checkbox" id="auto_generate" name="auto_generate" style="margin-left: 0; margin-top: 15px;" v-model="auto_password" placeholder="Manually Type a password." />
                        <label for="auto_generate">
                          Auto Generate Passwrod
                        </label>
                     </div>

                     <div class="form-group">
                       <label for="period_id">Select Department</label>

                       <select class="selectbox form-control" id="department_id" name="department_id">                           
                        
                           @foreach($departments as $department)
                              <option value="{{ $department->id }}">{{ strip_tags($department->dept_name) }}</option>
                           @endforeach
                        </select>

                     </div>

                     <div class="form-group custom-checkbox">
                       <input type="checkbox" id="role" name="role" style="margin-left: 0; margin-top: 15px; margin-bottom: 25px;"/>
                        <label for="role">
                          Role as a Staff
                        </label>

                     </div>
                     
                     
                     <button type="submit" class="btn btn-default btn-info admin-form-button">Create Staff</button>
                     <a href="{{ route('staffs.index') }}" class="btn btn-danger admin-form-button"> Cancel <i class="fa fa-angle-double-right"></i></a>
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

@section('custom_scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>
<script type="text/javascript">

var app = new Vue({
  el: '#app',
  data: {
    auto_password: true
  }
});
</script>

@endsection