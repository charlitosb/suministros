# 🖥️ Sistema de Suministros - Laravel

## Autor
**Carlos Barrios 202408075**  
Programación WEB

---

## 📋 PROMPT 1: Configuración de Base de Datos

Este prompt contiene todo lo necesario para configurar la base de datos del sistema.

---

## 🚀 Instrucciones de Instalación

### Requisitos Previos
- XAMPP instalado en Windows 11
- PHP 8.1 o superior
- Composer instalado
- MySQL/MariaDB (incluido en XAMPP)

### Paso 1: Crear el Proyecto Laravel

Abre una terminal (CMD o PowerShell) y ejecuta:

```bash
# Navegar a la carpeta htdocs de XAMPP
cd C:\xampp\htdocs

# Crear proyecto Laravel
composer create-project laravel/laravel suministros

# Entrar al proyecto
cd suministros
```

### Paso 2: Configurar la Base de Datos

#### Opción A: Usando phpMyAdmin (SQL directo)

1. Abre XAMPP y enciende Apache y MySQL
2. Abre tu navegador y ve a: `http://localhost/phpmyadmin`
3. Haz clic en "SQL" en el menú superior
4. Copia y pega todo el contenido del archivo `database/suministros_db.sql`
5. Haz clic en "Continuar" o "Go"

#### Opción B: Usando Migraciones de Laravel

1. Primero crea la base de datos vacía en phpMyAdmin:
   - Ve a phpMyAdmin
   - Haz clic en "Nueva" en el panel izquierdo
   - Nombre: `suministros_db`
   - Cotejamiento: `utf8mb4_unicode_ci`
   - Haz clic en "Crear"

2. Configura el archivo `.env` del proyecto:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=suministros_db
DB_USERNAME=root
DB_PASSWORD=
```

3. Copia los archivos de migraciones a `database/migrations/`

4. Copia los archivos de seeders a `database/seeders/`

5. Ejecuta las migraciones y seeders:

```bash
php artisan migrate
php artisan db:seed
```

### Paso 3: Verificar la Instalación

1. En phpMyAdmin, selecciona la base de datos `suministros_db`
2. Deberías ver las siguientes tablas:
   - `usuarios` (5 registros)
   - `marcas` (5 registros)
   - `categorias` (5 registros)
   - `tipos_equipo` (5 registros)
   - `equipos` (5 registros)
   - `suministros` (5 registros)
   - `ingresos_suministro` (5 registros)
   - `instalaciones_suministro` (5 registros)

### Paso 4: Iniciar el Servidor de Desarrollo

```bash
php artisan serve
```

Abre tu navegador en: `http://localhost:8000`

---

## 📊 Estructura de la Base de Datos

### Diagrama de Relaciones

```
┌─────────────┐     ┌─────────────┐     ┌─────────────────┐
│    MARCA    │────<│  SUMINISTRO │>────│   CATEGORIA     │
└─────────────┘     └──────┬──────┘     └─────────────────┘
      │                   ││                    │
      │                   ││                    │
      │       ┌───────────┘└───────────┐       │
      │       │                        │       │
      │       ▼                        ▼       │
      │  ┌─────────────┐      ┌─────────────┐  │
      │  │  INGRESO    │      │ INSTALACION │  │
      │  │ SUMINISTRO  │      │ SUMINISTRO  │  │
      │  │  (+stock)   │      │  (-stock)   │  │
      │  └─────────────┘      └──────┬──────┘  │
      │                              │         │
      │                              ▼         │
      │  ┌─────────────┐      ┌─────────────┐  │
      └──│ TIPO_EQUIPO │─────>│   EQUIPO    │<─┘
         └─────────────┘      └─────────────┘

┌─────────────┐
│   USUARIO   │ (Autenticación)
└─────────────┘
```

### Descripción de Tablas

| Tabla | Descripción |
|-------|-------------|
| `usuarios` | Usuarios del sistema para autenticación |
| `marcas` | Marcas de los suministros (HP, Epson, etc.) |
| `categorias` | Categorías de productos (Toner, Mouse, etc.) |
| `tipos_equipo` | Tipos de equipos (Laptop, PC, Impresora) |
| `equipos` | Equipos de cómputo de la empresa |
| `suministros` | Productos/artículos en inventario |
| `ingresos_suministro` | Registro de entradas (+stock) |
| `instalaciones_suministro` | Registro de salidas (-stock) |

---

## 👥 Usuarios de Prueba

| Usuario | Nombre | Contraseña |
|---------|--------|------------|
| admin | Administrador del Sistema | password |
| carlos | Carlos Barrios | password |
| maria | María García | password |

---

## 📁 Estructura de Archivos (Prompt 1)

```
suministros_laravel/
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_usuarios_table.php
│   │   ├── 2024_01_01_000002_create_marcas_table.php
│   │   ├── 2024_01_01_000003_create_categorias_table.php
│   │   ├── 2024_01_01_000004_create_tipos_equipo_table.php
│   │   ├── 2024_01_01_000005_create_equipos_table.php
│   │   ├── 2024_01_01_000006_create_suministros_table.php
│   │   ├── 2024_01_01_000007_create_ingresos_suministro_table.php
│   │   └── 2024_01_01_000008_create_instalaciones_suministro_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── UsuarioSeeder.php
│   │   ├── MarcaSeeder.php
│   │   ├── CategoriaSeeder.php
│   │   ├── TipoEquipoSeeder.php
│   │   ├── EquipoSeeder.php
│   │   ├── SuministroSeeder.php
│   │   ├── IngresoSuministroSeeder.php
│   │   └── InstalacionSuministroSeeder.php
│   └── suministros_db.sql
└── README.md
```

---

## ⚡ Comandos Útiles

```bash
# Resetear base de datos y volver a sembrar
php artisan migrate:fresh --seed

# Solo ejecutar seeders
php artisan db:seed

# Verificar estado de migraciones
php artisan migrate:status

# Crear la clave de aplicación
php artisan key:generate
```

---

## 📌 Notas Importantes

1. **Stock Inicial**: Todos los suministros inician con stock = 0
2. **Ingresos**: Aumentan automáticamente el stock
3. **Instalaciones**: Reducen automáticamente el stock
4. **Integridad**: Las FK usan `ON DELETE RESTRICT` para evitar borrar registros relacionados

---

## 📦 PROMPT 2: Modelos y Controladores

### Modelos Creados

| Modelo | Tabla | Relaciones |
|--------|-------|------------|
| Usuario | usuarios | - |
| Marca | marcas | hasMany → Suministro |
| Categoria | categorias | hasMany → Suministro |
| TipoEquipo | tipos_equipo | hasMany → Equipo, Suministro |
| Equipo | equipos | belongsTo → TipoEquipo, hasMany → Instalacion |
| Suministro | suministros | belongsTo → Marca, Categoria, TipoEquipo |
| IngresoSuministro | ingresos_suministro | belongsTo → Suministro |
| InstalacionSuministro | instalaciones_suministro | belongsTo → Suministro, Equipo |

### Controladores Creados

- **AuthController**: Login/Logout simple
- **DashboardController**: Página de bienvenida
- **MarcaController**: CRUD completo
- **CategoriaController**: CRUD completo
- **TipoEquipoController**: CRUD completo
- **EquipoController**: CRUD completo
- **SuministroController**: CRUD completo
- **IngresoSuministroController**: CRUD + lógica de incremento de stock
- **InstalacionSuministroController**: CRUD + validación robusta de stock
- **InventarioController**: Vista filtrada + exportación PDF

### Rutas Disponibles

```
GET|POST   /login                  → Autenticación
POST       /logout                 → Cerrar sesión
GET        /dashboard              → Panel principal

# CRUDs
GET|POST   /marcas                 → index, store
GET        /marcas/create          → create
GET|PUT|DELETE /marcas/{marca}     → show, update, destroy
GET        /marcas/{marca}/edit    → edit

(Mismo patrón para: categorias, tipos-equipo, equipos, suministros, ingresos, instalaciones)

# Inventario
GET        /inventario             → Vista con filtros
GET        /inventario/pdf         → Exportar a PDF

# API
GET        /api/suministros/{id}/stock → Stock disponible (AJAX)
```

### Lógica de Stock

**Ingreso de Suministros:**
- Al crear → `stock += cantidad`
- Al eliminar → `stock -= cantidad` (si hay suficiente)
- Al editar → Ajusta diferencias

**Instalación de Suministros:**
- Al crear → Valida `stock > 0`, luego `stock -= 1`
- Al eliminar → `stock += 1`
- Al cambiar suministro → Devuelve al anterior, resta al nuevo

### Archivos del Prompt 2

```
app/
├── Models/
│   ├── Usuario.php
│   ├── Marca.php
│   ├── Categoria.php
│   ├── TipoEquipo.php
│   ├── Equipo.php
│   ├── Suministro.php
│   ├── IngresoSuministro.php
│   └── InstalacionSuministro.php
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── MarcaController.php
│   │   ├── CategoriaController.php
│   │   ├── TipoEquipoController.php
│   │   ├── EquipoController.php
│   │   ├── SuministroController.php
│   │   ├── IngresoSuministroController.php
│   │   ├── InstalacionSuministroController.php
│   │   └── InventarioController.php
│   └── Middleware/
│       └── Autenticado.php
├── bootstrap/
│   └── app.php
├── config/
│   └── auth.php
└── routes/
    └── web.php
```

---

## ➡️ Siguiente Prompt

**PROMPT 3: Vistas + Layout** incluirá:
- Layout maestro con Navbar
- Header y Footer personalizados
- Vistas CRUD para todas las entidades
- Vista de Inventario con filtros

---

## 📦 PROMPT 3: Vistas y Layout

### Layout Maestro
- **Header:** "Sistema de Suministros"
- **Navbar:** Horizontal con acceso a todos los módulos
- **Footer:** "Programación WEB" / "Carlos Barrios 202408075"
- **Diseño:** Minimalista con CSS puro (sin Bootstrap)

### Vistas Creadas

| Módulo | Vistas |
|--------|--------|
| Auth | login.blade.php |
| Dashboard | dashboard.blade.php |
| Marcas | index, create, edit, show |
| Categorías | index, create, edit, show |
| Tipos Equipo | index, create, edit, show |
| Equipos | index, create, edit, show |
| Suministros | index, create, edit, show |
| Ingresos | index, create, edit, show |
| Instalaciones | index, create, edit, show |
| Inventario | index, pdf |

### Características de las Vistas

- **Selects dinámicos**: FKs muestran nombres, no IDs
- **Indicadores de stock**: Colores según nivel (verde/amarillo/rojo)
- **Validación JavaScript**: Preview de cambios en stock
- **Filtros**: Búsqueda y filtrado en inventario
- **Ordenamiento**: Columnas clickeables en tablas
- **Paginación**: Estilizada y funcional
- **Alertas**: Mensajes de éxito/error
- **Confirmaciones**: Antes de eliminar registros

### Archivos del Prompt 3

```
resources/views/
├── layouts/
│   └── app.blade.php              # Layout maestro
├── auth/
│   └── login.blade.php            # Formulario de login
├── dashboard.blade.php            # Dashboard de bienvenida
├── marcas/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── categorias/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── tipos-equipo/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── equipos/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── suministros/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── ingresos/
│   ├── index.blade.php
│   ├── create.blade.php           # Vista con preview de stock
│   ├── edit.blade.php
│   └── show.blade.php             # Vista detalle con stock actualizado
├── instalaciones/
│   ├── index.blade.php
│   ├── create.blade.php           # CRÍTICO: Validación robusta de stock
│   ├── edit.blade.php
│   └── show.blade.php
├── inventario/
│   ├── index.blade.php            # Vista con filtros completos
│   └── pdf.blade.php              # Template para PDF
└── vendor/pagination/
    └── simple-default.blade.php
```

---

## 🚀 Instalación Completa

### Paso 1: Crear proyecto Laravel
```bash
cd C:\xampp\htdocs
composer create-project laravel/laravel suministros
cd suministros
```

### Paso 2: Configurar .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=suministros_db
DB_USERNAME=root
DB_PASSWORD=
```

### Paso 3: Crear base de datos en phpMyAdmin
- Nombre: `suministros_db`
- Cotejamiento: `utf8mb4_unicode_ci`

### Paso 4: Copiar archivos
Copia las carpetas del proyecto:
- `app/` → `suministros/app/`
- `bootstrap/` → `suministros/bootstrap/`
- `config/` → `suministros/config/`
- `database/` → `suministros/database/`
- `resources/` → `suministros/resources/`
- `routes/` → `suministros/routes/`

### Paso 5: Instalar DomPDF
```bash
composer require barryvdh/laravel-dompdf
```

### Paso 6: Ejecutar migraciones y seeders
```bash
php artisan migrate
php artisan db:seed
```

### Paso 7: Iniciar servidor
```bash
php artisan serve
```

### Paso 8: Acceder al sistema
- URL: http://localhost:8000
- Usuario: admin, carlos o maria
- Contraseña: password

---

## 👥 Usuarios de Prueba

| Usuario | Nombre | Contraseña |
|---------|--------|------------|
| admin | Administrador del Sistema | password |
| carlos | Carlos Barrios | password |
| maria | María García | password |

---

## 📊 Datos de Prueba Incluidos

- **5 Usuarios** con contraseña `password`
- **5 Marcas**: HP, Epson, Logitech, Dell, Canon
- **5 Categorías**: Toner, Mouse, Teclado, Cartucho, Cable USB
- **5 Tipos de Equipo**: Laptop, PC, Impresora, Monitor, Scanner
- **5 Equipos** con números de serie
- **5 Suministros** con precios y relaciones
- **5 Ingresos** que incrementaron stock
- **5 Instalaciones** que decrementaron stock
