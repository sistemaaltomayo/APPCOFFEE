@extends('template')
@section('style')
 	{{ HTML::style('/css/select/bootstrap-select.min.css') }}
    {{ HTML::style('/css/cssCliente.css') }}
    {{ HTML::style('/css/cssPersonal.css') }}
@stop

@section('section')

<div class="mensaje-error"></div>
<div class="permisomsj"></div>

<div class="titulo col-xs-12 col-md-12 col-sm-12 col-lg-12">
	<div class="msj"></div>
	<h4 style="text-align:center;">PROCESO DE SELECCIÓN PERSONAL <br><small>({{$postulante->Nombre}})</small></h4>
</div>


@if(count($errors)>0)
  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      @foreach($errors->all() as $error)
         <strong>Error!</strong> {{$error}}<br>
      @endforeach 
  </div>
@endif


<div class="@if($postulante->Estado == '0')  mostrar @else ocultar @endif toptermino paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
			
	<div class="col-sx-12">
		<div class="box" style="width:90%;margin:0 auto">							
			<div class="icon">
				<div class="image"><i class="fa fa-thumbs-o-up"></i></div>
				<div class="info">
					<h3 class="title">Bien Hecho <br><small>(Por favor llamar al Administrador)</small></h3>
					<h2>(1/5)</h2>
					
					<div class="row">
						<div class="col-xs-6 col-xs-offset-5">
							<h2 style='font-size:15px;float:right;'> Rpta : <strong style='color:#000;'>
								
								@if($postulante->Termino == '0')
									No Acepto
							    @else
							    	Acepto
							    @endif

							</strong> </h2>
						</div>
						
					  	<div class="col-xs-10 col-xs-offset-1">


						    <div class="input-group">
						      <input type="text" id='codigotermino' name='codigotermino' class="form-control" placeholder="Código">
						      <span class="input-group-btn">
						        <button class="btntermmino btn btn-default" type="button">Validar</button>
						      </span>
						    </div>
						  	</div>
						</div>								
					</div>
			</div>
			<div class="space"></div>
			<input type="hidden" name="termino" id="termino" value="{{$postulante->Termino}}">



		</div> 
	</div>
</div>


<div class="@if($postulante->Estado == '1') mostrar @else ocultar @endif topexamenadmin paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
		
	<div class="col-sx-12">
				<div class="listatoma">
				    <table  class="table demo">
				      	<thead>
					        <tr>
					        	<th colspan="5" class='id'>
					        		<h3>INSTRUCCIONES</h3>
					            	<p> 
					            		A continuación vas a encontrar una serie de indicadores por los que vas a evaluar al postulante. Contesta marcando en la columna del SI en el caso que el postulante cumple con ese indicador y en la columna de NO en el caso que el postulante no cumple.		
									</p>
					          	</th>
					        </tr>
					        <tr>
					        	<th colspan="2" class='id'>
					            	ASPECTO A EVALUAR
					          	</th>
					          	<th colspan="3" class='id'>
					            	(SI / NO)
					          	</th>

					        </tr>
				      	</thead>
				      	<tbody>
				      			{{--*/ $numeracion = 1 /*--}}
				      			{{--*/ $numeracion = 1 /*--}}
				      			{{--*/ $numeraciongrupo = 1 /*--}}
				      			{{--*/ $idpregunta = '' /*--}}

							    @foreach($listaTituloInspeccion as $item)
							    	<tr class='titulotabla'>
							    		<td colspan="5" ><b>{{$item->Descripcion}}</b></td>
							    	</tr>
							    	@foreach($listaLugarInspeccion as $item2)

								 			<tr class='lugartabla'>
								 				<td colspan="5"><b>{{$item2->Descripcion}}</b></td>
								 			</tr>

								 		@foreach($listaPreguntaDetalleBPM as $item3)
								 			
								 			@if($item2->Id == $item3->IdLugarInspeccionADM) 
									 			<tr>

									 				<td rowspan="{{$item3->Cantidad}}" class="verticalalign">{{$numeracion}}</td>
									 				<td rowspan="{{$item3->Cantidad}}" class="verticalalign"><b>{{$item3->Pregunta}}</b></td>



									 				<td>
														<div class="funkyradio ">															 	     													 
														    <div class="funkyradio-success">
														        <input type="radio" name="radio{{$numeracion}}" id="radio{{$numeracion}}" value="1">
														        <label for="radio{{$numeracion}}">SI</label>
														    </div>				        					 										        											  
														</div>
									 				</td>
								 					<td>
														<div class="funkyradio ">															 	     													 			        					 
														    <div class="funkyradio-success">
														        <input type="radio" name="radio{{$numeracion}}" id="radion{{$numeracion}}" value="0">
														        <label for="radion{{$numeracion}}">NO</label>
														    </div>											        											  
														</div>
														
									 				</td>
													<td>
														<i class="pregunta{{$numeracion}} fa fa-question-circle" aria-hidden="true"></i>
														<span style='display:none;' class="idlocalinspeccionpregunta{{$numeracion}}">{{$item3->Id}}</span>
													</td>

									 		</tr>

									 		{{--*/ $numeracion = $numeracion + 1 /*--}}
									 		@endif
									 		
								 		@endforeach
							    	@endforeach
							    @endforeach
				      		
				      	</tbody>
				    </table>  
				    <p id="contadorUnico" style="display:none;">{{$numeracion}}</p>	

					<div class="input-group grupo-imput">
					    <span class="titulospan input-group-addon" id="basic-addon1">COMENTARIO ADICIONAL:  </span>
					</div>

					<div class="input-group grupo-imput textarea">
						{{ Form::textarea('comentarioexamen', null, ['class' => 'form-control', 'rows' => '5','placeholder' => 'COMENTARIO ADICIONAL...', 'id' => 'comentarioexamen', 'maxlength' => '1000']) }}
					</div>

					<input type="submit" id="btnexamenadminpostulante" class="btn btn-primary" value="Guardar">

							    
				</div>
	</div>
</div>




<div class="@if($postulante->Estado == '2') mostrar @else ocultar @endif topresultadoexamenadmin paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
		
	<div class="col-sx-12">
		<div class="box" style="width:90%;margin:0 auto">							
			<div class="icon">
				<div class="image"><i class="fa fa-thumbs-o-up"></i></div>
				<div class="info">
					<h3 class="title"> EVALUACION DEL ADMINISTRADOR <br><strong><small>(CALIFICACION)</small></strong> <br>
						<strong>
							<small style='color:#e63f0c;' id='calificacionadm'>
								@if(isset($respuestaexamenadmin->Calificacion))
									<b class='si'>{{$respuestaexamenadmin->Si}}</b> - 
									<b class='cal'>{{$respuestaexamenadmin->Calificacion}}</b>
								@else
									<b class='si'></b>
									<b class='cal'></b>	
		                        @endif
							</small>
						</strong>
					</h3>
	
					<div class="row">

						@if(isset($respuestaexamenadmin->Calificacion))

							@if($respuestaexamenadmin->Si > 6)
								<div class="col-xs-10 col-xs-offset-1 evaluacioncontinuar">
									<h4> Felicidades <b>{{$postulante->Nombre}}</b> sigues en el proceso de selección</h4>	
									<br>			           
									<input type="submit" id="btncontinuarprocesoseleccion" class="btn btn-primary" value="CONTINUAR">
								</div>
						    @else
								<div class="col-xs-10 col-xs-offset-1 evaluacionterminar">
									<h4> Postulante <b>{{$postulante->Nombre}}</b> termino su proceso de selección por que no aprobo la evaluación</h4>	
									<br>			           
									<input type="submit" id="btnterminarprocesoseleccion" class="btn btn-primary" value="TERMINAR">
								</div>
							@endif

						@else

							<div class="col-xs-10 col-xs-offset-1 evaluacioncontinuar ocultar">
								<h4> Felicidades <b>{{$postulante->Nombre}}</b> sigues en el proceso de selección</h4>	
								<br>			           
								<input type="submit" id="btncontinuarprocesoseleccion" class="btn btn-primary" value="CONTINUAR">
							</div>	

							<div class="col-xs-10 col-xs-offset-1 evaluacionterminar ocultar">
								<h4> Postulante <b>{{$postulante->Nombre}}</b> termino su proceso de selección por que no aprobo la evaluación</h4>	
								<br>			           
								<input type="submit" id="btnterminarprocesoseleccion" class="btn btn-primary" value="TERMINAR">
							</div>

                        @endif	

					</div>


			</div>
			<div class="space"></div>
		</div> 
	</div>
</div>
</div>


<div class="@if($postulante->Estado == '3') mostrar @else ocultar @endif topdatospersonales paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
	<div class="col-sx-12">
			<div class="panelespersonal col-xs-12">

				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">DATOS PERSONALES (1)</h3>
					</div>

					<div class="panel-body">



						<div class="input-group grupo-imput" >
						    <span class="input-group-addon" id="basic-addon1">Nombre Completo (*) : </span>
							  	{{Form::text('nombretermino',$postulante->Nombre, array('class' => 'form-control control', 'placeholder' => 'Nombre', 'id' => 'nombretermino', 'maxlength' => '200', 'disabled ' => 'disabled'))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">DNI (*) : </span>
							  	{{Form::text('dnitermino',$postulante->Dni, array('class' => 'solonumero form-control control', 'placeholder' => 'DNI', 'id' => 'dnitermino', 'maxlength' => '8' ,'disabled ' => 'disabled'))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Fecha Nacimiento (*) : </span>
							{{  Form::date('fechanacimiento','',array('class' => 'form-control control', 'id' => 'fechanacimiento')) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Dirección (*) : </span>
							{{Form::text('direccion','', array('class' => 'form-control control', 'placeholder' => 'Dirección', 'id' => 'direccion', 'maxlength' => '200' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Provincia (*) : </span>
							{{ Form::select('provincia', $comboprovincia, array(),['class' => 'selectpicker form-control control' , 'id' => 'provincia' , 'data-live-search' => 'true']) }}
						</div>

						<div class="ajaxdistrito input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Distrito (*) : </span>
							{{ Form::select('distrito', array(), array(),['class' => 'selectpicker form-control control' , 'id' => 'distrito' , 'data-live-search' => 'true']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Teléfono  : </span>
							{{Form::text('telefono','', array('class' => 'solonumero form-control control', 'placeholder' => 'Telefono', 'id' => 'telefono', 'maxlength' => '15' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Celular (*) :  </span>
							{{Form::text('celular','', array('class' => 'solonumero form-control control', 'placeholder' => 'Celular', 'id' => 'celular', 'maxlength' => '15' ))}}						    
						</div>


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Correo Electrónico (*) : </span>
							{{Form::text('correoelectronico','', array('class' => 'form-control control', 'placeholder' => 'Correo Electrónico', 'id' => 'correoelectronico', 'maxlength' => '100' ))}}						    
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">EN CASO DE EMERGENCIA: <br><li>(Dejar un contacto por lo menos)</li> </span>
						</div>



						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Telefon/Celular: </span>
							{{Form::text('telefonoreferencia','', array('class' => 'solonumero form-control control', 'placeholder' => 'Telefon/Celular', 'id' => 'telefonoreferencia', 'maxlength' => '15' ))}}						    
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Nombre Referencia: </span>
							{{Form::text('nombrereferencia','', array('class' => 'form-control control', 'placeholder' => 'Nombre Referencia', 'id' => 'nombrereferencia', 'maxlength' => '100' ))}}		
						</div>

						<div style="float:right;margin-bottom:12px;">
							<button type="button" class="agregar btnreferencia btn btn-success">
								Agregar Referencia <i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>

						<div>
						    <table id='listareferencia'  class="table demo" >
						      	<thead>
							        <tr>
							        	<th>
							            	Telefon/Celular
							          	</th>
							          	<th >
							            	Nombre Referencia
							          	</th>
							          	<th >
							            	Eliminar
							          	</th>								          	
							        </tr>
						      	</thead>
						      	<tbody>

						      	</tbody>
						    </table> 
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">
						    	¿TIENES ESPOSA(O) E HIJOS?: <br><li>(háganos saber cuales son para la información del <b style='font-size: 15px;color: #08257C;'>SEGURO</b>)</li> 
						    </span>
						</div>

	                	<div class="inputs grupo-imput">
	                		<div class="cajamedidas entry input-group">
	                 			<span class="input-group-addon" id="basic-addon1">Esposa(o): </span>
		                        <input type="text" class="form-control" placeholder = 'Nombre de la Esposa(o)' name="nombreesposa" id='nombreesposa' maxlength = '100' />

	                			<span class="input-group-addon" id="basic-addon1">Edad de la Esposa(o): </span>
		                        <input type="text" class="solonumero form-control" placeholder = 'Edad de la Esposa(o)' name="edadesposa" id='edadesposa' />
	                    	</div>
	                    </div>

	                	<div class="inputs grupo-imput">
	                		<div class="cajamedidas entry input-group">
	                 			<span class="input-group-addon" id="basic-addon1">Hija(o): </span>
		                        <input type="text" class="form-control" placeholder = 'Nombre de la Hija(o)' name="nombrehija" id='nombrehija' maxlength = '100'/>
	                			<span class="input-group-addon" id="basic-addon1">Edad de la Hija(o): </span>
		                        <input type="text" class="solonumero form-control" placeholder = 'Edad de la Hija(o)' name="edadhija" id='edadhija' />
	                    	</div>
	                    </div>

						<div style="float:right;margin-bottom:12px;">
							<button type="button" class="agregar btnhijosesposa btn btn-success">
								Agregar Datos de Familia <i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>

						<div>
						    <table id='listarhijosesposa'  class="table demo" >
						      	<thead>
							        <tr>
							        	<th>
							            	Esposa(o)
							          	</th>
							          	<th >
							            	Edad de Esposa(o)
							          	</th>
							        	<th>
							            	Hija(o)
							          	</th>
							          	<th >
							            	Edad de Hija(o)
							          	</th>							          	
							          	<th >
							            	Eliminar
							          	</th>								          	
							        </tr>
						      	</thead>
						      	<tbody>

						      	</tbody>
						    </table> 
						</div>







						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">¿TIENES ALGUNA HABILIDAD O TALENTO?: <br><li>(háganos saber cuales son sus talentos)</li> </span>
						</div>

						<div class="input-group grupo-imput textarea">
							{{ Form::textarea('talento', null, ['class' => 'form-control', 'rows' => '5','placeholder' => 'Talento...', 'id' => 'talento', 'maxlength' => '2000']) }}
						</div>

					</div>
				</div>


				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">GRADO DE INSTRUCCION (2)</h3>
					</div>
					<div class="panel-body">


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Grado de Instrucción (*) : </span>
							{{ Form::select('gradoinstruccion', $combogradoinstruccion, array(),['class' => 'form-control control' , 'id' => 'gradoinstruccion']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">COMPUTACIÓN:  </span>
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Programas: </span>
							{{ Form::select('programa', $comboprograma, array(),['class' => 'form-control control' , 'id' => 'programa']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Nivel: </span>
							{{ Form::select('nivelprograma', $combonivel, array(),['class' => 'form-control control' , 'id' => 'nivelprograma']) }}
						</div>

						<div style="float:right;margin-bottom:12px;">
							<button type="button" class="agregar btnprograma btn btn-success">
								Agregar Programa <i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>

						<div>
						    <table id='listaprograna'  class="table demo" >
						      	<thead>
							        <tr>
							        	<th>
							            	Programa
							          	</th>
							          	<th >
							            	Nivel
							          	</th>
							          	<th >
							            	Eliminar
							          	</th>								          	
							        </tr>
						      	</thead>
						      	<tbody>

						      	</tbody>
						    </table> 
						</div>


						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">IDIOMAS:  </span>
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Idiomas: </span>
							{{ Form::select('idioma', $comboidioma, array(),['class' => 'form-control control' , 'id' => 'idioma']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Nivel: </span>
							{{ Form::select('nivelidioma', $combonivel, array(),['class' => 'form-control control' , 'id' => 'nivelidioma']) }}
						</div>


						<div style="float:right;margin-bottom:12px;">
							<button type="button" class="agregar btnidioma btn btn-success">
								Agregar Idioma <i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>

						<div>
						    <table id='listaidioma'  class="table demo" >
						      	<thead>
							        <tr>
							        	<th>
							            	Idioma
							          	</th>
							          	<th >
							            	Nivel
							          	</th>
							          	<th >
							            	Eliminar
							          	</th>								          	
							        </tr>
						      	</thead>
						      	<tbody>

						      	</tbody>
						    </table> 
						</div>


						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">CURSOS ADICIONALES:  </span>
						</div>


						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Curso Adicional (*) : </span>
							{{Form::text('cursoadicional','', array('class' => 'form-control control', 'placeholder' => 'Curso Adicional', 'id' => 'cursoadicional', 'maxlength' => '200' ))}}
						</div>

						<div style="float:right;margin-bottom:12px;">
							<button type="button" class="agregar btncursoadicional btn btn-success">
								Agregar Cursos adicionales <i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>

						<div>
						    <table id='listacursoadicionales'  class="table demo" >
						      	<thead>
							        <tr>
							        	<th>
							            	Curso
							          	</th>
							          	<th >
							            	Eliminar
							          	</th>								          	
							        </tr>
						      	</thead>
						      	<tbody>

						      	</tbody>
						    </table> 
						</div>


					</div>
				</div>



				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">REFERENCIAS PERSONALES (3)</h3>
					</div>

					<div class="panel-body">

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">COMO SE ENTERO DEL PUESTO DE TRABAJO:  </span>
						</div>
						
						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Medios (*) : </span>
							{{ Form::select('medio', $combomedio, array(),['class' => 'form-control control' , 'id' => 'medio']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Especificar (*) : </span>
							{{Form::text('especificarmedio','', array('class' => 'form-control control', 'placeholder' => 'Especificar', 'id' => 'especificarmedio', 'maxlength' => '200' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">REFERENCIA DE TRABAJO:  </span>
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Empresa : </span>
							{{Form::text('empresa','', array('class' => 'form-control control', 'placeholder' => 'Empresa', 'id' => 'empresa', 'maxlength' => '200' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Departamento: </span>
							{{ Form::select('departamento', $combodepartamento, array(),['class' => 'form-control control' , 'id' => 'departamento']) }}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Cargo : </span>
							{{Form::text('cargo','', array('class' => 'form-control control', 'placeholder' => 'Cargo', 'id' => 'cargo', 'maxlength' => '100' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">Funciones:  </span>
						</div>

						<div class="input-group grupo-imput textarea">
							{{ Form::textarea('funcion', null, ['class' => 'form-control', 'rows' => '5','placeholder' => 'Funciones...', 'id' => 'funcion', 'maxlength' => '1000']) }}
						</div>

						<div style="float:right;margin-bottom:12px;">
							<button type="button" class="agregar btnreferenciatrabajo btn btn-success">
								Agregar Referencias de Trabajos <i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>

						<div>
						    <table id='listareferenciatrabajo'  class="table demo" >
						      	<thead>
							        <tr>
							        	<th>
							            	Empresa
							          	</th>
							          	<th >
							            	Departamento
							          	</th>
							          	<th >
							            	Cargo
							          	</th>	
							          	<th >
							            	Funciones
							          	</th>
							          	<th >
							            	Eliminar
							          	</th>							          	
							        </tr>
						      	</thead>
						      	<tbody>

						      	</tbody>
						    </table> 
						</div>

						<div class="input-group grupo-imput">
						    <span class="titulospan input-group-addon" id="basic-addon1">NOMBRE Y CELULAR DE TU ULTIMO TRABAJO: <br>
						    <li>(contacto con el cual nos podemos comunicar)</li>  </span>
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Nombre Contacto (*): </span>
							{{Form::text('nombreultimo','', array('class' => 'form-control control', 'placeholder' => 'Nombre Contacto', 'id' => 'nombreultimo', 'maxlength' => '200' ))}}
						</div>

						<div class="input-group grupo-imput">
						    <span class="input-group-addon" id="basic-addon1">Celular Contacto (*): </span>
							{{Form::text('celularultimmo','', array('class' => 'solonumero form-control control', 'placeholder' => 'Celular Contacto', 'id' => 'celularultimmo', 'maxlength' => '15' ))}}
						</div>

					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
					<input type="submit" id="btninsertarpostulante" class="btn btn-primary" value="Guardar">
				</div>
			</div>
	</div>
</div>


<div class="@if($postulante->Estado == '4') mostrar @else ocultar @endif topempezarexamen1 paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
		
	<div class="@if($puestotrabajo == 'ADM') mostrar @else ocultar @endif empezaradm col-sx-12">
		<div class="box" style="width:90%;margin:0 auto">							
			<div class="icon">
				<div class="image"><i class="fa fa-thumbs-o-up"></i></div>
				<div class="info">
					<h3 class="title"> EXAMEN 01 <br><strong><small>(INSTRUCCIONES)</small></strong> <br>
						<strong><small style='color:#e63f0c;'>(SOLO TIENE 10 MINUTOS PARA RESOLVER EL EXAMEN)</small></strong></h3>
	
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<h4>
								A continuación tendras <b> 3 INDICACIONES </b>, las cuales deberas seguir al pie de la letra para el correcto llenado de la prueba.
							</h4>
							

				            <div class="testimonials">
				            	<div class="active item">

				                  <blockquote>
				                  	<h4>PRIMERA INDICACIÓN: </h4>
				                  	<p>
										Escriba una cruz <b>(✓)</b> en la <b>columna 1</b> a la altura de cada seguro de incendios o de accidentes desde 150.000 a 400.000  soles inclusive, contratado entre el 15 de marzo de 1975 y el 10 de mayo de 1976.
				                  	</p>
				              		</blockquote>
				                </div>
				            </div>

				            <div class="testimonials">
				            	<div class="active item">

				                  <blockquote>
				                  	<h4>SEGUNDA INDICACIÓN: </h4>
				                  	<p>
										Escriba una cruz <b>(✓)</b> en la <b>columna 2</b> a la altura de cada seguro de vida o de accidentes, hasta 300.000  soles inclusive, contratado entre el 15 de octubre de 1975 y el 20 de agosto de 1976.	
													                  		
				                  	</p>
				              		</blockquote>
				                </div>
				            </div>
				            <div class="testimonials">
				            	<div class="active item">

				                  <blockquote>
				                  	<h4>TERCERA INDICACIÓN: </h4>
				                  	<p>
										Escriba una cruz <b>(✓)</b> en la <b>columna 3</b> a la altura de cada seguro de incendios o de vida, desde 200.000 a  500.000 soles inclusive, contratado entre el 10 de febrero de 1975 y el 15 de junio de 1976.
				                  	</p>
				              		</blockquote>
				                </div>
				            </div>				            

							<input type="submit" id="btnempezarprimerexamen" class="btn btn-primary" value="EMPEZAR PRIMER EXAMEN (TIENE 10 MINUTOS)">

						</div>							
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
	</div>


	<div class="@if($puestotrabajo == 'ATC') mostrar @else ocultar @endif empezaratc col-sx-12">
		<div class="box" style="width:90%;margin:0 auto">							
			<div class="icon">
				<div class="image"><i class="fa fa-thumbs-o-up"></i></div>
				<div class="info">
					<h3 class="title"> EXAMEN 01 <br><strong><small>(INSTRUCCIONES)</small></strong> <br>
						<strong><small style='color:#e63f0c;'>(SOLO TIENE 10 MINUTOS PARA RESOLVER EL EXAMEN)</small></strong></h3>
	
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<h4>
								Escribe los <b> NUMEROS </b> que corresponden en la serie numerica (Recuerde que solo tienes 10 minutos para resolver la prueba).
							</h4>
						
							<input type="submit" id="btnempezarprimerexamenatc" class="btn btn-primary" value="EMPEZAR PRIMER EXAMEN (TIENE 10 MINUTOS)">

						</div>							
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
	</div>

</div>





<div class="@if($postulante->Estado == '5') mostrar @else ocultar @endif topexamen1 paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
		
	<div class="@if($puestotrabajo == 'ADM') mostrar @else ocultar @endif primeradm col-sx-12">
			<div class="panelespersonal col-xs-12">

				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title">RECUERDA QUE, SOLO PUEDES MARCAR EN LA COLUMNA RESPECTIVA SI CUMPLE CON LAS CONDICIONES DE CANTIDAD ASEGURADA, CLASE DE SEGURO Y FECHA DE CONTRATACION</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<h4>A continuación tendras <b> 3 INDICACIONES </b>, las cuales deberas seguir al pie de la letra para el correcto llenado de la prueba.</h4>
								

					            <div class="testimonials">
					            	<div class="active item">

					                  <blockquote>
					                  	<h4>PRIMERA INDICACIÓN: </h4>
					                  	<p>
											Escriba una cruz <b>(✓)</b> en la <b>columna 1</b> a la altura de cada seguro de incendios o de accidentes desde 150.000 a 400.000  soles inclusive, contratado entre el 15 de marzo de 1975 y el 10 de mayo de 1976.
					                  	</p>
					              		</blockquote>
					                </div>
					            </div>

					            <div class="testimonials">
					            	<div class="active item">

					                  <blockquote>
					                  	<h4>SEGUNDA INDICACIÓN: </h4>
					                  	<p>
											Escriba una cruz <b>(✓)</b> en la <b>columna 2</b> a la altura de cada seguro de vida o de accidentes, hasta 300.000  soles inclusive, contratado entre el 15 de octubre de 1975 y el 20 de agosto de 1976.	
														                  		
					                  	</p>
					              		</blockquote>
					                </div>
					            </div>
					            <div class="testimonials">
					            	<div class="active item">

					                  <blockquote>
					                  	<h4>TERCERA INDICACIÓN: </h4>
					                  	<p>
											Escriba una cruz <b>(✓)</b> en la <b>columna 3</b> a la altura de cada seguro de incendios o de vida, desde 200.000 a  500.000 soles inclusive, contratado entre el 10 de febrero de 1975 y el 15 de junio de 1976.
					                  	</p>
					              		</blockquote>
					                </div>
					            </div>				            
							</div>	

					        <div id="timer">
					        	<div class="containert">
					                <p>Tiempo Estimado ({{$postulante->TiempoPrimerExamenAdm}}) min</p>             
					            </div>
					            <div class="containert">
					            	<article>
						                <div id="minutePEAd" class='minute'>00</div>
						                <div class="divider">:</div>
						                <div id="secondPEAd" class='second'>00</div>  
					            	</article>
					            </div>
					        </div>

						</div>

					    <table id='listaprimerexamenadministrativo'  class="table demo" >
					      	<thead>
						        <tr>
						        	<th>
						            	Nº
						          	</th>
						        	<th>
						            	CANTIDAD ASEGURADA
						          	</th>
						          	<th >
						            	CLASE DE SEGURO
						          	</th>
						          	<th colspan="2">
						            	FECHA DE CONTRATACION
						          	</th>	
						          	<th>
						            	1
						          	</th>
						          	<th>
						            	2
						          	</th>	
						          	<th>
						            	3
						          	</th>							          							          	
						        </tr>
					      	</thead>
					      	<tbody>
					      		
					      			{{--*/ $contador = 1 /*--}}
						      		@foreach($listaprimerexamenadmin as $item)
						        	<tr id='{{$item->Id}}'>
						        			<td><b>{{$contador}}</b></td>
						        			<td>{{$item->CantidadAsegurada}}</td>
						        			<td>{{$item->ClaseSeguro}}</td>
							        		<td>{{$item->DiaContratacion}}</td>
							        		<td>{{$item->AnioContratacion}}</td>
						        			<td class='cuno'>  
							        			<div class="funkyradio">
									        		<div class="funkyradio">
												        <div class="funkyradio-success">
												            <input type="checkbox" name="c{{$contador}}" id="checkbox{{$contador}}1" value="1" />
												            <label for="checkbox{{$contador}}1">&nbsp</label>
											        	</div>
												    </div>   
											    </div>   
						        			</td>
							        		<td class='cdos'>
							        			<div class="funkyradio">
									        		<div class="funkyradio">
												        <div class="funkyradio-success">
												            <input type="checkbox" name="c{{$contador}}" id="checkbox{{$contador}}2" value="1" />
												            <label for="checkbox{{$contador}}2">&nbsp</label>
											        	</div>
												    </div>   
											    </div>   
							        		</td>
							        		<td class='ctres'>
							        			<div class="funkyradio">
									        		<div class="funkyradio">
												        <div class="funkyradio-success">
												            <input type="checkbox" name="c{{$contador}}" id="checkbox{{$contador}}3" value="1" />
												            <label for="checkbox{{$contador}}3">&nbsp</label>
											        	</div>
												    </div>   
											    </div> 
							        		</td>
						            </tr>
						            {{--*/ $contador = $contador + 1 /*--}}
						            @endforeach
					      		

					      	</tbody>
					    </table> 

						<input type="submit" id="btncalcularprimerexamen" class="btn btn-primary" value="CUARDAR">
					</div>
				</div>
			</div>
	</div>



	<div class="@if($puestotrabajo == 'ATC') mostrar @else ocultar @endif primeratc col-sx-12">
			<div class="panelespersonal col-xs-12">

				<div class="panel panel-info">
					<div class="panel-heading" style="text-align:center;">
						<h3 class="panel-title"> TEST RAPIDO DE INTELIGENCIA </h3>
					</div>

					<div class="panel-body">
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<h4>
									Escribe los <b> NUMEROS </b> que corresponden en la serie numerica (Recuerde que solo tienes 10 minutos para resolver la prueba).
								</h4>
											            
							</div>	

					        <div id="timer">
					        	<div class="containert">
					                <p>Tiempo Estimado ({{$postulante->TiempoPrimerExamenAtc}}) min</p>             
					            </div>
					            <div class="containert">
					            	<article>
						                <div id="minutePEAtc" class='minute'>00</div>
						                <div class="divider">:</div>
						                <div id="secondPEAtc" class='second'>00</div>  
					            	</article>
					            </div>
					        </div>

						</div>

					    <table id='listaprimerexamenatc'  class="table demo" >
					      	<thead>
						        <tr>
						        	<th>
						            	Nº
						          	</th>
						        	<th>
						            	Escribe los dos números que faltan a esta serie ( X -Y )
						          	</th>	
						          	<th>
						            	X
						          	</th>
						          	<th>
						            	Y
						          	</th>	
							          							          	
						        </tr>
					      	</thead>
					      	<tbody>
					      		
					      			{{--*/ $contador = 1 /*--}}
						      		@foreach($listaprimerexamenatc as $item)
						        	<tr id='{{$item->Id}}'>
						        			<td> <h4 style='color:#adadad;'>{{$contador}}</h4></td>
						        			<td> <h4>{{$item->Pregunta}}</h4> </td>

						        			<td class='x' style='width:17%;'>  
							  					{{Form::text('imput'.$contador.'1','', array('class' => 'decimal form-control control', 'placeholder' => 'X', 'id' => 'imput'.$contador.'1', 'maxlength' => '200'))}}		
						        			</td>
							        		<td class='y' style='width:17%;'>
							  					{{Form::text('imput'.$contador.'2','', array('class' => 'decimal form-control control', 'placeholder' => 'Y', 'id' => 'imput'.$contador.'2', 'maxlength' => '200'))}} 
							        		</td>

						            </tr>
						            {{--*/ $contador = $contador + 1 /*--}}
						            @endforeach
					      		

					      	</tbody>
					    </table> 

						<input type="submit" id="btncalcularprimerexamenatc" class="btn btn-primary" value="CUARDAR">
					</div>


				</div>
			</div>
	</div>


</div>


<div class="@if($postulante->Estado == '6') mostrar @else ocultar @endif topempezarexamen2 paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
		
	<div class="col-sx-12">
		<div class="box" style="width:90%;margin:0 auto">							
			<div class="icon">
				<div class="image"><i class="fa fa-thumbs-o-up"></i></div>
				<div class="info">
					<h3 class="title"> EXAMEN 02 <br><strong><small>(INSTRUCCIONES)</small></strong> <br>
						<strong><small style='color:#e63f0c;'>(SOLO TIENE 10 MINUTOS PARA RESOLVER EL EXAMEN)</small></strong></h3>
	
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<h4>A continuación tendras <b> BANCO DE PREGUNTAS PARA MEDIR ACTITUD A LAS VENTAS.</b></h4>
							<input type="submit" id="btnempezarsegundoexamen" class="btn btn-primary" value="EMPEZAR SEGUNDO EXAMEN (TIENE 10 MINUTOS)">
						</div>							
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
	</div>
</div>




<div class="@if($postulante->Estado == '7') mostrar @else ocultar @endif topexamen2 paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
		
	<div class="col-sx-12">

				{{--*/ $idPregunta = "" /*--}}
				{{--*/ $contadorItem = 1 /*--}}
				{{--*/ $contador = 0 /*--}}
				{{--*/ $contadorUnicov = 0 /*--}}
				{{--*/ $numeracion = 1 /*--}}

		        @foreach($listasegundoexamen as $item)
					
		        	@if($item->IdPreguntaVenta != $idPregunta)

						<div class="col-xs-12 col-md-12">
							<div class="preguntas pregunta{{$contadorItem}}">

								<div class="numero"><p>{{$contadorItem}}</p></div>
								<div class="pregunta">
									<p><b>{{$item->NombrePregunta}}</b></p>	
								</div>

							    <div class="funkyradio funkyradioventa">
								{{--*/ $contadorUnicov = $contadorUnicov + 1 /*--}}
								{{--*/ $idPregunta = $item->IdPreguntaVenta /*--}}
								{{--*/ $contadorItem = $contadorItem + 1 /*--}}	    
		        	@endif
					
					    <div class="funkyradio-success">
				            <input type="radio" name="radiov{{$contadorUnicov}}" id="radiov{{$contador}}" value="{{$item->Id}}" />
				            <label for="radiov{{$contador}}">{{$item->Descripcion}}</label>
				        </div>
				        {{--*/ $numeracion = $numeracion + 1 /*--}}

					@if(count($listasegundoexamen) == ($contador + 1))
								  </div>
							</div>
						</div>
					@else
			        	@if($listasegundoexamen[$contador+1]->IdPreguntaVenta != $idPregunta)
			        				</div>
							</div>
						</div>
			        	@endif
					@endif
					{{--*/ $contador = $contador + 1 /*--}}
				@endforeach

				<p id="contadorUnicov" style="display:none;">{{$numeracion}}</p>	

				<div class="col-xs-12" style = 'margin-top:15px;'>

			        <div id="timer">
			        	<div class="containert">
			                <p>Tiempo Estimado ({{$postulante->TiempoPrimerExamenAtc}}) min</p>             
			            </div>
			            <div class="containert">
			            	<article>
				                <div id="minuteSEA" class='minute'>00</div>
				                <div class="divider">:</div>
				                <div id="secondSEA" class='second'>00</div>  
			            	</article>
			            </div>
			        </div>

					<input type="submit" id="btnexamensegundopostulante" class="btn btn-primary" value="Guardar">
				</div>


	</div>
</div>




<div class="@if($postulante->Estado == '8') mostrar @else ocultar @endif terminoprocesoseleccion paneltop formulario col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
		
	<div class="col-sx-12">

		<div class="box" style="width:90%;margin:0 auto">							
			<div class="icon">
				<div class="image"><i class="fa fa-thumbs-o-up"></i></div>
				<div class="info">
					<h3 class="title"> CULMINO PROCESO DE SELECCION <br>
						<strong><small style='color:#e63f0c;'>(GRACIAS)</small></strong></h3>
	
				</div>
				<div class="space"></div>
			</div> 
		</div>


	</div>
</div>








<input type="hidden" name="puestotrabajo" id="puestotrabajo" value="{{$puestotrabajo}}">

<input type="hidden" name="estadoselecccion" id="estadoselecccion" value="{{$postulante->Estado}}">

<input type="hidden" name="tiempoprimerexamenadmtop" id="tiempoprimerexamenadmtop" value="{{$postulante->TiempoPrimerExamenAdm}}">
<input type="hidden" name="tiempoprimerexamenadm" id="tiempoprimerexamenadm" value="{{$postulante->TiempoPrimerExamenAdmTer}}">
<input type="hidden" name="culminopea" id="culminopea" value="0">


<input type="hidden" name="tiempoprimerexamenatctop" id="tiempoprimerexamenatctop" value="{{$postulante->TiempoPrimerExamenAtc}}">
<input type="hidden" name="tiempoprimerexamenatc" id="tiempoprimerexamenatc" value="{{$postulante->TiempoPrimerExamenAtcTer}}">
<input type="hidden" name="culminopeatc" id="culminopeatc" value="0">

<input type="hidden" name="tiemposegundoexamenadmtop" id="tiemposegundoexamenadmtop" value="{{$postulante->TiempoSegundoExamenAdm}}">
<input type="hidden" name="tiemposegundoexamenadm" id="tiemposegundoexamenadm" value="{{$postulante->TiempoSegundoExamenAdmTer}}">
<input type="hidden" name="culminosea" id="culminosea" value="0">


<input type="hidden" name="idopcion" id="idopcion" value="{{$idopcion}}">
<input type="hidden" name="codigo" id="codigo" value="{{$codigo}}">
<input type="hidden" name="idpostulante" id="idpostulante" value="{{$idpostulante}}">


<div class="modal fade" id="modalcargando" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="width:320px;height:310px;margin:0 auto">

        <div class="modal-body">
          	<div class="cargandoreportefail">
				{{ HTML::image('img/cargando1.gif', 'cargando') }}
			</div>
			<p class="msjcargando">Espere por favor</p>
			<p class="msjcargando">Esto puede tardar varios minutos ...</p>

		    <div class="alertajax alert alert-danger ">
		        <a href="javascript:location.reload()" class="btnfail btn btn-xs btn-danger pull-right">Intentar Nuevamente</a>
		        <strong>Error: </strong> <span class='msjfailajax'></span>
		    </div>


        </div>

      </div>
    </div>
</div>


<div class="modal fade" id="modalaviso" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content" style="width:320px;height:250px;margin:0 auto">
        <div class="modal-body">
        	<h3 style = 'text-align:center;'>{{$postulante->Nombre}}</h3>
        	<div class='terminar' style='display:none;'>
				<p>Terminó su proceso de selección para el postulante </p>
				<div class="col-xs-12" style="text-align:center;">
					<button class="btntermminar btn btn-success" type="button">Aceptar</button>
				</div>
        	</div>
        	<div class='continua' style='display:none;'>
				<p>Continúa con su proceso de selección (Aceptar para la siguiente etapa)</p>
				<div class="col-xs-12" style="text-align:center;">
					<button class="btncontinuar btn btn-success" type="button">Aceptar</button>
				</div>
        	</div>
        </div>
      </div>
    </div>
</div>



@stop
@section('script')

	{{ HTML::script('js/select/bootstrap-select.min.js'); }}

    <script>




    	$(document).ready(function(){

    		var estadoselecccion 		  = parseInt($("#estadoselecccion").val());
    		var puestotrabajo 		  	  = $("#puestotrabajo").val();

    		if(estadoselecccion==5 &&  puestotrabajo == 'ADM'){
    			cronometroPEA();
    		}

    		if(estadoselecccion==5 &&  puestotrabajo == 'ATC'){
    			cronometroPEATC();
    		}

    		if(estadoselecccion==7){
    			cronometroSEP();
    		}



    		function cronometroSEP(){


    			var idpostulante 	   		  = $('#idpostulante').val();
	    		var tiemposegundoexamenadmtop = $("#tiemposegundoexamenadmtop").val();
		    	var tiemposegundoexamenadm    = $("#tiemposegundoexamenadm").val();
		    	var arreglotime 		      = tiemposegundoexamenadm.split(':');
		    	var arreglominuto 		      = parseInt(arreglotime[0]);
		    	var arreglosegundo 		      = parseInt(arreglotime[1]);
		    	

		    	

			    var tiempo = { minuto: arreglominuto, segundo: arreglosegundo};
			    var tiempo_corriendo = null;                  
		        tiempo_corriendo = setInterval(function(){
		        	culminosea     			  = $("#culminosea").val();
		            // Segundos
		            tiempo.segundo++;
		            if(tiempo.segundo >= 60)
		            {
		                tiempo.segundo = 0;
		                tiempo.minuto++;
		            }      
		            // Minutos
		            if(tiempo.minuto >= 60)
		            {
		                tiempo.minuto = 0;
		                tiempo.hora++;
		            }
		            $("#minuteSEA").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
		            $("#secondSEA").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);

		            minutos 		= tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto;
		            segundos 		= tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo;
		            horacompleta 	= minutos+':'+segundos;
		            accionhora 		= 3;

			    	if(culminosea == '1'){
			    		clearInterval(tiempo_corriendo); 
			    	}

					$.ajax(
			        {
			            url: "/APPCOFFEE/actualizar-cronometro-examen-ajax",
			            type: "POST",
			            data: { idpostulante : idpostulante , horacompleta : horacompleta, accionhora : accionhora},

			        }).done(function(pagina) 
			        {
			        	console.log("actualizadondo cronometro");
			        });	

			    	if(tiemposegundoexamenadmtop <= horacompleta){
			    		clearInterval(tiempo_corriendo); 
			    		$( "#btnexamensegundopostulante" ).click();
			    	}
		        }, 1000);
    		}




    		function cronometroPEATC(){

    			var idpostulante 	   		  = $('#idpostulante').val();
	    		var tiempoprimerexamenatctop  = $("#tiempoprimerexamenatctop").val();
		    	var tiempoprimerexamenatc     = $("#tiempoprimerexamenatc").val();
		    	var arreglotime 		      = tiempoprimerexamenatc.split(':');
		    	var arreglominuto 		      = parseInt(arreglotime[0]);
		    	var arreglosegundo 		      = parseInt(arreglotime[1]);
		    	

			    var tiempo = { minuto: arreglominuto, segundo: arreglosegundo};
			    var tiempo_corriendo = null;                  
		        tiempo_corriendo = setInterval(function(){

		        	culminopeatc     		  = $("#culminopeatc").val();
		            // Segundos
		            tiempo.segundo++;
		            if(tiempo.segundo >= 60)
		            {
		                tiempo.segundo = 0;
		                tiempo.minuto++;
		            }      
		            // Minutos
		            if(tiempo.minuto >= 60)
		            {
		                tiempo.minuto = 0;
		                tiempo.hora++;
		            }
		            $("#minutePEAtc").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
		            $("#secondPEAtc").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);

		            minutos 		= tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto;
		            segundos 		= tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo;
		            horacompleta 	= minutos+':'+segundos;
		            accionhora 		= 2;

			    	if(culminopeatc == '1'){
			    		clearInterval(tiempo_corriendo); 
			    	}


					$.ajax(
			        {
			            url: "/APPCOFFEE/actualizar-cronometro-examen-ajax",
			            type: "POST",
			            data: { idpostulante : idpostulante , horacompleta : horacompleta, accionhora : accionhora},

			        }).done(function(pagina) 
			        {
			        	console.log("actualizadondo cronometro");
			        });	

			    	if(tiempoprimerexamenatctop <= horacompleta){
			    		clearInterval(tiempo_corriendo); 
			    		$( "#btncalcularprimerexamenatc" ).click();
			    	}
		        }, 1000);
    		}


    		function cronometroPEA(){

    			var idpostulante 	   		  = $('#idpostulante').val();
	    		var tiempoprimerexamenadmtop  = $("#tiempoprimerexamenadmtop").val();
		    	var tiempoprimerexamenadm     = $("#tiempoprimerexamenadm").val();
		    	var arreglotime 		      = tiempoprimerexamenadm.split(':');
		    	var arreglominuto 		      = parseInt(arreglotime[0]);
		    	var arreglosegundo 		      = parseInt(arreglotime[1]);
		    	

			    var tiempo = { minuto: arreglominuto, segundo: arreglosegundo};
			    var tiempo_corriendo = null;                  
		        tiempo_corriendo = setInterval(function(){
		            // Segundos
		            culminopea     		      = $("#culminopea").val();
		            tiempo.segundo++;
		            if(tiempo.segundo >= 60)
		            {
		                tiempo.segundo = 0;
		                tiempo.minuto++;
		            }      
		            // Minutos
		            if(tiempo.minuto >= 60)
		            {
		                tiempo.minuto = 0;
		                tiempo.hora++;
		            }
		            $("#minutePEAd").text(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
		            $("#secondPEAd").text(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);

		            minutos 		= tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto;
		            segundos 		= tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo;
		            horacompleta 	= minutos+':'+segundos;
		            accionhora 		= 1;

			    	if(culminopea == '1'){
			    		clearInterval(tiempo_corriendo); 
			    	}


					$.ajax(
			        {
			            url: "/APPCOFFEE/actualizar-cronometro-examen-ajax",
			            type: "POST",
			            data: { idpostulante : idpostulante , horacompleta : horacompleta, accionhora : accionhora},

			        }).done(function(pagina) 
			        {
			        	console.log("actualizadondo cronometro");
			        });	



			    	if(tiempoprimerexamenadmtop <= horacompleta){
			    		clearInterval(tiempo_corriendo); 
			    		$( "#btncalcularprimerexamen" ).click();
			    	}
		        }, 1000);
    		}



			$("#btnempezarsegundoexamen").click(function(e) {

				$("#modalcargando").modal();
				idpostulante 	    = $('#idpostulante').val();
				$.ajax(
		        {
		            url: "/APPCOFFEE/empezar-segundo-examen-ajax",
		            type: "POST",
		            data: { idpostulante : idpostulante },

		        }).done(function(pagina) 
		        {
					$(".topempezarexamen2").css("display", "none");
					$(".topexamen2").css("display", "inline-block");
					$('#modalcargando').modal('hide');
					cronometroSEP();
		        });
			});




			$("#btnempezarprimerexamen").click(function(e) {

				$("#modalcargando").modal();
				idpostulante 	    = $('#idpostulante').val();
				$.ajax(
		        {
		            url: "/APPCOFFEE/empezar-primer-examen-ajax",
		            type: "POST",
		            data: { idpostulante : idpostulante },

		        }).done(function(pagina) 
		        {
					$(".topempezarexamen1").css("display", "none");
					$(".topexamen1").css("display", "inline-block");
					$('#modalcargando').modal('hide');
					cronometroPEA();
		        });
			});






			$("#btnempezarprimerexamenatc").click(function(e) {


				$("#modalcargando").modal();
				idpostulante 	    = $('#idpostulante').val();
				$.ajax(
		        {
		            url: "/APPCOFFEE/empezar-primer-examen-ajax",
		            type: "POST",
		            data: { idpostulante : idpostulante },

		        }).done(function(pagina) 
		        {
					$(".topempezarexamen1").css("display", "none");
					$(".topexamen1").css("display", "inline-block");
					$('#modalcargando').modal('hide');
					cronometroPEATC();
		        });
			});



    	});




		$('#btnexamensegundopostulante').on('click', function(event){

			var xml 				= "";
			var sw 					= "1";
			var id 					= "";
			var puntaje 			= "";
			var alertaMensajeGlobal = "";
			$(".alerta").html("");
			var aleatorio = Math.floor((Math.random() * 500) + 1);
			idpostulante 	        = $('#idpostulante').val();


			for (i=1; i<=parseInt($("#contadorUnicov").html())-1; i++)
			{
				if($('input:radio[name=radiov'+i+']').is(':checked')) {
					idrespuestaventa = $('input:radio[name=radiov'+i+']:checked').val();
					xml= xml + idrespuestaventa + '&&&';
				}
			}

			$("#modalcargando").modal();

			$.ajax(
		    {
		        url: "/APPCOFFEE/guardar-examen-segundo-postulante-ajax",
		        type: "POST",
		        data: { xml : xml , idpostulante : idpostulante},
		    }).done(function(pagina) 
		    {
				$(".topexamen2").css("display", "none");
				$(".terminoprocesoseleccion").css("display", "inline-block");
				$('#modalcargando').modal('hide');
				$("#culminosea").val('1');

				/*JSONdata     = JSON.parse(pagina);
				si 			 = JSONdata[0].si;
				calificacion = JSONdata[0].calificacion;

				$("#calificacionadm .si").html(si);
				$("#calificacionadm .cal").html(calificacion);

				if(parseInt(si) > 6){
					$(".evaluacionterminar").css("display", "none");
					$(".evaluacioncontinuar").css("display", "inline-block");
				}else{
					$(".evaluacioncontinuar").css("display", "none");
					$(".evaluacionterminar").css("display", "inline-block");
				}*/

		    });

	    });





		$('#btnexamenadminpostulante').on('click', function(event){

			var xml 				= "";
			var sw 					= "1";
			var id 					= "";
			var puntaje 			= "";
			var alertaMensajeGlobal = "";
			idpostulante 	        = $('#idpostulante').val();
			comentarioexamen 	    = $('#comentarioexamen').val();


			$(".alerta").html("");
			var aleatorio = Math.floor((Math.random() * 500) + 1);

			for (i=1; i<=parseInt($("#contadorUnico").html())-1; i++)
			{

				if($('input:radio[name=radio'+i+']').is(':checked')) { 

					$('.pregunta'+i).css( "display", "none" );
					id = $('.idlocalinspeccionpregunta'+i).html();
					puntaje = $('input:radio[name=radio'+i+']:checked').val();
					if(puntaje=='' && observacion.trim() == ""){
						sw="";
						$('.pregunta'+i).css( "display", "inline-block" );
					}
					xml= xml + id+'***'+puntaje+'&&&';
				}else{
					sw="";
					$('.pregunta'+i).css( "display", "inline-block" );
				}
			}


			if(sw == '')
			{

	        	msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Complete el examen del postulante <i class='signointerrogacion fa fa-question-circle' aria-hidden='true'></i></strong></div>";
	    		$(".permisomsj").append(msj);
	    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 2000);

			}else{

				puntero = this;
				$(puntero).prop("disabled",true);
				$("#modalcargando").modal();



				$.ajax(
			    {
			        url: "/APPCOFFEE/guardar-examen-administrativo-postulante-ajax",
			        type: "POST",
			        data: { xml : xml , idpostulante : idpostulante, comentarioexamen : comentarioexamen},
			    }).done(function(pagina) 
			    {
					$(".topexamenadmin").css("display", "none");
					$(".topresultadoexamenadmin").css("display", "inline-block");
					$('#modalcargando').modal('hide');

					JSONdata     = JSON.parse(pagina);
					si 			 = JSONdata[0].si;
					calificacion = JSONdata[0].calificacion;

					$("#calificacionadm .si").html(si);
					$("#calificacionadm .cal").html(calificacion);

					if(parseInt(si) > 6){
						$(".evaluacionterminar").css("display", "none");
						$(".evaluacioncontinuar").css("display", "inline-block");
					}else{
						$(".evaluacioncontinuar").css("display", "none");
						$(".evaluacionterminar").css("display", "inline-block");
					}

			    });

			}

	    });



	$("#btncalcularprimerexamen").click(function(e) {

		$("#modalcargando").modal();
		idpostulante 	    = $('#idpostulante').val();
		count 				= 1;
		xml 				= '';

	    $("#listaprimerexamenadministrativo tbody tr").each(function(){

	    	unoc            = 0;
	    	dosc            = 0;
	    	tresc           = 0;
	    	idexamen 	    = $(this).attr("id");

			if($('#checkbox'+count+'1').is(':checked')){
			    unoc = 1;
			}
			if($('#checkbox'+count+'2').is(':checked')){
			    dosc = 1;
			}			
			if($('#checkbox'+count+'3').is(':checked')){
			    tresc = 1;
			}	

			xml 	= xml + idexamen +'***'+ unoc+'***'+ dosc+'***'+ tresc +'&&&';
	    	count 			= count + 1;

    	});

		$.ajax(
        {
            url: "/APPCOFFEE/guardar-primer-examen-administrativo-ajax",
            type: "POST",
            data: { xml : xml, idpostulante : idpostulante},

        }).done(function(pagina) 
        {
			$(".topexamen1").css("display", "none");
			$(".topempezarexamen2").css("display", "inline-block");
			$('#modalcargando').modal('hide');
			$("#culminopea").val('1');
		
        });


	});



	$("#btncalcularprimerexamenatc").click(function(e) {

		$("#modalcargando").modal();
		idpostulante 	    = $('#idpostulante').val();
		count 				= 1;
		xml 				= '';

	    $("#listaprimerexamenatc tbody tr").each(function(){

	    	rpt1            = '';
	    	rpt2            = '';
	    	idexamen 	    = $(this).attr("id");

	    	rpt1 = 	$('#imput'+count+'1').val().trim();
	    	rpt2 = 	$('#imput'+count+'2').val().trim();

			xml 	= xml + idexamen +'***'+ rpt1 +'***'+ rpt2 +'&&&';
	    	count 	= count + 1;

    	});

		$.ajax(
        {
            url: "/APPCOFFEE/guardar-primer-examen-atc-ajax",
            type: "POST",
            data: { xml : xml, idpostulante : idpostulante},

        }).done(function(pagina) 
        {
			$(".topexamen1").css("display", "none");
			$(".topempezarexamen2").css("display", "inline-block");
			$('#modalcargando').modal('hide');
			$("#culminopeatc").val('1');
        });


	});


	$("#btncontinuarprocesoseleccion").click(function(e) {

		$("#modalcargando").modal();
		idpostulante 	    = $('#idpostulante').val();
		$.ajax(
        {
            url: "/APPCOFFEE/continuar-proceso-seleccion-ajax",
            type: "POST",
            data: { idpostulante : idpostulante },

        }).done(function(pagina) 
        {
			$(".topresultadoexamenadmin").css("display", "none");
			$(".topdatospersonales").css("display", "inline-block");
			$('#modalcargando').modal('hide');
        });
	});


	$("#btnterminarprocesoseleccion").click(function(e) {

		var idopcion = $("#idopcion").val();
		window.location.href = '/APPCOFFEE/getion-solicitud-personal/'+idopcion;

	});











	$("#btninsertarpostulante").click(function(e) {

		
	 	var alertaMensajeGlobal='';

	 	nombretermino 		= $('#nombretermino').val();
	 	dnitermino 			= $('#dnitermino').val();
	 	fechanacimiento 	= $('#fechanacimiento').val();
	 	direccion 			= $('#direccion').val();
	 	provincia 			= $('#provincia').val();
	 	distrito 			= $('#distrito').val();
	 	celular 			= $('#celular').val();
	 	telefono 			= $('#telefono').val();
	 	correoelectronico 	= $('#correoelectronico').val();
	 	gradoinstruccion 	= $('#gradoinstruccion').val();
	 	medio 				= $('#medio').val();
	 	especificarmedio 	= $('#especificarmedio').val();
	 	idpostulante 	    = $('#idpostulante').val();
	 	talento 	    	= $('#talento').val();	 	
	 	nombreultimo 	    = $('#nombreultimo').val();
	 	celularultimmo 	    = $('#celularultimmo').val();	



	 	
	 	xmlreferencia 		= '';
	 	carritoreferencia   = 0;
	 	xmlprograma 		= '';
	 	carritoprograma     = 0;
	 	xmlidioma 			= '';
	 	carritoidioma    	= 0;
	 	xmltrabajo  		= '';
	 	carritotrabajo      = 0;
	 	xmlhijosesposa  	= '';
	 	xmlcursoadicional 		= '';
	 	carritocursoadicional   = 0;



	 	/************************ datos personales **********************/
	 	if(!valVacio($('#fechanacimiento').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo fecha nacimiento es obligatorio<br>';}
	 	if(!valVacio($('#direccion').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo direccion es obligatorio<br>';}
	 	if(!valSelect($('#provincia').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo provincia seleccionado es invalido<br>';}
		if(!valSelect($('#distrito').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo distrito seleccionado es invalido<br>';}
		if(!valVacio($('#celular').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo celular es obligatorio<br>';}
		if(!valVacio($('#correoelectronico').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo correo electronico es obligatorio<br>';}
		if(!valEmail($('#correoelectronico').val(),-1)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo correo electronico no corresponde con una dirección de e-mail válida<br>'}

	    $("#listareferencia tbody tr").each(function(){

			telefonor 		= $(this).find('.telefonor').html();
			nombrer    	= $(this).find('.nombrer').html();
	    	xmlreferencia 	= xmlreferencia + telefonor +'***'+ nombrer +'&&&';
	    	carritoreferencia 	= 1;

    	});
		if(!valSelect(carritoreferencia,0)){ alertaMensajeGlobal+='<strong>Error!</strong> Debe haber por lo menos una referencia en caso de emergencia<br>';}
		
	    $("#listarhijosesposa tbody tr").each(function(){

			esposo 			= $(this).find('.nombreesposa').html();
			edadesposo    	= $(this).find('.edadesposa').html();
			hijo 			= $(this).find('.nombrehija').html();
			edadhijo    	= $(this).find('.edadhija').html();
	    	xmlhijosesposa 	= xmlhijosesposa + esposo +'***'+ edadesposo +'***'+ hijo +'***'+ edadhijo +'&&&';

    	});



		if(!valVacio($('#talento').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo talento es obligatorio<br>';}

		/*******************************************************************/

		/************************ grado instruccion **********************/

		if(!valSelect($('#gradoinstruccion').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo grado de instrucción seleccionado es invalido<br>';}

	    $("#listaprograna tbody tr").each(function(){

			idprograma 		= $(this).find('.idprograma').html();
			idnivelprograma = $(this).find('.idnivelprograma').html();
	    	xmlprograma 	= xmlprograma + idprograma +'***'+ idnivelprograma +'&&&';
	    	carritoprograma = 1;

    	});
		if(!valSelect(carritoprograma,0)){ alertaMensajeGlobal+='<strong>Error!</strong> Debe haber por lo menos un programa de computacion agregado<br>';}


	    $("#listaidioma tbody tr").each(function(){

			ididioma 		= $(this).find('.ididioma').html();
			idnivelidioma   = $(this).find('.idnivelidioma').html();
	    	xmlidioma 		= xmlidioma + ididioma +'***'+ idnivelidioma +'&&&';
	    	carritoidioma 	= 1;

    	});
		if(!valSelect(carritoidioma,0)){ alertaMensajeGlobal+='<strong>Error!</strong> Debe haber por lo menos un idioma agregado<br>';}


	    $("#listacursoadicionales tbody tr").each(function(){

			cursoadicional 			= $(this).find('.cursoadicional').html();
	    	xmlcursoadicional 		= xmlcursoadicional + cursoadicional +'&&&';
	    	carritocursoadicional 	= 1;

    	});
		if(!valSelect(carritocursoadicional,0)){ alertaMensajeGlobal+='<strong>Error!</strong> Debe haber por lo menos un curso adicional agregado<br>';}




		/*******************************************************************/

		/************************ referecnia personales **********************/

		if(!valSelect($('#medio').val(),0)){ alertaMensajeGlobal+='<strong>Error!</strong> El campo medio seleccionado es invalido<br>';}
		if(!valVacio($('#especificarmedio').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo especificar medio es obligatorio<br>';}

	    $("#listareferenciatrabajo tbody tr").each(function(){

			empresa 			= $(this).find('.empresa').html();
			iddepartamento   	= $(this).find('.iddepartamento').html();
			cargo 				= $(this).find('.cargo').html();
			funcion   			= $(this).find('.funcion').html();
	    	xmltrabajo 			= xmltrabajo + empresa +'***'+ iddepartamento +'***'+ cargo +'***'+ funcion +'&&&';
	    	carritotrabajo 		= 1;
    	});
		if(!valSelect(carritotrabajo,0)){ alertaMensajeGlobal+='<strong>Error!</strong> Debe haber por lo menos una referencia de trabajo agregado<br>';}


	 	if(!valVacio($('#nombreultimo').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo nombre contacto es obligatorio<br>';}
	 	if(!valVacio($('#celularultimmo').val())){ alertaMensajeGlobal+='<strong>Error!</strong> El campo celular contacto es obligatorio<br>';}



		$( ".mensaje-error" ).html("");
		if(alertaMensajeGlobal!='')
		{
			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);
			return false;

		}else{	

			$("#modalcargando").modal();

			$.ajax(
            {
                url: "/APPCOFFEE/insertar-datos-personales-postulante-ajax",
                type: "POST",
                data: { nombretermino : nombretermino , dnitermino : dnitermino, fechanacimiento : fechanacimiento, direccion : direccion, provincia : provincia, distrito : distrito, celular : celular, telefono : telefono, correoelectronico : correoelectronico, gradoinstruccion : gradoinstruccion , medio : medio,idpostulante : idpostulante , xmlreferencia : xmlreferencia, xmlprograma : xmlprograma, xmlidioma : xmlidioma, xmltrabajo : xmltrabajo, especificarmedio : especificarmedio , talento : talento , xmlhijosesposa : xmlhijosesposa , xmlcursoadicional : xmlcursoadicional , nombreultimo : nombreultimo , celularultimmo : celularultimmo },
            }).done(function(pagina) 
            {

            	$(".topdatospersonales").css("display", "none");
				$(".topempezarexamen1").css("display", "inline-block");
            	$('#modalcargando').modal('hide');
            	$('#mensaje-error').html("");

            }); 

		}


	});





    /*************************************  DATOS PERSONALES ***************************************/






	$(".btnreferenciatrabajo").click(function(e) {


		var countcarrito 			= 0;
		var alertaMensajeGlobal 	= '';
		var empresa 				= $('#empresa').val();
		var iddepartamento 			= $('#departamento').val();
		var departamento 			= $('#departamento :selected').text();
		var cargo 					= $('#cargo').val();
		var funcion 				= $('#funcion').val();
		var aleatorio = Math.floor((Math.random() * 500) + 1);

		if(empresa !='' && iddepartamento !='0' && cargo !='' && funcion !=''){


			var eliminar = '<button type=button class="eliminar btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></button>'					
			fila =  '<tr><td class="iddepartamento ocultar">'+iddepartamento+'</td><td class="empresa">'+empresa+'</td><td class="departamento">'+departamento+'</td><td class="cargo">'+cargo+'</td><td class="funcion">'+funcion+'</td><td>'+eliminar+'</td></tr>'

		    $("#listareferenciatrabajo tbody tr").each(function(){
		    	idempresa = $(this).find('.empresa').html();
		    	if (empresa == idempresa){
					countcarrito =  1;
			    }
	    	});

	    	if (countcarrito == 0){
				$('#listareferenciatrabajo tbody').append(fila);
				$('#empresa').val('');
				$('#cargo').val('');
				$('#funcion').val('');


		    }else{

            	msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Empresa ya esta agregado </strong></div>";
        		$(".permisomsj").append(msj);
        		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);

		    }


		}else{

			msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Ingrese una Empresa , Departamento, Cargo y Funciones</strong></div>";
    		$(".permisomsj").append(msj);
    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 2000);


		}

	});

	$("#listareferenciatrabajo").on('click','.eliminar', function() {
		$(this).closest('tr').remove();
	})







	$(".btnidioma").click(function(e) {


		var countcarrito 			= 0;
		var alertaMensajeGlobal 	= '';
		var ididioma 				= $('#idioma').val();
		var idnivelidioma 			= $('#nivelidioma').val();
		var idioma 					= $('#idioma :selected').text();
		var nivelidioma 			= $('#nivelidioma :selected').text();
		var aleatorio = Math.floor((Math.random() * 500) + 1);

		if(ididioma !='0' && idnivelidioma !='0'){


			var eliminar = '<button type=button class="eliminar btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></button>'					
			fila =  '<tr><td class="ididioma ocultar">'+ididioma+'</td><td class="idnivelidioma ocultar">'+idnivelidioma+'</td><td class="idioma">'+idioma+'</td><td class="nivelidioma">'+nivelidioma+'</td><td>'+eliminar+'</td></tr>'

		    $("#listaidioma tbody tr").each(function(){
		    	idioma = $(this).find('.ididioma').html();
		    	if (idioma == ididioma){
					countcarrito =  1;
			    }
	    	});

	    	if (countcarrito == 0){
				$('#listaidioma tbody').append(fila);
		    }else{
            	msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Idioma ya esta agregado </strong></div>";
        		$(".permisomsj").append(msj);
        		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);
		    }


		}else{

			msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Seleccione un Idioma y Nivel</strong></div>";
    		$(".permisomsj").append(msj);
    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 2000);


		}

	});



	$("#listaidioma").on('click','.eliminar', function() {
		$(this).closest('tr').remove();
	})



	$(".btncursoadicional").click(function(e) {


		var countcarrito 			= 0;
		var alertaMensajeGlobal 	= '';
		var cursoadicional 			= $('#cursoadicional').val();
		var aleatorio = Math.floor((Math.random() * 500) + 1);

		if(cursoadicional !=''){

			var eliminar = '<button type=button class="eliminar btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></button>';					
			fila =  '<tr><td class="cursoadicional">'+cursoadicional+'</td><td style="width:10%;">'+eliminar+'</td></tr>'
	    	$('#listacursoadicionales tbody').append(fila);
	    	$('#cursoadicional').val('');

		}else{

			msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Ingrese (Curso Adicional)</strong></div>";
    		$(".permisomsj").append(msj);
    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 2000);


		}

	});


	$("#listacursoadicionales").on('click','.eliminar', function() {
		$(this).closest('tr').remove();
	})





	$(".btnprograma").click(function(e) {

		var countcarrito 			= 0;
		var alertaMensajeGlobal 	= '';
		var idprograma 				= $('#programa').val();
		var idnivelprograma 		= $('#nivelprograma').val();
		var programa 				= $('#programa :selected').text();
		var nivelprograma 			= $('#nivelprograma :selected').text();
		var aleatorio = Math.floor((Math.random() * 500) + 1);





		if(idprograma !='0' && idnivelprograma !='0'){


			var eliminar = '<button type=button class="eliminar btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></button>'					
			fila =  '<tr><td class="idprograma ocultar">'+idprograma+'</td><td class="idnivelprograma ocultar">'+idnivelprograma+'</td><td class="programa">'+programa+'</td><td class="nivelprograma">'+nivelprograma+'</td><td>'+eliminar+'</td></tr>'

		    $("#listaprograna tbody tr").each(function(){
		    	programa = $(this).find('.idprograma').html();
		    	if (programa == idprograma){
					countcarrito =  1;
			    }
	    	});

	    	if (countcarrito == 0){
				$('#listaprograna tbody').append(fila);
		    }else{

            	msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Programa ya esta agregado </strong></div>";
        		$(".permisomsj").append(msj);
        		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);


		    }


		}else{
			msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Seleccione un Programa y Nivel</strong></div>";
    		$(".permisomsj").append(msj);
    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 2000);
		}

	});

	$("#listaprograna").on('click','.eliminar', function() {
		$(this).closest('tr').remove();
	})




	$(".btnhijosesposa").click(function(e) {

		var countcarrito = 0;
		var alertaMensajeGlobal='';
		var nombreesposa = $('#nombreesposa').val();
		var edadesposa 	 =  $('#edadesposa').val();
		var nombrehija 	 = $('#nombrehija').val();
		var edadhija 	 =  $('#edadhija').val();
		var aleatorio = Math.floor((Math.random() * 500) + 1);		

		if(!valVacio(nombreesposa)){ errorflotante(aleatorio,"El campo Esposa(o) es obligarotio"); return false;}
		if(!valVacio(edadesposa)){ errorflotante(aleatorio,"El campo Edad de la Esposa(o) es obligarotio"); return false;}

		if(nombrehija != '' && edadhija == '' ){
			if(!valVacio(edadesposa)){ errorflotante(aleatorio,"El campo Edad de la Hija(o) es obligarotio"); return false;}
		}
		if(nombrehija == '' && edadhija != '' ){
			if(!valVacio(edadesposa)){ errorflotante(aleatorio,"El campo Hija(o) es obligarotio"); return false;}
		}		

		var eliminar = '<button type=button class="eliminar btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></button>'					
		fila =  '<tr><td class="nombreesposa">'+nombreesposa+'</td><td class="edadesposa">'+edadesposa+'</td><td class="nombrehija">'+nombrehija+'</td><td class="edadhija">'+edadhija+'</td><td>'+eliminar+'</td></tr>'
		$('#listarhijosesposa tbody').append(fila);
		$('#nombrehija').val('');
		$('#edadhija').val('');	


	});

	$("#listarhijosesposa").on('click','.eliminar', function() {
		$(this).closest('tr').remove();
	})





	$(".btnreferencia").click(function(e) {

		var countcarrito = 0;
		var alertaMensajeGlobal='';
		var telefonoreferencia = $('#telefonoreferencia').val();
		var nombrereferencia =  $('#nombrereferencia').val();
		var aleatorio = Math.floor((Math.random() * 500) + 1);


		if(telefonoreferencia !='' && nombrereferencia !=''){


			var eliminar = '<button type=button class="eliminar btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></button>'					
			fila =  '<tr><td class="telefonor">'+telefonoreferencia+'</td><td class="nombrer">'+nombrereferencia+'</td><td>'+eliminar+'</td></tr>'

		    $("#listareferencia tbody tr").each(function(){
		    	telefonor = $(this).find('.telefonor').html();
		    	if (telefonor == telefonoreferencia){
					countcarrito =  1;
			    }
	    	});

	    	if (countcarrito == 0){
				$('#listareferencia tbody').append(fila);
				$('#telefonoreferencia').val("");
				$('#nombrereferencia').val("");
		    }else{

            	msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Telefono/Celular ya esta agregado </strong></div>";
        		$(".permisomsj").append(msj);
        		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 1200);

		    }


		}else{

        	msj="<div class='rd"+aleatorio+" alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong> Ingrese (Telefono/Celular y Nombre Referencia)</strong></div>";
    		$(".permisomsj").append(msj);
    		setTimeout(function(){ $(".rd"+aleatorio).fadeOut(200).fadeIn(100).fadeOut(400).fadeIn(400).fadeOut(100);}, 2000);

		}

	});


	$("#listareferencia").on('click','.eliminar', function() {
		$(this).closest('tr').remove();
	})




	/*************************************  TERMINO ***************************************/

	$(".btntermminar").click(function(e) {
		var idopcion = $("#idopcion").val();
		window.location.href = '/APPCOFFEE/getion-solicitud-personal/'+idopcion;
	});

	$(".btncontinuar").click(function(e) {

		idpostulante 	    = $('#idpostulante').val();

		$.ajax(
        {
            url: "/APPCOFFEE/continuar-termino-condiciones-ajax",
            type: "POST",
            data: { idpostulante : idpostulante },

        }).done(function(pagina) 
        {
			$(".toptermino").css("display", "none");
			$(".topexamenadmin").css("display", "inline-block");
			$('#modalaviso').modal('hide');
        }); 

	});


	$(".btntermmino").click(function(e) {

		var alertaMensajeGlobal='';
		var codigo = $("#codigo").val();
		var codigodig = $("#codigotermino").val();
		var termino = $("#termino").val();

		if(codigo==codigodig){

			if(termino == 1){

				$("#modalaviso .continua").css("display", "inline-block");
				$("#modalaviso .terminar").css("display", "none");
				$("#modalaviso").modal();

			}else{


				$("#modalaviso .continua").css("display", "none");
				$("#modalaviso .terminar").css("display", "inline-block");
				$("#modalaviso").modal();

			}

		}else{
			alertaMensajeGlobal+='<strong>Error!</strong> Codigo no coincide con el de su Usuario <br>'

			$(".mensaje-error").append("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+alertaMensajeGlobal+"</div>");
			$('html, body').animate({scrollTop : 0},800);
		}

	});


	/*document.onkeydown = function(e){
		tecla = (document.all) ? e.keyCode : e.which;
		if (tecla = 116) {return false;}
	}*/

	$('.selectpicker').selectpicker();
    $("#provincia").change(function(e) {


		    var codprovincia = $('#provincia').val();

			$.ajax(
            {
                url: "/APPCOFFEE/ajax-select-distrito",
                type: "POST",
                data: { codprovincia : codprovincia },

            }).done(function(pagina) 
            {
            	$(".ajaxdistrito").html(pagina);

            }); 

    });






    </script>

@stop