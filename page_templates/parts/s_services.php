<?php
global $count_nr;
global $section;
global $CleanScriptCore;

$section_color = stripslashes($section['section_color']);
?>
<!--Services section START-->
<section class="services" id="<?php echo $section['section_type'] . $count_nr; ?>">
    <div class="container">
        <div class="row">
            <!--Main section title & subtitle START-->
            <div class="col-sm-12">
                <h1 class="sectionTitle" style="border-bottom:3px solid <?php echo $section['section_color']; ?>"><?php echo stripslashes($section['section_title']); ?></h1>
                <div class="sectionSubtitle"><?php echo stripslashes($section['section_subtitle']); ?></div>
            </div>
            <!--Main section title & subtitle END-->
        </div>
        <div class="row">

            <?php
            for ($i = 1; $i < 10; $i++) {
                $box_icon = $box_title = $box_description = '';
                $box_icon = stripslashes($section['box' . $i . '_icon']);
                $box_title = stripslashes($section['box' . $i . '_title']);
                $box_description = stripslashes($section['box' . $i . '_description']);
                if (empty($box_icon)) {
                    continue;
                }
                ?>

                <!-- Single column of information START -->
                <div class="col-sm-4 isHidd">
                    <!--icon container and icon START-->
                    <div class="circle"><i class="fa <?php echo $box_icon; ?>"></i></div>
                    <!--icon container and icon END-->
                    <!--column title START-->
                    <h3><?php echo $box_title; ?></h3>
                    <!--column title END-->
                    <!-- Column Content Text START-->
                    <p>
                        <?php echo $box_description; ?>
                    </p>
                    <!-- Column Content Text END-->
                </div>
                <!-- Single column of information END -->
            <?php } ?>


        </div>
    </div>
</section>
<!--Services section END-->
