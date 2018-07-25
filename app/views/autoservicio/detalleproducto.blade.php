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
					<h1>DETALLA DEL PEDIDO</h1>
				</div>
				<div class='col-xs-4'>
					<h1 class='textcoffee'>COFFEE & ARTS</h1>
				</div>
			</nav>
	</div>


	<div class="row paginadetallepedido"> 

		<div class='col-xs-12 col-xs-offset-0 col-md-6 col-md-offset-3'>

			<div class='logo'>
				{{ HTML::image('img/logotab.png', 'logo coffee and arts') }}
			</div>
			<div class="titulo">
				<h1>¿ SU ORDEN ES CORRECTA ?</h1>
			</div>			



			<div class='detalles'>

			  <div class='row'>
			    <div class='col-md-12'>

	

			            @foreach ($listacarrito as $item)

					        <div class="item active">
					            <div class="detalle row">
					              	<div class="col-xs-12">
						              	<div class='col-xs-12 col'>

							              	<div class="borderigth sinpadding col-xs-12">

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
				              	
							            </div>  	
					              	</div>  
					            </div>
					        </div>

			            @endforeach
								                                                     
			    </div>
			  </div>						

			</div>

			<div class='row'>
			    <div class='col-xs-12'>
			    	<div class='col-xs-12'>
				    	<div class='col-xs-6'>
							<div class="total">
								<h4>TOTAL</h4>
							</div>
						</div>	
				    	<div class='col-xs-6'>
							<div class="montototal">
								<h4>S/ 30.00</h4>
							</div>
						</div>	
					</div>
				</div>	
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

