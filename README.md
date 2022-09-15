# basicStore

Prerequisitos
Tener instalado 
- npm
- php
- Cualquier motor de Base de datos relacional (postgres, mysql, etc)

Instalación
1. Clonar el repositorio: 
git clone https://github.com/jeantech-zz/BasicProjecStore

2. Instalar NPM packages:
    npm install 
    npm run dev

3. Crear una base de datos y configurarla en el archivo .env

4. Ejecutar migraciones:
 php artisan migrate --seed
 
5. desplegar la aplicación:
php artisan serve
