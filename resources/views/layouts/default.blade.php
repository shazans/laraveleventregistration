<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>

<header class="row">
        @include('includes.header')
    </header>


<!--<div class="container">-->

   <div id="main" class="row">

        <!-- sidebar content -->
    
        <!-- main content -->
        <div id="content" class="col-md-12">
            @yield('content')
        </div>

  </div>

 <p>
<p>
    <footer class="row">
        @include('includes.footer')
    </footer>

<!--</div>-->
</body>
</html>
