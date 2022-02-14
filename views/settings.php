<div class="wrap">
    <h2>Front Page Settings</h2>
    <form action="options.php" method="post">
    <?php settings_fields('mf_frontpage_media'); 
    do_settings_sections('mf-frontpage-settings'); 
    submit_button('Save Changes', 'primary'); 
    ?>
    </form>
</div>