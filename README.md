# 🐳 Guía de Despliegue con Docker (Laravel + Nginx + MySQL)

Esta guía detalla los pasos de instalación y configuración inicial del proyecto utilizando Docker.

## 📋 Requisitos Previos

Asegúrate de tener instalado en tu máquina:

- Git
- Docker y Docker Compose (versión v2 recomendada, usa `docker compose` con espacio)

## 🚀 Pasos de Instalación 

Sigue estos pasos en estricto orden para inicializar el proyecto:

```
# 1. Clonar el repositorio y moverse al directorio
git clone [https://github.com/kurdotex/dev.git](https://github.com/kurdotex/dev.git)
cd dev

# 2. Crear el archivo de variables de entorno (Asegúrate de que DB_HOST=db)
cp .env.example .env

# 3. Levantar los contenedores (app, db, nginx) en segundo plano y reconstruir
# 
docker compose up -d --build

# 4. Ejecutar la configuración inicial DENTRO del contenedor 'app'
# Nota: La ejecución de las migraciones ocurre después de que el entorno está activo.

# Instalar dependencias PHP (Composer) y generar clave
docker compose exec app composer install
docker compose exec app php artisan key:generate

# EJECUTAR MIGRACIONES (Crea las tablas en la DB)
docker compose exec app php artisan migrate

# Generar la documentación Swagger/OpenAPI
docker compose exec app php artisan l5-swagger:generate

# Limpiar caché de configuración
docker compose exec app php artisan config:clear
```

### 💻 Gestión, Pruebas y Acceso
1. Acceso a la Aplicación y Documentación
```
   http://localhost:8000
```

2. Servicio URLAplicación Web (Vue SPA). Documentación API (Swagger)
 ```
 http://localhost:8000/api/documentation
```
 
