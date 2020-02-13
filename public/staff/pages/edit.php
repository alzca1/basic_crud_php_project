<?php

require_once '../../../private/initialize.php';
// Aquí al cargar la página evaluamos si $_GET['id] existe, dado que si no existe
// no podemos editar un elemento que no existe. Redirigimos a index de pages. 
if (!isset($_GET['id'])) {
    redirect_to(url_for('/staff/pages/index.php'));
}

// Si existe, lo guardamos en la variable $id
$id = $_GET['id'];

// Venimos de un POST request? Si es así, apunta :D
if (is_post_request()) {
    //inicializamos el array $page y comenzamos a meterle keys y values (representados por $_POST['randon_key'])
    $page = [];
    $page['id'] = $id;
    $page['subject_id'] = $_POST['subject_id'] ?? '';
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? '';
    $page['content'] = $_POST['content'] ?? '';

    // Una vez hemos asignado valores a las diferentes keys de $page, aplicamos la fórmula para actualizar en bbdd
    // que en este caso se llama update_page() y que toma como referencia 
    $result = update_page($page);
    redirect_to(url_for('/staff/pages/show.php?id=' . $id));
} else {
    // si no venimos de POST request, inicializamos la variable $page con una función que traerá la info sobre $id desde
    // la bbdd 
    $page = find_page_by_id($id);
    // averiguaremos de nuevo cuantas rows tienen las subjects para poder meterlas en el formulario
    $page_set = find_all_subjects();
    // inicializamos $page_count con el número de rows que tiene $page_set
    $page_count = mysqli_num_rows($page_set);
    // liberamos memoria
    mysqli_free_result($page_set);
}


$page_title = "Edit Page";
// metemos el header de la página
include SHARED_PATH . '/staff_header.php';
?>


<div id="content">
    <a href="<?php echo url_for('/staff/pages/index.php'); ?>">Go Back</a>
    <div class="page edit">
        <h1>Edit Page</h1>
        <!-- La acción del form apuntará a edit.php junto al id, que pasaremos por las funciones h()(htmlspecialchars) y u()(urlencode) -->
        <form action="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($id))); ?>" method="post">


            <dl>
                <dt>Subject</dt>
                <dd>
                    <select name="subject_id">
                        <?php
                        // Aquí reclamamos que la bbdd nos muestre todos los subjects contenidos para 
                        // mostrarlos en el desplegable
                        $subject_set = find_all_subjects();
                        //Mientras haya elementos dentro del $subject_set...
                        while ($subject = mysqli_fetch_assoc($subject_set)) {
                            // haz echo por cada uno de ellos con el elemento <option>
                            // siendo su valor $subject['id] 
                            echo "<option value=\"" . h($subject['id']) . "\"";
                            // y añadiendo la propiedad "selected"
                            // a aquel subject['id'] que coincida con page['subject_id']
                            if ($page['subject_id'] == $subject['id']) {
                                echo " selected";
                            }
                            //por último, añade el valor de $subject['menu_name] como texto a
                            // mostrar de <option> dentro del desplegable
                            echo ">" . h($subject['menu_name']) . "</option>";
                        }
                        mysqli_free_result($subject_set);

                        ?>


                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Menu Name</dt>
                <dd> <input type="text" name="menu_name" value="<?php echo h($page['menu_name']); ?>" /> </dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name="position">
                        <?php for ($i = 1; $i <= $page_count; $i++) {
                            echo "<option value=\"{$i}\"";
                            if ($page['position'] == $i) {
                                echo " selected";
                            }
                            echo ">{$i} </option>";
                        }
                        ?>
                    </select>
                </dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type="hidden" name="visible" value="0">
                    <input type="checkbox" name="visible" value="1" <?php if ($page['subject_id'] == "1") {
                                                                        echo "checked";
                                                                    } ?> />
                </dd>
            </dl>

            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea name="content" cols="60" rows="10"><?php echo h($page['content']); ?></textarea>
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Edit Page">
            </div>
        </form>
    </div>
</div> <?php include SHARED_PATH . '/staff_footer.php'; ?>