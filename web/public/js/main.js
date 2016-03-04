$(function() {
    var userSearchInput = $( "#userSearch" );
    var source = userSearchInput.data('ajax') + '?subject=user';

    userSearchInput.autocomplete({
        source: source,
        minLength: 2,
        response: function(event, ui) {
            // ui.content is the array that's about to be sent to the response callback.
        },
        select: function( event, ui ) {
        }
    });

});