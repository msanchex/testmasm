<?php

/**
 * This is the model class for table "t_ComprasUsuariosCategorias".
 *
 * The followings are the available columns in table 't_ComprasUsuariosCategorias':
 * @property string $idComprasUsuariosCategorias
 * @property string $identificacionUsuario
 * @property integer $idCategoriaBI
 */
class ComprasUsuariosCategorias extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_ComprasUsuariosCategorias';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('identificacionUsuario, idCategoriaBI', 'required'),
            array('idCategoriaBI', 'numerical', 'integerOnly' => true),
            array('identificacionUsuario', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idComprasUsuariosCategorias, identificacionUsuario, idCategoriaBI', 'safe', 'on' => 'search'),
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
            'idComprasUsuariosCategorias' => 'Id Compras Usuarios Categorias',
            'identificacionUsuario' => 'Identificacion Usuario',
            'idCategoriaBI' => 'Id Categoria Bi',
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

        $criteria->compare('idComprasUsuariosCategorias', $this->idComprasUsuariosCategorias, true);
        $criteria->compare('identificacionUsuario', $this->identificacionUsuario, true);
        $criteria->compare('idCategoriaBI', $this->idCategoriaBI);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ComprasUsuariosCategorias the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
