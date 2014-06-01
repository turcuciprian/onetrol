var $ = jQuery.noConflict();
//retina ready screens support
function tc_retina_support() {
    var retina = window.devicePixelRatio >= 1.5;
    if (retina) {
        $('body').addClass('retina');
    }
}




