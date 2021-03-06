<?php
use app\bibliotecas\GeneralClass;
/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{

	$xml = new GeneralClass();
	$urls = $xml->getBaseXml();
	$posicion_coincidencia=0;
	$posicion_autoservicio=0;

	$cadena_de_texto = Request::url();
	$cadena_buscada   = '';

	for ($i = 0; $i < count($urls['parametro']); $i++) {

		if(strrpos($cadena_de_texto,(string)$urls['parametro'][$i]['valor'])>0){
			$cadena_buscada = (string)$urls['parametro'][$i]['valor'];
		}
	}

	$posicion_coincidencia =  strrpos($cadena_de_texto,$cadena_buscada);
	$posicion_autoservicio =  strrpos($cadena_de_texto,'autoservicio');

	//se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='

	if ($posicion_autoservicio <= 0) {
		if ($posicion_coincidencia > 0) {

			
		    if(Request::url()!='http://'.$cadena_buscada.':8080/APPCOFFEE/login'  && !Session::has('Usuario')){

				return Redirect::to('/login');
			}

		    if( (Request::url()=='http://'.$cadena_buscada.':8080/APPCOFFEE/login' ||  Request::url()=='http://'.$cadena_buscada.':8080/APPCOFFEE')  && Session::has('Usuario')){

				return Redirect::to('/bienvenidos-coffee-and-arts');
			}
		}
	}

});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
