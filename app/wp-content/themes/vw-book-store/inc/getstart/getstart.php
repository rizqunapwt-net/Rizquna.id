<?php
/* Add to Dashboard main menu */
function vw_book_store_gettingstarted() {
    add_menu_page(
        esc_html__( 'VW Book Store', 'vw-book-store' ), // Page title
        esc_html__( 'VW Book Store', 'vw-book-store' ), // Menu title
        'manage_options',                            // Capability
        'vw_book_store_guide',                        // Menu slug
        'vw_book_store_mostrar_guide',                // Callback
        get_template_directory_uri() . '/inc/getstart/images/menu-icon.svg', // Image icon
        59                                           // Position
    );
}
add_action( 'admin_menu', 'vw_book_store_gettingstarted' );

// Add a Custom CSS file to WP Admin Area
function vw_book_store_admin_theme_style() {
   wp_enqueue_style('vw-book-store-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/getstart/getstart.css');
   wp_enqueue_script('vw-book-store-tabs', esc_url(get_template_directory_uri()) . '/inc/getstart/js/tab.js');

   // Admin notice code START
	wp_register_script('vw-book-store-notice', esc_url(get_template_directory_uri()) . '/inc/getstart/js/notice.js', array('jquery'), time(), true);
	wp_enqueue_script('vw-book-store-notice');
	// Admin notice code END
}
add_action('admin_enqueue_scripts', 'vw_book_store_admin_theme_style');

//guidline for about theme
function vw_book_store_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$vw_book_store_theme = wp_get_theme( 'vw-book-store' );
?>

<div class="wrapper-info">
	<div class="tab-sec">
    	
    	<div class="tab">
    		<button class="tablinks" onclick="vw_book_store_open_tab(event, 'theme_offer')"><?php esc_html_e( 'Demo Import', 'vw-book-store' ); ?></button>
			<button class="tablinks" onclick="vw_book_store_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Setup With Customizer', 'vw-book-store' ); ?></button>
			<button class="tablinks" onclick="vw_book_store_open_tab(event, 'theme_pro')"><?php esc_html_e( 'Get Premium', 'vw-book-store' ); ?></button>
  			<button class="tablinks" onclick="vw_book_store_open_tab(event, 'free_pro')"><?php esc_html_e( 'Free VS Premium', 'vw-book-store' ); ?></button>
  			<button class="tablinks" onclick="vw_book_store_open_tab(event, 'get_bundle')"><?php esc_html_e( 'WP Theme Bundle', 'vw-book-store' ); ?></button>
		</div>

		<?php 
			$vw_book_store_plugin_custom_css = '';
			if(class_exists('Ibtana_Visual_Editor_Menu_Class')){
				$vw_book_store_plugin_custom_css ='display: block';
			}
		?>

		<div id="theme_offer" class="tabcontent open">
			<div class="demo-content">
				<div class="demo-text">
					<?php 
					/* Get Started. */ 
					require get_parent_theme_file_path( '/inc/getstart/demo-content.php' );
				 	?>
				</div>
				
			 	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/responsive.png" alt="" class="resp-img" />
			</div> 	
		</div>
		<div id="lite_theme" class="tabcontent">
			<div class="lite-theme-tab" style="<?php echo esc_attr($vw_book_store_plugin_custom_css); ?>">
				<h3><?php esc_html_e( 'Vw Book Store', 'vw-book-store' ); ?></h3>
				<hr class="h3hr">
				<p><?php esc_html_e(' VW Book store is a feature-rich, flexible, robust and reliable WordPress theme for book stores, eBook sites, writers, magazines, journalists, editors, authors, publishers, modern online library and online book sellers. The theme can very well serve libraries, Book Reviewer, Editing Service, Publishing Service, author, Book Agent, Literary Clubs, fan fiction, Digital and Media online stores, reading clubs, online movie, Book Collector, Literary Agency, Book Review Platform, book landing, Booklover, public library, digital library, childrens story books, book series, copywriter, book-storage, bookshop, book blog or podcast, used books, book editor, selling books on ecommerce platform, Text Books Online, book-keeping business, litreture, bookstall, news stand, bookseller, amazon kindle, pubsliher, community center, reading room website, Teachers, institutes, Story telling, Fact Checker, Screenwriter, Writing Tutor, elearning, journal, publisher, story, caters education, author, selling ebooks, PDFs online, course providers, online courses music and game selling sites. Built on Bootstrap framework, it is extremely easy to use. It is readily responsive, LMS, cross-browser compatible, Editor Style, Flexible Header, Footer Widgets, widget ready, RTL Language Support and translation ready. Its user-friendly interface of both frontend and backend will give a great experience to both your customers and you. It has multiple options to change the layout of the website. Banners and sliders are provided to further enhance its look. With a great scope of customization, you can change its colour, background, images and several other elements. The VW Bookstore theme is sure to give you good SEO results. It is lightweight leading to speedy loading. With social media icons, your content, posts and website can be shared on various networking sites. These icons can also be used to let users follow you there. This book store theme can handle large traffic without hampering its functionality. It is purposefully made clean and secure resulting in a bug-free site. Use this theme to establish an online book hub for reading and literature lovers.','vw-book-store'); ?></p>
				<div class="lite-info">
					<div class="col-left-inner">
				  		<h4><?php esc_html_e( 'Theme Documentation', 'vw-book-store' ); ?></h4>
						<p><?php esc_html_e( 'If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'vw-book-store' ); ?></p>
						<div class="info-link">
							<a href="<?php echo esc_url(VW_BOOK_STORE_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'vw-book-store' ); ?></a>
						</div>
						<hr>
						<h4><?php esc_html_e('Theme Customizer', 'vw-book-store'); ?></h4>
						<p> <?php esc_html_e('To begin customizing your website, start by clicking "Customize".', 'vw-book-store'); ?></p>
						<div class="info-link">
							<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'vw-book-store'); ?></a>
						</div>
						<hr>
						<h4><?php esc_html_e('Having Trouble, Need Support?', 'vw-book-store'); ?></h4>
						<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'vw-book-store'); ?></p>
						<div class="info-link">
							<a href="<?php echo esc_url(VW_BOOK_STORE_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'vw-book-store'); ?></a>
						</div>
						<hr>
						<h4><?php esc_html_e('Reviews & Testimonials', 'vw-book-store'); ?></h4>
						<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'vw-book-store'); ?></p>
						<div class="info-link">
							<a href="<?php echo esc_url(VW_BOOK_STORE_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'vw-book-store'); ?></a>
						</div>

						<div class="link-customizer">
							<h4><?php esc_html_e( 'Link to customizer', 'vw-book-store' ); ?></h4>
							<div class="first-row">
								<div class="row-box">
									<div class="row-box1">
										<span class="dashicons dashicons-buddicons-buddypress-logo"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[control]=custom_logo') ); ?>" target="_blank"><?php esc_html_e('Upload your logo','vw-book-store'); ?></a>
									</div>
									<div class="row-box2">
										<span class="dashicons dashicons-category"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_book_store_top_bar') ); ?>" target="_blank"><?php esc_html_e('Header','vw-book-store'); ?></a>
									</div>
								</div>

								<div class="row-box">
									<div class="row-box1">
										<span class="dashicons dashicons-slides"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_book_store_slider_section') ); ?>" target="_blank"><?php esc_html_e('Slider Settings','vw-book-store'); ?></a>
									</div>
									<div class="row-box2">
										<span class="dashicons dashicons-category"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_book_store_top_charts_section') ); ?>" target="_blank"><?php esc_html_e('Top Charts Section','vw-book-store'); ?></a>
									</div>
								</div>
							
								<div class="row-box">
									<div class="row-box1">
										<span class="dashicons dashicons-category"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_book_store_right_sidebar_section') ); ?>" target="_blank"><?php esc_html_e('Right Sidebar Section','vw-book-store'); ?></a>
									</div>
									<div class="row-box2">
										<span class="dashicons dashicons-menu"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=nav_menus') ); ?>" target="_blank"><?php esc_html_e('Menus','vw-book-store'); ?></a>
									</div>
								</div>
								
								<div class="row-box">
									<div class="row-box1">
										<span class="dashicons dashicons-admin-generic"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_book_store_left_right') ); ?>" target="_blank"><?php esc_html_e('General Settings','vw-book-store'); ?></a>
									</div>
									<div class="row-box2">
										<span class="dashicons dashicons-format-gallery"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_book_store_post_settings') ); ?>" target="_blank"><?php esc_html_e('Post settings','vw-book-store'); ?></a>
									</div>
								</div>

								<div class="row-box">
									<div class="row-box1">
										<span class="dashicons dashicons-screenoptions"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[panel]=widgets') ); ?>" target="_blank"><?php esc_html_e('Footer Widget','vw-book-store'); ?></a>
									</div>
									<div class="row-box2">
										<span class="dashicons dashicons-text-page"></span><a href="<?php echo esc_url( admin_url('customize.php?autofocus[section]=vw_book_store_footer') ); ?>" target="_blank"><?php esc_html_e('Footer Text','vw-book-store'); ?></a>
									</div>
								</div>
							</div>
						</div>
				  	</div>
					<div class="col-right-inner">
						<h4 class="page-template"><?php esc_html_e('How to set up Home Page Template','vw-book-store'); ?></h4>
						<p><?php esc_html_e('Follow these instructions to setup Home page.','vw-book-store'); ?></p>
	                  	<p><span class="strong"><?php esc_html_e('1. Create a new page :','vw-book-store'); ?></span><?php esc_html_e(' Go to ','vw-book-store'); ?>
						  	<b><?php esc_html_e(' Dashboard >> Pages >> Add New Page','vw-book-store'); ?></b></p>
	                  	<p><?php esc_html_e('Name it as "Home" then select the template "Custom Home Page".','vw-book-store'); ?></p>
	                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/home-page-template.png" alt="" />
	                  	<p><span class="strong"><?php esc_html_e('2. Set the front page:','vw-book-store'); ?></span><?php esc_html_e(' Go to ','vw-book-store'); ?>
						  	<b><?php esc_html_e(' Settings >> Reading ','vw-book-store'); ?></b></p>
					  	<p><?php esc_html_e('Select the option of Static Page, now select the page you created to be the homepage, while another page to be your default page.','vw-book-store'); ?></p>
	                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/set-front-page.png" alt="" />
	                  	<p><?php esc_html_e(' Once you are done with setup, then follow the','vw-book-store'); ?> <a class="doc-links" href="<?php echo esc_url(VW_BOOK_STORE_FREE_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation','vw-book-store'); ?></a></p>
				  	</div>

				</div>
			  	
			</div>
		</div>

		<div id="theme_pro" class="tabcontent">		  	
			<div class="pro-info">
				<div class="col-left-pro">
					<h3><?php esc_html_e( 'Premium Theme Information', 'vw-book-store' ); ?></h3>
					<hr class="h3hr">
			    	<p><?php esc_html_e('This bookstore WordPress theme is clean, reliable, modern and feature-full with great use for book stores, eBook portals, online book sellers, authors, journalists, writers, editors, publishers, libraries, reading clubs, online music, movies and game selling website and all the literature lovers. It is a one-stop-solution for establishing a performance efficient website for all books and reading related businesses. It has all the facility to list your books whether you deal with kids sound and story books or literature books for adults. It has sections cascaded to form a continuity to never leave the visitors idle. This bookstore WordPress theme has a fluid layout making it fully responsive. It is cross-browser compatible and translation ready. It is coded from scratch to make it bug-free. It is fearlessly compatible with third party plugins to give an extra edge to your website with the added plugin.','vw-book-store'); ?></p>
			    	<div class="pro-links">
				    	<a href="<?php echo esc_url(VW_BOOK_STORE_LIVE_DEMO ); ?>" target="_blank" class="demo-btn"><?php esc_html_e('Live Demo', 'vw-book-store'); ?></a>
						<a href="<?php echo esc_url(VW_BOOK_STORE_BUY_NOW ); ?>" target="_blank" class="prem-btn"><?php esc_html_e('Buy Premium', 'vw-book-store'); ?></a>
						<a href="<?php echo esc_url(VW_BOOK_STORE_PRO_DOC ); ?>" target="_blank" class="doc-btn"><?php esc_html_e('Documentation', 'vw-book-store'); ?></a>
					</div>
			    </div>
			    <div class="col-right-pro scroll-image-wrapper">
			    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/pro-theme.jpg" alt="" class="pro-img" />		    	
			    </div>
			</div>		    
		</div>

		<div id="free_pro" class="tabcontent">
		  	<div class="featurebox">
			    <h3><?php esc_html_e( 'Theme Features', 'vw-book-store' ); ?></h3>
				<hr class="h3hr">
				<div class="table-image">
					<table class="tablebox">
						<thead>
							<tr>
								<th> <?php esc_html_e('Features', 'vw-book-store'); ?></th>
								<th><?php esc_html_e('Free Themes', 'vw-book-store'); ?></th>
								<th><?php esc_html_e('Premium Themes', 'vw-book-store'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php esc_html_e('Theme Customization', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Responsive Design', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Logo Upload', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Social Media Links', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Banner Settings', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Template Pages', 'vw-book-store'); ?></td>
								<td class="table-img"><?php esc_html_e('3', 'vw-book-store'); ?></td>
								<td class="table-img"><?php esc_html_e('10', 'vw-book-store'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Home Page Template', 'vw-book-store'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'vw-book-store'); ?></td>
								<td class="table-img"><?php esc_html_e('1', 'vw-book-store'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Theme sections', 'vw-book-store'); ?></td>
								<td class="table-img"><?php esc_html_e('2', 'vw-book-store'); ?></td>
								<td class="table-img"><?php esc_html_e('13', 'vw-book-store'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Contact us Page Template / Support Templates', 'vw-book-store'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('1', 'vw-book-store'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Blog Templates & Layout', 'vw-book-store'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'vw-book-store'); ?></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Page Templates & Layout', 'vw-book-store'); ?></td>
								<td class="table-img">0</td>
								<td class="table-img"><?php esc_html_e('3(Left/Right Sidebar)', 'vw-book-store'); ?></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Color Pallete For Particular Sections', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Global Color Option', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Reordering', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Demo Importer', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Allow To Set Site Title, Tagline, Logo', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Enable Disable Options On All Sections, Logo', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Full Documentation', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Latest WordPress Compatibility', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Support 3rd Party Plugins', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Secure and Optimized Code', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Exclusive Functionalities', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Section Enable / Disable', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Section Google Font Choices', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Video Gallery', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Simple & Mega Menu Option', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support to add custom CSS / JS ', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Shortcodes', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Premium Membership', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Budget Friendly Value', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('Priority Error Fixing', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Custom Feature Addition', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr class="odd">
								<td><?php esc_html_e('All Access Theme Pass', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Seamless Customer Support', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Vw Book Store ', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Detail Services', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('About Business Page', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Team Member Page', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Project Description Page', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td><?php esc_html_e('Support Page', 'vw-book-store'); ?></td>
								<td class="table-img"><span class="dashicons dashicons-no"></span></td>
								<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
							</tr>
							<tr>
								<td></td>
								<td class="table-img"></td>
								<td class="update-link"><a href="<?php echo esc_url(VW_BOOK_STORE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'vw-book-store'); ?></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div id="get_bundle" class="tabcontent">	
			<div class="bundle-info">
				<div class="col-left-pro">
			   		<h3><?php esc_html_e( 'WP Theme Bundle', 'vw-book-store' ); ?></h3>
			   		<hr class="h3hr">
			    	<p><?php esc_html_e('Enhance your website effortlessly with our WP Theme Bundle. Get access to 400+ premium WordPress themes and 5+ powerful plugins, all designed to meet diverse business needs. Enjoy seamless integration with any plugins, ultimate customization flexibility, and regular updates to keep your site current and secure. Plus, benefit from our dedicated customer support, ensuring a smooth and professional web experience.','vw-book-store'); ?></p>
			    	<div class="feature">
			    		<h4><?php esc_html_e( 'Features:', 'vw-book-store' ); ?></h4>
			    		<p><img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/tick.png" alt="" /><?php esc_html_e('400+ Premium Themes & 5+ Plugins.', 'vw-book-store'); ?></p>
			    		<p><img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/tick.png" alt="" /><?php esc_html_e('Seamless Integration.', 'vw-book-store'); ?></p>
			    		<p><img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/tick.png" alt="" /><?php esc_html_e('Customization Flexibility.', 'vw-book-store'); ?></p>
			    		<p><img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/tick.png" alt="" /><?php esc_html_e('Regular Updates.', 'vw-book-store'); ?></p>
			    		<p><img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/tick.png" alt="" /><?php esc_html_e('Dedicated Support.', 'vw-book-store'); ?></p>
			    	</div>
			    	<p><?php esc_html_e('Upgrade now and give your website the professional edge it deserves, all at an unbeatable price of $99!', 'vw-book-store'); ?></p>
			    	<div class="pro-links">
						<a href="<?php echo esc_url(VW_BOOK_STORE_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank" class="bundle-buy"><?php esc_html_e('Get Bundle', 'vw-book-store'); ?></a>
						<a href="<?php echo esc_url(VW_BOOK_STORE_THEME_BUNDLE_DOC ); ?>" target="_blank" class="bundle-doc"><?php esc_html_e('Documentation', 'vw-book-store'); ?></a>
					</div>
			   	</div>
			   	<div class="col-right-pro scroll-image-wrapper">
			    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/bundle.jpg" alt="" />
			   	</div>
			</div>	  	
		   			    
		</div>
	</div>
	<div class="coupen-code-section">
		<div class="sshot-section">
			<div class="sshot-inner">
				<h2><?php esc_html_e( 'Welcome To Vw Book Store,', 'vw-book-store' ); ?> </span></h2>
				<div class="on-pro">
					<span class="version"><?php esc_html_e( 'Version', 'vw-book-store' ); ?>: <?php echo esc_html($vw_book_store_theme['Version']);?></span>
					<span class="coupon-code"><?php esc_html_e('Get 20% Of On Pro Theme-Use Code: ','vw-book-store'); ?><span class="code-highlight"><?php esc_html_e('VWPRO20','vw-book-store'); ?></span>
				</div>
		    	<p><?php esc_html_e('All Our Wordpress Themes Are Modern, Minimalist, 100% Responsive, Seo-Friendly,Feature-Rich, And Multipurpose That Best Suit Designers, Bloggers And Other Professionals Who Are Working In The Creative Fields.','vw-book-store'); ?></p>
		    	<div class="btn-section">
			    	<div class="proo-links">
				    	<a href="<?php echo esc_url(VW_BOOK_STORE_LIVE_DEMO ); ?>" target="_blank" class="demo-btn"><?php esc_html_e('Live Demo', 'vw-book-store'); ?></a>
						<a href="<?php echo esc_url(VW_BOOK_STORE_BUY_NOW ); ?>" target="_blank" class="prem-btn"><?php esc_html_e('Buy Premium', 'vw-book-store'); ?></a>
						<a href="<?php echo esc_url(VW_BOOK_STORE_PRO_DOC ); ?>" target="_blank" class="doc-btn"><?php esc_html_e('Documentation', 'vw-book-store'); ?></a>
						
					</div>
			    	
			    </div>
			</div>
	    	<div class="bundle-banner">
	    		<div class="bundle-img">
	    			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/bundle-notice.png" alt="" />
	    		</div>
	    		<div class="bundle-text">
		  			<h2><?php esc_html_e('WP THEME BUNDLE','vw-book-store'); ?></h2>
					<h4><?php esc_html_e('Get Access to 400+ Premium WordPress Themes At Just $99','vw-book-store'); ?></h4>
					<div class="bundle-button">
			  			<a href="<?php echo esc_url( 'https://www.vwthemes.com/discount/FREEBREF?redirect=/products/wp-theme-bundle'); ?>" target="_blank"><?php esc_html_e('Get 10% OFF On Bundle', 'vw-book-store'); ?></a>
			  		</div>
		  		</div>
		  		
	    	</div>
	    </div>
	    <div class="coupen-section">
	    	<div class="logo-section">
			  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" alt="" />
		  	</div>
		  	<div class="logo-right">	
		  		<div class="logo-text">
		  			<h2><?php esc_html_e('GET PRO','vw-book-store'); ?></h2>
					<h4><?php esc_html_e('20% Off','vw-book-store'); ?></h4>
		  		</div>						
			</div>
	    </div>
	</div>
      
</div>
<?php } ?>