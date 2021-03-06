<div id="owl-productodetalle-inicio" class="owl-carousel owl-theme owl-productodetalle">
    <?php foreach ($listModulos as $objModulo): ?>
        <?php foreach ($objModulo->listImagenesBanners as $objImagen): ?>
            <div class="item"><a href="#" ><img src="<?php echo Yii::app()->request->baseUrl . $objImagen->rutaImagen; ?>" alt="<?php echo $objImagen->nombre ?>"></a></div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<div class="ui-content c_cont_slc_ntg">
    <div class="ui-bar ui-bar-c ui-corner-all center ccont_index">
        <a href="<?php echo CController::createUrl('/sitio/entrega', array('tipo' => Yii::app()->params->entrega['tipo']['presencial'])) ?>" data-ajax="false" class="ui-btn ui-btn-inline ui-corner-all ui-shadow c_btn_img">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/entrega/icon_recoger.png" alt="Pasa por el pedido" onmouseover="this.src = '<?php echo Yii::app()->request->baseUrl; ?>/images/entrega/icon_recoger_hover.png'" onmouseout="this.src = '<?php echo Yii::app()->request->baseUrl; ?>/images/entrega/icon_recoger.png'" class="c_ndx_img">
        </a>
        <div class="ctxt_pedido bg_red">
            <h2><a href="<?php echo CController::createUrl('/sitio/entrega', array('tipo' => Yii::app()->params->entrega['tipo']['presencial'])) ?>" data-ajax="false">Quiero pasar por<br> el pedido</a></h2>
            <p><a href="#panel-info-presencial">Conocer más [+]</a></p>
        </div>
    </div>
    <!-- <div class="cdt_line_spc"><span></span></div> -->
    <!-- <div class="c_espacio"></div> -->
    <div class="space-1"></div>
    <div class="ui-bar ui-bar-c ui-corner-all center ccont_index">
        <a href="<?php echo CController::createUrl('/sitio/entrega', array('tipo' => Yii::app()->params->entrega['tipo']['domicilio'])) ?>" data-ajax="false" class="ui-btn ui-btn-inline ui-corner-all ui-shadow c_btn_img"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/entrega/icon_domicilio.png" alt="Domicilio" onmouseover="this.src = '<?php echo Yii::app()->request->baseUrl; ?>/images/entrega/icon_domicilio_hover.png'" onmouseout="this.src = '<?php echo Yii::app()->request->baseUrl; ?>/images/entrega/icon_domicilio.png'" class="c_ndx_img"></a>
        <div class="ctxt_pedido bg_yellow">
            <h2><a href="<?php echo CController::createUrl('/sitio/entrega', array('tipo' => Yii::app()->params->entrega['tipo']['domicilio'])) ?>" data-ajax="false">Quiero que me lo<br> entreguen a domicilio</a></h2>
            <p><a href="#panel-info-domicilio">Conocer más [+]</a></p>
        </div>
    </div>
</div>

<?php $this->renderPartial('/contenido/modulo', array('objModulo'=>ModulosConfigurados::getModuloFlotante($this->objSectorCiudad, Yii::app()->shoppingCart->getCodigoPerfil(), UbicacionModulos::UBICACION_MOVIL_HOME))) ?>

<?php $this->extraContentList[] = $this->renderPartial('_entregaDomicilio', null, true); ?>
<?php $this->extraContentList[] = $this->renderPartial('_entregaPresencial', null, true); ?>
