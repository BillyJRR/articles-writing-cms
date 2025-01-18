Fase 1

-   Paginación
    Para mejorar la experiencia de los usuarios y optimizar la carga de la página, he implementado la paginación en las rutas que manejan grandes volúmenes de datos. Esta técnica permite dividir los resultados en varias páginas, lo que reduce el tiempo de carga al limitar la cantidad de datos enviados en cada solicitud. La paginación es especialmente útil para las listas de artículos o productos, donde el número de elementos puede ser muy alto.

-   Protección contra Scraping (Bots)
    Para evitar que bots o scripts automáticos realicen scraping de la web o la API, he implementado una estrategia de limitación de solicitudes (throttling) en las rutas más críticas. Utilizando Route::middleware('throttle:60,1'), he establecido un límite de 60 solicitudes por minuto para cada cliente, lo que reduce el riesgo de que un bot sobrecargue el servidor con solicitudes excesivas.

Fase 2

    En esta fase tuve que crear algunas tablas nuevas. Usé migraciones para generar la tabla drafts (borradores) y otra llamada draft_category para manejar la relación entre los borradores y las categorías. También preparé un seed para pasar la información de la tabla articles a drafts y a draft_category, asegurando que las categorías quedaran bien relacionadas.
    Además, creé el controlador, modelo, servicio, repositorio y request para drafts, agregando toda la lógica necesaria para manejar los borradores. Tuve que actualizar las rutas y crear nuevas vistas, incluyendo botones para gestionar todo lo relacionado con los borradores de manera sencilla.

Fase 3

    En esta fase creé dos tablas (article_author y draft_author) para gestionar las relaciones entre artículos, borradores y autores. También generé un seed que migra la información de las tablas articles y drafts, asegurando que los autores quedaran correctamente asociados.
    Modifiqué los modelos para reflejar estas nuevas relaciones y también ajusté los requests, servicios, repositorios y controladores para que todo funcione bien con las nuevas estructuras. En las vistas, agregué un selector múltiple para los autores y actualicé el código para mostrar más de un autor cuando sea necesario.

Fase 4

    En esta última fase se agrego una API REST para que puedan publicar notas de manera automática, para ello se creo una api en el archivo api.php además de creo su propio controlador con su respectivo request, service y repositorio.

    # API Documentation
    Esta API permite publicar notas.

    #Endpoints
    Ruta: /api/post-article
    Método HTTP: POST
    Descripción: Crea y publicar la nota.

    #Headers:
    - Content-Type: multipart/form-data

    #Parámetros
    #Request Body (Payload)
    El cuerpo de la solicitud debe ser enviado como `multipart/form-data` para incluir la imagen y los demás parámetros. El cuerpo debe contener los siguientes campos:
    {
        "title": "Introducción a Laravel",
        "body": "Laravel es un framework PHP para el desarrollo de aplicaciones web que sigue el patrón MVC. Este artículo cubre los conceptos básicos de Laravel.",
        "authors": [3],
        "categories": [1,2,3],
        "image": //file
    }

Preguntas adicionales

    *¿Por qué crees que no debería permitirse la actualización del slug de un artículo una vez publicada la nota?

    El slug es parte de la URL, y si cambias la URL después de que el artículo ha sido publicado, los enlaces que ya han sido compartidos o guardados en otros sitios dejarán de funcionar, lo que puede confundir a los usuarios y hacer que lleguen a páginas de error

    *¿Qué otras consideraciones propondrías para la escalabilidad del CMS? ya sea debido a un aumento de requests al sistema como cuando empezamos a tener bastante data en la BD.

    A medida que la base de datos crece, las consultas pueden volverse más lentas. Usar índices en las columnas más consultadas y paginación para cargar menos datos a la vez ayudará a mejorar la velocidad.

    Guardar en caché datos que no cambian frecuentemente, como artículos populares o categorías, hará que el sistema sea más rápido y reduzca la carga en la base de datos.

Como levantar el proyecto usando docker

    1. Una vez descargado el proyecto, abrelo en Visual Code, abre la terminal y ejecuta el comando:
        docker compose up -d --build
    2. Luego descargamos las dependencias con los siguientes comando:
        docker compose exec app composer install
        npm install
    3. A continuación creamos el archivo .env en la raiz del proyecto, abrimos el archivo .env.example copiamos su contenido en el archivo .env y realizamos las siguientes modificaciones:
        DB_CONNECTION=mysql
        DB_HOST=db
        DB_PORT=3306
        DB_DATABASE=db_laravel_cms
        DB_USERNAME=root
        DB_PASSWORD=root
    4. Generamos nuestra key para el proyecto ejecutando el comando:
        docker compose exec app php artisan key:generate
    5. Ahora ejecutamos el siguiente codigo para habilitar el acceso públicamente a los archivos almacenados en la carpeta storage/app/public para lo que es la visibilidad de las imagenes:
        docker compose exec app php artisan storage:link
    6. Ahora para compilar los archivos CSS (y también JavaScript), necesitas ejecutar el comando:
        npm run build
    7. Ahora ejecutamos las migraciones y los seeders:
        docker compose exec app php artisan migrate --seed
    8. Si en caso te salga error al probar la api, ejecuta el siguiente comando:
        docker compose exec app php artisan install:api
    9. Y listo, eso es todo, a continuación dejo las rutas actuales que puedes usar:
        http://localhost:8080 -> tu base de datos en mysql
        http://localhost/articles -> para visualizar los articulos
        http://localhost/admin-cms/drafts -> para agregar nuevos borradores y publicarlos
