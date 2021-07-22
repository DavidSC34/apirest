<?php
require_once 'conexion.php';

class ModeloPeleas{
    static public function index($tabla, $cantidad, $desde){
        if ($cantidad != null && $desde != null) {
            $stmt = Conexion::conectar()->prepare("SELECT $tabla.id, $tabla.id_cartelera, $tabla.champion, $tabla.country_champion, $tabla.result, $tabla.challenger, $tabla.country_challenger, $tabla.gender, $tabla.organismo, $tabla.division, $tabla.title, $tabla.rounds FROM $tabla LIMIT $desde, $cantidad ");
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT $tabla.id, $tabla.id_cartelera, $tabla.champion, $tabla.country_champion, $tabla.result, $tabla.challenger, $tabla.country_challenger, $tabla.gender, $tabla.organismo, $tabla.division, $tabla.title, $tabla.rounds FROM $tabla ");
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    static public function show($tabla, $id){

        $stmt = Conexion::conectar()->prepare("SELECT $tabla.id, $tabla.id_cartelera, $tabla.champion, $tabla.country_champion, $tabla.result, $tabla.challenger, $tabla.country_challenger, $tabla.gender, $tabla.organismo, $tabla.division, $tabla.title, $tabla.rounds FROM $tabla  WHERE id= :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}