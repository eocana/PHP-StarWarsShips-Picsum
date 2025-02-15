# Prueba técnica puesto Junior PHP 

## 1. Crear una app PHP que carga un fichero CSV en una base de datos y visualiza datos en el navegador

### Objetivo

En este repositorio tienes el fichero __naves.csv__ es un fichero CSV delimitado por __;__ generado con datos de [SAWPI](https://swapi.dev/) una API abierta con datos del universo de Star Wars

Se trata de crear con PHP una mini aplicación que realice tres tareas:

* Importar el fichero CSV a una base de datos sqlite, de manera que cada fila del fichero corresponda a un registro en la tabla de la base de datos

* Visualizar en el navegador un listado de todos los registros. El listado debe ofrecer información resumida de cada registro pero también para cada registro disponer de acciones para:

  * Ver detalle del registro en otra pagina

  * Eliminar ese registro

* Mediante el navegador, permitir añadir un nuevo registro a la base de datos

### Aspectos a tener en cuenta

* Debes crear una base de datos sqlite (https://sqlite.org), que se almacena localmente en un fichero, de manera que la puedas subir al repositorio del proyecto. Para esta prueba no queremos accesos a servidores mysql ni similares.

* En tus manos esta definir todo el esquema de datos para la base de datos: tabla y registros

* Para importar el CSV a la base de datos en sqlite puedes crear un script php que lo haga por línea de comandos (terminal) o hacer una carga del fichero desde el navegador, o usar cualquier otra técnica ;) aquí decides tu. Lo importante es llegar a importar el CSV dentro de sqlite. Este es un proceso que solo debes hacer una vez para cargar la base de datos antes de su uso.

* En la parte de funcionamiento con el navegador no es necesario complicarte con el diseño, puedes usar bootstrap, o un CSS mínimo para poner las cosas con un aspecto usable y ya esta. En esta fase no nos interesa tanto un trabajo frontend como el hecho de ver como te enfrentas a todo el proyecto ...y tampoco queremos que te pases una semana entera con la prueba ;)

* A nivel de usar el navegador basta con que tu aplicación tenga un script de punto de entrada y arrancar con el mismo servidor web incluido en PHP, por ejemplo en plan:


```$ php -S localhost:9999 -t ./ ``` 

Nota: Recuerda que SQLite3 se instala habitualmente de serie con PHP (https://www.php.net/manual/es/book.sqlite3.php) por lo que en principio no necesitas mucho más.

## 2. Descargar datos de una API Publica y convertir a CSV

En esta segunda parte debes acceder a [PICSUM](https://picsum.photos/) y descargar datos.

Picsum.photos es una API publica, gratuita y abierta con fotos para descargar y usar como compos en diseños (de manera parecida a lo que hace con texto con el Lorem Ipsum).

### Objetivo

Debes conseguir descargar un listado con la información de las primeras 75 imágenes, y convertirlo a un fichero CSV delimitado por __;__

__Nota: Se trata de descargar el listado de información de las imágenes disponibles, no las imágenes en si.__

La manera en que lo hagas lo dejamos a tu elección. Puedes usar __curl__, o crearte un script PHP, o usar alguna utilidad del terminal, etc. El único requisito es que desarrolles la solución que te parezca más practica y la documentes para que nosotros podamos testearla y reproducir el proceso desde el terminal para comprobar su efectividad.

## Como entregar la pruebas

Para esta prueba, ya sea solo la 1, o ambas (1 y 2) debes crear un único repositorio PRIVADO en gitlab o en github (donde prefieras) y subir allí todo el código.

Luego, en función de que sitio uses, dar acceso a ese repositorio al usuario:

__GITLAB:__

usuario: actuadevhr / e-mail: actuadevhr@actuasolutions.com

__GITHUB:__

usuario: actuadev / e-mail: actuadev@actuasolutions.com

Con esto recibiremos una notificación de acceso y podremos entrar a ver el proyecto y descargarlo para testearlo.

## ¿Que valoramos?

Ante todo ten calma, esta prueba técnica esta pensada para ver como te apañas, a partir de un funcional mínimo, para desarrollar una cosa concreta con PHP que implica trabajo con base de datos, navegador, terminal y git.

Para el puesto PHP que estamos seleccionando lo que nos interesa es ver tu capacidad de buscar soluciones y desarrollar por tu cuenta.

Céntrate en resolver la primera parte, y ataca la segunda solo si vas bien de tiempo y tienes totalmente finalizada la primera.

La manera en que escribas el código, enfoques el proyecto y lo documentes nos dará información para evaluar tus capacidades.

En concreto nos va a interesar:

* Estilo código
* Documentación código y proyecto
* Trabajo con la base de datos
* Soluciones aportadas
* Rigor y seguridad aplicados

## Plazo de entrega

Se trata de unas prueba pensada para que no te robe mucho tiempo de tu día a día, y menos si actualmente estas trabajando.

Si este es el caso, en 2 o 3 de días puedes tener resueltas las dos partes, pero si ves que necesitas más tiempo avísanos a través del correo de contacto que ya tienes y lo gestionamos.
