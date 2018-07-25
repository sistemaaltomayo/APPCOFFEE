<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>COFFEE AND ARTS - AUTOSERVICIO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

        <link rel="icon" href="{{asset('img/logoautoservicio.ico')}}"/>

        {{ HTML::style('css/bootstrap.min.css'); }}
        {{ HTML::style('css/font-awesome.min.css'); }}
        @yield('style')
        {{ HTML::style('css/globalautoservicio.css'); }}


    </head>


    <body>
    	<section>

            <p id='ipsocket' style='display:none;'>{{(string)Session::get('basedatos')['parametro'][4]['valor']}}</p>

    		@yield('section')

            {{ HTML::script('js/jquery-2.1.3.min.js'); }}
            {{ HTML::script('js/jquery-ui.min.js'); }}
            {{ HTML::script('js/bootstrap.min.js'); }}
            {{ HTML::script('js/validaciones.js'); }}
            {{ HTML::script('js/jquery.numeric.js'); }}

            {{ HTML::script('js/jquery.mousewheel.js'); }}
            {{ HTML::script('js/jquery-scrollpanel-0.7.0.js');}}
           
            @yield('script')
            {{ HTML::script('js/globalautoservicio.js'); }}

		</section>




    </body>

</html>


