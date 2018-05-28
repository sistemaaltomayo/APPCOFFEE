@extends('template')
@section('style')
 	{{ HTML::style('/css/select/bootstrap-select.min.css') }}
<style>


.test {
  *zoom: 1;
}
.test:before, .test:after {
  content: "";
  display: table;
}
.test:after {
  clear: both;
}


.cool-gallery {
  *zoom: 1;
}
.cool-gallery:before, .cool-gallery:after {
  content: "";
  display: table;
}
.cool-gallery:after {
  clear: both;
}
.cool-gallery li {
  list-style: none;	
  position: relative;
  float: left;
  width: 25%;
  box-sizing: border-box;
  padding: 10px;
}

.cool-gallery li .inactivo{
  border: 2px solid #eeeeee !important;
}
.cool-gallery li a {
  display: block;
  height: 100%;
  padding: 15px;
  padding-bottom: 10px;
  border: 2px solid #0b56a8;
  border-radius: 2px;
  text-decoration: none;
  font-size: 1.1em;
  background-color: white;
  color: inherit;
  box-shadow: 0 3px 4px rgba(0, 0, 0, 0.1);
}
.cool-gallery li a .image-wrapper {
  position: relative;
  height: 90px;
  overflow: hidden;
}
.cool-gallery li a .image-wrapper img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  min-height: 100%;
  min-width: 100%;
}
.cool-gallery li a .replace-caption {
  display: none;
  width: 100%;
  height: 25px;
  line-height: 25px;
  padding: 0;
  margin-top: 10px;
  border: none;
  text-align: center;
  font-size: 1.1em;
  box-sizing: border-box;
  outline: none;
  background-color: white;
}
.cool-gallery li a .replace-caption:hover {
  background-color: #ffffdf;
}
.cool-gallery li a .replace-caption:focus {
  background-color: white !important;
}
.cool-gallery li .select-picture {
  position: absolute;
  top: 30px;
  left: 30px;
}
.cool-gallery li.selected a {
  border-color: #0b56a8;
}
.cool-gallery li.dragging a {
  border-color: #090 !important;
}

.cool-gallery li .nombre{
    font-size: 12px;
    text-align: center;
    font-weight: bold;
    position: absolute;
    top: 62px;
    width: 166px;
}

.cool-gallery li .precio{
	font-size: 17px;
    text-align: center;
    font-weight: bold;
    position: absolute;
    top: 40px;
    left: 39%;
    color: #3c763d;
}

.cool-gallery li .item{
	font-size: 15px;
    text-align: center;
    font-weight: bold;
    position: absolute;
    top: 104px;
    right: 23px;
}
.filtros{
	margin-top: 15px;
	margin-bottom: 15px;
	display: none;
}
.filtros .ordenar a{
	float: right;
}
.filtros .agregar button{
	margin-left: 19px !important;
}    

</style>


@stop


@section('section')

	@if (Session::get('alertaMensajeGlobal'))
	  <div class="alert alert-success alert-dismissible" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	         <strong>Bien Hecho!</strong> {{ Session::get('alertaMensajeGlobal') }}
	  </div>
	@endif  

	@if (Session::get('alertaMensajeGlobalE'))
	<div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>¡Error!</strong> {{ Session::get('alertaMensajeGlobalE') }}
	</div>
	@endif 


<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<div class="permisomsj">

	</div>
	<h4 style="text-align:center;">GESTION CARTA </h4>
</div>
<div class="container">

	<div class="row">
		
		<input type="hidden" name="hcategoria" id="hcategoria" value="">

		<div class="listatabla permisos col-xs-12">	
			<div class="listatoma ">

				<div class="container">
					<div class=" col-sm-4 col-md-2">
					    <nav class="nav-sidebar">
							<ul class="tabscarta nav tabs">
								{{--*/ $sw = 1 /*--}}
							  	@foreach($listaCarta as $item)

						          	<li class="selectcat" id="{{$item->Etiqueta}}"><a href="#tab{{$item->Etiqueta}}" data-toggle="tab">{{$item->Nombres}}</a></li>

						          	{{--*/ $sw = $sw + 1 /*--}}
					         	@endforeach                               
							</ul>
						</nav>
					</div>

					<div class="tab-content  col-sm-8 col-md-10">

						<div class='filtros col-xs-12'>

						  <div class="agregar col-xs-10">


						  		<div class='selectproducto'>
								    <select class="selectpicker" data-live-search="true">
								        <option value='0' data-tokens="Seleccione Producto">Seleccione Producto</option>
									  	@foreach($listaProducto as $item)

								          	<option value='{{$item->id}}' data-tokens="{{$item->codigoproducto}}-{{$item->descripcion}}">{{$item->codigoproducto}} - {{$item->descripcion}}</option>

							         	 @endforeach 
								    </select>
								    <button class="btnagregar btn btn-success" id="" type="button">
										<i class="fa fa-plus fa-lg"></i>
									</button> 
						  		</div>

  

						  </div>
						  <div class="ordenar col-xs-2">
						    <a href="#" class="btn btn-success">
						        Ordenar
						    </a> 
						  </div>

						</div>

						{{--*/ $sw = 1 /*--}}
					  	@foreach($listaCarta as $item)

					  		<div class="tab-pane @if ($sw == 1) active @endif text-style" id="tab{{$item->Etiqueta}}">
					  			@if ($sw == 1) 
					  				Seleccione Categoria
					  			@endif
							</div>
				          	{{--*/ $sw = $sw + 1 /*--}}
				     	 @endforeach  

					</div>
				       
				</div>

			</div>

		</div>

	</div>	
</div>

@stop
@section('script')


{{ HTML::script('/js/select/bootstrap-select.min.js'); }}
<script type="text/javascript">

    $('.ordenar').on('click', function(event){

    	var aleatorio 	= Math.floor((Math.random() * 500) + 1);
    	var data = '';
   		var etiqueta = $('#hcategoria').val();

        $('#tab'+etiqueta+' ul li').each(function(){
        	var id = $(this).attr('data');
        	data = data+id+'***';
        });

    	if(data == ''){
    		msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> No hay productos </strong></div>";
        	$(".permisomsj").append(msj);
    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);
    		return false;
    	}

		$.ajax(
        {
            url: "/APPCOFFEE/ordenar-productos-carta-ajax",
            type: "POST",
            data: { data : data ,etiqueta : etiqueta},

        }).done(function(pagina) 
        {
        	$("#tab"+etiqueta).html(pagina);
        	msj="<div class='rd"+aleatorio+" alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Ordenado exitoso </strong></div>";
    		$(".permisomsj").append(msj); 
    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);
        });



    });

	$(".selectproducto").on('click','.btnagregar', function() {


    	var aleatorio 	= Math.floor((Math.random() * 500) + 1);
    	var idproducto = $('.selectpicker option:selected').val();
    	if(idproducto == '0'){
    		msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Seleccione producto </strong></div>";
        	$(".permisomsj").append(msj);

    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);
    		return false;
    	}


    	var etiqueta = $('#hcategoria').val();
    	var sw = 0;
    
        $('#tab'+etiqueta+' ul li').each(function(){
        	if(idproducto == $(this).attr('name')){
        		sw = 1;
        	}
        });

    	if(sw == 1){
    		msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Producto ya esta registrado </strong></div>";
        	$(".permisomsj").append(msj);

    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);
    		return false;
    	}

		$.ajax(
        {
            url: "/APPCOFFEE/agregar-productos-carta-ajax",
            type: "POST",
            data: { etiqueta : etiqueta, idproducto : idproducto},

        }).done(function(pagina) 
        {
        	$("#tab"+etiqueta).html(pagina);
        	msj="<div class='rd"+aleatorio+" alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Registro exitoso </strong></div>";
    		$(".permisomsj").append(msj); 
    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);
        });


    });




	$(".tab-pane").on('click','.select-picture', function() {

		var aleatorio 	= Math.floor((Math.random() * 500) + 1);
		var id 			= $(this).attr('id');
		var checked 	= 0;
		var padre 		= $(this).parent('a');

		if($(this).is(':checked')){ 
			checked = 1;
			padre.removeClass( "inactivo" );
		}else{
			checked = 0;
			padre.addClass( "inactivo" );
		}

		$.ajax(
        {
            url: "/APPCOFFEE/activo-carta-ajax",
            type: "POST",
            data: { id : id , checked : checked},
        }).done(function(pagina) 
        {
            	msj="<div class='rd"+aleatorio+" alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Actualización exitosa </strong></div>";
        		$(".permisomsj").append(msj);
        });	

    	setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);

	})




    $('.selectcat').on('click', function(event){

	//$(".selectproducto").on('click','.selectcat', function() {

        $('.tab-content .tab-pane').each(function(){
            $(this).html("");
        });

    	var etiqueta = $(this).attr("id");
    	$('#hcategoria').val(etiqueta);
		$(".filtros").css("display", "block");

		$.ajax(
        {
            url: "/APPCOFFEE/listar-select-ajax",
            type: "POST",
            data: { etiqueta : etiqueta},

        }).done(function(pagina) 
        {
        	//console.log(pagina);
        	$(".selectproducto").html(pagina);;
        });	


		$.ajax(
        {
            url: "/APPCOFFEE/listar-productos-carta-ajax",
            type: "POST",
            data: { etiqueta : etiqueta},

        }).done(function(pagina) 
        {
        	$("#tab"+etiqueta).html(pagina);
        });	


    });

</script>

@stop