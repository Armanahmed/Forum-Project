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
            <div class="panel panel-default">
               <div class="panel-heading">
                  <div class="card-title">
                     <div class="title">Category Form</div>
                  </div>
               </div>
               <div class="panel-body">
                  <form action="{{ route('categories.update', $category->id) }}" method="POST" data-parsley-validate>
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                     <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" value="{{strip_tags($category->category_name)}}" minlength="3" required >
                     </div>
                     <div class="form-group">
                        <label for="dept_detail">category Detail</label>
                        <textarea class="form-control" rows="6" id="category_detail" name="category_detail" minlength="15" required >{{strip_tags($category->category_detail)}}</textarea>
                     </div>
                     <button type="submit" class="btn btn-default btn-info admin-form-button">Submit</button>
                     <a href="{{ route('categories.show', $category->id) }}" class="btn btn-danger admin-form-button"> Cancel <i class="fa fa-angle-double-right"></i></a>
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