<?php
global $count_nr;
global $section;
global $CleanScriptCore;

$section_color = stripslashes($section['section_color']);
?>
<!--The Team section START-->
<section class="team" id="<?php echo $section['section_type'] . $count_nr; ?>">
    <div class="container">
        <div class="row">
            <!--Main section title & subtitle START-->
            <div class="col-sm-12">
                <h1 class="sectionTitle"  style="border-bottom:3px solid <?php echo $section['section_color']; ?>"><?php echo stripslashes($section['section_title']); ?></h1>
                <div class="sectionSubtitle"><?php echo stripslashes($section['section_subtitle']); ?></div>
            </div>
            <!--Main section title & subtitle END-->
        </div>
        <div class="row">
            <?php
            for ($i = 1; $i < 9; $i++) {
                $Member_picture = $Member_name = $Member_position = $Member_email = $Member_facebook = $Member_twitter = '';
                $Member_picture = stripslashes($section['Member' . $i . '_picture']);
                $Member_name = stripslashes($section['Member' . $i . '_name']);
                $Member_position = stripslashes($section['Member' . $i . '_position']);
                $Member_email = stripslashes($section['Member' . $i . '_email']);
                $Member_facebook = stripslashes($section['Member' . $i . '_facebook']);
                $Member_twitter = stripslashes($section['Member' . $i . '_twitter']);
                if (empty($Member_picture)) {
                    continue;
                }
                $picture_id = $CleanScriptCore->cs_get_attachment_id_by_url($Member_picture);
                ?>
                <!--Team member column container START-->
                <div class="col-sm-3">
                    <!--Person description container START-->
                    <div class="person  isHidd">
                        <!--The image container START-->
                        <div class="picture img-responsive img-circle">
                            <?php echo wp_get_attachment_image($picture_id, 'onetrol_team', FALSE, array('class' => 'img-responsive img-circle')); ?>
                        </div>
                        <!--The image container END-->
                        <!--Title (name) START-->
                        <h3><?php echo $Member_name; ?></h3>
                        <!--Title (name) END-->
                        <!--Position container and text START-->
                        <div class="position"><?php echo $Member_position; ?></div>
                        <!--Position container and text END-->
                        <!--Social links list START-->
                        <ul>
                            <li><a href="emailto:<?php echo $Member_email; ?>"><i class="fa fa-envelope"></i></a></li>
                            <li><a href="<?php echo $Member_facebook; ?>"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="http://twitter.com/<?php echo $Member_twitter; ?>"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                        <!--Social links list END-->
                    </div>
                    <!--Person description container END-->
                </div>
                <!--Team member column container END-->
            <?php } ?>
        </div>




    </div>
</section>
<!--The Team section END-->
