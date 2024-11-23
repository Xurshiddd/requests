<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="navbar-brand">
            <img src="https://ttysi.uz/assets/public/images/logo_black.svg" alt="icon" style="max-width: 50px">
            <a href="/"><img src="https://ttysi.uz/assets/public/images/logo/logo-text.svg" style="max-width: 170px" alt="logo"></a>
        </div>
    </div>

    <div class="header-right">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn text-black">Log out</button>
        </form>
    </div>
</nav>
