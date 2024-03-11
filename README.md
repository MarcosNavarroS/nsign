
#  Marcos Navarro Nsign prueba técnica

## Instalación y comandos útiles

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

Con el siguiente comando, levantares la interfaz gráfica de swagger, desde donde podréis ver la documentación de los endpoints del api:
```bash
  make swagger
```

## Documentación

El proyecto está desarrollado aplicando arquitectura hexagonal y domain driven design y para el acceso a datos se está utilizando la api de stack exchange.

Por defecto se están consultando datos de stackoverflow, pero podemos cambiar a cualquiera de las páginas del ecosistema de stackexchange cambiando la variable de entorno STACKEXCHANGE_API_SITE.

En cuanto a los test, las peticiones a la api externa, se simulan con un mock server, para evitar superar el límite de peticiones que tienen establecido.
Los test unitarios que ya eran cubiertos por algun test de integracion se han obviado. En una situacion real se llegaria a un consenso con el equipo sobre que alcance buscamos en la cobertura y la implementacion de los test.
Por otro lado, por la tipologia de la prueba tecnica, las entidades de dominio han quedado anemicas, por ese motivo no he creado test unitarios de ellas.

Para acceder a la definición de los endpoints, levantar el contenedor de swagger y acceder a http://localhost:999/