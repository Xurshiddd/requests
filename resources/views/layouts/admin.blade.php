<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TTYSI Requests</title>

    <!-- BOOTSTRAP STYLES-->
    @include('components.css')
</head>
<body>
<div id="wrapper">
    @include('components.navbar')

    <!-- /. NAV TOP  -->
    @include('components.saidbar')
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div>
                <div class="col-md-12">
                    <h1 class="page-head-line">@yield('h1')Dashboard</h1>
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
@yield('script')
<div id="footer-sec">
    &copy; 2014 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a>
</div>
@include('components.script')
</body>
</html>
