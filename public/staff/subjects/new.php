<?php require_once '../../../private/initialize.php';

if (is_post_request()) {
    $subject = []; 
    $subject['menu_name'] = $_POST['menu_name'] ?? '';
    $subject['position'] = $_POST['position'] ?? '';
    $subject['visible'] = $_POST['visible'] ?? '';

    $result = insert_subject($subject);
    if($result === true){
        $new_id = mysqli_insert_id($db);
        redirect_to(url_for('/staff/subjects/show.php?id=' . $new_id));
    }else{
        $errors = $result; 
    }
    
} else {

}


// aquí lo que hacemos es contabilizar el número de pages actualmente
// para poder establecer el número que aparecerá en la position
$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set) + 1;
mysqli_free_result($subject_set);


$subject = [];
$subject['position'] = $subject_count;

$page_title = "Create Subject";

include SHARED_PATH . '/staff_header.php';
?>

<div id="content">

    <a href="<?php echo url_for('/staff/subjects/index.php'); ?>" class="back-link">&laquo Back to List</a>

    <div class="subject new">

        <h1>Create Subject</h1>
        <?php echo display_errors($errors); ?>
        <form action="<?php echo url_for('/staff/subjects/new.php'); ?>" method="post">

            <dl>
                <dt>Menu Name</dt>
                <dd><input type="text" name="menu_name" value=""></dd>
            </dl>

            <dl>
                <dt>Position</dt>
                <dd>
          <select name="position">
            <?php
            for ($i = 1; $i <= $subject_count; $i++) {
              echo "<option value=\"{$i}\"";
              if ($subject["position"] == $i) {
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
                    <input type="hidden" name="visible" value="0">
                    <input type="checkbox" name="visible" value="1">
                </dd>
            </dl>
            <div id="operations">
                <input type="submit" value="Create Subject">
            </div>

        </form>
    </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>