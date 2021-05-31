<?php

class ControladorClientes
{

    /*Crea un registro*/

    public function create($datos)
    {
        //Validacion de nombre

        if (isset($datos["nombre"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["nombre"])) {
            $json = array(
                "status" => 404,
                "detalle" => "Error en el campo nombre, solo se permiten letras"
            );
            echo json_encode($json, true);
            return;
        }
        //Validacion apellido

        if (isset($datos["apellido"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $datos["apellido"])) {
            $json = array(
                "status" => 404,
                "detalle" => "Error en el campo apellido, solo se permiten letras"
            );
            echo json_encode($json, true);
            return;
        }
        //Validacion del apellido
        if (isset($datos["email"]) && !preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $datos["email"])) {
            $json = array(
                "status" => 404,
                "detalle" => "Error en el campo email, coloca un email valido"
            );
            echo json_encode($json, true);
            return;
        }

        //Validar email no este repetido

        $clientes =  ModeloClientes::index("clientes");
        foreach ($clientes as $key => $value) {
            if ($value['email'] == $datos['email']) {
                $json = array(
                    "status" => 404,
                    "detalle" => "El email ya existe en la base de datos"
                );
                echo json_encode($json, true);
                return;
            }
        }

        //Generar credenciales del cliente
        //insertar el signo $ tiene problema al generar el token
        $id_cliente = str_replace("$", "a", crypt($datos["nombre"] . $datos["apellido"] . $datos["email"], '$2a$07$dfasdfesergsrg4545ADss$'));
        $llave_secreta = str_replace("$", "o", crypt($datos["email"] . $datos["apellido"] . $datos["nombre"], '$2a$07$dfasdfesergsrg4545ADss$'));

        /****
         * llevar datos al modelo
         */
        $datos = array(
            "nombre" => $datos["nombre"],
            "apellido" => $datos["apellido"],
            "email" => $datos["email"],
            "id_cliente" => $id_cliente,
            "llave_secreta" => $llave_secreta,
            "created_at" => date('Y-m-d h:i:s'),
            "updated_at" => date('Y-m-d h:i:s')
        );

        $create = ModeloClientes::create("clientes", $datos);

        /****
         * Respuest del modelo
         */

        if ($create == "ok") {
            $json = array(
                "status" => 200,
                "detalle" => "Registro exitoso, tome sus credenciales y guardelas",
                "credenciales" => array("id_cliente" => $id_cliente, "llave_secreta" => $llave_secreta)
            );
            echo json_encode($json, true);
            return;
        }
    }
}
