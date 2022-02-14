jQuery(document).ready(function($){
    const videos = [
        'video1', 
        'video2',  
        'video5',
        'video6', 
        'video7'
    ]; 
    videos.forEach(element => {
        $('#upload_' + element).click(function(e) { 
            e.preventDefault();
            let custom_uploader;
            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }
            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });
            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function() {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                $('#' + element).val(attachment.url);
            });
            //Open the uploader dialog
            custom_uploader.open();
        });   
    });
    var laguage =  $( "#site_laguage_abreviation option:selected" ).val(); 
    $("#laguage_flag").html('<i class="flag flag-' +laguage.toLowerCase() + '"></i>'); 
    $("#site_laguage_abreviation").change(function(){
        laguage =  $( "#site_laguage_abreviation option:selected" ).val(); 
       $("#laguage_flag").html('<i class="flag flag-' + laguage.toLowerCase() + '"></i>'); 
    })

});