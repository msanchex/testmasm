<div class="clst_cont_top">
   <div class="clst_pro_img">
        <a href="<?php echo CController::createUrl('/catalogo/combo', array('combo' => $position->objCombo->idCombo, 'descripcion' => $position->objCombo->getCadenaUrl())) ?>" data-ajax="false">
            <img src="<?php echo Yii::app()->request->baseUrl . $position->objCombo->rutaImagen(); ?>" class="ui-li-thumb">
        </a>
    </div>
    
    <div class="clst_cont_pr_prod">
        <h2><a href="<?php echo CController::createUrl('/catalogo/combo', array('combo' => $position->objCombo->idCombo, 'descripcion' => $position->objCombo->getCadenaUrl())) ?>" data-ajax="false"><?php echo $position->objCombo->descripcionCombo ?></a></h2>
        <div class="clst_pre_act"><?php echo Yii::app()->numberFormatter->format(Yii::app()->params->formatoMoneda['patron'], $position->getPrice(), Yii::app()->params->formatoMoneda['moneda']); ?> </div>

        <?php if ($position->getShipping() > 0): ?>
            <div class="clst_pre_act"><span>[Flete <?php echo Yii::app()->numberFormatter->format(Yii::app()->params->formatoMoneda['patron'], $position->getShipping(), Yii::app()->params->formatoMoneda['moneda']); ?>]</span></div>
        <?php endif; ?>

        <?php if (Yii::app()->shoppingCart->getObjCiudad()->excentoImpuestos == 0 && $position->getTax() > 0): ?>
            <div class="clst_pre_act"><span>Incluye <?php echo Yii::app()->numberFormatter->formatPercentage($position->getTax()) ?> de impuestos [<?php echo Yii::app()->numberFormatter->format(Yii::app()->params->formatoMoneda['patron'], $position->getTaxPrice(), Yii::app()->params->formatoMoneda['moneda']); ?>]</span></div>
        <?php endif; ?>

        <?php if ($position->getDelivery() > 0): ?>
            <div class="clst_pre_act"><span>Tiempo de entrega: <?php echo $position->getDelivery() ?> hora(s)</span></div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>
</div>

<table class="ui-responsive ctable_list_prod"  cellspacing="0">
    <tbody>
        <tr>
            <td class="ctd_01">
                <input type="number" placeholder="0" id="cantidad-producto-<?php echo $position->getId() ?>" data-modificar="2" data-position="<?php echo $position->getId(); ?>" data-mini="true" value="<?php echo $position->getQuantity() ?>" class="cbtn_cant" >
            </td>
            <td class="ctd_02">
                <p>Subtotal</p>
                <p id="subtotal-producto-<?php echo $position->getId(); ?>" style="font-size:medium;"><?php echo Yii::app()->numberFormatter->format(Yii::app()->params->formatoMoneda['patron'], $position->getSumPrice(), Yii::app()->params->formatoMoneda['moneda']); ?></p>
            </td>
            <td class="ctd_03">
                <?php //echo CHtml::link('Guardar en lista personal', '#', array('class' => 'ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-n', 'data-mini' => 'true')); ?>
                <?php echo CHtml::link('Eliminar', '#', array('data-eliminar' => 1, 'data-position' => $position->getId(), 'class' => 'ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-a', 'data-mini' => 'true')); ?>
            </td>
        </tr>
    </tbody>
</table>