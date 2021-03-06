
<div class="ui-btn ui-corner-all ui-shadow ui-btn-n totalPagarbtn">
    Total a pagar <?php echo Yii::app()->numberFormatter->format(Yii::app()->params->formatoMoneda['patron'], Yii::app()->shoppingCart->getTotalCost(), Yii::app()->params->formatoMoneda['moneda']) ?>
</div>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form-pago-pago',
    'enableClientValidation' => true,
    'action' => Yii::app()->createUrl('/carro/pagar', array('paso' => $modelPago->getScenario(), 'post' => 'true')),
    'htmlOptions' => array(
        'class' => "", 'data-ajax' => "false"
    ),
    'errorMessageCssClass' => 'has-error',
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'errorCssClass' => 'has-error',
        'successCssClass' => 'has-success',
    ))
);
?>
<fieldset>
    <div class="ui-field-container ui-bar ui-bar-a contentPaso3 ui-corner-all">
        <h2>Forma de pago</h2>
        <?php $this->renderPartial('/carro/_formaPago', array('form' => $form, 'model' => $modelPago, 'listFormaPago'=>$listFormaPago)) ?>
    </div>
    <div class="space-2"></div>

    <?php if ($modelPago->bono !== null): ?>
        <div class="ui-field-container contentPaso3 ui-bar ui-bar-a ui-corner-all">
            <?php echo $form->labelEx($modelPago, 'usoBono', array()); ?>

            <div>
                <div>Nombre o tipo de bono: Bono Cliente Fiel</div>
                <div>Valor del bono: <?php echo Yii::app()->numberFormatter->format(Yii::app()->params->formatoMoneda['patron'], $modelPago->bono['valor'], Yii::app()->params->formatoMoneda['moneda']); ?></div>
                <div>Vigencia inicial del bono: <?php echo $modelPago->bono['vigenciaInicio'] ?></div>
                <div>Vigencia final del bono: <?php echo $modelPago->bono['vigenciaFin'] ?></div>
                <div class="utilBono">¿Desea utilizar este bono?</div>
                <?php //echo $form->radioButton($modelPago, 'usoBono', array('value' => '1', 'data-role' => 'none')) . 'Si'; ?>
                <?php //echo $form->radioButton($modelPago, 'usoBono', array('value' => '0', 'data-role' => 'none')) . 'No'; ?>
                <input type="radio" data-role="none" id="FormaPagoForm_usoBono_1" name="FormaPagoForm[usoBono]" value="1" <?php echo ($modelPago->usoBono == 1 ? "checked" : "") ?>> Si
                <input type="radio" data-role="none" id="FormaPagoForm_usoBono_0" name="FormaPagoForm[usoBono]" value="0" <?php echo ($modelPago->usoBono != 1 ? "checked" : "") ?>> No

                <?php echo $form->error($modelPago, 'usoBono'); ?>
            </div>

        </div>
    <?php endif; ?>

</fieldset>

<?php if (isset($submit) && $submit): ?>
    <div class="ui-input-btn ui-btn ui-corner-all ui-shadow ui-btn-r">
        Continuar
        <input type="button" data-enhanced="true" value="Continuar" id="btn-carropagar-siguiente" data-origin="pago" data-redirect="confirmacion">
    </div>
<?php endif; ?>
<?php $this->endWidget(); ?>
