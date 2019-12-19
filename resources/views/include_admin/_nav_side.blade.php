<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">

            <li>
                <a class="adminhome" href="{{ route('adminhome') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            @if( (Auth::user()->role == 'manager') || (Auth::user()->role == 'admin') )
            <li>
                <a class="departments" href="{{ route('departments.index') }}"><i class="fa fa-dashboard"></i> Departments</a>
            </li>
            @endif
            @if( (Auth::user()->role == 'manager') || (Auth::user()->role == 'admin'))
            <li>
                <a class="categories" href="{{ route('categories.index') }}"><i class="fa fa-dashboard"></i> Categories</a>
            </li>
            @endif
            @if( (Auth::user()->role == 'manager') || (Auth::user()->role == 'coordinator') || (Auth::user()->role == 'admin') )
            <li>
                <a class="periods" href="{{ route('periods.index') }}"><i class="fa fa-dashboard"></i> Sessions</a>
            </li>
            @endif
            
            @if( (Auth::user()->role == 'manager') || (Auth::user()->role == 'coordinator') || (Auth::user()->role == 'admin') )
            <li>
                <a class="has-submenu" href="#"><i class="fa fa-sitemap"></i> Manage Users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('users.index') }}">Students List</a>
                    </li>
                    <li>
                        <a href="{{ route('staffs.index') }}">Staffs List</a>
                    </li>
                    @if( (Auth::user()->role == 'manager') || (Auth::user()->role == 'admin') )
                    <li>
                        <a href="{{ route('coordinators.index') }}">Coordinators List</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            <li>
                <a class="ideaadmin" href="{{ route('ideaadmin.index') }}"><i class="fa fa-dashboard"></i> Posts</a>
            </li>   
            <li>
                <a class="ideacomment" href="{{ route('ideaadmin.comment') }}"><i class="fa fa-dashboard"></i> Comments</a>
            </li>
            <li>
                <a class="ideapopular" href="{{ route('ideaadmin.popular') }}"><i class="fa fa-dashboard"></i> Popular Ideas</a>
            </li>
            <li>
                <a class="ideaviewed" href="{{ route('ideaadmin.viewed') }}"><i class="fa fa-dashboard"></i> Most Viewed Ideas </a>
            </li>	
        </ul>

    </div>

</nav>
<!-- /. NAV SIDE  -->