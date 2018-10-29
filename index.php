<?php
/*
Plugin Name: Layotter
Description: Add and arrange your content freely with an intuitive drag and drop interface!
Author: Dennis Hingst modified by VSOE WordPress team
Version: 0.0.1
Author URI: https://viterbischool.usc.edu
Text Domain: viterbischool
Copyright 2018 University of Souther California Viterbi School of Engineering

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// load translations
load_plugin_textdomain('viterbischool', false, basename(__DIR__) . '/languages/');

// settings are self-contained and should be included even if ACF is not available
// one reason is that otherwise default settings would not be registered on plugin activation
require_once __DIR__ . '/core/settings.php';

// include other files after plugins are loaded so ACF checks can be run
add_action('plugins_loaded', 'layotter');
function layotter() {

    // ACF abstraction layer is always required
    require_once __DIR__ . '/core/acf-abstraction.php';

    // include files only if ACF is available
    if (Layotter_ACF::is_available()) {
        require_once __DIR__ . '/core/core.php';
        require_once __DIR__ . '/core/ajax.php';
        require_once __DIR__ . '/core/assets.php';
        require_once __DIR__ . '/core/interface.php';
        require_once __DIR__ . '/core/templates.php';
        require_once __DIR__ . '/core/layouts.php';
        require_once __DIR__ . '/core/acf-locations.php';
        require_once __DIR__ . '/core/shortcode.php';
        require_once __DIR__ . '/core/views.php';
        require_once __DIR__ . '/core/revisions.php';

        require_once __DIR__ . '/components/form.php';
        require_once __DIR__ . '/components/editable.php';
        require_once __DIR__ . '/components/options.php';
        require_once __DIR__ . '/components/post.php';
        require_once __DIR__ . '/components/row.php';
        require_once __DIR__ . '/components/col.php';
        require_once __DIR__ . '/components/element.php';

        // this library takes care of saving custom fields for each post revision
        // see https://wordpress.org/plugins/wp-post-meta-revisions/
        if (!class_exists('WP_Post_Meta_Revisioning')) {
            require_once __DIR__ . '/lib/wp-post-meta-revisions.php';
        }

        // include example element after theme is loaded (allows disabling the
        // example element with a settings filter in the theme)
        add_action('after_setup_theme', 'layotter_include_example_element');
    }
}

function layotter_include_example_element() {
    if (Layotter_Settings::example_element_enabled()) {
        require_once __DIR__ . '/example/field-group.php';
        require_once __DIR__ . '/example/element.php';
    }
}