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