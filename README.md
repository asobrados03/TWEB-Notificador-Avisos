# TWEB Notificador de Avisos
En esta práctica académica realizada en el primer cuatrimestre del curso 2023-2024, saque una nota de 8,9/10.

## Diagrama Entidad-Relación de la Base de Datos de la aplicación

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

    PROFESOR ||--|| PUBLICAR : "1,1"
    PUBLICAR ||--o{ AVISO : "1,N"

    ESTUDIANTE ||--o{ DIRIGIR_A : "1,N"
    DIRIGIR_A ||--|| AVISO : "*"
    DIRIGIR_A {
        boolean Leido
    }

    AVISO {
        date FechaPub
        string Titulo
        string Contenido
        int IDAviso
    }
```

"Explícitamente, se mantiene qué aviso va dirigido a qué estudiante en la relación DIRIGIR_A."
