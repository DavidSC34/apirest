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
                "total_registros" => count($cartelera),
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

    public function update($id, $datos)
    {
        // var_dump($datos['usuarioLogeado']['uid']);
        // var_dump($datos['cartelera']);
        // return;



        /*Validacion datos */
        foreach ($datos['cartelera'] as $key => $valueDatos) {

            if (isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\:\\,\\.\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $valueDatos)) {
                $json = array(
                    "status" => 404,
                    "detalle" => "Error en el campo nombre " . $key
                );
                echo json_encode($json, true);
                return;
            }
        }

        /* validar el id creador*/
        $cartelera  = ModeloCarteleras::show("cartelera", $id);

        foreach ($cartelera as $key => $valueCartelera) {
            if ($valueCartelera->uid == $datos['usuarioLogeado']['uid']) {
                /*Llevar datos al modelo*/
                $datos = array(
                    "id" => $id,
                    "date" => $datos['cartelera']["date"],
                    "country" => $datos['cartelera']["country"],
                    "city" => $datos['cartelera']["city"],
                    "state" => $datos['cartelera']["state"],
                    "commission" => $datos['cartelera']["commission"],
                    "promoter" => $datos['cartelera']["promoter"],
                    "place" => $datos['cartelera']["place"],
                    "uid" => $datos['cartelera']["uid"],
                    "updated_at" => date('Y-m-d h:i:s'),
                );

                $update  = ModeloCarteleras::update("cartelera", $datos);

                /*Respuesta del modelo */
                if ($update == "ok") {
                    $json = array(
                        "status" => 200,
                        "detalle" => "Registro exitoso, su cartelera ha sido actualizada"
                    );
                    echo json_encode($json, true);
                    return;
                }
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No esta autorizado para modificar esta cartelera"
                );
                echo json_encode($json, true);
                return;
            }
        }
    }

    public function delete($id, $datos)
    {
        // var_dump($datos['usuarioLogeado']['uid']);
        // var_dump($datos['cartelera']);
        // return;


        /* validar el id creador*/
        $cartelera  = ModeloCarteleras::show("cartelera", $id);

        foreach ($cartelera as $key => $valueCartelera) {

            if ($valueCartelera->uid == $datos['usuarioLogeado']['uid'] && ($valueCartelera->uid !== " ")) {
                /*Llevar datos al modelo*/
                $datos = array(
                    "id" => $id,
                    "updated_at" => date('Y-m-d h:i:s'),
                );

                $delete  = ModeloCarteleras::delete("cartelera", $datos);

                /*Respuesta del modelo */
                if ($delete == "ok") {
                    $json = array(
                        "status" => 200,
                        "detalle" => "Cartelera eliminada exitosamente"
                    );
                    echo json_encode($json, true);
                    return;
                }
            } else {
                $json = array(
                    "status" => 404,
                    "detalle" => "No esta autorizado para modificar esta cartelera"
                );
                echo json_encode($json, true);
                return;
            }
        }
    }
}
