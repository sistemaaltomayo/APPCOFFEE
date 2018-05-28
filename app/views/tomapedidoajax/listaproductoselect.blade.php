<select class="selectpicker" data-live-search="true">
    <option value='0' data-tokens="Seleccione Producto">Seleccione Producto</option>
  	@foreach($listaProducto as $item)

      	<option value='{{$item->id}}' data-tokens="{{$item->codigoproducto}}-{{$item->descripcion}}">{{$item->codigoproducto}} - {{$item->descripcion}}</option>

 	 @endforeach 
</select>
<button class="btnagregar btn btn-success" id="" type="button">
	<i class="fa fa-plus fa-lg"></i>
</button> 

<script type="text/javascript">
	$('.selectpicker').selectpicker('refresh');
</script>