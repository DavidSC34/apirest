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

    public function show($id){
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

    public function peleaPorCartelera(){}

    public function create($datos){
        /*Validacion datos */

        if($datos['id_cartelera'] == null || empty($datos['id_cartelera']) ){
            
        }

        /*Llevar datos al modelo*/
    }

    public function update(){}

    public function delete(){}
}
