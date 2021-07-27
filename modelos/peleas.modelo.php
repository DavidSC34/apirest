<?php
require_once 'conexion.php';

class ModeloPeleas
{
    static public function index($tabla, $cantidad, $desde)
    {
        if ($cantidad != null && $desde != null) {
            $stmt = Conexion::conectar()->prepare("SELECT $tabla.id, $tabla.id_cartelera, $tabla.champion, $tabla.country_champion, $tabla.result, $tabla.challenger, $tabla.country_challenger, $tabla.gender, $tabla.organismo, $tabla.division, $tabla.title, $tabla.rounds, $tabla.status FROM $tabla LIMIT $desde, $cantidad ");
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT $tabla.id, $tabla.id_cartelera, $tabla.champion, $tabla.country_champion, $tabla.result, $tabla.challenger, $tabla.country_challenger, $tabla.gender, $tabla.organismo, $tabla.division, $tabla.title, $tabla.rounds, $tabla.status FROM $tabla ");
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function show($tabla, $id)
    {

        $stmt = Conexion::conectar()->prepare("SELECT $tabla.id, $tabla.id_cartelera, $tabla.champion, $tabla.country_champion, $tabla.result, $tabla.challenger, $tabla.country_challenger, $tabla.gender, $tabla.organismo, $tabla.division, $tabla.title, $tabla.rounds, $tabla.status, $tabla.uid, $tabla.created_at, $tabla.updated_at FROM $tabla  WHERE id= :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function showPeleaCartelera($tabla, $tabla2, $id)
    {
        $stmt = Conexion::conectar()->prepare(" SELECT $tabla.id, $tabla.id_cartelera, $tabla.champion, $tabla.country_champion, $tabla.result, $tabla.challenger, $tabla.country_challenger, $tabla.gender, $tabla.organismo, $tabla.division, $tabla.title, $tabla.rounds, $tabla.status, $tabla.uid, $tabla.created_at, $tabla.updated_at, $tabla2.date, $tabla2.country, $tabla2.city, $tabla2.state,$tabla2.commission FROM $tabla INNER JOIN $tabla2 ON $tabla.id_cartelera = $tabla2.id_cartelera WHERE $tabla.id_cartelera=:id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    static public function create($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_cartelera, champion, country_champion, result, challenger, country_challenger, gender, organismo, division, title, rounds, uid, status, created_at, updated_at) VALUES (:id_cartelera, :champion, :country_champion, :result, :challenger, :country_challenger, :gender, :organismo, :division, :title, :rounds, :uid, :status, :created_at, :updated_at)");

        $stmt->bindParam(":id_cartelera", $datos['id_cartelera'], PDO::PARAM_INT);
        $stmt->bindParam(":champion", $datos['champion'], PDO::PARAM_STR);
        $stmt->bindParam(":country_champion", $datos['country_champion'], PDO::PARAM_STR);
        $stmt->bindParam(":result", $datos['result'], PDO::PARAM_STR);
        $stmt->bindParam(":challenger", $datos['challenger'], PDO::PARAM_STR);
        $stmt->bindParam(":country_challenger", $datos['country_challenger'], PDO::PARAM_STR);
        $stmt->bindParam(":gender", $datos['gender'], PDO::PARAM_STR);
        $stmt->bindParam(":organismo", $datos['organismo'], PDO::PARAM_STR);
        $stmt->bindParam(":division", $datos['division'], PDO::PARAM_STR);
        $stmt->bindParam(":title", $datos['title'], PDO::PARAM_STR);
        $stmt->bindParam(":rounds", $datos['rounds'], PDO::PARAM_INT);
        $stmt->bindParam(":uid", $datos['uid'], PDO::PARAM_STR);
        $stmt->bindParam(":status", $datos['status'], PDO::PARAM_INT);
        $stmt->bindParam(":created_at", $datos['created_at'], PDO::PARAM_STR);
        $stmt->bindParam(":updated_at", $datos['updated_at'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt = null;
    }

    static public function update($tabla, $datos)
    {


        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_cartelera=:id_cartelera,champion=:champion,country_champion=:country_champion,result=:result,challenger=:challenger,country_challenger=:country_challenger,gender=:gender,organismo=:organismo,division=:division,title=:title,rounds=:rounds,updated_at=:updated_at WHERE id=:id");

        $stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
        $stmt->bindParam(":id_cartelera", $datos['id_cartelera'], PDO::PARAM_INT);
        $stmt->bindParam(":champion", $datos['champion'], PDO::PARAM_STR);
        $stmt->bindParam(":country_champion", $datos['country_champion'], PDO::PARAM_STR);
        $stmt->bindParam(":result", $datos['result'], PDO::PARAM_STR);
        $stmt->bindParam(":challenger", $datos['challenger'], PDO::PARAM_STR);
        $stmt->bindParam(":country_challenger", $datos['country_challenger'], PDO::PARAM_STR);
        $stmt->bindParam(":gender", $datos['gender'], PDO::PARAM_STR);
        $stmt->bindParam(":organismo", $datos['organismo'], PDO::PARAM_STR);
        $stmt->bindParam(":division", $datos['division'], PDO::PARAM_STR);
        $stmt->bindParam(":title", $datos['title'], PDO::PARAM_STR);
        $stmt->bindParam(":rounds", $datos['rounds'], PDO::PARAM_INT);
        $stmt->bindParam(":updated_at", $datos['updated_at'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt = null;
    }
    static public function delete($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET status=:status,updated_at=:updated_at WHERE id=:id");

        $stmt->bindParam(":id", $datos['id'], PDO::PARAM_INT);
        $stmt->bindParam(":status", $datos['status'], PDO::PARAM_INT);
        $stmt->bindParam(":updated_at", $datos['updated_at'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt = null;
    }
}
