<?php
class ControladorCursos
{

    /*Mostrar todos los registros */

    public function index($page)
    {
        /*Validar las credenciales del cliente*/
        $clientes =  ModeloClientes::index("clientes");

        if (isset($_SERVER['PHP_AUTH_USER']) &&  isset($_SERVER['PHP_AUTH_PW'])) {

            foreach ($clientes as $key => $valueCliente) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueCliente["id_cliente"] . ":" . $valueCliente["llave_secreta"])
                ) {

                    if ($page != null) {
                        /*Mostrar cursos con paginacion */
                        $cantidad = 10;
                        $desde = ($page - 1) * $cantidad;
                        $cursos = ModeloCursos::index("cursos", "clientes", $cantidad, $desde);
                    } else {

                        /*Mosstrar todos los cursos */
                        $cursos = ModeloCursos::index("cursos", "clientes", null, null);
                    }
                    if (!empty($cursos)) {
                        $json = array(
                            "status" => 200,
                            "total_registros" => count($cursos),
                            "detalle" => $cursos
                        );
                        echo json_encode($json, true);
                        return;
                    } else {
                        $json = array(
                            "status" => 200,
                            "total_registros" => 0,
                            "detalle" => "No hay ningun curso registrado"
                        );
                        echo json_encode($json, true);
                        return;
                    }
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "El Token es invalido"
                    );
                }
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para recibir los registros"
            );
        }
        echo json_encode($json, true);
        return;
    }

    /*crear cursos */

    public function create($datos)
    {

        /*Validar las credenciales del cliente*/
        $clientes =  ModeloClientes::index("clientes");

        if (isset($_SERVER['PHP_AUTH_USER']) &&  isset($_SERVER['PHP_AUTH_PW'])) {

            foreach ($clientes as $key => $valueCliente) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueCliente["id_cliente"] . ":" . $valueCliente["llave_secreta"])
                ) {
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



                    /*Validacion que el titulo o la descripcion no esten repetidos */
                    $cursos = ModeloCursos::index("cursos", "clientes", null, null);
                    foreach ($cursos as $key => $value) {
                        if ($value->titulo == $datos["titulo"]) {
                            $json = array(
                                "status" => 404,
                                "detalle" => "El titulo ya existe en la base de datos"
                            );
                            echo json_encode($json, true);
                            return;
                        }
                        if ($value->descripcion == $datos["descripcion"]) {
                            $json = array(
                                "status" => 404,
                                "detalle" => "La descripcion ya existe en la base de datos"
                            );
                            echo json_encode($json, true);
                            return;
                        }
                    }

                    /*Llevar datos al modelo*/
                    $datos = array(
                        "titulo" => $datos["titulo"],
                        "descripcion" => $datos["descripcion"],
                        "instructor" => $datos["instructor"],
                        "imagen" => $datos["imagen"],
                        "precio" => $datos["precio"],
                        "id_creador" => $valueCliente['id'],
                        "created_at" => date('Y-m-d h:i:s'),
                        "updated_at" => date('Y-m-d h:i:s'),
                    );



                    $create  = ModeloCursos::create("cursos", $datos);

                    /*Respuesta del modelo */
                    if ($create == "ok") {
                        $json = array(
                            "status" => 200,
                            "detalle" => "Registro exitoso, su curso ha sido guardado"
                        );
                        echo json_encode($json, true);
                        return;
                    }
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "El Token es invalido"
                    );
                }
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para crear cursos"
            );
        }
        echo json_encode($json, true);
        return;
    }

    /*editar cursos */
    public function show($id)
    {
        /*Validar las credenciales del cliente*/
        $clientes =  ModeloClientes::index("clientes");

        if (isset($_SERVER['PHP_AUTH_USER']) &&  isset($_SERVER['PHP_AUTH_PW'])) {

            foreach ($clientes as $key => $valueCliente) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueCliente["id_cliente"] . ":" . $valueCliente["llave_secreta"])
                ) {
                    /*Mosstrar todos los cursos */
                    $curso = ModeloCursos::show("cursos", "clientes", $id);
                    if (!empty($curso)) {
                        $json = array(
                            "status" => 200,
                            "detalle" => $curso
                        );
                        echo json_encode($json, true);
                        return;
                    } else {
                        $json = array(
                            "status" => 200,
                            "total_registros" => 0,
                            "detalle" => "No hay ningun curso registrado"
                        );
                        echo json_encode($json, true);
                        return;
                    }
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "El Token es invalido"
                    );
                }
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para recibir los registros"
            );
        }
        echo json_encode($json, true);
        return;
    }
    /*editar cursos */
    public function update($id, $datos)
    {
        /*Validar las credenciales del cliente*/
        $clientes =  ModeloClientes::index("clientes");

        if (isset($_SERVER['PHP_AUTH_USER']) &&  isset($_SERVER['PHP_AUTH_PW'])) {

            foreach ($clientes as $key => $valueCliente) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueCliente["id_cliente"] . ":" . $valueCliente["llave_secreta"])
                ) {
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

                    /* validar el id creador*/
                    $curso = ModeloCursos::show("cursos", "clientes", $id);
                    foreach ($curso as $key => $valueCurso) {
                        if ($valueCurso->id_creador == $valueCliente["id"]) {

                            /*Llevar datos al modelo*/
                            $datos = array(
                                "id" => $id,
                                "titulo" => $datos["titulo"],
                                "descripcion" => $datos["descripcion"],
                                "instructor" => $datos["instructor"],
                                "imagen" => $datos["imagen"],
                                "precio" => $datos["precio"],
                                "updated_at" => date('Y-m-d h:i:s'),
                            );

                            $update  = ModeloCursos::update("cursos", $datos);

                            /*Respuesta del modelo */
                            if ($update == "ok") {
                                $json = array(
                                    "status" => 200,
                                    "detalle" => "Registro exitoso, su curso ha sido actualizado"
                                );
                                echo json_encode($json, true);
                                return;
                            }
                        } else {
                            $json = array(
                                "status" => 404,
                                "detalle" => "No esta autorizado para modificar este curso"
                            );
                            echo json_encode($json, true);
                            return;
                        }
                    }
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "El Token es invalido"
                    );
                }
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para modificar cursos"
            );
        }
        echo json_encode($json, true);
        return;
    }
    /*borrar cursos */
    public function delete($id)
    {
        /*Validar las credenciales del cliente*/
        $clientes =  ModeloClientes::index("clientes");

        if (isset($_SERVER['PHP_AUTH_USER']) &&  isset($_SERVER['PHP_AUTH_PW'])) {

            foreach ($clientes as $key => $valueCliente) {
                if (
                    "Basic " . base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW']) ==
                    "Basic " . base64_encode($valueCliente["id_cliente"] . ":" . $valueCliente["llave_secreta"])
                ) {


                    /* validar el id creador*/
                    $curso = ModeloCursos::show("cursos", "clientes", $id);
                    foreach ($curso as $key => $valueCurso) {
                        if ($valueCurso->id_creador == $valueCliente["id"]) {



                            $delete  = ModeloCursos::delete("cursos", $id);

                            /*Respuesta del modelo */
                            if ($delete == "ok") {
                                $json = array(
                                    "status" => 200,
                                    "detalle" => "Se ha borrado su curso con exito"
                                );
                                echo json_encode($json, true);
                                return;
                            }
                        } else {
                            $json = array(
                                "status" => 404,
                                "detalle" => "No esta autorizado para borrar este curso"
                            );
                            echo json_encode($json, true);
                            return;
                        }
                    }
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "El Token es invalido"
                    );
                }
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No esta autorizado para modificar cursos"
            );
        }
        echo json_encode($json, true);
        return;
    }
}
