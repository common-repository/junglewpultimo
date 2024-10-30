jQuery(document).ready(function($){

    $.post(ajaxurl, {

        action: 'update_results'

    }, function (response){

        console.log('AJAX complete');

    });

});