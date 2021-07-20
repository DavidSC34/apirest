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

    public function create($datos)
    {
        /*Validacion datos */
        foreach ($datos as $key => $valueDatos) {

            if (isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\:\\,\\.\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $valueDatos)) {
                $json = array(
                    "status" => 404,
                    "detalle" => "Error en el campo nombre " . $key
                );
                echo json_encode($json, true);
                return;
            }
        }
        /*Llevar datos al modelo*/
        $datos = array(
            "date" => $datos["date"],
            "country" => $datos["country"],
            "city" => $datos["city"],
            "state" => $datos["state"],
            "commission" => $datos["commission"],
            "promoter" => $datos["promoter"],
            "place" => $datos["place"],
            "uid" => $datos["uid"],
            "status" => 1,
            "created_at" => date('Y-m-d h:i:s'),
            "updated_at" => date('Y-m-d h:i:s'),
        );

        $create  = ModeloCarteleras::create("cartelera", $datos);

        /*Respuesta del modelo */
        if ($create == "ok") {
            $json = array(
                "status" => 200,
                "detalle" => "Registro exitoso, su cartelera ha sido guardado"
            );
            echo json_encode($json, true);
            return;
        }
    }
}
