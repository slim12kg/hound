<?php
declare (strict_types = 1);

session_start();

include '../config.php';
include '../libs/hound.php';

include 'includes/functions.php';

$temppass = $_SESSION['temppass'];

if ((string) $temppass === (string) $password) {
    include 'includes/header.php';
    include 'includes/sidebar.php'; ?>

    <div class="content">
        <div class="content main">
            <h2>Configuration</h2>

            <?php
            if ($_POST['op'] === 'mod') {
                $sitename = $_POST['sitename'];
                $templatename = $_POST['templatename'];
                $slogan = $_POST['slogan'];

                $file = '../site/config.txt';
                $arrayvalue = array(
                    'Title' => $sitename,
                    'Template' => $templatename,
                    'Slogan' => $slogan,
                    'Version' => houndGetParameter('version'),
                );

                if (writeParam($arrayvalue, $file)) {
                    echo '<div class="thin-ui-notification thin-ui-notification-success">Changes saved.</div>';
                } else {
                    echo '<div class="thin-ui-notification thin-ui-notification-error">An error occurred while saving changes.</div>';
                }
            }
            ?>

            <form role="form" id="commentForm" action="" method="post">
                <input type="hidden" value="mod" name="op">

                <p>
                    <b>Site Title</b><br>
                    <input name="sitename" value="<?php echo houndGetParameter('title');?>" required type="text" id="sitename" class="thin-ui-input" size="64">
                    <br><small>The title of your website.</small>
                </p>

                <p>
                    <b>Tagline</b><br>
                    <input name="slogan" value="<?php echo houndGetParameter('slogan');?>" type="text" id="slogan" class="thin-ui-input" size="64">
                    <br><small>In a few words, explain what this site is about.</small>
                </p>

                <p>
                    <b>Site Template</b>
                    <br><small>Name of your template folder.</small>
                    <div class="thin-ui-select-wrapper">
                        <select name="templatename" id="templatename">
                            <?php
                            $dirtmpl = scandir('../site/templates');
                            foreach ($dirtmpl as $itemtpl) {
                                if (is_dir('../site/templates/' . $itemtpl) && ($itemtpl != '.') && ($itemtpl != '..')) {
                                    if ($itemtpl === houndGetParameter('template')) {
                                        $sel2 = 'selected';
                                    } else {
                                        $sel2 = '';
                                    }

                                    echo "<option $sel2 value=\"$itemtpl\">$itemtpl</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </p>

                <p><button type="submit" class="thin-ui-button thin-ui-button-primary">Save Changes</button></p>
            </form>
        </div>
    </div>
    <?php
    include 'includes/footer.php';
}
else {
    php_redirect('index.php?err=1');
}
