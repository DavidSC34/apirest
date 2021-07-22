<?php

require_once "controladores/rutas.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/cursos.controlador.php";
require_once "controladores/carteleras.controlador.php";
require_once "controladores/peleas.controlador.php";

require_once "modelos/clientes.modelo.php";
require_once "modelos/cursos.modelo.php";
require_once "modelos/carteleras.modelo.php";
require_once "modelos/peleas.modelo.php";

$rutas = new controladorRutas();
$rutas->index();
