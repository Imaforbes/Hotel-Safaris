# 🏨 Safari's Hotel Management System
### Enterprise-Grade PHP 8 & PDO MySQL Resort Architecture | Dual Role-Based Access Control (RBAC)

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6%2B-F7DF1E?style=for-the-badge&logo=javascript)
![Security](https://img.shields.io/badge/Security-PDO%20%2F%20Bcrypt-4ade80?style=for-the-badge)

---

## 🌐 English Documentation

### 📌 Overview
**Safari's Hotel Management System** is a full-stack resort operations and administration platform developed by **Imanol Forbes**. Originally conceptualized as an academic engineering project, it has been completely architected and refactored into a modern, hardened web application following strict backend security protocols and high-craft UI aesthetics.

The system enforces **Role-Based Access Control (RBAC)** to separate high-level executive management from day-to-day hospitality operations, powered by an asynchronous AJAX frontend and a secure PHP 8 / PDO MySQL backend.

---

### ✨ Key Features & Technical Highlights

- **🔒 Hardened Backend Security:**
  - **Zero SQL Injection:** All database queries utilize **PDO (PHP Data Objects)** with native parameterized prepared statements (`$pdo->prepare`).
  - **Bcrypt Password Hashing:** User credentials are encrypted at rest using standard `password_hash($pass, PASSWORD_DEFAULT)` and verified via `password_verify()`.
  - **Session Guardrails:** Role checks on every administrative page prevent unauthorized URL escalation.
- **⚡ Universal Database Connector (`api_hotel/conexion.php`):**
  - Built-in multi-environment intelligence: automatically detects and connects via **macOS MAMP Unix domain sockets (`/Applications/MAMP/tmp/mysql/mysql.sock`)** with password `'root'`, or falls back seamlessly to **Windows/Linux XAMPP (`localhost`)** with empty password `''`.
- **👥 Dual-Role Dashboards (RBAC):**
  - **👑 Administrator Panel (`administrador.php`):** Executive overview with real-time statistics (total staff, guests, room occupancy, and active reservations) and full Employee CRUD management.
  - **🦁 Staff / Concierge Panel (`panel-empleado.php`):** Operational control center for room reservations, guest check-ins, and ecotourism activity enrollments.
- **🎨 Hallmark Editorial UI / Anti-AI-Slop Craft:**
  - Styled with an **Obsidian & Luxury Safari Gold** theme, glassmorphic login card (`index.php`), interactive stats cards with smooth hover elevation (`transform: translateY(-5px)`), and a fixed **Technical Portfolio Top Bar (`.hallmark-header`)**.
- **⚙️ Automated Hospitality Business Logic:**
  - Transactional SQL (`$pdo->beginTransaction()`) updates room availability (`hab_disp = 'Si' / 'No'`) automatically upon booking or canceling reservations.

---

### 📦 Quick Start & Installation

#### 1. Clone the Repository
```bash
git clone https://github.com/Imaforbes/Hotel-Safaris.git
cd Hotel-Safaris
```

#### 2. Import Database Schema (`database.sql`)
The repository includes a complete, idempotent SQL schema and seed data file in the root directory: **`database.sql`**.
- In **phpMyAdmin** (MAMP / XAMPP): Create database `hotel` (or let the script create it automatically) and click **Import** -> select `database.sql`.
- Via **Terminal CLI**:
  ```bash
  # MAMP on macOS
  /Applications/MAMP/Library/bin/mysql80/bin/mysql -S /Applications/MAMP/tmp/mysql/mysql.sock -u root -proot < database.sql

  # Standard MySQL / XAMPP
  mysql -u root -p < database.sql
  ```

#### 3. Default Seed Test Accounts (Ready to Login)
All preloaded accounts are encrypted with valid PHP Bcrypt hashes:

| Role | Username | Password | Access Area |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin` | `admin123` | Executive Dashboard (`administrador.php`) |
| **Administrator** | `iforbes` | `admin123` | Executive Dashboard (`administrador.php`) |
| **Staff / Guide** | `empleado` | `empleado123` | Staff Operations (`panel-empleado.php`) |
| **Staff / Guide** | `rsafari` | `empleado123` | Staff Operations (`panel-empleado.php`) |

---

### 📂 Repository Architecture

```
Hotel-Safaris/
├── 📄 README.md                # Bilingual Technical & Architectural Guide
├── 💾 database.sql             # MySQL 8.0 Schema & Preloaded Safari Seed Data
├── 🚪 index.php                # Luxury Safari Login Portal (Bcrypt Auth)
├── 👑 administrador.php        # Executive Dashboard & Employee CRUD
├── 🦁 panel-empleado.php       # Operational Staff & Reservations Center
├── ✏️ editar-empleado.php      # Employee Profile Editor View
├── 📁 api_hotel/               # Backend API Endpoints & PDO Engine
│   ├── 🔗 conexion.php         # Universal PDO DB Engine (MAMP + XAMPP Auto-Detect)
│   ├── 🔐 perfiles.php         # Authentication & RBAC Session Controller
│   ├── 🔑 generar_hash.php     # Bcrypt Hasher Utility
│   ├── 📥 inserta-reserva.php  # Transactional Booking & Room Availability Logic
│   └── 📋 consulta-*.php       # REST-like CRUD Endpoint Controllers
└── 📁 css/
    └── 🎨 style.css            # Custom Design System & Hallmark Header Tokens
```

---
---

## 🇲🇽 Documentación en Español

### 📌 Descripción General
**Sistema de Gestión Hotelera "Safari's"** es una plataforma web modular para la administración y operación diaria de un hotel o resort ecoturístico, desarrollada por **Imanol (`@imaforbes`)**. Refactorizado con estándares profesionales, el sistema separa la gestión administrativa de la operativa mediante un control de acceso por roles (RBAC) dual, respaldado por consultas asíncronas AJAX y seguridad de servidor PHP 8 + PDO MySQL.

---

### 🛡️ Características Principales
- **Seguridad Antivulnerabilidades:** Conexión PDO con sentencias preparadas contra inyección SQL y contraseñas protegidas con `password_hash()` (Bcrypt).
- **Conector Universal MAMP / XAMPP:** El archivo `api_hotel/conexion.php` detecta automáticamente si se está ejecutando en MAMP en macOS (usando socket Unix y contraseña `'root'`) o en XAMPP en Windows (usando `localhost` y contraseña vacía).
- **Esquema Oficial Precargado (`database.sql`):** Incluye las 7 tablas relacionales del sistema (`empleados`, `cliente`, `habitaciones`, `reserva`, `actividades`, `cliente_actividad`, `recepcion`) con habitaciones temáticas Safari y 5 cuentas de prueba listas para usar.
- **Diseño Editorial y Moderno:** Barra de Portafolio Técnico superior (`.hallmark-header`), tarjetas interactivas con elevación en hover y tema de color *Obsidiana & Oro Safari*.

---

### 👨‍💻 Autor / Author
**Imanol (`@imaforbes`)** — *Full-Stack Web & Applications Developer*  
[Repositorio Oficial en GitHub ↗](https://github.com/Imaforbes/Hotel-Safaris)
