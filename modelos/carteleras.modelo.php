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

    /*Mostrar una sola cartelera */
    static public function show($tabla1, $id)
    {
        // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=:id");
        $stmt = Conexion::conectar()->prepare(" SELECT $tabla1.id_cartelera,$tabla1.date, $tabla1.country, $tabla1.city,$tabla1.state, $tabla1.commission, $tabla1.promoter, $tabla1.place, $tabla1.uid, $tabla1.status  FROM $tabla1  WHERE $tabla1.id_cartelera=:id ");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
    static public function create($tabla, $datos)
    {
        // echo "<pre>";
        // print_r($datos);
        // echo "</pre>";
        // return;
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (date, country, city, state, commission, promoter, place, uid, status, created_at, updated_at) VALUES (:date, :country, :city, :state, :commission, :promoter, :place, :uid, :status, :created_at, :updated_at)");

        $stmt->bindParam(":date", $datos["date"], PDO::PARAM_STR);
        $stmt->bindParam(":country", $datos["country"], PDO::PARAM_STR);
        $stmt->bindParam(":city", $datos["city"], PDO::PARAM_STR);
        $stmt->bindParam(":state", $datos["state"], PDO::PARAM_STR);
        $stmt->bindParam(":commission", $datos["commission"], PDO::PARAM_STR);
        $stmt->bindParam(":promoter", $datos["promoter"], PDO::PARAM_STR);
        $stmt->bindParam(":place", $datos["place"], PDO::PARAM_STR);
        $stmt->bindParam(":uid", $datos["uid"], PDO::PARAM_STR);
        $stmt->bindParam(":status", $datos["status"], PDO::PARAM_STR);
        $stmt->bindParam(":created_at", $datos["created_at"], PDO::PARAM_STR);
        $stmt->bindParam(":updated_at", $datos["updated_at"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt = null;
    }

    static public function update($tabla, $datos)
    {
        // echo "<pre>";
        // print_r($datos);
        // echo "</pre>";
        // return;
        $stmt = Conexion::conectar()->prepare(" UPDATE $tabla SET date=:date,country=:country,city=:city,state=:state,commission=:commission,promoter=:promoter,place=:place,status=:status,updated_at=:updated_at  WHERE $tabla.id_cartelera = :id ");

        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":date", $datos["date"], PDO::PARAM_STR);
        $stmt->bindParam(":country", $datos["country"], PDO::PARAM_STR);
        $stmt->bindParam(":city", $datos["city"], PDO::PARAM_STR);
        $stmt->bindParam(":state", $datos["state"], PDO::PARAM_STR);
        $stmt->bindParam(":commission", $datos["commission"], PDO::PARAM_STR);
        $stmt->bindParam(":promoter", $datos["promoter"], PDO::PARAM_STR);
        $stmt->bindParam(":place", $datos["place"], PDO::PARAM_STR);
        $stmt->bindParam(":status", $datos["status"], PDO::PARAM_STR);
        $stmt->bindParam(":updated_at", $datos["updated_at"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt = null;
    }

    static public function delete($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare(" UPDATE $tabla SET status=0,updated_at=:updated_at  WHERE $tabla.id_cartelera = :id ");

        $stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
        $stmt->bindParam(":updated_at", $datos['updated_at'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt = null;
    }
}
