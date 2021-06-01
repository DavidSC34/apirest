<?php


$arrayRutas = explode('/', $_SERVER['REQUEST_URI']);

if (count(array_filter($arrayRutas)) === 0) {
    /*cunado no se hace nunguna peticio a la API */
    $json = array(
        "detalle" => "no encontrado"
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
                $cursos->index();
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
        } else {
            $json = array(
                "detalle" => "no encontrado"
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
            /* PETICIONES PUT*/ elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {

                /*Capturar datos */
                $datos = array();
                parse_str(file_get_contents('php://input'), $datos);

                $editarCurso = new ControladorCursos();
                $editarCurso->update(array_filter($arrayRutas)[2], $datos);
            }

            /* PETICIONES DELETE*/ elseif (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
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
