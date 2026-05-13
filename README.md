# Insta API

API de backend para una aplicación estilo Instagram construida con Laravel.

## Qué se ha hecho

- Creación de endpoints de autenticación con Sanctum:
  - `POST /api/register`
  - `POST /api/login`
  - `POST /api/logout`
  - `GET /api/me`
- Implementación de usuarios y perfiles:
  - Modelo `User` con `name`, `email`, `password` y `username`.
  - Relación `User -> Profile`.
- Endpoint para listar usuarios:
  - `GET /api/users`
  - Soporta búsqueda con parámetro `search`
  - Devuelve datos de perfil, conteo de posts, y estado de amistad.
- Publicaciones, comentarios y likes:
  - `GET /api/posts`
  - `POST /api/posts`
  - `GET /api/posts/{post}`
  - `DELETE /api/posts/{post}`
  - `GET /api/posts/{post}/comments`
  - `POST /api/posts/{post}/comments`
  - `POST /api/posts/{post}/like`
  - `DELETE /api/posts/{post}/like`
- Sistema de amistades:
  - `POST /api/users/{user}/friend`
  - `GET /api/friends`
  - `GET /api/friendships/pending`
  - `POST /api/friendships/{friendship}/accept`
- Mensajería entre usuarios:
  - `GET /api/messages`
  - `GET /api/messages/{user}`
  - `POST /api/messages/{user}`
- Actualización del perfil:
  - `GET /api/profile/{user}`
  - `POST /api/profile/update`

## Archivos modificados

- `app/Http/Controllers/AuthController.php`
- `app/Http/Controllers/FriendshipController.php`
- `app/Http/Controllers/PostController.php`
- `app/Http/Controllers/ProfileController.php`
- `app/Models/Post.php`
- `app/Models/User.php`
- `database/seeders/DatabaseSeeder.php`
- `routes/api.php`

## Instalación rápida

1. Copia el archivo `.env.example` a `.env`.
2. Configura la base de datos y las credenciales.
3. Ejecuta:
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```
4. Inicia el servidor:
   ```bash
   php artisan serve
   ```

## Uso

1. Regístrate con `POST /api/register`.
2. Inicia sesión con `POST /api/login`.
3. Usa el token en `Authorization: Bearer <token>` para acceder a los endpoints protegidos.

## Notas

- Las contraseñas se almacenan hasheadas con el guardado automático de Laravel.
- El endpoint `GET /api/users` omite al usuario actual y muestra estado de amistad con el resto.

## Licencia

Este proyecto está basado en Laravel y mantiene la licencia MIT.
