# Guía de Despliegue en Render

Este archivo contiene instrucciones para desplegar tu aplicación Laravel en Render.

## Requisitos previos

1. Una cuenta en [Render.com](https://render.com)
2. Tu código versionado en GitHub
3. El archivo `render.yaml` incluido en el repositorio

## Pasos para desplegar

### 1. Preparar el repositorio

Asegúrate de que tu código esté en GitHub:

```bash
git add .
git commit -m "Preparar para despliegue en Render"
git push origin main
```

### 2. Conectar con Render

1. Ve a [dashboard.render.com](https://dashboard.render.com)
2. Haz clic en **New +** → **Web Service**
3. Selecciona **Connect a repository**
4. Busca tu repositorio de GitHub y conéctalo
5. Render debería detectar automáticamente el archivo `render.yaml`

### 3. Configurar variables de entorno

En el panel de Render, establece estas variables de entorno:

| Variable | Valor |
|----------|-------|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | (Se genera automáticamente) |
| `DB_CONNECTION` | `sqlite` |
| `DB_DATABASE` | `storage/database.sqlite` |
| `LOG_CHANNEL` | `stderr` |

> En Render, la ruta dentro del repositorio puede no ser escribible. Usa `storage/database.sqlite` y crea el archivo en el arranque para que SQLite pueda escribir el archivo.

**Nota**: Si necesitas una base de datos MySQL/PostgreSQL, puedes crear un servicio de base de datos en Render y actualizar las credenciales en el archivo `render.yaml`.

### 4. Iniciar el despliegue

1. Haz clic en **Create Web Service**
2. Render ejecutará automáticamente:
   - `composer install`
   - `npm install`
   - `npm run build`
   - `php artisan migrate --force`
   - Iniciará el servidor

El despliegue tardará 5-10 minutos. Una vez completado, verás la URL de tu aplicación.

## Soluciones de problemas comunes

### Error: "Procfile not found"
Esto se resuelve con el archivo `render.yaml`. Asegúrate de que esté en la raíz del repositorio.

### Base de datos vacía
Si migraste pero la base de datos está vacía, puedes ejecutar seeders en Render:
- En el panel de Render, ve a **Shell**
- Ejecuta: `php artisan db:seed`

### Cambios no se reflejan
Render redesplegará automáticamente cuando hagas push a la rama principal:
```bash
git add .
git commit -m "Cambios"
git push origin main
```

## Usar una base de datos PostgreSQL o MySQL

Si prefieres usar PostgreSQL/MySQL en lugar de SQLite:

1. En Render, crea un servicio **PostgreSQL** o **MySQL**
2. Copia las credenciales de conexión
3. Actualiza el archivo `render.yaml`:

```yaml
envVars:
  - key: DB_CONNECTION
    value: pgsql  # o mysql
  - key: DB_HOST
    value: <host>
  - key: DB_PORT
    value: <port>
  - key: DB_DATABASE
    value: <database>
  - key: DB_USERNAME
    value: <username>
  - key: DB_PASSWORD
    value: <password>
```

4. Haz push de los cambios:
```bash
git add render.yaml
git commit -m "Usar PostgreSQL/MySQL en Render"
git push origin main
```

## Acceder a logs

En el panel de Render:
1. Ve a **Logs** para ver los logs en tiempo real
2. O usa **Shell** para ejecutar comandos directamente

## Más información

- [Documentación de Render](https://render.com/docs)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
