@extends('template')
@section('style')

    {{ HTML::style('/css/select/bootstrap-select.min.css') }}
    {{ HTML::style('/css/tabla/bootstrapSwitch.css') }}
    {{ HTML::style('/css/font-awesome.min.css') }}
    {{ HTML::style('/css/carrusel.css') }}


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
    <h4 style="text-align:center;">LISTA PRODUCTOS ARTESANIA </h4>
</div>

<div class="container">
    <div class="row">

        <div class="col-xs-12 cabecerageneral">


            <div class="col-xs-12">
                <div class="colarte col-xs-6 col-sm-3 col-md-3 col-lg-2 sinpadding">

                        {{ Form::select('region', $comboregion, array(),['class' => 'selectpicker form-control control filtroselect' , 'data-style' => 'btn-primary', 'id' => 'region' , 'data-live-search' => 'true' ]) }}

                </div>
                <div class="colarte col-xs-6 col-sm-3 col-md-3 col-lg-2 sinpadding">
                    {{ Form::select('taller', $combotaller, array(),['class' => 'selectpicker form-control control filtroselect' , 'data-style' => 'btn-info', 'id' => 'taller' , 'data-live-search' => 'true']) }}
                </div>
                <div class="colarte col-xs-6 col-sm-3 col-md-3 col-lg-2 sinpadding">
                    {{ Form::select('materia', $combomateria, array(),['class' => 'selectpicker form-control control filtroselect' , 'data-style' => 'btn-success', 'id' => 'materia' , 'data-live-search' => 'true']) }}
                </div>   
                <div class="colarte col-xs-6 col-sm-3 col-md-3 col-lg-2 sinpadding">
                    {{ Form::select('linea', $combolinea, array(),['class' => 'selectpicker form-control control filtroselect' , 'data-style' => 'btn-warning' , 'id' => 'linea' , 'data-live-search' => 'true']) }}
                </div> 

                <div class="colarte col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">S/.</span>
                        <input type="text" class="decimal form-control" placeholder="P1" id='p1'>
                        <span class="input-group-addon" id="basic-addon1">a S/.</span>
                        <input type="text" class="decimal form-control" placeholder="P2" id='p2'>
                       <span class = "input-group-btn">
                          <button class = "btn btn-default" type = "button" class='btnprecio'>
                            <span class="glyphicon glyphicon-search" style='height: 20px;padding-top: 3px;' aria-hidden="true"></span>
                          </button>
                       </span>                      
                    </div>                    
                </div>

                <div class="colarte col-xs-12 col-sm-6 col-md-6 col-lg-1 buscar">
                    {{ Form::select('producto', $comboproducto, array(),['class' => 'selectpicker form-control control' , 'id' => 'producto' , 'data-live-search' => 'true']) }}
                </div>




            </div>




            <div class='col-xs-12 ajaxlistafiltro'>

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

            </div>


            <div class="col-xs-12 ajaxlistaproducto">







            </div>

        </div>  

    </div>  
</div>
@stop



    <div id="wrapper">
        <div class="overlay"></div>
    

        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                       Brand
                    </a>
                </li>
                <li>
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Events</a>
                </li>
                <li>
                    <a href="#">Team</a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Works <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">Dropdown heading</li>
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
                <li>
                    <a href="https://twitter.com/maridlcrmn">Follow me</a>
                </li>
            </ul>
        </nav>



        <!--<div id="page-content-wrapper">
            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
        </div>-->


    </div>



@section('script')


    {{ HTML::script('js/select/bootstrap-select.min.js'); }}
    {{ HTML::script('/js/carruselproductos.js'); }}

    <script type="text/javascript">


        $(".btnprecio").click(function(e) {

            var precio1 = $('#p1').val();
            var precio2 = $('#p2').val();

            $('.ajaxlistaproducto').html("");
            $('.ajaxlistafiltro').html("<p class=msjcargando>Tranquilidad Esto puede tardar varios segundos ... </p>");

            $.ajax(
            {
                url: "/APPCOFFEE/ajax-filtro-artesania-price",
                type: "POST",
                data: { precio1 : precio1 , precio2 : precio2 },

            }).done(function(pagina) 
            {
                $(".ajaxlistafiltro").html(pagina);

            });

        });




        $('.selectpicker').selectpicker();
        $(document).ready(function() {
            $("#zoom_05").elevateZoom({ zoomType    : "inner", cursor: "crosshair" });
        });


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




        $(".ajaxlistafiltro").on('dblclick','.filaproducto', function() {
 
            var codproducto = $(this).attr("id");
            $('.ajaxlistafiltro').html("");
            $('.ajaxlistaproducto').html("<p class=msjcargando>Tranquilidad Esto puede tardar varios segundos ... </p>");
            $.ajax(
            {
                url: "/APPCOFFEE/ajax-producto-artesania",
                type: "POST",
                data: { codproducto : codproducto },

            }).done(function(pagina) 
            {
                $(".ajaxlistaproducto").html(pagina);

            }); 


        })


        $("#producto").change(function(e) {

                var codproducto = $('#producto').val();
                $('.ajaxlistafiltro').html("");
                $('.ajaxlistaproducto').html("<p class=msjcargando>Tranquilidad Esto puede tardar varios segundos ... </p>");


                $.ajax(
                {
                    url: "/APPCOFFEE/ajax-producto-artesania",
                    type: "POST",
                    data: { codproducto : codproducto },

                }).done(function(pagina) 
                {
                    $(".ajaxlistaproducto").html(pagina);

                });

        });


        $(".filtroselect").change(function(e) {

                var region  = $('#region').val();
                var taller  = $('#taller').val();                
                var materia = $('#materia').val();
                var linea   = $('#linea').val(); 
                $('.ajaxlistaproducto').html("");
                $('.ajaxlistafiltro').html("<p class=msjcargando>Tranquilidad Esto puede tardar varios segundos ... </p>");

                $.ajax(
                {
                    url: "/APPCOFFEE/ajax-filtro-artesania-select",
                    type: "POST",
                    data: { region : region , taller : taller , materia : materia , linea : linea },

                }).done(function(pagina) 
                {
                    $(".ajaxlistafiltro").html(pagina);

                });

        });


        $(document).ready(function () {
          var trigger = $('.hamburger'),
              overlay = $('.overlay'),
             isClosed = false;

            trigger.click(function () {
              hamburger_cross();      
            });

            function hamburger_cross() {

              if (isClosed == true) {          
                overlay.hide();
                trigger.removeClass('is-open');
                trigger.addClass('is-closed');
                isClosed = false;
              } else {   
                overlay.show();
                trigger.removeClass('is-closed');
                trigger.addClass('is-open');
                isClosed = true;
              }
          }
          
          $('[data-toggle="offcanvas"]').click(function () {
                $('#wrapper').toggleClass('toggled');
          });  
        });


    </script>

@stop