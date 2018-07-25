@extends('template')
@section('style')


    {{ HTML::style('/css/tabla/footable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.sortable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.paginate.css') }}
    {{ HTML::style('/css/tabla/bootstrapSwitch.css') }}
    {{ HTML::style('/css/font-awesome.min.css') }}
    {{ HTML::style('/css/cssPersonal.css') }}
	<style>
		.position{
			position: relative;	
		    text-align: center;
		    font-size: 1.8em;			
		}
		.marcado{
			background: red;
		    color: #fff;
		    text-align: center;
		    font-size: 1.8em;

		}	
		.tardanza{
			color: #08257C;
		    width: 19px;
		    font-size: 0.45em;
		    border: 2px solid #08257C;
		    position: absolute;
		    top: -2px;
		    right: 0px;
		    border-radius: 15px;
		}
		.selectzona{
			display: inline-block;
			width: 80%;
			font-size: 0.8em;
			border-bottom: 1px solid #ddd !important;
		}
		.selectzonapdf{
			display: inline-block;
			width: 18%;
			height: 41px;
			border-bottom: 1px solid #ddd !important;
		}	
		.list-group-item {
			border: 0px;
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
	<h4 style="text-align:center;">Asistencia del Personal del dia <small>({{date_format(date_create($hoy), 'd/m/Y')}})</small></h4>
</div>

<div class="container">

	<div class="row">
		
		<div class="col-xs-12 cabecerageneral">




			<div class="listatoma col-xs-12">
			    <table  data-filter="#filter" class="table demo" data-page-size="100">
			      	<thead>
				        <tr>
				          	<th data-class="expand" >
				            	Zona
				          	</th>
				          	<th>
				            	Empleado
				          	</th>
				          	<th>
				            	Hora Inicio
				          	</th>
				          	<th>
				            	Hora Salida
				          	</th>
				          	<th class='marcado'>
				            	Entrada  (Marco)
				          	</th>
				          	<th class='marcado'>
				            	Salida  (Marco)
				          	</th>
				          	<th>
				            	Dia Semana 
				          	</th>	          	
				        </tr>
			      	</thead>
			      	<tbody id="fbody">

			      		@foreach($listaAsistencia as $item)
			        	<tr>
			        				
			        		{{--*/ $estado = '' /*--}}

		        			@if($item->Entrada == 1)
		        				{{--*/ $estado = 'T' /*--}}
		        			@else
			        			@if($item->Salida == 1)
			        				{{--*/ $estado = 'F' /*--}}
			        			@else
			        				{{--*/ $estado = '' /*--}}
			        			@endif        			
		        			@endif


			        		
			        			<td>{{$item->NombreLocal}}</td>
			        			<td>{{$item->NombreEmpleado}}  {{$item->ApellidoEmpleado}}</td>
			        			<td>{{$item->HorarioInicio}}</td>
			        			<td>{{$item->HorarioFinal}}</td>
				        		<td class='position @if($item->FechaHoraEntrada != '') marcado @endif'>
				        			{{ $item->FechaHoraEntrada}}

				        			@if($estado != '')
				        				<p class='tardanza'>{{$estado}}</p>
				        			@endif 
				        		</td>
				        		<td class='@if($item->FechaHoraSalida != '') marcado @endif'>
				        			{{$item->FechaHoraSalida}}
				        		</td>
				        		<td>{{$item->DiaSemana}}</td>

			            </tr>
                       @endforeach
			      	</tbody>
			      	<tfoot class="footable-pagination">
			        	<tr>
			          		<td colspan="7"><ul id="pagination" class="footable-nav"></ul></td>
			        	</tr>
			      	</tfoot>
			    </table> 
			</div>









		</div>

	</div>	
</div>


</div>



@stop

@section('script')

	<!-- TABLA JS -->
	{{ HTML::script('/js/tabla/footable.js'); }}
	{{ HTML::script('/js/tabla/footable.sortable.js'); }}
	{{ HTML::script('/js/tabla/footable.filter.js'); }}
	{{ HTML::script('/js/tabla/footable.paginate.js'); }}

@stop