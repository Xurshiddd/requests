<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <div class="user-img-div">
                    <p style="font-size: larger; font-weight: 900; color: white; display: flex; justify-content: center; align-items: center">
                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                    </p>
                </div>
            </li>
            <li>
                <a class="active-menu" href="{{ route('admin') }}"><i class="fa fa-dashboard "></i>Dashboard</a>
            </li>
            @if(auth()->user()->hasRole('SuperAdmin'))
            <li>
                <a href="#"><i class="fa fa-lock" aria-hidden="true"></i>Ruxsatlar<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('roles.index')}}">Role</a>
                    </li>
                    <li>
                        <a href="{{ route('permissions.index') }}">Permission</a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                </ul>
            </li>
            @endif
            <li>
                <a href="#"><i class="fa-solid fa-code-pull-request"></i>So'rovlar <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ route('requests.index') }}">Barcha so'rovlar</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
