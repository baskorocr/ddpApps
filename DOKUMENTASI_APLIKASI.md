# Dokumentasi Aplikasi Quality Control System (QCS)

## Daftar Isi
1. [Gambaran Umum](#gambaran-umum)
2. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
3. [Struktur Database](#struktur-database)
4. [Fitur Utama](#fitur-utama)
5. [Arsitektur Aplikasi](#arsitektur-aplikasi)
6. [Panduan Instalasi](#panduan-instalasi)
7. [Panduan Penggunaan](#panduan-penggunaan)
8. [API Endpoints](#api-endpoints)
9. [Troubleshooting](#troubleshooting)

## Gambaran Umum

Quality Control System (QCS) adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola proses kontrol kualitas dalam lingkungan manufaktur. Aplikasi ini memungkinkan pengguna untuk melacak defect, mengelola data produksi, dan menghasilkan laporan kualitas.

### Tujuan Aplikasi
- Mengelola data quality control dalam proses produksi
- Melacak defect dan jenis kerusakan produk
- Menghasilkan laporan analisis kualitas
- Mengelola data master (parts, colors, customers, dll)
- Memfasilitasi workflow quality control dengan role-based access

## Teknologi yang Digunakan

### Backend
- **Framework**: Laravel 10.x
- **PHP Version**: ^8.1
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Breeze + Sanctum
- **Performance**: Laravel Octane

### Frontend
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js
- **Icons**: Heroicons, FontAwesome
- **PWA**: Laravel PWA

### Dependencies Utama
- **Excel Processing**: Maatwebsite/Excel, PhpSpreadsheet, Fast-Excel
- **HTTP Client**: Guzzle
- **Development**: Laravel Sail, Tinker

## Struktur Database

### File Migration

Berikut adalah daftar file migration yang ada dalam aplikasi:

```
database/migrations/
├── 2014_10_11_023236_create_depts_table.php
├── 2014_10_12_000000_create_users_table.php
├── 2014_10_12_100000_create_password_reset_tokens_table.php
├── 2019_08_19_000000_create_failed_jobs_table.php
├── 2019_12_14_000001_create_personal_access_tokens_table.php
├── 2024_10_31_015913_create_lines_table.php
├── 2024_11_01_031327_create_customers_table.php
├── 2024_11_01_031504_create_type_part_table.php
├── 2024_11_01_031517_create_colors_table.php
├── 2024_11_01_031529_create_parts_table.php
├── 2024_11_01_032535_create_type_defects_table.php
├── 2024_11_01_032542_create_item_defects_table.php
├── 2024_11_02_033927_create_status_o_k_s_table.php
├── 2024_11_04_030340_create_shifts_table.php
├── 2024_11_04_030725_create_fix_proses_table.php
├── 2024_11_04_031355_create_temp_defacts_table.php
├── 2025_03_07_082241_create_q1_s_table.php
└── 2025_03_07_082302_create_q2_s_table.php
```

### Model Files

Berikut adalah daftar model yang ada dalam aplikasi:

```
app/Models/
├── User.php
├── Dept.php
├── line.php
├── customer.php
├── typeParts.php
├── Colors.php
├── Parts.php
├── typeDefect.php
├── itemDefects.php
├── statusOK.php
├── shift.php
├── fixProses.php
├── tempDefact.php
├── Q1.php
├── Q2.php
├── endRepaint.php
└── outTotal.php
```

### Detail Struktur Tabel dan Model

#### 1. Users Table & Model
**Migration**: `2014_10_12_000000_create_users_table.php`
**Model**: `app/Models/User.php`

- **Fields**: id, name, email, npk, password, role, dept_id, timestamps
- **Relationships**: 
  - BelongsTo Dept
  - HasMany Q1, Q2
- **Features**: Authentication, Role-based access

#### 2. Departments Table & Model
**Migration**: `2014_10_11_023236_create_depts_table.php`
**Model**: `app/Models/Dept.php`

- **Fields**: id, name, description
- **Relationships**: HasMany Users
- **Purpose**: Mengelola departemen dalam organisasi

#### 3. Lines Table & Model
**Migration**: `2024_10_31_015913_create_lines_table.php`
**Model**: `app/Models/line.php`

- **Fields**: id, name, description, status
- **Relationships**: HasMany Q1, Q2
- **Purpose**: Mengelola line produksi

#### 4. Shifts Table & Model
**Migration**: `2024_11_04_030340_create_shifts_table.php`
**Model**: `app/Models/shift.php`

- **Fields**: id, name, start_time, end_time, description
- **Relationships**: HasMany Q1, Q2
- **Purpose**: Mengelola shift kerja

#### 5. Customers Table & Model
**Migration**: `2024_11_01_031327_create_customers_table.php`
**Model**: `app/Models/customer.php`

- **Fields**: id, name
- **Fillable**: ['name']
- **Timestamps**: false
- **Purpose**: Mengelola data customer

#### 6. Colors Table & Model
**Migration**: `2024_11_01_031517_create_colors_table.php`
**Model**: `app/Models/Colors.php`

- **Fields**: id, color
- **Fillable**: ['color']
- **Timestamps**: false
- **Relationships**: HasMany Parts, Q1, Q2
- **Purpose**: Mengelola data warna produk

#### 7. Type Parts Table & Model
**Migration**: `2024_11_01_031504_create_type_part_table.php`
**Model**: `app/Models/typeParts.php`

- **Fields**: id, type_name, description
- **Relationships**: HasMany Parts
- **Purpose**: Mengelola kategori/jenis part

#### 8. Parts Table & Model
**Migration**: `2024_11_01_031529_create_parts_table.php`
**Model**: `app/Models/Parts.php`

- **Fields**: id, item, idType
- **Fillable**: ['item', 'idType']
- **Timestamps**: false
- **Relationships**: 
  - BelongsTo typeParts (idType)
  - HasMany Q1, Q2
- **Foreign Keys**: idType → type_parts.id

#### 9. Type Defects Table & Model
**Migration**: `2024_11_01_032535_create_type_defects_table.php`
**Model**: `app/Models/typeDefect.php`

- **Fields**: id, type
- **Fillable**: ['type']
- **Timestamps**: false
- **Relationships**: HasMany itemDefects
- **Purpose**: Mengelola kategori defect

#### 10. Item Defects Table & Model
**Migration**: `2024_11_01_032542_create_item_defects_table.php`
**Model**: `app/Models/itemDefects.php`

- **Fields**: id, idTypeDefact, itemDefact
- **Fillable**: ['idTypeDefact', 'itemDefact']
- **Timestamps**: false
- **Relationships**: BelongsTo typeDefect (idTypeDefact)
- **Purpose**: Mengelola detail item defect

#### 11. Q1 Table & Model
**Migration**: `2025_03_07_082241_create_q1_s_table.php`
**Model**: `app/Models/Q1.php`

- **Table**: q1_s
- **Fields**: id, idPart, idColor, idShift, idLine, typeDefact, role, idNPK, timestamps
- **Fillable**: ['idPart', 'idColor', 'typeDefact', 'role', 'idShift', 'idLine', 'idNPK', 'role', 'created_at', 'updated_at']
- **Foreign Keys**:
  - idLine → lines.id
  - idNPK → users.npk
  - idPart → parts.id
  - idColor → colors.id
  - idShift → shifts.id
- **Purpose**: Menyimpan data quality control tahap 1

#### 12. Q2 Table & Model
**Migration**: `2025_03_07_082302_create_q2_s_table.php`
**Model**: `app/Models/Q2.php`

- **Table**: q2_s
- **Fields**: id, idPart, idColor, typeDefact, role, idShift, idLine, idNPK, timestamps
- **Foreign Keys**: Similar to Q1
- **Purpose**: Menyimpan data quality control tahap 2

#### 13. Temp Defacts Table & Model
**Migration**: `2024_11_04_031355_create_temp_defacts_table.php`
**Model**: `app/Models/tempDefact.php`

- **Fields**: id, idPart, idColor, quantity, status, timestamps
- **Purpose**: Tabel temporary untuk proses defect

#### 14. Fix Proses Table & Model
**Migration**: `2024_11_04_030725_create_fix_proses_table.php`
**Model**: `app/Models/fixProses.php`

- **Fields**: id, process_name, description, status
- **Purpose**: Mengelola proses perbaikan

#### 15. Status OK Table & Model
**Migration**: `2024_11_02_033927_create_status_o_k_s_table.php`
**Model**: `app/Models/statusOK.php`

- **Fields**: id, status_name, description
- **Purpose**: Mengelola status OK dalam quality control

### Contoh Kode Model

#### Model Parts.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\typeParts;
use App\Models\Colors;

class Parts extends Model
{
    use HasFactory;
    protected $table = 'parts';
    public $timestamps = false;
    
    protected $fillable = [
        'item',
        'idType'
    ];

    public function typePart()
    {
        return $this->belongsTo(typeParts::class, 'idType');
    }
}
```

#### Model Q1.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Q1 extends Model
{
    use HasFactory;
    protected $table = 'q1_s';
    
    protected $fillable = [
        'idPart',
        'idColor',
        'typeDefact',
        'role',
        'idShift',
        'idLine',
        'idNPK',
        'role',
        'created_at',
        'updated_at',
    ];
}
```

### Contoh Migration

#### Migration create_parts_table.php
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idType');
            $table->string('item');
            
            $table->foreign('idType')
                  ->references('id')
                  ->on('type_parts')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
```

## Fitur Utama

### 1. Manajemen User dan Role
- **Admin**: Akses penuh ke semua fitur
- **Supervisor**: Akses monitoring dan approval
- **Users**: Akses input data quality control

### 2. Master Data Management
- Kelola data Parts dan Type Parts
- Kelola data Colors
- Kelola data Customers
- Kelola data Lines dan Shifts
- Kelola data Type Defects dan Item Defects

### 3. Quality Control Process
- **Q1 Process**: Input dan tracking quality control tahap 1
- **Q2 Process**: Input dan tracking quality control tahap 2
- Real-time data validation
- Defect categorization dan tracking

### 4. Reporting System
- Generate laporan berdasarkan periode
- Export data ke Excel
- Filter laporan berdasarkan line, shift, defect type
- Dashboard analytics

### 5. Progressive Web App (PWA)
- Offline capability
- Mobile-responsive design
- App-like experience

## Arsitektur Aplikasi

### MVC Pattern
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/AdminController.php
│   │   ├── Supervisor/SupervisorController.php
│   │   ├── User/UserController.php
│   │   ├── ProsesController.php
│   │   ├── ColorController.php
│   │   ├── CustomerController.php
│   │   ├── PartController.php
│   │   ├── TypeDefectController.php
│   │   └── reports.php
│   ├── Middleware/
│   └── Requests/
├── Models/
│   ├── User.php
│   ├── Parts.php
│   ├── Colors.php
│   ├── Q1.php
│   ├── Q2.php
│   └── ...
└── Providers/
```

### Route Structure
```
routes/
├── web.php (Main routes)
├── api.php (API routes)
└── auth.php (Authentication routes)
```

### View Structure
```
resources/views/
├── admin/ (Admin views)
├── supervisor/ (Supervisor views)
├── user/ (User views)
├── auth/ (Authentication views)
├── layouts/ (Layout templates)
├── components/ (Reusable components)
└── reports/ (Report views)
```

## Panduan Instalasi

### Persyaratan Sistem
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Web Server (Apache/Nginx)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone [repository-url]
   cd ddpApps
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   Edit file `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=qcs_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Database Migration & Seeding**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build Assets**
   ```bash
   npm run build
   ```

7. **Start Application**
   ```bash
   php artisan serve
   # atau dengan Octane
   php artisan octane:start
   ```

## Panduan Penggunaan

### Login dan Authentication
1. Akses aplikasi melalui browser
2. Login menggunakan kredensial yang telah dibuat
3. Sistem akan mengarahkan ke dashboard sesuai role

### Admin Dashboard
- Kelola semua master data
- Monitor aktivitas user
- Generate dan export laporan
- Manage user accounts dan permissions

### Supervisor Dashboard
- Monitor proses quality control
- Review dan approve data
- Akses laporan departemen

### User Dashboard
- Input data Q1 dan Q2
- View personal statistics
- Access quality control forms

### Quality Control Process

#### Q1 Process
1. Pilih Line dan Shift
2. Pilih Part dan Color
3. Input defect data jika ada
4. Submit data

#### Q2 Process
1. Pilih data dari temp_defacts
2. Verify dan update status
3. Input additional defect information
4. Complete Q2 process

## API Endpoints

### Authentication
- `POST /login` - User login
- `POST /logout` - User logout
- `POST /register` - User registration (admin only)

### Master Data
- `GET /admin/parts` - Get all parts
- `POST /admin/parts` - Create new part
- `PUT /admin/parts/{id}` - Update part
- `DELETE /admin/parts/{id}` - Delete part

### Quality Control
- `POST /users/storeReqQ1` - Submit Q1 data
- `POST /users/storeReqQ2` - Submit Q2 data
- `POST /users/getData` - Get filtered data
- `GET /users/getPart2` - Get parts for Q2

### Reports
- `GET /reports` - Get filtered reports
- `GET /reports/export` - Export report to Excel
- `GET /reportDefact` - Get defect reports
- `GET /reports/defact` - Export defect report

### Monitoring
- `GET /count1` - Get shift 1 count
- `GET /count2` - Get shift 2 count

## Troubleshooting

### Common Issues

#### 1. Database Connection Error
**Problem**: Cannot connect to database
**Solution**: 
- Check database credentials in `.env`
- Ensure database server is running
- Verify database exists

#### 2. Permission Denied
**Problem**: File permission errors
**Solution**:
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

#### 3. Composer Dependencies
**Problem**: Missing dependencies
**Solution**:
```bash
composer install --no-dev --optimize-autoloader
```

#### 4. NPM Build Errors
**Problem**: Asset compilation fails
**Solution**:
```bash
npm cache clean --force
npm install
npm run build
```

#### 5. Session Issues
**Problem**: User sessions not working
**Solution**:
- Check session configuration in `config/session.php`
- Clear application cache: `php artisan cache:clear`
- Clear config cache: `php artisan config:clear`

### Performance Optimization

1. **Enable Caching**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Use Octane for Production**
   ```bash
   php artisan octane:install --server=swoole
   php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
   ```

3. **Database Optimization**
   - Add proper indexes
   - Use database query optimization
   - Implement eager loading for relationships

### Maintenance

#### Regular Tasks
- Backup database regularly
- Monitor log files in `storage/logs/`
- Update dependencies periodically
- Clear temporary files and cache

#### Log Monitoring
```bash
# View latest logs
tail -f storage/logs/laravel.log

# Clear logs
echo "" > storage/logs/laravel.log
```

---

**Dokumentasi ini dibuat untuk membantu pengembangan, deployment, dan maintenance aplikasi Quality Control System. Untuk pertanyaan lebih lanjut, silakan hubungi tim development.**

**Versi Dokumentasi**: 1.0  
**Tanggal Update**: " + new Date().toLocaleDateString('id-ID') + "  
**Framework**: Laravel 10.x  
**PHP Version**: 8.1+