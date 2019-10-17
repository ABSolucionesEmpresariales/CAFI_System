<div class="container-fluid px-0 d-none d-lg-block fixed-top">
    <nav style="background-color: black;" class="navbar navbar-expand-lg navbar-dark justify-content-around p-0">
        <div class="col-1 d-flex justify-content-between align-items-center">
            <img class="img-fluid" src="img/logo/nav1-dark.png">
        </div>
        <div class="collapse navbar-collapse col-10 d-flex justify-content-center align-items-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item mx-2 text-center">        
                    <a style="color: #fe6f00;" class="<?php if($sel === 'venta'){ echo seleccionado; } ?> nav-link" onclick="window.location.href='VVentas.php'" title="Venta"><img src="../img/sell.png">Venta</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'abonos'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VAbonos.php'" title="Abonos"><img src="../img/abonos-dark.png">Abonos</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'adeudos'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VConsultasAdeudos.php'" title="Adeudos"><img src="../img/adeudos-dark.png">Adeudos</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'gastos'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VGastos.php'" title="Gastos"><img src="../img/expenses.png">Gastos</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'retiros'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VRetiros.php'" title="Retiro"><img src="../img/atm.png">Retiros</a>
                </li>

                <?php if($_SESSION['acceso'] === "Manager"){?>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if($sel === 'ingresos'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VOtrosIngresos.php'" title="Otros Ingresos"><img src="../img/profit.png">Ingresos</a>
                    </li>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if($sel === 'clientes'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VClientes.php'" title="Clientes"><img src="../img/client.png">Clientes</a>
                    </li>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if($sel === 'inventario'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VInventario.php'" title="Inventario"><img src="../img/Inventory-dark.png">Reporte Inventario</a>
                    </li>
                    <li class="nav-item mx-2 text-center">
                        <a style="color: #fe6f00;" class="<?php if($sel === 'productos'){ echo seleccionado; } ?> nav-link" onclick="window.location.href='VProductos.php'" title="Productos"><img src="../img/products.png">Productos</a>
                    </li>
                <?php } ?>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'ventas'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VConsultasVentas.php'" title="Venta"><img src="../img/sales.png">Historial Ventas</a>
                </li>
            </ul>
        </div>
        <div class="col-1 d-flex justify-content-end align-items-center text-center">
            <a class="nav-link text-danger font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src="../img/logout.png">Salir</a>
        </div>
    </nav>
</div>

<div class="container-fluid d-lg-none">
    <nav style="background-color: black;" class="navbar navbar-dark justify-content-around p-0">
        <button class="d-lg-none navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <img class="img-fluid" src="../img/logo/nav1-dark.png">
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if($_SESSION['acceso'] != "Manager"){?>
                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">        
                                <a style="color: #fe6f00;" class="<?php if($sel === 'venta'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VVentas.php'" title="Venta"><img src="../img/sell.png">Vender</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'abonos'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VAbonos.php'" title="Abonos"><img src="../img/abonos-dark.png">Abonos</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'adeudos'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VConsultasAdeudos.php'" title="Adeudos"><img src="../img/adeudos-dark.png">Adeudos</a>
                            </li>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'gastos'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VGastos.php'" title="Gastos"><img src="../img/expenses.png">Gastos</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'retiros'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VRetiros.php'" title="Retiro"><img src="../img/atm.png">Retiros</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'ventas'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VConsultasVentas.php'" title="Venta"><img src="../img/sales.png">Ventas</a>
                            </li>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <li class="nav-item mx-2 text-center">
                                <a id="nav-salir" class="nav-link font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src="../img/logout.png">Salir</a>
                            </li>
                        </div>
                    </div>
                <?php }?>

                <?php if($_SESSION['acceso'] === "Manager"){?>
                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">        
                                <a id="orange" class="<?php if($sel === 'venta'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VVentas.php'" title="Venta"><img src="../img/sell.png">Vender</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'abonos'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VAbonos.php'" title="Abonos"><img src="../img/abonos-dark.png">Abonos</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'adeudos'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VConsultasAdeudos.php'" title="Adeudos"><img src="../img/adeudos-dark.png">Adeudos</a>
                            </li>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'gastos'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VGastos.php'" title="Gastos"><img src="../img/expenses.png">Gastos</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'retiros'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VRetiros.php'" title="Retiro"><img src="../img/atm.png">Retiros</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'ingresos'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VOtrosIngresos.php'" title="Otros Ingresos"><img src="../img/profit.png">Ingresos</a>
                            </li>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'clientes'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VClientes.php'" title="Clientes"><img src="../img/client.png">Clientes</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a id="orange" class="<?php if($sel === 'inventario'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VInventario.php'" title="Inventario"><img src="../img/Inventory-dark.png">Reporte Inventario</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a style="color: #fe6f00;" class="<?php if($sel === 'productos'){ echo seleccionado; } ?> nav-link font-weight-bold" onclick="window.location.href='VProductos.php'" title="Productos"><img src="../img/products.png">Productos</a>
                            </li>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if($sel === 'ventas'){ echo seleccionado; } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VConsultasVentas.php'" title="Venta"><img src="../img/sales.png">Ventas</a>
                            </li>
                        </div>
                        <div class="col-6">
                            <li class="nav-item mx-2 text-center">
                                <a id="nav-salir" class="nav-link font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src=" ../img/logout.png">Salir</a>
                            </li>
                        </div>
                    </div>
                <?php }?>
            </ul>
        </div>
    </nav>
</div>