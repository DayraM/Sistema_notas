CREATE DATABASE IF NOT EXISTS escuela;
USE escuela;

CREATE TABLE IF NOT EXISTS alumnos (
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  nombre varchar(50) NOT NULL,
  apellido varchar(50) NOT NULL,
  correo varchar(100) NOT NULL,
  telefono varchar(20),
  fecha_nacimiento DATE
);

CREATE TABLE IF NOT EXISTS notas (
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  id_alumno int(11) NOT NULL,
  materia varchar(50) NOT NULL,
  nota decimal(4,2) NOT NULL,
  FOREIGN KEY (id_alumno) REFERENCES alumnos(id)
);