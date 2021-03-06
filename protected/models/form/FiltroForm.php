<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class FiltroForm extends CFormModel {
    public $proveedor;
    public $nombre;
    public $listMarcas;
    public $listMarcasCheck = array();
    public $listFiltrosCheck = array();
    public $listFiltros;
    public $listCategoriasTienda = array();
    public $listCategoriasTiendaCheck = array();
    public $precio;
    public $precioRango = array("min"=>-1,"max"=>-1);
    public $calificacion = 0;
    
    public function setRango($minproducto, $maxproducto, $mintercero, $maxtercero){
        $arrMin = array();
        
        if($minproducto!=null && $minproducto>0)
            $arrMin[] = $minproducto;
        if($mintercero!=null && $mintercero>0)
            $arrMin[] = $mintercero;
        if(!empty($arrMin))
            $this->precioRango["min"] = min($arrMin);
        
        $arrMax = array();
        if($maxproducto!=null && $maxproducto>0)
            $arrMax[] = $maxproducto;
        if($maxtercero!=null && $maxtercero>0)
            $arrMax[] = $maxtercero;
        if(!empty($arrMax))
            $this->precioRango["max"] = max($arrMax);
        
    }
    
    public function isRangoPrecioValido(){
        return ($this->precioRango["min"]>0 && $this->precioRango["max"]>0);
    }


    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('listMarcas, nombre, listFiltros, listCategoriasTienda, precio, calificacion', 'safe'),
            array('listMarcas, nombre, precio', 'default', 'value' => null),
        );
    }
    
    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'listMarcas' => 'Marcas',
            'nombre' => 'Nombre',
            'listFiltros' => 'Filtros',
            'listCategoriasTienda' => 'Categorías',
            'precio' => 'Precio',
        );
    }
    
    public function getPrecioInicio(){
        if($this->precio == null || empty($this->precio) || !isset($this->precio[0]) || $this->precio[0]<0)
            return -1;
        return $this->precio[0];
    }
    
    public function getPrecioFin(){
        if($this->precio == null || empty($this->precio) || !isset($this->precio[1]) || $this->precio[1]<0)
            return -1;
        return $this->precio[1];
    }

}