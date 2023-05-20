<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Nombre de la Aplicación</title>
</head>

<body>
    <h1>Reto tecnico</h1>

    <p>Laravel 10 + Vue 3 + tailwind</p>

    <h2>Requisitos Previos</h2>

    <p>Asegúrate de tener instalados los siguientes requisitos previos antes de continuar:</p>

    <ul>
        <li>PHP >= 8</li>
        <li>Composer</li>
        <li>MySQL o cualquier otro sistema de gestión de bases de datos compatible</li>
        <li>Git</li>
    </ul>

    <h2>Clonar el Repositorio</h2>

    <ol>
        <li>Abre una terminal o línea de comandos en tu máquina local.</li>
        <li>Navega hasta el directorio donde deseas clonar el repositorio.</li>
        <li>Ejecuta el siguiente comando para clonar el repositorio:</li>
    </ol>

    <pre><code>git clone &lt;URL del repositorio&gt;</code></pre>

    <p>Una vez completado, navega al directorio de la aplicación:</p>

    <pre><code>cd nombre-de-la-aplicacion</code></pre>

    <h2>Instalar Dependencias</h2>

    <ol>
        <li>Asegúrate de estar en el directorio raíz de la aplicación.</li>
        <li>Ejecuta el siguiente comando para instalar las dependencias de Composer:</li>
    </ol>

    <pre><code>composer install</code></pre>

    <h2>Configurar el Entorno</h2>

    <ol>
        <li>Copia el archivo <code>.env.example</code> y renómbralo como <code>.env</code>.</li>
        <li>Abre el archivo <code>.env</code> y configura las variables de entorno, como la conexión a la base de datos y las credenciales del servicio de correo electrónico.</li>
        <li>Genera una nueva clave de aplicación ejecutando el siguiente comando:</li>
    </ol>

    <pre><code>php artisan key:generate</code></pre>

    <h2>Ejecutar Migraciones y Semillas</h2>

    <ol>
        <li>Ejecuta las migraciones para configurar la base de datos ejecutando el siguiente comando:</li>
    </ol>

    <pre><code>php artisan migrate</code></pre>

    <ol start="2">
        <li>Si la aplicación utiliza semillas (seeds) para generar datos de prueba, ejecuta el siguiente comando:</li>
    </ol>

    <pre><code>php artisan db:seed</code></pre>

    <h2>Iniciar el Servidor</h2>

    <ol>
        <li>Para iniciar el servidor de desarrollo de Laravel, ejecuta el siguiente comando:</li>
    </ol>

    <pre><code>php artisan serve</code></pre>

    <p>Ahora puedes acceder a la aplicación en tu navegador web utilizando la URL proporcionada por el servidor de desarrollo.</p>

    <h2>Contribución</h2>

    <p>Si deseas contribuir a este proyecto, sigue los siguientes pasos:</p>

