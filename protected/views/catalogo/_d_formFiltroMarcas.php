<?php if (!empty($formFiltro->listMarcas)): ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading-marcas">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion-filtros" href="#collapse-marcas" aria-expanded="true" aria-controls="collapse-marcas" style="background:none;">
                    Marca <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </h4>
        </div>
        <div id="collapse-marcas" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-marcas">
            <div class="panel-body">
                <ul>
                    <?php foreach ($formFiltro->listMarcas as $idMarca => $nombreMarca): ?>
                        <li>
                            <input type="checkbox" name="FiltroForm[listMarcas][<?php echo $idMarca ?>]" id="FiltroForm_listMarcas_<?php echo $idMarca ?>" value="<?php echo $idMarca ?>" <?php echo (isset($formFiltro->listMarcasCheck[$idMarca]) ? "checked" : "") ?>>
                            <label for="FiltroForm_listMarcas_<?php echo $idMarca ?>" class="clst_check"><span></span> <?php echo $nombreMarca ?></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>