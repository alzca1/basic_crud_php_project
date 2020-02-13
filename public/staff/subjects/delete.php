<?php

require_once '../../../private/initialize.php';


if (!isset($_GET['id'])) {
    redirect_to(url_for('/staff/subjects/index.php'));
}

$id = $_GET['id'];


if(is_post_request()){
    $result = delete_subject($id); 
    redirect_to(url_for('/staff/subjects/index.php'));
}else{
    $subject = find_subject_by_id($id);
}

$page_title = 'Delete Subject';
include(SHARED_PATH . '/staff_header.php');

?>

<div id="content">
    <a href="<?php echo url_for('/staff/subjects/index.php'); ?>" class="back-link">&laquo; Back to List</a>
    <div class="subject delete">
        <h1>Delete Subject</h1>
        <p>Are you sure you want to delete this subject?</p>
        <p class="item">Subject Name: <b><?php echo h($subject['menu_name']); ?></b></p>
        <form action="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>" method="post">
            <div id="operations">
                <input type="submit" value="Delete Subject" name="commit" />
            </div>
        </form>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>