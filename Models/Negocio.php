<?php

namespace Models;

class Negocio
{
    private $nombre;
    private $domicilio;
    private $ciudad;
    private $idcliente;
    private $telefono;
    private $impresora;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    }
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }
    public function setIdCliente($idcliente)
    {
        $this->idcliente = $idcliente;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function setImpresora($impresora)
    {
        $this->impresora = $impresora;
    }

    public function guardar($idusuario)
    {
        $datos = array(null,$this->nombre,$this->domicilio,$this->ciudad,$this->telefono,$this->impresora,$this->idcliente,$idusuario);

        $sql = "INSERT INTO negocios(idnegocios,nombre_negocio,domicilio,ciudad,telefono_negocio,impresora,clientesab_idclienteab,usuariosab_idusuariosab) VALUES('null', 
        '{$this->nombre}','{$this->domicilio}','{$this->ciudad}','{$this->telefono}','{$this->impresora}','{$this->idcliente}','$idusuario')";

        return $this->con->consultaSimple($sql);
    }

    public function eliminar($id)
    {
        $datos = array($id);
        $sql = "DELETE FROM negocios WHERE idnegocios = '$id'";

        $this->con->consultaSimple($sql);
    }

    public function editar($id, $idusuario)
    {
        $datos = array($this->nombre,$this->domicilio,$this->ciudad,$this->telefono,$this->impresora,$idusuario,$id);
        
        $sql = "UPDATE negocios SET nombre_negocio = '{$this->nombre}', domicilio = '{$this->domicilio}'
        ,ciudad ='{$this->ciudad}',telefono_negocio = '{$this->telefono}',impresora = '{$this->impresora}', clientesab_idclienteab ='{$this->idcliente}'
        , usuariosab_idusuariosab = '$idusuario' WHERE idnegocios ='$id'";
        
        return $this->con->consultaSimple($sql);
    }

    public function __destruct()
    {
        $this->con->cerrarConexion();
    }
}