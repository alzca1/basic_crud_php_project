<?php

require_once('../../../private/initialize.php');


// esta parte lo que hace es revisar si se ha producido un POST. Si no lo ha hecho, pasa a
// definir las diferentes variables insertadas en html con ''; 
if(is_post_request()) {

    // Si se ha producido un POST, los diferentes valores de $page['key'] estarán almacenados
    // en $_POST y lo que hacemos es recuperarlos para enviarlos a la base de datos. 
  $page = []; // inicializamos el array y comenzamos a meterle keys y valores. 
  $page['subject_id'] = $_POST['subject_id'] ?? '';
  $page['menu_name'] = $_POST['menu_name'] ?? '';
  $page['position'] = $_POST['position'] ?? '';
  $page['visible'] = $_POST['visible'] ?? '';
  $page['content'] = $_POST['content'] ?? '';
    // Una vez tenemos todos los keys y sus respectivosvalores, los remitimos a la bbdd con la función 
    //insert_page($page); 
  $result = insert_page($page);
  // hacemos un query a la bbdd para saber el id de la nueva página creada
  $new_id = mysqli_insert_id($db);
  // redireccionamos a la página show de la nueva página creada (junto con la variable $new_id)
  redirect_to(url_for('/staff/pages/show.php?id=' . $new_id));

} else {
    // Si no se ha producido un POST, inicializamos todas las variables que vamos a recoger en el form; 
  $page = [];
  $page['subject_id'] = '';
  $page['menu_name'] = '';
  $page['position'] = '';
  $page['visible'] = '';
  $page['content'] = '';
    // ejecutamos la función find_all_pages() para realizar acto seguido el $page_count, con la función
    // mysqli_num_rows($page_Set) a la que sumamos 1 dado que vamos a crear una nueva página y por tanto
    // habrá que sumarla al cómputo total de páginas. 
  $page_set = find_all_pages();
  $page_count = mysqli_num_rows($page_set) + 1;
  // liberamos $page_set para ahorrar memoria. 
  mysqli_free_result($page_set);

}

?>

<!-- Ojo, $page_title es una variable ya definida que permite poner título a la página --> 
<?php $page_title = 'Create Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

  <div class="page new">
    <h1>Create Page</h1>

    <!-- La acción que tendrá la form será redirigir de nuevo a new.php. De esta forma podremos hacer
    el procesamiento del form con la función is_post_request(), enviar datos a la bbdd (si procede) y 
    redirigir hacia la página show.php con los datos del nuevo registro. 
    
    -->
    <form action="<?php echo url_for('/staff/pages/new.php'); ?>" method="post">
      <dl>
        <dt>Subject</dt>
        <dd>
          <select name="subject_id">
          <!--Aquí insertamos la lógica para mostrar los registros de subjects en un desplegable.
          Para ello usamos un while, asignando a la variable $subject el valor de cada una de las rows
          que contiene $subject_set. Mientras dicha función no se quede sin rows que mostrar, nosotros
          procesaremos las rows y asignaremos tantos elementos <option> como subjects haya en la bbdd. 
          Para ello el value de option será igual al id de cada uno de los subjects. Además, envolvemos
          $subject['key] con la función h, que aplica la función htmlspecialchars() útil para evitar que 
          el texo introducido por el usuario contenga código HTML.
          
           -->
          <?php
            $subject_set = find_all_subjects();
            while($subject = mysqli_fetch_assoc($subject_set)) {
              echo "<option value=\"" . h($subject['id']) . "\"";
              // aquí comparamos $['page_id] con $subject['id'] y si es el mismo, añadimos al elemento
              // <select> la propiedad "selected"
              if($page["subject_id"] == $subject['id']) {
                echo " selected";
              }
              // el texto que contendrá <option> será el valor de $subject['menu_name']
              echo ">" . h($subject['menu_name']) . "</option>";
            }
            //liberamos memoria vaciando $subject_set
            mysqli_free_result($subject_set);
          ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo h($page['menu_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <?php
            //aquí hacemos un for-loop para mostrar todos los valores posibles en position
              for($i=1; $i <= $page_count; $i++) {
                echo "<option value=\"{$i}\"";
                if($page["position"] == $i) {
                  echo " selected";
                }
                echo ">{$i}</option>";
              }
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1"<?php if($page['subject_id'] == "1") { echo " checked"; } ?> />
        </dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd>
          <textarea name="content" cols="60" rows="10"><?php echo h($page['content']); ?></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Page" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
