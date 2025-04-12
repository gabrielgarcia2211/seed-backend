# 🧩 API de Gestión de Productos - Laravel 10+

Este proyecto es una API básica desarrollada con Laravel para la gestión de productos, que incluye autenticación con Laravel Sanctum, protección de rutas y carga de documentos (imagenes).

---

## 🚀 Instalación Local

Sigue los siguientes pasos para ejecutar este proyecto en tu entorno local:

---

### 🔁 1. Clonar el repositorio

```bash
git clone https://github.com/gabrielgarcia2211/seed-backend.git
cd seed-backend
```

---

### 📦 2. Instalar dependencias de PHP

```bash
composer install
```

---

### ⚙️ 3. Configurar archivo de entorno

Copia el archivo de ejemplo `.env` y personaliza los valores:

```bash
cp .env.example .env
```

Ejemplo de configuración para MySQL:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seed_db
DB_USERNAME=root
DB_PASSWORD=
```

---

### 🔐 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

---

### 🗃️ 5. Ejecutar las migraciones y seed de product

```bash
php artisan migrate --seed
```

---


### 🖥 6. Levantar el servidor de desarrollo

```bash
php artisan serve
```

Visita: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

### 📮 7. Probar autenticación y CRUD

Usa herramientas como Postman o Insomnia para interactuar con la API.

#### Endpoints de autenticación:
- `POST /api/register` → Registro de usuario
- `POST /api/login` → Inicio de sesión y obtención de token

#### Para acceder al CRUD, añade el token en los headers:

```
Authorization: Bearer TU_TOKEN
```

---

## 🧱 Estructura de Modelos

### 👤 Modelo: User

| Campo     | Tipo             | Requerido | Descripción         |
|-----------|------------------|-----------|---------------------|
| name      | varchar(255)     | ✅        | Nombre del usuario  |
| email     | varchar(255)     | ✅        | Correo electrónico  |
| password  | varchar(255)     | ✅        | Contraseña hasheada |

---

### 📦 Modelo: Product

| Campo       | Tipo               | Requerido | Descripción                         |
|-------------|--------------------|-----------|-------------------------------------|
| id          | bigint (auto inc.) | ✅        | Identificador único                 |
| nombre      | varchar(255)       | ✅        | Nombre del producto                 |
| precio      | decimal(10,2)      | ✅        | Precio del producto                 |
| descripcion | text               | ❌        | Descripción opcional del producto   |
| activo      | tinyint(1)         | ✅        | Estado del producto (1=activo)      |

---

### 📎 Modelo: Attachment

| Campo        | Tipo               | Requerido | Descripción                                 |
|--------------|--------------------|-----------|---------------------------------------------|
| id           | bigint (auto inc.) | ✅        | Identificador único                         |
| product_id   | bigint             | ✅        | Relación con el producto (`foreign key`)    |
| file_path    | varchar(255)       | ✅        | Ruta o URL del archivo adjunto              |
| created_at   | timestamp          | ✅        | Fecha de carga                              |
| updated_at   | timestamp          | ✅        | Fecha de modificación                       |

> Relación: Un producto puede tener múltiples archivos adjuntos. (limitado a 1 para el proyecto)


---

## 📘 Rutas del Resource Controller de Productos

| Método HTTP | URI                   | Acción del controlador     | Descripción                     |
|-------------|------------------------|----------------------------|---------------------------------|
| GET         | /api/productos         | index                      | Obtener listado de productos    |
| POST        | /api/productos         | store                      | Crear un nuevo producto         |
| GET         | /api/productos/{id}    | show                       | Obtener un producto específico  |
| PUT/POST(postman)   | /api/productos/{id}    | update                     | Actualizar un producto          |
| DELETE      | /api/productos/{id}    | destroy                    | Eliminar un producto            |

Estas rutas están protegidas por Sanctum y requieren autenticación. 

### ✅ ¡Listo!

Tu API está corriendo localmente con autenticación y CRUD protegido.