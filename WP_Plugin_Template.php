<?php

/*

Plugin Name: Plugin Template

Description: Plugin description

Version: 1.0

Author: ostpnk

Author URI: https://ostpnk.xyz/

License: GPLv2 or later

*/


class WP_Plugin_Template {

    protected $prefix = "wppt_";
    protected $plugin_name = "API extension";

    public function __construct()
    {
      add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);
      add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function addPluginAdminMenu() {
      //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
      add_menu_page(  $this->plugin_name, $this->plugin_name, 'administrator', $this->prefix.'settings', array( $this, 'displayPluginAdminDashboard' ), 'dashicons-rest-api', 26 );

    }

    public function displayPluginAdminDashboard() {
    ?>
        <h2><?= $this->plugin_name ?> Settings</h2>

        <?php // var_dump(get_registered_settings()); ?>
        <form action="options.php" method="post">
            <?php
            settings_fields( $this->prefix.'options' );
            do_settings_sections( $this->prefix.'settings' ); ?>
            <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
        </form>
        <?php
    }

    public function register_settings() {

        $settings_section_name = $this->prefix.'api_settings';
        $settings_section_title = 'API Settings';

        register_setting( $this->prefix.'options', $this->prefix.'options');
        add_settings_section( $settings_section_name, $settings_section_title, array( $this, 'section_text' ), $this->prefix.'settings' );

        add_settings_field( $this->prefix.'setting_api_key', 'API Key', array( $this, 'setting_api_key' ),  $this->prefix.'settings', $settings_section_name );
    }

    public function section_text() {
        echo '<p>Here you can set all the options for using the API</p>';
    }

    public function setting_api_key() {
        $options = get_option( $this->prefix.'options' );
        echo "<input id='".$this->prefix."setting_api_key' name='".$this->prefix."options[api_key]' type='text' value='" . esc_attr( $options['api_key'] ) . "' />";
    }

}

$wppt = new WP_Plugin_Template();

?>
