<?php

define( 'WHIZZY_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'WHIZZY_PLUGIN_URL', plugins_url( '', __FILE__ ) );

class WhizzyAdvanced {

    private $_whizzy_settings = array();

	public function __construct() {
		add_action( 'wp_footer', array( $this, 'render_comments_popup' ) );
		add_action( 'plugins_loaded', array( $this, 'register_helper_functions' ) );
		add_action( 'vc_before_init', array( $this, 'register_vc_shortcodes' ) );
		add_filter( 'template_include', array( $this, 'get_plugin_templates' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_print_scripts-post.php', array( $this, 'enqueue_shortcode_scripts' ), 99 );
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'enqueue_shortcode_scripts' ), 99 );
		//add_action( 'post_submitbox_misc_actions', array( $this, 'gallery_approve_metabox' ) );

        add_filter( 'whizzy_config_fields', array( $this, 'whizzy_config_fields' ) );
        // Watermark
		// add_filter( 'whizzy_meta_boxes_settings', array( $this, 'whizzy_meta_boxes_settings' ) );
		// add_action( 'whizzy_extra_gallery_buttons', array( $this, 'whizzy_gallery_buttons' ) );
		add_filter( 'whizzy_config_fields_general', array( $this, 'whizzy_config_fields_general' ) );
		add_action( 'whizzy_admin_settings_tab_list', array( $this, 'whizzy_admin_settings_tab_list' ) );
		add_action( 'whizzy_admin_settings_tabs_content', array( $this, 'whizzy_admin_settings_tabs_content' ) );
        add_filter( 'whizzy_before_update_setting_fields', array( $this, 'whizzy_before_update_setting_fields' ) );
        // Watermark
		add_filter( 'whizzy_watermark_gallery_image', array( $this, 'create_watermark_for_image_before_show' ), 10, 3 );

		add_action( 'edited_whizzy-client', array( $this, 'whizzy_client_save_custom_meta' ) );
		add_action( 'create_whizzy-client', array( $this, 'whizzy_client_save_custom_meta' ) );
		add_action( 'whizzy-client_add_form_fields', array( $this, 'whizzy_client_taxonomy_add_form_fields' ) );
		add_action( 'whizzy-client_edit_form_fields', array( $this, 'whizzy_client_taxonomy_edit_form_fields' ) );

		add_action( 'wp_ajax_whizzy-approve-galley', array( $this, 'ajax_approve_gallery' ) );
		add_action( 'wp_ajax_whizzy-watermark-image', array( $this, 'ajax_watermark_image' ) );
		add_action( 'wp_ajax_whizzy-send-photo-comment', array( $this, 'ajax_send_photo_comment' ) );
		add_action( 'wp_ajax_whizzy-get-photo-comments', array( $this, 'ajax_get_photo_comments' ) );
		add_action( 'wp_ajax_nopriv_whizzy-send-photo-comment', array( $this, 'ajax_send_photo_comment' ) );
		add_action( 'wp_ajax_nopriv_whizzy-get-photo-comments', array( $this, 'ajax_get_photo_comments' ) );
		add_action( 'wp_ajax_nopriv_whizzy-login', array( $this, 'ajax_user_login' ) );
	}

	/**
     * Get Settings from Options
     *
	 * @param string $param
	 * @return mixed
	 */
	public function get_whizzy_settings( $param = null ) {
	    if ( empty( $this->_whizzy_settings ) ) {
	        $this->_whizzy_settings = get_option( 'whizzy_settings' );
        }
        if ( isset( $param ) ) {
			if ( !empty( $this->_whizzy_settings[ $param ] )){
				return $this->_whizzy_settings[ $param ];
			}
        }
        return $this->_whizzy_settings;
    }

	/**
	 * Enqueue styles and scripts
	 */
	public function enqueue_frontend_scripts() {
        wp_enqueue_style( 'whizzy_skin', WHIZZY_PLUGIN_URL . '/assets/css/skin.css', array() );
        wp_enqueue_style( 'whizzy-advanced-main', WHIZZY_PLUGIN_URL . '/assets/css/advanced.css', array() );
		wp_enqueue_style( 'whizzy-advanced-shortcodes', WHIZZY_PLUGIN_URL . '/assets/css/shortcodes.css', array() );

		wp_enqueue_script( 'whizzy-advanced-main', WHIZZY_PLUGIN_URL . '/assets/js/advanced.min.js', array( 'whizzy-plugin-script' ), null, true );
		wp_enqueue_script( 'whizzy-advanced-shortcodes', WHIZZY_PLUGIN_URL . '/assets/js/shortcodes.min.js', array( 'lightgallery' ), null, true );
	}

	/**
	 * Enqueue admin script and style
	 */
	public function enqueue_admin_scripts() {
        wp_enqueue_media();
        wp_enqueue_style( 'whizzy-advanced-admin', WHIZZY_PLUGIN_URL . '/assets/css/admin-advanced.css', array() );

        wp_enqueue_script( 'whizzy-advanced-admin', WHIZZY_PLUGIN_URL . '/assets/js/admin-advanced.min.js', array( 'jquery' ), null, true );
    }

	/**
	 * Enqueue admin script for shortcodes
	 */
    public function enqueue_shortcode_scripts() {
        wp_enqueue_script( 'whizzy-admin-shortcodes', WHIZZY_PLUGIN_URL . '/assets/js/admin-shortcodes.min.js', array( 'jquery' ), null, true );
    }

	/**
     * Get plugin templates if need
     *
	 * @param string $template
	 * @return string
	 */
	public function get_plugin_templates( $template ) {
	    $whizzy_settings = $this->get_whizzy_settings();
	    $author_dashboard_page = isset( $whizzy_settings['author_dashboard_page'] ) ? $whizzy_settings['author_dashboard_page'] : false;

	    if ( $author_dashboard_page && is_page( $author_dashboard_page ) ) {
		    return WHIZZY_PLUGIN_DIR . '/templates/author-dashboard.php';
	    }

	    return $template;
    }

	/**
	 * Load custom plugin files
	 */
    public function register_helper_functions() {
	    require_once WHIZZY_PLUGIN_DIR . '/core/helper-functions.php';
    }

	/**
	 * Load Visual Composer ShortCodes
	 */
    public function register_vc_shortcodes() {
	    if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	        require_once WHIZZY_PLUGIN_DIR . '/core/shortcodes/albums.php';
	        require_once WHIZZY_PLUGIN_DIR . '/core/shortcodes/galleries.php';
        }
    }

	/**
     * Remove not need fields before save options
     *
	 * @param array $fields
	 * @return array
	 */
    public function whizzy_before_update_setting_fields( $fields ) {
	    unset( $fields['watermark']['nonce'] );

        return $fields;
    }

	/**
     * Add config fields
     *
	 * @param array $fields
	 * @return array
	 */
    public function whizzy_config_fields( $fields ) {
	    $fields['watermark_design'] = array(
		    'type' => 'group',
		    'options' => array(),
        );

	    return $fields;
    }

	/**
     * Add new meta boxes item for Whizzy Gallery
     *
	 * @param array $meta_boxes
	 * @return array
	 */
    public function whizzy_meta_boxes_settings( $meta_boxes ) {
        if ( isset( $meta_boxes['test_metabox']['fields']['tab_two'] ) ) {
            $meta_boxes['test_metabox']['fields']['tab_two'][] = array(
                'id' => '_whizzy_advanced_watermark',
                'name' => __( 'Show "Watermarked" Images', 'whizzy' ),
                'desc' => __( 'Do you want to it?', 'whizzy' ),
                'type' => 'checkbox',
            );
        }

        return $meta_boxes;
    }

	/**
     * Add extra fields to general tab
     *
	 * @param array $params
	 * @return array
	 */
    public function whizzy_config_fields_general( $params ) {
	    $pages = array( '' => __( 'None', 'whizzy' ) );
	    foreach ( get_pages() as $page ) {
	        $pages[ $page->ID ] = $page->post_title;
        }

	    $params['options']['page_settings'] = array(
		    'type' => 'group',
		    'options' => array(
			    'author_dashboard_page' => array(
				    'type' => 'select',
				    'name' => 'author_dashboard_page',
				    'desc' => __( 'Please, select author page', 'whizzy' ),
				    'label' => __( 'Author Dashboard Page', 'whizzy' ),
				    'options' => $pages,
			    ),
		    ),
	    );

	    return $params;
    }

	/**
	 * Show tab "Watermark Design" in Whizyy Setting page
	 */
    public function whizzy_admin_settings_tab_list() {
        ?>

        <li>
            <a href="#">
                <span class="dashicons-before dashicons-admin-appearance"></span>
                <?php _e( 'Watermark Design', 'whizzy' ); ?>
            </a>
        </li>

        <?php
    }

	/**
	 * Render "Watermark Design" content in Whizzy Settings page
     *
     * @param WhizzyForm $form
	 */
    public function whizzy_admin_settings_tabs_content( $form ) {
	    $whizzy_settings = $this->get_whizzy_settings( 'watermark' );
	    $whizzy_watermark_image_time = get_option( 'whizzy_watermark_img_time' );

	    $watermark_type = ( isset( $whizzy_settings['type'] ) && $whizzy_settings['type'] === 'text' ) ? 'text' : 'image';
	    $watermark_text = isset( $whizzy_settings['text'] ) ? sanitize_text_field( $whizzy_settings['text'] ) : '';
	    $watermark_font = isset( $whizzy_settings['font'] ) ? sanitize_text_field( $whizzy_settings['font'] ) : '';
	    $watermark_color = isset( $whizzy_settings['color'] ) ? sanitize_text_field( $whizzy_settings['color'] ) : '';
	    $watermark_image_id = isset( $whizzy_settings['watermark_image_id'] ) ? intval( $whizzy_settings['watermark_image_id'] ) : 0;
	    $watermark_position = isset( $whizzy_settings['position'] ) ? sanitize_text_field( $whizzy_settings['position'] ) : '';
	    $watermark_font_size = isset( $whizzy_settings['font_size'] ) ? intval( $whizzy_settings['font_size'] ) : 0;
	    $watermark_opacity = isset( $whizzy_settings['opacity'] ) ? intval( $whizzy_settings['opacity'] ) : 0;
	    $watermark_offsetx = isset( $whizzy_settings['offsetx'] ) ? intval( $whizzy_settings['offsetx'] ) : 0;
	    $watermark_offsety = isset( $whizzy_settings['offsety'] ) ? intval( $whizzy_settings['offsety'] ) : 0;

	    if ( empty( $whizzy_watermark_image_time ) ) {
		    $watermark_image = WHIZZY_PLUGIN_URL . '/assets/img/watermark-preview.jpg'; // default watermark
	    } else {
		    $upload_dir = wp_upload_dir( $whizzy_watermark_image_time, false );
		    $watermark_image = $upload_dir['url'] . '/whizzy-watermarked-image.jpg';
        }

	    ?>

        <div class="tabs-item">
	        <?php echo $form->field( 'watermark_design' )->render(); ?>
            <input type="hidden" id="watermark-field-nonce" name="watermark[nonce]" value="<?php echo wp_create_nonce( 'WhizzyAdvanced' ); ?>">

            <div class="inside watermark-editor-wrapper wew-wrapper">
                <div class="field-wrap">
                    <div class="group">
                        <div class="field">
                            <div class="select wew-heading">
                                <h3><?php _e( 'Watermark Editor', 'whizzy' ); ?></h3>
                                <p><?php _e( 'Create a custom watermark to project your images from unauthorized distribution.', 'whizzy' ); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="group">
                        <div class="field">
                            <div class="watermark-types wew-types">
                                <div class="active"><?php _e( 'Text', 'whizzy' ); ?></div>
                                <div><?php _e( 'Image', 'whizzy' ); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="group wew-content">
                        <div class="field">
                            <div class="editor-wrapper">
                                <div class="image-wrapper whizzy-pro--image-uploader">
                                    <p><?php _e( 'Preview', 'whizzy' ); ?></p>
                                    <div class="wew-preloader-wrapper">
                                        <div class="loader-wrap hidden">
                                            <div class="spinner-eff spinner-eff-2">
                                                <div class="square"></div>
                                            </div>
                                        </div>
                                        <img id="watermark-image-show" src="<?php echo esc_url( $watermark_image ); ?>" alt="">
                                    </div>
                                </div>
                                <div class="image-editor">
                                    <div id="watermark-form">
                                        <input id="watermark-type" type="hidden" name="watermark[type]" value="<?php echo esc_attr( $watermark_type ); ?>">
                                        <div class="form-field wew-hide-for-text active whizzy-pro--image-uploader">
                                            <label for="watermark-image-preview-btn"><?php _e( 'Preview', 'whizzy' ); ?></label>
                                            <input id="watermark-image-preview-input" type="hidden" name="watermark[watermark_image_id]" class="input-wp-image" value="<?php echo esc_attr( $watermark_image_id ); ?>">
                                            <img id="watermark-image-preview" class="image-wp-image" src="<?php echo esc_url( wp_get_attachment_image_url( $watermark_image_id ) ); ?>" alt="">
                                            <button type="button" id="watermark-image-preview-btn" class="button upload-wp-image"><?php _e( 'Upload Image', 'whizzy' ); ?></button>
                                        </div>
                                        <div class="form-field wew-hide-for-image">
                                            <label for="watermark-field-text"><?php _e( 'Text', 'whizzy' ); ?></label>
                                            <div class="image-editor-rightside">
                                                <input type="text" id="watermark-field-text" name="watermark[text]" value="<?php echo esc_attr( $watermark_text ); ?>">
                                            </div>
                                        </div>
                                        <div class="form-field wew-hide-for-image">
                                            <label for="watermark-field-font"><?php _e( 'Font', 'whizzy' ); ?></label>
                                            <div class="image-editor-rightside">
                                                <select name="watermark[font]" id="watermark-field-font">
                                                    <option value="Arial" <?php selected( $watermark_font, 'Arial' ); ?>><?php _e( 'Arial', 'whizzy' ); ?></option>
                                                </select>
                                                <div class="font-type-wrapper">
                                                    <div class="font-type"><strong>B</strong></div>
                                                    <div class="font-type"><em>I</em></div>
                                                    <div class="font-type"><u>U</u></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-field wew-hide-for-image">
                                            <label for="watermark-field-font-size"><?php _e( 'Font Size', 'whizzy' ); ?></label>
                                            <div class="image-editor-rightside image-editor-rightside--start">
                                                <input type="range" id="watermark-field-font-size" name="watermark[font_size]" min="6" step="2" max="96" value="<?php echo esc_attr( $watermark_font_size ); ?>">
                                                <p class="wew-fontsize"></p>
                                            </div>
                                        </div>
                                        <div class="form-field wew-hide-for-image">
                                            <label for="watermark-field-color"><?php _e( 'Color', 'whizzy' ); ?></label>
                                            <div class="image-editor-rightside">
                                                <input type="text" id="watermark-field-color" name="watermark[color]" value="<?php echo esc_attr( $watermark_color ); ?>">
                                            </div>
                                        </div>
                                        <div class="form-field">
                                            <label for="watermark-field-opacity"><?php _e( 'Opacity', 'whizzy' ); ?></label>
                                            <div class="image-editor-rightside image-editor-rightside--start">
                                                <input type="range" id="watermark-field-opacity" name="watermark[opacity]" min="0" step="1" max="100" value="<?php echo esc_attr( $watermark_opacity ); ?>">
                                                <p class="wew-opacity"></p>
                                            </div>
                                        </div>
                                        <div class="form-field">
                                            <label for="watermark-field-position"><?php _e( 'Position', 'whizzy' ); ?></label>
                                            <input type="hidden" id="watermark-field-position" name="watermark[position]" value="<?php echo esc_attr( $watermark_position ); ?>">
                                            <div class="image-editor-rightside image-editor-rightside--start image-editor-rightside--offset">
                                                <div class="wew-position-wrapper">
                                                    <div class="wew-position" data-position="NorthWest">
                                                        <i class="dashicons dashicons-yes"></i>
                                                    </div>
                                                    <div class="wew-position" data-position="North">
                                                        <i class="dashicons dashicons-yes"></i>
                                                    </div>
                                                    <div class="wew-position" data-position="NorthEast">
                                                        <i class="dashicons dashicons-yes"></i>
                                                    </div>
                                                    <div class="wew-position" data-position="West">
                                                        <i class="dashicons dashicons-yes"></i>
                                                    </div>
                                                    <div class="wew-position" data-position="Center">
                                                        <i class="dashicons dashicons-yes"></i>
                                                    </div>
                                                    <div class="wew-position" data-position="East">
                                                        <i class="dashicons dashicons-yes"></i>
                                                    </div>
                                                    <div class="wew-position" data-position="SouthWest">
                                                        <i class="dashicons dashicons-yes"></i>
                                                    </div>
                                                    <div class="wew-position" data-position="South">
                                                        <i class="dashicons dashicons-yes"></i>
                                                    </div>
                                                    <div class="wew-position" data-position="SouthEast">
                                                        <i class="dashicons dashicons-yes"></i>
                                                    </div>
                                                </div>
                                                <div class="wew-offset-wrapper">
                                                    <div class="wew-offset wew-offset--x">
                                                        <label for="watermark-field-offsetx"><?php _e( 'Offset X', 'whizzy' ); ?></label>
                                                        <input type="number" id="watermark-field-offsetx" name="watermark[offsetx]" value="<?php echo esc_attr( $watermark_offsetx ); ?>">
                                                    </div>
                                                    <div class="wew-offset wew-offset--y">
                                                        <label for="watermark-field-offsety"><?php _e( 'Offset Y', 'whizzy' ); ?></label>
                                                        <input type="number" id="watermark-field-offsety" name="watermark[offsety]" value="<?php echo esc_attr( $watermark_offsety ); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

	/**
	 * Show "Approve Gallery" button on gallery page
	 */
    public function whizzy_gallery_buttons() {
        $gallery_id = get_queried_object_id();
	    $approve_status = get_post_meta( $gallery_id, 'whizzy_gallery_approve_status', true );
        $clients = get_the_terms( $gallery_id, 'whizzy-client' );
        $client = ( ! empty( $clients ) ) ? reset( $clients ) : null;

        if ( $client && ! $approve_status ) {
	        $galley_client = get_term_meta( $client->term_id, 'whizzy_user_id', true );

	        if ( $galley_client == get_current_user_id() ) {
	            echo '<button class="button-download a-btn-2 aheto-btn aheto-btn--primary button whizzy-pro-approve-gallery" data-id="'. $gallery_id .'" data-nonce="'. wp_create_nonce( 'WhizzyAdvanced' ) .'">';
	            echo '<em>'. __( 'Approve Gallery', 'whizzy' ) .'</em>';
	            echo '<em class="hidden">'. __( 'Approved', 'whizzy' ) .'</em>';
	            echo '<i class="fa fa-caret-right aheto-btn__icon--right" aria-hidden="true"></i>';
	            echo '</button>';
            }
        }
    }

	/**
	 * Add Custom Fields to Whizzy Clients taxonomy for create
	 */
    public function whizzy_client_taxonomy_add_form_fields() {
	    ob_start(); ?>

        <div class="form-field term-parent-wrap">
            <label for="whizzy_meta[user_id]"><?php _e( 'User', 'whizzy' ); ?></label>
            <?php
            wp_dropdown_users( array(
                'id' => 'whizzy-meta-user-id',
                'name' => 'whizzy_meta[user_id]',
                'show_option_none' => __( 'None', 'whizzy' ),
            ) );
            ?>
        </div>

        <?php echo ob_get_clean();
    }

	/**
	 * Add Custom Fields to Whizzy Clients taxonomy for update
	 *
	 * @param WP_Term $term
	 */
    public function whizzy_client_taxonomy_edit_form_fields( $term ) {
	    ob_start(); ?>

        <tr class="form-field term-parent-wrap">
            <th scope="row">
                <label for="whizzy_meta[user_id]"><?php _e( 'User', 'whizzy' ); ?></label>
            </th>
            <td>
	            <?php
	            wp_dropdown_users( array(
		            'id' => 'whizzy-meta-user-id',
		            'name' => 'whizzy_meta[user_id]',
		            'selected' => get_term_meta( $term->term_id, 'whizzy_user_id', true ),
		            'show_option_none' => __( 'None', 'whizzy' ),
	            ) );
	            ?>
            </td>
        </tr>

	    <?php echo ob_get_clean();
    }

	/**
     * Save Custom Meta to Whizzy Clients
     *
	 * @param int $term_id
	 */
    public function whizzy_client_save_custom_meta( $term_id ) {
        if ( ! empty( $_POST['whizzy_meta'] ) ) {
            $user_id = ( ! empty( $_POST['whizzy_meta']['user_id'] ) ) ? intval( $_POST['whizzy_meta']['user_id'] ) : '';

            update_term_meta( $term_id, 'whizzy_user_id', $user_id );
        }
    }

	/**
     * Show "Gallery Approve" status in admin panel
     *
	 * @param WP_Post $post
	 */
    public function gallery_approve_metabox( $post ) {
        if ( 'whizzy_proof_gallery' === $post->post_type ) {
	        $approve_status = get_post_meta( $post->ID, 'whizzy_gallery_approve_status', true );

	        if ( '1' == $approve_status ) {
		        $approve_text = __( 'Approved', 'whizzy' );
	        } elseif ( '0' == $approve_status ) {
		        $approve_text = __( 'Not Approved!', 'whizzy' );
	        } else {
		        $approve_text = __( 'Waiting for approval', 'whizzy' );
	        }

	        ob_start(); ?>

            <div class="misc-pub-section misc-pub-whizzy-gallery-approve" id="whizzy-gallery-approve">
                <span class="dashicons dashicons-nametag"></span>
		        <?php _e( 'Gallery Status:', 'whizzy' ); ?>
                <span id="post-visibility-display">
                <?php echo esc_html( $approve_text ); ?>
            </span>
            </div>

	        <?php echo ob_get_clean();
        }
    }

	/**
	 * Render photo comments popup
	 */
	public function render_comments_popup() {
		ob_start(); ?>

        <div id="whizzy-pro--loader" class="whizzy-loader-container hidden">
            <div class="whizzy-load-speeding-wheel full"></div>
        </div>
        <div class="whizzy-popup-wrapper hidden">
            <div id="whizzy-photo-comments-modal" class="white-popup">
                <span class="whizzy-popup-close"><i class="fa fa-close"></i></span>

                <div class="popup-scroll">
                    <h3><?php _e( 'Add comment', 'whizzy' ); ?></h3>
                    <form id="whizzy-photo-comments-form" method="post">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'WhizzyAdvanced' ); ?>">
                        <input type="hidden" name="action" value="whizzy-send-photo-comment">

				        <?php if ( ! is_user_logged_in() ): ?>
                            <div class="form-group">
                                <label for="comment-name"><?php _e( 'Name*', 'whizzy' ); ?></label>
                                <input type="text" name="name" class="form-control" id="comment-name" placeholder="<?php _e( 'Name', 'whizzy' ); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="comment-email"><?php _e( 'Email*', 'whizzy' ); ?></label>
                                <input type="email" name="email" class="form-control" id="comment-email" placeholder="<?php _e( 'Email', 'whizzy' ); ?>" required>
                            </div>
				        <?php endif; ?>

                        <div class="form-group">
                            <label for="comment-message"><?php _e( 'Message*', 'whizzy' ); ?></label>
                            <textarea name="message" class="form-control" id="comment-message" rows="3" placeholder="<?php _e( 'Message', 'whizzy' ); ?>" required></textarea>
                        </div>
                        <div class="errors-list bg-danger hidden"></div>
                        <button type="submit" class="aheto-btn aheto-btn--primary btn btn-primary"><?php _e( 'Send', 'whizzy' ); ?></button>
                    </form>

                    <h3><?php _e( 'Comments', 'whizzy' ); ?></h3>
                    <div class="whiizy-pro--comments-list-container"></div>
                </div>
            </div>
        </div>

		<?php echo ob_get_clean();
	}

    // Watermark
	/**
     * Create watermark image instead selected image
     *
	 * @param string $image_url
	 * @param int $image_id
	 * @param bool $enable_watermark
	 * @return string
	 */
	public function create_watermark_for_image_before_show( $image_url, $image_id, $enable_watermark ) {
		if ( isset( $image_url, $image_id ) && $enable_watermark ) {
			$upload_dir = wp_get_upload_dir();
			$temp_watermark_file = $upload_dir['path'] . '/' . uniqid( 'whizzy-watermark-temp-' ) . '.jpg';
			$watermark_settings = $this->get_whizzy_settings( 'watermark' );
			$watermark = new \Ajaxray\PHPWatermark\Watermark( get_attached_file( $image_id ) );
			$watermark->setFont( $watermark_settings['font'] )
			          ->setFontSize( $watermark_settings['font_size'] )
			          ->setOpacity( $watermark_settings['opacity'] / 100 )
			          ->setPosition( $watermark_settings['position'] )
			          ->setOffset( $watermark_settings['offsetx'], $watermark_settings['offsety'] );

			if ( ! empty( $watermark_settings['text'] && $watermark_settings['type'] === 'text' ) ) {
				$watermark->withText( $watermark_settings['text'], $temp_watermark_file );
			}
			if ( ! empty( $watermark_settings['watermark_image_id'] ) && $watermark_settings['type'] === 'image' ) {
				$watermark_image_path = get_attached_file( $watermark_settings['watermark_image_id'] );
				$watermark->withImage( $watermark_image_path, $temp_watermark_file );
			}

			if ( file_exists( $temp_watermark_file ) ) {
				$image_url = 'data:image/jpg;base64,'. base64_encode( file_get_contents( $temp_watermark_file ) );
				unlink( $temp_watermark_file );
				unset( $watermark );
			}
		}

		return $image_url;
	}

	/**
	 * AJAX: User authorize
	 */
	public function ajax_user_login() {
	    if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'WhizzyAdvanced' ) ) {
	        if ( ! empty( $_POST['email'] ) && ! empty( $_POST['password'] ) ) {
	            $current_page_id = isset( $_POST['page_id'] ) ? intval( $_POST['page_id'] ) : 0;
	            $login = is_email( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : sanitize_text_field( $_POST['email'] );
	            $password = sanitize_text_field( $_POST['password'] );

	            $signon = wp_signon( array( 'user_login' => $login, 'user_password' => $password, 'remember' => true ) );

	            if ( is_wp_error( $signon ) ) {
	                wp_send_json( array( 'status' => false, 'msg' => __( 'The password or username is incorrect!', 'whizzy' ) ) );
                } else {
	                wp_send_json( array( 'status' => true, 'redirect_to' => get_permalink( $current_page_id ) ) );
                }
            }
        }
    }

	/**
	 * AJAX: get photo comments
	 */
	public function ajax_get_photo_comments() {
	    $output = '';

	    if ( isset( $_GET['attachment_id'] ) ) {
	        $comments = get_comments( array( 'post_id' => intval( $_GET['attachment_id'] ) ) );

	        if ( ! empty( $comments ) ) {
	            $date_time_format = get_option( 'date_format' ) .' '. get_option( 'time_format' );
		        $output .= '<ul class="media-list">';

		        foreach ( $comments as $comment ) {
			        $output .= '<li class="media">';
			        $output .= '<div class="media-left">';
			        $output .= '<img class="media-object" src="'. get_avatar_url( get_the_author_meta( 'ID', $comment->user_id ) ) .'" alt="">';
			        $output .= '</div>';
			        $output .= '<div class="media-body">';
			        $output .= '<h4 class="media-heading">';
			        $output .= $comment->comment_author;
			        $output .= '<small>'. date( $date_time_format, strtotime( $comment->comment_date ) ) .'</small>';
			        $output .= '</h4>';
			        $output .= esc_html( $comment->comment_content );
			        $output .= '</div>';
			        $output .= '</li>';
                }

		        $output .= '</ul>';
            }
        }

        wp_send_json( $output );
    }

	/**
	 * AJAX: send comment to photo
	 */
    public function ajax_send_photo_comment() {
	    if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'WhizzyAdvanced' ) ) {
	        $name = ( ! empty( $_POST['name'] ) ) ? sanitize_text_field( $_POST['name'] ) : null;
	        $email = ( ! empty( $_POST['email'] ) ) ? sanitize_email( $_POST['email'] ) : null;
	        $message = ( ! empty( $_POST['message'] ) ) ? sanitize_textarea_field( $_POST['message'] ) : null;
		    $attachment_id = ( ! empty( $_POST['attachment_id'] ) ) ? intval( $_POST['attachment_id'] ) : null;

	        if ( ! isset( $message, $attachment_id ) ) {
		        wp_send_json( array( 'status' => false, 'msg' => __( 'Message field is a required!', 'whizzy' ) ) );
            }
            if ( is_user_logged_in() ) {
	            $name = wp_get_current_user()->user_login;
	            $email = wp_get_current_user()->user_email;
            } else {
	            if ( ! isset( $name, $email ) ) {
		            wp_send_json( array( 'status' => false, 'msg' => __( 'Name and Email fields is a required!', 'whizzy' ) ) );
	            }
            }

            $status = wp_insert_comment( wp_slash( array(
	            'comment_author' => $name,
	            'comment_author_email' => $email,
	            'comment_post_ID' => $attachment_id,
	            'comment_content' => $message,
                'user_id' => get_current_user_id(),
            ) ) );
	        wp_send_json( array( 'status' => (bool) $status ) );
        }

	    wp_send_json( array( 'status' => false, 'msg' => __( 'Bad request!', 'whizzy' ) ) );
    }

	/**
	 * AJAX: Approve gallery
	 */
    public function ajax_approve_gallery() {
        if ( isset( $_POST['nonce'], $_POST['gallery_id'] ) && wp_verify_nonce( $_POST['nonce'], 'WhizzyAdvanced' ) ) {
            wp_send_json( (bool) add_post_meta( intval( $_POST['gallery_id'] ), 'whizzy_gallery_approve_status', true ) );
        }

        wp_send_json( false );
    }

	/**
	 * AJAX: Create watermark image preview
	 */
    public function ajax_watermark_image() {
	    $text = ( ! empty( $_POST['text'] ) ) ? sanitize_text_field( $_POST['text'] ) : null;
	    $font = ( ! empty( $_POST['font'] ) ) ? sanitize_text_field( $_POST['font'] ) : null;
	    $nonce = ( ! empty( $_POST['nonce'] ) ) ? sanitize_text_field( $_POST['nonce'] ) : null;
	    $position = ( ! empty( $_POST['position'] ) ) ? sanitize_text_field( $_POST['position'] ) : null;
	    $font_size = ( ! empty( $_POST['font_size'] ) ) ? intval( $_POST['font_size'] ) : 0;
	    $opacity = ( ! empty( $_POST['opacity'] ) ) ? intval( $_POST['opacity'] ) : 0;
	    $offsetx = ( ! empty( $_POST['offsetx'] ) ) ? intval( $_POST['offsetx'] ) : 0;
	    $offsety = ( ! empty( $_POST['offsety'] ) ) ? intval( $_POST['offsety'] ) : 0;
	    $color = ( ! empty( $_POST['color'] ) ) ? sanitize_text_field( $_POST['color'] ) : null;
	    $watermark_image = ( ! empty( $_POST['watermark_image'] ) ) ? intval( $_POST['watermark_image'] ) : 0;
	    $type = ( isset( $_POST['type'] ) && $_POST['type'] === 'image' ) ? 'image' : 'text';

	    if ( ! wp_verify_nonce( $nonce, 'WhizzyAdvanced' ) ) {
            wp_send_json( array( 'status' => false, 'msg' => __( 'Bad request!', 'whizzy' ) ) );
        }

	    if ( $whizzy_watermark_image_time = get_option( 'whizzy_watermark_img_time' ) ) {
		    $upload_dir = wp_upload_dir( $whizzy_watermark_image_time, false );
	    } else {
		    $upload_dir = wp_upload_dir();
		    add_option( 'whizzy_watermark_img_time', ltrim( $upload_dir['subdir'], '/' ) );
        }

        $image_path = WHIZZY_PLUGIN_DIR . '/assets/img/watermark-preview.jpg'; // default watermark;
        $output_url = $upload_dir['url'] . '/whizzy-watermarked-image.jpg?time='. time();
        $output_path = $upload_dir['path'] . '/whizzy-watermarked-image.jpg';


        if ( $image_path ) {
            $watermark = new \Ajaxray\PHPWatermark\Watermark( $image_path );

            if ( isset( $font ) ) {
                $watermark->setFont( $font );
            }
            if ( isset( $font_size ) ) {
                $watermark->setFontSize( $font_size );
            }
            if ( isset( $opacity ) ) {
                $watermark->setOpacity( ( $opacity / 100 ) );
            }
            if ( isset( $position ) ) {
                $watermark->setPosition( $position );
            }
            if ( isset( $offsetx, $offsety ) ) {
                $watermark->setOffset( $offsetx, $offsety );
            }
            if ( ! empty( $text ) && $type === 'text' ) {
                wp_send_json( array( 'status' => $watermark->withText( $text, $output_path ), 'img_url' => $output_url ) );
            }
            if ( ! empty( $watermark_image ) && $type === 'image' ) {
                $watermark_image_path = get_attached_file( $watermark_image );
                wp_send_json( array( 'status' => $watermark->withImage( $watermark_image_path, $output_path ), 'img_url' => $output_url ) );
            }
        }
    }

}

new WhizzyAdvanced();
