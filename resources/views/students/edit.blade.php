@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            Student
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
                     <div class="title">Edit Student</div>
                  </div>
               </div>
               <div class="panel-body">
                  <form action="{{ route('users.update', $student->id) }}" method="POST" data-parsley-validate>
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                     <div class="form-group">
                        <label for="name">Student Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{strip_tags($student->name)}}" minlength="3" required>
                     </div>

                     <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{strip_tags($student->email)}}" required>
                     </div>

                     <div class="form-group custom-checkbox">
                        <label for="password" v-if="!auto_password">Passwrod</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Passwrod" v-if="!auto_password" minlength="6" required>
                        <input type="checkbox" id="auto_generate" name="auto_generate" style="margin-left: 0; margin-top: 15px;" v-model="auto_password" placeholder="Manually Type a password." />
                        <label for="auto_generate">
                          Keep The Current Password
                        </label>
                     </div>

                     <div class="form-group">
                       <label for="period_id">Select Session</label>

                       <select class="selectbox form-control" id="period_id" name="period_id">                           
                        
                           @foreach($periods as $period)
                              <option value="{{ strip_tags($period->id) }}">{{ strip_tags($period->department->dept_name) }} &nbsp;&nbsp;( {{ strip_tags($period->period_name) }} )</option>
                           @endforeach
                        </select>

                     </div>

                     <div class="form-group custom-checkbox">
                       <input type="checkbox" id="role" name="role" style="margin-left: 0; margin-top: 15px; margin-bottom: 25px;" required/>
                        <label for="role">
                          Role as a Student
                        </label>

                     </div>
                     
                     
                     <button type="submit" class="btn btn-default btn-info admin-form-button">Update Student</button>
                     <a href="{{ route('users.show', $student->id) }}" class="btn btn-danger admin-form-button"> Cancel <i class="fa fa-angle-double-right"></i></a>
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
$(document).ready(function() {
      $("#period_id").val("{{ $student->period_id }}").change();
    });
// Vue.component('example-component', require('./../../assets/js/components/ExampleComponent.vue'));
Vue.component('my-component', {
  template: '<div>A custom component!</div>'
});
var app = new Vue({
  el: '#app',
  data: {
    auto_password: true
  }
});
</script>

@endsection