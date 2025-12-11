# 🐳 Guía de Despliegue con Docker (Laravel + Nginx + MySQL)

Esta guía detalla los pasos para levantar el entorno de desarrollo local utilizando Docker. El entorno incluye:

- **App:** PHP 8.3 (Laravel)
- **Web Server:** Nginx (Alpine)
- **Database:** MySQL 8.0

---

## 📋 Requisitos Previos

Asegúrate de tener instalado en tu máquina:

- Git
- Docker y Docker Compose (versión v2 recomendada, usa `docker compose` con espacio)

---

## 🚀 Pasos de Instalación

Sigue estos pasos en orden si acabas de clonar el repositorio:

---

### 1. Clonar el repositorio

Abre tu terminal y descarga el proyecto:

```
git clone https://github.com/kurdotex/dev.git
cd dev
```

## Configurar las variables de entorno

Crear el archivo .env

```
cp .env.example .env
```

## Configura el archivo .env:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```

## Levantar los contenedores

```
docker compose up -d --build
```

## Instalar dependencias y configurar Laravel

```
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan l5-swagger:generate
```

🌐 Acceso a la Aplicación

| Servicio                    | URL                                                                                |
| --------------------------- | ---------------------------------------------------------------------------------- |
| Aplicación Web              | [http://localhost:8000](http://localhost:8000)                                     |
| Documentación API (Swagger) | [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation) |


📚 Documentación del Proyecto

Para ver Swagger:
http://localhost:8000/api/documentation

## Regenerar la documentación:
```
docker compose exec app php artisan l5-swagger:generate
```


## 💻 Gestión, Pruebas y Debugging

### 1. Entrar al Contenedor de la Aplicación (PHP/Laravel)

Para ejecutar comandos de Artisan o Composer dentro del entorno de PHP:
```
sudo docker compose exec app bash
```

### 2. Ejecutar Pruebas PHPUnit

Utiliza el binario de PHPUnit instalado para correr los tests funcionales y unitarios.

**Desde dentro del contenedor (una vez ejecutado el comando anterior):**
```
./vendor/bin/phpunit
```

## 🌐 Acceso a la Aplicación

| Servicio | URL |
| :--- | :--- |
| Aplicación Web | [http://localhost:8000](http://localhost:8000) |
| Documentación API (Swagger) | [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation) |

### Regenerar la documentación:
```
docker compose exec app php artisan l5-swagger:generate
```
