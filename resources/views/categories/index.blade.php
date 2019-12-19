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
         <div class="col-md-8">
            <!--    Hover Rows  -->
            <div class="panel panel-info">
               <div class="panel-heading">
                  Category List
               </div>

               <div class="panel-body">
                  <div class="table-responsive">
                     <table id="example" class="display" style="width:100%">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Category Name</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $i = 1; ?>
                           @foreach($categories as $category)
                           
                           <tr>
                              <td>{{ $i }}</td>
                              <td>{{ strip_tags($category->category_name) }}</td>
                              <td>
                              <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm"><i class="fa fa-archive "></i> Details</a>
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
         <div class="col-md-4 col-xs-12">
            <div class="panel panel-info">
               <div class="panel-heading">

                  <div class="card-title">
                     <div class="title">Create Category</div>
                  </div>
               </div>
               <div class="panel-body">
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
                  <form action="{{ route('categories.store') }}" method="POST" data-parsley-validate>
                  {{ csrf_field() }}
                     <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name" minlength="3" required >
                     </div>
                     <div class="form-group">
                        <label for="category_detail">Category Detail</label>
                        <textarea class="form-control" rows="6" id="category_detail" name="category_detail" placeholder="Category Detail" minlength="15" required></textarea>
                     </div>
                     <button type="submit" class="btn btn-default btn-info">Submit</button>
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
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"></link>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    $('#example').DataTable( {
        "order": [[ 1, "desc" ]],
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]]
    } );
} );

</script>

@endsection