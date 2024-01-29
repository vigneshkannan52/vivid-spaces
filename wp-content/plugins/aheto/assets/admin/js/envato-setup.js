
var EnvatoWizard = (function($){

	var t;

	/*=================================*/
	/* BACKGROUND */
	/*=================================*/
	//sets child image as a background
	function wpc_add_img_bg(img_sel, parent_sel) {
		if (!img_sel) {

			return false;
		}
		var $parent, $imgDataHidden, _this;
		$(img_sel).each(function () {
			_this = $(this);
			$imgDataHidden = _this.data('s-hidden');
			$parent = _this.closest(parent_sel);
			$parent = $parent.length ? $parent : _this.parent();
			$parent.css('background-image', 'url(' + this.src + ')').addClass('s-back-switch');
			if ($imgDataHidden) {
				_this.css('visibility', 'hidden');
			}
			else {
				_this.hide();
			}
		});
	}

	$('a.button.refresh').on('click', function (e) {
		e.preventDefault();
		location.reload();
	});

    $( () => {

		function getCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}

		function eraseCookie(name) {
			createCookie(name,"",-1);
		}

		function createCookie(name, value, days) {
			var expires;
			if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
				expires = "; expires=" + date.toGMTString();
			}
			else {
				expires = "";
			}
			document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
		}

		$('.aheto-import-theme-data--list .item').on('click', function () {

			$('.envato_default_content input').prop('checked', true);
			$('.envato_default_content').addClass('checkes');

            $('.aheto-required-plugins-buttons .default').removeClass('default');

			var directory = $(this).attr('data-type');

			eraseCookie("importType");
			createCookie("importType", directory, "20");

			afrer_reloading();
		});

		wpc_add_img_bg('.s-img-switch');
		$('.envato_default_content input').each(function () {
			if($(this).is(':checked')) {
				$(this).parent().toggleClass('checkes');
			}
		});
		$('.custom-steps').hide();

		function afrer_reloading() {

			var directory = getCookie('importType');

			if ( directory ){
				$('.aheto-import-theme-data--list .item').attr('data-checked', false).removeClass('active');

				$('.aheto-import-theme-data--list .item[data-type="'+directory+'"]').attr('data-checked', true).addClass('active');

			}
		}

    } );

	$('div[data-directory] label').on('click', function (e) {
		e.stopPropagation();
		$(this).parent().toggleClass('checkes');
	});

	$('.custom-steps a.next').on('click', function () {

		$('.envato_default_content[data-directory]').hide();
		$('.custom-steps a.prev').show();
	});
	$('.custom-steps a.prev:not(.disable)').on('click', function () {
		$('.envato_default_content[data-directory]').hide();
	});

	$('.custom-steps a.prev.disable').on('click', function (e) {
		e.preventDefault();
	});

	// callbacks from form button clicks.
	var callbacks = {
		install_plugins: function(btn){
			var plugins = new PluginManager();
			plugins.init(btn);
		},
		install_content: function(btn){
			var content = new ContentManager();
			content.init(btn);
		}
	};

	function window_loaded(){
		// init button clicks:
		$('.button-next').on( 'click', function(e) {

			var loading_button = dtbaker_loading_button(this);
			if(!loading_button){
				return false;
			}
			if($(this).data('callback') && typeof callbacks[$(this).data('callback')] != 'undefined'){
				// we have to process a callback before continue with form submission
				callbacks[$(this).data('callback')](this);
				return false;
			}else{
				return true;
			}
		});
		$('.button-upload').on( 'click', function(e) {
			e.preventDefault();
			renderMediaUploader();
		});
		$('.theme-presets a').on( 'click', function(e) {
			e.preventDefault();
			var $ul = $(this).parents('ul').first();
			$ul.find('.current').removeClass('current');
			var $li = $(this).parents('li').first();
			$li.addClass('current');
			var newcolor = $(this).data('style');
			$('#new_style').val(newcolor);
			return false;
		});

		$('.envato_default_content .defgroup').on('change', function () {

			if($(this).is(':checked')){
				$('.envato_default_content .defgroup').prop('checked', true);
			}else{
				$('.envato_default_content .defgroup').prop('checked', false);
			}
		});
	}

	function PluginManager(){

		var complete;
		var items_completed = 0;
		var current_item = '';
		var $current_node;
		var current_item_hash = '';

		function ajax_callback(response){


			if($current_node){
				if(!$current_node.data('done_item')){
					items_completed++;
					$current_node.data('done_item',1);
				}
				$current_node.find('.spinner').css('visibility','hidden');
			}

			if(typeof response == 'object' && typeof response.message != 'undefined'){
				$current_node.find('span').text(response.message);
				if(typeof response.url != 'undefined'){
					// we have an ajax url action to perform.

					if(response.hash == current_item_hash){
						$current_node.find('span').text("failed");
						find_next();
					}else {
						current_item_hash = response.hash;

						jQuery.post(response.url, response, function(response2) {
							process_current();

							$current_node.find('span').text(response.message + envato_setup_params.verify_text);
						}).fail(ajax_callback);
					}

				}else if(typeof response.done != 'undefined'){
					// finished processing this plugin, move onto next
					find_next();
				}else{
					// error processing this plugin
					find_next();
				}
			}else{
				// error - try again with next plugin
				var $items = $('tr.envato_default_content');

				if(items_completed < $items.length){
					$current_node.find('span').text("ajax error");
				} else {
					$current_node.find('span').text("Success");
				}
				find_next();

			}
		}
		function process_current(){
			if(current_item){
				// query our ajax handler to get the ajax to send to TGM
				// if we don't get a reply we can assume everything worked and continue onto the next one.
				jQuery.post(envato_setup_params.ajaxurl, {
					action: 'envato_setup_plugins',
					wpnonce: envato_setup_params.wpnonce,
					slug: current_item
				}, ajax_callback).fail(ajax_callback);
			}
		}
		function find_next(){
			var do_next = false;
			if($current_node){
				if(!$current_node.data('done_item')){
					items_completed++;
					$current_node.data('done_item',1);
				}
				$current_node.find('.spinner').css('visibility','hidden');
			}
			var $li = $('.aheto-required-plugins--list li');
			$li.each(function(){
				if(current_item == '' || do_next){
					current_item = $(this).data('slug');
					$current_node = $(this);
					process_current();
					do_next = false;
				}else if($(this).data('slug') == current_item){
					do_next = true;
				}
			});
			if(items_completed >= $li.length){
				// finished all plugins!
				complete();
			}
		}

		return {
			init: function(btn){
				$('.aheto-required-plugins--list').addClass('installing');
				complete = function(){
					window.location.href=btn.href;
				};
				find_next();
			}
		}
	}

	function ContentManager(){

		var complete;
		var items_completed = 0;
		var current_item = '';
		var file_url = '';
		var $current_node;
		var current_item_hash = '';

		function ajax_callback(response) {

			console.dir(response);

			if($current_node){
				if(!$current_node.data('done_item')){
					items_completed++;
					$current_node.data('done_item',1);
				}
				$current_node.find('.spinner').css('visibility','hidden');
			}

			if(typeof response == 'object' && typeof response.message != 'undefined'){
				$current_node.find('span').text(response.message);
				if(typeof response.url != 'undefined'){
					// we have an ajax url action to perform.
					if(response.hash == current_item_hash){
						$current_node.find('span').text("failed");
						find_next();
					}else {
						current_item_hash = response.hash;
						jQuery.post(response.url, response, ajax_callback).fail(ajax_callback); // recuurrssionnnnn
					}
				}else if(typeof response.done != 'undefined'){
					// finished processing this plugin, move onto next
					find_next();
				}else{
					// error processing this plugin
					find_next();
				}
			}else{
				// error - try again with next plugin
				var $items = $('tr.envato_default_content');
				if(items_completed < $items.length){
					$current_node.find('span').text("ajax error");
				} else {
					$current_node.find('span').text("Success");
				}
				find_next();
			}
		}

		function getCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}

		function process_current(){
			if(current_item){
				var $check = $current_node.find('input:checkbox, input:radio');
				var file_url = $(".envato_default_content[data-content='"+current_item+"']").attr('data-file_url');

				if($check.is(':checked')) {
					// process htis one!
					jQuery.post(envato_setup_params.ajaxurl, {
						action: 'envato_setup_content',
						wpnonce: envato_setup_params.wpnonce,
						type:  getCookie('importType'),
						file_url: file_url,
						content: current_item
					}, ajax_callback).fail(ajax_callback);
				}else{
					$current_node.find('span').text("Skipping");
					setTimeout(find_next,300);
				}
			}
		}
		function find_next(){
			var do_next = false;
			if($current_node){
				if(!$current_node.data('done_item')){
					items_completed++;
					$current_node.data('done_item',1);
				}
				$current_node.find('.spinner').css('visibility','hidden');
			}
			// var $items = $('div.envato_default_content');
			var $items = $('.item.active[data-checked="true"] li.envato_default_content');
			var $enabled_items = $('.item.active[data-checked="true"] li.envato_default_content input:checked');

			$items.each(function(){
				if (current_item == '' || do_next) {
					current_item = $(this).data('content');
					file_url = $(this).data('file_url');
					type_import = getCookie('importType');
					$current_node = $(this);
					process_current();
					do_next = false;
				} else if ($(this).data('content') == current_item) {
					do_next = true;
				}
			});
			if(items_completed >= $items.length){
				// finished all items!
				complete();
			}
		}

		return {
			init: function(btn){
				$('.aheto-import-theme-data').addClass('installing');
				$('.aheto-import-theme-data').find('input').prop("disabled", true);
				complete = function(){
					$(".install-text").text('Succeess').css('color', 'green').css('font-weight', 'bold');
					$(".button-next").text('Done');
					setInterval( window.location.href=btn.href, 16000);
				};
				find_next();
			}
		}
	}

	/**
	 * Callback function for the 'click' event of the 'Set Footer Image'
	 * anchor in its meta box.
	 *
	 * Displays the media uploader for selecting an image.
	 *
	 * @since 0.1.0
	 */
	function renderMediaUploader() {
		'use strict';

		var file_frame, attachment;

		if ( undefined !== file_frame ) {
			file_frame.open();
			return;
		}

		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Upload Logo',//jQuery( this ).data( 'uploader_title' ),
			button: {
				text: 'Select Logo' //jQuery( this ).data( 'uploader_button_text' )
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();

			jQuery('.site-logo').attr('src',attachment.url);
			jQuery('#new_logo_id').val(attachment.id);
			// Do something with attachment.id and/or attachment.url here
		});
		// Now display the actual file_frame
		file_frame.open();

	}

	function dtbaker_loading_button(btn){

		var $button = jQuery(btn);
		if($button.data('done-loading') == 'yes')return false;
		var existing_text = $button.text();
		var existing_width = $button.outerWidth();
		var loading_text = "..........----";
		var completed = false;

		$button.css('width',existing_width);
		$button.addClass('dtbaker_loading_button_current');
		var _modifier = $button.is('input') || $button.is('button') ? 'val' : 'text';
		$button[_modifier](loading_text);
		//$button.attr('disabled',true);
		$button.data('done-loading','yes');

		var anim_index = [0,1,2];

		// animate the text indent
		function moo() {
			if (completed)return;
			var current_text = '';
			// increase each index up to the loading length
			for(var i = 0; i < anim_index.length; i++){
				anim_index[i] = anim_index[i]+1;
				if(anim_index[i] >= loading_text.length)anim_index[i] = 0;
				current_text += loading_text.charAt(anim_index[i]);
			}
			$button[_modifier](current_text);
			setTimeout(function(){ moo();},60);
		}

		moo();

		return {
			done: function(){
				completed = true;
				$button[_modifier](existing_text);
				$button.removeClass('dtbaker_loading_button_current');
				$button.attr('disabled',false);
			}
		}

	}

	return {
		init: function(){
			t = this;
			$(window_loaded);
		},
		callback: function(func){

		}
	}

})(jQuery);


EnvatoWizard.init();
