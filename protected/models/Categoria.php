<?php

/**
 * This is the model class for table "m_Categoria".
 *
 * The followings are the available columns in table 'm_Categoria':
 * @property integer $idCategoriaBI
 * @property integer $idCategoria
 * @property string $nombreCategoria
 * @property integer $nivel
 * @property integer $padre
 */
class Categoria extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'm_Categoria';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idCategoriaBI, idCategoria, nombreCategoria, nivel, padre', 'required'),
            array('idCategoriaBI, idCategoria, nivel, padre', 'numerical', 'integerOnly' => true),
            array('nombreCategoria', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idCategoriaBI, idCategoria, nombreCategoria, nivel, padre', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'listCategoriasTienda' => array(self::MANY_MANY, 'CategoriaTienda', 'm_CategoriasCategoriaTienda(idCategoriaTienda, idCategoriaBI)'),
            'listCategoriasTiendaCategoria' => array(self::BELONGS_TO, 'CategoriasCategoriaTienda', '', 
                        'on' => 'listCategoriasHijasHijas.idCategoriaBI = listCategoriasTiendaCategoria.idCategoriaBI AND listCategoriasTiendaCategoria.idCategoriaTienda =:idcategoriatienda '),
            'listCategoriasHijas' => array(self::HAS_MANY, 'Categoria', 'padre'),
            'listCategoriasHijasHijas' => array(self::HAS_MANY, 'Categoria', 'padre'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'idCategoriaBI' => 'Id Categoria Bi',
            'idCategoria' => 'Id Categoria',
            'nombreCategoria' => 'Nombre Categoria',
            'nivel' => 'Nivel',
            'padre' => 'Padre',
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

        $criteria->compare('idCategoriaBI', $this->idCategoriaBI);
        $criteria->compare('idCategoria', $this->idCategoria);
        $criteria->compare('nombreCategoria', $this->nombreCategoria, true);
        $criteria->compare('nivel', $this->nivel);
        $criteria->compare('padre', $this->padre);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Categoria the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
