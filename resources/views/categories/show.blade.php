@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            Category
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
                Category Details
                  
               </div>
               <div class="panel-body">
                <div class="body-content">
                    <h5 class="body-content-title">Name of the Category:</h5>
                    <p class="body-content-info"> {{ strip_tags($category->category_name)}} </p>
                  </div>
                  <div class="body-content">
                    <h5 class="body-content-title">Category Description:</h5>
                    <p class="body-content-info body-content-desc"> {{ strip_tags($category->category_detail)}} </p>
                  </div>               

               </div>
            </div>
         </div>

         <div class="col-md-4 col-xs-12">
            <div class="panel panel-info">
               <div class="panel-heading">
                  Category Info
               </div>
               <div class="panel-body">
                  <p><span><strong>Created At: </strong></span> <span>{{ date('M j, Y h:ia', strtotime($category->created_at)) }}</span></p>
                  <p><span><strong>Updated At: </strong></span> <span>{{ date('M j, Y h:ia', strtotime($category->updated_at)) }}</span></p>
                  <div class="text-center">
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm admin-form-button"><i class="fa fa-edit "></i> Edit</a>

                    <?php $find = 0; ?>
                    @foreach($categoryposts as $categorypost)
                       @if( $categorypost->cat_id == $category->id )
                          <?php $find = 1; ?>
                          @break
                       @else
                          <?php $find = 0; ?>
                       @endif
                    @endforeach
                    
                    @if($find == 1)
                       
                    @else
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                      <button class="btn btn-danger btn-sm admin-form-button"><i class="fa fa-trash-o"></i> Delete</button>
                    </form>
                    @endif

                  </div>
               </div>
               <div class="panel-footer text-center">
                  <a href="{{ route('categories.index') }}" class="btn btn-primary "><i class="fa fa-files-o"></i> See All Category</a>
               </div>
            </div>
         </div>

         <div class="col-md-12">
            <!--    Hover Rows  -->
            <div class="panel panel-info">
               <div class="panel-heading">
                  Idea List For This Category
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
                              <th>Created At</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 1; ?>
                           @foreach($posts as $post)
                           
                           <tr>
                              <td>{{ $i }}</td>
                              <td>{{ $post->dept_name }}</td>
                              <td>{{ substr(strip_tags($post->post_details), 0, 40) }} {{ strlen(strip_tags($post->post_details)) > 40 ? "..." : "" }}</td>
                              <td>{{ $post->period_name }}</td>
                              <td>{{ date('Y/m/d h:i:s', strtotime($post->post_created)) }}</td>
                              <td>
                                 <a href="{{ route('ideapanel.show', $post->post_id) }}" class="btn btn-info btn-sm"> Read More <i class="fa fa-angle-right "></i></a>
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
        "order": [[ 3, "desc" ]],
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]]
    } );
} );

</script>

@endsection