<div class='nav'>
	<div class='col col-xs-6'>
		<p class='titulo'>MI ORDEN - PARA COMER ACA</p>
	</div>
	<div class='col col-xs-6'>
		<div class='total'>
			<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
			<small class='cantidadtotal'> {{count($listacarrito)}} </small>
			<small> Productos : </small>
			<small class='montototal'> 
				S/ {{number_format(round($listacarrito->sum('precio'),2),2,'.','')}}
			</small>
		</div>
		
	</div>
</div>


<div class='detalles'>

  <div class='row'>
    <div class='col-md-12'>
      <div class="carousel slide media-carousel" id="media">
        <div class="carousel-inner">

        {{--*/ $sw = 0 /*--}}
        {{--*/ $count = 0 /*--}}		

            @foreach ($listacarrito as $item)



            	@if($sw==0) 
		          <div class="item  active">
		            <div class="detalle row">
		          {{--*/ $sw = 1 /*--}}  	
            	@else
            		@if($count%2==0) 
			          <div class="item">
			            <div class="detalle row">
		            @endif
            	@endif

              	<div class="col-xs-6 sinpadding">
	              	<div class='col-xs-12 col'>

		              	<div class="borderigth sinpadding col-xs-10">

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

		              	<div class="col-xs-2">
		              		<div class='btneditar'>
		              			<button type="submit" class="btnfrank btneditar btn btn-default" >EDITAR</button>
		              		</div>	
		              	</div>				              	
		            </div>  	
              	</div>  

          	
            	{{--*/ $count = $count + 1 /*--}}
            	@if($count == count($listacarrito)) 
		            </div>
		          </div>
		        @else
	            	@if($count%2==0) 
			            </div>
			          </div>
			        @endif	
		        @endif
            @endforeach
					                            


        </div>
        <a data-slide="prev" href="#media" class="left carousel-control">‹</a>
        <a data-slide="next" href="#media" class="right carousel-control">›</a>
      </div>                          
    </div>
  </div>						

</div>



<div class='funcion'>
	<div class="row"> 
		<div class='col-xs-6'>
			<a href="{{ url('/autoservicio/limpiar/') }}" class="btncancelar btn btn-default">
                CANCELAR
            </a>
		</div>	
		<div class='col-xs-6'>
			<a href="{{ url('/autoservicio/comprobantedepago') }}" class="btnaceptar btn btn-default">
                ACEPTAR
            </a>
		</div>							
	</div>
</div>