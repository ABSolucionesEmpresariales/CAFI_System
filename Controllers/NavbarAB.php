<div class="container-fluid px-0 d-none d-lg-block fixed-top">
    <nav style="background-color: black;" class="navbar navbar-expand-lg navbar-dark justify-content-around p-0">
        <div class="col-1 d-flex justify-content-between align-items-center">
            <img class="img-fluid" src="../img/logo/nav1-dark.png" />
        </div>
        <div class="collapse navbar-collapse col-9 d-flex justify-content-center align-items-center" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                if ($_SESSION['acceso'] === "CEOAB") { ?>
                    <li class="nav-item mx-2 text-center">
                        <a id="orange" class="<?php if ($sel === 'usuarios') {
                                                        echo seleccionado;
                                                    } ?> nav-link text-white" onclick="window.location.href='usuariosab.php'" title="Usuarios"><img src="../img/clientes.png">Usuarios</a>
                    </li>
                <?php } ?>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if ($sel === 'clientes') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='clienteab.php'" title="Clientes"><img src="../img/client.png">Clientes</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a class="<?php if ($sel === 'negocios') {
                                    echo seleccionado;
                                } ?> nav-link text-white" onclick="window.location.href='negocio.php'" title="Negocios"><img src="../img/store.png">Negocios</a>
                </li>
                <li class="nav-item mx-2 text-center">
                    <a id="orange" class="<?php if ($sel === 'suscripciones') {
                                                echo seleccionado;
                                            } ?> nav-link text-white" onclick="window.location.href='suscripcion.php'" title="Suscripciones"><img src="../img/calendar.png">Suscripciones</a>
                </li>
            </ul>
        </div>
        <div class="col-1 d-flex justify-content-end align-items-center text-center text-uppercase">
            <a id="nav-salir" class="nav-link text-danger font-weight-bold" href="../Controllers/login.php?cerrar_sesion" title="Salir"><img src="../img/logout.png">Salir</a>
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
                <div class="row">
                    <div class="col-6">
                        <li class="nav-item mx-2 text-center">
                            <a id="orange" class="<?php if ($sel === 'usuarios') {
                                                        echo seleccionado;
                                                    } ?> nav-link text-white" onclick="window.location.href='VUsuarios_ab.php'" title="Usuarios"><img src="../img/clientes.png">Usuarios</a>
                        </li>
                    </div>
                    <div class="col-6">
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'clientes') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='VClienteab.php'" title="Clientes"><img src="../img/client.png">Clientes</a>
                        </li>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <li class="nav-item mx-2 text-center">
                            <a class="<?php if ($sel === 'negocios') {
                                            echo seleccionado;
                                        } ?> nav-link text-white" onclick="window.location.href='VNegociosab.php'" title="Negocios"><img src="../img/store.png">Negocios</a>
                        </li>
                    </div>
                    <div class="col-6">
                        <li class="nav-item mx-2 text-center">
                            <a id="orange" class="<?php if ($sel === 'suscripciones') {
                                                        echo seleccionado;
                                                    } ?> nav-link text-white" onclick="window.location.href='VSuscripcion.php'" title="Suscripciones"><img src="../img/calendar.png">Suscripciones</a>
                        </li>
                    </div>
                </div>

                <li class="nav-item mx-2 text-center">
                    <a id="nav-salir" class="nav-link text-white" href="../Controllers/login.php?cerrar_sesion" title="Salir"><img src="../img/salir.png">Salir</a>
                </li>
            </ul>
        </div>
    </nav>
</div>