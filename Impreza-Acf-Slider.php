// Tutorial: Adding FlexSlider and Magnific Popup in WordPress theme

// Part 1: Add code to enqueue scripts (jQuery, FlexSlider, and Magnific Popup)

// This function enqueues the required scripts and styles for the slider and popup.
function srg_add_flexslider_shortcode() {
    // Enqueue jQuery as it is a dependency for both FlexSlider and Magnific Popup.
    wp_enqueue_script('jquery');

    // Enqueue FlexSlider scripts and styles
    wp_enqueue_script('flexslider', get_template_directory_uri() . '/PATH_TO_YOUR_FLEXSLIDER_SCRIPT/flexslider.js', array('jquery'), '', true);
    wp_register_style('flexslider-style', get_template_directory_uri() . '/PATH_TO_YOUR_FLEXSLIDER_CSS/flexslider.css');
    wp_enqueue_style('flexslider-style');

    // Enqueue Magnific Popup scripts and styles
    wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/PATH_TO_YOUR_MAGNIFIC_POPUP_SCRIPT/magnific-popup.js', array('jquery'), '', true);
    wp_register_style('magnific-popup-style', get_template_directory_uri() . '/PATH_TO_YOUR_MAGNIFIC_POPUP_CSS/magnific-popup.css');
    wp_enqueue_style('magnific-popup-style');

    // Part 3: Add inline script to setup FlexSlider and Magnific Popup
    wp_add_inline_script( 'flexslider', 
        'jQuery(document).ready(function($) {
            $(".flexslider").flexslider({
                animation: "slide",
                animationLoop: false,
                slideshow: false,
                itemWidth: 210,
                itemMargin: 5,
                minItems: 3,
                maxItems: 3,
                controlNav: true
            });
            $("[ref=magnificPopup]").magnificPopup({
                type: "image",
                mainClass: "mfp-fade"
            });
        });'
    );
}

// Enqueue the scripts and styles when WordPress loads scripts and styles
add_action('wp_enqueue_scripts', 'srg_add_flexslider_shortcode');

// Part 2: Create the actual shortcode

// This function generates the HTML for the slider and popup using images from a custom field.
function acf_flexslider_shortcode() {
    // Retrieve images from the custom field 'service_gallery'
    $images = get_field('service_gallery');
    $output = '';

    // Generate the slider and popup HTML if there are images
    if($images) {
        $output .= '<div id="slider" class="flexslider"><ul class="slides">';
        foreach($images as $image) {
            $output .= '<li><a ref="magnificPopup" href="'.$image['url'].'" class="w-image-h inited"><img src="'.$image['url'].'" alt="'.$image['alt'].'" decoding="async" loading="lazy" /></a></li>';
        }
        $output .= '</ul></div>';
    }

    // Return the generated HTML
    return $output;
}

// Register the shortcode 'acf_flexslider'
add_shortcode('acf_flexslider', 'acf_flexslider_shortcode');
