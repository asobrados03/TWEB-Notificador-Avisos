# [TECNOLOGÍAS WEB] Notificador de Avisos
En esta práctica académica realizada en el primer cuatrimestre del curso 2023-2024, obtuve una calificación de 8,9/10.
A continuación se mostrarán los diagramas realizados para el diseño de esta aplicación de notificación de avisos. El primer diagrama es un diagrama entidad-relación que modela el diseño conceptual de la base de datos que requiere la base de datos de la aplicación web, los otros dos diagramas son diagramas basados en la metodología UWE (UML-Based Web Engineering), la cual se utiliza para el diseño de aplicaciones web orientadas a servicios. Estos diagramas están enfocados en modelar tanto la estructura de la base de datos como las interacciones entre los usuarios y el sistema. A través de estos diagramas, se pretende visualizar de manera clara cómo los diferentes componentes de la aplicación interactúan entre sí y cómo se gestionan los avisos dentro de la plataforma.

## Enunciado de la práctica [Notificador Avisos TWEB]

### Descripción General

La aplicación web permite a los profesores de Tecnologías Web notificar avisos a sus alumnos. Los avisos son pequeños elementos de información con un título o asunto descriptivo y un contenido informativo breve (máximo 150 caracteres). Los avisos pueden ser colectivos, dirigidos a todos los alumnos de la asignatura (por ejemplo, la comunicación de un cambio de laboratorio, fecha de examen, etc.) o individuales, dirigidos específicamente a cada estudiante (por ejemplo, la comunicación de una nota individual de un examen, la configuración personal de su máquina virtual, etc.).

### Perfiles de Usuario

1. **Profesor**
2. **Estudiante**

### Características de los Usuarios

- Nombre
- Correo electrónico (para login)
- NIA (Número Identificación Alumno) único de 4 cifras
  - Estudiantes: 100-9999
  - Profesores: 1-99
  - NIA 0 reservado para otros usos (p.e. Administrador del sistema)

### Diagrama de Casos de Uso

```mermaid
graph TD
    A[Usuario estudiante] --> B(Login)
    A --> C(Consultar avisos)
    A --> D(Restablecer contraseña)
    C --> E(Filtrar avisos)
    F[Usuario profesor] --> B
    F --> C
    F --> G(Registrar estudiante)
    F --> H(Publicar aviso)
    F --> I(Importar avisos)
    I --> J(Recibir y verificar archivo avisos)
```

### Descripción de Casos de Uso

#### Login
Cualquier Usuario (ya sea estudiante o profesor) tendrá que identificarse en el sistema, indicando su nombre de usuario (su email) y su contraseña para acceder.

#### Consultar avisos
Un Usuario estudiante o profesor podrá consultar los avisos publicados. En el caso del Usuario estudiante, se llevará cuenta de los avisos ya leídos o no, para presentar los no leídos de forma resaltada.

#### Filtrar avisos
La lista de los avisos publicados se podrá filtrar por, al menos, un filtro, el que se considere más adecuado para cada perfil (por ejemplo, leído o no para el Usuario estudiante, y destinatario para el Usuario profesor).

#### Restablecer contraseña
Un Usuario estudiante podrá restablecer su contraseña.

#### Registrar estudiante
Un Usuario profesor podrá registrar a los estudiantes. Cada uno de ellos tendrá un NIA único y una dirección de correo electrónico válida, además de su nombre completo. El profesor asignará una contraseña inicial que el estudiante podrá modificar.

#### Publicar aviso
Un Usuario profesor podrá publicar un aviso dirigido bien a todos los alumnos o a uno específico (de los registrados en el momento de publicar el aviso). El aviso tendrá un asunto y un breve contenido (de no más de 150 caracteres) y se registrará la fecha de publicación.

#### Importar avisos
El Usuario profesor podrá subir al servidor un fichero de texto en el que, en cada línea, podrá incluir un aviso a enviar. Esta opción será útil para automatizar el envío masivo de avisos a los estudiantes. El archivo subido tendrá formato de texto .CSV (utilizando el separador punto y coma), teniendo los siguientes campos: NIA; nombreEstudiante; asunto; contenido.

#### Recibir y verificar archivo avisos
La aplicación estará preparada para recibir, almacenar y procesar el archivo de importación recibido, verificando la correcta sintaxis del archivo e informando de los posibles errores sintácticos.

### Consideraciones Adicionales

- El diseño del front-end (lado cliente) de la aplicación web DEBERÁ SER responsive.
- Se valorará positivamente que el front-end (lado cliente) de la aplicación sea lo más interactivo posible.
- Se valorará positivamente la seguridad de la aplicación (hasheado y fortaleza de contraseñas, conexión segura, prevención inyección de código y validación).

## Diagrama Entidad-Relación de la Base de Datos de la aplicación
El diagrama entidad-relación presenta el modelo conceptual de la base de datos, describiendo las entidades principales (USUARIO, ESTUDIANTE, PROFESOR y AVISO) y sus relaciones. DIRIGIR_A es una relación entre ESTUDIANTE y AVISO que incluye un atributo Leido, indicando si el estudiante ha leído el aviso. El diagrama también muestra cómo los ESTUDIANTES reciben AVISOS, cómo la entidad USUARIO se divide en ESTUDIANTE y PROFESOR, con roles distintos en el sistema y el hecho de que el PROFESOR publica avisos en la plataforma para sus alumnos (representado en la relación PUBLICAR).

```mermaid
erDiagram
    USUARIO {
        integer NIA PK
        string Nombre
        string Email
        string Contrasenia
    }
    AVISO {
        integer IDAviso PK
        integer Profesor FK
        string Titulo
        string Contenido
    }
    DIRIGIR_A_ESTUDIANTE {
        integer Estudiante PK, FK
        integer Aviso PK, FK
        enum Leido
    }

    USUARIO ||--o| AVISO : Publica
    AVISO ||--o| DIRIGIR_A_ESTUDIANTE : Dirige_a
    USUARIO ||--o| DIRIGIR_A_ESTUDIANTE : Recibe
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

> [!NOTE]
> "Este diagrama puede completarse incluyendo acciones de cada perfil para la gestión de Estudiantes dentro del menú correspondiente y acciones de la gestión de usuarios dentro del menú de usuario."

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
Basándome en el contenido del documento proporcionado, el procedimiento para preparar el entorno de trabajo y ejecutar el proyecto se describe claramente. A continuación, adapto la sección "Instrucciones de instalación" del README.md para reflejar estos pasos:

## Instrucciones de instalación

### Pre-requisitos
Antes de comenzar, asegúrate de contar con:
1. Una máquina virtual (o física) con **Ubuntu 20.04**.
2. Acceso al sistema operativo a través de un cliente SSH.
3. Un navegador web para probar la aplicación.

### Preparación del entorno
1. **Instalación del sistema operativo y protocolo SSH**
   - Instala Ubuntu 20.04 en la máquina virtual.
   - Durante la instalación, habilita el protocolo SSH para acceder al sistema de manera remota.

2. **Instalar el entorno LAMP (Linux, Apache, MySQL, PHP)**
   Sigue los pasos detallados del tutorial de Digital Ocean [aquí](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04-es).

   - **Paso 1: Instalar Apache**
     ```bash
     sudo apt update
     sudo apt install apache2
     ```
   - **Paso 2: Instalar MySQL**
     ```bash
     sudo apt install mysql-server
     sudo mysql_secure_installation
     ```
   - **Paso 3: Instalar PHP**
     ```bash
     sudo apt install php libapache2-mod-php php-mysql
     ```

3. **Configurar directorios para la aplicación**
   - Crear un directorio específico para la aplicación en `/var/www/mi_dominio`:
     ```bash
     sudo mkdir /var/www/mi_dominio
     ```
   - Agrega tus archivos HTML y PHP al directorio creado.

4. **Activar directorios personales en Apache**
   - Habilita el módulo `userdir` para permitir directorios públicos en cada usuario:
     ```bash
     sudo a2enmod userdir
     ```
   - Reinicia Apache para aplicar los cambios:
     ```bash
     sudo systemctl restart apache2
     ```
   - Crea un directorio `public_html` en tu directorio personal y añade los archivos `index.html` e `index.php`:
     ```bash
     mkdir ~/public_html
     ```

### Probar la instalación
1. Accede a los archivos HTML y PHP:
   - **Archivo HTML:** [http://dominio:puerto/~usuarioMaquinaVirtual/](http://dominio:puerto/~usuarioMaquinaVirtual/)
   - **Archivo PHP:** [http://dominio:puerto/~usuarioMaquinaVirtual/index.php](http://dominio:puerto/~usuarioMaquinaVirtual/index.php)
> [!CAUTION]
> El dominio indicado en la URL es la dirección web donde hayas alojado tu máquina virtual o el dominio donde hayas desplegado el proyecto. En el caso de que hayas desplegado el proyecto en local el dominio es localhost o la IP 127.0.0.1 (que es el localhost). El puerto debes indicarlo tú manualmente en la instalación.

## Agradecimientos

Agradezco a mis profesores y compañeros por su apoyo y orientación durante el desarrollo de esta práctica. Sus aportes han sido fundamentales para el éxito de este proyecto.
## Contribuciones

Si deseas contribuir a este proyecto, no dudes en hacer un fork del repositorio, proponer mejoras o reportar problemas. ¡Toda ayuda es bienvenida!
## Contacto

Para cualquier consulta o comentario sobre este proyecto, puedes contactarme a través de mi perfil de GitHub.
