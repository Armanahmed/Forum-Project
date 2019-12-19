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
                     <div class="title">Form Elements</div>
                  </div>
               </div>
               <div class="panel-body">
                  <form action="{{ route('departments.update', $department->id) }}" method="POST" data-parsley-validate>
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                     <div class="form-group">
                        <label for="dept_name">Dept. Name</label>
                        <input type="text" class="form-control" id="dept_name" name="dept_name" value="{{strip_tags($department->dept_name)}}" minlength="3" required>
                     </div>
                     <div class="form-group">
                        <label for="dept_detail">Dept. Detail</label>
                        <textarea class="form-control" rows="6" id="dept_detail" name="dept_detail" minlength="15" required>{{strip_tags($department->dept_detail)}}</textarea>
                     </div>
                     <div class="form-group" v-if="change_coordinator">
                       <label for="coordinator_id">Select Coordinator</label>

                       <select class="selectbox form-control" id="coordinator_id" name="coordinator_id">                           
                        
                           @foreach($staffs as $staff)
                              <option value="{{ strip_tags($staff->id) }}">{{ strip_tags($staff->name) }} &nbsp;&nbsp; ({{ $staff->email }})</option>
                           @endforeach
                        </select>

                     </div>
                     <div class="form-group custom-checkbox">
                        <input type="checkbox" id="coordinator_input" name="coordinator_input" style="margin-left: 0; margin-top: 15px; margin-bottom: 25px;" v-model="change_coordinator"/>
                        <label for="coordinator_input">
                           Change coordinator
                        </label>

                     </div>

                     <button type="submit" class="btn btn-default btn-info admin-form-button">Submit</button>
                     <a href="{{ route('departments.show', $department->id) }}" class="btn btn-danger admin-form-button"> Cancel <i class="fa fa-angle-double-right"></i></a>
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
// Vue.component('example-component', require('./../../assets/js/components/ExampleComponent.vue'));
Vue.component('my-component', {
  template: '<div>A custom component!</div>'
});
var app = new Vue({
  el: '#app',
  data: {
    change_coordinator: false
  }
});

</script>


@endsection