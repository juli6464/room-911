# Despliegue proyecto Laravel + Vue + Tailwind + Mysql
 - Copar archivo .env.example y  renombrarlo a .env y agregar el usuario, nombre de base de datos y contraseña
 - npm install
 - composer install
 - Crear Db en mysql room_911
 - Ejecutar php artisan migrate --seed
 - Para levantar el backend php artisan serve
 - Para levantar el frontend npm run dev
 - Ingresar a http://127.0.0.1:8000/ para ver el aplicativo

# Qué se puede probar?
 - Iniciar sesión con un admin existente o empleado .
 - En el dashboard se fuede filtrar por id, nombre, apellido, departamento y  usar todos los filtros.
 - Se puede crear un empleado haciendo clic en nuevo empleado.
 - Se puede editar el empleado haciendo click en update del que se desee mdificar.
 - Se puede eliminar el empleado desde el dashboard.
 - Cada intento de acceso se conserva en BD  la hora y el empleado que lo está haciendo; ya sea que tenga o no éxito,
y/o que el empleado no esté registrado en BD.
 - En el botón de history del empleado se puede descargar el PDF del numero de intentos, con fechas de intento y el nombre del empleado.
 - Para crear un Usuario admin en la sección de Login se crea con usuario que sea único y que tenga por lo menos 6 caracteres.
 - Se puede importar por CSV el listado de empleados (Para prueba importa employees.csv que está en el repositorio).
 - La imagen del diagrama E-R puedes buscarlo en el repositorio como Diagrama-entidad-relacion.PNG.
 