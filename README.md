# libPHP_MySQLConnection
Este  proyecto  es  una  clase  en  PHP  cuyo  objetivo  es  agilizar  el  uso  de  una conexión con un servidor MySQL ya que es  muy común en proyectos WEB. La idea de  esta  clase es  usar un  estilo  orientado a  objetos que permita al usuario realizar operaciones CRUD de manera SEGURA usando Prepared Statements.

Las ventajas de usar Prepared Statements es que evitas ataques de tipo SQL Injection los cuales son muy comunes en proyectos WEB que se crean desde cero, tambien conocidos comunmente como (Legacy Code).

A continuación se muestra los ejemplos de código para realizar las operaciones CRUD.

### Inicialización
Para empezar a usar la clase es necesario importarla con include, después creamos una  instancia de la clase, una  vez hecho  esto es
necesario llamar a los métodos setters para asignar  la IP,  el usuario,  el password,  la base de datos, incluso el puerto si es que 
esta usando uno diferente el 3306. Por ultimo llamamos al método connect() el cual intenta establecer la conexión con el SGDB.
```PHP
include_once "MySQLConnection.php";

$localhost = new MySQLConnection();
$localhost->setIP("127.0.0.1");
$localhost->setDatabase("Database");
$localhost->setPassword("Password");
$localhost->setUsername("UserName");
$localhost->connect();
```

### INSERT
En el ejemplo de abajo podemos ver como realizar una inserción de un registro con tan solo tres lineas de código. Si no conoces los Prepared 
Statements te recomiendo que leas este articulo de la pagina oficial de [https://www.php.net/manual/es/mysqli-stmt.bind-param.php](https://www.php.net/manual/es/mysqli-stmt.bind-param.php)
```PHP
$BIND_PARAMS = array("sid","Atun",500, 5.55);
$SQL_INSERT = "INSERT INTO productos(nombre, cantidad, precio) VALUES(?,?,?)";
$localhost->execute( $SQL_INSERT, $BIND_PARAMS);
```

### DELETE
En el ejemplo que se muestra a continuación se puede observar como borrar un registro, igual utilizando solo tres lineas de código.
```PHP
$BIND_PARAMS = array("s","111");
$SQL_DELETE = "DELETE FROM test WHERE ID = ?";
$localhost->execute( $SQL_DELETE, $BIND_PARAMS);
```
En caso de que no se requieran pasar parámetros a la consulta se debe usar null como argumento. Esto aplica para cualquier operación CRUD.
```PHP
$SQL_DELETE = "DELETE FROM test";
$localhost->execute( $SQL_DELETE, null);
```

### SELECT
Ejemplo con parametros
```PHP
$BIND_PARAMS = array("s","111");
$SQL_SELECT = "SELECT * FROM test WHERE ID = ?";
$resultset = $localhost->execute( $SQL_SELECT, $BIND_PARAMS);

if($resultset->num_rows > 0)
{
    while( $row = $resultset->fetch_assoc() )
    {
        echo $row['ID']."<BR>";
    }
}
else
{
    echo "NO HAY NINGUN RESULTADO RETORNADO <BR>";
}
$resultset->close();

```
Ejemplo sin parametros
```PHP
$SQL_SELECT = "SELECT * FROM test";
$resultset = $localhost->execute( $SQL_SELECT, null);
if($resultset->num_rows > 0)
{
    while( $row = $resultset->fetch_assoc() )
    {
        echo $row['ID']."<BR>";
    }
}
else
{
    echo "NO HAY NINGUN RESULTADO RETORNADO <BR>";
}
$resultset->close();
```
