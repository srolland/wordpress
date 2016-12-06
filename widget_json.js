var ok = '';
jQuery( document ).ready( function() {
  console.log('CMJ Javascript loaded');
  jQuery( '#pn_cmj_btn' ).click( function( e ) {
    var data = {
  		action: 'json_cmj_test',
      name: jQuery( '#pn_cmj_name' ).val(),
      nonce: jQuery( '#pn_cmj_nonce' ).val()
  	};
  	jQuery.post( ajaxurl, data, function( response ) {
      console.log( response );
  	} );
  } );
} );
