<?php

class ControladorCarteleras
{

    public function index($page)
    {

        if ($page != null) {
            /*Mostrar cursos con paginacion */
            $cantidad = 10;
            $desde = ($page - 1) * $cantidad;
            $carteleras = ModeloCarteleras::index("cartelera", $cantidad, $desde);
        } else {

            /*Mosstrar todos los cursos */
            $carteleras = ModeloCarteleras::index("cartelera", null, null);
        }
        //Verificacion de datos de datos
        if (!empty($carteleras)) {
            $json = array(
                "status" => 200,
                "total_registros" => count($carteleras),
                "detalle" => $carteleras
            );
            echo json_encode($json, true);
            return;
        } else {
            $json = array(
                "status" => 200,
                "total_registros" => 0,
                "detalle" => "No hay ninguna cartelera registrada"
            );
            echo json_encode($json, true);
            return;
        }
    }

    public function show($id)
    {
        $cartelera = ModeloCarteleras::show("cartelera", $id);
        if (!empty($cartelera)) {
            $json = array(
                "status" => 200,
                "detalle" => $cartelera
            );
            echo json_encode($json, true);
            return;
        } else {
            $json = array(
                "status" => 200,
                "total_registros" => 0,
                "detalle" => "No hay ninguna cartelera registrada"
            );
            echo json_encode($json, true);
            return;
        }
    }
}
