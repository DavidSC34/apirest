<?php

class ControladorPeleas
{

    public function index($page)
    {
        if ($page != null) {
            /*Mostrar pelas con paginacion */
            $cantidad = 10;
            $desde = ($page - 1) * $cantidad;
            $peleas = ModeloPeleas::index("cartelera_peleas", $cantidad, $desde);
        } else {

            /*Mosstrar todos las peleas */
            $peleas = ModeloPeleas::index("cartelera_peleas", null, null);
        }
        //Verificacion de datos de datos
        if (!empty($peleas)) {
            $json = array(
                "status" => 200,
                "total_registros" => count($peleas),
                "detalle" => $peleas
            );
            echo json_encode($json, true);
            return;
        } else {
            $json = array(
                "status" => 200,
                "total_registros" => 0,
                "detalle" => "No hay ninguna pelea registrada"
            );
            echo json_encode($json, true);
            return;
        }
    }

    public function show($id)
    {
        $pelea = ModeloPeleas::show("cartelera_peleas", $id);
        if (!empty($pelea)) {
            $json = array(
                "status" => 200,
                "detalle" => $pelea
            );
            echo json_encode($json, true);
            return;
        } else {
            $json = array(
                "status" => 200,
                "total_registros" => 0,
                "detalle" => "No hay ninguna pelea registrada"
            );
            echo json_encode($json, true);
            return;
        }
    }

    public function peleaPorCartelera()
    {
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
        $datosModelo = array();
        if ($datos['id_cartelera'] != null && !empty($datos['id_cartelera']) && is_numeric($datos['id_cartelera'])) {
            $datosModelo['id_cartelera'] = $datos['id_cartelera'];
        } else {
            $json = array(
                "status" => 200,
                "total_registros" => 0,
                "detalle" => "Error en el id de cartelera, no es numerico o no esta definida"
            );
            echo json_encode($json, true);
            return;
        }

        if ($datos['rounds'] != null && !empty($datos['rounds']) && is_numeric($datos['rounds']) && $datos['rounds'] <= 12) {
            $datosModelo['rounds'] = $datos['rounds'];
        } else {
            $json = array(
                "status" => 200,
                "total_registros" => 0,
                "detalle" => "Error en rounds, no es numerico o no esta definida o es mayor a 12"
            );
            echo json_encode($json, true);
            return;
        }

        /*Llevar datos al modelo*/
        $datosModelo['champion'] = $datos['champion'];
        $datosModelo['country_champion'] = $datos['country_champion'];
        $datosModelo['result'] = $datos['result'];
        $datosModelo['challenger'] = $datos['challenger'];
        $datosModelo['country_challenger'] = $datos['country_challenger'];
        $datosModelo['gender'] = $datos['gender'];
        $datosModelo['organismo'] = $datos['organismo'];
        $datosModelo['division'] = $datos['division'];
        $datosModelo['title'] = $datos['title'];
        $datosModelo['uid'] = $datos['uid'];
        $datosModelo['status'] = 1;
        $datosModelo['created_at'] = date('Y-m-d h:i:s');
        $datosModelo['updated_at'] = date('Y-m-d h:i:s');

        $create  = ModeloPeleas::create("cartelera_peleas", $datosModelo);

        /*Respuesta del modelo */
        if ($create == "ok") {
            $json = array(
                "status" => 200,
                "detalle" => "Registro exitoso, su pelea ha sido guardada"
            );
            echo json_encode($json, true);
            return;
        }
    }

    public function update()
    {
        //verificar si el usuario que actualiza fue el creador de la pelea
    }

    public function delete()
    {
        //verificar si el usuario que borrar fue el creador de la pelea
    }
}
