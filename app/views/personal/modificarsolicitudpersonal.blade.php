@extends('template')
@section('style')
    {{ HTML::style('/css/cssPersonal.css') }}
@stop

@section('section')

<div class="mensaje-error"></div>

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<h4 style="text-align:center;">Modificar Solicitud Personal</h4>
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

	  	<div class="paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
	  		
			{{Form::open(array('method' => 'POST', 'url' => '/modificar-solicitud-personal/'.$idOpcion.'/'.$persolicitud->Id, 'files' => true))}}
			
			<div class="panelespersonal col-xs-12">

				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">Solicitud del Personal</h3>
					</div>
					<div class="panel-body">


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Motivo: </span>
							{{ Form::select('motivosolicitud', $combomotivosolicitud, array(),['class' => 'selectmotivosolicitud form-control control' , 'id' => 'motivosolicitud', 'disabled' => 'disabled']) }}
						</div>

						@if($persolicitud->IdMotivoSolicitud == 'LIM01CEN000000000001')

							<div class='reemplazopersonal' style='display:inline-block;'>

								<div class="input-group grupo-imput">
								    <span class="titulospan input-group-addon" id="basic-addon1">PERSONAL Y MOTIVO DE REEMPLAZO: <br><li>(Seleccionar el nombre del personal y motivo de reemplazo)</li> </span>
								</div>

                            {{--*/ $listapersonal = PERSolicitudPersonalMotivo::where('IdSolicitud','=',$persolicitud->Id)->get() /*--}}

							    <table id='listapersonalmotivo'  class="table demo" >
							      	<thead>
								        <tr>
								        	<th>
								            	Usuario
								          	</th>
								          	<th >
								            	Motivo
								          	</th>
								          	
								        </tr>
							      	</thead>
							      	<tbody>
		                                @foreach($listapersonal as $item)
		                                <tr>
		                                        <td>{{$item->Usuario}}</td>
		                                        <td>{{$item->Remplazo}}</td>
		                                </tr>
		                                 @endforeach
							      	</tbody>
							    </table> 

							</div>

							<div class='autorizacion'>

								<div class="input-group grupo-imput">
								    <span class="titulospan input-group-addon" id="basic-addon1">AUTORIZACION DE INCREMENTO DE PERSONAL: <br><li>(Indicar quien autorizo el incremento y por que medio)</li> </span>
								</div>

								<div class="input-group grupo-imput">
									<span class="input-group-addon" id="basic-addon1"></span>
								  	{{Form::text('autorizacion',$persolicitud->Autorizacion, array('class' => 'form-control control', 'placeholder' => 'Autorización', 'id' => 'autorizacion', 'maxlength' => '1000', 'disabled' => 'disabled'))}}
								</div>

							</div>

						@else

							<div class='reemplazopersonal' >

								<div class="input-group grupo-imput">
								    <span class="titulospan input-group-addon" id="basic-addon1">PERSONAL Y MOTIVO DE REEMPLAZO: <br><li>(Seleccionar el nombre del personal y motivo de reemplazo)</li> </span>
								</div>

							</div>

							<div class='autorizacion' style='display:inline-block;'>

								<div class="input-group grupo-imput">
								    <span class="titulospan input-group-addon" id="basic-addon1">AUTORIZACION DE INCREMENTO DE PERSONAL: <br><li>(Indicar quien autorizo el incremento y por que medio)</li> </span>
								</div>

								<div class="input-group grupo-imput">
									<span class="input-group-addon" id="basic-addon1"></span>
								  	{{Form::text('autorizacion',$persolicitud->Autorizacion, array('class' => 'form-control control', 'placeholder' => 'Autorización', 'id' => 'autorizacion', 'maxlength' => '1000' , 'disabled' => 'disabled'))}}
								</div>

							</div>	

						@endif

					</div>
				</div>


				<div class="panel panel-success">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">Datos del Cargo</h3>
					</div>
					<div class="panel-body">
						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Cargo o puesto a ocupar: </span>
							{{ Form::select('tipousuario', $combotipousuario, array(),['class' => 'selecttipousuario form-control control' , 'id' => 'tipousuario' , 'disabled' => 'disabled']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Número Vacantes: </span>
						  	{{Form::number('numerovacantes',$persolicitud->NumeroVacantes, array('class' => 'form-control control', 'id' => 'numerovacantes' , 'min' => '1' , 'disabled' => 'disabled'))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">Observación:  </span>
						</div>

						<div class="input-group grupo-imput textarea">
							{{ Form::textarea('observacion', $persolicitud->Observacion, ['class' => 'form-control', 'rows' => '5','placeholder' => 'Observación...', 'id' => 'observacion', 'maxlength' => '1000' ]) }}
						</div>

					</div>
				</div>

	
			</div>

			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
				<input type="submit" id="btnmodificarsolicitudpersonal" class="btn btn-primary" value="Guardar">
			</div>
			{{Form::close()}}

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

    <script>


	$( ".selectmotivosolicitud" ).change(function() {
	  
	  
	    if (this.value!=0) {

	    	if (this.value=='LIM01CEN000000000001'){

			    $('.paneltop .reemplazopersonal').css("display", "block");
			    $('.paneltop .autorizacion').css("display", "none");
			    $("#autorizacion").val("");

			}else{

			    $('.paneltop .reemplazopersonal').css("display", "none");
			    $('.paneltop .autorizacion').css("display", "block");

			    $("#usuarior option[value='0']").prop("selected", true);
			    $("#motivoreemplazo option[value='0']").prop("selected", true);

			}
		} else{
			$('.paneltop .reemplazopersonal').css("display", "none");
			$('.paneltop .autorizacion').css("display", "none");
		}


	});




	$("#btnmodificarsolicitudpersonal").click(function(e) {

	 	var alertaMensajeGlobal='';
		
	 	if(!valSelect($('#motivosolicitud').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Motivo seleccionado es invalido<br>';}

		if(valSelect($('#motivosolicitud').val(),0)){ 

			if($('#motivosolicitud').val()=='LIM01CEN000000000001'){

				if(!valSelect($('#usuarior').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Personal de Reemplazo seleccionado es invalido<br>';}

				if(!valSelect($('#motivoreemplazo').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Motivo Reemplazo seleccionado es invalido<br>';}

			}else{
					if(!valVacio($('#autorizacion').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Autorización es obligatorio<br>';}

			}	

		}	


	 	if(!valSelect($('#tipousuario').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Cargo o puesto a ocupar seleccionado es invalido<br>';}
	 	if(!valSelect($('#local').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Area seleccionado es invalido<br>';}
	 	if(!numeroentre($('#numerovacantes').val(),1,10)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo Número Vacantes debe ser de 1 a 10<br>';}


		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);
			return false;
		}else{	
			$("#modalcargando").modal();
			return true; 
		}


	});

    </script>

@stop