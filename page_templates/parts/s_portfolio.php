<?php
global $count_nr;
global $section;
global $CleanScriptCore;
$CleanScriptCore = new CleanScriptCore();
$section_color = stripslashes($section['section_color']);
$rgbcolor = '';
?>
<!--Portfolio section START-->
<section class="portfolio"  id="<?php echo stripslashes($section['section_type']) . $count_nr; ?>">
    <div class="container">
        <?php if (isset($section['section_title']) && !empty($section['section_title'])) { ?>
            <div class="row">
                <!--Main section title & subtitle START-->
                <div class="col-sm-12">
                    <h1 class="sectionTitle" style="border-bottom:3px solid <?php echo $section_color; ?>"><?php echo stripslashes($section['section_title']); ?></h1>
                    <div class="sectionSubtitle"><?php echo stripslashes($section['section_subtitle']); ?></div>
                </div>
                <!--Main section title & subtitle END-->
            </div>
        <?php } ?>
    </div>
    <!--The gallery START-->
    <div class="gallery_list">
        <!--The gallery list START-->
        <ul>
            <?php
            $gallery = explode(',', stripslashes($section['gallery']));
            foreach ($gallery as $image_id) {
                ?>
                <!--Gallery item list element START-->
                <li class="isHidd">
                    <?php
                    $picture_link = wp_get_attachment_url($image_id);
                    $popup_type = "mpl-img";
                    $icon = 'fa-picture-o';
                    $post_content = get_post($image_id)->post_excerpt;
                    if (!empty($post_content)) {
                        if (strpos($post_content, 'maps') != FALSE) {
                            $icon = "fa-map-marker";
                            $start = strpos($post_content, 'src="') + 5;
                            $end = strpos($post_content, ' ', $start) - 1;
                            $end = $end - $start;

                            $post_content = substr($post_content, $start, $end);
                            $popup_type = "mpl-iframe";
                        } elseif (strpos($post_content, 'youtube') != FALSE || strpos($post_content, 'vimeo') != FALSE) {
                            $popup_type = "mpl-iframe";
                            $picture_link = $post_content;
                            $icon = "fa-video-camera";
                        } elseif (strpos($post_content, '://')) {
                            $picture_link = $post_content;
                            $popup_type = "mpl-none";
                            $icon = "fa-link";
                        }
                        $post_content = str_replace('"', "", $post_content);
                        $picture_link = $post_content;
                    }
                    ?>
                    <a href="<?php echo $picture_link; ?>" class="<?php echo $popup_type; ?> magnific-popup-link">
                        <?php echo wp_get_attachment_image($image_id, 'onetrol_gallery', FALSE, array('class' => 'img-responsive')); ?>
                        <div class="bottombar">
                            <span><?php echo get_post($image_id)->post_title; ?></span>
                            <div class="iconGrafic">
                                <i class="fa <?php echo $icon; ?>"></i>
                            </div>
                        </div>
                        <div class="overlay pullUp">
                            <i class="fa fa-plus"></i>
                        </div>
                    </a>
                </li>
                <!--Gallery item list element END-->
            <?php } ?>
        </ul>
        <!--The gallery list END-->

    </div>
    <!--The gallery END-->
</section>
<!--Portfolio section END-->
