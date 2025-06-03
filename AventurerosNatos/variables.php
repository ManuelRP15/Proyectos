<?php
// Definición de variables
$host = "ip_de_tu_servidor";
$user = "usuario_de_tu_servidor";
$password = "contrasenia_de_tu_servidor";
$bbdd = "base_de_datos_de_tu_servidor";

// Codigos HTTP
$headerJSON = 'Content-Type: application/json';
$codigosHTTP = [
    "200" => "HTTP/1.1 200 OK",
    "201" => "HTTP/1.1 201 Created",
    "202" => "HTTP/1.1 202 Accepted",
    "400" => "HTTP/1.1 400 Bad Request",
    "404" => "HTTP/1.1 404 Not Found",
    "500" => "HTTP/1.1 500 Internal Server Error"
];
