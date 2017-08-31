
@if(count($producto) > 0)


<div id='carousel-custom' class='carousel slide' data-ride='carousel'>
    <div class="coruselcontenedor">
        <div class='carousel-outer'>
            <!-- me art lab slider -->
            <div class='carousel-inner '>

                {{--*/ $count   = 0 /*--}}
                {{--*/ $class   = '' /*--}}

                @foreach ($listaproducto as $item)


                    {{--*/ $class   = '' /*--}}
                    @if($count == 0)
                        {{--*/ $class   = 'active' /*--}}  
                    @endif  

                    <div class='item {{$class}}'>
                        {{ HTML::image('imgartesania/'.$item->Url) }}
                    </div>  

                    {{--*/ $count   = $count + 1  /*--}}
                @endforeach

            </div>
                
            <!-- sag sol -->
            <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
                <span class='glyphicon glyphicon-chevron-left'></span>
            </a>
            <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
                <span class='glyphicon glyphicon-chevron-right'></span>
            </a>
        </div>
        
        <!-- thumb -->
        <ol class='carousel-indicators mCustomScrollbar meartlab'>

                {{--*/ $count   = 0 /*--}}
                {{--*/ $class   = '' /*--}}

                @foreach ($listaproducto as $item)
                    {{--*/ $class   = '' /*--}}
                    @if($count == 0)
                        {{--*/ $class   = 'active' /*--}}  
                    @endif  
                    <li data-target='#carousel-custom' data-slide-to='{{$count}}' class='$class'>
                        {{ HTML::image('imgartesania/'.$item->Url) }}
                    </li>

                    {{--*/ $count   = $count + 1  /*--}}
                @endforeach

        </ol>

        <div class="text-content">
            <h5><small>S/. {{number_format($producto->precio, 2, '.', '')}}</small></h5>
            <h5>{{$producto->descripcion}}</h5>
            <!-- <div class="for-border"></div> -->
            <div class="notice notice-info">
                <strong>Linea : </strong> <h4>{{$producto->Linea}}</h4>
            </div>
            <div class="notice notice-info">
                <strong>Taller : </strong> <h4>{{$producto->Taller}}</h4>
            </div>
            <div class="notice notice-info">
                <strong>Materia Prima : </strong> <h4>{{$producto->Materia}}</h4>
            </div>
            <div class="notice notice-info">
                <strong>Región : </strong> <h4>{{$producto->Region}}</h4>
            </div>                        
            
        </div>    
            
    </div>
</div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#zoom_05").elevateZoom({ zoomType    : "inner", cursor: "crosshair" });
        });

    </script>                

@else
    <h3>No Hay descripcion para este producto</h3>
@endif  