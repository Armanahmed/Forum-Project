@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            Coordinators
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
            <!--    Hover Rows  -->
            <div class="panel panel-info">
               <div class="panel-heading">
                  All Coordinators
               </div>
               <!-- <div class="breadcrumb text-center">
                  <form action="{{ route('coordinators.create') }}" method="GET" style="display: inline-block;"">
                     {{ csrf_field() }}
                     <button class="btn btn-info"><i class="fa fa-pencil"></i> Add a Coordinators</button>
                  </form>
               </div> -->
               <div class="panel-body">
                  <div class="table-responsive">
                     <table id="example" class="display" style="width:100%">
                        
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Coordinator Name</th>
                              <th>Department Name</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>                           
                           <?php $i = 1; ?>
                           @foreach($coordinators as $coordinator)
                           
                           <tr>
                              
                              <td>{{$i}}</td>
                              <td>{{strip_tags($coordinator->name)}}</td>
                              <td>{{strip_tags($coordinator->dept_name)}}</td>
                              <td>
                                 <a href="{{route('coordinators.show', $coordinator->id)}}" class="btn btn-info btn-sm"><i class="fa fa-archive "></i> Details</a>
                                 <!-- <form action="{{ route('coordinators.destroy', $coordinator->id) }}" method="POST" style="display: inline-block;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>
                                 </form> -->
                              </td>
                              
                           </tr>
                           <?php $i++; ?>
                           @endforeach
                           
                        </tbody>
                     </table>
                  </div>
                  <div class="text-center">
                     
                  </div>
               </div>
            </div>
            <!-- End  Hover Rows  -->
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
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"></link>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    $('#example').DataTable( {
        "order": [[ 2, "desc" ]],
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]]
    } );
} );

</script>

@endsection