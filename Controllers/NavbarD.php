<div class="container-fluid px-0 d-none d-lg-block fixed-top">
    <nav style="background-color: black;" class="navbar navbar-expand-lg navbar-dark justify-content-around p-0">
        <div class="col-1 d-flex justify-content-between align-items-center">
            <img class="img-fluid" src="img/logo/nav1-dark.png"/>
        </div>
        <div class="collapse navbar-collapse col-9 d-flex justify-content-center align-items-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item mx-2 text-center">        
                    <a id="orange" class="<?php if($sel === 'trabajadores'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VTrabajador.php'" title="Trabajadores"><img src="../img/clientes.png">Trabajadores</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'edr'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VEstadoResultados.php'" title="Estado de Resultados"><img src="../img/line-chart.png">Estado de Resultados</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'fde'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VFlujoEfectivo.php'" title="Flujo de Efectivo"><img src="../img/cake-graphic.png">Flujo de Efectivo</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if($sel === 'mv'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VMasVendidos.php'" title="Mas Vendidos"><img src="../img/most.png">Mas Vendidos</a>
                </li>
            </ul>
        </div>

        <div class="col-1 d-flex justify-content-end align-items-center text-center text-uppercase">
            <a class="nav-link text-danger font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src="../img/logout.png">Salir</a>
        </div>
    </nav>
</div>

<div class="contaier-fluid d-lg-none">
    <nav style="background-color: black;" class="navbar navbar-dark justify-content-around p-0">
        <button class="d-lg-none navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <img class="img-fluid" src="../img/logo/nav1-dark.png">
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <div class="row">
                    <div class="col-6">
                        <li class="nav-item mx-2 text-center">        
                            <a class="<?php if($sel === 'trabajadores'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VTrabajador.php'" title="Trabajadores"><img src="../img/clientes.png">Trabajadores</a>
                        </li>
                    </div>
                    <div class="col-6">
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if($sel === 'edr'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VEstadoResultados.php'" title="Estado de Resultados"><img src="../img/line-chart.png">Estado de Resultados</a>
                        </li>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if($sel === 'fde'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VFlujoEfectivo.php'" title="Flujo de Efectivo"><img src="../img/cake-graphic.png">Flujo de Efectivo</a>
                        </li>
                    </div>
                    <div class="col-6">
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if($sel === 'mv'){ echo seleccionado; } ?> nav-link text-white" onclick="window.location.href='VMasVendidos.php'" title="Mas Vendidos"><img src="../img/most.png">Mas Vendidos</a>
                        </li>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <li class="nav-item mx-2 text-center">
                            <a class="nav-link text-danger font-weight-bold" href="index.php?cerrar_sesion" title="Salir"><img src="../img/logout.png">Salir</a>
                        </li>
                    </div>
                </div>
            </ul>
        </div>
    </nav>
</div>
