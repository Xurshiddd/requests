<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TTYSI Requests</title>

    <!-- BOOTSTRAP STYLES-->
    @include('components.css')
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%!important;
        }

        .content {
            min-height: calc(100vh - 50px); /* Footerning balandligini hisobga oling */
            display: flex;
            flex-direction: column;
        }

        .footer {
            height: 50px; /* Footerning balandligi */
            background-color: #000;
            color: #fff;
            text-align: center;
            line-height: 50px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

    </style>
</head>
<body>
<div style="height: fit-content!important;">
<div id="wrapper">
    @include('components.navbar')

    <!-- /. NAV TOP  -->
    @include('components.saidbar')
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div>
                <div class="col-md-12 content">
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
<div id="footer-sec" class="footer">
    &copy; 2014 YourCompany | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a>
</div>
@include('components.script')
</div>
</body>
</html>
