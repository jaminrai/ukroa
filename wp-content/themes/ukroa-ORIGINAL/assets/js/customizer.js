/* global wp */
( function( wp, $ ) {
    // Primary Color: Update header background, links, and buttons
    wp.customize( 'ukroa_primary_color', function( value ) {
        value.bind( function( newval ) {
            // Update header background color
            $( 'header' ).css( 'background-color', newval );

            // Update link and button colors
            $( 'a, .button' ).css( 'color', newval );
            $( '.button:hover' ).css( {
                'background-color': newval,
                'color': '#fff'
            } );
        } );
    } );

    // Footer Text: Update copyright text
    wp.customize( 'ukroa_footer_text', function( value ) {
        value.bind( function( newval ) {
            $( '.copyright p' ).html( newval + ' <a href="' + wp.customize.settings.url.home + '/privacy-policy/">Privacy Policy</a>' );
        } );
    } );

    // Header Image: Update header background image
    wp.customize( 'header_image', function( value ) {
        value.bind( function( newval ) {
            $( 'header' ).css( 'background-image', 'url(' + newval + ')' );
        } );
    } );

    // Social Media Links: Update footer social links
    var socials = [ 'facebook', 'twitter', 'instagram' ];
    socials.forEach( function( social ) {
        wp.customize( 'ukroa_social_' + social, function( value ) {
            value.bind( function( newval ) {
                var $link = $( '.social-links a[href*="' + social + '"]' );
                if ( newval ) {
                    if ( $link.length ) {
                        $link.attr( 'href', newval );
                    } else {
                        $( '.social-links' ).append( '<li><a href="' + newval + '" target="_blank" rel="noopener">' + social.charAt(0).toUpperCase() + social.slice(1) + '</a></li>' );
                    }
                } else {
                    $link.parent().remove();
                }
            } );
        } );
    } );
} )( wp, jQuery );