# BasicStore

Tienda muy básica, donde un cliente puede comprar un solo producto con un 
valor fijo, el cliente necesita únicamente proporcionar su nombre, dirección de correo 
electrónico y su número de celular para efectuar la compra. Una vez un cliente procede 
a la compra de su producto, como es debido, el sistema debe saber que se creó una 
nueva orden de pedido, asignarle su código único para identificarla y saber si esta se 
encuentra pendiente de pago o si ya se ha realizado un pago para poder “despacharla”. 

## Comenzando 🚀

_Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._

Mira **Deployment** para conocer como desplegar el proyecto.


### Pre-requisitos 📋

_Que cosas necesitas para instalar el software y como instalarlas_

```
NPM
PHP
APACHE
Base de datos Relacional (Mysql, Postgres)
```

### Instalación 🔧

_Realice los siguientes paso para instalar el proyecto de manera local_

_1. Clonar el repositorio_

```
https://github.com/jeantech-zz/BasicProjecStore
```

_2. Ejecutar el comando_

```
npm install
```
```
npm run dev
```
_3. Configurar el archivo .env con nuestros datos de configuraciond de base de datos y servicio de correo_

```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

```
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```
_3. Ejecutar el migraciones y datos de iniciales_

```
 php artisan migrate --seed
```


## Ejecutando las pruebas ⚙️

_Para ejecutar las pruebas se requiere_
```
 vendor/bin/phpunit 
```


## Despliegue 📦

_Para desplegar el proyecto se requiere ejecutar el comando_
```
 php artisan serve
```

## Construido con 🛠️

_Herramientas utilizastadas_

* [Laravel](https://laravel.com/) - El framework Backend
* [bootstrap](https://getbootstrap.com/) - Frontend


## Versionado 📌

Usamos [Git](https://github.com/) para el versionado.

## Autor✒️

* **Jennifer Andrea Tenorio** - *Desarrolladora* - [jeantech](https://github.com/jeantech-zz)
