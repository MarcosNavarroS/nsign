
#  Marcos Navarro Nsign prueba técnica

## Presentación
¡Hola! Soy Marcos Navarro y en esta prueba técnica mostraré mis aptitudes en el desarrollo de una api con PHP y Symfony.

En este caso, he desarrollado dos endpoints que se nutren de la api de stackexchange para consultar los datos, tal y como sé pedía en las especificaciones de la prueba.

Para estructurar el código he utilizado arquitectura hexagonal y para el modelaje de las entidades he utilizado domain driven design.

## Documentación

Los endpoints desarrollados son dos, uno que permite consultar una question mediante su id y otro que te lista las questions que están ahora mismo promocionadas, permitiendo filtrar por fechas, paginar y ordenar los resultados.
Inicialmente, se consultan los datos de stackoverflow, pero es posible cambiar entre las diferentes páginas del ecosistema de stackexchange modificando la variable de entorno "STACKEXCHANGE_API_SITE".

He testeado la mayor parte de la funcionalidad, ya sea con test unitarios, de integración o funcionales. 
En mi experiencia, consensuamos con el equipo que tipo de test desarrollamos para cada parte de la aplicación, aunque siempre buscando que este todo cubierto. 
Espero que haya sido suficiente en este caso. Para evitar que los test consuman rate limit de la api y para tener un entorno de test cerrado, las peticiones externas en los test atacan a un mock server.
En este caso concreto, al tener solo consulta de datos, las entidades de dominio no tienen prácticamente lógica de negocio, mas alla de almacenar datos, por ese motivo no tienen test unitarios.

A continuación detallo algunos comandos que hay que lanzar para ejecutar la aplicación o para ejecutar la interfaz gráfica de la definición de la api.

## Instalación y comandos útiles

Para ejecutar la aplicación es necesario tener instalado docker/docker-compose y make para lanzar los comandos siguientes.

Para poder hacer uso de la api por primera vez, lanzar el siguiente comando en un terminal:

```bash
  make prepare
```
Este comando va a hacer el build de las imágenes de docker, levantarlas e instalar dependencias de composer. Con esto ya estará todo listo para hacer uso de la api.

Las siguientes veces que se quiera levantar el proyecto tan solo será necesario ejecutar el siguiente comando:
```bash
  make up
```
Para ejecutar los tests, tan solo hay que lanzar el siguiente comando:
```bash
  make tests
```
Para abrir una terminal en el contenedor:
```bash
  make bash
```

Con el siguiente comando, se levanta la interfaz gráfica de swagger(http://localhost:999/), desde donde podréis ver la definición de los endpoints del api:
```bash
  make swagger
```

## Palabras finales
Espero que os haya gustado la prueba y agradeceros la oportunidad de participar en el proceso. Un saludo.