# Svelt API - Gestión de Aparcamientos

¡Bienvenido/a al repositorio de Svelt API! Este proyecto forma parte de mi proyecto final de grado y tiene como objetivo proporcionar una API para la gestión de aparcamientos. La API está desarrollada utilizando PHP y MySQL.

## Características principales

-   Autenticación de usuarios y roles (Super User y User).
-   Gestión de aparcamientos, incluyendo creación, actualización y eliminación.
-   Consulta de información detallada sobre cada aparcamiento, como ubicación, disponibilidad, horarios, tarifas, etc.
-   Gestión de reservas de plazas de aparcamiento disponibles.
- Operaciones CRUD Correspondientes

## Requisitos previos

Asegúrate de tener los siguientes requisitos previos antes de instalar y ejecutar la API:

-   Servidor web Apache con soporte para PHP: [Apache](https://httpd.apache.org/)
-   MySQL: [MySQL](https://www.mysql.com/)

## Instalación

Sigue estos pasos para instalar la API en tu entorno local:

1.  Clona este repositorio en el directorio raíz de tu servidor web:
    
    `git clone https://github.com/tu-usuario/nombre-del-repositorio.git` 
    
2.  Crea una base de datos en MySQL para la API.
    
3.  Importa el archivo `database.sql` en tu base de datos recién creada.
    
4.  Abre el archivo `env.php` en la raíz del proyecto y actualiza los datos de conexión a la base de datos con los tuyos:
    
    `define('DB_SERVER', 'localhost');
    define('DB_USER', 'tu-usuario');
    define('DB_PASSWD', 'tu-contraseña');
    define('DB_SCHEMA', 'nombre-de-tu-base-de-datos');` 
    

## Configuración

Antes de utilizar la API, asegúrate de configurar correctamente la conexión a la base de datos y otros ajustes necesarios:

1.  Abre el archivo `env.php` en la raíz del proyecto y revisa los valores de las constantes.
2. Para probar la correcta funcionalidad, prueba a hacer un GET a: `localhost/[carpeta-donde-alojes-la-api]/ParkingPlace` con Postman u otra aplicación de gestión de peticiones HTTP

## Uso

Una vez configurada la API, puedes utilizarla para interactuar con la aplicación frontend. Asegúrate de seguir las rutas y estructura de datos adecuadas según la documentación proporcionada en la API.


## Contacto

Si tienes alguna pregunta o sugerencia sobre este proyecto, no dudes en ponerte en contacto conmigo a través de mi dirección de correo electrónico [[averbec580@gmail.com](mailto:averbec580@gmail.com)].

¡Gracias por tu interés! 🙂 
