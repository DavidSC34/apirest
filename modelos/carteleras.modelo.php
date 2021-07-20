<?php
require_once 'conexion.php';
class ModeloCarteleras
{

    /*Mostrar todos las carteleras */
    static public function index($tabla1, $cantidad, $desde)
    {
        if ($cantidad != null && $desde != null) {
            $stmt = Conexion::conectar()->prepare(" SELECT $tabla1.id_cartelera,$tabla1.date, $tabla1.country, $tabla1.city,$tabla1.state, $tabla1.commission, $tabla1.promoter, $tabla1.place, $tabla1.uid, $tabla1.status FROM $tabla1 WHERE $tabla1.status = 1  LIMIT $desde, $cantidad ");
        } else {

            $stmt = Conexion::conectar()->prepare(" SELECT $tabla1.id_cartelera,$tabla1.date, $tabla1.country, $tabla1.city,$tabla1.state, $tabla1.commission, $tabla1.promoter, $tabla1.place, $tabla1.uid, $tabla1.status   FROM $tabla1 WHERE $tabla1.status = 1");
        }
        // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /*Mostrar una solo cartelera */
    static public function show($tabla1, $id)
    {
        // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=:id");
        $stmt = Conexion::conectar()->prepare(" SELECT $tabla1.id_cartelera,$tabla1.date, $tabla1.country, $tabla1.city,$tabla1.state, $tabla1.commission, $tabla1.promoter, $tabla1.place, $tabla1.uid, $tabla1.status  FROM $tabla1  WHERE $tabla1.id_cartelera=:id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    static public function create($tabla, $datos)
    {
        echo "<pre>";
        print_r($datos);
        echo "</pre>";
        return;
    }
}
