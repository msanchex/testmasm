<?php

/**
 * This is the model class for table "m_Operador".
 *
 * The followings are the available columns in table 'm_Operador':
 * @property integer $idOperador
 * @property string $nombre
 * @property string $usuario
 * @property string $clave
 * @property integer $perfil
 * @property string $email
 * @property integer $activo
 */
class Operador extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'm_Operador';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre, usuario, clave, perfil, activo', 'required', 'message'=>'{attribute} no puede estar vacío'),
            array('perfil, activo', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'min'=>5, 'max' => 20),
            array('usuario, clave', 'length', 'min'=>5, 'max' => 15),
            array('email', 'email'),
            array('email', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idOperador, nombre, usuario, clave, perfil, email, activo', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'idOperador' => 'Id Operador',
            'nombre' => 'Nombre',
            'usuario' => 'Usuario',
            'clave' => 'Clave',
            'perfil' => 'Perfil',
            'email' => 'Email',
            'activo' => 'Activo',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('idOperador', $this->idOperador);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('usuario', $this->usuario, true);
        $criteria->compare('clave', $this->clave, true);
        $criteria->compare('perfil', $this->perfil);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('activo', $this->activo);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Operador the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * @param string $password password para validar
     * return boolean Valida si parametro $password corresponde a la clave del usuario
     */
    public function validarContrasena($contrasena) {
        return $this->hash($contrasena) === $this->clave;
    }

    public function hash($contrasena) {
        return $contrasena;
        //return md5($contrasena);
    }
    
    public static function listData(){
        return self::model()->findAll(array('condition'=>'activo=:activo','params'=>array(':activo'=>1)));
    }

}
