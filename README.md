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
 - Se puede eliminar el empleado desde el dashboard.
 - Se puede importar por CSV el listado de empleados (Para prueba importa employees.csv que está en el repositorio).
 - La imagen del diagrama E-R puedes buscarlo en el repositorio como Diagrama-entidad-relacion.PNG
 