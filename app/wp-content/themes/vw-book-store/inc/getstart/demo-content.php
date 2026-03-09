<div class="theme-offer">
	<?php
        // Check if the demo import has been completed
        $vw_book_store_demo_import_completed = get_option('vw_book_store_demo_import_completed', false);

        // If the demo import is completed, display the "View Site" button
        if ($vw_book_store_demo_import_completed) {
        echo '<p class="notice-text">' . esc_html__('Your demo import has been completed successfully.', 'vw-book-store') . '</p>';
        echo '<span><a href="' . esc_url(home_url()) . '" class="button button-primary site-btn" target="_blank">' . esc_html__('View Site', 'vw-book-store') . '</a></span>';
        echo '<span><a href="'. esc_url(admin_url('customize.php') ) .'" class="button button-primary demo-btn" target=_blank>'. esc_html__( 'Customize Your Site', 'vw-book-store' ) .'</a></span>';
        echo '<span><a href="'. esc_url( 'https://preview.vwthemesdemo.com/docs/free-vw-books-store/' ) .'" class="button button-primary doc-btn" target=_blank>'. esc_html__( 'Free Theme Documentation', 'vw-book-store' ) .'</a></span>';    
    }

		//POST and update the customizer and other related data of POLITICAL CAMPAIGN
        if (isset($_POST['submit'])) {

            // Check if ibtana visual editor is installed and activated
            if (!is_plugin_active('ibtana-visual-editor/plugin.php')) {
              // Install the plugin if it doesn't exist
              $vw_book_store_plugin_slug = 'ibtana-visual-editor';
              $vw_book_store_plugin_file = 'ibtana-visual-editor/plugin.php';

              // Check if plugin is installed
              $vw_book_store_installed_plugins = get_plugins();
              if (!isset($vw_book_store_installed_plugins[$vw_book_store_plugin_file])) {
                  include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
                  include_once(ABSPATH . 'wp-admin/includes/file.php');
                  include_once(ABSPATH . 'wp-admin/includes/misc.php');
                  include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

                  // Install the plugin
                  $vw_book_store_upgrader = new Plugin_Upgrader();
                  $vw_book_store_upgrader->install('https://downloads.wordpress.org/plugin/ibtana-visual-editor.latest-stable.zip');
              }
              // Activate the plugin
              activate_plugin($vw_book_store_plugin_file);
            }

            // Check if Contact Form 7 is installed and activated
            if (!is_plugin_active('woocommerce/woocommerce.php')) {
              // Install the plugin if it doesn't exist
              $vw_book_store_plugin_slug = 'woocommerce';
              $vw_book_store_plugin_file = 'woocommerce/woocommerce.php';

              // Check if plugin is installed
              $installed_plugins = get_plugins();
              if (!isset($installed_plugins[$vw_book_store_plugin_file])) {
                  include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
                  include_once(ABSPATH . 'wp-admin/includes/file.php');
                  include_once(ABSPATH . 'wp-admin/includes/misc.php');
                  include_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

                  // Install the plugin
                  $vw_book_store_upgrader = new Plugin_Upgrader();
                  $vw_book_store_upgrader->install('https://downloads.wordpress.org/plugin/woocommerce.latest-stable.zip');
              }
              // Activate the plugin
              activate_plugin($vw_book_store_plugin_file);
            }

            // ------- Create Nav Menu --------
            $vw_book_store_menuname = 'Main Menus';
            $vw_book_store_bpmenulocation = 'primary';
            $vw_book_store_menu_exists = wp_get_nav_menu_object($vw_book_store_menuname);

            if (!$vw_book_store_menu_exists) {
                $vw_book_store_menu_id = wp_create_nav_menu($vw_book_store_menuname);

                // Create Home Page
                $vw_book_store_home_title = 'Home';
                $vw_book_store_home = array(
                    'post_type' => 'page',
                    'post_title' => $vw_book_store_home_title,
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_slug' => 'home'
                );
                $vw_book_store_home_id = wp_insert_post($vw_book_store_home);
                // Assign Home Page Template
                add_post_meta($vw_book_store_home_id, '_wp_page_template', 'page-template/custom-home-page.php');
                // Update options to set Home Page as the front page
                update_option('page_on_front', $vw_book_store_home_id);
                update_option('show_on_front', 'page');
                // Add Home Page to Menu
                wp_update_nav_menu_item($vw_book_store_menu_id, 0, array(
                    'menu-item-title' => __('Home', 'vw-book-store'),
                    'menu-item-classes' => 'home',
                    'menu-item-url' => home_url('/'),
                    'menu-item-status' => 'publish',
                    'menu-item-object-id' => $vw_book_store_home_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type'
                ));

                // Create Pages Page with Dummy Content
                $vw_book_store_pages_title = 'Pages';
                $vw_book_store_pages_content = '
                <p>Explore all the pages we have on our website. Find information about our services, company, and more.</p>

                 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br>

                  All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
                $vw_book_store_pages = array(
                    'post_type' => 'page',
                    'post_title' => $vw_book_store_pages_title,
                    'post_content' => $vw_book_store_pages_content,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_slug' => 'pages'
                );
                $vw_book_store_pages_id = wp_insert_post($vw_book_store_pages);
                // Add Pages Page to Menu
                wp_update_nav_menu_item($vw_book_store_menu_id, 0, array(
                    'menu-item-title' => __('Pages', 'vw-book-store'),
                    'menu-item-classes' => 'pages',
                    'menu-item-url' => home_url('/pages/'),
                    'menu-item-status' => 'publish',
                    'menu-item-object-id' => $vw_book_store_pages_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type'
                ));

                // Create About Us Page with Dummy Content
                $vw_book_store_about_title = 'About Us';
                $vw_book_store_about_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

                         Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br>

                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br>

                            All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
                $vw_book_store_about = array(
                    'post_type' => 'page',
                    'post_title' => $vw_book_store_about_title,
                    'post_content' => $vw_book_store_about_content,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_slug' => 'about-us'
                );
                $vw_book_store_about_id = wp_insert_post($vw_book_store_about);
                // Add About Us Page to Menu
                wp_update_nav_menu_item($vw_book_store_menu_id, 0, array(
                    'menu-item-title' => __('About Us', 'vw-book-store'),
                    'menu-item-classes' => 'about-us',
                    'menu-item-url' => home_url('/about-us/'),
                    'menu-item-status' => 'publish',
                    'menu-item-object-id' => $vw_book_store_about_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type'
                ));

                // Create Books Page with Dummy Content
                $vw_book_store_books_title = 'Books';
                $vw_book_store_books_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

                         Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br>

                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br>

                            All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
                $vw_book_store_books = array(
                    'post_type' => 'page',
                    'post_title' => $vw_book_store_books_title,
                    'post_content' => $vw_book_store_books_content,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_slug' => 'books'
                );
                $vw_book_store_books_id = wp_insert_post($vw_book_store_books);
                // Add Books Page to Menu
                wp_update_nav_menu_item($vw_book_store_menu_id, 0, array(
                    'menu-item-title' => __('Books', 'vw-book-store'),
                    'menu-item-classes' => 'books',
                    'menu-item-url' => home_url('/books/'),
                    'menu-item-status' => 'publish',
                    'menu-item-object-id' => $vw_book_store_books_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type'
                ));

                // Create Blog Page 
                $vw_book_store_blog_page_title = 'Blog';
                $vw_book_store_blog_page_query = new WP_Query(array(
                    'post_type'      => 'page',
                    'name'           => sanitize_title($vw_book_store_blog_page_title),
                    'post_status'    => 'publish',
                    'posts_per_page' => 1
                ));
                if (!$vw_book_store_blog_page_query->have_posts()) {
                    $vw_book_store_blog_page = array(
                    'post_type'   => 'page',
                    'post_title'  => $vw_book_store_blog_page_title,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    );
                    $vw_book_store_blog_page_id = wp_insert_post($vw_book_store_blog_page);
                    update_option('page_for_posts', $vw_book_store_blog_page_id);
                    wp_update_nav_menu_item($vw_book_store_menu_id, 0, array(
                    'menu-item-title'      => __('Blog', 'vw-book-store'),
                    'menu-item-url'        => get_permalink($vw_book_store_blog_page_id),
                    'menu-item-status'     => 'publish',
                    'menu-item-object-id'  => $vw_book_store_blog_page_id,
                    'menu-item-object'     => 'page',
                        'menu-item-type'       => 'post_type',
                    ));
                }

                // Create Contact Us Page with Dummy Content
                $vw_book_store_contact_title = 'Contact Us';
                $vw_book_store_contact_content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam...<br>

                         Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br>

                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything embarrassing hidden in the middle of text.<br>

                            All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.';
                $vw_book_store_contact = array(
                    'post_type' => 'page',
                    'post_title' => $vw_book_store_contact_title,
                    'post_content' => $vw_book_store_contact_content,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_slug' => 'contact-us'
                );
                $vw_book_store_contact_id = wp_insert_post($vw_book_store_contact);
                // Add Contact Us Page to Menu
                wp_update_nav_menu_item($vw_book_store_menu_id, 0, array(
                    'menu-item-title' => __('Contact Us', 'vw-book-store'),
                    'menu-item-classes' => 'contact-us',
                    'menu-item-url' => home_url('/contact-us/'),
                    'menu-item-status' => 'publish',
                    'menu-item-object-id' => $vw_book_store_contact_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type'
                ));

                // Set the menu location if it's not already set
                if (!has_nav_menu($vw_book_store_bpmenulocation)) {
                    $locations = get_theme_mod('nav_menu_locations'); // Use 'nav_menu_locations' to get locations array
                    if (empty($locations)) {
                        $locations = array();
                    }
                    $locations[$vw_book_store_bpmenulocation] = $vw_book_store_menu_id;
                    set_theme_mod('nav_menu_locations', $locations);
                }

        }


            // Set the demo import completion flag
    		update_option('vw_book_store_demo_import_completed', true);
    		// Display success message and "View Site" button
    		echo '<p class="notice-text">' . esc_html__('Your demo import has been completed successfully.', 'vw-book-store') . '</p>';
    		echo '<span><a href="' . esc_url(home_url()) . '" class="button button-primary site-btn" target="_blank">' . esc_html__('View Site', 'vw-book-store') . '</a></span>';
            echo '<span><a href="'. esc_url(admin_url('customize.php') ) .'" class="button button-primary demo-btn" target=_blank>'. esc_html__( 'Customize Your Site', 'vw-book-store' ) .'</a></span>';
            echo '<span><a href="'. esc_url( 'https://preview.vwthemesdemo.com/docs/free-vw-books-store/' ) .'" class="button button-primary doc-btn" target=_blank>'. esc_html__( 'Free Theme Documentation', 'vw-book-store' ) .'</a></span>';
            //end


            // Top Bar //
            set_theme_mod( 'vw_book_store_search_icon', 'fas fa-search' );
            set_theme_mod( 'vw_book_store_search_close_icon', 'fa fa-window-close' );
            set_theme_mod( 'vw_book_store_search_placeholder', 'Search' );
            set_theme_mod( 'vw_book_store_header_my_account_icon', 'fas fa-user' );
            set_theme_mod( 'vw_book_store_my_account_text', 'My Account' );
            set_theme_mod( 'vw_book_store_my_account_link', '#' );
            set_theme_mod( 'vw_book_store_help_icon', 'far fa-question-circle' );
            set_theme_mod( 'vw_book_store_help_text', 'Help' );
            set_theme_mod( 'vw_book_store_help_link', '#' );
            set_theme_mod( 'vw_book_store_email_icon', 'far fa-envelope');
            set_theme_mod( 'vw_book_store_email', 'Bookstore@gmail.com');
            set_theme_mod( 'vw_book_store_cart_icon', 'fas fa-shopping-bag');
            set_theme_mod( 'vw_book_store_cart_link', '#');
            set_theme_mod( 'vw_book_store_category_text', 'ALL CATEGORIES');


            // slider section start //
            set_theme_mod( 'vw_book_store_slider_button_text', 'Read More' );
           

            for($vw_book_store_i=1;$vw_book_store_i<=4;$vw_book_store_i++){
               $vw_book_store_slider_title = 'LOREM IPSUM DAMET CONSE TETUR ELIT';
               $vw_book_store_slider_content = 'Lorem ipsum is simply dummy text of the printing and typesetting industry.';
                  // Create post object
               $my_post = array(
               'post_title'    => wp_strip_all_tags( $vw_book_store_slider_title ),
               'post_content'  => $vw_book_store_slider_content,
               'post_status'   => 'publish',
               'post_type'     => 'page',
               );

               // Insert the post into the database
               $vw_book_store_post_id = wp_insert_post( $my_post );

               if ($vw_book_store_post_id) {
                 // Set the theme mod for the slider page
                 set_theme_mod('vw_book_store_slider_page' . $vw_book_store_i, $vw_book_store_post_id);

                  $vw_book_store_image_url = get_template_directory_uri().'/inc/block-patterns/images/banner'.$vw_book_store_i.'.png';

                $vw_book_store_image_id = media_sideload_image($vw_book_store_image_url, $vw_book_store_post_id, null, 'id');

                    if (!is_wp_error($vw_book_store_image_id)) {
                        // Set the downloaded image as the post's featured image
                        set_post_thumbnail($vw_book_store_post_id, $vw_book_store_image_id);
                    }
                }
            }


            // products

            $vw_book_store_title_array = array(
            array("LOREM IPSUM DOLAR SIT EMIT",
                "LOREM IPSUM DOLAR SIT EMIT",
                "LOREM IPSUM DOLAR SIT EMIT",
                "LOREM IPSUM DOLAR SIT EMIT")
            );

            foreach ($vw_book_store_title_array as $vw_book_store_titles) {
                // Loop to create only 4 products
                for ($vw_book_store_i = 0; $vw_book_store_i < 4; $vw_book_store_i++) {
                    // Create product content
                    $vw_book_store_title = $vw_book_store_titles[$vw_book_store_i];
                    $vw_book_store_content = 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.';

                    // Create product post object
                    $vw_book_store_my_post = array(
                        'post_title'    => wp_strip_all_tags($vw_book_store_title),
                        'post_content'  => $vw_book_store_content,
                        'post_status'   => 'publish',
                        'post_type'     => 'product',
                    );
                    set_theme_mod('vw_book_shop_product_page', esc_url($vw_book_store_post_id));
                    // Insert the product into the database
                    $vw_book_store_post_id = wp_insert_post($vw_book_store_my_post);

                    if (is_wp_error($vw_book_store_post_id)) {
                        error_log('Error creating product: ' . $vw_book_store_post_id->get_error_message());
                        continue; // Skip to the next product if creation fails
                    }

                    // Add product meta (price, etc.)
                    update_post_meta($vw_book_store_post_id, '_regular_price', '15.00'); // Regular price
                    update_post_meta($vw_book_store_post_id, '_sale_price', '12.00'); // Sale price
                    update_post_meta($vw_book_store_post_id, '_price', '12.00'); // Active price

                    // Handle the featured image using media_sideload_image
                    $vw_book_store_image_url = get_template_directory_uri() . '/inc/block-patterns/images/product' . ($vw_book_store_i + 1) . '.png';
                    $vw_book_store_image_id = media_sideload_image($vw_book_store_image_url, $vw_book_store_post_id, null, 'id');

                    if (is_wp_error($vw_book_store_image_id)) {
                        error_log('Error downloading image: ' . $vw_book_store_image_id->get_error_message());
                        continue; // Skip to the next product if image download fails
                    }

                    // Assign featured image to product
                    set_post_thumbnail($vw_book_store_post_id, $vw_book_store_image_id);
                }
            }

           // Check if the 'Products' page already exists
            $vw_book_store_page_query = new WP_Query(array(
                'post_type'      => 'page',
                'title'          => 'Products',
                'post_status'    => 'publish',
                'posts_per_page' => 1
            ));

            if (!$vw_book_store_page_query->have_posts()) {
                $vw_book_store_page_title = 'LOREM IPSUM';
                $productpage = '[products limit="4" columns="4"]';

                // Append the WooCommerce products shortcode to the content
                $vw_book_store_content = '';
                $vw_book_store_content .= do_shortcode($productpage);

                // Create the new page
                $vw_book_store_page = array(
                    'post_type'    => 'page',
                    'post_title'   => $vw_book_store_page_title,
                    'post_content' => $vw_book_store_content,
                    'post_status'  => 'publish',
                    'post_author'  => 1,
                    'post_slug'    => 'products'
                );

                // Insert the page and get its ID
                $vw_book_store_page_id = wp_insert_post($vw_book_store_page);

                // Store the page ID in theme mod for future reference
                if (!is_wp_error($vw_book_store_page_id)) {
                    set_theme_mod('vw_book_shop_product_page', $vw_book_store_page_id);
                }
            }

            //Copyright Text
            set_theme_mod( 'vw_book_store_footer_text', 'By VWThemes' );

        }
    ?>

    <form action="<?php echo esc_url(home_url()); ?>/wp-admin/themes.php?page=vw_book_store_guide" method="POST" onsubmit="return validate(this);">
        <?php if (!get_option('vw_book_store_demo_import_completed')) : ?>
            <form method="post">   
            <p class="run-import-text"><?php esc_html_e('Click On The Below Run Importer Button To Import Demo Content Of vw book store', 'vw-book-store'); ?></p>
                <p><?php esc_html_e('Please back up your website if it’s already live with data. This importer will overwrite your existing settings with the new customizer values for vw book store', 'vw-book-store'); ?></p>
                <input class="run-import" type="submit" name="submit" value="<?php esc_attr_e('Run Importer', 'vw-book-store'); ?>" class="button button-primary button-large">
        </form>   
        <?php endif; ?>
        <div id="spinner" style="display:none;">         
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/spinner.png" alt="" />
        </div>
    </form>
    <script type="text/javascript">
        function validate(form) {
            if (confirm("Do you really want to import the theme demo content?")) {
                // Show the spinner
                document.getElementById('spinner').style.display = 'block';
                // Allow the form to be submitted
                return true;
            } 
            else {
                return false;
            }
        }
    </script>
</div>
