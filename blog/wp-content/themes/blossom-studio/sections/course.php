<?php
/**
 * Course Level Section
 * 
 * @package Blossom_Studio
 */
if( is_active_sidebar( 'course' ) ){ ?>
<section id="course_section" class="course-level-section">
	<div class="container">
		<div class="section-grid">
    		<?php dynamic_sidebar( 'course' ); ?>
		</div>
	</div>
</section><!-- .course-section -->
<?php
}