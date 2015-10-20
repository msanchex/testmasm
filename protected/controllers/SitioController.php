<?php

class SitioController extends Controller {
    
    /**
     * @return array action filters
     * */
    public function filters() {
        return array(
            array(
                'application.filters.SessionControlFilter + inicio, categorias',
                'isMobile' => $this->isMobile
            ),
        );
    }

    public function actionIndex() {
        $this->showSeeker = false;
        $this->logoLinkMenu = false;
        
        $objSectorCiudad = null;
        $tipoEntrega = null;
        if (isset(Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']])){
            $objSectorCiudad = Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']];
        }
        
        if (isset(Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']]) && Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']] != null ) {
            $tipoEntrega = Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']];
        }
        
        if($objSectorCiudad==null || $tipoEntrega==null){
            $this->showHeaderIcons = false;
        }
        
        if($this->isMobile){
            $this->render('index');
        }else{
            
        /*    
        $listProductos = array();
        $listCombos = array();

            if ($objSectorCiudad == null) {
                $listProductos = Producto::model()->findAll(array(
                    'with' => array('listImagenes', 'objCodigoEspecial', 'listCalificaciones', 'objCategoriaBI'),
                    'condition' => "t.activo=:activo AND t.codigoProducto IN ($codigosStr)",
                    'params' => array(
                        ':activo' => 1,
                    )
                ));
            } else {
                $listProductos = Producto::model()->findAll(array(
                    'with' => array('listImagenes', 'objCodigoEspecial', 'listCalificaciones', 'objCategoriaBI',
                        'listSaldos' => array('condition' => '(listSaldos.saldoUnidad>:saldo AND listSaldos.codigoCiudad=:ciudad AND listSaldos.codigoSector=:sector) OR (listSaldos.saldoUnidad IS NULL AND listSaldos.codigoCiudad IS NULL AND listSaldos.codigoSector IS NULL)'),
                        'listPrecios' => array('condition' => '(listPrecios.codigoCiudad=:ciudad AND listPrecios.codigoSector=:sector) OR (listPrecios.codigoCiudad IS NULL AND listPrecios.codigoSector IS NULL)'),
                        'listSaldosTerceros' => array('condition' => '(listSaldosTerceros.codigoCiudad=:ciudad AND listSaldosTerceros.codigoSector=:sector) OR (listSaldosTerceros.codigoCiudad IS NULL AND listSaldosTerceros.codigoSector IS NULL)')
                    ),
                    'condition' => "t.activo=:activo AND t.codigoProducto IN ($codigosStr) AND ( (listSaldos.saldoUnidad IS NOT NULL AND listPrecios.codigoCiudad IS NOT NULL) OR listSaldosTerceros.codigoCiudad IS NOT NULL)",
                    'params' => array(
                        ':activo' => 1,
                        ':saldo' => 0,
                        ':ciudad' => $objSectorCiudad->codigoCiudad,
                        ':sector' => $objSectorCiudad->codigoSector,
                    )
                ));
            }
        

            $listCodigoEspecial = CodigoEspecial::model()->findAll(array(
                'condition' => 'codigoEspecial<>0'
            ));

            $formFiltro = new FiltroForm;

            $msgCodigoEspecial = array();
            foreach ($listProductos as $objProducto) {
                if ($objProducto->codigoEspecial != null && $objProducto->codigoEspecial != 0) {
                    $msgCodigoEspecial[$objProducto->codigoEspecial] = $objProducto->objCodigoEspecial;
                }

                foreach ($objProducto->objCategoriaBI->listCategoriasTienda as $objCategoriaTienda) {
                    $formFiltro->listCategoriasTienda[$objCategoriaTienda->idCategoriaTienda] = $objCategoriaTienda;
                }
            }

            $imagenBusqueda = null;
            if (empty($listProductos)) {
                $imagenBusqueda = Yii::app()->params->busqueda['imagen']['noExito'];

                if ($objSectorCiudad != null) {
                    try {
                        $busqueda = new Busquedas;

                        if (!Yii::app()->user->isGuest)
                            $busqueda->identificacionUsuario = Yii::app()->user->name;

                        $busqueda->tipoBusqueda = Yii::app()->params->busqueda['tipo']['buscador'];
                        $busqueda->busqueda = $term;
                        $busqueda->fecha = new CDbExpression('NOW()');
                        $busqueda->codigoCiudad = $objSectorCiudad->codigoCiudad;
                        $busqueda->codigoSector = $objSectorCiudad->codigoSector;
                        $busqueda->save();
                    } catch (Exception $exc) {
                        Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
                    }
                }
            }

            $codigoPerfil = Yii::app()->params->perfil['defecto'];

            if (!Yii::app()->user->isGuest) {
                $usuario = Yii::app()->session[Yii::app()->params->usuario['sesion']];
                $codigoPerfil = $usuario->objPerfil->codigoPerfil;
            }
       
           // $rawData=Yii::app()->db->createCommand('SELECT * FROM tbl_user')->queryAll();
            // or using: $rawData=User::model()->findAll(); <--this better represents your question
                $dataProvider=new CArrayDataProvider($listProductos, array(
                    'id'=>'codigoProducto',
                    'sort'=>array(
                        'attributes'=>array(
                             'descripcionProducto'
                        ),
                    ),
                    'pagination'=>array(
                        'pageSize'=>10,
                    ),
                ));

                $_SESSION['objSectorCiudad']=$objSectorCiudad;
                $_SESSION['codigoPerfil']=$codigoPerfil;
 */           
                $this->render('d_index');
        }
        Yii::app()->end();
    }

    public function actionEntrega($tipo = null) {
        
        if ($tipo != Yii::app()->params->entrega['tipo']['presencial'] && $tipo != Yii::app()->params->entrega['tipo']['domicilio']) {
            $this->actionIndex();
        }

        Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']] = $tipo;
        Yii::app()->session[Yii::app()->params->sesion['carroPagarForm']] = null;
        
        if($this->isMobile){
            $this->redirect($this->createUrl('/sitio/ubicacion/'));
        }else{
            echo CJSON::encode(array(
               'result' => 'ok',
                'response' => 'SE HA SELECCIONADO EL TIPO DE ENTREGA '.Yii::app()->params->entrega['tipo'][$tipo]
            )); 
            Yii::app()->end();
        }
    }
    
    public function actionUbicacion() {
        $this->showSeeker = false;
        $this->logoLinkMenu = false;
        $this->fixedFooter = true;

       // if (!isset(Yii::app()->session[Yii::app()->params->sesion['redireccionAutenticacion']]) || Yii::app()->session[Yii::app()->params->sesion['redireccionAutenticacion']] == 'null') {
            Yii::app()->session[Yii::app()->params->sesion['redireccionAutenticacion']] = (Yii::app()->request->urlReferrer == null ? 'null' : Yii::app()->request->urlReferrer);
       // }
        if ((!isset(Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']]) || Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']] == null)&& $this->isMobile ) {
            $this->actionIndex();
            //$this->render('index');
            //Yii::app()->end();
        }
        
        $tipo = Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']];
        
        $objSectorCiudad = null;
        if (isset(Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']])){
            $objSectorCiudad = Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']];
        }
        
        if($objSectorCiudad==null){
            $this->showHeaderIcons = false;
        }

        $listCiudadesSectores = Ciudad::model()->findAll(array(
            'with' => array('listSectores'),
            'order' => 't.orden',
            'condition' => 'estadoCiudadSector=:estadoCiudadSector AND estadoSector=:estadoSector AND estadoCiudad=:estadoCiudad',
            'params' => array(
                ':estadoCiudadSector' => 1,
                ':estadoSector' => 1,
                ':estadoCiudad' => 1,
            )
        ));
        
        $listCiudadesSubsectores = Ciudad::model()->findAll(array(
            'with' => array(
                'listSubSectores' => array(
                    'order'=> 'listSubSectores.nombreSubSector',
                    'condition' => 'estadoSubSector=1',
                    'with' => array(
                        'listSectorReferencias' => array(
                            'condition' => 'listSectorReferencias.estadoSectorReferencia=1',
                            'with' => array(
                                'objSectorCiudad' => array(
                                    'condition' => 'objSectorCiudad.estadoCiudadSector=1',
                                    'with' => array(
                                        'objSector' => array(
                                            'condition' => 'objSector.estadoSector=1',
                                            'order' => 'objSector.nombreSector',
                                        ))),
                                'listPuntoReferencias' => array('condition' => 'listPuntoReferencias.estadoReferencia=1', 'order' => 'listPuntoReferencias.nombreReferencia')
                            ))))),
            'order' => 't.nombreCiudad'
        ));

        $idxCiudadesSubSectores = array();
        foreach ($listCiudadesSubsectores as $indice => $ciudad) {
            $idxCiudadesSubSectores[$ciudad->codigoCiudad] = $indice;
        }

        /* Yii::app()->session[Yii::app()->params->sesion['pdvEntrega']] = null;
          Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']] = null;
          Yii::app()->session[Yii::app()->params->sesion['subSectorCiudadEntrega']] = null; */

        if($this->isMobile){
            $this->render('ubicacion', array(
                'listCiudadesSectores' => $listCiudadesSectores,
                'listCiudadesSubsectores' => $listCiudadesSubsectores,
                'idxCiudadesSubSectores' => $idxCiudadesSubSectores,
                'tipoEntrega' => $tipo,
                'objSectorCiudad' => $objSectorCiudad,
            ));
        }else{
            $this->render('d_ubicacion', array(
                'listCiudadesSectores' => $listCiudadesSectores,
                'listCiudadesSubsectores' => $listCiudadesSubsectores,
                'idxCiudadesSubSectores' => $idxCiudadesSubSectores,
                'tipoEntrega' => $tipo,
                'objSectorCiudad' => $objSectorCiudad,
            ));
        }
    }
    
    public function actionUbicacionSeleccion($ciudad, $sector, $subsector = null) {
        $objSectorCiudad = SectorCiudad::model()->find(array(
            'with' => array('objCiudad', 'objSector'),
            'condition' => 't.codigoCiudad=:ciudad AND t.codigoSector=:sector AND t.estadoCiudadSector=:estado',
            'params' => array(
                ':ciudad' => $ciudad,
                ':sector' => $sector,
                ':estado' => 1,
            )
        ));

        if ($objSectorCiudad == null) {
            $this->actionIndex();
        }

        $objSectorCiudadOld = null;

        if (isset(Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']]))
            $objSectorCiudadOld = Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']];

        //$objSubSector = $subsector != null ? SubSector::model()->findByPk(array('codigoCiudad' => $ciudad, 'codigoSubSector' => $sector)) : null;
        $objSubSector = null;

        $objSectorCiudad->objCiudad->getDomicilio();
        Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']] = $objSectorCiudad;
        Yii::app()->session[Yii::app()->params->sesion['subSectorCiudadEntrega']] = $objSubSector;
        
        if ($objSectorCiudadOld != null && ($objSectorCiudadOld->codigoCiudad != $objSectorCiudad->codigoCiudad || $objSectorCiudadOld->codigoSector != $objSectorCiudad->codigoSector)){
            Yii::app()->shoppingCart->clear();
            Yii::app()->session[Yii::app()->params->sesion['carroPagarForm']] = null;
        }
        
        Yii::app()->shoppingCart->CalculateShipping();
        
        $objHorarioSecCiud = HorariosCiudadSector::model()->find(array(
            'condition' => 'codigoCiudad=:ciudad AND codigoSector=:sector',
            'params' => array(
                ':ciudad' => $objSectorCiudad->codigoCiudad,
                ':sector' => $objSectorCiudad->codigoSector,
            )
        ));
        
        if($objHorarioSecCiud!=null && $objHorarioSecCiud->sadCiudadSector==0){
            Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']] = Yii::app()->params->entrega['tipo']['presencial'];
        }
        if(Yii::app()->session[Yii::app()->params->sesion['redireccionAutenticacion']]==null){
                $this->redirect($this->createUrl('/sitio/inicio'));
        }else{
            $this->redirect(Yii::app()->session[Yii::app()->params->sesion['redireccionAutenticacion']]);
        }
    }
    
    public function actionUbicacionVerificacion() {
        if (!Yii::app()->request->isPostRequest) {
            echo CJSON::encode(array('result' => 'error', 'response' => "Solicitud inválida"));
            Yii::app()->end();
        }
         
        $ciudad = Yii::app()->getRequest()->getPost('ciudad');
        $sector = Yii::app()->getRequest()->getPost('sector');
        
        if($ciudad==null || $sector==null){
            echo CJSON::encode(array('result' => 'error', 'response' => "Solicitud inválida"));
            Yii::app()->end();
        }   
            
        $objSectorCiudad = SectorCiudad::model()->find(array(
            'with' => array('objCiudad', 'objSector'),
            'condition' => 't.codigoCiudad=:ciudad AND t.codigoSector=:sector AND t.estadoCiudadSector=:estado',
            'params' => array(
                ':ciudad' => $ciudad,
                ':sector' => $sector,
                ':estado' => 1,
            )
        ));

        if ($objSectorCiudad == null) {
            echo CJSON::encode(array('result' => 'error', 'response' => 'Ubicación no existente'));
            Yii::app()->end();
        }
        
        $mensajeUbicacion = "<strong>" . $objSectorCiudad->objCiudad->nombreCiudad . " - " . $objSectorCiudad->objSector->nombreSector . "</strong>";
                
        if (!isset(Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']]) || Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']] != Yii::app()->params->entrega['tipo']['presencial']) {
            $objHorarioSecCiud = HorariosCiudadSector::model()->find(array(
                'condition' => 'codigoCiudad=:ciudad AND codigoSector=:sector',
                'params' => array(
                    ':ciudad' => $objSectorCiudad->codigoCiudad,
                    ':sector' => $objSectorCiudad->codigoSector,
                )
            ));

            if($objHorarioSecCiud!=null && $objHorarioSecCiud->sadCiudadSector==0){
                $mensajeUbicacion .= "<br/>No contamos con servicio de entrega a domicilio para esta ubicación, los pedidos deben ser recogidos en el Punto de Venta seleccionado por usted al momento de finalizar la compra.";
                echo CJSON::encode(array('result' => 'ok', 'response' => array(
                    'mensaje' => $mensajeUbicacion,
                    'domicilio' => false,
                    'url' => CController::createUrl('/sitio/ubicacionSeleccion', array('ciudad' => $objSectorCiudad->codigoCiudad, 'sector' => $objSectorCiudad->codigoSector))
                )));
                Yii::app()->end();
            }
        }
        
        echo CJSON::encode(array('result' => 'ok', 'response' => array(
            'mensaje' => $mensajeUbicacion,
            'domicilio' => true,
            'url' => CController::createUrl('/sitio/ubicacionSeleccion', array('ciudad' => $objSectorCiudad->codigoCiudad, 'sector' => $objSectorCiudad->codigoSector))
        )));
        Yii::app()->end();
    }

    public function actionGps() {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->session[Yii::app()->params->sesion['pdvEntrega']] = null;
            /* Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']] = null;
              Yii::app()->session[Yii::app()->params->sesion['subSectorCiudadEntrega']] = null; */

            $lat = Yii::app()->getRequest()->getPost('lat');
            $lon = Yii::app()->getRequest()->getPost('lon');

            try {
                $puntosv = PuntoVenta::model()->findAll();
                $pdvCerca = array('pdv' => null, 'dist' => -1);

                foreach ($puntosv as $pdv) {
                    $dist = distanciaCoordenadas($lat, $lon, $pdv->latitudGoogle, $pdv->longitudGoogle);
                    
                    if($dist>Yii::app()->params->gps['distanciaMaxima']){
                        continue;
                    }

                    if ($pdvCerca['pdv'] == null) {
                        $pdvCerca['pdv'] = $pdv;
                        $pdvCerca['dist'] = $dist;
                    } else {
                        if ($dist < $pdvCerca['dist']) {
                            $pdvCerca['pdv'] = $pdv;
                            $pdvCerca['dist'] = $dist;
                        }
                    }
                }

                if ($pdvCerca['pdv'] == null) {
                    echo CJSON::encode(array('result' => 'error', 'response' => 'No se encuentra punto de venta cercano'));
                    Yii::app()->end();
                }

                $objCiudadSector = SectorCiudad::model()->find(array(
                    'with' => array('objCiudad', 'objSector'),
                    'condition' => 't.codigoCiudad=:ciudad AND t.codigoSector=:sector AND t.estadoCiudadSector=:estado',
                    'params' => array(
                        'ciudad' => $pdvCerca['pdv']->codigoCiudad,
                        'sector' => $pdvCerca['pdv']->idSectorLRV,
                        'estado' => 1
                    )
                ));

                if ($objCiudadSector == null) {
                    echo CJSON::encode(array('result' => 'error', 'response' => 'No se encuentra sector cercano'));
                    Yii::app()->end();
                }

                Yii::app()->session[Yii::app()->params->sesion['pdvEntrega']] = $pdvCerca['pdv'];
                //Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']] = $sectorCiudad;
                /* Yii::app()->session[Yii::app()->params->sesion['subSectorCiudadEntrega']] = null; */
                
                $mensajeUbicacion="";
                if($this->isMobile){
                    $mensajeUbicacion = "<strong>" . $objCiudadSector->objCiudad->nombreCiudad . " - " . $objCiudadSector->objSector->nombreSector . "</strong>";

                    if (!isset(Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']]) || Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']] != Yii::app()->params->entrega['tipo']['presencial']) {
                        $objHorarioSecCiud = HorariosCiudadSector::model()->find(array(
                            'condition' => 'codigoCiudad=:ciudad AND codigoSector=:sector',
                            'params' => array(
                                ':ciudad' => $objCiudadSector->codigoCiudad,
                                ':sector' => $objCiudadSector->codigoSector,
                            )
                        ));

                        if($objHorarioSecCiud!=null && $objHorarioSecCiud->sadCiudadSector==0){
                            $mensajeUbicacion .= "<br/>No contamos con servicio de entrega a domicilio para esta ubicación, los pedidos deben ser recogidos en el Punto de Venta seleccionado por usted al momento de finalizar la compra.";
                        }
                    }
                }else{
                    if (!isset(Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']]) || Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']] != Yii::app()->params->entrega['tipo']['presencial']) {
                        $objHorarioSecCiud = HorariosCiudadSector::model()->find(array(
                            'condition' => 'codigoCiudad=:ciudad AND codigoSector=:sector',
                            'params' => array(
                                ':ciudad' => $objCiudadSector->codigoCiudad,
                                ':sector' => $objCiudadSector->codigoSector,
                            )
                        ));
                       $mensajeUbicacion= $this->renderPartial('_mensajeUbicacion',
                               array(
                                       "objCiudadSector"=>$objCiudadSector,
                                       "objHorarioSecCiud"=>$objHorarioSecCiud,
                                       "pdvCerca"=>$pdvCerca
                                
                        ),true);
                    }
                }
                
                
                
                echo CJSON::encode(array(
                    'result' => 'ok',
                    'response' => array(
                        'ubicacion' => $mensajeUbicacion,
                        'url' => CController::createUrl('/sitio/ubicacionSeleccion', array('ciudad' => $pdvCerca['pdv']->codigoCiudad, 'sector' => $pdvCerca['pdv']->idSectorLRV)))
                ));
                Yii::app()->end();
            } catch (Exception $exc) {
                Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
                echo CJSON::encode(array('result' => 'error', 'response' => 'Error: ' . $exc->getMessage()));
                Yii::app()->end();
            }
        } else {
            echo CJSON::encode(array('result' => 'error', 'response' => 'Solicitud invalida.'));
            Yii::app()->end();
        }
    }

    public function actionInicio() {
        $this->render('inicio');
    }

    public function actionCategorias() {
        $this->render('categorias');
    }

    public function actionCargarUbicacion($codigoCiudad=null, $sector=0,$subsector = null){
        if(isset($codigoCiudad)){
            $objSectorCiudad = SectorCiudad::model()->find(array(
            'with' => array('objCiudad', 'objSector'),
            'condition' => 't.codigoCiudad=:ciudad AND t.codigoSector=:sector AND t.estadoCiudadSector=:estado',
            'params' => array(
                ':ciudad' => $codigoCiudad,
                ':sector' => $sector,
                ':estado' => 1,
            )
            ));

            if ($objSectorCiudad == null) {
                $this->actionIndex();
            }
            $objSectorCiudadOld = null;

            if (isset(Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']]))
                $objSectorCiudadOld = Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']];

            $objSubSector = $subsector != null ? SubSector::model()->findByPk(array('codigoCiudad' => $codigoCiudad, 'codigoSubSector' => $sector)) : null;

            $objSectorCiudad->objCiudad->getDomicilio();
            Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']] = $objSectorCiudad;
           
            $_SESSION['codigoCiudad']=$objSectorCiudad->objCiudad->codigoCiudad;
            $_SESSION['nombreCiudad']=$objSectorCiudad->objCiudad->nombreCiudad;
            $urlAnterior="";
            
            if(isset(Yii::app()->session[Yii::app()->params->sesion['redireccionAutenticacion']]) && Yii::app()->session[Yii::app()->params->sesion['redireccionAutenticacion']] != null){
                $urlAnterior=Yii::app()->session[Yii::app()->params->sesion['redireccionAutenticacion']];
            }else{
                $urlAnterior=$this->createUrl('/sitio/index/');
            }
            echo CJSON::encode(array('result' => 'ok', 'response' => 'Se ha cambiado la ciudad de entrega por: '.$objSectorCiudad->objCiudad->nombreCiudad,
                                     'urlAnterior' => $urlAnterior ));
            Yii::app()->end();
        }else{
            echo CJSON::encode(array('result' => 'error', 'response' => 'Solicitud inválida.'));
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = "m_error";
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error');
        }
    }
    
}
