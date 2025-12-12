# 🐳 Guía de Despliegue con Docker (Laravel + Nginx + MySQL)

Esta guía detalla los pasos de instalación y configuración inicial del proyecto utilizando Docker.

## 📋 Requisitos Previos

Asegúrate de tener instalado en tu máquina:

- Git
- Docker y Docker Compose (versión v2 recomendada, usa `docker compose` con espacio)


## ⚙️ Valores Clave del Archivo .env (Docker y Base de Datos)

| Variable | Valor de Desarrollo Típico | Notas Importantes (Docker) |
| :--- | :--- | :--- |
| `APP_ENV` | `local` | Entorno de la aplicación. |
| `APP_DEBUG` | `true` | Muestra errores detallados. |
| `DB_CONNECTION` | `mysql` | Driver de la base de datos. |
| `DB_HOST` | **`db`** | **Debe ser el nombre del servicio** del contenedor MySQL, NO `localhost`.  |
| `DB_PORT` | `3306` | Puerto de la base de datos. |
| `DB_DATABASE` | `laravel` | Nombre de la base de datos. |
| `DB_USERNAME` | `root` | Usuario de la base de datos. |
| `DB_PASSWORD` | `secret` | Contraseña de la base de datos. |
| `APP_URL` | `http://localhost:8000` | URL base de la aplicación. |


## 🚀 Pasos de Instalación 

Sigue estos pasos en estricto orden para inicializar el proyecto:


# 1. Clonar el repositorio y moverse al directorio
```
git clone [https://github.com/kurdotex/dev.git](https://github.com/kurdotex/dev.git)
cd dev
```

# 2. Crear el archivo de variables de entorno (Asegúrate de que DB_HOST=db)
```
cp .env.example .env
```

# 3. Levantar los contenedores (app, db, nginx) en segundo plano y reconstruir
```
docker compose up -d --build
```

# 4. Ejecutar la configuración inicial DENTRO del contenedor 'app'
# Nota: La ejecución de las migraciones ocurre después de que el entorno está activo.

# Instalar dependencias PHP (Composer) y generar clave
```
docker compose exec app composer install
docker compose exec app php artisan key:generate
```

# EJECUTAR MIGRACIONES (Crea las tablas en la DB)
```
docker compose exec app php artisan migrate
```

# Generar la documentación Swagger/OpenAPI
```
docker compose exec app php artisan l5-swagger:generate
```

# Limpiar caché de configuración
```
docker compose exec app php artisan config:clear
```

### 💻 Gestión, Pruebas y Acceso
1. Url Base API
   http://localhost:8000/api


2. Documentación API (Swagger)
 http://localhost:8000/api/documentation

 
### Ejecutar Pruebas PHPUnit
 ```
docker compose exec app ./vendor/bin/phpunit
```
