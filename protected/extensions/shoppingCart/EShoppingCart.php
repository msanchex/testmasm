<?php

/**
 * Shopping cart class
 *
 * @author pirrat <mrakobesov@gmail.com>
 * @version 0.7
 * @package ShoppingCart
 */
class EShoppingCart extends CMap {

    /**
     * Update the model on session restore?
     * @var boolean
     */
    public $discounts = array();

    /**
     * Сумма скидки на всю корзину
     * @var float
     */
    protected $discountPrice = 0.0;
    public $codigoPerfil = null;
    public $objSectorCiudad = null;
    protected $shipping = 0;
    protected $shippingStored = 0; //valor envio bodega
    protected $deliveryStored = 0; //tiempo entrega bodega
    protected $bonoValue = 0;
    protected $objPagoExpress = null;

    public function getObjExpress() {
        if ($this->objPagoExpress == null && $this->objSectorCiudad !== null && $this->objSectorCiudad instanceof SectorCiudad) {
            $this->objPagoExpress = PagoExpress::model()->find(array(
                'with' => array('objDireccionDespacho' => array('condition' => 'objDireccionDespacho.codigoCiudad=:ciudad AND objDireccionDespacho.codigoSector=:sector')),
                'condition' => 't.identificacionUsuario=:cedula AND t.activo=:activo',
                'params' => array(
                    ':cedula' => Yii::app()->user->name,
                    ':activo' => 1,
                    ':ciudad' => $this->objSectorCiudad->codigoCiudad,
                    ':sector' => $this->objSectorCiudad->codigoSector
                )
            ));
        }

        return $this->objPagoExpress;
    }

    public function init() {
        $this->restoreFromSession();
    }

    public function setBono($newVal) {
        $this->bonoValue = $newVal;
    }
    
    public function getBono() {
        return $this->bonoValue;
    }

    /* public function setUbicacion($objSectorCiudad) {
      if ($this->objSectorCiudad == null || $objSectorCiudad->codigoCiudad != $this->objSectorCiudad->codigoCiudad || $objSectorCiudad->codigoSector != $this->objSectorCiudad->codigoSector) {
      $this->objSectorCiudad = $objSectorCiudad;
      $this->clear();
      $this->saveState();
      }
      } */

    public function setShipping($newVal) {
        $this->shipping = $newVal;
        $this->saveStateAttributes();
    }

    public function CalculateShipping() {
        if ($this->objSectorCiudad !== null && $this->objSectorCiudad instanceof SectorCiudad) {

            $objDomicilio = Domicilio::model()->find(array(
                'condition' => 'codigoCiudad=:ciudad AND codigoSector=:sector AND codigoPerfil=:perfil',
                'params' => array(
                    ':ciudad' => $this->objSectorCiudad->codigoCiudad,
                    ':sector' => $this->objSectorCiudad->codigoSector,
                    ':perfil' => $this->codigoPerfil,
                )
            ));

            if ($objDomicilio === null) {
                $objDomicilio = Domicilio::model()->find(array(
                    'condition' => 'codigoCiudad=:ciudad AND codigoSector=:sector AND codigoPerfil=:perfil',
                    'params' => array(
                        ':ciudad' => $this->objSectorCiudad->codigoCiudad,
                        ':sector' => Yii::app()->params->sector['*'],
                        ':perfil' => $this->codigoPerfil,
                    )
                ));
            }

            if ($objDomicilio === null) {
                $objDomicilio = Domicilio::model()->find(array(
                    'condition' => 'codigoCiudad=:ciudad AND codigoSector=:sector AND codigoPerfil=:perfil',
                    'params' => array(
                        ':ciudad' => Yii::app()->params->ciudad['*'],
                        ':sector' => Yii::app()->params->sector['*'],
                        ':perfil' => $this->codigoPerfil,
                    )
                ));
            }

            /* if ($objDomicilio === null) {
              $objDomicilio = Domicilio::model()->find(array(
              'condition' => 'codigoCiudad=:ciudad AND codigoSector=:sector AND codigoPerfil=:perfil',
              'params' => array(
              ':ciudad' => $this->objSectorCiudad->codigoCiudad,
              ':sector' => $this->objSectorCiudad->codigoSector,
              ':perfil' => Yii::app()->params->perfil['*'],
              )
              ));
              } */

            if ($objDomicilio === null) {
                $objDomicilio = Domicilio::model()->find(array(
                    'condition' => 'codigoCiudad=:ciudad AND codigoSector=:sector AND codigoPerfil=:perfil',
                    'params' => array(
                        ':ciudad' => Yii::app()->params->ciudad['*'],
                        ':sector' => Yii::app()->params->sector['*'],
                        ':perfil' => Yii::app()->params->perfil['*'],
                    )
                ));
            }

            if ($objDomicilio !== null)
                $this->shipping = $objDomicilio->valorDomicilio;

            $this->saveStateAttributes();
        }
    }

    public function getShipping() {
        return $this->shipping;
    }

    public function getShippingStored() {
        return $this->shippingStored;
    }

    public function getDeliveryStored() {
        return $this->deliveryStored;
    }

    public function setCodigoPerfil($codigoPerfil) {
        if($this->codigoPerfil != $codigoPerfil && $codigoPerfil!==null){
            $this->codigoPerfil = $codigoPerfil;
            $this->updatePositions();
            $this->CalculateShipping();
            //$this->saveStateAttributes();
        }
        $this->saveStateAttributes();
    }
    
    public function getSectorCiudad() {
        return $this->objSectorCiudad;
    }

    public function getCodigoPerfil() {
        return $this->codigoPerfil;
    }
    
    /*public function getEsClienteFiel(){
        if(isset(Yii::app()->session[Yii::app()->params->usuario['sesion']]) && Yii::app()->session[Yii::app()->params->usuario['sesion']] instanceof Usuario){
            $objUsuario = Yii::app()->session[Yii::app()->params->usuario['sesion']];
            return ($objUsuario->esClienteFiel==1);
        }
        
        return false;
    }*/

    public function getCodigoCiudad() {
        if ($this->objSectorCiudad == null)
            return null;
        return $this->objSectorCiudad->codigoCiudad;
    }

    public function getobjSectorCiudad() {
        if ($this->objSectorCiudad == null)
            return null;
        return $this->objSectorCiudad;
    }
    
    public function getObjCiudad() {
        if ($this->objSectorCiudad == null)
            return null;
        return $this->objSectorCiudad->objCiudad;
    }

    public function getCodigoSector() {
        if ($this->objSectorCiudad == null)
            return null;
        return $this->objSectorCiudad->codigoSector;
    }
    
    public function getObjSector() {
        if ($this->objSectorCiudad == null)
            return null;
        return $this->objSectorCiudad->objSector;
    }

    public function getCategorias() {
        $arrCategorias = array();
        foreach ($this as $position) {
            if ($position->isProduct()) {
                $arrCategorias[] = array(
                    'refe' => $position->objProducto->codigoProducto,
                    'codigo' => $position->objProducto->idCategoriaBI,
                    'valor' => $position->getSumPrice(),
                    'tieneDescuento' => $position->hasDiscount()
                );
            }
        }
        return $arrCategorias;
    }

    public function getMarcas() {
        $arrMarcas = array();
        foreach ($this as $position) {
            if ($position->isProduct()) {
                $arrMarcas[] = array(
                    'refe' => $position->objProducto->codigoProducto,
                    'codigo' => $position->objProducto->idMarca,
                    'valor' => $position->getSumPrice(),
                    'tieneDescuento' => $position->hasDiscount()
                );
            }
        }
        return $arrMarcas;
    }

    public function getProveedores() {
        $arrProveedores = array();
        foreach ($this as $position) {
            if ($position->isProduct()) {
                $arrProveedores[] = array(
                    'refe' => $position->objProducto->codigoProducto,
                    'codigo' => $position->objProducto->codigoProveedor,
                    'valor' => $position->getSumPrice(),
                    'tieneDescuento' => $position->hasDiscount()
                );
            }
        }
        return $arrProveedores;
    }

    public function getProductosCantidad() {
        $arrProductos = array();
        foreach ($this as $position) {
            if ($position->isProduct()) {
                $arrProductos[] = array(
                    'codigo' => $position->objProducto->codigoProducto,
                    'cantidad' => $position->getQuantityUnit(),
                    'valor' => $position->getSumPrice(),
                    'tieneDescuento' => $position->hasDiscount()
                );
            }
        }
        return $arrProductos;
    }
    
    /**
     * Restores the shopping cart from the session
     */
    public function restoreFromSession() {
        $data = Yii::app()->getUser()->getState(__CLASS__);

        if (isset(Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']])) {
            $this->objSectorCiudad = Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']];
            if ($this->objSectorCiudad->objCiudad->getDomicilio() != null) {
                $this->shippingStored = $this->objSectorCiudad->objCiudad->getDomicilio()->valorDomicilio;
                $this->deliveryStored = $this->objSectorCiudad->objCiudad->getDomicilio()->tiempoDomicilio;
            }
            Yii::app()->session[Yii::app()->params->sesion['sectorCiudadEntrega']] = $this->objSectorCiudad;
        }

        $this->codigoPerfil = Yii::app()->getUser()->getState(__CLASS__ . '_CodigoPerfil');
        $this->shipping = Yii::app()->getUser()->getState(__CLASS__ . '_Shipping');
        $codigoPerfil = Yii::app()->params->perfil['defecto'];
        if(isset(Yii::app()->session[Yii::app()->params->usuario['sesion']]) && Yii::app()->session[Yii::app()->params->usuario['sesion']] instanceof Usuario){
            $objUsuario = Yii::app()->session[Yii::app()->params->usuario['sesion']];
            $codigoPerfil = $objUsuario->getCodigoPerfil();
        }

        if (is_array($data) || $data instanceof Traversable)
            foreach ($data as $key => $product)
                parent::add($key, $product);
        
        $this->setCodigoPerfil($codigoPerfil);
        
        if(isset(Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']]) && Yii::app()->session[Yii::app()->params->sesion['tipoEntrega']] ==Yii::app()->params->entrega['tipo']['presencial']){
            $this->shipping = 0;
        }
    }

    /**
     * Add item to the shopping cart
     * If the position was previously added to the cart,
     * then information of it is updated, and count increases by $quantity
     * @param IECartPosition $position
     * @param int $quantity count of elements positions
     * @param bool $fraction adding fraction or not
     */
    public function put(IECartPosition $position, $fraction, $quantity = 1) {
        $key = $position->getId();
        if ($this->itemAt($key) instanceof IECartPosition) {
            $position = $this->itemAt($key);
            $oldQuantity = $position->getQuantity($fraction);
            $quantity += $oldQuantity;

            if (!$fraction) {
                $quantity -= $position->getQuantityStored();
            }
        }

        $this->update($position, $fraction, $quantity);
    }

    /**
     * Add item to the shopping cart
     * If the position was previously added to the cart,
     * then information of it is updated, and count increases by $quantity
     * @param IECartPosition $position
     * @param int $quantity count of elements positions
     */
    public function putStored(IECartPosition $position, $quantity = 1) {
        $key = $position->getId();
        if ($this->itemAt($key) instanceof IECartPosition) {
            $position = $this->itemAt($key);
            $oldQuantity = $position->getQuantityStored();
            $quantity += $oldQuantity;
        }

        $this->updateStored($position, $quantity);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function add($key, $value) {
        $this->put($value, 1);
    }

    /**
     * Removes position from the shopping cart of key
     * @param mixed $key
     */
    public function remove($key) {
        parent::remove($key);
        $this->applyDiscounts();
        $this->onRemovePosition(new CEvent($this));
        $this->saveState();
    }

    public function updatePositions() {
        if ($this->objSectorCiudad !== null && $this->codigoPerfil!==null) {
            foreach ($this as $position) {
                $key = $position->getId();

                $position->generate(array(
                    'objSectorCiudad' => $this->objSectorCiudad,
                    'codigoPerfil' => $this->codigoPerfil
                ));
                parent::add($key, $position);

                $this->applyDiscounts();
                $this->onUpdatePoistion(new CEvent($this));
                $this->saveState();
            }
        }
    }
    
    public function updatePositionKey($key) {
        $position = $this->itemAt($key);
        if ($this->objSectorCiudad !== null && $this->codigoPerfil!==null && $position !==null) {
            $position->generate(array(
                'objSectorCiudad' => $this->objSectorCiudad,
                'codigoPerfil' => $this->codigoPerfil
            ));
            parent::add($key, $position);

            $this->applyDiscounts();
            $this->onUpdatePoistion(new CEvent($this));
            $this->saveState();
        }
    }
    
    public function updatePosition(IECartPosition $position) {
        if ($this->objSectorCiudad !== null && $this->codigoPerfil!==null && $position !==null) {
            parent::add($position->getId(), $position);

            //$this->applyDiscounts();
            $this->onUpdatePoistion(new CEvent($this));
            $this->saveState();
        }
    }

    /**
     * Updates the position in the shopping cart
     * If the position was previously added, then it will be updated in shopping cart,
     * if the position was not previously in the cart, it will be added there.
     * If the count of less than 1, the position will be deleted.
     *
     * @param IECartPosition $position
     * @param int $quantity
     * @param bool $fraction adding fraction or not
     */
    public function update(IECartPosition $position, $fraction, $quantity) {
        if ($this->objSectorCiudad !== null) {
            $key = $position->getId();

            $position->generate(array(
                'objSectorCiudad' => $this->objSectorCiudad,
                'codigoPerfil' => $this->codigoPerfil
            ));

            //$position->attachBehavior("CartPosition", new ECartPositionBehaviour());

            $position->setQuantity($quantity, $fraction);

            if ($position->getQuantity(true) + $position->getQuantity(false) < 1)
                $this->remove($key);
            else
                parent::add($key, $position);

            $this->applyDiscounts();
            $this->onUpdatePoistion(new CEvent($this));
            $this->saveState();
            return true;
        }
        return false;
    }

    /**
     * Updates the position in the shopping cart
     * If the position was previously added, then it will be updated in shopping cart,
     * if the position was not previously in the cart, it will be added there.
     * If the count of less than 1, the position will be deleted.
     *
     * @param IECartPosition $position
     * @param int $quantity
     */
    public function updateStored(IECartPosition $position, $quantity) {
        if ($this->objSectorCiudad !== null) {

            $key = $position->getId();

            $position->generate(array(
                'objSectorCiudad' => $this->objSectorCiudad,
                'codigoPerfil' => $this->codigoPerfil
            ));

            $position->setQuantityStored($quantity);

            if ($position->getQuantity(true) + $position->getQuantity(false) < 1)
                $this->remove($key);
            else
                parent::add($key, $position);

            $this->applyDiscounts();
            $this->onUpdatePoistion(new CEvent($this));
            $this->saveState();
            return true;
        }
        return false;
    }

    /**
     * Saves the state of the object in the session.
     * @return void
     */
    protected function saveState() {
        Yii::app()->getUser()->setState(__CLASS__, $this->toArray());
        $this->saveStateAttributes();
    }

    protected function saveStateAttributes() {
        //Yii::app()->getUser()->setState('SectorCiudad', $this->objSectorCiudad);
        Yii::app()->getUser()->setState(__CLASS__ . '_CodigoPerfil', $this->codigoPerfil);
        Yii::app()->getUser()->setState(__CLASS__ . '_Shipping', $this->shipping);
    }

    /**
     * Returns count of items in shopping cart
     * @return int
     */
    public function getItemsCount() {
        $count = 0;
        foreach ($this as $position) {
            $count += $position->getQuantity() + $position->getQuantity(true);
        }

        return $count;
    }

    /**
     * Returns total price for all items in the shopping cart.
     * @param bool $withDiscount
     * @return float
     */
    public function getCost($withDiscount = true) {
        $price = 0.0;
        foreach ($this as $position) {
            $price += $position->getSumPrice($withDiscount);
        }

        if ($withDiscount)
            $price -= $this->discountPrice;

        return $price;
    }

    public function getTotalCost() {

        $price = 0.0;
        foreach ($this as $position) {
            $price += $position->getTotalPrice();
        }

        $price -= $this->discountPrice;
        $price += $this->shipping + $this->shippingStored;
        $price -= $this->bonoValue;

        return $price;
    }

    public function getExtraShipping() {
        $shipping = 0.0;
        foreach ($this as $position) {
            $shipping += $position->getShipping();
        }
        $shipping += $this->shippingStored;
        return $shipping;
    }

    /* public function getTax($position = null) {
      $tax = 0.0;
      if ($position == null) {
      if ($this->objSectorCiudad != null && $this->objSectorCiudad->objCiudad->excentoImpuestos == 0) {
      foreach ($this as $position) {
      $tax += $position->getTax();
      }
      }
      } else {
      if ($this->objSectorCiudad != null && $this->objSectorCiudad->objCiudad->excentoImpuestos == 0) {
      $tax = $position->getTax();
      }
      }
      return $tax;
      } */

    public function getTaxPrice() {
        $tax = 0;
        if ($this->objSectorCiudad != null && $this->objSectorCiudad->objCiudad->excentoImpuestos == 0) {
            foreach ($this as $position) {
                $tax += $position->getTaxPrice(true);
            }
        }
        //$tax = ceil($tax);
        return $tax;
    }
    
    public function getBaseTaxPrice(){
        $tax = 0;
        if ($this->objSectorCiudad != null && $this->objSectorCiudad->objCiudad->excentoImpuestos == 0) {
            foreach ($this as $position) {
                $tax += $position->getBaseTaxPrice(true);
            }
        }
        //$tax = ceil($tax);
        return $tax;
    }
    
    public function onRemovePosition($event) {
        $this->raiseEvent('onRemovePosition', $event);
    }

    public function onUpdatePoistion($event) {
        $this->raiseEvent('onUpdatePoistion', $event);
    }

    /**
     * apply discounts for all positions
     * @return void
     */
    protected function applyDiscounts() {
        foreach ($this->discounts as $discount) {
            $discountObj = Yii::createComponent($discount);
            $discountObj->setShoppingCart($this);
            $discountObj->apply();
        }
    }

    public function addDiscountPrice($price) {
        $this->discountPrice += $price;
    }

    public function getDiscountPrice($total = false) {
        if ($total) {
            $discount = 0.0;
            foreach ($this as $position) {
                $discount += $position->getDiscountPrice() * $position->getQuantity() + $position->getDiscountPrice(true) * $position->getQuantity(true);
                //$discount -= $position->getShipping();
            }
            $discount += $this->discountPrice;
            //$discount -= $this->shipping;

            return $discount;
        } else
            return $this->discountPrice;
    }

    /**
     * Returns array all positions
     * @return array
     */
    public function getPositions() {
        return $this->toArray();
    }

    /**
     * @return bool
     */
    public function isEmpty() {
        return !(bool) $this->getCount();
    }

}
