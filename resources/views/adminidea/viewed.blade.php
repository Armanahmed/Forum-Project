@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            Most Viewed
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
                  Idea List
               </div>
               
               <div class="panel-body">
                  <div class="table-responsive">
                     <table id="example" class="display" style="width:100%">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Dept. Name</th>
                              <th>Idea</th>
                              <th>Session</th>
                              <th>Views</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 1; ?>
                           @foreach($posts as $post)

                           
                               @foreach($populars as $popular)

                                  @if( $popular->department_id == $post->department_id && $popular->max_views == $post->views )
                                    <tr>
                                       <td>{{ $i }}</td>
                                       <td>{{ strip_tags($post->dept_name) }}</td>
                                       <td>{{ substr(strip_tags($post->post_details), 0, 40) }} {{ strlen(strip_tags($post->post_details)) > 40 ? "..." : "" }}</td>
                                       <td>{{ strip_tags($post->period_name) }}</td>
                                       <td>{{ strip_tags($post->views) }}</td>
                                       <td>
                                          <a href="{{ route('ideapanel.show', $post->post_id) }}" class="btn btn-info btn-sm"> Read More <i class="fa fa-angle-right "></i></a>
                                       </td>
                                    </tr>
                                    @break
                                     
                                  @endif


                               @endforeach
                           
                           
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