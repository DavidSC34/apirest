<?php


$arrayRutas = explode('/', $_SERVER['REQUEST_URI']);


if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $carteleras = new ControladorCarteleras();
    $carteleras->index($_GET["page"]);
} else {

    if (count(array_filter($arrayRutas)) === 0) {
        /*cunado no se hace nunguna peticio a la API */
        $json = array(
            "detalle" => "Peticion invalida"
        );
        echo json_encode($json, true);
        return;
    } else {

        if (count(array_filter($arrayRutas)) === 1) {
            /*cuando se hacen peticiones de registros*/
            if (array_filter($arrayRutas)[1] == "registro") {

                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                    //Capturar datos 
                    $datos = array(
                        "nombre" => $_POST["nombre"],
                        "apellido" => $_POST["apellido"],
                        "email" => $_POST["email"]
                    );
                    $registro = new ControladorClientes();
                    $registro->create($datos);
                } else {
                    $json = array(
                        "detalle" => "no encontrado"
                    );
                    echo json_encode($json, true);
                    return;
                }
            } elseif (array_filter($arrayRutas)[1] == "cursos") {
                /* PETICIONES GET*/
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                    $cursos = new ControladorCursos();
                    $cursos->index(null);
                }
                /* PETICIONES POST*/ elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                    /*Capturar datos*/

                    $datos = array(
                        "titulo" => $_POST["titulo"],
                        "descripcion" => $_POST["descripcion"],
                        "instructor" => $_POST["instructor"],
                        "imagen" => $_POST["imagen"],
                        "precio" => $_POST["precio"],
                    );


                    $crearCurso = new ControladorCursos();
                    $crearCurso->create($datos);
                } else {
                    $json = array(
                        "detalle" => "no encontrado"
                    );
                    echo json_encode($json, true);
                    return;
                }
            } elseif (array_filter($arrayRutas)[1] == "carteleras") {
                /*checar el tipo de peticion http */
                /* PETICIONES GET*/
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {


                    $carteleras = new ControladorCarteleras();
                    $carteleras->index(null);
                } elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

                     /*Capturar datos */
                     $datos = array();
                     $datos = json_decode(file_get_contents('php://input'),true);

                    // $datos = array(
                    //     "date" => $_POST["date"],
                    //     "country" => $_POST["country"],
                    //     "city" => $_POST["city"],
                    //     "state" => $_POST["state"],
                    //     "commission" => $_POST["commission"],
                    //     "promoter" => $_POST["promoter"],
                    //     "place" => $_POST["place"],
                    //     "uid" => $_POST["uid"],
                    //     "status" => 1,
                    // );


                    $crearCartelera = new ControladorCarteleras();
                    $crearCartelera->create($datos);
                } else {
                    $json = array(
                        "detalle" => "Peticion invalida"
                    );
                    echo json_encode($json, true);
                    return;
                }
            } elseif (array_filter($arrayRutas)[1] == "peleas") {

                /*checar el tipo de peticion http */
                /* PETICIONES GET*/
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                    $peleas = new ControladorPeleas();
                    $peleas->index(null);
                }
                /* PETICIONES POST*/ elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                    $datos = array(
                        "id_cartelera" => $_POST['id_cartelera'],
                        "champion" => $_POST['champion'],
                        "country_champion" => $_POST['country_champion'],
                        "result" => $_POST['result'],
                        "challenger" => $_POST['challenger'],
                        "country_challenger" => $_POST['country_challenger'],
                        "gender" => $_POST['gender'],
                        "organismo" => $_POST['organismo'],
                        "division" => $_POST['division'],
                        "title" => $_POST['title'],
                        "rounds" => $_POST['rounds'],
                        "uid" => $_POST['uid'],

                    );

                    $crearPelea = new ControladorPeleas();
                    $crearPelea->create($datos);
                } else {
                    $json = array(
                        "detalle" => "Peticion invalida"
                    );
                    echo json_encode($json, true);
                    return;
                }
            } else {
                $json = array(
                    "detalle" => "no encontrado en peticiones"
                );
                echo json_encode($json, true);
                return;
            }
        } else {
            /*cuado se hacen péticiones de un solo curso*/
            if (array_filter($arrayRutas)[1] == "cursos" && is_numeric(array_filter($arrayRutas)[2])) {
                /* PETICIONES GET*/
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                    $curso = new ControladorCursos();
                    $curso->show(array_filter($arrayRutas)[2]);
                }
                /** PETICIONES PUT */
                elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {

                    /*Capturar datos */
                    $datos = array();
                    parse_str(file_get_contents('php://input'), $datos);

                    $editarCurso = new ControladorCursos();
                    $editarCurso->update(array_filter($arrayRutas)[2], $datos);
                }
                /** PETICIONES DELETE */
                elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                    $borrarCurso = new ControladorCursos();
                    $borrarCurso->delete(array_filter($arrayRutas)[2]);
                } else {
                    /*Metodo no encontrado */
                    $json = array(
                        "detalle" => "no encontrado"
                    );
                    echo json_encode($json, true);
                    return;
                }
            } elseif (array_filter($arrayRutas)[1] == "carteleras" && is_numeric(array_filter($arrayRutas)[2])) {
                /**  PETICIONES GET */
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                    $cartelera = new ControladorCarteleras();
                    $cartelera->show(array_filter($arrayRutas)[2]);
                }
                /**  PETICIONES PUT */
                elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
                    /*Capturar datos */
                    $datos = array();
                    parse_str(file_get_contents('php://input'), $datos);

                    $editarCartelera = new ControladorCarteleras();
                    $editarCartelera->update(array_filter($arrayRutas)[2], $datos);
                }
                /**  PETICIONES DELETE */
                elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                    /*Capturar datos */
                    $datos = array();
                    parse_str(file_get_contents('php://input'), $datos);
                    $borrarCartelera = new ControladorCarteleras();
                    $borrarCartelera->delete(array_filter($arrayRutas)[2], $datos);
                }
                /**  PETICIONES INVALIDAS */
                else {
                    /*Metodo no encontrado */
                    $json = array(
                        "detalle" => "no encontrado"
                    );
                    echo json_encode($json, true);
                    return;
                }
            } elseif (array_filter($arrayRutas)[1] == "peleas" && is_numeric(array_filter($arrayRutas)[2])) {

                /* PETICIONES GET*/
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                    $pelea = new ControladorPeleas();
                    $pelea->show(array_filter($arrayRutas)[2]);
                }
                /**PETICIONES PUT */
                elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
                    /*Capturar datos */
                    $datos = array();
                    parse_str(file_get_contents('php://input'), $datos);

                    $editarPelea = new ControladorPeleas();
                    $editarPelea->update(array_filter($arrayRutas)[2], $datos);
                }
                /**PETICIONES DELETE */
                elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                    /*Capturar datos */
                    $datos = array();
                    parse_str(file_get_contents('php://input'), $datos);
                    $borrarPelea = new ControladorPeleas();
                    $borrarPelea->delete(array_filter($arrayRutas)[2], $datos);
                }
                /**METODO NO ENCONTRADO PARA LAS PELEAS */
                else {
                    /*Metodo no encontrado */
                    $json = array(
                        "detalle" => "no encontrado"
                    );
                    echo json_encode($json, true);
                    return;
                }
            }
            /** PETICIONES DE PELEAS POR CARTELERA */
            elseif (array_filter($arrayRutas)[1] == "pelea-cartelera" && is_numeric(array_filter($arrayRutas)[2])) {
                /** PETICIONES GET */
                if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {

                    $peleaCartelera = new ControladorPeleas();
                    $peleaCartelera->showPeleaCartelera(array_filter($arrayRutas)[2]);
                }
                /**METODO NO ENCONTRADO PARA LAS PELEAS */
                else {
                    /*Metodo no encontrado */
                    $json = array(
                        "detalle" => "Peticion no encontrado"
                    );
                    echo json_encode($json, true);
                    return;
                }
            } else {
                /*Metodo si no pide cursos y no es un numero  */
                $json = array(
                    "detalle" => "no encontrado"
                );
                echo json_encode($json, true);
                return;
            }
        }
    }
}
