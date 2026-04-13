# 🚗 FinishLine - Guía del proyecto

## Configuración del servidor
1. `docker-compose.yml` → Le dice a Docker qué servicios levantar (nginx, php, MySQL)
2. `Dockerfile` → Le dice a Docker cómo construir el contenedor PHP
3. `nginx/default.conf` → Configura el servidor web

## Base de datos
1. `src/init.sql` → Crea las tablas al arrancar por primera vez
2. `src/conexion.php` → Se conecta a MySQL, lo usan todos los PHP

## Páginas de la web
1. `src/index.php` → Página principal
2. `src/login.php` → Formulario de inicio de sesión
3. `src/registro.php` → Formulario de registro
4. `src/servicios.php` → Lista los servicios del taller
5. `src/galeria.php` → Galería de trabajos
6. `src/tickets.php` → Ver y crear citas/presupuestos

## ⚠️ Proceso para cada miembro del equipo
1. Hacer `git clone` del repositorio
2. Copiar `.env.example` y renombrarlo a `.env`
3. Rellenar las contraseñas en `.env`
4. Arrancar Docker con `docker-compose up --build`
5. Abrir el navegador en `http://localhost:8080`


## usuario.php
Lo que hace cada método:
   Método                          Función

registrar()-------------------> Crea el hash de la contraseña y guarda el usuario
login()-----------------------> Busca el usuario y verifica la contraseña
existeCorreo()----------------> Previene registros duplicados

## AuthController.php
Lo que hace cada método:
    Método                                Función

registro()-----------------> Valida datos y registra el usuario
login()--------------------> Verifica credenciales y crea la sesión
logout()-------------------> Destruye la sesión y redirige al login
verificarSesion()----------> Protege páginas que requieren login