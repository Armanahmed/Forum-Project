@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            All Comment
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
         <div class="col-md-12">
            <!--    Hover Rows  -->
            <div class="panel panel-info">
               <div class="panel-heading">
                  Comment List
               </div>
               
               <div class="panel-body">
                  <div class="table-responsive">
                     <table id="example" class="display" style="width:100%">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Department</th>
                              <th>Comment</th>
                              <th>Session</th>
                              <th>Created At</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 1; ?>
                           @foreach($comments as $comment)
                           
                           <tr>
                              <td>{{ $i }}</td>
                              <td>{{ $comment->dept_name }}</td>
                              <td>{{ substr(strip_tags($comment->comment_details), 0, 40) }} {{ strlen(strip_tags($comment->comment_details)) > 40 ? "..." : "" }}</td>
                              <td>{{ strip_tags($comment->period_name) }}</td>
                              <td>{{ date('Y/m/d h:i:s', strtotime($comment->comment_create)) }}</td>
                              <td>
                                 <a href="{{ route('ideapanel.show', $comment->post_id) }}" class="btn btn-info btn-sm"> Read More <i class="fa fa-angle-right "></i></a>
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
        "order": [[ 4, "desc" ]],
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]]
    } );
} );

</script>

@endsection