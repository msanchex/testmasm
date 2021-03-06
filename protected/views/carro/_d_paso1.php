<?php if ($modelPago->pagoInvitado): ?>
    <h3 class="text-center title-desp"><span class="glyphicon glyphicon-map-marker"></span>Direcci&oacute;n de despacho</h3>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableClientValidation' => true,
        //'action' => ($model->isNewRecord ? Yii::app()->createUrl('/usuario/direccionCrear') : Yii::app()->createUrl('/usuario/direccionActualizar', array('id' => $model->idDireccionDespacho))),
        'id' => "form-direccion-pagoinvitado",
        'htmlOptions' => array(
            'class' => 'form-horizontal'
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

    <div class="row">


        <div class="form-group">
            <?php echo $form->labelEx($modelPago, 'descripcion', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
                <?php echo $form->textField($modelPago, 'descripcion', array('class' => 'form-control input-sm', 'maxlength' => 50, 'placeholder' => $modelPago->getAttributeLabel('descripcion'))); ?>
                <?php echo $form->error($modelPago, 'descripcion', array('class' => 'text-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($modelPago, 'nombre', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
                <?php echo $form->textField($modelPago, 'nombre', array('class' => 'form-control input-sm', 'maxlength' => 50, 'placeholder' => $modelPago->getAttributeLabel('nombre'))); ?>
                <?php echo $form->error($modelPago, 'nombre', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($modelPago, 'correoElectronico', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
                <?php echo $form->emailField($modelPago, 'correoElectronico', array('class' => 'form-control input-sm', 'maxlength' => 50, 'placeholder' => $modelPago->getAttributeLabel('correoElectronico'))); ?>
                <?php echo $form->error($modelPago, 'correoElectronico', array('class' => 'text-danger')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($modelPago, 'direccion', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
                <?php echo $form->textField($modelPago, 'direccion', array('class' => 'form-control input-sm', 'maxlength' => 100, 'placeholder' => $modelPago->getAttributeLabel('direccion'))); ?>
                <?php echo $form->error($modelPago, 'direccion', array('class' => 'text-danger')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($modelPago, 'barrio', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
                <?php echo $form->textField($modelPago, 'barrio', array('class' => 'form-control input-sm', 'maxlength' => 50, 'placeholder' => $modelPago->getAttributeLabel('barrio'))); ?>
                <?php echo $form->error($modelPago, 'barrio', array('class' => 'text-danger')); ?>
            </div>
        </div>
        
        <div class="form-group">
            <?php echo $form->labelEx($modelPago, 'telefono', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
                <?php echo $form->textField($modelPago, 'telefono', array('class' => 'form-control input-sm', 'maxlength' => 11, 'placeholder' => $modelPago->getAttributeLabel('telefono'))); ?>
                <?php echo $form->error($modelPago, 'telefono', array('class' => 'text-danger')); ?>
            </div>
        </div>
        
        <div class="form-group">
            <?php echo $form->labelEx($modelPago, 'extension', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
                <?php echo $form->textField($modelPago, 'extension', array('class' => 'form-control input-sm', 'maxlength' => 5, 'placeholder' => $modelPago->getAttributeLabel('extension'))); ?>
                <?php echo $form->error($modelPago, 'extension', array('class' => 'text-danger')); ?>
            </div>
        </div>
        
        <div class="form-group">
            <?php echo $form->labelEx($modelPago, 'celular', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8">
                <?php echo $form->textField($modelPago, 'celular', array('class' => 'form-control input-sm', 'maxlength' => 20, 'placeholder' => $modelPago->getAttributeLabel('celular'))); ?>
                <?php echo $form->error($modelPago, 'celular', array('class' => 'text-danger')); ?>
            </div>
        </div>
    </div>

    <?php $this->endWidget(); ?>
<?php else: ?>
    <h3 class="text-center title-desp"><span class="glyphicon glyphicon-map-marker"></span>Direcci&oacute;nes de despacho</h3>
    <div class="row">
        <div class="col-md-4">
            <?php echo CHtml::link('Adicionar direcci&oacute;n', "#", array('data-role' => 'direccion-adicionar-modal', 'data-vista' => 'pasoscompra', 'class' => 'btn btn-primary adicionar')); ?>
        </div>
    </div>

    <div id="div-direcciones-pasoscompra" class="row">
        <?php $this->renderPartial('/usuario/_d_direccionesLista', array('listDirecciones' => $listDirecciones, 'radio' => true, 'idDireccionSeleccionada' => $modelPago->idDireccionDespacho)) ?>
    </div>

    <div id="FormaPagoForm_idDireccionDespacho_em_" class="text-danger" style="display: none;"></div>

    <div class="row">
        <div class="col-md-4">
            <?php echo CHtml::link('Adicionar direcci&oacute;n', "#", array('data-role' => 'direccion-adicionar-modal', 'data-vista' => 'pasoscompra', 'class' => 'btn btn-primary adicionar')); ?>
        </div>
    </div>
<?php endif; ?>