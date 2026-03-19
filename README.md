# Laravel 12 Starter Template

Starter profesional para nuevos productos sobre Laravel 12, con autenticacion completa, roles tipados, preferencias de frontend, panel de administracion basico y tooling de calidad listo para trabajar.

## Resumen

- Laravel 12 + PHP 8.2+
- Fortify sin Jetstream
- Livewire 3 + Blade
- Tailwind CSS 4 + Vite
- Pest, PHPStan, Pint, Rector y Prettier
- Localizacion `en` y `es`
- Roles tipados: `admin` y `user`
- Preferencias de frontend por usuario
- Configuracion global tipada para verificacion humana en registro

## Funcionalidades incluidas

- Landing publica en `/`
- Dashboard para usuarios autenticados y verificados
- Perfil de cuenta con:
    - cambio de idioma
    - seleccion de template visual
    - actualizacion de nombre y email
    - cambio de contrasena
    - activacion de 2FA
- Area de administracion en `/admin/settings`
- Verificacion humana configurable para el registro
- Galeria de templates y preview de estilos

## Arquitectura actual

### Backend

- `app/Actions/Fortify` contiene las acciones de registro, perfil y password
- `app/Enums/UserRole.php` define los roles del sistema
- `app/Enums/AppSettingKey.php` centraliza claves tipadas de configuracion
- `app/Http/Controllers` contiene endpoints declarativos y delgados
- `app/Http/Requests` encapsula validacion HTTP
- `app/Http/Middleware/EnsureUserHasRole.php` protege rutas por rol
- `app/Http/Middleware/SetLocale.php` resuelve locale, template y estado compartido de frontend
- `app/Models/UserFrontendPreference.php` separa preferencias visuales del modelo `User`
- `app/Models/AppSetting.php` expone una API tipada para settings globales

### Frontend

- Blade-first, sin SPA innecesaria
- Layout principal en `resources/views/components/layouts/app.blade.php`
- Pantallas de auth personalizadas en `resources/views/auth`
- Dashboard en `resources/views/dashboard.blade.php`
- Perfil en `resources/views/profile.blade.php`
- Ajustes de administracion en `resources/views/admin/settings.blade.php`

### Datos y seeders

- `database/seeders/AdminUserSeeder.php` crea perfiles administrativos
- `database/seeders/StandardUserSeeder.php` crea perfiles de usuario estandar
- `database/seeders/DatabaseSeeder.php` compone ambos seeders

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js + npm
- SQLite habilitado en PHP

## Instalacion rapida

```bash
cp .env.example .env
composer install
npm install
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
```

Iniciar entorno local:

```bash
composer run dev
```

## Usuarios seed por defecto

Credenciales de demo para validacion funcional local:

### Administradores

- `starter@example.com` / `password`
- `ops-admin@example.com` / `password`

### Usuarios estandar

- `member@example.com` / `password`
- `analyst@example.com` / `password`

Ademas se generan usuarios fake adicionales con rol `user`.

## Roles y acceso

El sistema usa un enum tipado para roles:

- `admin`: acceso a configuracion administrativa global
- `user`: acceso normal a dashboard y perfil

Reglas actuales:

- solo usuarios autenticados y verificados entran a `/dashboard` y `/profile`
- solo usuarios con rol `admin` entran a `/admin/settings`
- solo `admin` puede cambiar la verificacion humana global del registro

## Configuracion global

Hoy existe una configuracion de aplicacion persistida:

- `registration_human_verification_enabled`

Se consume desde `AppSetting` con acceso tipado y afecta:

- render del captcha en registro
- validacion del registro
- pantalla administrativa

## Comandos utiles

### Desarrollo

```bash
composer run dev
php artisan serve
npm run dev
```

### Base de datos

```bash
php artisan migrate
composer run migrate
php artisan db:seed
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=StandardUserSeeder
```

### Calidad

```bash
./vendor/bin/pint --test
npm run lint
composer run phpstan
./vendor/bin/pest
composer run test
```

## Testing

El proyecto incluye cobertura para:

- auth flow
- pages auth
- dashboard y profile
- acceso admin
- seeders
- locale
- galeria de templates
- 2FA
- modelo `User`

Ejemplos:

```bash
./vendor/bin/pest tests/Feature/AdminAccessTest.php
./vendor/bin/pest tests/Feature/DatabaseSeederTest.php
./vendor/bin/pest --filter="global human verification"
```

## Convenciones del proyecto

- `User` queda cercano al baseline de Laravel y solo contiene logica de identidad/autorizacion esencial
- las preferencias visuales no viven en `User`, sino en `UserFrontendPreference`
- las validaciones HTTP viven en `FormRequest`
- los roles usan enum, no strings dispersos por el codigo
- los settings globales usan claves tipadas, no magic strings sueltos
- los lockfiles se versionan

## Estructura recomendada para extender

Si vas a seguir creciendo este starter, el orden sugerido es:

1. adaptar branding y copy de landing/dashboard
2. definir tus entidades de dominio
3. ampliar permisos sobre la base de roles existente
4. mover settings globales a modulos mas especificos si el dominio crece
5. agregar CI para lint, analisis y tests

## Verificacion recomendada antes de entregar cambios

```bash
./vendor/bin/pint --test
npm run lint
composer run phpstan
./vendor/bin/pest
npm run build
```

## Changelog

Consulta `CHANGELOG.md` para el historial funcional del starter.

## Licencia

MIT, siguiendo la base del ecosistema Laravel, salvo que tu proyecto derivado defina otra.
