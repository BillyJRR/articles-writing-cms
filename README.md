Fase 1

-   Paginación
    Para mejorar la experiencia de los usuarios y optimizar la carga de la página, he implementado la paginación en las rutas que manejan grandes volúmenes de datos. Esta técnica permite dividir los resultados en varias páginas, lo que reduce el tiempo de carga al limitar la cantidad de datos enviados en cada solicitud. La paginación es especialmente útil para las listas de artículos o productos, donde el número de elementos puede ser muy alto.

-   Protección contra Scraping (Bots)
    Para evitar que bots o scripts automáticos realicen scraping de la web o la API, he implementado una estrategia de limitación de solicitudes (throttling) en las rutas más críticas. Utilizando Route::middleware('throttle:60,1'), he establecido un límite de 60 solicitudes por minuto para cada cliente, lo que reduce el riesgo de que un bot sobrecargue el servidor con solicitudes excesivas.

Fase 2

    En esta fase tuve que crear algunas tablas nuevas. Usé migraciones para generar la tabla drafts (borradores) y otra llamada draft_category para manejar la relación entre los borradores y las categorías. También preparé un seed para pasar la información de la tabla articles a drafts y a draft_category, asegurando que las categorías quedaran bien relacionadas.
    Además, creé el controlador, modelo, servicio, repositorio y request para drafts, agregando toda la lógica necesaria para manejar los borradores. Tuve que actualizar las rutas y crear nuevas vistas, incluyendo botones para gestionar todo lo relacionado con los borradores de manera sencilla.
