# MannyMaquinarias
Proyecto simulacro para un empresa en la catedra de Ingenieria de Software 2

# 🚜 Sistema de Maquinarias Agrícolas

## Usuarios cargados automaticamente para realizar pruebas:
| **Nombre** | **Email** | **Password** | **Rol** |
| --- | --- | --- | --- |
| Admin Principal | `admin@maquinarias.com` | `password123` | admin |
| **Fraanj** | `fraanj@test.com` | `123456` | admin |
| Juan Empleado | `empleado@maquinarias.com` | `password123` | employee |
| María Cliente | `cliente@maquinarias.com` | `password123` | user |

## 🚀 Configuración Inicial del Proyecto

### 1. Clonar e instalar dependencias
```bash
git clone <url-del-repo>
cd proyecto-maquinarias
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Configurar base de datos
Editar `.env` con los datos de tu BD:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=maquinarias_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

---

## 📊 Comandos de Base de Datos

### ✅ Ejecutar migraciones
```bash
php artisan migrate
```

### 🌱 Ejecutar seeders
```bash
php artisan db:seed
```

### 🔥 **RESETEAR BD COMPLETA** (¡Cuidado! Borra todo)
```bash
# Limpia BD + ejecuta migraciones + seeders
php artisan migrate:fresh --seed
```

### 🔄 Rollback de migraciones
```bash
# Deshace la última migración
php artisan migrate:rollback

# Deshace todas las migraciones
php artisan migrate:reset
```

---

## 🖥️ Comandos de Servidor

### 🌐 Iniciar servidor de desarrollo
```bash
php artisan serve
# Por defecto: http://localhost:8000

# Puerto personalizado
php artisan serve --port=8080
```

### 🎨 Compilar assets (CSS/JS)
```bash
# Desarrollo
npm run dev

# Producción
npm run build

# Watch (auto-recarga)
npm run dev -- --watch
```

---

## 🛠️ Comandos para Crear Archivos

### 🎮 Crear Controller
```bash
# Controller básico
php artisan make:controller MaquinariaController

# Controller con métodos CRUD
php artisan make:controller MaquinariaController --resource

# Controller + Model + Migration
php artisan make:controller MaquinariaController --resource --model=Maquinaria
```

### 🏗️ Crear Model
```bash
# Model básico
php artisan make:model Maquinaria

# Model + Migration
php artisan make:model Maquinaria -m

# Model + Migration + Factory + Seeder
php artisan make:model Maquinaria -mfs

# Model + Controller + Migration (completo)
php artisan make:model Maquinaria -mcr
```

### 🗄️ Crear Migration
```bash
# Crear tabla
php artisan make:migration create_maquinarias_table

# Modificar tabla existente
php artisan make:migration add_precio_to_maquinarias_table --table=maquinarias
```

### 🌱 Crear Seeder
```bash
php artisan make:seeder MaquinariaSeeder
```

---

## 🏗️ Implementar Operaciones de Base de Datos

### **Estructura recomendada: Repository Pattern + Service Layer**

#### 1️⃣ Crear Repository
```bash
# Crear directorio
mkdir app/Repositories

# Crear interface
touch app/Repositories/MaquinariaRepositoryInterface.php

# Crear implementación
touch app/Repositories/MaquinariaRepository.php
```

**Interface:**
```php
<?php
namespace App\Repositories;

interface MaquinariaRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
```

**Implementación:**
```php
<?php
namespace App\Repositories;

use App\Models\Maquinaria;

class MaquinariaRepository implements MaquinariaRepositoryInterface
{
    public function all()
    {
        return Maquinaria::all();
    }
    
    public function find($id)
    {
        return Maquinaria::findOrFail($id);
    }
    
    public function create(array $data)
    {
        return Maquinaria::create($data);
    }
    
    public function update($id, array $data)
    {
        $maquinaria = $this->find($id);
        $maquinaria->update($data);
        return $maquinaria;
    }
    
    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
```

#### 2️⃣ Crear Service
```bash
mkdir app/Services
touch app/Services/MaquinariaService.php
```

```php
<?php
namespace App\Services;

use App\Repositories\MaquinariaRepositoryInterface;

class MaquinariaService
{
    protected $maquinariaRepository;
    
    public function __construct(MaquinariaRepositoryInterface $maquinariaRepository)
    {
        $this->maquinariaRepository = $maquinariaRepository;
    }
    
    public function getAllMaquinarias()
    {
        return $this->maquinariaRepository->all();
    }
    
    public function createMaquinaria(array $data)
    {
        // Lógica de negocio aquí
        return $this->maquinariaRepository->create($data);
    }
    
    // ... más métodos
}
```

#### 3️⃣ Registrar en Service Provider
**En `app/Providers/AppServiceProvider.php`:**
```php
public function register(): void
{
    $this->app->bind(
        \App\Repositories\MaquinariaRepositoryInterface::class,
        \App\Repositories\MaquinariaRepository::class
    );
}
```

#### 4️⃣ Usar en Controller
```php
<?php
namespace App\Http\Controllers;

use App\Services\MaquinariaService;

class MaquinariaController extends Controller
{
    protected $maquinariaService;
    
    public function __construct(MaquinariaService $maquinariaService)
    {
        $this->maquinariaService = $maquinariaService;
    }
    
    public function index()
    {
        $maquinarias = $this->maquinariaService->getAllMaquinarias();
        return view('maquinarias.index', compact('maquinarias'));
    }
    
    public function store(Request $request)
    {
        $maquinaria = $this->maquinariaService->createMaquinaria($request->validated());
        return redirect()->route('maquinarias.index');
    }
}
```

---

## 👥 Usuarios de Prueba

**Acceso al sistema:**
- **Admin:** `fraanj@test.com` / `123456`
- **Employee:** `employee@test.com` / `123456`
- **User:** `user@test.com` / `123456`

---

## 🆘 Comandos Útiles de Emergencia

### 🧹 Limpiar caché
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 🔐 Permisos (Linux/Mac)
```bash
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```

### 📝 Ver rutas disponibles
```bash
php artisan route:list
```

### 🕵️ Debugging
```bash
# Tinker (consola interactiva)
php artisan tinker

# Logs en tiempo real
tail -f storage/logs/laravel.log
```

---

## 🚨 Solución de Problemas Comunes

| Problema | Solución |
|----------|----------|
| Error 500 | `php artisan cache:clear` + verificar `.env` |
| BD no conecta | Verificar credenciales en `.env` |
| Assets no cargan | `npm run dev` |
| Permisos | `chmod 775 storage bootstrap/cache` |
| Rutas no funcionan | `php artisan route:clear` |

---

**¡Listo para desarrollar! 🚀**
