<?php /* @var $this Controller */ ?>
<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="es" />
        <meta content="es" http-equiv="content-language">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script>requestUrl = "<?php echo Yii::app()->request->baseUrl; ?>";</script>
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon_16.ico" type="image/x-icon" />  
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
       
    </head>

    <body>
        <div class="container-fluid">
                <header>
                        <div class="row">
                                <div class="col-md-12">	
                                        <!--logo-->
                                        <div class="col-md-2">
                                                <a class="navbar-brand logo-top"  title="Drogueria - La Rebaja Virtual" alt="logo - La Rebaja" href="<?php echo Yii::app()->baseUrl?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logotop.png" alt="La rebaja virtual"></a>
                                        </div>

                                        <div class="col-md-10">
                                                <div class="row">
                                                        <div class="col-md-12">
                                                                <div class="col-md-2">
                                                                    
                                                                     <!--   <div class="dropdown ciudad">
                                                                                 <a id="ciudad" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ciudad&nbsp;&nbsp;&nbsp;|<span class="glyphicon glyphicon-arrow-down"></span></a>
                                                                                        <?php if(!isset($_SESSION['listciudades'])):
                                                                                               $this->getCiudades();
                                                                                        endif;?>
                                                                                        <ul class="dropdown-menu" aria-labelledby="ciudad">
                                                                                             
                                                                                            <?php foreach($_SESSION['listciudades'] as $ciudad):?>
                                                                                                <a href="#"><li><?php echo /*$ciudad->codigoCiudad." - ".*/$ciudad->nombreCiudad ?></li></a>
                                                                                            <?php  endforeach; ?>   
                                                                                        </ul>
                                                                        </div> --> 
                                                                     <ul class="user ">
                                                                         <?php if(isset($_SESSION['nombreCiudad'])):?>
                                                                            <li>
                                                                               <?php echo $this->sectorName?>     
                                                                            </li>
                                                                         <?php endif;?>
                                                                         <br/>
                                                                         <li>
                                                                        <?php echo CHtml::link('Cambiar Ubicación', CController::createUrl('/sitio/ubicacion'), array()); ?>
                                                                         </li>
                                                                     </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <form method="get" action="<?php echo CController::createUrl('/catalogo/buscarD') ?>" data-ajax="false">
                                                                                    
                                                                                <div class="col-md-6 content-search">
                                                                                        <input type="text" class="form-control" placeholder="Escriba el nombre del producto"  autocomplete="off" value="" id="busqueda" name="busqueda" > 
                                                                                </div>
                                                                                <div class="col-md-6 content-category">
                                                                                        <div class="controls">	
                                                                                                <span>Todas las categorías</span>
                                                                                                <span><i><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/ico-filtro-categorias.png" alt=""></a></i></span>
                                                                                                <span><i><a type="button" value="" ><img class="ico-buscar" src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/ico-buscar.png" alt=""></a></i></span>
                                                                                        </div>
                                                                                </div>
                                                                         </form>

                                                                </div>
                                                                <div class="col-md-4">	
                                                                    <?php if(Yii::app()->user->isGuest):?>
                                                                            <ul class="user">
                                                                                    <img class="ico-user" src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/ico-iniciar-sesion.png" alt="">
                                                                                    <li><a href="<?= Yii::app()->request->baseUrl;?>/usuario/autenticar" >Iniciar Sesión</a></li>
                                                                                    <span style="color:#A3A3A3;">|</span>
                                                                                    <li><a href="<?= Yii::app()->request->baseUrl;?>/usuario/registro">Registrate</a></li>
                                                                            </ul>
                                                                    <?php else:?>
                                                                                <?php $nombre=explode(" ",Yii::app()->session[Yii::app()->params->usuario['sesion']]->nombre."");?>
                                                                           <ul class="user">
                                                                                <li>
                                                                                <a href="<?= Yii::app()->request->baseUrl;?>/usuario/infoPersonal" class="">Hola <?php echo $nombre[0];?> (Mi cuenta)</a> 
                                                                                <span style="color:#A3A3A3;">|</span>
                                                                                <a href="<?= Yii::app()->request->baseUrl;?>/usuario/salir" class=""><span class="glyphicon glyphicon-log-out"></span> Cerrar sesion</a> 
                                                                               </li>
                                                                           </ul>
                                                                    <?php endif;?>
                                                                        <div class="info-compra">
                                                                                <span><img class="ico-carrito" src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/ico-carrito.png" alt=""></span>
                                                                                <span id="cantidad-productos" class="cantidad-productos"><?php echo Yii::app()->shoppingCart->getCount(); ?></span>
                                                                                <p style="color: #A3A3A3;">Productos</p>
                                                                        </div>
                                                                    
                                                                    <div data-role="panel" id="div-carro-canasta">
                                                                        <?php $this->renderPartial('/carro/d_canasta'); ?>
                                                                    </div>  
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>

                                </div>
                        </div>
                </header>
        </div>
        <!--menu-->
        <ul class="nav nav-pills" role="tablist">
            <li class="dropdown col-md-2 categorias" role="presentation">

                <a id="categorias" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categorías<span class="ico-cat"></span></a>
                <ul class="dropdown-menu category" aria-labelledby="categorias">
                  <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/rx.png" alt="">Medicina formulada</a></li>
                  <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/productos-sin-formula.png" alt="">Productos sin formula</a></li>
                  <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/cuidado-personal.png" alt="">Cuidado personal</a></li>
                  <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/comida.png" alt="">Alimentos y bebidas</a></li>
                  <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/aseo.png" alt="">Aseo y Hogar</a></li>
                  <li><a href="mundo-bebes.html"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/bebe.png" alt="">Mundo Bebes</a></li>
                  <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/natural.png" alt="">Natural</a></li>
                  <li><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/promociones.png" alt="">Promociones</a></li>
                </ul>
            </li>

                <li class="col-md-3 mundo_bebe">
                        <a href="mundo-bebes.html"><span class="ico-bebe"></span>Mundo bebé</a>
                </li>

            <li class="col-md-3 natural">
                <a href="#"><span class="ico-natural"></span>Natural</a>
            </li>
            <li class="col-md-4 promociones">
                <a href="#"><span class="ico-promociones"></span>Promociones</a>
            </li>

        </ul>
        <!--fin menu-->
        <div class="container">
            <?php echo $content; ?>
        </div>
         
            <section>	
            <br>
            </section>
                    <!--promociones-->
            <section>	
                    <div class="container">	
                            <div class="row">	
                                    <div class="col-md-12">	
                                            <div class="col-md-4">
                                                    <a href="#"><img style="width:100%;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/prom-lunes.png"></a>
                                            </div>
                                            <div class="col-md-4">
                                                    <a href="#"><img style="width:100%;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/prom-descuento.png"></a>	
                                            </div>
                                            <div class="col-md-4">
                                                    <a href="#"><img style="width:100%;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/prom-bebes.png"></a>		
                                            </div>
                                    </div>
                            </div>
                    </div>
            </section>
            <!--promociones-->

            <section>	
            <br>
            </section>

            <!--banner footer-->
            <section class="img-footer">	
                    <div class="row"></div>
            </section>
            <!--fin banner footer-->
<!--footer-->
<footer>	
	<div class="container">	
		<div class="row">
			<div class="col-md-12" style="padding-top:20px;">	
				<div class="col-md-3">
					<div class="titulo-footer">	
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/informacion-y-servicios.png" alt="">
						<strong style="margin-left:10px;">Información</strong><br><strong class="title-footer2"> y servicios</strong>
					</div>
					<ul>	
						<li><a href="#">Horarios de atención</a></li>
						<li><a href="#">Politicas días de descuento 1,10,15 y 25</a></li>
						<li><a href="#">PQRS (Pregunras, quejas, reclamos, sugerencias)</a></li>
						<li><a href="#">Políticas y términos de uso</a></li>
						<li><a href="#">SIC (Súper intendencia de industria y comercio)</a></li>
						<li><a href="#">Tarjeta crediRebaja</a></li>
					</ul>
				</div>
				<div class="col-md-2">
					<div class="titulo-footer">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/cliente-fiel.png" alt="">	
						<strong style="margin-left:10px;">Club</strong><br><strong class="title-footer2">cliente fiel</strong>
					</div>
					<ul>	
						<li><a href="#">Informaciíon del programa</a></li>
						<li><a href="#">Beneficios del programa</a></li>
						<li><a href="#">Términos y condiciones</a></li>
						<li><a href="#">Actualiza datos</a></li>
					</ul>
				</div>
				<div class="col-md-3">
					<div class="titulo-footer">	
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/ico-actividad-comercial.png" alt="">
						<strong style="margin-left:10px;">Actividades</strong><br><strong class="title-footer2">comerciales</strong>
					</div>
					<ul>	
						<li><a href="#">Políticas y condiciones</a></li>
						<li><a href="#">Ganadores de campañas</a></li>
					</ul>
				</div>
				<div class="col-md-2">
					<div class="titulo-footer">	
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/coopervir.png" alt="">
						<strong>Cooperservir</strong>
					</div>
				</div>
				<div class="col-md-2">
					<div class="titulo-footer-last">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/desktop/ico-contactanos.png" alt="">	
						<strong>Contactanos</strong>
					</div>
					<ul>	
						<li>Call center <br> 01 8000 93 99 00</li>
					</ul>
				</div>
			</div>	
			
			<div class="col-md-12">	
				<br>
				<br>
			</div>	

			<div class="col-md-12">	
			  <p align="center">Cooperativa Multiactiva &nbsp;de Servicios Solidarios Copservir  Ltda | NIT &nbsp;830.011.670-3 | LA REBAJA DROGUERIA | 01 8000 93 99  00 <br> Calle 13 No. 42 - 10 Bogotá, Colombia | <a href="mailto:infolrv@copservir.com">infolrv@copservir.com</a>
              Colombia © 2015 <a href="http://www.larebajavirtual.com">www.larebajavirtual.com <br> </a><a href="/contenido/index/opcion/param/99/">PQRS (preguntas, quejas, reclamos, sugerencias)</a></p>
			</div>
		</div>
	</div>
</footer>
    </body>
</html>