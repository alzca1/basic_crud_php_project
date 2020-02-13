<?php 

ob_start(); // output buffering encendido. 


// Con estas constantes PHP, definimos rutas de archivo
// __FILE__ retorna la ruta actual a este archivo
// dirname() retorna la ruta al directorio padre del archivo

// El primero está diciendo: esta constante se llamará PRIVATE_PATH
// Y es igual al nombre del directorio de el archivo en el que estamos (initialize.php)
define("PRIVATE_PATH", dirname(__FILE__));
// Lo mismo, pero subimos un nivel: PROJECT_PATH es igual al directorio que contenga PRIVATE_PATH
// es decir, el directorio raiz
define("PROJECT_PATH", dirname(PRIVATE_PATH));
// el PUBLIC_PATH es igual a PROJECT_PATH + /public
define("PUBLIC_PATH", PROJECT_PATH . '/public');
// el SHARED_PATH es igual a PRIVATE_PATH + /shared
define("SHARED_PATH", PRIVATE_PATH . '/shared');

// Para generar la ruta de forma dinámica, se plantea la siguiente lógica
// Generamos una variable que calculará el número de caracteres desde el
// inicio de la ruta relativa raiz del sitio hasta la carpeta /public
// definimos la variable $public_end igual a la función strpos()
// el primer argumento de la función será la ruta actual del script
// que se está ejecutando (en este caso initialize.php) en el server
// para ello usamos $_SERVER, que toma como índice SCRIPT_NAME
// SCRIPT_NAME proporciona la rutal del script actual
// dentro de esa ruta, el segundo argumento '/public' es la cadena
// que queremos buscar. Con ello obtenemos el número de caracteres de la
// ruta hasta el caracter antes de /public. Por eso a ese numero, 
// añadimos 7, porque será a partir de /public cuando podamos ir jugando
// con las rutas

$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7 ;

// Una vez tenemos la cifra a partir de la cual podemos comenzar a añadir
// rutas, creamos la variable $doc_root. Con dicha variable, lo que 
// hacemos es guardar la ruta completa hasta /public (que será dinámica, 
// función de si estamos en desarrollo o producción)

$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end) ;

// Al tratarse de una variable constante, la convertimos en tal y ya
// podemos usarla
 define("WWW_ROOT", $doc_root);

 require_once('functions.php');
 require_once('database.php');
 require_once('query_functions.php');

 $db = db_connect(); 

?>

