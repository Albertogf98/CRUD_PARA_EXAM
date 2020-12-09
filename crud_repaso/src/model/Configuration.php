<?php
define("HOST","mysql:host=vps-08d8b3f2.vps.ovh.net;dbname=usuariosRepaso");
define("USER","alberto");
define("PASSWORD","12345tren");
define("DATABASE","usuariosRepaso");
define("USERS","usuarios");
define("CITY","ciudad");
define("COUNTRY","pais");
define("PAGINATION_LIMIT", 4);

const create_database = "CREATE DATABASE IF NOT EXISTS ".DATABASE;
const create_country_table = "CREATE TABLE IF NOT EXISTS ". COUNTRY ."(
        id_pais INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nombre VARCHAR(50))";

const create_city_table = "CREATE TABLE IF NOT EXISTS ". CITY ."(
        id_ciudad INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nombre VARCHAR(50), 
        codPais INT(11),
        FOREIGN KEY (codPais) REFERENCES ". COUNTRY ."(id_pais))";

const create_users_table = "CREATE TABLE IF NOT EXISTS ". USERS ."(
        id_usuario INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        dni CHAR(9),
        nombre VARCHAR(100),
        apellidos VARCHAR(100),
        usuario VARCHAR(100),
        edad DATE, 
        codCiudad INT(11), 
        FOREIGN KEY (codCiudad) REFERENCES ". CITY ."(id_ciudad))";


const sql_select_users = "SELECT u.*, ci.nombre AS cityName, co.nombre AS countryName 
FROM ". USERS ." u INNER JOIN " . CITY ." ci ON  u.codCiudad = ci.id_ciudad INNER JOIN 
  ". COUNTRY ." co ON ci.codPais = co.id_pais ORDER BY u.id_usuario 
DESC LIMIT ?, ?";

const sql_count = "SELECT count(*) FROM ".USERS;

function selectUserById($id) {
    return "SELECT u.*, ci.nombre AS cityName, co.nombre AS countryName 
FROM ". USERS ." u INNER JOIN " . CITY ." ci ON  u.codCiudad = ci.id_ciudad INNER JOIN 
  ". COUNTRY ." co ON ci.codPais = co.id_pais WHERE id_usuario= '$id'";
}

const select_city = "SELECT * FROM ". CITY;












/*const sql_insert_country = "INSERT INTO ". COUNTRY ." (nombre) VALUES
                                                    ('España'), ('Autria'), ('Grecia'), ('Alemania'), ('Italia')";


const sql_insert_city = "INSERT INTO ". CITY ." (nombre, codPais) VALUES 
                                                    ('Madrid', 1), ('Málaga', 1), 
                                                    ('Viena', 2), ('Graz', 2), 
                                                    ('Atenas', 3), ('Patras', 3), 
                                                    ('Viena', 4), ('Graz', 4),                                                   
                                                    ('Roma', 5), ('Nápoles', 5)";

const sql_insert_users = "INSERT INTO ". USERS ." (dni, nombre, apellidos, usuario ,edad, codCiudad) VALUES 
                                                    ('2487714c',  'Belén', 'Jiménez Ranchal','CrossingBlogger','2001-12-10', 1), 
                                                    ('77147852g', 'Alberto', 'Gandoy Florido','sparz98' ,'1998-02-01', 2), 
                                                    ('77147852z', 'Rocío', 'Reina Olivos', 'pijita95' ,'1995-08-28', 3), 
                                                    ('77147852ñ', 'Facundo', 'De Nardo','rockStart','1991-06-16', 5)";*/

?>