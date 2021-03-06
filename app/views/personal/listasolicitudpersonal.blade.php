@extends('template')
@section('style')


    {{ HTML::style('/css/tabla/footable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.sortable-0.1.css') }}
    {{ HTML::style('/css/tabla/footable.paginate.css') }}
    {{ HTML::style('/css/tabla/bootstrapSwitch.css') }}
    {{ HTML::style('/css/font-awesome.min.css') }}
     {{ HTML::style('/css/cssPersonal.css') }}


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
	<h4 style="text-align:center;">Lista Solicitudes Personal <small>(Ultimas 30 Solicitudes)</small></h4>
</div>

<div class="container">

	<div class="row">
		
		<div class="col-xs-12 cabecerageneral">

			<div class="col-xs-12 buscaragregar">
				<div class="filter col-xs-12 col-sm-8  col-md-8 col-lg-6">
					<input id="filter" class="form-control control" placeholder="Buscar" type="text" />
				</div>
				<div class="agregar col-xs-12 col-sm-4  col-md-4 col-lg-6">

                    <a href="{{ url('/insertar-solicitud-personal/'.$idOpcion) }}" class="btn btn-success">
                        <span class="glyphicon glyphicon-plus"></span> Agregar
                    </a>

				</div>
			</div>


			<div class="listatabla col-xs-12">
				<div class="listatoma">

				    <table data-filter="#filter" class="table demo" data-page-size="30">
				      	<thead>
					        <tr>
					        	<th data-class="expand" >
					            	Correlativo
					          	</th>
					          	<th >
					            	Zona
					          	</th>
					          	<th >
					            	Motivo
					          	</th>
					          	<th data-hide="phone,tablet">
					            	Cargo
					          	</th>
					          	<th data-hide="phone,tablet">
					            	Estado
					          	</th>					          	
					          	<th>
					            	Fecha Creación
					          	</th>					          	
					          	<th data-hide="phone,tablet">
					            	Usuario Creación
					          	</th>					          	
					          	<th data-hide="phone,tablet">
					            	Opciones
					          	</th>

					        </tr>
				      	</thead>
				      	<tbody>
				      		@foreach($listaSolicitudPersonal as $item)


				        			{{--*/ $class = '' /*--}}
				        			{{--*/ $fila = '' /*--}}
							    	{{--*/ $estado = '' /*--}}
								    @if($item->Estado == 'ES') 
							      		{{--*/ $estado = 'Espera' /*--}}
							      		{{--*/ $class = 'notactiveurl' /*--}}
							      		{{--*/ $fila = 'filaespera' /*--}}	
							      	@else
							      		{{--*/ $estado = 'Aceptado' /*--}}
							      		{{--*/ $fila = 'filaactivo' /*--}}		      		
								    @endif



				        	<tr class='{{$fila}}'>




				        			<td>{{$item->Correlativo}}</td>
				        			<td>{{$item->Nombre}}</td>
					        		<td>{{$item->MotivoSolicitud}}</td>
					        		<td>{{$item->Cargo}}</td>
					        		<td>{{$estado}}</td>
					        		<td>{{date_format(date_create($item->FechaCrea), 'm/d/Y H:i:s')}}</td>
					        		<td>{{$item->Nombreusuario}} {{$item->Apellidousuario}}</td>


					        		<td>
									    <div class="btn-group">
										    <button type="button" class="btn btn-default dropdown-toggle"
										            data-toggle="dropdown">
										      Opciones
										      <span class="caret"></span>
										    </button>

										    <ul class="dropdown-menu menulistas">

										    	

											    <li>
											      	<a href="{{ url('/modificar-solicitud-personal/'.$idOpcion.'/'.$item->Id) }}">Modificar</a>
											    </li>

										      	@foreach($listaOpcionPlus as $itemp)
											      	<li class='{{$class}}'>
											      		<a href="{{ url('/'.$itemp->Pagina.'/'.Hashids::encode(substr($itemp->Id, -12)).'/'.Hashids::encode(substr($item->Id, -12)).'/'.$idOpcion)}}">{{$itemp->Nombre}}</a>
											      	</li>										    	
										      	@endforeach

										        <li class='topsolicitud' id='{{$item->Id}}'><a href="#" class='postulantessolicitud' data-toggle="modal" data-target="#modallistapostulante">Lista Postulante</a></li>

										    </ul>
										</div>
					        		</td>

				            </tr>
				            @endforeach
				      	</tbody>
				      	<tfoot class="footable-pagination">
				        	<tr>
				          		<td colspan="8"><ul id="pagination" class="footable-nav"></ul></td>
				        	</tr>
				      	</tfoot>
				    </table>  
				    <input type="hidden" name="idOpcion" id="idOpcion" value="{{$idOpcion}}">
				</div>
			</div>

		</div>

	</div>	
</div>


 <div class="modal fade" id="modallistapostulante" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style = 'text-align: center;font-style: italic;font-weight: bold;'>LISTA DE POSTULANTES </h4>
        </div>
        <div class="modal-body ajaxlistapostulante">



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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

	<script type="text/javascript">

	    $(function() {
	      $('table').footable();
	    });

	    $(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})

		$(".postulantessolicitud").click(function(e) {

			$(".ajaxlistapostulante").html("");
			var idsolicitud = $(this).parent('.topsolicitud').attr("id");
			var idopcion    = $("#idOpcion").val();

			$.ajax(
	        {
	            url: "/APPCOFFEE/lista-postulante-solicitud-ajax",
	            type: "POST",
	            data: { idsolicitud : idsolicitud  , idopcion : idopcion },

	        }).done(function(pagina) 
	        {
				$(".ajaxlistapostulante").html(pagina); 				
	        });
		});		


	</script>

@stop