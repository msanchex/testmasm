<?php

/**
 * This is the model class for table "t_ProductosSaldosCedi".
 *
 * The followings are the available columns in table 't_ProductosSaldosCedi':
 * @property integer $idProductosSaldosCedi
 * @property string $codigoProducto
 * @property integer $codigoCedi
 * @property integer $saldoUnidad
 *
 * The followings are the available model relations:
 * @property Producto $objProducto
 */
class ProductosSaldosCedi extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_ProductosSaldosCedi';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('codigoProducto, codigoCedi', 'required'),
            array('codigoCedi, saldoUnidad', 'numerical', 'integerOnly' => true),
            array('codigoProducto', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idProductosSaldosCedi, codigoProducto, codigoCedi, saldoUnidad', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'objProducto' => array(self::BELONGS_TO, 'Producto', 'codigoProducto'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'idProductosSaldosCedi' => 'Id Productos Saldos Cedi',
            'codigoProducto' => 'Codigo Producto',
            'codigoCedi' => 'Codigo Cedi',
            'saldoUnidad' => 'Saldo Unidad',
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

        $criteria->compare('idProductosSaldosCedi', $this->idProductosSaldosCedi);
        $criteria->compare('codigoProducto', $this->codigoProducto, true);
        $criteria->compare('codigoCedi', $this->codigoCedi);
        $criteria->compare('saldoUnidad', $this->saldoUnidad);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductosSaldosCedi the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
