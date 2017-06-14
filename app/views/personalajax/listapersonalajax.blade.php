<table data-filter="#filter" class="table demo" data-page-size="30">
  	<thead>
        <tr>
        	<th data-class="expand" >
            	DNI
          	</th>
          	<th >
            	Nombres
          	</th>
          	<th>
            	Etapa
          	</th>
          	<th >
            	Estado
          	</th>
          	<th >
            	Proceso
          	</th>          	
        </tr>
  	</thead>
  	<tbody>
  		@foreach($listapostulante as $item)
    	<tr>
    		
    			<td>{{$item->Dni}}</td>
    			<td>{{$item->Nombre}}</td>
    			<td>
    				{{--*/ $estado  = PEREstadoPostulante::where('Estado','=',$item->Estado)->first(); /*--}}
    				{{$estado->Nombre}}
    			</td>
        		<td>
					@if($item->EstadoCulmino == '') 
					    <strong style='color:#4cae4c;'>En Proceso</strong>	
					@else
						<strong style='color:#d43f3a;'>Termino</strong>
					@endif
        		</td>
    			<td>
					@if($item->EstadoCulmino == '')
					    <div class="btn-group">
						    <button type="button" class="btn btn-default dropdown-toggle"
						            data-toggle="dropdown">
						      Opciones
						      <span class="caret"></span>
						    </button>				    	
						    <ul class="dropdown-menu menulistas">
						      	<li class=''><a href="{{ url('/proceso-seleccion-postulante/'.Hashids::encode(substr($idsolicitud, -12)).'/'.Hashids::encode(substr($item->Id, -12)).'/'.$idopcion)}}" class='' >Continuar</a></li>
						    </ul>
						</div>
					@endif    				

    			</td>        		

        </tr>
        @endforeach
  	</tbody>
</table> 






