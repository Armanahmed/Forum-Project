@extends('layouts.main')

@section('content')

<div class="container wrapper-container">
      <div class="row">
        <div class="col-md-12">

          <div class="submit-box-wrapper wrapper-box">
            <h2 class="head-h2 text-center">We Have Idea to Change and Improve !</h2>
            <!-- <span class="section-title-border"></span>
            <p>Ab commodi facilisi cupidatat primis. Irure, doloribus montes commodo dictumst facilisis et fringilla tempus sapiente fringilla minim sapien natoque omnis. Cillum felis quos habitasse iusto reprehenderit expedita duis aenean excepteur quod morbi litora, ratione. Vitae vitae adipisicing vel quam blandit debitis asperiores, eos ex, consectetur? Sapien cupidatat iusto! At iure.</p> -->

            <!-- <div class="center-block bg-submit">
               
                  <div class="checkbox">
                     <label>
                        <input type="checkbox" v-model="idea_submit"> <h4>Submit An Idea !</h4>
                     </label>
                  </div>
               
            </div> -->
            <div class="clearfix"></div>

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

            <form class="form-horizontal forum-form" action="{{ route('ideapanel.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate>
            {{ csrf_field() }}
               <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
               <input type="hidden" id="period_id" name="period_id" value="{{ Auth::user()->period_id }}">
               <div class="form-group">
                  <label for="category_id" class="col-sm-2 control-label">Select Category</label>
                  <div class="col-sm-10">
                     <select class="form-control" id="category_id" name="category_id" required>
                        <option value=""> Select Category </option>
                       @foreach($categories as $category)
                           
                           <option value="{{ strip_tags($category->id) }}"> {{ strip_tags($category->category_name) }} </option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="form-group">
                  <label for="post_details" class="col-sm-2 control-label">Idea Details</label>
                  <div class="col-sm-10">
                     <textarea class="form-control" id="post_details" name="post_details" rows="5" minlength="15" required></textarea>
                  </div>
               </div>
               <div class="form-group form-block-file">
                  
                     <label for="idea_file" class="col-sm-2 control-label">File input</label>
                     <div class="col-sm-10">
                        <input type="file" id="idea_file" name="idea_file[]" multiple="multiple">
                        <p class="help-block">Multiple file selection is supported.</p>
                     </div>
               </div>
               <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                     <div class="checkbox">
                        <label>
                           <input type="checkbox" id="anonymous" name="anonymous"> Post Anonymously
                        </label>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="terms" name="terms" required> Must Agree Terms and Conditions
                        </label>
                     </div>
                  </div>
               </div>

               <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-default forum-button">Submit Idea</button>
                  </div>
               </div>
            </form>

          </div>

        </div>
      </div>
    </div>

    

@endsection

