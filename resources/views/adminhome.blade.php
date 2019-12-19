@extends('layouts.admin')

@section('admincontent')

<div id="page-wrapper">
    <div class="header"> 
        <h1 class="page-header">
            
                Dashboard
        </h1>
        
    </div>
    <div id="page-inner">

        <!-- /. ROW  -->

        
        <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="board">
                        <div class="panel panel-primary">
                        <div class="number">
                            <h3>
                                <h3 >{{ $ideawithoutcomment }}</h3>
                                <small>Ideas Without Comment</small>
                            </h3> 
                        </div>
                        <div class="icon">
                           <i class="fa fa-comments fa-5x red"></i>
                        </div>
         
                        </div>
                        </div>
                    </div>
                    
                           <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="board">
                        <div class="panel panel-primary">
                        <div class="number">
                            <h3>
                                <h3>{{ $ideaanonymous }}</h3>
                                <small>Anonymous Idea</small>
                            </h3> 
                        </div>
                        <div class="icon">
                           <i class="fa fa-lightbulb-o fa-5x blue"></i>
                        </div>
         
                        </div>
                        </div>
                    </div>
                    
                           <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="board">
                        <div class="panel panel-primary">
                        <div class="number">
                            <h3>
                                <h3 >{{ $commentanonymous }}</h3>
                                <small>Anonymous Comments</small>
                            </h3> 
                        </div>
                        <div class="icon">
                           <i class="fa fa-comments-o fa-5x green"></i>
                        </div>
         
                        </div>
                        </div>
                    </div>
                    
                   
                </div>

        <div class="row">


            <div class="col-md-7 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Department Ideas
                    </div>
                    <div class="panel-body">
                        <div id="morris-bar-chart"></div>
                    </div>

                </div>  
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Department Contributors
                    </div>
                    <div class="panel-body">
                        <div id="morris-donut-chart"></div>
                    </div>
                </div>
            </div>


        </div>      	
        <!-- /. ROW  -->

        <div class="row">
        @foreach($deptideas as $deptidea)
            <div class="col-xs-6 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body easypiechart-panel">
                        <h4>{{ $deptidea->dept_name }}</h4>
                        <div class="easypiechart" id="easypiechart-blue" data-percent="{{ number_format(($deptidea->all_idea * 100) / $totalposts, 2) }}" ><span class="percent">{{ number_format(($deptidea->all_idea * 100) / $totalposts, 2) }} %</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
            
        </div><!--/.row-->


        <footer><p>All right reserved. Template by: <a href="http://daffodil.ac">MindHunters Group</a></p>


        </footer>
    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->

@endsection

@section('custom_scripts')
<script src="{{ asset('assets/js/morris/morris.js') }}"></script>
<!-- <script src="{{ asset('assets/js/easypiechart.js') }}"></script>
<script src="{{ asset('assets/js/easypiechart-data.js') }}"></script> -->

<script type="text/javascript">

(function ($) {
    "use strict";
    var mainApp = {

        initFunction: function () {
            
            /* MORRIS BAR CHART
            -----------------------------------------*/
            Morris.Bar({
                element: 'morris-bar-chart',
                data: [
                @foreach($deptideas as $deptidea)
                {
                    y: '{{$deptidea->dept_name}}',
                    a: '{{$deptidea->all_idea}}'
                }, 
                @endforeach
                ],
                xkey: 'y',
                ykeys: ['a'],
                labels: ['Total Idea'],
                hideHover: 'auto',
                resize: true
            });
            /* MORRIS DONUT CHART
            ----------------------------------------*/
            Morris.Donut({
                element: 'morris-donut-chart',
                data: [
                @foreach($deptcontributors as $deptcontributor)
                {
                    label: "{{$deptcontributor->dept_name}}",
                    value: {{$deptcontributor->all_contributor}}
                },
                @endforeach
                ],
                resize: true
            });

                   
     
        },

        initialization: function () {
            mainApp.initFunction();

        }

    }
    // Initializing ///

    $(document).ready(function () {
        mainApp.initFunction();
    });

}(jQuery));

</script>

@endsection
