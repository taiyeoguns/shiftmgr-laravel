<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img data-name="{{ $user->name or 'User' }}" class="img-circle avatar" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ $user->name or 'User' }}</p>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>
            <li class="active"><a href="{{ route('shifts.index') }}"><i class="fa fa-calendar"></i> <span>Shifts</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside> 
