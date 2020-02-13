<?php

require_once('../../../private/initialize.php');

$page_set = find_all_pages();

$page_title = 'Pages';

include(SHARED_PATH . '/staff_header.php');

?>

<div id="content">

    <div id="pages_listing">
        <h1>Pages</h1>
        <div class="actions"><a href="<?php echo url_for('/staff/pages/new.php'); ?>" class="actions">Create New Page</a></div>
    </div>

    <table class="list">
        <tr>
            <th>ID</th>
            <th>Subject ID</th>
            <th>Position</th>
            <th>Visible</th>
            <th>Name</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <?php while ($page = mysqli_fetch_assoc($page_set)) { ?>
            <tr>
                <td> <?php echo h($page['id']); ?></td>
                <td> <?php echo h($page['subject_id']); ?></td>
                <td><?php echo h($page['position']); ?></td>
                <td> <?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></td>
                <td> <?php echo h($page['menu_name']); ?></td>
                <td><a class="action" href="<?php echo url_for('staff/pages/show.php?id=' . h(u($page['id']))); ?>">View</a></td>
                <td><a class="action" href="<?php echo url_for('/staff/pages/edit.php?id=' . $page['id']); ?>">Edit</a></td>
                <td><a class="action" href="<?php echo url_for('/staff/pages/delete.php?id=' . $page['id']); ?>">Delete</a></td>

            </tr>


        <?php } ?>
    </table>
    <?php mysqli_free_result($page_set); ?>
</div>


<?php include(SHARED_PATH . '/staff_footer.php'); ?>