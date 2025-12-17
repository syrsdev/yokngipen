# YOKNGIPEN

Platform ini dibuat sebagai jembatan untuk penyelenggara dan calon peserta event untuk pemesanan tiket event.

## Tech Stack

**Core:**  HTML, CSS, JS

**Framework & Library:** Laravel, Bootstrap, Breeze

# Installation

Clone Project

```bash
  git clone https://github.com/syrsdev/yokngipen.git
  cd yokngipen
```

Open & Install Project

```bash
  composer install  
  npm install

  cp .env.example .env

  php artisan migrate
  # atau  
  php artisan migrate --seed
  # atau
  php artisan migrate:fresh --seed

   php artisan key:generate
```

## Run Locally

Open Terminal

```bash
  composer run dev
```
