<?php $mensajes = Yii::app()->user->getFlashes(); ?>
<?php if ($mensajes): ?>
    <ul class="messages">
        <?php foreach ($mensajes as $idx => $mensaje): ?>
            <li><div class="<?php echo $idx ?>-msg"><?php echo $mensaje ?></div></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<br/>
<div class="">
    <br/>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'id' => "form-recordar", 'class' => "", 'data-ajax'=>"false"
        ),
        'errorMessageCssClass' => 'has-error',
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => true,
            'errorCssClass' => 'has-error',
            'successCssClass' => 'has-success',
        ))
    ); ?>
        <div class="row">
                <div class="col-md-4">
                    <?php echo $form->labelEx($model, 'correoElectronico', array('class' => '')); ?>
                    <?php echo $form->textField($model, 'correoElectronico', array('placeholder' => $model->getAttributeLabel('correoElectronico'),'class'=>'form-control')); ?>
                    <?php echo $form->error($model, 'correoElectronico',array( "class" => "text-danger")); ?>
                </div>
        </div>
    <div class='space-1'></div>
    <?php /* echo CHtml::submitButton('Recordar', array('class' => 'c_bt_sendrc')); */ ?>
    <div class="row">
         <div class="col-md-4">
               <input type="button" data-enhanced="true" data-registro-desktop="recordar" class='btn btn-primary' value="Recordar">
         </div>
    </div>
    <?php $this->endWidget(); ?>
</div>