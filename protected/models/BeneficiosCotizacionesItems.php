<?php

/**
 * This is the model class for table "t_BeneficiosCotizacionesItems".
 *
 * The followings are the available columns in table 't_BeneficiosCotizacionesItems':
 * @property string $idBeneficioCotizacionItem
 * @property string $idBeneficio
 * @property integer $idBeneficioSincronizado
 * @property string $idCotizacionItem
 * @property integer $tipo
 * @property string $fechaIni
 * @property string $fechaFin
 * @property integer $dsctoUnid
 * @property integer $dsctoFrac
 * @property integer $vtaUnid
 * @property integer $vtaFrac
 * @property integer $pagoUnid
 * @property integer $pagoFrac
 * @property integer $cuentaCop
 * @property integer $nitCop
 * @property integer $porcCop
 * @property integer $cuentaProv
 * @property string $nitProv
 * @property integer $porcProv
 * @property integer $promoFiel
 * @property string $mensaje
 * @property integer $swobligaCli
 * @property string $fechaCreacionBeneficio
 *
 * The followings are the available model relations:
 * @property MBeneficioTipo $tipo0
 * @property TCotizacionesItems $idCotizacionItem0
 */
class BeneficiosCotizacionesItems extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 't_BeneficiosCotizacionesItems';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('idBeneficio, idBeneficioSincronizado, idCotizacionItem, tipo, fechaIni, fechaFin, fechaCreacionBeneficio', 'required'),
            array('idBeneficioSincronizado, tipo, dsctoUnid, dsctoFrac, vtaUnid, vtaFrac, pagoUnid, pagoFrac, cuentaCop, nitCop, porcCop, cuentaProv, porcProv, promoFiel, swobligaCli', 'numerical', 'integerOnly' => true),
            array('idBeneficio', 'length', 'max' => 11),
            array('idCotizacionItem', 'length', 'max' => 10),
            array('nitProv', 'length', 'max' => 45),
            array('mensaje', 'length', 'max' => 140),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('idBeneficioCotizacionItem, idBeneficio, idBeneficioSincronizado, idCotizacionItem, tipo, fechaIni, fechaFin, dsctoUnid, dsctoFrac, vtaUnid, vtaFrac, pagoUnid, pagoFrac, cuentaCop, nitCop, porcCop, cuentaProv, nitProv, porcProv, promoFiel, mensaje, swobligaCli, fechaCreacionBeneficio', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tipo0' => array(self::BELONGS_TO, 'MBeneficioTipo', 'tipo'),
            'idCotizacionItem0' => array(self::BELONGS_TO, 'TCotizacionesItems', 'idCotizacionItem'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'idBeneficioCotizacionItem' => 'Id Beneficio Cotizacion Item',
            'idBeneficio' => 'Id Beneficio',
            'idBeneficioSincronizado' => 'Id Beneficio Sincronizado',
            'idCotizacionItem' => 'Id Cotizacion Item',
            'tipo' => 'Tipo',
            'fechaIni' => 'Fecha Ini',
            'fechaFin' => 'Fecha Fin',
            'dsctoUnid' => 'Dscto Unid',
            'dsctoFrac' => 'Dscto Frac',
            'vtaUnid' => 'Vta Unid',
            'vtaFrac' => 'Vta Frac',
            'pagoUnid' => 'Pago Unid',
            'pagoFrac' => 'Pago Frac',
            'cuentaCop' => 'Cuenta Cop',
            'nitCop' => 'Nit Cop',
            'porcCop' => 'Porc Cop',
            'cuentaProv' => 'Cuenta Prov',
            'nitProv' => 'Nit Prov',
            'porcProv' => 'Porc Prov',
            'promoFiel' => 'Promo Fiel',
            'mensaje' => 'Mensaje',
            'swobligaCli' => 'Swobliga Cli',
            'fechaCreacionBeneficio' => 'Fecha Creacion Beneficio',
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

        $criteria->compare('idBeneficioCotizacionItem', $this->idBeneficioCotizacionItem, true);
        $criteria->compare('idBeneficio', $this->idBeneficio, true);
        $criteria->compare('idBeneficioSincronizado', $this->idBeneficioSincronizado);
        $criteria->compare('idCotizacionItem', $this->idCotizacionItem, true);
        $criteria->compare('tipo', $this->tipo);
        $criteria->compare('fechaIni', $this->fechaIni, true);
        $criteria->compare('fechaFin', $this->fechaFin, true);
        $criteria->compare('dsctoUnid', $this->dsctoUnid);
        $criteria->compare('dsctoFrac', $this->dsctoFrac);
        $criteria->compare('vtaUnid', $this->vtaUnid);
        $criteria->compare('vtaFrac', $this->vtaFrac);
        $criteria->compare('pagoUnid', $this->pagoUnid);
        $criteria->compare('pagoFrac', $this->pagoFrac);
        $criteria->compare('cuentaCop', $this->cuentaCop);
        $criteria->compare('nitCop', $this->nitCop);
        $criteria->compare('porcCop', $this->porcCop);
        $criteria->compare('cuentaProv', $this->cuentaProv);
        $criteria->compare('nitProv', $this->nitProv, true);
        $criteria->compare('porcProv', $this->porcProv);
        $criteria->compare('promoFiel', $this->promoFiel);
        $criteria->compare('mensaje', $this->mensaje, true);
        $criteria->compare('swobligaCli', $this->swobligaCli);
        $criteria->compare('fechaCreacionBeneficio', $this->fechaCreacionBeneficio, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BeneficiosCotizacionesItems the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Metodo que hereda comportamiento de ValidateModelBehavior
     * @return void
     */
    public function behaviors() {
        return array(
            'ValidateModelBehavior' => array(
                'class' => 'application.components.behaviors.ValidateModelBehavior',
                'model' => $this
            ),
        );
    }

}
