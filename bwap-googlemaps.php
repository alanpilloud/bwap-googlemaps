<?php
/*
Plugin Name: BWAP Googlemaps
Plugin URI: http://alanpilloud.github.io
Description: Add a simple map with a unique marker
Version: 0.0.1
Author: Bureau Web Alan Pilloud
Author URI: http://alanpilloud.github.io
*/

defined( 'ABSPATH' ) or die;

require 'plugin_update_check.php';
$MyUpdateChecker = new PluginUpdateChecker_2_0 ('https://kernl.us/api/v1/updates/568baf4c5f8a752d2f4ddea5/', __FILE__, 'bwap-googlemaps', 1);

if (!class_exists('BwapGoogleMaps')) {

    class BwapGoogleMaps
    {
        protected $tag = 'bwap-googlemaps';
        protected $name = 'BWAP Googlemaps';
        protected $version = '0.0.1';

        public function __construct()
        {
            add_shortcode( $this->tag, array( &$this, 'shortcode' ) );
        }

        public function shortcode( $atts, $content = null )
        {
            $mapid = $this->tag;

            $atts = shortcode_atts( array(
                'key' => '',
                'title' => '',
                'lat' => '-25.363',
                'lon' => '131.044',
                'zoom' => 4,
                'class' => 'map'
            ), $atts );

            add_action('wp_footer', function() use ($atts, $mapid) {
                ?>
                <script>
                function initMap() {
                  var myLatLng = {lat: <?= $atts['lat'] ?>, lng: <?= $atts['lon'] ?>};

                  var map = new google.maps.Map(document.getElementById("<?= $mapid ?>"), {center: myLatLng,scrollwheel: false, zoom: <?= $atts['zoom'] ?>});

                  var marker = new google.maps.Marker({map: map, position: myLatLng, title: "<?= $atts['title'] ?>" });
              }</script>
              <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= $atts['key'] ?>&amp;callback=initMap"></script>
              <?php
            });

            echo '<div id="'.$mapid.'" class="'.$atts['class'].'"></div>';
        }
    }
    new BwapGoogleMaps;
}
