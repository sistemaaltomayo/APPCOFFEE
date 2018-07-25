<?php
use app\bibliotecas\GeneralClass;

class AutoservicioController extends BaseController
{

	public function actionInicio()
	{
		conexionbd();
		$idioma 		= 'Es';
		if(Session::get('idioma')){
			$idioma = Session::get('idioma');
		}		
		$tags 	 		= GENTag::where('Codigo','=','00001')->lists('Item', $idioma);
		return View::make('autoservicio/inicio',
		[
			'tags' => $tags
		]);

	}

	public function actionIdioma()
	{
		conexionbd();
		$idioma = Input::get('idioma');
		Session::put('idioma', $idioma);
		return Redirect::to('/autoservicio/inicio');	
	}


	public function actionComprobantePago()
	{

		conexionbd();
		return View::make('autoservicio/comprobantedepago',
		[
			'tags' => 'tgas'
		]);	
	}

	public function actionDetalleproducto()
	{

		conexionbd();


		/******* arraycarrito *****/
		$arraycarrito = carrito();						
		$listacarrito    	=   tbListarProducto::whereIn('id', $arraycarrito)
								->get();


		return View::make('autoservicio/detalleproducto',
		[
			'listacarrito' 			=> $listacarrito,
			'tags' => 'tgas'
		]);	
	}




	



	public function actionMenu($tipoentrega)
	{
		conexionbd();
		$gruposcarta    	=   GENCartaCategoria::where('Activo','=','1')
								->select('Nombres','Etiqueta')		
								->groupBy('Nombres','Etiqueta')
								->get();

		$topgrupo			=   $gruposcarta->first();
								
		$categorias 		= 	GENCartaCategoria::where('Activo','=','1')
								->where('Etiqueta','=',$topgrupo->Etiqueta)
								->select('IdCategoria')
								->lists('IdCategoria');

		$listaproductos    	=   tbListarProducto::whereIn('IdCategoria', $categorias)
								->get();


		/******* arraycarrito *****/
		$arraycarrito = carrito();						
		$listacarrito    	=   tbListarProducto::whereIn('id', $arraycarrito)
								->get();



						
		return View::make('autoservicio/menu',
		[
			'gruposcarta' 		=> $gruposcarta,
			'listaproductos' 	=> $listaproductos,
			'listacarrito' 		=> $listacarrito,		
			'topgrupo' 			=> $topgrupo,
			'menu' 				=> 'menu'
		]);

	}
	
	public function actionAjaxProductoCategoria()
	{
		conexionbd();
		$etiqueta 			= 	Input::get('etiqueta');
		$topgrupo    		=   GENCartaCategoria::where('Etiqueta','=',$etiqueta)->first();	
		$categorias 		= 	GENCartaCategoria::where('Activo','=','1')
								->where('Etiqueta','=',$etiqueta)
								->select('IdCategoria')
								->lists('IdCategoria');

		$listaproductos    	=   tbListarProducto::whereIn('IdCategoria', $categorias)
								->get();
						
		return View::make('autoservicioajax/listaproductosxcategoria',
		[
			'listaproductos' 	=> $listaproductos,	
			'topgrupo' 			=> $topgrupo,
			'menu' 				=> 'menu'
		]);

	}


	public function actionAjaxDetalleProducto()
	{
		conexionbd();
		$generalclass        		 	= new GeneralClass();
		$prefijo						= Input::get('prefijo');
		$id								= Input::get('id');
		$id 						 	= $generalclass->getDecodificarIdconPrefijo($id,$prefijo);
		$producto    					=  tbListarProducto::where('Id','=', $id)->first();


						
		return View::make('autoservicioajax/detalledeproducto',
		[
			'producto' 			=> $producto,
			'menu' 				=> 'menu'
		]);

	}


	public function actionAjaxCarritoCompra()
	{
		conexionbd();
		$generalclass        		 	= new GeneralClass();
		$prefijo						= Input::get('prefijo');
		$id								= Input::get('id');
		$id 						 	= $generalclass->getDecodificarIdconPrefijo($id,$prefijo);

		$arraycarrito = carrito();
		array_push($arraycarrito, $id);
		Session::put('arraycarrito', $arraycarrito);



		$listacarrito    					=   tbListarProducto::whereIn('id', $arraycarrito)
										   		->get();
						

		return View::make('autoservicioajax/carritocompra',
		[
			'listacarrito' 			=> $listacarrito,
			'menu' 						=> 'menu'
		]);

	}








}


function carrito(){
	/*************  base de datos *************/
		if (!Session::get('arraycarrito')){
			$arraycarrito 				= [];	
		}else{
			$arraycarrito 				= Session::get('arraycarrito');			
		}
	return $arraycarrito;	
	/******************************************/
}

function conexionbd(){
	/*************  base de datos *************/
	if (!Session::get('basedatos')){
		$xml = new GeneralClass();
		$basedatos = $xml->getBaseXml();
		Session::forget('basedatos');
		Session::put('basedatos', $basedatos);
	}


	/******************************************/
}


?>