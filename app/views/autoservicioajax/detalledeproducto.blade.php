<div class="row">  

    <div class="container-fluid">
        <div class="content-wrapper">   
            <div class="item-container">    
                <div class="container"> 
                    <div class="col-xs-12">

                        <div class="col-xs-5">
                            {{ HTML::image('img/categorias/cafes.png', 'cafes') }}
                        </div>
                            
                        <div class="col-xs-7">
                            <div class="product-title">{{$producto->descripcion}}</div>
                            <div class="product-desc">descripcion del producto bien detallado</div>
                            <hr>
                            <div class="product-price">S/ {{number_format(round($producto->precio,2),2,'.','')}}</div>
                            <div class="product-stock">100 CALORIAS</div>
                            <hr>
                            <div class="row"> 
                                <div class="col-xs-12">
                                    <div class="product-title">Caracteristica del producto</div>
                                </div>    
                                
                                <div class="col-xs-6">

                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="radio" id="radio1" />
                                            <label for="radio1">Con Azucar</label>
                                        </div>
                                        <div class="funkyradio-success">
                                            <input type="radio" name="radio" id="radio2"/>
                                            <label for="radio2">Con Azucar</label>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="radio" id="radio3"/>
                                            <label for="radio3">Con Azucar</label>
                                        </div>
                                        <div class="funkyradio-success">
                                            <input type="radio" name="radio" id="radio4" />
                                            <label for="radio4">Con Azucar</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row"> 
                            	<div class="col-xs-6">
                                        <button type="button" id='cancelarproducto' class="btn btn-danger">
                                            CANCELAR 
                                        </button>                                            
                                </div> 
                                <div class="col-xs-6">   

                                        <button type="button" id='confirmarproducto'                           
                                                data-prefijo='{{substr($producto->id, 0,8)}}' 
                                                data='{{Hashids::encode(substr($producto->id, -12))}}' 
                                                class="btn btn-primary">
                                            CONFIRMAR 
                                        </button>
                            	</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 acompanalo">
                        <div class='col titulo col-xs-12'>
                            <h4>ACOMPAÑALO CON ESTE DELICIOSO</h4>
                        </div>                                          
                        <div class='col col-xs-4'>
                            <div class='producto'>
                                {{ HTML::image('img/categorias/cafes.png', 'cafes') }}
                                <h3>ALFAJOR</h3>
                                <p class='precio'>S/ 2.00</p>
                                <p class='caloria'>100 CAL</p>
                            </div>
                        </div>  
                        <div class='col col-xs-4'>
                            <div class='producto'>
                                {{ HTML::image('img/categorias/cafes.png', 'cafes') }}
                                <h3>ALFAJOR</h3>
                                <p class='precio'>S/ 2.00</p>
                                <p class='caloria'>100 CAL</p>
                            </div>
                        </div>
                        <div class='col col-xs-4'>
                            <div class='producto'>
                                {{ HTML::image('img/categorias/cafes.png', 'cafes') }}
                                <h3>ALFAJOR</h3>
                                <p class='precio'>S/ 2.00</p>
                                <p class='caloria'>100 CAL</p>
                            </div>
                        </div>
                    </div>

                </div> 
            </div>
        </div>
    </div>    
</div>
