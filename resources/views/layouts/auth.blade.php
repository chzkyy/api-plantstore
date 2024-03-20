<!DOCTYPE html>
<html lang="en">

{{--
	______ _____   __  ________ ___  __________ _____	
 ./ ___  ||__  |  | | |  __  _||_ | |_ _||_  _||_  _|	 
 / ./  \_|  | |__| | |_/  / /  | |_/  /   \ \  / /    	
| |        |  __  |    .'.' _ | __  <     \ \/ /   	
\ \.___.'\| |  | |_ _/ /__/ || | _\ \_   _|  |_   	
\._____.'____||___|________||_| |____| |______|	  

--}}

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @include('includes.style')

</head>

<body>
    @include('includes.particle-js')
    <div class="container" data-aos="fade-in">
        <div class="row mobile ">
            @yield('content')
        </div>
    </div>
    @include('includes.script')
</body>

</html>