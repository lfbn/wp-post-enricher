jQuery(document).ready(function(){
    jQuery('#wppe-button-search').click(function(event){
        event.preventDefault();

        var errorBoxElement = jQuery('.wppe-error-box');
        var loadingElement = jQuery('#wppe-loading');
        var terms = jQuery('#wppe-terms').val();
        var searchType = jQuery('input[name="wppe-option-group"]:checked').val();

        if (terms === '') {
            errorBoxElement.text('Please provide a term to search...');
            errorBoxElement.toggle();
            return;
        }

        if (searchType === '') {
            errorBoxElement.text('Please define what kind of search you want to do...');
            errorBoxElement.toggle();
            return;
        }

        jQuery('#wppe-results').empty();
        loadingElement.toggle();

        var posting = jQuery.post(
            ajaxurl,
            {
                'action': 'post_enricher_callback',
                'url': '/search/index',
                'terms': terms,
                'search_type': searchType
            }
        );

        posting.done(function(data) {
            loadingElement.toggle();
            jQuery('#wppe-results').html(data);
        });

    });
});