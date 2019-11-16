<?php
if ($_SESSION['acceso'] != 'CEO') { ?>
    <div class="container-fluid px-0 d-none d-lg-block fixed-top">
        <nav style="background-color: #2f2e3e;" class="navbar navbar-expand-lg navbar-dark justify-content-around p-0">
            <div class="col-1 d-flex justify-content-between align-items-center">
                <img class="img-fluid" src="../img/logo/nav1-dark.png">
            </div>
            <div class="collapse navbar-collapse col-10 d-flex justify-content-center align-items-center" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item mx-2 text-center">
                        <a style="color: #fe6f00;" class="<?php if ($sel === 'venta') {
                                                                    echo seleccionado;
                                                                } ?> nav-link" onclick="window.location.href='ventas.php'" title="Venta"><img src="../img/sell.png">Venta</a>
                    </li>

                    <?php if ($_SESSION['acceso'] === "Employe") { ?>
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'abonos') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='abonos.php'" title="Abonos"><img src="../img/abonos-dark.png">Abonos</a>
                        </li>
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'adeudos') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='consultasadeudos.php'" title="Adeudos"><img src="../img/adeudos-dark.png">Adeudos</a>
                        </li>
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'gastos') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='../Views/gastos.php'" title="Gastos"><img src="../img/expenses.png">Gastos</a>
                        </li>
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'retiros') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='retiros.php'" title="Retiro"><img src="../img/atm.png">Retiros</a>
                        </li>
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'ventas') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='consultasventas.php'" title="Venta"><img src="../img/sales.png">Historial Ventas</a>
                        </li>
                    <?php } ?>


                    <?php if ($_SESSION['acceso'] === "Manager") { ?>
                        <div class="dropdown nav-item mx-2 text-center">
                            <button style="background-color: #2f2e3e;" class="dropbtn"><img src="../img/expenses.png">Caja</button>
                            <div style="background-color: #2f2e3e;" class="dropdown-content">
                                <a class="<?php if ($sel === 'abonos') {
                                            echo seleccionado;
                                        } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='abonos.php'" title="Abonos"><img src="../img/abonos-dark.png">Abonos</a>
                                <a class="<?php if ($sel === 'adeudos') {
                                            echo seleccionado;
                                        } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='consultasadeudos.php'" title="Adeudos"><img src="../img/adeudos-dark.png">Adeudos</a>
                                <a class="<?php if ($sel === 'gastos') {
                                            echo seleccionado;
                                        } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='../Views/gastos.php'" title="Gastos"><img src="../img/expenses.png">Gastos</a>
                                <a class="<?php if ($sel === 'retiros') {
                                            echo seleccionado;
                                        } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='retiros.php'" title="Retiro"><img src="../img/atm.png">Retiros</a>
                                <a class="<?php if ($sel === 'ingresos') {
                                            echo seleccionado;
                                        } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='otros_ingresos.php'" title="Otros Ingresos"><img src="../img/profit.png">Ingresos</a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <button style="background-color: #2f2e3e;" class="dropbtn"><img src="../img/sales.png">Catalogo</button>
                            <div style="background-color: #2f2e3e;" class="dropdown-content">
                                <a class="<?php if ($sel === 'clientes') {
                                        echo seleccionado;
                                    } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='clientes.php'" title="Clientes"><img src="../img/client.png">Clientes</a>
                                <a style="color: #fe6f00;" class="<?php if ($sel === 'productos') {
                                        echo seleccionado;
                                    } ?> nav-link font-weight-bold" onclick="window.location.href='productos.php'" title="Productos"><img src="../img/products.png">Productos</a>
                                <a class="<?php if ($sel === 'proveedores') {
                                        echo seleccionado;
                                    } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='proveedores.php'" title="Proveedores"><img src="../img/truck.png">Proveedores</a>
                                <a class="<?php if ($sel === 'ccm') {
                                        echo seleccionado;
                                    } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='ccm.php'" title="Categorias/Marcas/Colores"><img src="../img/user.png">Cat/Marcas/Colores</a>
                            </div>
                        </div>
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'compras') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='compras.php'" title="Crompas"><img src="../img/buy.png">Compras</a>
                        </li>
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'inventario') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='inventario.php'" title="Inventario"><img src="../img/Inventory-dark.png">Inventario</a>
                        </li>
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'ventas') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='consultasventas.php'" title="Venta"><img src="../img/sales.png"> Historial Ventas</a>
                        </li>
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'reportes') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='reportes.php'" title="Reportes"><img src="../img/analysis.png">Reportes</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-1 d-flex justify-content-end align-items-center text-center">
                <a class="nav-link text-danger font-weight-bold" href="../Controllers/login.php?cerrar_sesion" title="Salir"><img src="../img/logout.png">Salir</a>
            </div>
        </nav>
    </div>

    <div class="container-fluid d-lg-none">
        <nav style="background-color: #2f2e3e;" class="navbar navbar-dark justify-content-around p-0">
            <button class="d-lg-none navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <img class="img-fluid" src="../img/logo/nav1-dark.png">
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if ($_SESSION['acceso'] != "Manager") { ?>
                        <div class="row">
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a style="color: #fe6f00;" class="<?php if ($sel === 'venta') {
                                                                                    echo seleccionado;
                                                                                } ?> nav-link font-weight-bold" onclick="window.location.href='ventas.php'" title="Venta"><img src="../img/sell.png">Vender</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'abonos') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='VAbonos.php'" title="Abonos"><img src="../img/abonos-dark.png">Abonos</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'adeudos') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='consultasadeudos.php'" title="Adeudos"><img src="../img/adeudos-dark.png">Adeudos</a>
                                </li>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'gastos') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='../Views/gastos.php'" title="Gastos"><img src="../img/expenses.png">Gastos</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'retiros') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='retiros.php'" title="Retiro"><img src="../img/atm.png">Retiros</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'ventas') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='consultasventas.php'" title="Venta"><img src="../img/sales.png">Ventas</a>
                                </li>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <li class="nav-item mx-2 text-center">
                                    <a id="nav-salir" class="nav-link font-weight-bold" href="../Controllers/login.php?cerrar_sesion" title="Salir"><img src="../img/logout.png">Salir</a>
                                </li>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($_SESSION['acceso'] === "Manager") { ?>
                        <div class="row">
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a id="orange" class="<?php if ($sel === 'venta') {
                                                                        echo seleccionado;
                                                                    } ?> nav-link font-weight-bold text-white" onclick="window.location.href='ventas.php'" title="Venta"><img src="../img/sell.png">Vender</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'abonos') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='abonos.php'" title="Abonos"><img src="../img/abonos-dark.png">Abonos</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'adeudos') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='consultasadeudos.php'" title="Adeudos"><img src="../img/adeudos-dark.png">Adeudos</a>
                                </li>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'gastos') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='../Views/gastos.php'" title="Gastos"><img src="../img/expenses.png">Gastos</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'retiros') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='retiros.php'" title="Retiro"><img src="../img/atm.png">Retiros</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'ingresos') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='otros_ingresos.php'" title="Otros Ingresos"><img src="../img/profit.png">Ingresos</a>
                                </li>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'clientes') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='clientes.php'" title="Clientes"><img src="../img/client.png">Clientes</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    <a id="orange" class="<?php if ($sel === 'inventario') {
                                                                        echo seleccionado;
                                                                    } ?> nav-link font-weight-bold text-white" onclick="window.location.href='inventario.php'" title="Inventario"><img src="../img/Inventory-dark.png">Reporte Inventario</a>
                                </li>
                            </div>
                            <div class="col-4">
                                <li class="nav-item mx-2 text-center">
                                    
                                </li>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <li class="nav-item mx-2 text-center">
                                    <a class="<?php if ($sel === 'ventas') {
                                                            echo seleccionado;
                                                        } ?> nav-link font-weight-bold text-white" onclick="window.location.href='consultasventas.php'" title="Venta"><img src="../img/sales.png">Ventas</a>
                                </li>
                            </div>
                            <div class="col-6">
                                <li class="nav-item mx-2 text-center">
                                    <a id="nav-salir" class="nav-link font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src=" ../img/logout.png">Salir</a>
                                </li>
                            </div>
                        </div>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
<?php } else { ?>

    <div class="container-fluid px-0 d-none d-lg-block fixed-top">
        <nav style="background-color: #2f2e3e;" class="navbar navbar-expand-lg navbar-dark justify-content-around p-0">
            <div class="col-1 d-flex justify-content-between align-items-center">
                <img class="img-fluid" src="../img/logo/nav1-dark.png" />
            </div>
            <div class="collapse navbar-collapse col-10 d-flex justify-content-center align-items-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item mx-2 text-center">
                        <a id="orange" class="<?php if ($sel === 'trabajadores') {
                                                        echo seleccionado;
                                                    } ?> nav-link text-white" onclick="window.location.href='trabajadorCafi.php'" title="Trabajadores"><img src="../img/clientes.png">Trabajadores</a>
                    </li>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if ($sel === 'edr') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='estadoresultados.php'" title="Estado de Resultados"><img src="../img/line-chart.png">E.R.</a>
                    </li>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if ($sel === 'fde') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='flujoefectivo.php'" title="Flujo de Efectivo"><img src="../img/cake-graphic.png">F.E.</a>
                    </li>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if ($sel === 'mv') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='masVendidos.php'" title="Flujo de Efectivo"><img src="../img/most.png">M.V.</a>
                    </li>

                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if ($sel === 'venta') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='ventas.php'" title="Venta"><img src="../img/sell.png">Vender</a>
                    </li>
                    <div class="dropdown nav-item mx-2 text-center">
                        <button style="background-color: #2f2e3e;" class="dropbtn"><img src="../img/expenses.png">Caja</button>
                        <div style="background-color: #2f2e3e;" class="dropdown-content">
                            <a class="<?php if ($sel === 'abonos') {
                                        echo seleccionado;
                                    } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='abonos.php'" title="Abonos"><img src="../img/abonos-dark.png">Abonos</a>
                            <a class="<?php if ($sel === 'adeudos') {
                                        echo seleccionado;
                                    } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='consultasadeudos.php'" title="Adeudos"><img src="../img/adeudos-dark.png">Adeudos</a>
                            <a class="<?php if ($sel === 'gastos') {
                                        echo seleccionado;
                                    } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='../Views/gastos.php'" title="Gastos"><img src="../img/expenses.png">Gastos</a>
                            <a class="<?php if ($sel === 'retiros') {
                                        echo seleccionado;
                                    } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='retiros.php'" title="Retiro"><img src="../img/atm.png">Retiros</a>
                            <a class="<?php if ($sel === 'ingresos') {
                                        echo seleccionado;
                                    } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='otros_ingresos.php'" title="Otros Ingresos"><img src="../img/profit.png">Ingresos</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button style="background-color: #2f2e3e;" class="dropbtn"><img src="../img/sales.png">Catalogo</button>
                        <div style="background-color: #2f2e3e;" class="dropdown-content nav-link">
                            <a class="<?php if ($sel === 'clientes') {
                                    echo seleccionado;
                                } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='clientes.php'" title="Clientes"><img src="../img/client.png">Clientes</a>
                            <a style="color: #fe6f00;" class="<?php if ($sel === 'productos') {
                                    echo seleccionado;
                                } ?> nav-link font-weight-bold" onclick="window.location.href='productos.php'" title="Productos"><img src="../img/products.png">Productos</a>
                            <a class="<?php if ($sel === 'proveedores') {
                                    echo seleccionado;
                                } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='proveedores.php'" title="Proveedores"><img src="../img/truck.png">Proveedores</a>
                            <a class="<?php if ($sel === 'ccm') {
                                    echo seleccionado;
                                } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='ccm.php'" title="Categorias/Marcas/Colores"><img src="../img/user.png">Cat/Marcas/Colores</a>
                        </div>
                    </div>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if ($sel === 'compras') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='compras.php'" title="Crompas"><img src="../img/buy.png">Compras</a>
                    </li>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if ($sel === 'inventario') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='inventario.php'" title="Inventario"><img src="../img/Inventory-dark.png">Inventario</a>
                    </li>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if ($sel === 'ventas') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='consultasventas.php'" title="Venta"><img src="../img/sales.png">Ventas</a>
                    </li>
                    <li class="nav-item mx-2 text-center">
                        <a class="<?php if ($sel === 'reportes') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='reportes.php'" title="Reportes"><img src="../img/analysis.png">Reportes</a>
                    </li>
                    <li class="nav-item mx-2 text-center text-white col-2">
                        <select class="form form-control mt-3" id="Navbarsucursales">
                        </select>
                    </li>
                </ul>
            </div>

            <div class="col-1 d-flex justify-content-end align-items-center text-center text-uppercase">
                <a class="nav-link text-danger font-weight-bold" href="../Controllers/login.php?cerrar_sesion" title="Salir"><img src="../img/logout.png">Salir</a>
            </div>
        </nav>
    </div>

    <div class="contaier-fluid d-lg-none">
        <nav class="navbar navbar-dark bg-dark justify-content-around p-0">
            <button class="d-lg-none navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <img class="img-fluid" src="../img/logo/nav1-dark.png">
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'trabajadores') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='trabajadorCafi.php'" title="Trabajadores"><img src="../img/clientes.png">Trabajadores</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'edr') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='estadoresultados.php'" title="Estado de Resultados"><img src="../img/line-chart.png"><br>E.R</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'fde') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='flujoefectivo.php'" title="Flujo de Efectivo"><img src="../img/cake-graphic.png"><br>F.E</a>
                            </li>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'venta') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='ventas.php'" title="Venta"><img src="../img/sell.png"><br>Vender</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'abonos') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='abonos.php'" title="Abonos"><img src="../img/abonos-dark.png"><br>Abonos</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'adeudos') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='consultasadeudos.php'" title="Adeudos"><img src="../img/adeudos-dark.png">Adeudos</a>
                            </li>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'gastos') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='../Views/gastos.php'" title="Gastos"><img src="../img/expenses.png"><br>Gastos</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'retiros') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='retiros.php'" title="Retiro"><img src="../img/atm.png"><br>Retiros</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'ingresos') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='otros_ingresos.php'" title="Otros Ingresos"><img src="../img/profit.png">Ingresos</a>
                            </li>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'clientes') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='clientes.php'" title="Clientes"><img src="../img/client.png"><br>Clientes</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'inventario') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='inventario.php'" title="Inventario"><img src="../img/Inventory-dark.png">Inventario</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'productos') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='productos.php'" title="Productos"><img src="../img/products.png">Productos</a>
                            </li>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'proveedores') {
                                    echo seleccionado;
                                } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='proveedores.php'" title="Proveedores"><img src="../img/truck.png">Proveedores</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'compras') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='compras.php'" title="Crompas"><img src="../img/buy.png">Compras</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'ccm') {
                                    echo seleccionado;
                                } ?> nav-link text-white mx-2 text-center" onclick="window.location.href='ccm.php'" title="Categorias/Marcas/Colores"><img src="../img/user.png"><br>CMC</a>
                            </li>
                        </div>
                    </div>
                            
                    <div class="row">
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'ventas') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='consultasventas.php'" title="Venta"><img src="../img/sales.png"><br>Ventas</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'reportes') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='reportes.php'" title="Reportes"><img src="../img/analysis.png">Reportes</a>
                            </li>
                        </div>
                        <div class="col-4">
                            <li class="nav-item mx-2 text-center">
                                <a class="<?php if ($sel === 'mv') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='masVendidos.php'" title="Flujo de Efectivo"><img src="../img/most.png"><br>M.V</a>
                            </li>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <li class="nav-item mx-2 text-center text-white">
                                <select class="form form-control mt-3" id="Navbarsucursales2">
                                </select>
                            </li>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <li class="nav-item mx-2 text-center">
                                <a class="nav-link text-danger font-weight-bold" href="../Controllers/login.php?cerrar_sesion" title="Salir"><img src="../img/logout.png"><br>Salir</a>
                            </li>
                        </div>
                    </div>
                </ul>
            </div>
        </nav>
    </div>


<?php } ?>
