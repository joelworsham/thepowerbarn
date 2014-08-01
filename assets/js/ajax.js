// Load more on sroll
jQuery(window).scroll(function () {
    if (jQuery(window).scrollTop() + jQuery(window).height() + 100 > jQuery(document).height()) {
        ajax_load_posts(false);
    }
});

function ajax_load_posts(e, offset, load_count, category) {
    // Bail if already loading
    if ( jQuery('#ajax-loader').length ) return;

    // Setup
    var e_content = jQuery('#content'),
        ID = null,
        url = null;

    // Defaults
    if (typeof e == 'undefined') e = false;
    if (typeof offset == 'undefined') offset = e_content.find('.post').length;
    if (typeof load_count == 'undefined') load_count = 3;
    if (typeof category == 'undefined') category = null;

    // If self exists, is a single load request
    // NOTE: home link uses this too, but the ID is not set
    if ( e ) {
        ID = jQuery(e).attr('data-ID');
        url = jQuery(e).attr('data-url');

        // Delete the current content
        e_content.html('');

        // Set the url and add it to the history
        window.history.pushState('', '', url);
    }

    // Add the nifty loader
    e_content.append('<div id="ajax-loader">Loading...</div>');

    // AJAX
    var data = {
        action: 'load_posts',
        ID: ID,
        url: url,
        category: category,
        offset: offset,
        load_count: load_count
    };

    jQuery.post(
        ajax_data.ajaxurl,
        data,
        function(response) {
            // Remove the loader
            jQuery('#ajax-loader').remove();

            // Add the new content
            e_content.append(response);
        }
    );
}