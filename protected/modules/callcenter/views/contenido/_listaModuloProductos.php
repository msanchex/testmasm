<?php if(count($model->listProductosModulos(array('condition' => 'codigoProducto IS NOT NULL'))) == 0): ?>
    <p>No hay productos en la lista</p>
<?php else: ?>
    <table class="table table-bordered table-hover table-striped">
        <tbody>
            <tr>
                <th>Imagen</th>
                <th>Código</th>
                <th>Producto</th>
                <th></th>
            </tr>
            <?php foreach ($model->listProductosModulos(array('condition' => 'codigoProducto IS NOT NULL')) as $fila => $objProductoModulo): ?>
                <tr>
                    <td><img src="<?php echo Yii::app()->request->baseUrl . $objProductoModulo->objProducto->rutaImagen() ?>" title="<?php echo $objProductoModulo->objProducto->descripcionProducto ?>"> </td>
                    <td><?php echo $objProductoModulo->objProducto->codigoProducto ?></td>
                    <td><?php echo $objProductoModulo->objProducto->descripcionProducto . "<br>" . $objProductoModulo->objProducto->presentacionProducto ?></td>
                    <td>
                        <?php echo CHtml::link('Eliminar', '#', array('data-producto' => $objProductoModulo->idProductoModulo, 'data-role' => "eliminar-producto-contenido", 'class' => 'btn btn-primary')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>