<?php

/**
 * Plugin Name:       Front page Media
 * Plugin URI:        https://mario-flores.com
 * Description:       Set media show in the front page
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            Mario Flores
 * Author URI:        https://mario-flores.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mf_front_page
 * Domain Path:       /languages
 */
add_action('admin_enqueue_scripts', 'mf_frontpage_enqueue');
function mf_frontpage_enqueue()
{
    wp_enqueue_media();
    wp_enqueue_script('mf-frontpage-main', plugins_url('/js/main.js', __FILE__), array('jquery'), '1.0.0', true);
    wp_enqueue_style('mf_language_main', plugins_url('/css/main.css', __FILE__), array(), '1.0', 'all'); 
}

add_action('admin_menu', 'mf_frontpage_menu');
function mf_frontpage_menu()
{
    add_menu_page('Theme Settings', 'Theme Settings', 'manage_options', 'mf-all-site-settings', 'mf_all_sites');
    add_submenu_page('mf-all-site-settings', 'Front Page', 'Front page', 'mage_options', 'mf-frontpage-settings', 'mf_front_page_media');
    add_submenu_page('mf-all-site-settings', 'Language', 'Language', 'manage_options', 'mf-multisite-language', 'mf_site_language');
    add_submenu_page('mf-all-site-settings', 'Google', 'Google', 'manage_options', 'mf-google-settings', 'mf_google_settings'); 

}

function mf_google_settings(){
    include(plugin_dir_path(__FILE__). 'views/google_settings.php'); 
}

function mf_all_sites(){
    include(plugin_dir_path(__FILE__) . 'views/all_settings.php');
}

function mf_site_language()
{  
    $id = get_current_blog_id(); 
    $value =  get_network_option($id, 'country-slug', 'empty', false);
    if($value == false){
        add_network_option($id, 'country-slug', '');
    }
    if(!empty($_POST['site_laguage_abreviation'])){
        update_network_option($id, 'country-slug', $_POST['site_laguage_abreviation']); 
    } 
    $value =  get_network_option($id, 'country-slug', 'empty', false);
    include(plugin_dir_path(__FILE__) . 'views/laguage_selector.php');
}
function mf_front_page_media()
{
    include(plugin_dir_path(__FILE__) . 'views/settings.php');
}
function mf_frontpage_activate()
{
    $options = array(
        'video1' => '',
        'video2' => '',
        'video3' => '',
        'video4' => '',
        'video5' => '',
        'video6' => '',
        'video7' => '',
        'buy_button_text' => '',
        'mf_buy_button_page' => '', 
        'comunication' => ''

    );
    add_option('mf_frontpage_media', $options);

    $options2 = array(
        'topheader' => '', 
        'afterbody' => '', 
        'taglanguage' => ''
    ); 
    add_option('mf_google_options', $options2); 
}

add_action('admin_init', 'mf_google_options_init'); 
function mf_google_options_init(){
    add_settings_section('mf_google_options', 'Google Settings', '', 'mf-google-settings'); 
    register_setting('mf_google_options', 'mf_google_options'); 
    add_settings_field('mf_topheader', 'Top Header', 'mf_input_top_header', 'mf-google-settings', 'mf_google_options'); 
    add_settings_field('mf_afterbody', 'After Body', 'mf_input_after_body', 'mf-google-settings', 'mf_google_options');
    add_settings_field('mf_tag_laguage', 'Google Tag laguage', 'mf_input_tag_language', 'mf-google-settings', 'mf_google_options');
    add_settings_field('mf_head_scripts', 'Javascript in header', 'mf_input_head_scripts', 'mf-google-settings', 'mf_google_options'); 
    add_settings_field('mf_footer_scripts', 'Javascript in footer', 'mf_input_footer_scripts', 'mf-google-settings', 'mf_google_options'); 
}

function mf_input_footer_scripts(){
    $google = get_option('mf_google_options'); 
    $jsfooter = $google['jsfooter'];
    echo '<textarea id="jsfooter" name="mf_google_options[jsfooter]" rows="20" cols="100">'.$jsfooter.'</textarea>';
}
function mf_input_head_scripts(){
    $google = get_option('mf_google_options'); 
    $jsheader = $google['jsheader'];
    echo '<textarea id="jsheader" name="mf_google_options[jsheader]" rows="20" cols="100">'.$jsheader.'</textarea>';
}
function mf_input_tag_language(){
    $google = get_option('mf_google_options'); 
    $toheader = $google['taglanguage']; 
    echo '<input type="text" id="taglanguage" name="mf_google_options[taglanguage]" value="'.$toheader.'">';
}

function mf_input_top_header(){
    $google = get_option('mf_google_options'); 
    $toheader = $google['topheader']; 
    echo '<textarea id="topheader" name="mf_google_options[topheader]" rows="20" cols="100">'.$toheader.'</textarea>';
}
function mf_input_after_body(){
    $google = get_option('mf_google_options'); 
    $afterbody = $google['afterbody']; 
    echo '<textarea id="afterbody" name="mf_google_options[afterbody]" rows="10" cols="100">'.$afterbody. '</textarea>';
}

add_action('admin_init', 'mf_frontpage_admin_init');
function mf_frontpage_admin_init()
{
    add_settings_section('mf_frontpage_media', 'Front Page Media', '', 'mf-frontpage-settings');

    register_setting('mf_frontpage_media', 'mf_frontpage_media');
    add_settings_field('mf_frontpage_video1', 'homepage desktop', 'mf_frontpage_input_video1', 'mf-frontpage-settings', 'mf_frontpage_media');
    add_settings_field('mf_frontpage_video2', 'homepage mobile', 'mf_frontpage_input_video2', 'mf-frontpage-settings', 'mf_frontpage_media');
    add_settings_field('mf_frontpage_video5', 'what us prostamol desktop', 'mf_frontpage_input_video5', 'mf-frontpage-settings', 'mf_frontpage_media');
    add_settings_field('mf_frontpage_video6', 'what is prostamol mobile', 'mf_frontpage_input_video6', 'mf-frontpage-settings', 'mf_frontpage_media');
    add_settings_field('mf_frontpage_video7', 'further information', 'mf_frontpage_input_video7', 'mf-frontpage-settings', 'mf_frontpage_media');
    add_settings_field('mf_buy_button_text', 'Buy button text', 'mf_input_buy_button_text', 'mf-frontpage-settings', 'mf_frontpage_media');
    add_settings_field('mf_buy_button_page', 'Buy button page', 'mf_input_buy_button_page', 'mf-frontpage-settings', 'mf_frontpage_media');
    add_settings_field('mf_buy_comunication', 'Comunication page slug', 'mf_input_comunication', 'mf-frontpage-settings', 'mf_frontpage_media');
}
function mf_input_comunication()
{
    $videos = get_option('mf_frontpage_media');
    $buy_button_page = $videos['comunication'];
    echo '<input id="comunication" type="text" name="mf_frontpage_media[comunication]" value="' . esc_attr($buy_button_page) . '">';
}

function mf_input_buy_button_page()
{
    $videos = get_option('mf_frontpage_media');
    $buy_button_page = $videos['buy_button_page'];
    echo '<input id="buy_button_page" type="text" name="mf_frontpage_media[buy_button_page]" value="' . esc_attr($buy_button_page) . '">';
}
function mf_input_buy_button_text()
{
    $videos = get_option('mf_frontpage_media');
    $buy_button_text = $videos['buy_button_text'];
    echo '<input id="buy_button_text" type="text" name="mf_frontpage_media[buy_button_text]" value="' . esc_attr($buy_button_text) . '">';
}
function mf_frontpage_input_video1()
{
    $videos = get_option('mf_frontpage_media');
    $video1 = $videos['video1'];
    echo '<input id="video1" type="text" name="mf_frontpage_media[video1]" value="' . esc_attr($video1) . '">';
    echo '<input id="upload_video1" class="button" type="button" value="Upload Video" />';
}
function mf_frontpage_input_video2()
{
    $videos = get_option('mf_frontpage_media');
    $video2 = $videos['video2'];
    echo '<input id="video2" type="text" name="mf_frontpage_media[video2]" value="' . esc_attr($video2) . '">';
    echo '<input id="upload_video2" class="button" type="button" value="Upload Video" />';
}
function mf_frontpage_input_video5()
{
    $videos = get_option('mf_frontpage_media');
    $video5 = $videos['video5'];
    echo '<input id="video5" type="text" name="mf_frontpage_media[video5]" value="' . esc_attr($video5) . '">';
    echo '<input id="upload_video5" class="button" type="button" value="Upload Video" />';
}

function mf_frontpage_input_video6()
{
    $videos = get_option('mf_frontpage_media');
    $video6 = $videos['video6'];
    echo '<input id="video6" type="text" name="mf_frontpage_media[video6]" value="' . esc_attr($video6) . '">';
    echo '<input id="upload_video6" class="button" type="button" value="Upload Video" />';
}
function mf_frontpage_input_video7()
{
    $videos = get_option('mf_frontpage_media');
    $video7 = $videos['video7'];
    echo '<input id="video7" type="text" name="mf_frontpage_media[video7]" value="' . esc_attr($video7) . '">';
    echo '<input id="upload_video7" class="button" type="button" value="Upload Video" />';
}