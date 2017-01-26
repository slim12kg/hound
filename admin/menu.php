<?php
declare (strict_types = 1);

session_start();

include '../config.php';
include '../libs/hound.php';
include 'libs/houndAdmin.php';

include 'includes/functions.php';

$temppass = $_SESSION['temppass'];
$page = houndSanitizeString($_GET['page']);

$houndAdmin = new houndAdmin('', '');
$param = $houndAdmin->read_param('../site/config.txt');

if ((string) $temppass === (string) $password) {
    include 'includes/header.php';
    include 'includes/sidebar.php'; ?>

    <div class="content">
        <div class="content main">
            <?php
            if ($_GET['op'] === "del") {
                $file = '../site/pages/menu-' . $page . '.txt';

                if (unlink($file)) {
                    echo '<div class="thin-ui-notification thin-ui-notification-success">Menu item deleted successfully.</div>';
                } else {
                    echo '<div class="thin-ui-notification thin-ui-notification-error">An error occurred while deleting menu item.</div>';
                }
            }
            ?>
            <h2>Menu</h2>
            <div>
                <a href="new-menu.php" class="thin-ui-button thin-ui-button-primary"><i class="fa fa-plus" aria-hidden="true"></i> New menu item</a>
            </div>

            <br>
            <table class="default zebra hd-sortable" data-table-theme="default zebra hd-sortable">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fileindir = $houndAdmin->get_files('../site/pages/');
                    foreach ($fileindir as $file) {
                        if (preg_match("/\menu\b/i", $file)) {
                            $parampage = $houndAdmin->read_param($file);
                            $nameofmenu = str_replace('../site/pages/', '', $file);
                            $nameofmenu = str_replace('menu-', '', $nameofmenu);
                            $nameofmenu = str_replace('.txt', '', $nameofmenu);
                            $i++;

                            echo '<tr>
                                <td>' . $parampage['order'] . '</td>
                                <td>' . $parampage['item'] . '</td>
                                <td>' . $parampage['link'] . '</td>
                                <td><a href="edit-menu.php?page=' . $nameofmenu . '">Edit</a></td>
                                <td><a style="color: red" onclick="return confirm(\'Are you sure?\');" href="menu.php?op=del&page=' . $nameofmenu . '">Delete</a></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    include 'includes/footer.php';
}
else {
    php_redirect('index.php?err=1');
}
