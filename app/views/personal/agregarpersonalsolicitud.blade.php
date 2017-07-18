@extends('template')
@section('style')
 	{{ HTML::style('/css/select/bootstrap-select.min.css') }}
    {{ HTML::style('/css/cssPersonal.css') }}
@stop

@section('section')

<div class="mensaje-error"></div>

@if (Session::get('alertaMensajeGlobalE'))
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>¡Error!</strong> {{ Session::get('alertaMensajeGlobalE') }}
</div>
@endif


<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<div class="msj"></div>
	<h4 style="text-align:center;">Agregar Postulante Solicitud</h4>

</div>


@if(count($errors)>0)
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      @foreach($errors->all() as $error)
         <strong>Error!</strong> {{$error}}<br>
      @endforeach 
  </div>
@endif




<div class="container">
	<div class="row">

	  	<div class="terminopersonal paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
	  		<h4 class='etapasnumero'><strong style='color:#08257C;font-size:1.2em;'>(1/8)</strong></h4>
	  		<!-- , 'target' => '_blank' -->
	  		{{Form::open(array('method' => 'POST', 'url' => '/insertar-termino-condicion/'.$idOpcionRolPlus , 'target' => '_blank' ))}}

			<div class="panelespersonal col-xs-12">

				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">Terminos y Condiciones del Puesto a Postular
						</h3>
					</div>

					<div class="panel-body">

						<div class="col-xs-12" style='margin-bottom:30px;margin-top:25px;' >
								<video width="100%" height="350" id="Video1">
								  <source src="/APPCOFFEE/video/terminosycondiciones.mp4" type="video/mp4">
								  <source src="movie.ogg" type="video/ogg">
								  No es commpatible.
								</video>

						</div>

						<button type="button" class="btn btn-success grupo-imput" id="play" onclick="vidplay()">PLAY</button>					
					    <div class="checkvideo input-group grupo-imput" style='display:none;'>
					      <span class="input-group-addon">
					        <input type="checkbox" id='videover' name='videover'>
					      </span>
					      <input type="text" class="form-control" style='font-weight:bold;' value ='¿Entendio el video (puede verlo nuevamente)?' readonly />
					    </div>

					    <div id='aceptotermino' style='display:none;'>

							<div class="input-group grupo-imput" >
							    <span class="input-group-addon" id="basic-addon1">Nombre Completo: </span>
								  	{{Form::text('nombretermino','', array('class' => 'form-control control', 'placeholder' => 'Nombre', 'id' => 'nombretermino', 'maxlength' => '200'))}}
							</div>

							<div class="input-group grupo-imput" >
							    <span class="input-group-addon" id="basic-addon1">Apellido Completo: </span>
								  	{{Form::text('apellidotermino','', array('class' => 'form-control control', 'placeholder' => 'Apellido', 'id' => 'apellidotermino', 'maxlength' => '200'))}}
							</div>

							<div class="input-group grupo-imput">
							    <span class="input-group-addon" id="basic-addon1">DNI: </span>
								  	{{Form::text('dnitermino','', array('class' => 'solonumero form-control control', 'placeholder' => 'DNI', 'id' => 'dnitermino', 'maxlength' => '8'))}}
							</div>

							<div class="col-xs-6" style="text-align:center;">
								<input type="submit" id="btnaceptocondicion" name='1' class="btnaceptocondicion btn btn-primary" value="Acepto">
							</div>

							<div class="col-xs-6" style="text-align:center;">
								<input type="submit" id="btnaceptocondicion" name='0'  class="btnaceptocondicion btn btn-danger" value="No Acepto">
							</div>

					    </div>


						<input type="hidden" name="idSolicitud" id="idSolicitud" value='{{$idSolicitud}}'>
						<input type="hidden" name="termino" id="termino" >
						<input type="hidden" name="idopcion" id="idopcion" value='{{$idopcion}}'>
						<input type="hidden" name="cantidadplay" id="cantidadplay" value='0'>
						

					</div>
				</div>
			</div>

			{{Form::close()}}


			<input type="hidden" name="redireccionar" id="redireccionar" value='0'>

	  </div>

	</div>	
</div>

<div class="modal fade" id="modalcargando" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="width:320px;height:310px;margin:0 auto">

        <div class="modal-body">
          	<div class="cargandoreportefail">
				{{ HTML::image('img/cargando1.gif', 'cargando') }}
			</div>
			<p class="msjcargando">Espere por favor</p>
			<p class="msjcargando">Esto puede tardar varios minutos ...</p>

		    <div class="alertajax alert alert-danger ">
		        <a href="javascript:location.reload()" class="btnfail btn btn-xs btn-danger pull-right">Intentar Nuevamente</a>
		        <strong>Error: </strong> <span class='msjfailajax'></span>
		    </div>


        </div>

      </div>
    </div>
</div>






@stop
@section('script')

	{{ HTML::script('js/select/bootstrap-select.min.js'); }}



    <script>

	$('.selectpicker').selectpicker();

	setInterval(bienvenida, 3000);

	function bienvenida(){
		var redireccionar = $("#redireccionar").val();
		if(redireccionar=='1'){
			window.location.href = '/APPCOFFEE/bienvenidos-coffee-and-arts';
		}
	}

	$("#videover").click(function () {
      	if (this.checked){
      		$("#aceptotermino").css("display", "block");
        }else{
		    $("#aceptotermino").css("display", "none");
	   	}
	});

    function vidplay() {
        var video = document.getElementById("Video1");
        var button = document.getElementById("play");
        video.play();
        $("#play").attr("disabled", true);
        var cantidadplay = parseInt($('#cantidadplay').val())+1;
        $('#cantidadplay').val(cantidadplay)
    }

	$("#Video1").on('ended', function(){
		$("#play").attr("disabled", false);
		$(".checkvideo").css("display", "table");
	});


    $("#provincia").change(function(e) {


		    var codprovincia = $('#provincia').val();

			$.ajax(
            {
                url: "/APPCOFFEE/ajax-select-distrito",
                type: "POST",
                data: { codprovincia : codprovincia },

            }).done(function(pagina) 
            {
            	$(".ajaxdistrito").html(pagina);

            }); 

    });

	$(".btnaceptocondicion").click(function(e) {

		var aleatorio = Math.floor((Math.random() * 500) + 1);
	 	var alertaMensajeGlobal='';
	 	idsolicitud = $('#idsolicitud').val();
	 	termino     = $(this).attr("name");
	 	nombre      = $('#nombretermino').val();
	 	dni      	= $('#dnitermino').val()
		
		if(!valVacio($('#nombretermino').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Nombre es obligatorio<br>';}
		if(!valVacio($('#apellidotermino').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Apellido es obligatorio<br>';}
		if(!valVacio($('#dnitermino').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo DNI  es obligatorio<br>';}
        if(!CantidadNumeros($('#dnitermino').val(),8)){ alertaMensajeGlobal+='<strong>Error!</strong>El campo DNI debe tener 8 digitos<br>';}
		$("#termino").val($(this).attr("name"));

      
		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);
			return false;

		}else{	

			$("#redireccionar").val('1');
			$("#modalcargando").modal();

		}


	});


    </script>

@stop