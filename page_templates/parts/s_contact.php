<?php
global $count_nr;
global $section;
global $CleanScriptCore;
$CleanScriptCore = new CleanScriptCore();

$contact_info_title = stripslashes($section['contact_info_title']);
$section_color = $section['section_color'];
if (isset($section['section_type'])) {
    $section_type = stripslashes($section['section_type']);
}
if (isset($section['section_title'])) {
    $section_title = stripslashes($section['section_title']);
}
if (isset($section['section_subtitle'])) {
    $section_subtitle = stripslashes($section['section_subtitle']);
}
?>
<!--Contact section START-->
<?php
?>
<section class="contact" id="<?php echo $section_type . $count_nr; ?>">
    <div class="container">
        <div class="row">
            <!--Main section title & subtitle START-->
            <div class="col-sm-12">
                <h1 class="sectionTitle" style="border-bottom:3px solid <?php echo $section_color; ?>"><?php echo $section_title; ?></h1>
                <div class="sectionSubtitle"><?php echo $section_subtitle; ?></div>
            </div>
            <!--Main section title & subtitle END-->
        </div>
        <div class="row">
            <div class="col-sm-6 isHidd">
                <h3><?php echo $section['contact_info_title']; ?></h3>
                <p>
                    <?php echo $CleanScriptCore->cs_text_str_replace(stripslashes($section['contact_info_description'])); ?>
                </p>
                <p>
                    <strong><?php echo stripslashes($section['company_name']); ?></strong><br />
                    <?php echo $CleanScriptCore->cs_text_str_replace(stripslashes($section['company_address'])); ?>
                </p>
                <p>
                    <?php
                    if (isset($section['contact_email'])) {
                        $contact_email = stripslashes($section['contact_email']);
                    }
                    if (isset($section['contact_phone'])) {
                        $contact_phone = stripslashes($section['contact_phone']);
                    }
                    if (isset($section['contact_website'])) {
                        $contact_website = stripslashes($section['contact_website']);
                    }
                    ?>
                    <strong>Email</strong>: <?php echo $contact_email; ?><br />
                    <strong>Phone</strong>: <?php echo $contact_phone; ?><br />
                    <strong>Website</strong>: <?php echo $contact_website; ?><br />
                </p>
                <ul class="social">
                    <?php
                    for ($i = 1; $i < 9; $i++) {
                        echo $icon = $icon_link = '';
                        $icon = stripslashes($section['icon' . $i]);
                        $icon_link = stripslashes($section['icon' . $i . '_link']);
                        if (!empty($icon)) {
                            ?>
                            <li>
                                <a href="<?php echo $icon_link; ?>">
                                    <i class="fa <?php echo $icon; ?>"></i>
                                </a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="col-sm-6 isHidd">
                <h3><?php echo stripslashes($section['contact_form_title']); ?></h3>
                <p><?php echo stripslashes($section['contact_form_description']); ?></p>
                <?php $csc_cf7id = stripslashes($section['csc_cf7id']);
                ?>
                <?php
                if (function_exists('wpcf7_add_shortcodes')) {
                    $contact_form = do_shortcode('[contact-form-7 id="' . $csc_cf7id . '"]');
                    if (strpos($contact_form, '404 "Not Found"') === FALSE) {
                        echo $contact_form;
                    } else {
                        $csc_admin_url = admin_url('admin.php?page=wpcf7-new');
                        ?>
                        <h4>Contact Form NOT set!</h4><a href="<?php echo $csc_admin_url; ?>">Click here to add a new one</a> Then set it in the contact Section from the dropdown.
                        <?php
                    }
                } else {
                    ?>
                    <h3>Please install and activate Contact Form 7 Plugin</h3>
                    <?php
                }
                //wpcf7_contact_form
                ?>
            </div>
        </div>
    </div>
</section>
<!--Contact section END-->