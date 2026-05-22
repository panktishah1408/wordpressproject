<?php
/*
Plugin Name: My Learning Plugin
Description: Learning WordPress plugin basics
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit;
}

/*
|--------------------------------------------------------------------------
| INIT HOOK
|--------------------------------------------------------------------------
*/

add_action('init', 'mlp_init');

function mlp_init() {
    error_log('My Learning Plugin initialized');
}

/*
|--------------------------------------------------------------------------
| ENQUEUE FRONTEND ASSETS
|--------------------------------------------------------------------------
*/

add_action('wp_enqueue_scripts', 'mlp_enqueue_assets');

function mlp_enqueue_assets() {

    wp_enqueue_style(
        'mlp-style',
        plugin_dir_url(__FILE__) . 'assets/css/style.css',
        [],
        '1.0'
    );

    wp_enqueue_script(
        'mlp-script',
        plugin_dir_url(__FILE__) . 'assets/js/script.js',
        [],
        '1.0',
        true
    );
}

/*
|--------------------------------------------------------------------------
| ADMIN MENU
|--------------------------------------------------------------------------
*/

add_action('admin_menu', 'mlp_admin_menu');

function mlp_admin_menu() {

    add_menu_page(
        'My Learning Plugin',     // Page title
        'Learning Plugin',        // Menu title
        'manage_options',         // Capability
        'mlp-settings',           // Menu slug
        'mlp_settings_page',      // Callback function
        'dashicons-admin-generic',
        25
    );
}

/*
|--------------------------------------------------------------------------
| SETTINGS PAGE
|--------------------------------------------------------------------------
*/

function mlp_settings_page() {
    ?>
    
    <div class="wrap">
        <h1>My Learning Plugin Settings</h1>

        <p>Congratulations! Your plugin admin page works.</p>

        <form method="post">

            <label>
                Site Notice:
            </label>

            <input 
                type="text" 
                name="mlp_notice"
                value=""
                style="width: 300px;"
            >

            <br><br>

            <button class="button button-primary">
                Save Settings
            </button>

        </form>
    </div>

    <?php
}