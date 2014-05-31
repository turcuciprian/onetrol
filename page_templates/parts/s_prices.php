<?php
global $count_nr;
global $section;
global $CleanScriptCore;

if (isset($section['highlighted_color'])) {
    $highlighted_color = stripslashes($section['highlighted_color']);
}
$currency = stripslashes($section['currency']);
?>
<!--Prices section START-->
<section class="prices" id="<?php echo $section['section_type'] . $count_nr; ?>">
    <div class="container">
        <div class="row">
            <!--Main section title & subtitle START-->
            <div class="col-sm-12">
                <h1 class="sectionTitle" style="border-bottom:3px solid <?php echo stripslashes($section['section_color']); ?>"><?php echo stripslashes($section['section_title']); ?></h1>
                <div class="sectionSubtitle"><?php echo stripslashes($section['section_subtitle']); ?></div>
            </div>
            <!--Main section title & subtitle END-->
        </div>
        <div class="row">
            <?php
            for ($i = 1; $i < 5; $i++) {

                $column_title = $column_highlight = $column_state = $column_price = $column_description = $column_list = $column_button_text = $column_button_link = '';
                $column_title = stripslashes($section['column' . $i . '_title']);
                if (empty($column_title)) {
                    continue;
                }
                ?>
                <!--Prices Column main container START-->
                <div class="col-lg-3">
                    <?php
                    if (isset($section['column' . $i . '_highlight'])) {
                        $column_highlight = stripslashes($section['column' . $i . '_highlight']);
                    }
                    if ($column_highlight == "on") {
                        $column_state = 'highlighted';
                    }

                    $column_price = stripslashes($section['column' . $i . '_price']);
                    $column_description = stripslashes($section['column' . $i . '_description']);
                    $column_list = stripslashes($section['column' . $i . '_list']);
                    $column_button_text = stripslashes($section['column' . $i . '_button_text']);
                    $column_button_link = stripslashes($section['column' . $i . '_button_link']);
                    ?>
                    <!--main prices column container wrap START-->
                    <div class="price-column <?php echo $column_state; ?> isHidd">
                        <!--The main column title START-->
                        <h3><?php echo $column_title; ?></h3>
                        <!--The main column title END-->
                        <!--Value Container START-->
                        <div class="value">
                            <!--Price and currency container START-->
                            <div class="price">
                                <!--currency container START-->
                                <div class="currency"><?php echo $currency; ?></div>
                                <!--currency container END-->
                                <!--Price container START-->
                                <h2><?php echo $column_price; ?></h2>
                                <!--Price container END-->
                            </div>
                            <!--Price and currency container END-->
                            <!--Value Description container START-->
                            <div class="descr"><?php echo $column_description; ?></div>
                            <!--Value Description container END-->
                        </div>
                        <!--Value Container END-->
                        <!--Column buy now button container START-->
                        <div class="citrix_button"><a href="<?php echo $column_button_link; ?>"><?php echo $column_button_text; ?></a></div>
                        <!--Column buy now button container END-->
                        <!--Features List START-->
                        <ul class="features">
                            <?php echo $CleanScriptCore->cs_price_list($column_list); ?>
                        </ul>
                        <!--Features List END-->
                    </div>
                    <!--main prices column container wrap END-->
                </div>
                <?php
            }
            ?>


        </div>
    </div>
</section>
<!--Prices section END-->
