<?php

class UsuarioController extends ControllerOperator {
    //public $defaultAction = 'autenticar';

    /**
     * @return array action filters
     * */
    public function filters() {
        return array(
            'access + index, autenticar',
            //'login + index, infoPersonal, direcciones, direccionCrear, pagoexpress, listapedidos, pedido, listapersonal, listadetalle',
            //'loginajax + direccionActualizar',
        );
    }

    /*
      public function filters() {
      return array(
      array('tienda.filters.AccessControlFilter'),
      array('tienda.filters.LanzamientoControlFilter'),
      );
      } */

    public function filterAccess($filter) {
        if (!Yii::app()->controller->module->user->isGuest) {
            $this->redirect(Yii::app()->controller->module->homeUrl);
        }
        $filter->run();
    }

    public function filterLogin($filter) {
        if (Yii::app()->controller->module->user->isGuest) {
            $this->redirect(Yii::app()->user->loginUrl);
        }
        $filter->run();
    }

    public function filterLoginajax($filter) {
        if (Yii::app()->controller->module->user->isGuest) {
            echo CJSON::encode(array('result' => 'error', 'response' => 'No se detecta usuario autenticado, por favor iniciar sesión para continuar'));
            Yii::app()->end();
        }
        $filter->run();
    }

    public function actionIndex() {
        $this->redirect($this->createUrl('autenticar'));
    }

    /**
     * Visualiza la pagina de autenticacion de usuario
     */
    public function actionAutenticar() {
        $this->layout = "simple";

        $model = new LoginOperatorForm;

        if (isset($_POST['LoginOperatorForm'])) {
            $model->attributes = $_POST['LoginOperatorForm'];
            if ($model->validate()) {
                $this->redirect(Yii::app()->controller->module->homeUrl);
            }
        }

        $this->render('autenticar', array('model' => $model));
    }

    /**
     * Cierra sesion y redirecciona a la pagina de autenticacion
     */
    public function actionSalir() {
        Yii::app()->controller->module->user->logout();
        $this->redirect(Yii::app()->controller->module->homeUrl);
    }

}
