@extends('templateautoservicio')
@section('section')
<div class="container">
	<div class="row">  
			<nav class='menu'>
				<div class='col-xs-2'>
					<a href="{{ url('/autoservicio/menu/falta') }}" class="btn btn-default">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					</a>
				</div>	
				<div class='col-xs-6'>
					<h1>COMPROBANTE DE PAGO</h1>
				</div>
				<div class='col-xs-4'>
					<h1 class='textcoffee'>COFFEE & ARTS</h1>
				</div>
			</nav>
	</div>


	<div class="row comprobantedepago"> 

		<div class='col-xs-12 col-xs-offset-0 col-md-6 col-md-offset-3'>

			<div class='logo'>
				{{ HTML::image('img/logotab.png', 'logo coffee and arts') }}
			</div>
			<div class="titulo">
				<h1>MONTO TOTAL</h1>
			</div>			
			<div class="titulo">
				<h1>S/ 25.00</h1>
			</div>
			<div class="tab_container">
				<input id="tab1" type="radio" name="tabs" checked>
				<label for="tab1"><i class="fa fa-pencil-square-o"></i><span>Boleta</span></label>

				<input id="tab2" type="radio" name="tabs">
				<label for="tab2"><i class="fa fa-pencil-square-o"></i><span>Factura</span></label>



				<section id="content1" class="tab-content">

	  	        	<div class="input-group">
	  	        		<span class="input-group-addon" id="basic-addon2">
					       <span class="glyphicon glyphicon-user" aria-hidden="true" style="color:#286090"></span>
					  	</span>
					  	<input type="text" name="txtNombres" id="nombre" maxlength="40" class="form-control" placeholder="Nombre Completo" aria-describedby="basic-addon2">
					</div>

					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-qrcode" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtDni" id="dni" maxlength="8" class="form-control" placeholder="Dni">
					</div>
					
					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-envelope" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtCorreo" id="correo" maxlength="80" class="form-control" placeholder="Correo" >
					</div>				

				</section>

				<section id="content2" class="tab-content">

	  	        	<div class="input-group">
	  	        		<span class="input-group-addon" id="basic-addon2">
					       <span class="glyphicon glyphicon-user" aria-hidden="true" style="color:#286090"></span>
					  	</span>
					  	<input type="text" name="txtNombres" id="nombre" maxlength="40" class="form-control" placeholder="Razón solcial" aria-describedby="basic-addon2">
					</div>

					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-qrcode" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtDni" id="dni" maxlength="11" class="form-control" placeholder="Ruc">
					</div>
					
					<div class="input-group">
			        	<span class="input-group-addon"  id="basic-addon2">
					       <span class="glyphicon glyphicon-envelope" style="color:#286090" aria-hidden="true"></span>
					  	</span>
					  	<input type="text" name="txtCorreo" id="correo" maxlength="80" class="form-control" placeholder="Correo" >
					</div>	
			      
				</section>


			</div>



			<div class="btncdp row"> 

				<div class='divcancelar col-xs-6'>
					<a href="{{ url('/autoservicio/menu/falta/') }}" class="btncancelar btn btn-default">
                        CANCELAR
                    </a>
				</div>	
				<div class='divaceptar col-xs-6'>
					<a href="{{ url('/autoservicio/detalle-pedido') }}" class="btnaceptar btn btn-default">
                        ACEPTAR
                    </a>
				</div>	

			</div>



		</div>	



	</div>




</div>

@stop
@section('script')
	<script type="text/javascript">

	</script>
@stop

