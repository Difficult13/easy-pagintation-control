(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 */

	$(document).ready(function(){

		$('#epc-form').submit(function(e){
			e.preventDefault();

			$('#epc-submit').prop('disabled', true);
			$('#epc-notice-success').prop('hidden', true);
			$('#epc-notice-error').prop('hidden', true);

			var data = {
				'result': {},
				'action': 'epc_post',
				'epc_nonce': $('#epc_nonce').val()
			};

			var options = {};
			$('#epc-body .epc-options-section').each(function(){
				options = {};
				$(this).find('input').each(function(){
					options[$(this).attr('name')] = $(this).val();
				});
				data['result'][$(this).attr('id')] = options;
			});


			$.ajax({
				type:'POST',
				url: ajaxurl,
				data: data,
				success:function(data){
					if (data == 1){
						$('#epc-notice-success').prop('hidden', false);
					} else {
						$('#epc-notice-error').prop('hidden', false);
					}
					$('#epc-submit').prop('disabled', false);
				},
				error:function(a){
					$('#epc-notice-error').prop('hidden', false);
					$('#epc-submit').prop('disabled', false);
				}
			});
		});

	});

})( jQuery );
