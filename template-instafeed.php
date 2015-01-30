<?php
/*
 Template Name: Instafeed
 *
 * This template is used to include the instafeed javascript

 */

get_header();
?>
       
    <!-- #content Starts -->
	<?php woo_content_before(); ?>
    <div id="content" class="col-full">
    
    	<div id="main-sidebar-container">    

            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <section id="main">                       
<?php
	woo_loop_before();
	
	if (have_posts()) { $count = 0;
		while (have_posts()) { the_post(); $count++;
			
			woo_get_template_part( 'content', get_post_type() ); // Get the post content template file, contextually.
		}
	}
	
	woo_loop_after();
?>   

<script type="text/javascript">
    var feed = new Instafeed({
        get: 'tagged',
        tagName: 'practiceperfect',
        sortBy: 'most-liked',
        clientId: 'd682f7c5c8e0478f9a0695d815c07b9e',
        template: '{{model}}'

    feed.run();
</script>

            </section><!-- /#main -->
            <?php woo_main_after(); ?>
    
            <?php get_sidebar(); ?>

		</div><!-- /#main-sidebar-container -->         

		<?php get_sidebar('alt'); ?>

    </div><!-- /#content -->
	<?php woo_content_after(); ?>

<?php get_footer(); ?>