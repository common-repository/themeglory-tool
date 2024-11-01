(function( $ ) {
	$(function() {

	$('.color-field').wpColorPicker();
	$('.tggrouped').on('click' , function(){
		$(this).closest('.input-group').find('.input-subgroup').slideToggle();
	});

	$( '#add-feature' ).on('click', function() {
                var row = $( '.empty-feature-row.screen-reader-text' ).clone(true);
                row.removeClass( 'empty-feature-row screen-reader-text' );
                row.insertBefore( '#repeatable-fieldset tbody>tr:last' );
                return false;
            });
        
            $( '.remove-feature' ).on('click', function() {
                $(this).parents('tr').remove();
                return false;
            });

	});

})( jQuery );

