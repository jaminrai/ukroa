//jquery-ui-tabs
jQuery(document).ready(function($) {
$('#tabs').tabs();
$('.sps-cat-query-cls').select2();

var custom_uploader;
 
 
    $('#sps_video_upload').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Video',
            button: {
                text: 'Choose Video'
            },
            library: {type: 'video/MP4'},
            button: {text: 'Insert'},
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#sps_video_banner').val(attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
    
});