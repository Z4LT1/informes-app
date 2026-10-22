<div align="center">

<img src="imagenes/logo_itred.png" alt="Logo" width="160">

# Informes App

<!-- Una línea que diga qué es el proyecto -->

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL%20%2F%20MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white)

[Demo en vivo](#) · [Capturas](#-capturas) · [Instalación](#-instalación-local)

</div>

---

## 📑 Tabla de contenidos

- [¿Qué es?](#-qué-es)
- [Contexto: práctica profesional](#-contexto-práctica-profesional)
- [Capturas](#-capturas)
- [Funcionalidades](#-funcionalidades)
- [¿Cómo funciona?](#-cómo-funciona)
- [Stack tecnológico](#-stack-tecnológico)
- [Arquitectura y modularidad](#-arquitectura-y-modularidad)
- [Estructura del proyecto](#-estructura-del-proyecto)
- [Estándar de escritura de código](#-estándar-de-escritura-de-código)
- [Base de datos](#-base-de-datos)
- [Instalación local](#-instalación-local)
- [Despliegue](#-despliegue)
- [Seguridad](#-seguridad)
- [Aprendizajes](#-aprendizajes)
- [Mejoras futuras](#-mejoras-futuras)
- [Autor](#-autor)
- [Créditos y licencia](#-créditos-y-licencia)

---

## 📌 ¿Qué es?

<!-- Qué problema resuelve, para quién, en 2–4 líneas -->

## 🏢 Contexto: práctica profesional

<!-- Empresa, rol (Analista Programador), período, qué te pidieron -->

## 📸 Capturas

<!-- Reemplaza las rutas por tus capturas (sugerencia: carpeta docs/capturas/) -->

| Login | Panel | Editor de informe |
|:---:|:---:|:---:|
| ![Login](docs/capturas/login.png) | ![Panel](docs/capturas/panel.png) | ![Portada](docs/capturas/portada.png) |

<!-- Opcional: un GIF corto del flujo completo -->

## ✨ Funcionalidades

<!-- Lista con viñetas -->

-
-
-

## ⚙️ ¿Cómo funciona?

<!-- Flujo del usuario paso a paso -->

```mermaid
flowchart LR
    A[Login] --> B[Panel]
    B --> C[Nuevo informe]
    B --> D[Mis informes]
    C --> E[Editor por secciones]
    D --> E
    E --> F[Exportar]
```

<!-- Explica el diagrama -->

## 🛠️ Stack tecnológico

| Capa | Tecnología | Uso en el proyecto |
|---|---|---|
| Frontend | | |
| Backend | | |
| Base de datos | | |
| Entorno | | |

## 🧩 Arquitectura y modularidad

<!-- Idea principal de la modularidad -->

### Separación por tecnología

<!-- Cada módulo tiene su .php, .css y .js correspondiente -->

| Módulo | PHP | CSS | JS |
|---|---|---|---|
| | | | |

### Componentes de vista

<!-- portada.php como orquestador que incluye portada_vista_*.php -->

### Capa de datos y funciones

<!-- portada_datos.php, portada_funciones.php, portada_exportacion.php -->

## 🗂️ Estructura del proyecto

```text
informes_app/
├── bd/
│   └── informes_app_bd.sql
├── css/programa/
│   ├── login/
│   └── informes/
├── js/programa/
│   ├── login/
│   └── informes/
├── php/programa/
│   ├── login/
│   └── informes/
├── imagenes/
├── documentos/
└── index.php
```

<!-- Breve explicación de cada carpeta -->

## 📐 Estándar de escritura de código

<!-- Reglas que seguías: nomenclatura, comentarios, bloques INICIO/FIN, cabecera, etc. -->

### Nomenclatura

### Comentarios y bloques

```php
/* ------------------------
   -- INICIO NOMBRE BLOQUE --
   ------------------------ */

/* ---------------------
   -- FIN NOMBRE BLOQUE --
   --------------------- */
```

### Clases CSS e IDs

## 🗄️ Base de datos

<!-- Descripción general y relaciones -->

```mermaid
erDiagram
    usuarios ||--o{ informes : crea
    informes ||--o| introduccion : tiene
    informes ||--o| base_datos : tiene
    informes ||--o| documentacion_caso_uso : tiene
    informes ||--o{ caso_uso_imagen : tiene
    informes ||--o{ carpeta_diagramas : tiene
    informes ||--o{ carpeta_informes_programas : tiene
    informes ||--o{ carpeta_pantallazos_programas : tiene
    informes ||--o{ carpeta_rutas_estructurales : tiene
    informes ||--o{ carpeta_fuentes_detalle : tiene
```

## 💻 Instalación local

<!-- Datos útiles: crear BD `informes_app` en phpMyAdmin → importar bd/informes_app_bd.sql → abrir http://localhost/informes_app/
     Usuario demo: demo / demo1234. Sin config.php se usa localhost/root/sin contraseña. -->

### Requisitos

-
-

### Pasos

1.
2.
3.

```bash
# comandos
```

## 🚀 Despliegue

<!-- Dónde está publicado y cómo.
     Datos útiles: copiar php/config/config.example.php como config.php con los datos del hosting,
     o definir variables de entorno DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT. -->

### Credenciales de prueba

| Usuario | Contraseña |
|---|---|
| | |

## 🔐 Seguridad

<!-- Prepared statements, password_hash, sesiones, htmlspecialchars, etc. -->

## 📚 Aprendizajes

<!-- Qué aprendiste en la práctica -->

## 🔭 Mejoras futuras

- [ ]
- [ ]
- [ ]

## 👤 Autor

<!-- Nombre, LinkedIn, correo, portafolio -->

## 📄 Créditos y licencia

<!-- Mención a la empresa y licencia/permiso de publicación -->
