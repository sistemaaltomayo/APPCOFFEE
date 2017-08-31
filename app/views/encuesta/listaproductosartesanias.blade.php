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
                <div class="input-group grupo-imput cajapro">
                    {{ Form::select('producto', $comboproducto, array(),['class' => 'selectpicker form-control control' , 'id' => 'producto' , 'data-live-search' => 'true']) }}
                </div>
            </div>

            <div class="col-xs-12 ajaxlistaproducto">




            </div>

        </div>  

    </div>  
</div>
@stop

@section('script')


    {{ HTML::script('js/select/bootstrap-select.min.js'); }}
    {{ HTML::script('/js/carruselproductos.js'); }}

    <script type="text/javascript">


        $('.selectpicker').selectpicker();
        $(document).ready(function() {
            $("#zoom_05").elevateZoom({ zoomType    : "inner", cursor: "crosshair" });
        });

        $("#producto").change(function(e) {

                var codproducto = $('#producto').val();
                $(".ajaxlistaproducto").html("");

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


    </script>

@stop