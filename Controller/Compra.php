<?php

class Compra
{

    public function buscarCompra($param = NULL)
    {
        $objCompra = new Model_compra();
        $where = " true";

        if (isset($param['idcompra'])) {
            $where .= " AND idcompra = " . $param['idcompra'];
        }
        if (isset($param['idusuario'])) {
            $where .= " AND idusuario = " . $param['idusuario'];
        }

        $compra = $objCompra->Listar($where);
        return $compra;
    }

    /**
     *
     */
    public function iniciarCompra($datos)
    {
        $obj_usuario = new Model_usuario();
        $obj_compra = new Model_compra();
        $obj_compraestado = new Model_compraestado();
        $obj_compraestadotipo = new Model_compraestadotipo();
        $obj_usuario->Buscar($datos['idusuario']);

        // La fecha donde se inicia la compra
        $t = time();
        $t = (date("Y-m-d H:i:s", $t));

        $obj_producto = new Model_producto();
        $obj_producto->Buscar($datos['id_producto']);

        // Antes de insertar, tengo que verificar que el producto solicitado no supere el stock
        if ($obj_producto->getProcantstock() >= 1) {
            // $id_compra = $this->getIdCompra($obj_usuario, $obj_compra);
            $id_compra = $this->buscarCompraCarritoUsuario($datos['idusuario']);

            if ($id_compra == '') {
                $t = time();
                $t = (date("Y-m-d H:i:s", $t));
                $obj_compra->setearValores(null, $t, $obj_usuario);

                $id_compra = $obj_compra->Insertar(); // Obtengo el #ID de la compra después de insertar

                $obj_compra->Buscar($id_compra);
                $obj_compraestadotipo->Buscar(1);
                $obj_compraestado->setearValores(null, $obj_compra, $obj_compraestadotipo, $t, null);
                $obj_compraestado->Insertar();
            } else {
                $obj_compra->Buscar($id_compra);
            }

            $obj_compraitem = new Model_compraitem();

            // En caso de existir ese producto ya en el carrito, incrementamos su cantidad solamente, no se agrega de nuevo
            $param_compraitems = [];
            $param_compraitems['idproducto'] = $obj_producto->getIdProducto();
            $param_compraitems['idcompra'] = $id_compra;
            $compraitem = $this->buscarCompraItem($param_compraitems);

            // Modifico el stock del producto cuando se realiza una compra
            $cantidad = $obj_producto->getProcantstock() - 1;
            $obj_producto->setearValores($obj_producto->getIdProducto(), $obj_producto->getPronombre(), $obj_producto->getProdetalle(), $cantidad, $obj_producto->getUrlImagen(), $obj_producto->getPrecio());
            $obj_producto->Modificar();
            $obj_producto->Buscar($datos['id_producto']);

            if ($compraitem) { // Si ya existe una compraitem
                $new_cantidad = $compraitem[0]->getCicantidad() + 1;
                $obj_compraitem->setearValores($compraitem[0]->getIdCompraitem(), $compraitem[0]->getObjProducto(), $compraitem[0]->getObjCompra(), $new_cantidad);
                $obj_compraitem->Modificar();
            } else { // En caso de no existir esa compra, agrega uno nuevo.
                $obj_compraitem->setearValores(null, $obj_producto, $obj_compra, 1);
                $obj_compraitem->Insertar();
            }

            $resultado['exito'] = true;
            return $resultado;
        } else {
            $resultado['errors'][] = ['¡La cantidad supera el stock!'];
            http_response_code(400);
            echo json_encode($resultado['errors']);
        }
    }



    /**
     * Buscar estados de compra
     */
    public function buscarCompraEstado($param = NULL)
    {
        $obj_compraestado = new Model_compraestado();
        $where = " true";

        if (isset($param['idcompraestado'])) {
            $where .= " AND idcompraestado = " . $param['idcompraestado'];
        }
        if (isset($param['idcompra'])) {
            $where .= " AND idcompra = " . $param['idcompra'];
        }
        if (isset($param['idcompraestadotipo'])) {
            $where .= " AND idcompraestadotipo = " . $param['idcompraestadotipo'];
        }
        $compra_estado = $obj_compraestado->Listar($where);
        return $compra_estado;
    }

    /**
     * Busco el item de compra por id_compra y id_producto
     */
    public function buscarCompraItem($param = NULL)
    {
        $obj_compraitem = new Model_compraitem();
        $where = " true";

        if (isset($param['idcompraitem'])) {
            $where .= " AND idcompraitem = " . $param['idcompraitem'];
        }
        if (isset($param['idproducto'])) {
            $where .= " AND idproducto = " . $param['idproducto'];
        }
        if (isset($param['idcompra'])) {
            $where .= " AND idcompra = " . $param['idcompra'];
        }
        $compra_items = $obj_compraitem->Listar($where);
        return $compra_items;
    }

 
    /**
     * Busco el carrito de compras de un usuario específico
     */
    public function buscarCompraCarritoUsuario($id_usuario)
    {
        $where = " idusuario =" . $id_usuario;

        $where .= " AND idcompra IN (SELECT idcompra FROM compraestado WHERE idcompraestadotipo = 1 AND cefechafin IS NULL)";

        $obj_compra = new Model_compra();
        $compras = $obj_compra->Listar($where);

        if ($compras != null) {
            return $compras[0]->getIdCompra();
        } else {
            return '';
        }
    }
}

?>
