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
            @if(Session::has('danger'))
               <div class="alert alert-danger">                  
                     <strong>Danger:</strong> {{ Session::get('danger') }}
               </div>
            @endif
            
         </div>
         <div class="col-md-12">
            <!--    Hover Rows  -->
            <div class="panel panel-info">
               <div class="panel-heading">
                  Department List
               </div>
               <div class="breadcrumb text-center">
                  <form action="{{ route('departments.create') }}" method="GET" style="display: inline-block;"">
                     {{ csrf_field() }}
                     <button class="btn btn-info"><i class="fa fa-pencil"></i> Add a Department</button>
                  </form>
               </div>
               <div class="panel-body">
                  <div class="table-responsive">
                     <table id="example" class="display" style="width:100%">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Dept. Name</th>
                              <th>QA Coordinator</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 1; ?>
                           @foreach($departments as $department)
                           
                           <tr>
                              <td>{{ $i }}</td>
                              <td>{{ strip_tags($department->dept_name) }}</td>
                              <td>{{ strip_tags($department->name) }}</td>
                              <td>
                                 <a href="{{ route('departments.show', $department->id) }}" class="btn btn-info btn-sm"><i class="fa fa-archive "></i> Details</a>
                                 <?php $find = 0; ?>
                                  @foreach($deptperiods as $deptperiod)
                                     @if( $deptperiod->dept_id == $department->id )
                                        <?php $find = 1; ?>
                                        @break
                                     @else
                                        <?php $find = 0; ?>
                                     @endif
                                  @endforeach
                                  
                                  @if($find == 1)
                                     
                                  @else
                                 <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: inline-block;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>
                                 </form>
                                 @endif
                              </td>
                           </tr>
                           <?php $i++; ?>
                           @endforeach
                        </tbody>
                     </table>
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
        "order": [[ 1, "asc" ]],
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]]
    } );
} );

</script>

@endsection