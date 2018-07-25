@extends('templateautoservicio')
@section('section')
<div class="container">
	<div class="row">  
			<nav class='menu'>
				<div class='col-xs-2'>
					<a href="{{ url('/autoservicio/inicio') }}" class="btn btn-default">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					</a>
				</div>	
				<div class='col-xs-6'>
					<h1>MI MENU</h1>
				</div>
				<div class='col-xs-4'>
					<h1 class='textcoffee'>COFFEE & ARTS</h1>
				</div>
			</nav>
	</div>

	<div class="row"> 
		<div class='categoriaproducto'>

			<div class='categoria scrollpanel no3 col-xs-3'>


                @foreach ($gruposcarta as $item)

					<div class='cajacategoria' data='{{$item->Etiqueta}}'>
						{{ HTML::image('img/categorias/cafes.png', 'cafes') }}
						<h3>{{$item->Nombres}}</h3>
					</div>

                @endforeach

											
			</div>	

			<div class='productos col-xs-9'>

				<div class='col titulo col-xs-12'>
					<h4>{{$topgrupo->Nombres}} <small>(Seleccione un producto)</small></h4>
				</div>	


                @foreach ($listaproductos as $item)

					<div class='col col-xs-4'>
						<div class='producto' 
							data-prefijo='{{substr($item->id, 0,8)}}' 
							data='{{Hashids::encode(substr($item->id, -12))}}' 
							data-toggle="modal" 
							data-target="#modalproducto">

							{{ HTML::image('img/categorias/cafes.png', 'cafes') }}
							<h3>{{$item->descripcion}}</h3>
							<p class='precio'>S/ {{number_format(round($item->precio,2),2,'.','')}}</p>
							<p class='caloria'>100 CAL</p>
						</div>
					</div>	

                @endforeach

			</div>	


		</div>

	</div>


	<div class="row">  
			<div class='menufooter'>
				<div class='nav'>
					<div class='col col-xs-6'>
						<p class='titulo'>MI ORDEN - PARA COMER ACA</p>
					</div>
					<div class='col col-xs-6'>
						<div class='total'>
							<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
							<small class='cantidadtotal'> {{count($listacarrito)}} </small>
							<small> Productos : </small>
							<small class='montototal'> 
								S/ {{number_format(round($listacarrito->sum('precio'),2),2,'.','')}}
							</small>
						</div>
						
					</div>
				</div>


				<div class='detalles'>

				  <div class='row'>
				    <div class='col-md-12'>

	            	@if(count($listacarrito)>0) 
  
				      <div class="carousel slide media-carousel" id="media">
				        <div class="carousel-inner">

				        {{--*/ $sw = 0 /*--}}
				        {{--*/ $count = 0 /*--}}		

				            @foreach ($listacarrito as $item)



				            	@if($sw==0) 
						          <div class="item  active">
						            <div class="detalle row">
						          {{--*/ $sw = 1 /*--}}  	
				            	@else
				            		@if($count%2==0) 
							          <div class="item">
							            <div class="detalle row">
						            @endif
				            	@endif

				              	<div class="col-xs-6 sinpadding">
					              	<div class='col-xs-12 col'>

						              	<div class="borderigth sinpadding col-xs-10">

						              		<div class='titulo'>
						              			<div class='producto'>1 X {{$item->descripcion}}</div>
						              			<div class='cal'>100 CAL</div>
						              			<div class='precio'>S/ {{number_format(round($item->precio,2),2,'.','')}}</div>
						              		</div>
						              		<div class='caracteristicas'>
						              			<div class="col-xs-6">
							              			<li>- Sin azucar</li>
							              			<li>- Sin azucar</li>					              				
						              			</div>
						              			<div class="col-xs-6">
							              			<li>- Sin azucar</li>
							              			<li>- Sin azucar</li>					              				
						              			</div>						              			
					              			
						              		</div>

						              	</div>	

						              	<div class="col-xs-2">
						              		<div class='btneditar'>
						              			<button type="submit" class="btnfrank btneditar btn btn-default" >EDITAR</button>
						              		</div>	
						              	</div>				              	
						            </div>  	
				              	</div>  

			              	
				            	{{--*/ $count = $count + 1 /*--}}
				            	@if($count == count($listacarrito)) 
						            </div>
						          </div>
						        @else
					            	@if($count%2==0) 
							            </div>
							          </div>
							        @endif	
						        @endif
				            @endforeach
									                            


				        </div>
				        <a data-slide="prev" href="#media" class="left carousel-control">‹</a>
				        <a data-slide="next" href="#media" class="right carousel-control">›</a>
				      </div> 

	            	@else
	            		<h4 class='sinproductos'>Seleccione Un Producto</h4>
	            	@endif

				    </div>
				  </div>						

				</div>



				<div class='funcion'>
					<div class="row"> 
						<div class='col-xs-6'>
							<a href="{{ url('/autoservicio/limpiar/') }}" class="btncancelar btn btn-default">
		                        CANCELAR
		                    </a>
						</div>	
						<div class='col-xs-6'>
							<a href="{{ url('/autoservicio/comprobantedepago') }}" class="btnaceptar btn btn-default">
		                        ACEPTAR
		                    </a>
						</div>							
					</div>
				</div>

			</div>
	</div>


</div>


<!-- Modal -->
<div id="modalproducto" class="modal  fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog  modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">DETALLE DEL PRODUCTO</h4>
      </div>
      <div class="modal-body detalleproducto">






      </div>
    </div>
  </div>
</div>


@stop
@section('script')
	{{ HTML::script('js/incializarscroll.js');}}
	<script type="text/javascript">


		$(".detalleproducto").on('click','#confirmarproducto', function() {

			var id  	 = $(this).attr('data');
			var prefijo  = $(this).attr('data-prefijo');

	        $.ajax({
	            type	: 	"POST",
	            url		: 	"/APPCOFFEE/autoservicio/ajax-carrito-compra",
	            data	: 	{
	            				id : id,
	            				prefijo : prefijo
	            	 		},
	            success: function (data) {

	            	$(".menufooter").html(data);
	            	$('#modalproducto').modal('hide');

	            },
	            error: function (data) {
	                $(".detalleproducto").html("Error al Buscar .......");
	            }
	        });

	    });	



		$(".detalleproducto").on('click','#cancelarproducto', function() {
	    	$('#modalproducto').modal('hide');
	    });	


		$(document).ready(function() {
		  $('#media').carousel({
		    pause: true,
		    interval: false,
		  });
		});

 

		$(".productos").on('click','.producto', function() {

			var id  	 = $(this).attr('data');
			var prefijo  = $(this).attr('data-prefijo');
			
			$(".detalleproducto").html("Buscando Producto.....");


	        $.ajax({
	            type	: 	"POST",
	            url		: 	"/APPCOFFEE/autoservicio/ajax-detalle-producto",
	            data	: 	{
	            				id : id,
	            				prefijo : prefijo
	            	 		},
	            success: function (data) {
	            	$(".detalleproducto").html(data);
	            },
	            error: function (data) {
	                $(".detalleproducto").html("Error al Buscar .......");
	            }
	        });


	    });	




	    $('.cajacategoria').on('click', function(event){

	    	var etiqueta  = $(this).attr('data');
			$(".productos").html("Buscando Productos.....");

	        $.ajax({
	            type	: 	"POST",
	            url		: 	"/APPCOFFEE/autoservicio/ajax-productos-categoria",
	            data	: 	{
	            				etiqueta : etiqueta
	            	 		},
	            success: function (data) {
	            	$(".productos").html(data);
	            },
	            error: function (data) {
	                $(".productos").html("Error al Buscar .......");
	            }
	        });

	    });	






	</script>
@stop

