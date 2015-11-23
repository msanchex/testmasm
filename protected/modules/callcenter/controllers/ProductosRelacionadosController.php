<?php

class ProductosRelacionadosController extends ControllerOperator {

    public $objSectorCiudad = null;

    public function filters() {
        return array(
            //'access',
            'login + index',
                //'loginajax + direccionActualizar',
        );
    }

    public function filterAccess($filter) {
        if (Yii::app()->controller->module->user->isGuest || Yii::app()->controller->module->user->profile != 2) {
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
        $this->layout = "admin";

        $model = new Producto('search');

        $model->unsetAttributes();
        if (isset($_GET['Producto']))
            $model->attributes = $_GET['Producto'];

        $model->activo = 1;

        $this->render('index', array(
            'model' => $model
        ));
    }

    public function actionCrearrelacion($codigo)
    {
        $model = Producto::model()->findByPk($codigo);

        $modelRelacionados = ProductosRelacionados::model()->findAll(array(
            'condition' => "t.codigoProducto =:codigo",
            'params' => array(
                ':codigo' => $codigo
            )
        ));

        $this->render('crearRelacion', array(
            'model' => $model,
            'modelRelacionados' => $modelRelacionados
        ));
    }

    public function actionBuscarproductos() {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(404, 'Solicitud inválida.');
        }

        $busqueda = Yii::app()->getRequest()->getPost('busqueda');
        $codigoProducto = Yii::app()->getRequest()->getPost('codigoProducto');


        //echo $busqueda." ... ".$modulo;
        //Yii::app()->end();

        if ($busqueda === null || $codigoProducto === null) {
            throw new CHttpException(404, 'Solicitud inválida.');
        }

        $busqueda = trim($busqueda);

        if (empty($busqueda)) {
            throw new CHttpException(404, 'Búsqueda no puede estar vacío.');
        }

        $listProductos = array();
        $codigosArray = GSASearch($busqueda);
        $codigosStr = implode(",", $codigosArray);

        if (!empty($codigosArray)) {
            $listProductos = Producto::model()->findAll(array(
                'with' => array('listImagenes', 'objCodigoEspecial', 'listCalificaciones', 'objCategoriaBI',),
                'condition' => "t.activo=:activo AND t.codigoProducto IN ($codigosStr)",
                'params' => array(
                    ':activo' => 1,
                )
            ));
        }

        
        $model = ProductosRelacionados::model()->findAll('codigoProducto=:codigoProducto', array(':codigoProducto' => $codigoProducto));

        $productosAgregados = array();

        foreach ($model as $indice => $fila) {
            $productosAgregados[] = $fila->codigoRelacionado;
        }
        //print_r();



        $this->renderPartial('buscarProductos', array(
            'listProductos' => $listProductos,
            'nombreBusqueda' => $busqueda,
            'codigoProducto' => $codigoProducto,
            'productosAgregados' => $productosAgregados
        ));
    }

    public function actionAgregarproductorelacionado()
    {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(404, 'Solicitud inválida.');
        }

        $producto = Yii::app()->getRequest()->getPost('producto');
        $productoRelacionado = Yii::app()->getRequest()->getPost('productoRelacionado');

        //echo $producto;
        //Yii::app()->end();

        if ($producto === null || $productoRelacionado === null) {
            throw new CHttpException(404, 'Solicitud inválida.');
        }

        $model = new ProductosRelacionados;

        $model->codigoProducto = $producto;
        $model->codigoRelacionado = $productoRelacionado;
        $model->orden = 0;


        if ($model->save()) {
            $modelRelacionados = ProductosRelacionados::model()->findAll(array(
                'condition' => "t.codigoProducto =:codigo",
                'params' => array(
                    ':codigo' => $producto
                )
            ));
            
            echo CJSON::encode(array('result' => 'ok',
                'response' => array(
                    'htmlProductosAgregados' => $this->renderPartial('_listaProductosRelacionados', array('model' => $modelRelacionados), true, false),
                    'mensaje' => "Se relaciono el producto"
            )));
            Yii::app()->end();
        } else {
            echo CJSON::encode(array(
                'result' => 'error',
                'response' => 'Error al relacionar el producto, por favor intente de nuevo',
            ));
            Yii::app()->end();
        }
    }


    public function actionEliminarproductorelacionado() 
    {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(404, 'Solicitud inválida.');
        }

        $idRelacionado = Yii::app()->getRequest()->getPost('idRelacionado');

        //echo $producto;
        //Yii::app()->end();

        if ($idRelacionado === null) {
            throw new CHttpException(404, 'Solicitud inválida.');
        }

        $model = ProductosRelacionados::model()->findByPk($idRelacionado);
        $producto = $model->codigoProducto;


        if ($model->delete()) {
            $modelRelacionados = ProductosRelacionados::model()->findAll(array(
                'condition' => "t.codigoProducto =:codigo",
                'params' => array(
                    ':codigo' => $producto
                )
            ));

            echo CJSON::encode(array('result' => 'ok',
                'response' => array(
                    'htmlProductosAgregados' => $this->renderPartial('_listaProductosRelacionados', array('model' => $modelRelacionados), true, false),
                    'mensaje' => "Se elimino el producto relacionado"
            )));
            Yii::app()->end();
        } else {
            echo CJSON::encode(array(
                'result' => 'error',
                'response' => 'Error al eliminar la relación con este producto, por favor intente de nuevo',
            ));
            Yii::app()->end();
        }
    }

    public function actionActualizarproductorelacionado() {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(404, 'Solicitud inválida.');
        }

        $idRelacionado = Yii::app()->getRequest()->getPost('idRelacionado');
        $orden = Yii::app()->getRequest()->getPost('orden');

        //echo $producto;
        //Yii::app()->end();

        if ($idRelacionado === null || $orden === null) {
            throw new CHttpException(404, 'Solicitud inválida.');
        }

        $model = ProductosRelacionados::model()->findByPk($idRelacionado);
        $model->orden = $orden;
        $producto = $model->codigoProducto;


        if ($model->save()) {
            $modelRelacionados = ProductosRelacionados::model()->findAll(array(
                'condition' => "t.codigoProducto =:codigo",
                'params' => array(
                    ':codigo' => $producto
                )
            ));

            echo CJSON::encode(array('result' => 'ok',
                'response' => array(
                    'htmlProductosAgregados' => $this->renderPartial('_listaProductosRelacionados', array('model' => $modelRelacionados), true, false),
                    'mensaje' => "Se actualizo el orden del producto relacionado"
            )));
            Yii::app()->end();
        } else {
            echo CJSON::encode(array(
                'result' => 'error',
                'response' => 'Error al actualizar el orden de este producto, por favor intente de nuevo',
            ));
            Yii::app()->end();
        }
    }
}