🚀Guía: Desplegar una aplicación PHP + MySQL (Docker Compose) en Render

🧩Objetivo



Publicar en internet una aplicación web PHP + MySQL que ya funciona en GitHub Codespaces, obteniendo una URL del tipo:



https://tu-app.onrender.com

🧰Requisitos previos



Tener una cuenta gratuita en Render.



Tener el repositorio de tu aplicación en GitHub, visible públicamente.

El repositorio debe incluir:



Dockerfile (para PHP)

docker-compose.yml

Código PHP (por ejemplo, index.php, conexion.php, etc.)

🧱Preparar los archivos



Render no usa directamente docker-compose.yml, sino un servicio principal (web) y, si hace falta, una base de datos separada.



Un ejemplo funcional 👇



FROM php:8.2-apache



\# Instala extensiones necesarias

RUN docker-php-ext-install pdo pdo\_mysql



\# Copia los archivos del proyecto

COPY . /var/www/html/



EXPOSE 80

⚙️Subir tu repositorio a GitHub



Si ya lo tienes, asegúrate de que:



&#x20;Es público.

Tiene el Dockerfile en la raíz del proyecto.

🌐Crear la base de datos MySQL en Render



Entra en https://dashboard.render.com

Haz clic en New + → PostgreSQL / MySQL Database

Elige MySQL

Asigna un nombre (por ejemplo: miapp-db)

Espera unos segundos mientras Render crea la base de datos

Guarda los datos de conexión:

Host

Usuario

Contraseña

Nombre de base de datos

Puerto

🧩Crear el servicio web (PHP)



En el mismo panel de Render, haz clic en New + → Web Service

Conecta tu cuenta de GitHub

Selecciona tu repositorio con el proyecto

En los campos de configuración:

Root directory: deja vacío (si el Dockerfile está en la raíz)

Environment: Docker

Build Command: deja vacío

Start Command: Render lo infiere del Dockerfile

Crea el servicio y espera que construya la imagen (puede tardar 3–5 minutos la primera vez).

🧩Configurar las variables de entorno



En la pestaña Environment del servicio (en Render):



Agrega las siguientes variables según tu conexión MySQL:







Tu archivo conexion.php debería leerlas así :



<?php

$host = getenv('DB\_HOST');

$db   = getenv('DB\_NAME');

$user = getenv('DB\_USER');

$pass = getenv('DB\_PASSWORD');

$port = getenv('DB\_PORT');



try {

&#x20;   $conn = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);

&#x20;   $conn->setAttribute(PDO::ATTR\_ERRMODE, PDO::ERRMODE\_EXCEPTION);

} catch (PDOException $e) {

&#x20;   echo "❌ Error de conexión: " . $e->getMessage();

}

?>

🧠Probar la aplicación



Una vez Render haya desplegado tu contenedor, aparecerá una URL del tipo:



https://tu-app.onrender.com

Haz clic ahí y deberías ver tu página index.php funcionando y conectada a MySQL.

🎉 ¡Tu aplicación está en línea permanentemente!



⚠️Notas



Render pone en reposo los servicios gratuitos si no se usan durante 15 min, pero se reactivan al acceder a la URL.

Puedes ver los logs de despliegue en la pestaña Logs.

Si cambia la contraseña o base de datos, solo actualizan las variables de entorno.

🧾Resumen



GitHub (repositorio público)

&#x20;   ↓

Render (importa el repositorio)

&#x20;   ↓

Crea base de datos MySQL

&#x20;   ↓

Configura variables de entorno

&#x20;   ↓

URL pública: https://tu-app.onrender.com

