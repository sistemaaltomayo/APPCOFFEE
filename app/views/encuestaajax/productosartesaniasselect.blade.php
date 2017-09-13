
@if (count($listaproducto)>0) 

<div class="input-group filtro">
      <input type="text" class="form-control" id="filtroproducto" onkeyup="myfiltro()" placeholder="Buscar Producto">
      <span class="input-group-addon">{{count($listaproducto)}} Filas</span>
</div>

<div class="table-container">
    <table class="table table-filter">
        <tbody id="tablafiltro">


        @foreach($listaproducto as $item)
            <tr class='filaproducto' id='{{$item->codigoproducto}}'>
                <td>
                    <div class="media">
                        <a href="#" class="pull-left">
                            @if($item->imagen == '') 
                                <img src="{{URL::asset('/imgartesania/000000.png')}}" class='media-photo'>
                            @else 
                                <img src="{{URL::asset('imgartesania/'.$item->imagen)}}" class='media-photo'>
                            @endif
                            
                            
                        </a>
                        <div class="media-bodyy">
                            <span class="media-meta pull-right">(ARTESANIA)</span>
                            <h4 class="title">
                                {{$item->codigoproducto}}
                                <span class="pull-right pagado">S/. {{number_format($item->precio, 2, '.', '')}}</span>
                            </h4>
                            <p class="summary">{{$item->descripcion}}</p>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach



        </tbody>
    </table>
</div>

@else

    <h2 style = 'text-align:center;'>--------------- No hay registros ---------------</h2>


@endif

<script>

        function myfiltro() {
          // Declare variables 
          var input, filter, table, tr, td, i;
          input = document.getElementById("filtroproducto");
          filter = input.value.toUpperCase();
          table = document.getElementById("tablafiltro");
          tr = table.getElementsByTagName("tr");

          // Loop through all table rows, and hide those who don't match the search query
          for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
              if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            } 
          }
        }

</script>