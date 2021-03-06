<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecordarForm
 *
 * @author miguel.sanchez
 */
class RecordarForm extends CFormModel {

    public $correoElectronico;
    public $usuario;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('correoElectronico', 'required', 'message' => '{attribute} no puede estar vacío'),
            array('correoElectronico', 'email'),
            array('usuario', 'safe'),
            array('correoElectronico', 'validarCorreo'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'correoElectronico' => 'Correo electrónico',
        );
    }

    /**
     * Valida existencia de usuario con correo ingresado
     */
    public function validarCorreo($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->usuario = Usuario::model()->find(array(
                'with'=> 'objUsuarioExtendida',
                'condition' => 'correoElectronico=:correo',
                'params' => array(':correo' => $this->correoElectronico)
            ));

            if ($this->usuario === null) {
                $this->addError('correoElectronico', $this->getAttributeLabel($attribute) . ' no registrado');
            }
        }
    }

}
