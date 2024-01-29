;(function($, window, document, undefined) {
	var $win = $(window);
	var $doc = $(document);

	$doc.ready(function() {

		$(document).on("scheduled-on-new-app", function(event) {
			$field_container = $('.field.field-paid-service');
			scheduled_wc_products_field();
		});
		scheduled_wc_add_new_options();
		scheduled_wc_reorder_custom_field_values();

		$('body').on('click','button.mark-paid',function(){

			var thisAppt = $(this).data('appt-id'),
				apptBlock = $(this).parents('.appt-block');

			if (thisAppt){

				var confirm_mark_paid = confirm(scheduled_wc_variables.i18n_mark_paid);

				if (confirm_mark_paid){

					var data = {
						'action': 'scheduled_wc_mark_paid',
						'appt_id': parseInt(thisAppt)
					};

					$.post(
						scheduled_wc_variables.ajaxurl,
						data,
						function(response) {
							if (response != 'no_order'){
								apptBlock.find('.scheduled-wc_status-text').removeClass('awaiting').addClass('paid');
								apptBlock.find('.scheduled-wc_status-text').html('<a target="_blank" href="' + response + '"><i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;' + scheduled_wc_variables.i18n_paid + '</a>');
							}
						}
					);

				} else {

					return false;

				}

			}

			return false;

		});

	});

	$win.on('load', function() {

		init_scheduled_cf_payment_sortables();
		$('.scheduled-cf-block').on('click','.cfButton',function(e){
			init_scheduled_cf_payment_sortables();
		});

	});

	function update_CF_Data(CF_SortablesForm){

		var sortableContent = JSON.stringify(CF_SortablesForm.serializeArray());
		$('#scheduled_custom_fields').val(sortableContent);

	}

	function init_scheduled_cf_payment_sortables(){

		if (typeof jQuery.ui.sortable == 'function') {
			var CF_SortablesForm = $('#scheduled-cf-sortables-form');

			$('#scheduled-cf-paid-service').sortable({
				handle: ".sub-handle",
				stop: function(){
					update_CF_Data(CF_SortablesForm);
				}
			});
		}

	}

	function scheduled_wc_products_field() {

		var $dropdown = $('select', $field_container);
		$dropdown.on('change', function() {
			var $this = $(this),
				product_id = $this.val(),
				field_name = $this.attr('name'),
				$variations_container = $this.parent().find('.paid-variations');

			scheduled_wc_load_variations(product_id, field_name, $variations_container);
		});

	}

	function scheduled_wc_load_variations( product_id, field_name, variations_container ) {

		if ( !product_id ) {
			variations_container.html('');
			return;
		};

		var data = {
			'action': 'scheduled_wc_load_variations',
			'product_id': parseInt(product_id),
			'field_name': field_name
		};

		$.post(
			scheduled_wc_variables.ajaxurl,
			data,
			function(response) {
				variations_container.html(response);
			}
		);

	}

	function scheduled_wc_add_new_options() {

		// Custom Fields
		var CF_SortablesTemplatesContainer	= $('#scheduled-cf-sortable-templates'),
			separator = '---';

		$doc.on("scheduled-on-cbutton-click", function(event, params) {
			var $this = params.button_object,
				$this_parent = $this.parents('li'),
				button_type = params.button_type,
				unique_number = params.random_number; // $this_parent.length ? $this_parent.find('input[type=text]:first').attr('name').split(separator)[1] : '';

			if ( button_type === 'single-paid-service' ) {

				var $options_list = $this.parent().find('#scheduled-cf-paid-service');

				$( '> li', $options_list).each(function() {
					var $this_li = $(this),
						$option_field = $this_li.find('select'),
						this_name = $option_field.attr('name');

					if ( !scheduled_wc_strpos(this_name, separator) ) {
						var field_name = this_name + separator + unique_number;

						$option_field.attr('name', field_name);
					};
				});

				scheduled_wc_update_data();
			};
		});

		$doc.on('change', '#scheduledCFTemplate-single-paid-service select', function() {
			scheduled_wc_update_data();
		});

	}

	function scheduled_wc_strpos(haystack, needle, offset) {
		var i = (haystack+'').indexOf(needle, (offset || 0));
		return i === -1 ? false : i;
	}

	function scheduled_wc_update_data(CF_SortablesForm){
		var sortables_form = $('#scheduled-cf-sortables-form'),
			sortableContent = JSON.stringify(sortables_form.serializeArray());
		$('#scheduled_custom_fields').val(sortableContent);
	}

	function scheduled_wc_reorder_custom_field_values() {
		var $order_items = $('#order_line_items > .item');
		if ( !$order_items.length ) {
			return;
		};

		$order_items.each(function() {
			var $this = $(this),
				$metas = $('div.view > table > tbody > tr', $this);

			$metas.each(function() {
				var $this = $(this),
					$label = $this.find('th'),
					$value = $this.find('td');

				if ( $label.text()==='Form Field:' ) {
					$label.text( $value.text().replace(/:.+/, ':') );
					$value.text( $value.text().replace(/^[^:]+:/, '') );
				};
			});
		});
	}
})(jQuery, window, document);
