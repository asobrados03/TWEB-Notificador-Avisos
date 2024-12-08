# [TECNOLOGÍAS WEB] Notificador de Avisos
En esta práctica académica realizada en el primer cuatrimestre del curso 2023-2024, obtuve una calificación de 8,9/10.
A continuación se mostrarán los diagramas realizados para el diseño de esta aplicación de notificación de avisos. El primer diagrama es un diagrama entidad-relación que modela el diseño conceptual de la base de datos que requiere la base de datos de la aplicación web, los otros dos diagramas son diagramas basados en la metodología UWE (UML-Based Web Engineering), la cual se utiliza para el diseño de aplicaciones web orientadas a servicios. Estos diagramas están enfocados en modelar tanto la estructura de la base de datos como las interacciones entre los usuarios y el sistema. A través de estos diagramas, se pretende visualizar de manera clara cómo los diferentes componentes de la aplicación interactúan entre sí y cómo se gestionan los avisos dentro de la plataforma.

## Diagrama Entidad-Relación de la Base de Datos de la aplicación
El diagrama entidad-relación presenta el modelo conceptual de la base de datos, describiendo las entidades principales (USUARIO, ESTUDIANTE, PROFESOR y AVISO) y sus relaciones. DIRIGIR_A es una relación entre ESTUDIANTE y AVISO que incluye un atributo Leido, indicando si el estudiante ha leído el aviso. El diagrama también muestra cómo los ESTUDIANTES reciben AVISOS, cómo la entidad USUARIO se divide en ESTUDIANTE y PROFESOR, con roles distintos en el sistema y el hecho de que el PROFESOR publica avisos en la plataforma para sus alumnos (representado en la relación PUBLICAR).

```mermaid
erDiagram
    USUARIO {
        string Email
        string Contrasena
        string Login
        string Nombre
        int NIA
    }

    %% Relación jerárquica
    USUARIO ||--o| PROFESOR : "Es un"
    USUARIO ||--o| ESTUDIANTE : "Es un"

    %% Relaciones entre las entidades
    PROFESOR ||--|| PUBLICAR : "1,1"
    PUBLICAR ||--o{ AVISO : "1,N"
    ESTUDIANTE ||--o{ DIRIGIR_A : "1,N"
    DIRIGIR_A ||--o{ AVISO : "1,N"

    %% Relación DIRIGIR_A con atributo
    DIRIGIR_A {
        boolean Leido
    }

    %% Entidades
    AVISO {
        date FechaPub
        string Titulo
        string Contenido
        int IDAviso
    }
```

"(En la relación "DIRIGIR_A") Explícitamente, se mantiene qué aviso va dirigido a qué estudiante."

| IDAviso | IDAlumno |
|---------|----------|
|    1    |    1     |
|    2    |    1     |
|    2    |    2     |

## Diagramas UWE
Los diagramas UWE se utilizan para diseñar aplicaciones web mediante la representación de clases y sus interacciones dentro del sistema. Esta metodología facilita la creación de aplicaciones web de manera estructurada y organizada, abordando tanto las interfaces como la lógica de negocio.

### Diagrama de navegación UWE
El diagrama de navegación UWE describe la estructura de navegación dentro de una aplicación web. Este modelo es útil para representar cómo los usuarios pueden moverse entre las diferentes partes de la aplicación, conectando los componentes de contenido y procesamiento de manera coherente. A continuación, detallo su aplicación en el diseño de la solución:
UWE propone otro modelo interesante, el modelo de navegabilidad, que es útil para representar cómo navegar dentro de la app, introduciendo componentes de navegabilidad: menús, índices, y procesos, que luego se traduce en componentes HTML concretos (por ejemplo, un menú aquí se traducirá en una barra de navegación HTML, es decir, en una lista (```<ul>```), cuyos elementos (```<li>```) son enlaces (```<a>```), asociados a cada opción del menú), y permite distribuir la navegabilidad entre las diferentes acciones, ya sean de contenido o de procesamiento.
En la app hay tres grandes paquetes funcionales:

- Gestión de usuarios (login, restablecer contraseña, logout...).
- Gestión de estudiantes (registrar estudiante, ...).
- Gestión de avisos (publicar aviso, importar avisos, leer aviso, ...).

Las funcionalidades están distribuidas entre ambos perfiles de usuario. Basándonos en el modelo de contenido (específicamente en lo relacionado con los avisos, si nos enfocamos en la gestión de estos), una posible representación de la navegabilidad sería:

```mermaid
graph TD
    %% Menú principal de navegación
    Menu_Usuario[[&lt;&lt;menu&gt;&gt;
    Menú Usuario]]
    Menu_Usuario_Estudiante[[&lt;&lt;menu&gt;&gt;
    Menú Usuario Estudiante]]
    Menu_Usuario_Profesor[[&lt;&lt;menu&gt;&gt;
    Menú Usuario Profesor]]

    Menu_Usuario_Estudiante --> Filtro_Aviso
    Menu_Usuario_Profesor --> Filtro_Aviso
    Menu_Usuario_Profesor --> Importar_Aviso
    Menu_Usuario_Profesor --> Publicar_Aviso

    %% Gestión de Avisos
    subgraph "GESTIÓN DE AVISOS"
        %% Para el Estudiante
        Indice_Avisos_Estudiante[[&lt;&lt;index&gt;&gt;
        Índice Avisos]]
        Filtro_Aviso[[&lt;&lt;query&gt;&gt;
        Filtro Aviso]]
        Aviso_Estudiante[[&lt;&lt;nav class&gt;&gt;
        Aviso]]
        
        %% Para el Profesor
        Indice_Avisos_Profesor[[&lt;&lt;index&gt;&gt;
        Índice Avisos]]
        Aviso_Profesor[[&lt;&lt;nav class&gt;&gt;
        Aviso]]
        Publicar_Aviso[[&lt;&lt;process class&gt;&gt;
        Publicar Aviso]]
        Importar_Aviso[[&lt;&lt;process class&gt;&gt;
        Importar Aviso]]

        %% Relaciones para el Estudiante
        Indice_Avisos_Estudiante --> Aviso_Estudiante
        Filtro_Aviso --> Indice_Avisos_Estudiante
        

        %% Relaciones para el Profesor
        Filtro_Aviso --> Indice_Avisos_Profesor
        Publicar_Aviso --> Indice_Avisos_Profesor
        Indice_Avisos_Profesor --> Aviso_Profesor
        Importar_Aviso --> Publicar_Aviso
    end

    %% Relaciones entre menús y componentes
    Menu_Usuario --> Menu_Usuario_Estudiante:::nav_link
    Menu_Usuario --> Menu_Usuario_Profesor:::nav_link

    %% Flujo entre componentes de gestión de avisos para el Estudiante
    Menu_Usuario_Estudiante --> Indice_Avisos_Estudiante:::nav_link_yellow

    %% Flujo entre componentes de gestión de avisos para el Profesor
    Menu_Usuario_Profesor --> Indice_Avisos_Profesor:::process_link

    %% Estilos opcionales para diferenciar elementos
    classDef nav_link fill:#f9f,stroke:#333,stroke-width:2px;
    classDef process_link fill:#ff9,stroke:#333,stroke-width:2px;
    classDef nav_link_yellow fill:#ff9,stroke:#333,stroke-width:2px;
```

#### Nota adicional:
"Este diagrama puede completarse incluyendo acciones de cada perfil para la gestión de Estudiantes dentro del menú correspondiente y acciones de la gestión de usuarios dentro del menú de usuario."

### Diagrama de clases UWE
Este diagrama describe las clases principales del sistema y sus relaciones. Se visualizan los actores involucrados, como el Notificador, que es responsable de gestionar los avisos, y las clases de usuario como Estudiante. Las clases muestran sus métodos y atributos, reflejando cómo interactúan dentro de la aplicación. Además, el diagrama incluye las relaciones entre las clases, como la acción de registrar o publicar, lo que permite ver cómo los usuarios y los avisos interactúan con el sistema.

#### DIAGRAMA MODELO CONTENIDO (Metodología UWE)
A partir del diagrama E-R considerado, podemos considerar que nuestra app debe gestionar/presentar contenido sobre **usuarios** (en particular, estudiantes) y **avisos**, lo cual puede representarse mediante el siguiente diagrama de clases:

```mermaid
classDiagram
    class Notificador {
    }
    class Estudiante {
    }
    class Aviso {
    }

    class App {
        "Representa nuestra app."
    }

    App -- Notificador
    Notificador --> Estudiante : registrar *
    Notificador --> Aviso : publicar *
```
## Conclusión

Este proyecto refleja un enfoque estructurado y metódico en el diseño y desarrollo de aplicaciones web orientadas a servicios. A través del uso de diagramas E-R y la metodología UWE, se ha logrado visualizar cómo interactúan los diferentes componentes del sistema, facilitando la implementación y el mantenimiento del mismo. La calificación obtenida en esta práctica es un reflejo del esfuerzo invertido y del aprendizaje adquirido.
## Agradecimientos

Agradezco a mis profesores y compañeros por su apoyo y orientación durante el desarrollo de esta práctica. Sus aportes han sido fundamentales para el éxito de este proyecto.
## Contribuciones

Si deseas contribuir a este proyecto, no dudes en hacer un fork del repositorio, proponer mejoras o reportar problemas. ¡Toda ayuda es bienvenida!
## Contacto

Para cualquier consulta o comentario sobre este proyecto, puedes contactarme a través de mi perfil de GitHub.
