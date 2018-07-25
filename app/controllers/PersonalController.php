<?php
use app\bibliotecas\GeneralClass;

class PersonalController extends BaseController
{


	/****************************** Asistencia ***********************************/

	
	public function actionListaAsistenciaDia($idOpcion)
	{


		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}

		$hoy = date('Y-m-d');
		//$hoy = '2018-01-03';

		$stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC SMS_EMAILASISTENCIAWS ?');
        $stmt->bindParam(1, $hoy ,PDO::PARAM_STR);
        $stmt->execute();	


		$listaAsistencia =  GENEmailAsistenciaEmpleadosWS::join('GEN.EquipoTablet', 'GEN.EmailAsistenciaEmpleadosWS.IdLocal', '=', 'GEN.EquipoTablet.IdLocal')
						    ->get();

		return View::make('personal/listaasistenciadeldia',
						 [
						  	'hoy'  	 			 => $hoy,
						  	'listaAsistencia'  	 => $listaAsistencia,						  
						 ]);
	}







	/******************************* Personal ************************************/
	public function actionGuardarSegundoExamen()
	{

		$generalclass        		 	= new GeneralClass();
		$idpostulante  	 	 	     	= Input::get('idpostulante');
		$xml  	 	 	     		 	= Input::get('xml');
		$fecha 				 			= date("Ymd H:i:s");

		$id 						 	= $generalclass->getDecodificarId($idpostulante);
		$idcabe 					  	= $generalclass->getCreateIdInvictus('PER.SegundoExamenVenta');

		$tCabecera            	 		=  new PERSegundoExamenVenta;
		$tCabecera->Id 	     	 		=  $idcabe;
		$tCabecera->IdSolicitudPersonal =  $id;
		$tCabecera->FechaCrea 			=  $fecha;
		$tCabecera->save();

		$listarexamen 					= explode('&&&', $xml);
		$calificacion  	 	 	     	= '';
		$puntaje  	 	 	     		= 0;

		for ($i = 0; $i < count($listarexamen)-1; $i++) {

			$idexa 			 					= $listarexamen[$i];
			$respuesta 	  						= PERRespuestaVenta::whereId($idexa)->first();

			$iddet = $generalclass->getCreateIdInvictus('PER.RespuestaVentaPostulante');

			$tDetalle							= new PERRespuestaVentaPostulante;
			$tDetalle->Id 						= $iddet;
			$tDetalle->IdRespuestaVenta 		= $respuesta->Id;
			$tDetalle->IdPreguntaVenta 			= $respuesta->IdPreguntaVenta;
			$tDetalle->IdSegundoExamenVenta		= $idcabe;
			$tDetalle->IdSolicitudPersonal 		= $id;
			$tDetalle->Descripcion				= $respuesta->Descripcion;
			$tDetalle->Valoracion				= $respuesta->Valoracion;
			$tDetalle->save();

			$puntaje = $puntaje + $respuesta->Valoracion;

		}

		$solicitudpersonal 	  			= PERSolicitudPersonal::whereId($id)->first();
		$solicitud 	  					= PERSolicitud::whereId($solicitudpersonal->IdSolicitud)->first();

		if($solicitud->IdTipoUsuario == 'LIM01CEN000000000003'){
			if($puntaje <= 14){ $calificacion = 'DESAPROBADO'; }else{ $calificacion = 'APROBADO'; }
		}else{
			if($puntaje <= 18){ $calificacion = 'DESAPROBADO'; }else{ $calificacion = 'APROBADO'; }
		}


		$tCabecera 							= PERSegundoExamenVenta::find($idcabe); 
		$tCabecera->Puntaje 				= $puntaje;
		$tCabecera->Calificacion 			= $calificacion;	
		$tCabecera->save();

		$tPERSolicitudPersonal 				= PERSolicitudPersonal::find($id); 
		$tPERSolicitudPersonal->Estado 		= 8;
		$tPERSolicitudPersonal->Ubicacion	= 'C';	
		$tPERSolicitudPersonal->save();	


	}





	public function actionGuardarExamenAdministrativoPostulante()
	{

		$generalclass        		 	= new GeneralClass();
		$idpostulante  	 	 	     	= Input::get('idpostulante');
		$comentarioexamen  	 	 	    = Input::get('comentarioexamen');
		$xml  	 	 	     		 	= Input::get('xml');
		//$fecha 				 			= date("Y-m-d H:i:s");
		$fecha 				 			= date("Ymd H:i:s");
		$id 						 	= $generalclass->getDecodificarId($idpostulante);
		$idcabe 					  	= $generalclass->getCreateIdInvictus('PER.RespuestaZonaADM');
		$idusuario 			 			= Session::get('Usuario')[0]->Id;

		$tCabecera            	 		=  new PERRespuestaZonaADM;
		$tCabecera->Id 	     	 		=  $idcabe;
		$tCabecera->IdSolicitudPersonal =  $id;
		$tCabecera->Comentario 			=  $comentarioexamen;
		$tCabecera->FechaCrea 			=  $fecha;
		$tCabecera->save();

		$listarexamen 					= explode('&&&', $xml);
		$calificacion  	 	 	     	= '';
		$si  	 	 	     			= 0;
		$no  	 	 	     		    = 0;



		for ($i = 0; $i < count($listarexamen)-1; $i++) {

			$listadetalleexamen 	= explode('***', $listarexamen[$i]);
			$idexa 			 		= $listadetalleexamen[0];
			$respuesta 			 	= (int)$listadetalleexamen[1];

			$iddet = $generalclass->getCreateIdInvictus('PER.RespuestaDetalleADM');

			$preguntadetallebpm 	  			= PERPreguntaDetalleADM::whereId($idexa)->first();


			$tDetalle							= new PERRespuestaDetalleADM;
			$tDetalle->Id 						= $iddet;
			$tDetalle->IdPreguntaDetalleADM 	= $idexa;
			$tDetalle->IdRespuestaZonaADM 		= $idcabe;
			$tDetalle->IdLugarInspeccionADM		= $preguntadetallebpm->IdLugarInspeccionADM;
			$tDetalle->IdTituloInspeccionADM 	= $preguntadetallebpm->IdTituloInspeccionADM;
			$tDetalle->Puntaje					= $respuesta;
			$tDetalle->Activo					= 1;
			$tDetalle->save();

			if($respuesta == 1){ $si = $si +1; }else{ $no = $no +1; } 

		}


		if($si <= 16){ $calificacion = 'MALO'; }else{ if($si <= 19){ $calificacion = 'REGULAR'; }else{  $calificacion = 'BUENO'; } }



		$tCabecera 					= PERRespuestaZonaADM::find($idcabe); 
		$tCabecera->Si 				= $si;	
		$tCabecera->No 				= $no;
		$tCabecera->Calificacion 	= $calificacion;	
		$tCabecera->save();

		$tPERSolicitudPersonal = PERSolicitudPersonal::find($id); 
		$tPERSolicitudPersonal->Estado 				= 2;


		if($si <= 16){

			$tPERSolicitudPersonal->EstadoCulmino 			= 2;
			$tPERSolicitudPersonal->Proceso					= 'T';
			$tPERSolicitudPersonal->Ubicacion				= 'C';
			$tPERSolicitudPersonal->IdUsuarioAT				= $idusuario;
			$tPERSolicitudPersonal->FechaAT					= $fecha;	

		}


		$tPERSolicitudPersonal->save();	


		$arrayjson[] = array(
							'si'           		=> $si,
							'calificacion'      => $calificacion
		);
		echo json_encode($arrayjson);

	}



	public function actionPrimerExamenATC()
	{


		$generalclass        		 	= new GeneralClass();
		$idpostulante  	 	 	     	= Input::get('idpostulante');
		$xml  	 	 	     		 	= Input::get('xml');
		$fecha 				 			= date("Ymd H:i:s");

		$id 						 	= $generalclass->getDecodificarId($idpostulante);
		$idcabe 					  	= $generalclass->getCreateIdInvictus('PER.PrimerExamenAtcPostulante');

		$tCabecera            	 		=  new PERPrimerExamenAtcPostulante;
		$tCabecera->Id 	     	 		=  $idcabe;
		$tCabecera->IdSolicitudPersonal =  $id;
		$tCabecera->save();


		$listarexamen 					= explode('&&&', $xml);
		$calificacion  	 	 	     	= '';
		$puntaje  	 	 	     		= 0;
		$buenas  	 	 	     		= 0;
		$malas  	 	 	     		= 0;		

		for ($i = 0; $i < count($listarexamen)-1; $i++) {

			$idexa 			 					= $listarexamen[$i];
			$respuesta 	  						= PERRespuestaPrimerExamenAtc::whereId($idexa)->first();

			$iddet = $generalclass->getCreateIdInvictus('PER.DetallePrimerExamenAtcPostulante');

			$tDetalle									= new PERDetallePrimerExamenAtcPostulante;
			$tDetalle->Id 								= $iddet;
			$tDetalle->IdRespuestaPrimerExamenAtc 		= $respuesta->Id;
			$tDetalle->IdPreguntaPrimerExamenAtc 		= $respuesta->IdPreguntaPrimerExamenAtc;
			$tDetalle->IdPrimerExamenAtcPostulante		= $idcabe;
			$tDetalle->IdSolicitudPersonal 				= $id;
			$tDetalle->Descripcion						= $respuesta->Descripcion;
			$tDetalle->Valoracion						= $respuesta->Valoracion;
			$tDetalle->save();

			if($respuesta->Valoracion == 1){ $buenas = $buenas +1; }else{ $malas = $malas +1; }

		}


		if($buenas <= 0){ $calificacion = 'MUY MALO'; }else{ if($buenas <= 5){	$calificacion = 'MALO'; }else{ if($buenas <= 9){ $calificacion = 'REGULAR'; }else{ $calificacion = 'BUENO'; }	} }

		$tCabecera = PERPrimerExamenAtcPostulante::find($idcabe); 
		$tCabecera->Buenas 				= $buenas;	
		$tCabecera->Malas 				= $malas;
		$tCabecera->Calificacion 		= $calificacion;	
		$tCabecera->save();

		$tPERSolicitudPersonal = PERSolicitudPersonal::find($id); 
		$tPERSolicitudPersonal->Estado 				= 6;		
		$tPERSolicitudPersonal->save();		

		echo("1");
	}




	public function actionPrimerExamenAdministrativo()
	{

		$generalclass        		 	= new GeneralClass();
		$idpostulante  	 	 	     	= Input::get('idpostulante');
		$xml  	 	 	     		 	= Input::get('xml');

		$id 						 	= $generalclass->getDecodificarId($idpostulante);

		$idcabe 					  	= $generalclass->getCreateIdInvictus('PER.PrimerExamenAdministradorPostulante');

		$tCabecera            	 		=  new PERPrimerExamenAdministradorPostulante;
		$tCabecera->Id 	     	 		=  $idcabe;
		$tCabecera->IdSolicitudPersonal =  $id;
		$tCabecera->save();


		$listarexamen 	= explode('&&&', $xml);
		$calificacion  	 	 	     	= '';
		$buenas  	 	 	     		= 0;
		$malas  	 	 	     		= 0;

	    $listaprimerexamenadmin     = DB::table('PER.PrimerExamenAdministrador')
				            	    ->get();

		for ($i = 0; $i < count($listarexamen)-1; $i++) {

			$listadetalleexamen 	= explode('***', $listarexamen[$i]);
			$idexa 			 		= $listadetalleexamen[0];
			$uno 			 		= (int)$listadetalleexamen[1];
			$dos 			 		= (int)$listadetalleexamen[2];
			$tres 			 		= (int)$listadetalleexamen[3];

			$iddet = $generalclass->getCreateIdInvictus('PER.DetallePrimerExamenAdministradorPostulante');

			$tDetalle            	 							=  new PERDetallePrimerExamenAdministradorPostulante;
			$tDetalle->Id 	     	 							=  $iddet;
			$tDetalle->IdPrimerExamenAdministrador  			=  $idexa;
			$tDetalle->IdPrimerExamenAdministradorPostulante 	=  $idcabe;
			$tDetalle->IdSolicitudPersonal 						=  $id;
			$tDetalle->Uno 										=  $uno;
			$tDetalle->Dos 										=  $dos;	
			$tDetalle->Tres 									=  $tres;									
			$tDetalle->save();

			foreach($listaprimerexamenadmin as $item){

				if($item->Id ==  $idexa){
					if($uno == 1){ if($item->Uno == 1){	$buenas = $buenas +1; }else{ $malas = $malas +1; } }
					if($dos == 1){ if($item->Dos == 1){	$buenas = $buenas +1; }else{ $malas = $malas +1; } }
					if($tres == 1){ if($item->Tres == 1){ $buenas = $buenas +1; }else{ $malas = $malas +1; } }
				}
			}

		}

		if($buenas <= 9){ $calificacion = 'MALO'; }else{ if($buenas <= 14){	$calificacion = 'REGULAR'; }else{ if($buenas <= 19){ $calificacion = 'BUENO'; }else{ $calificacion = 'MUY BUENO'; }	} }

		$tCabecera = PERPrimerExamenAdministradorPostulante::find($idcabe); 
		$tCabecera->Buenas 				= $buenas;	
		$tCabecera->Malas 				= $malas;
		$tCabecera->Calificacion 		= $calificacion;	
		$tCabecera->save();

		$tPERSolicitudPersonal = PERSolicitudPersonal::find($id); 
		$tPERSolicitudPersonal->Estado 				= 6;		
		$tPERSolicitudPersonal->save();		

		echo("1");
	}




	public function actionActualizarCronometroExamen()
	{

		$generalclass        		 = new GeneralClass();
		$idpostulante  	 	 	     = Input::get('idpostulante');
		$horacompleta  	 	 	     = Input::get('horacompleta');
		$accionhora  	 	 	     = (int)Input::get('accionhora');

		$id = $generalclass->getDecodificarId($idpostulante);

		$tPERSolicitudPersonal = PERSolicitudPersonal::find($id); 

		if($accionhora == 1){
			$tPERSolicitudPersonal->TiempoPrimerExamenAdmTer = $horacompleta;
		}else{
			if($accionhora == 2){
				$tPERSolicitudPersonal->TiempoPrimerExamenAtcTer = $horacompleta;
			}else{
				if($accionhora == 3){
					$tPERSolicitudPersonal->TiempoSegundoExamenAdmTer = $horacompleta;
				}else{
					$tPERSolicitudPersonal->TiempoSegundoExamenAtcTer = $horacompleta;
				}				
			}			
		}	
		$tPERSolicitudPersonal->save();

		echo("1");
	}



	public function actionEmpezarSegundoExamen()
	{

		$generalclass        		 = new GeneralClass();
		$idpostulante  	 	 	     = Input::get('idpostulante');

		$id = $generalclass->getDecodificarId($idpostulante);

		$tPERSolicitudPersonal = PERSolicitudPersonal::find($id); 
		$tPERSolicitudPersonal->Estado 				= 7;		
		$tPERSolicitudPersonal->save();

		echo("1");
	}



	public function actionEmpezarPrimerExamen()
	{

		$generalclass        		 = new GeneralClass();
		$idpostulante  	 	 	     = Input::get('idpostulante');

		$id = $generalclass->getDecodificarId($idpostulante);

		$tPERSolicitudPersonal = PERSolicitudPersonal::find($id); 
		$tPERSolicitudPersonal->Estado 				= 5;		
		$tPERSolicitudPersonal->save();

		echo("1");
	}




	public function actionContinuarTerminoCondiciones()
	{

		$generalclass        		 = new GeneralClass();
		$idpostulante  	 	 	     = Input::get('idpostulante');

		$id = $generalclass->getDecodificarId($idpostulante);

		$tPERSolicitudPersonal = PERSolicitudPersonal::find($id); 
		$tPERSolicitudPersonal->Estado 				= 1;		
		$tPERSolicitudPersonal->save();

		echo("1");
	}


	public function actionContinuarProcesoSeleccion()
	{

		$generalclass        		 = new GeneralClass();
		$idpostulante  	 	 	     = Input::get('idpostulante');

		$id = $generalclass->getDecodificarId($idpostulante);

		$tPERSolicitudPersonal = PERSolicitudPersonal::find($id); 
		$tPERSolicitudPersonal->Estado 				= 3;		
		$tPERSolicitudPersonal->save();

		echo("1");
	}




	public function actionInsertarDatosPersonalesPostulante()
	{


		$generalclass        		 = new GeneralClass();
		$nombretermino  	 	 	 = Input::get('nombretermino');
		$dnitermino  	 	 	 	 = Input::get('dnitermino');
		$fechanacimiento  	 	 	 = Input::get('fechanacimiento');
		$direccion  	 	 	     = Input::get('direccion');
		$sexo  	 	 	         	 = Input::get('sexo');		
		$provincia  	 	 	     = Input::get('provincia');
		$distrito  	 	 	         = Input::get('distrito');
		$celular  	 	 	         = Input::get('celular');
		$telefono  	 	 	         = Input::get('telefono');
		$correoelectronico  	 	 = Input::get('correoelectronico');

		$gradoinstruccion  	 	 	 = Input::get('gradoinstruccion');
		$nombrecarrera  	 	 	 = Input::get('nombrecarrera');
		$centroestudios  	 	 	 = Input::get('centroestudios');		
		$cicloacademico  	 	 	 = Input::get('cicloacademico');
		$gradoestudio  	 	 	 	 = Input::get('gradoestudio');	


		$medio  	 	 	         = Input::get('medio');
		$idpostulante  	 	 	     = Input::get('idpostulante');
		$xmlreferencia  	 	 	 = Input::get('xmlreferencia');
		$xmlprograma  	 	 	     = Input::get('xmlprograma');
		$xmlidioma  	 	 	     = Input::get('xmlidioma');
		$xmltrabajo  	 	 	     = Input::get('xmltrabajo');
		$especificarmedio  	 	 	 = Input::get('especificarmedio');

		$talento  	 	 	     	 = Input::get('talento');
		$xmlhijosesposa  	 	 	 = Input::get('xmlhijosesposa');
		$xmlcursoadicional  	 	 = Input::get('xmlcursoadicional');
		$nombreultimo  	 	 	     = Input::get('nombreultimo');
		$celularultimmo  	 	 	 = Input::get('celularultimmo');				


		$id = $generalclass->getDecodificarId($idpostulante);

		$tPERSolicitudPersonal = PERSolicitudPersonal::find($id); 
		$tPERSolicitudPersonal->FechaNac 	 		= $fechanacimiento;
		$tPERSolicitudPersonal->Direccion 	 		= $direccion;
		$tPERSolicitudPersonal->Sexo 	 			= $sexo;

		$tPERSolicitudPersonal->IdDistrito 	 		= $distrito;
		$tPERSolicitudPersonal->TelefonoFijo 		= $telefono;
		$tPERSolicitudPersonal->Celular 	 		= $celular;
		$tPERSolicitudPersonal->CorreoElectronico 	= $correoelectronico;
		$tPERSolicitudPersonal->IdGradoInstruccion 	= $gradoinstruccion;

		$tPERSolicitudPersonal->NombreCarrera 		= $nombrecarrera;
		$tPERSolicitudPersonal->CentroEstudios 	 	= $centroestudios;
		$tPERSolicitudPersonal->CicloAcademico 		= $cicloacademico;
		$tPERSolicitudPersonal->IdGradoEstudio 		= $gradoestudio;

		$tPERSolicitudPersonal->IdMedio 	 		= $medio;
		$tPERSolicitudPersonal->EspecificarMedio 	= $especificarmedio;
		$tPERSolicitudPersonal->CelularUltimoTrabajo = $celularultimmo;
		$tPERSolicitudPersonal->NombreUltimoTrabajo = $nombreultimo;
		$tPERSolicitudPersonal->IdHabilidadTalento 	= $talento;
		$tPERSolicitudPersonal->Estado 				= 4;		
		$tPERSolicitudPersonal->save();



		$listareferencia 	= explode('&&&', $xmlreferencia);

		for ($i = 0; $i < count($listareferencia)-1; $i++) {

			$listareferencianumero 	= explode('***', $listareferencia[$i]);
			$tr 			 	= $listareferencianumero[0];
			$nr 			 	= $listareferencianumero[1];

			$iddet = $generalclass->getCreateIdInvictus('PER.ReferenciaPostulante');

			$tDetalle            	 		=  new PERReferenciaPostulante;
			$tDetalle->Id 	     	 		=  $iddet;
			$tDetalle->IdSolicitudPersonal  =  $id;
			$tDetalle->NombreReferencia 	=  $nr;
			$tDetalle->TelefonoReferencia 	=  $tr;
			$tDetalle->save();

		}


		$listahijosesposa 	= explode('&&&', $xmlhijosesposa);

		for ($i = 0; $i < count($listahijosesposa)-1; $i++) {

			$listahijosesposanumero 	= explode('***', $listahijosesposa[$i]);
			$ne 			 	= $listahijosesposanumero[0];
			$dnie 			 	= $listahijosesposanumero[1];
			$ee 			 	= (int)$listahijosesposanumero[2];
			$nh 			 	= $listahijosesposanumero[3];
			$dnih 			 	= $listahijosesposanumero[4];
			$eh 			 	= $listahijosesposanumero[5];

			$iddet = $generalclass->getCreateIdInvictus('PER.EsposaHijoPostulante');

			$tDetalle            	 		=  new PEREsposaHijoPostulante;
			$tDetalle->Id 	     	 		=  $iddet;
			$tDetalle->IdSolicitudPersonal  =  $id;
			$tDetalle->NombreEsposo 		=  $ne;
			$tDetalle->DNIEsposo 			=  $dnie;
			$tDetalle->EdadEsposo 			=  $ee;
			if($nh != ''){
				$tDetalle->NombreHijo 		=  $nh;
				$tDetalle->DNIHijo 			=  $dnih;
				$tDetalle->EdadHijo 		=  (int)$eh;	

			}
			$tDetalle->save();

		}


		$listaprograma 	= explode('&&&', $xmlprograma);

		for ($i = 0; $i < count($listaprograma)-1; $i++) {

			$listaprogramadet 	= explode('***', $listaprograma[$i]);
			$idprograma 			 	= $listaprogramadet[0];
			$idnivelprograma			= $listaprogramadet[1];

			$iddet = $generalclass->getCreateIdInvictus('PER.ComputacionPostulante');

			$tDetalle            	 		=  new PERComputacionPostulante;
			$tDetalle->Id 	     	 		=  $iddet;
			$tDetalle->IdSolicitudPersonal  =  $id;
			$tDetalle->IdProgramas 			=  $idprograma;
			$tDetalle->IdNivel 				=  $idnivelprograma;
			$tDetalle->save();

		}


		$listaidioma 	= explode('&&&', $xmlidioma);

		for ($i = 0; $i < count($listaidioma)-1; $i++) {

			$listaidiomadet 			= explode('***', $listaidioma[$i]);
			$ididioma			 		= $listaidiomadet[0];
			$idnivelidioma				= $listaidiomadet[1];

			$iddet = $generalclass->getCreateIdInvictus('PER.IdiomaPostulante');

			$tDetalle            	 		=  new PERIdiomaPostulante;
			$tDetalle->Id 	     	 		=  $iddet;
			$tDetalle->IdSolicitudPersonal  =  $id;
			$tDetalle->IdIdioma 			=  $ididioma;
			$tDetalle->IdNivel 				=  $idnivelidioma;
			$tDetalle->save();

		}

		$listacursoadicional	= explode('&&&', $xmlcursoadicional);

		for ($i = 0; $i < count($listacursoadicional)-1; $i++) {

			$cursoadicional	 = $listacursoadicional[$i];
			$iddet = $generalclass->getCreateIdInvictus('PER.CursoAdicionalPostulante');

			$tDetalle            	 		=  new PERCursoAdicionalPostulante;
			$tDetalle->Id 	     	 		=  $iddet;
			$tDetalle->IdSolicitudPersonal  =  $id;
			$tDetalle->NombreCurso 			=  $cursoadicional;
			$tDetalle->save();

		}





		$listatrabajo 	= explode('&&&', $xmltrabajo);

		for ($i = 0; $i < count($listatrabajo)-1; $i++) {

			$listatrabajodet 			= explode('***', $listatrabajo[$i]);
			$empresa			 		= $listatrabajodet[0];
			$iddepartamento				= $listatrabajodet[1];
			$cargo						= $listatrabajodet[2];
			$funcion					= $listatrabajodet[3];			


			$iddet = $generalclass->getCreateIdInvictus('PER.ReferenciaTrabajoPostulante');

			$tDetalle            	 		=  new PERReferenciaTrabajoPostulante;
			$tDetalle->Id 	     	 		=  $iddet;
			$tDetalle->IdSolicitudPersonal  =  $id;
			$tDetalle->Empresa 				=  $empresa;
			$tDetalle->IdDepartamento 		=  $iddepartamento;
			$tDetalle->Cargo 				=  $cargo;						
			$tDetalle->Funcion 				=  $funcion;
			$tDetalle->save();

		}

		echo("1");
	}


	public function actionProcesoSeleccionPostulante($idsolicitud,$idpostulante,$idopcion)
	{


		$generalclass        		= new GeneralClass();

		$solicitud  		 		= PERSolicitud::where('Id','=',$generalclass->getDecodificarId($idsolicitud))->first();
		if($solicitud->IdTipoUsuario == 'LIM01CEN000000000003'){ $puestotrabajo = 'ATC'; }else{ $puestotrabajo = 'ADM';	}



		$postulante  		 		= PERSolicitudPersonal::where('Id','=',$generalclass->getDecodificarId($idpostulante))->first();
		$codigo 			 		= Session::get('Usuario')[0]->Codigo;

		$provincia  				= GENProvincia::where('Activo','=',1)->orderBy('Descripcion', 'asc')->lists('Descripcion', 'Id');
		$comboprovincia  			= array(0 => "Seleccione Provincia") + $provincia;

		$departamento  				= GENDepartamento::where('Activo','=',1)->orderBy('Descripcion', 'asc')->lists('Descripcion', 'Id');
		$combodepartamento 			= array(0 => "Seleccione Departamento") + $departamento;

		$gradoinstruccion  			= PERGradoInstruccion::where('Activo','=',1)->orderBy('Id', 'asc')->lists('Nombre', 'Id');
		$combogradoinstruccion  	= array(0 => "Seleccione Grado Instrucción") + $gradoinstruccion;

		$nivel  					= PERNivel::where('Activo','=',1)->orderBy('Nombre', 'asc')->lists('Nombre', 'Id');
		$combonivel  				= array(0 => "Seleccione Nivel") + $nivel;

		$programas  				= PERProgramas::where('Activo','=',1)->orderBy('Nombre', 'asc')->lists('Nombre', 'Id');
		$comboprograma 				= array(0 => "Seleccione Programa") + $programas;

		$idioma  					= PERIdioma::where('Activo','=',1)->orderBy('Nombre', 'asc')->lists('Nombre', 'Id');
		$comboidioma 				= array(0 => "Seleccione Idioma") + $idioma;

		$medios  					= PERMedios::where('Activo','=',1)->orderBy('Nombre', 'asc')->lists('Nombre', 'Id');
		$combomedio 				= array(0 => "Seleccione Medio") + $medios;

		$estadocivil  				= PEREstadoCivil::where('Activo','=',1)->orderBy('Nombre', 'asc')->lists('Nombre', 'Id');
		$comboestadocivil  			= array(0 => "Seleccione Estado Civil") + $estadocivil;

		$habilidadtalento  			= PERHabilidadTalento::where('Activo','=',1)->orderBy('Nombre', 'asc')->lists('Nombre', 'Id');
		$combohabilidadtalento  	= array(0 => "Seleccione Talento") + $habilidadtalento;

		$gradoestudio  				= PERGradoEstudios::where('Activo','=',1)->orderBy('Nombre', 'asc')->lists('Nombre', 'Id');
		$combogradoestudio 			= array(0 => "Seleccione Grado Estudio") + $gradoestudio;

		/************************   Examen del Administrador al Postulante *********************/

		$listaLugarInspeccion    	= PERLugarInspeccionADM::where('Activo','=','1')
									 ->orderBy('Id', 'asc')
									 ->get();

		$listaTituloInspeccion   	= PERTituloInspeccionADM::where('Activo','=','1')
									 ->orderBy('Id', 'asc')
									 ->get();	
		$listaPreguntaDetalleBPM 	= PERPreguntaDetalleADM::where('Activo','=','1')
									 ->orderBy('Id', 'asc')
									 ->get();

		$respuestaexamenadmin       = DB::table('PER.RespuestaZonaADM')->where('IdSolicitudPersonal','=',$generalclass->getDecodificarId($idpostulante))->first();

		/****************************************************************************************/



	    $listaprimerexamenadmin     = DB::table('PER.PrimerExamenAdministrador')
				            	    ->get();

	    /*$listaprimerexamenatc     = DB::table('PER.PrimerExamenAtc')
				            	    ->get();	*/			            	    


		/************************   Primer Examen atc *********************/

		$listaprimerexamenatcpostulante  = PERPreguntaPrimerExamenAtc::join('PER.RespuestaPrimerExamenAtc', 'PER.PreguntaPrimerExamenAtc.Id', '=', 'PER.RespuestaPrimerExamenAtc.IdPreguntaPrimerExamenAtc')
										 ->select('PER.PreguntaPrimerExamenAtc.Descripcion as NombrePregunta','PER.RespuestaPrimerExamenAtc.IdPreguntaPrimerExamenAtc','PER.RespuestaPrimerExamenAtc.Id',
										 		  'PER.RespuestaPrimerExamenAtc.Descripcion','PER.RespuestaPrimerExamenAtc.Valoracion','PER.PreguntaPrimerExamenAtc.Categoria')
										 ->where('PER.PreguntaPrimerExamenAtc.Activo','=','1')
										 ->where('PER.RespuestaPrimerExamenAtc.Activo','=','1')
										 ->orderBy('PER.RespuestaPrimerExamenAtc.IdPreguntaPrimerExamenAtc', 'asc')
										 ->get();

		/****************************************************************************************/




		/************************   Segundo Examen seleccion *********************/

		$listasegundoexamen    		= PERPreguntaVentas::join('PER.RespuestaVenta', 'PER.PreguntaVentas.Id', '=', 'PER.RespuestaVenta.IdPreguntaVenta')
									 ->select('PER.PreguntaVentas.Descripcion as NombrePregunta','PER.RespuestaVenta.IdPreguntaVenta','PER.RespuestaVenta.Id',
									 		  'PER.RespuestaVenta.Descripcion','PER.RespuestaVenta.Valoracion')
									 ->where('PER.PreguntaVentas.Activo','=','1')
									 ->where('PER.RespuestaVenta.Activo','=','1')
									 ->orderBy('PER.RespuestaVenta.IdPreguntaVenta', 'asc')
									 ->get();

		/****************************************************************************************/

		$combosexo 					= array(0 => "Seleccione Sexo",'H' => "Hombre",'M' => "Mujer");


		return View::make('personal/procesoseleccion',
		[
		 'idsolicitud' 		  		=> $idsolicitud,
		 'puestotrabajo'  			=> $puestotrabajo,
		 'idpostulante' 	  		=> $idpostulante,
		 'postulante' 		  		=> $postulante,
		 'codigo' 		  	  		=> $codigo,
		 'idopcion' 		  		=> $idopcion,
		 'comboprovincia' 			=> $comboprovincia,
		 'combogradoinstruccion' 	=> $combogradoinstruccion,
		 'comboestadocivil' 		=> $comboestadocivil,
		 'combonivel' 				=> $combonivel,
		 'comboprograma' 			=> $comboprograma,
		 'comboidioma' 				=> $comboidioma,
		 'combomedio' 				=> $combomedio,
		 'combodepartamento' 		=> $combodepartamento,
		 'combohabilidadtalento' 	=> $combohabilidadtalento,
		 'combogradoestudio' 		=> $combogradoestudio,
		 'combosexo' 				=> $combosexo,
		 'listaLugarInspeccion'     => $listaLugarInspeccion,
		 'listaTituloInspeccion'    => $listaTituloInspeccion,
		 'listaPreguntaDetalleBPM'  => $listaPreguntaDetalleBPM,
		 'respuestaexamenadmin'  	=> $respuestaexamenadmin,
		 'listaprimerexamenadmin' 	=> $listaprimerexamenadmin,
		 //'listaprimerexamenatc' 	=> $listaprimerexamenatc,
		 'listasegundoexamen' 		=> $listasegundoexamen,	
		 'listaprimerexamenatcpostulante' 		=> $listaprimerexamenatcpostulante,		 
		]);



	}	


	public function actionInsertarTerminoCondicion()
	{

		$generalclass        = new GeneralClass();
		$idsolicitud  	 	 = Input::get('idSolicitud');
		$nombre  	 	 	 = Input::get('nombretermino');
		$apellido  	 	 	 = Input::get('apellidotermino');
		$termino  	 	 	 = Input::get('termino');
		$dni  	 	 	 	 = Input::get('dnitermino');
		$cantidadplay  	 	 = Input::get('cantidadplay');


		$idopcion  	 	 	 = Input::get('idopcion');
		//$fecha 				 = date("Y-m-d H:i:s");
		$fecha 				 = date("Ymd H:i:s");
		$idusuario 			 = Session::get('Usuario')[0]->Id;
		$id 				 = $generalclass->getCreateIdInvictus('PER.SolicitudPersonal');

		$postulante 			 							= PERSolicitudPersonal::where('Dni','=',$dni)->first();

		if(count($postulante)>0){ return Redirect::back()->with('alertaMensajeGlobalE', 'Este DNI ya se encuentra registrado (Llamar al Administrador)'); }

		$tiempo 			 								= PERTiemposExamen::first();
		$tPERSolicitudPersonal								= new PERSolicitudPersonal;
		$tPERSolicitudPersonal->Id 							= $id;
		$tPERSolicitudPersonal->IdSolicitud 				= $generalclass->getDecodificarId($idsolicitud);
		$tPERSolicitudPersonal->Nombre						= $nombre;
		$tPERSolicitudPersonal->Apellido					= $apellido;

		$tPERSolicitudPersonal->Dni 			    		= $dni;
		$tPERSolicitudPersonal->CantidadPlay 			    = $cantidadplay;
		$tPERSolicitudPersonal->Termino						= $termino;

		$tPERSolicitudPersonal->TiempoPrimerExamenAdm		= $tiempo->TiempoPrimerExamenAdm;
		$tPERSolicitudPersonal->TiempoPrimerExamenAtc 		= $tiempo->TiempoPrimerExamenAtc;
		$tPERSolicitudPersonal->TiempoSegundoExamenAdm		= $tiempo->TiempoSegundoExamenAdm;
		$tPERSolicitudPersonal->TiempoSegundoExamenAtc		= $tiempo->TiempoSegundoExamenAtc;
		$tPERSolicitudPersonal->TiempoPrimerExamenAdmTer 	= '00:00';
		$tPERSolicitudPersonal->TiempoPrimerExamenAtcTer	= '00:00';
		$tPERSolicitudPersonal->TiempoSegundoExamenAdmTer	= '00:00';
		$tPERSolicitudPersonal->TiempoSegundoExamenAtcTer 	= '00:00';

		$tPERSolicitudPersonal->IdUsuario					= $idusuario;
		$tPERSolicitudPersonal->FechaCrea					= $fecha;
		$tPERSolicitudPersonal->Activo						= 1;
		$tPERSolicitudPersonal->Estado						= '0';

		if($termino == '0'){
			$tPERSolicitudPersonal->EstadoCulmino			= '0';
			$tPERSolicitudPersonal->Proceso					= 'T';
			$tPERSolicitudPersonal->Ubicacion				= 'C';
			$tPERSolicitudPersonal->IdUsuarioAT				= $idusuario;
			$tPERSolicitudPersonal->FechaAT					= $fecha;
		}else{
			$tPERSolicitudPersonal->Proceso					= 'P';
			$tPERSolicitudPersonal->Ubicacion				= 'Z';
		}


		$tPERSolicitudPersonal->save();


		return Redirect::to('/proceso-seleccion-postulante'.'/'.$idsolicitud.'/'.Hashids::encode(substr($id, -12)).'/'.$idopcion);


	}	






	public function actionListaPostulanteSolicitud()
	{

		$idsolicitud  	 	 	 = Input::get('idsolicitud');
		$idopcion  	 	 	 	 = Input::get('idopcion');
		$listapostulante 		 = PERSolicitudPersonal::where('IdSolicitud','=',$idsolicitud)->get();

		return View::make('personalajax/listapersonalajax',
		[
		 'idsolicitud' 			 => $idsolicitud,
		 'idopcion' 			 => $idopcion,
		 'listapostulante' 		 => $listapostulante
		]);

	}



	public function actionAgregarPersonalSolicitud($idOpcionRolPlus,$idSolicitud,$idopcion)
	{

		/***** Permiso a la Opciones PLus ******/
		$validarpermiso = new GeneralClass();
    	$listaOpcionPlus = $validarpermiso->getPermisoPlus($idOpcionRolPlus);
  		if(count($listaOpcionPlus)==0){
			return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para esta Opcion(Agregar Personal)');
		}

		$solicitud  				= PERSolicitud::where('Id','=',$idSolicitud)->first();

		return View::make('personal/agregarpersonalsolicitud',
		[
		 'idOpcionRolPlus' 			=> $idOpcionRolPlus,
		 'idSolicitud' 				=> $idSolicitud,
		 'solicitud' 				=> $solicitud,
		 'idopcion' 				=> $idopcion,
		]);

	}	






    /**************************************** Solicitud Personal ************************************/

	public function actionListaSolicitudPersonal($idOpcion)
	{


		$validarurl = new GeneralClass();
    	$exits = $validarurl->getUrl($idOpcion);

    	if(!$exits){
    		return Response::view('error.error404',array(), 404);
    	}

		$idusuario = Session::get('Usuario')[0]->Id;

		$listaSolicitudPersonal = DB::table('PER.Solicitud')
		->join('GEN.Local', 'GEN.Local.Id', '=', 'PER.Solicitud.IdLocal')
		->join('PER.MotivoSolicitud', 'PER.MotivoSolicitud.Id', '=', 'PER.Solicitud.IdMotivoSolicitud')
		->join('PER.PuestoTrabajo', 'PER.PuestoTrabajo.Id', '=', 'PER.Solicitud.IdTipoUsuario')
		->join('tbUsuarioLocal', 'tbUsuarioLocal.Id', '=', 'PER.Solicitud.IdUsuarioCrea')
		->select('PER.Solicitud.Id','PER.Solicitud.Correlativo','GEN.Local.Nombre','PER.Solicitud.FechaCrea',
				 'PER.MotivoSolicitud.Nombre as MotivoSolicitud','PER.PuestoTrabajo.Nombre as Cargo',
				 'tbUsuarioLocal.Nombre as Nombreusuario','tbUsuarioLocal.Apellido as Apellidousuario','PER.Solicitud.Estado')
		->where('PER.Solicitud.Estado','<>','RE')
		->where('PER.Solicitud.Estado','<>','CE')
   		->orderBy('PER.Solicitud.FechaCrea', 'desc')
   		->take(30)
	    ->get();

	    $listaOpcionPlus = $validarurl->getlistaOpcionPlus($idOpcion);

		return View::make('personal/listasolicitudpersonal',
						 [
						  'listaSolicitudPersonal'  	 => $listaSolicitudPersonal,
						  'listaOpcionPlus'	 			 => $listaOpcionPlus,
						  'idOpcion' 		 			 => $idOpcion
						  ]);
	}





	public function actionInsertarSolicitudPersonal($idOpcion)
	{

		if($_POST){

			try{

				set_time_limit(0);
				DB::beginTransaction();

				$IdMotivoSolicitud 	= Input::get('motivosolicitud');
				$xmlusuariomotivo 	= Input::get('xmlusuariomotivo');
				$Autorizacion 		= Input::get('autorizacion');
				$IdTipoUsuario 		= Input::get('tipousuario');
				$NumeroVacantes 	= Input::get('numerovacantes');
				$Observacion 		= Input::get('observacion');


				$IdUsuarioCrea 		= Session::get('Usuario')[0]->Id;
				$fecha 				= date("Ymd H:i:s");
				$hoy 				= date("Ymd");

				$clases 			= new GeneralClass();
		    	$id 				= $clases->getCreateIdInvictus('PER.Solicitud');
				$correlativo 		= $clases->getCorrelativo('PER.Solicitud'); 

				$idLo = DB::table('INV.Sublocales')->where('INV.Sublocales.Id', '=', 'LIM01CEN000000000001')->first(); 

				$tPERSolicitud						= new PERSolicitud;
				$tPERSolicitud->Id 					= $id;
				$tPERSolicitud->Correlativo 		= $correlativo;
				$tPERSolicitud->IdLocal				= $idLo->IdLocal;
				$tPERSolicitud->IdMotivoSolicitud	= $IdMotivoSolicitud;
				$tPERSolicitud->Autorizacion		= $Autorizacion;
				$tPERSolicitud->IdTipoUsuario		= $IdTipoUsuario;
				$tPERSolicitud->NumeroVacantes		= $NumeroVacantes;
				$tPERSolicitud->Observacion			= $Observacion;
				$tPERSolicitud->IdUsuarioCrea		= $IdUsuarioCrea;
				$tPERSolicitud->Activo 				= 1;
				$tPERSolicitud->Email 				= 0;
				$tPERSolicitud->EmailMod 			= 0;
				$tPERSolicitud->Estado				= 'ES';	
				$tPERSolicitud->Fecha				= $hoy;				
				$tPERSolicitud->FechaCrea			= $fecha;
				$tPERSolicitud->save();


				$listausuario 	= explode('&&&', $xmlusuariomotivo);

				for ($i = 0; $i < count($listausuario)-1; $i++) {

					$listausuariomotivo = explode('***', $listausuario[$i]);
					$idusuario 			 = $listausuariomotivo[0];
					$idmotivo 			 = $listausuariomotivo[1];
					$usuario 			 = $listausuariomotivo[2];
					$motivo 			 = $listausuariomotivo[3];


					$iddet = $clases->getCreateIdInvictus('PER.SolicitudPersonalMotivo');

					$tDetalle            	 	=	new PERSolicitudPersonalMotivo;
					$tDetalle->Id 	     	 	=  $iddet;
					$tDetalle->IdSolicitud  	=  $id;
					$tDetalle->IdUsuario 	 	=  $idusuario;
					$tDetalle->IdMotivoRemplazo =  $idmotivo;
					$tDetalle->Usuario 	 		=  $usuario;
					$tDetalle->Remplazo 	 	=  $motivo;
					$tDetalle->Activo  	 		=  1;
					$tDetalle->save();
				}


				DB::commit();


			}catch(Exception $ex){
				DB::rollback();
				return Redirect::to('/getion-solicitud-personal/'.$idOpcion)->with('alertaMensajeGlobalE', 'Ocurrio un error inesperado. Porfavor contacte con el administrador del sistema');	
			}


			/******************************************* Envio de Email *******************************************/


			$data = PERSolicitud::join('GEN.Local', 'GEN.Local.Id', '=', 'PER.Solicitud.IdLocal')
			->join('PER.MotivoSolicitud', 'PER.MotivoSolicitud.Id', '=', 'PER.Solicitud.IdMotivoSolicitud')
			->join('PER.PuestoTrabajo', 'PER.PuestoTrabajo.Id', '=', 'PER.Solicitud.IdTipoUsuario')
			->join('tbUsuarioLocal', 'tbUsuarioLocal.Id', '=', 'PER.Solicitud.IdUsuarioCrea')		
			->select('PER.Solicitud.Id','PER.Solicitud.Correlativo','PER.Solicitud.Autorizacion','PER.PuestoTrabajo.Nombre as Cargo',
					'GEN.Local.Nombre as NombreLocal','PER.Solicitud.NumeroVacantes','PER.Solicitud.Observacion','PER.Solicitud.FechaCrea',
					'PER.Solicitud.IdUsuarioMod','PER.MotivoSolicitud.Nombre as MotivoSolicitud','PER.Solicitud.IdMotivoSolicitud')
			->where('PER.Solicitud.Id','=',$id)
		    ->first();



		    $email = GENSmsEmail::where('GEN.SmsEmail.Id','=','LIM01CEN000000000002')->first(); 
			$asunto = $data->NombreLocal;


			$array = $data->toArray();

	        try {

				Mail::send('emails.solicitud', $array, function($message) use ($email,$asunto)
				{

					$emails = explode(",", $email->Correo); 
				    $message->from('sistemascoffe@altomayoretail.pe', $email->DescripcionEstado);
				    $message->to($emails);
				    $message->subject('SOLICITUD PERSONAL '.$asunto);

				});

				$tPERSolicitud            =	PERSolicitud::find($id); 
				$tPERSolicitud->Email 	  = 1;
				$tPERSolicitud->save();

	        } catch (Exception $e) {
				return Redirect::to('/getion-solicitud-personal'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro Exitoso');
	        }

			return Redirect::to('/getion-solicitud-personal'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Registro Exitoso');
			

		}else{


			$permiso=permisos($idOpcion,'Anadir');

			if($permiso==0){

				return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para añadir aquí');

			}else{

				$motivosolicitud = PERMotivoSolicitud::where('Activo','=',1)->lists('Nombre', 'Id');
				$combomotivosolicitud  = array(0 => "Seleccione Motivo Solicitud") + $motivosolicitud;

				$tipousuario= PERPuestoTrabajo::where('Activo','=',1)
							  ->lists('Nombre', 'Id');

				$combotipousuario  = array(0 => "Seleccione Cargo") + $tipousuario;


				$local= GENLocal::join('GEN.LocalMovil', 'GEN.Local.Id', '=', 'GEN.LocalMovil.IdLocal')
							  ->where('GEN.LocalMovil.Activo','=',1)
							  ->where('GEN.LocalMovil.IdLocal','!=','LIM01CEN000000000000')
							  ->select('GEN.Local.Id','GEN.Local.Nombre')
							  ->lists('Nombre', 'Id');
				$combolocal  = array(0 => "Seleccione Area") + $local;


				$usuarior = tbUsuarioLocal::select(DB::raw("Id , Apellido + ' ' + Nombre as Nombre "))
							->orderBy('Nombre', 'asc')
							->whereIn('IdTipoUsuario', ['LIM01CEN000000000002','LIM01CEN000000000003'])
							->lists('Nombre', 'Id');

				$combousuarior  = array(0 => "Seleccione Personal de Remplazo") + $usuarior;

				$motivoreemplazo = PERMotivoReemplazo::where('Activo','=',1)->lists('Nombre', 'Id');
				$combomotivoreemplazo  = array(0 => "Seleccione Motivo Reemplazo") + $motivoreemplazo;



		        return View::make('personal/insertarsolicitudpersonal', 
						[
						 	'idOpcion' 		 		=> $idOpcion,
						 	'combomotivosolicitud' 	=> $combomotivosolicitud,
						 	'combomotivoreemplazo' 	=> $combomotivoreemplazo,
						 	'combotipousuario' 		=> $combotipousuario,
						 	'combolocal' 			=> $combolocal,
						 	'combousuarior' 		=> $combousuarior,
						]);
			}
		}
	}	


	public function actionModificarSolicitudPersonal($idOpcion,$idSolicitud)
	{


		if($_POST)
		{

			try{

				DB::beginTransaction();

				/*$IdMotivoSolicitud 	= Input::get('motivosolicitud');
				$IdUsuario 			= Input::get('usuarior');
				$IdMotivoRemplazo 	= Input::get('motivoreemplazo');
				$Autorizacion 		= Input::get('autorizacion');
				$IdTipoUsuario 		= Input::get('tipousuario');
				$IdLocal 			= Input::get('local');
				$NumeroVacantes 	= Input::get('numerovacantes');
				$EdadInicio 		= Input::get('edadinicio');		
				$EdadFin 			= Input::get('edadfin');	
				$PerfilPuesto 		= Input::get('perfilpuesto');
				$FuncionesPuesto 	= Input::get('funcionpuesto');
				$HorariosTrabajo 	= Input::get('horatrabajo');			
				$Sueldo 			= Input::get('sueldo');*/
				$Observacion 		= Input::get('observacion');
				$IdUsuarioMod 		= Session::get('Usuario')[0]->Id;
	
				$tPERSolicitud						= PERSolicitud::find($idSolicitud);
				/*$tPERSolicitud->IdMotivoSolicitud	= $IdMotivoSolicitud;
				$tPERSolicitud->IdUsuario			= $IdUsuario;
				$tPERSolicitud->IdMotivoRemplazo	= $IdMotivoRemplazo;
				$tPERSolicitud->Autorizacion		= $Autorizacion;
				$tPERSolicitud->IdTipoUsuario		= $IdTipoUsuario;
				$tPERSolicitud->IdLocal				= $IdLocal;
				$tPERSolicitud->NumeroVacantes		= $NumeroVacantes;
				$tPERSolicitud->EdadInicio			= $EdadInicio;
				$tPERSolicitud->EdadFin				= $EdadFin;
				$tPERSolicitud->PerfilPuesto		= $PerfilPuesto;
				$tPERSolicitud->FuncionesPuesto		= $FuncionesPuesto;
				$tPERSolicitud->HorariosTrabajo		= $HorariosTrabajo;
				$tPERSolicitud->Sueldo				= $Sueldo;*/
				$tPERSolicitud->Observacion			= $Observacion;
				$tPERSolicitud->IdUsuarioMod		= $IdUsuarioMod;
				$tPERSolicitud->save();

				DB::commit();


			}catch(Exception $ex){
				DB::rollback();
				return Redirect::to('/getion-solicitud-personal/'.$idOpcion)->with('alertaMensajeGlobalE', 'Ocurrio un error inesperado. Porfavor contacte con el administrador del sistema');	
			}



			/******************************************* Envio de Email *******************************************/


			$data = PERSolicitud::join('GEN.Local', 'GEN.Local.Id', '=', 'PER.Solicitud.IdLocal')
			->join('PER.MotivoSolicitud', 'PER.MotivoSolicitud.Id', '=', 'PER.Solicitud.IdMotivoSolicitud')
			->join('PER.PuestoTrabajo', 'PER.PuestoTrabajo.Id', '=', 'PER.Solicitud.IdTipoUsuario')
			->join('tbUsuarioLocal', 'tbUsuarioLocal.Id', '=', 'PER.Solicitud.IdUsuarioCrea')		
			->select('PER.Solicitud.Id','PER.Solicitud.Correlativo','PER.Solicitud.Autorizacion','PER.PuestoTrabajo.Nombre as Cargo',
					'GEN.Local.Nombre as NombreLocal','PER.Solicitud.NumeroVacantes','PER.Solicitud.Observacion','PER.Solicitud.FechaCrea',
					'PER.Solicitud.IdUsuarioMod','PER.MotivoSolicitud.Nombre as MotivoSolicitud','PER.Solicitud.IdMotivoSolicitud')
			->where('PER.Solicitud.Id','=',$idSolicitud)
		    ->first();


		    $email = GENSmsEmail::where('GEN.SmsEmail.Id','=','LIM01CEN000000000002')->first(); 
			$asunto = $data->NombreLocal;
			$array = $data->toArray();

	        try {

				Mail::send('emails.solicitud', $array, function($message) use ($email,$asunto)
				{

					$emails = explode(",", $email->Correo); 
				    $message->from('sistemascoffe@altomayoretail.pe', $email->DescripcionEstado);
				    $message->to($emails);
				    $message->subject('SOLICITUD PERSONAL '.$asunto);

				});

				$tPERSolicitud            	=	PERSolicitud::find($idSolicitud); 
				$tPERSolicitud->EmailMod 	= 1;
				$tPERSolicitud->save();

	        } catch (Exception $e) {
				return Redirect::to('/getion-solicitud-personal'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Modificación Exitosa');
	        }
			return Redirect::to('/getion-solicitud-personal'.'/'.$idOpcion)->with('alertaMensajeGlobal', 'Modificación Exitosa');


		}else{

			$permiso=permisos($idOpcion,'Modificar');

			if($permiso==0){

				return Redirect::back()->with('alertaMensajeGlobalE', 'No tiene autorización para Modificar aquí');

			}else{



				$persolicitud 			= PERSolicitud::where('PER.Solicitud.Id','=',$idSolicitud)->first();

				$motivosolicitud 		= PERMotivoSolicitud::where('Id','<>',$persolicitud->IdMotivoSolicitud)
								          ->where('Activo','=',1)
								          ->lists('Nombre', 'Id');
				$selectmotivosolicitud  = PERMotivoSolicitud::where('Id','=',$persolicitud->IdMotivoSolicitud)
								          ->first();
				$combomotivosolicitud   = array($selectmotivosolicitud->Id => $selectmotivosolicitud->Nombre) + $motivosolicitud;



				$tipousuario            = PERPuestoTrabajo::where('Activo','=',1)
							  				->lists('Nombre', 'Id');											

				$selecttipousuario  	= PERPuestoTrabajo::where('Id','=',$persolicitud->IdTipoUsuario)
								          ->first();

				$combotipousuario  = array($selecttipousuario->Id => $selecttipousuario->Nombre) + $tipousuario;


		        return View::make('personal/modificarsolicitudpersonal', 
		        				[
		        					'idOpcion' 		 		=> $idOpcion,
		        					'persolicitud' 		 	=> $persolicitud,
		        					'combomotivosolicitud' 	=> $combomotivosolicitud,
		        					'combotipousuario' 		=> $combotipousuario,
		        				]);
		
			}

		}
	}












}

	function permisos($idOpcion,$accion){

		$deco = new GeneralClass();
    	$id = $deco->getDecodificar($idOpcion);

		$listaMenu = Session::get('listaMenu');
		$result = 0;

		for( $i = 0 ; $i < count($listaMenu) ; $i ++){
			if($listaMenu[$i]->IdOpcion == $id && $listaMenu[$i]->$accion == 1){
				$result = 1;
			}
		}
		return $result;

	}
?>