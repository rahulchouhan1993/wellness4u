<?php
/**
 *	Adds hidden content to admin_footer, then shows with jQuery, and inserts after welcome panel
 *
 *	@author Ren Ventura <EngageWP.com>
 *	@see http://www.engagewp.com/how-to-create-full-width-dashboard-widget-wordpress
 */
add_action( 'admin_footer', 'rv_custom_dashboard_widget' );
function rv_custom_dashboard_widget() {
	// Bail if not viewing the main dashboard page
	if ( get_current_screen()->base !== 'dashboard' ) {
		return;
	}
	?>

	<div id="fastest-dashboard" class="welcome-panel" style="display: none;">
		<div class="welcome-panel-content">
			<h2>Best Minimalist Theme</h2>
			<p class="about-description">Thank you for deciding to use the <strong>Best Minimalist</strong> Wordpress theme. Below are the recommended products to be used with <strong>Best Minimalist</strong>:
			</p>
			<div class="welcome-panel-column-container">
				<div class="welcome-panel-column">
					<h3>Speed</h3>
					<ul>
						<li>
							<a href="https://wpvkp.com/go/uwso-minimalist" target="_blank"><img style="display:none;" src="https://wpvkp.com/go/uwso-minimalist">Ultimate Wordpress Speed Optimizer</a>
						</li>
						<li><a target="_blank" href="https://wpvkp.com/go/minimalist-rocket">WP Rocket</a>
						</li>
					</ul>
				</div>
				<div class="welcome-panel-column">
					<h3>Hosting</h3>
					<ul>
						<li>
							<a href="https://wpvkp.com/go/minimalist-bluehost" target="_blank">BlueHost</a>
            </li>
						<li>
							<a target="_blank" href="https://wpvkp.com/go/siteground-fastest/">SiteGround</a>
						</li>
					</ul>
				</div>
				<div class="welcome-panel-column welcome-panel-last">
					<h3>Marketing</h3>
					<ul>
						<li>
							<a target="_blank" href="https://wpvkp.com/go/minimalist-semrush"><img src="https://wpvkp.com/go/minimalist-semrush" style="display:none;"><strong>SEMrush</strong> - Spy on Your Competitors</a>
						</li>
					</ul>
			</div>
		</div>
	</div>
</div>
	<script>
		jQuery(document).ready(function($) {
			$('#welcome-panel').before($('#fastest-dashboard').show());
		});
	</script>

<?php }
