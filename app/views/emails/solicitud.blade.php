<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <style type="text/css">
        	section{
        		width: 100%;
        		background: #E8E8E8;
        		padding: 0px;
        		margin: 0px;
        	}

        	.panelcontainer{
        		width: 50%;
        		background: #fff;
        		margin: 0 auto;


        	}
        	.panelhead{
        		background: #08257C;
        		padding-top: 10px;
        		padding-bottom: 10px;
        		color: #fff;
        		text-align: center;
        		font-size: 1.2em;
        	}
        	.panelbody,.panelbodycodigo{
        		padding-left: 15px;
        		padding-right: 15px;
        	}
            .panelbodycodigo h3 small{
                color: #08257C;
            }

            table, td, th {    
                border: 1px solid #ddd;
                text-align: left;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                padding: 15px;
            }

        </style>

    </head>


    <body>
    	<section>
    		<div class='panelcontainer'>
    			<div class="panel">
                    <div class='panelbodycodigo'>

                        @if($IdUsuarioMod == '') 
                            <h3> Creación de Solicitud:   <small>{{$Correlativo}}</small></h3>
                        @else
                            <h3> Se Modifico la Solicitud:   <small>{{$Correlativo}}</small></h3>
                        @endif

                        
                        
                    </div>

    				<div class="panelhead">Solicitud de Personal</div>
    				<div class='panelbody'>
    					<h3>Motivo : 					<small>{{$MotivoSolicitud}}</small></h3>

                        @if($IdMotivoSolicitud == 'LIM01CEN000000000001') 
                            {{--*/ $listapersonal = PERSolicitudPersonalMotivo::where('IdSolicitud','=',$Id)->get() /*--}}

                            <table  class="table demo" >
                                <tr>
                                    <th>
                                        Personal
                                    </th>
                                    <th >
                                        Motivo
                                    </th>                                          
                                </tr>
                                @foreach($listapersonal as $item)
                                <tr>
                                        <td>{{$item->Usuario}}</td>
                                        <td>{{$item->Remplazo}}</td>
                                </tr>
                                 @endforeach
                            </table>
                        @else
                            <h3>Autorización :              <small>{{$Autorizacion}}</small></h3>                        
                        @endif

    				</div>
    				<div class="panelhead">Datos del Cargo</div>
    				<div class='panelbody'>
    					<h3>Cargo o puesto a ocupar : 	<small>{{$Cargo}}</small></h3>
    					<h3>Area : 						<small>{{$NombreLocal}}</small></h3>
    					<h3>Número Vacantes : 			<small>{{$NumeroVacantes}}</small></h3>
    					<h3>Observacion : 				<small>{{$Observacion}}</small></h3>
    				</div>
    			</div>
    						

    		</div>
		</section>
    </body>

</html>


