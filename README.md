# Sistema de Gestión de Alumnos y Notas (CRUD)

Aplicación web desarrollada en PHP + MySQL que permite gestionar alumnos y sus notas mediante operaciones CRUD.
El sistema calcula automáticamente el promedio y muestra el resultado cualitativo.

## Funcionalidades

* Registrar alumno
* Editar alumno
* Eliminar alumno (incluye sus notas asociadas)
* Registrar notas (rango 0–10)
* Modificar y eliminar notas
* Cálculo automático del promedio (2 decimales)
* Clasificación cualitativa:
    * 0 – 4.99 → Suspenso
    * 5 – 6.99 → Bien
    * 7 – 8.99 → Notable
    * 9 – 10 → Sobresaliente
* Exportar listado a Excel y PDF
* Confirmaciones con SweetAlert2
* Diseño responsive con Bootstrap

## Tecnologías utilizadas

* PHP
* MySQL
* Bootstrap
* DataTables
* SweetAlert2
* jQuery

## Base de Datos

El proyecto incluye el archivo:

* base_de_datos.sql

## Instalación

* Importar el archivo base_de_datos.sql en MySQL.

* Configurar las credenciales en conexion.php.

* Colocar el proyecto en el servidor local (XAMPP).

* Ejecutar localhost/Sistema_notas/ desde el navegador.

## Proyecto Académico

* Aplicación de Tecnologías Web
* Universidad de las Fuerzas Armadas ESPE – 2026
* Grupo 3

## Integrantes
* Dayra Mosquera
* Evelyn Condoy
* Alejandro Simba
* Darío Castillo