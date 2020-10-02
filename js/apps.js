
jQuery(document).ready(function($){
    
    // Check ACF
    if(typeof acf === 'undefined')
        return;
    // Date picker & Google Maps compatibility
    $('.acf-google-map input.search, .acf-date-picker input.input').addClass('form-control');
    
    // Clean errors on submission
    acf.addAction('validation_begin', function($form){
        $form.find('.acf-error-message').remove();
    });
    
    // Add alert alert-danger & move below field
    acf.addAction('invalid_field', function(field){
        field.$el.find('.acf-notice.-error').addClass('alert alert-danger').insertAfter(field.$el.find('.acf-input'));
    });
    
});