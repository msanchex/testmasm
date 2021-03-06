<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $isMobile = true;
    public $showSeeker = true;
    public $showHeaderIcons = true;
    public $logoLinkMenu = true;
    public $fixedFooter = true;
    public $extraContentList = array();
    public $extraPageList = array();
    public $sectorName = "";
    public $categorias = array();
    public $objSectorCiudad = null;

    public function init() {
        if (Yii::app()->detectMobileBrowser->showMobile) {
            $this->isMobile = true;
            $this->layout = '//layouts/mobile';
        } else {
            $this->isMobile = false;
            $this->layout = '//layouts/desktop';
        }

        //$this->isMobile = true;
        //$this->layout = '//layouts/mobile';
        $this->verificarDispositivo();

        if (isset(Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']]) && Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']] != null) {
            $this->objSectorCiudad = Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']];
        }

        $this->pageTitle = Yii::app()->name;
        $this->getSectorName();
        $this->registerJs();
        $this->registerCss();

        if (!$this->isMobile) {
            $this->getCategorias();
        }
    }

    public function verificarDispositivo() {
        //Get HTTP/HTTPS (the possible values for this vary from server to server)
        $urlProtocolo = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && !in_array(strtolower($_SERVER['HTTPS']), array('off', 'no'))) ? 'https' : 'http';

        //Get domain portion
        $urlHost = '://' . $_SERVER['HTTP_HOST'];

        //Get path to script
        $urlRequest = $_SERVER['REQUEST_URI'];
        
        $urlFull = $urlProtocolo . $urlHost . $urlRequest;
        $urlMovil = "://m.larebajavirtual.com";
        $urlDesktop = "://larebajavirtual.com";

        //si el host es movil y el dispositivo es escritorio => cambiar host por escritorio
        if (!$this->isMobile && strpos($urlHost, $urlMovil) !== FALSE) {
            $urlFull = str_replace($urlMovil, $urlDesktop, $urlFull);
            header("Location: $urlFull");
        }

        //si el host es escritorio y el dispositivo es movil => cambiar host por movil
        if ($this->isMobile && strpos($urlHost, $urlDesktop) !== FALSE) {
            $urlFull = str_replace($urlDesktop, $urlMovil, $urlFull);
            header("Location: $urlFull");
        }
    }

    public function getSectorName() {
        if (isset(Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']]) && Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']] != null) {
            $objSectorCiudad = Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']];
            $objSubSector = Yii::app()->session[Yii::app()->params->sesion['subSectorCiudadEntrega']];
            $this->sectorName = $objSectorCiudad->objCiudad->nombreCiudad;
            if ($objSubSector != null)
                $this->sectorName .= " - " . $objSubSector->nombreSubSector;
            else if ($objSectorCiudad->objSector->codigoSector != 0)
                $this->sectorName .= " - " . $objSectorCiudad->objSector->nombreSector;
        }else {
            $this->sectorName = "Seleccionar ubicación";
        }
    }

    public function registerJs() {
        if ($this->isMobile) {
            /* $cs = Yii::app()->clientScript;
              $cs->scriptMap = array(
              'jquery.js' => false,
              'jquery.ui.js' => false,
              );

              Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/jquery/jquery-1.10.0.min.js", CClientScript::POS_HEAD);
              Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/jquerymobile/js/jquery.mobile-1.4.5.min.js", CClientScript::POS_HEAD);
              Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/jquery/jquery.validate.min.js", CClientScript::POS_HEAD); */
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/jquerymobile/js/jquery.mobile-1.4.5.min.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/raty/jquery.raty.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/owl-carousel/owl.carousel.min.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/jquerymobile-windows/jqm-windows.mdialog.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/common.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/mobile.js", CClientScript::POS_HEAD);
        } else {
            //    Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/jquery/jquery-1.10.0.min.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/bootstrap/js/bootstrap.min.js", CClientScript::POS_HEAD);
            //  Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/jquery-ui/jquery-ui.min.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/owl-carousel/owl.carousel.min.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/select2/select2.min.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/bootstrap/js/dropdown.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/bootstrap/js/bootstrap-slider.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/raty/jquery.raty.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/libs/ad-gallery/jquery.ad-gallery.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/libs/bootbox.min.js', CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/libs/raphael/raphael-min.js', CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/common.js", CClientScript::POS_HEAD);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/desktop.js", CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/desktop-om.js", CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/desktop-ms.js", CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/desktop-jj.js", CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/isotope.pkgd.js", CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/masonry-horizontal.js", CClientScript::POS_END);
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/libs/loading/js/Loading.js', CClientScript::POS_END);
            /*     Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . "/js/npm.js", CClientScript::POS_END); */
        }
    }

//custom application css
    public function registerCss() {
        if ($this->isMobile) {
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/jquerymobile/css/themes/default/jquery.mobile-1.4.5.min.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/raty/jquery.raty.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/owl-carousel/owl.carousel.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/owl-carousel/owl.theme.css");
            //Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/css/mobile.css");
        } else {
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/bootstrap/css/bootstrap.min.css");
            //Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/bootstrap/css/bootstrap-responsive.min.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/jquery-ui/jquery-ui.min.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/select2/select2.min.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/bootstrap/css/dropdown.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/bootstrap/css/bootstrap-slider.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/owl-carousel/owl.carousel.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/owl-carousel/owl.theme.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/raty/jquery.raty.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/libs/ad-gallery/jquery.ad-gallery.css");
            //Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . "/css/main-desktop.css");
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/libs/loading/css/Loading.css');
        }
    }

    public function getCategorias() {
        $categorias = CategoriaTienda::model()->findAll(array(
            'order' => 't.orden',
            'condition' => 't.tipoDispositivo=:dispositivo AND t.visible=:visible AND t.idCategoriaPadre IS NULL ',
            'params' => array(
                ':visible' => 1,
                ':dispositivo' => CategoriaTienda::DISPOSITIVO_ESCRITORIO
            ),
            'with' => array('listCategoriasHijas' => array(
                    'with' => 'listModulosConfigurados'
                )),
        ));
        $this->categorias = $categorias;
    }

}
