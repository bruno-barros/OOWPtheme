<?php
add_action('widgets_init', 'social_links_load_widgets');

function social_links_load_widgets()
{
	register_widget('Social_Links_Widget');
}

class Social_Links_Widget extends WP_Widget {
	
	function Social_Links_Widget()
	{
		$widget_ops = array('classname' => 'social_links', 'description' => '');

		$control_ops = array('id_base' => 'social_links-widget');

		$this->WP_Widget('social_links-widget', 'Links Sociais', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		?>
		<ul class="social">
			<?php if($instance['rss_link']): ?>
			<li>
				<a class="rss" href="<?php echo $instance['rss_link']; ?>">rss</a>
				<div class="popup">
					<div class="holder">
						<p>RSS</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['fb_link']): ?>
			<li>
				<a class="facebook" href="<?php echo $instance['fb_link']; ?>">facebook</a>
				<div class="popup">
					<div class="holder">
						<p>Facebook</p>
					</div>
				</div>				
			</li>
			<?php endif; ?>
			<?php if($instance['twitter_link']): ?>
			<li>
				<a class="twitter" href="<?php echo $instance['twitter_link']; ?>">twitter</a>
				<div class="popup">
					<div class="holder">
						<p>Twitter</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['dribbble_link']): ?>
			<li>
				<a class="dribble" href="<?php echo $instance['dribbble_link']; ?>">dribbble</a>
				<div class="popup">
					<div class="holder">
						<p>Dribbble</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['google_link']): ?>
			<li>
				<a class="google" href="<?php echo $instance['google_link']; ?>">google+</a>
				<div class="popup">
					<div class="holder">
						<p>Google +1</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['linkedin_link']): ?>
			<li>
				<a class="linkedin" href="<?php echo $instance['linkedin_link']; ?>">linkedin</a>
				<div class="popup">
					<div class="holder">
						<p>LinkedIn</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['blogger_link']): ?>
			<li>
				<a class="blogger" href="<?php echo $instance['blogger_link']; ?>">blogger</a>
				<div class="popup">
					<div class="holder">
						<p>Blogger</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['tumblr_link']): ?>
			<li>
				<a class="tumblr" href="<?php echo $instance['tumblr_link']; ?>">tumblr</a>
				<div class="popup">
					<div class="holder">
						<p>Tumblr</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['reddit_link']): ?>
			<li>
				<a class="reddit" href="<?php echo $instance['reddit_link']; ?>">reddit</a>
				<div class="popup">
					<div class="holder">
						<p>Reddit</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['yahoo_link']): ?>
			<li>
				<a class="yahoo" href="<?php echo $instance['yahoo_link']; ?>">yahoo</a>
				<div class="popup">
					<div class="holder">
						<p>Yahoo</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['deviantart_link']): ?>
			<li>
				<a class="deviantart" href="<?php echo $instance['deviantart_link']; ?>">deviantart</a>
				<div class="popup">
					<div class="holder">
						<p>DeviantArt</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['vimeo_link']): ?>
			<li>
				<a class="vimeo" href="<?php echo $instance['vimeo_link']; ?>">vimeo</a>
				<div class="popup">
					<div class="holder">
						<p>Vimeo</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['youtube_link']): ?>
			<li>
				<a class="custom" href="<?php echo $instance['youtube_link']; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/youtube.png" alt="" /></a>
				<div class="popup">
					<div class="holder">
						<p>Youtube</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
			<?php if($instance['pinterest_link']): ?>
			<li>
				<a class="custom" href="<?php echo $instance['pinterest_link']; ?>"><img src="<?php bloginfo('template_directory'); ?>/images/pinterest.png" alt="" /></a>
				<div class="popup">
					<div class="holder">
						<p>Pinterest</p>
					</div>
				</div>
			</li>
			<?php endif; ?>
		</ul>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['rss_link'] = $new_instance['rss_link'];
		$instance['fb_link'] = $new_instance['fb_link'];
		$instance['twitter_link'] = $new_instance['twitter_link'];
		$instance['dribbble_link'] = $new_instance['dribbble_link'];
		$instance['google_link'] = $new_instance['google_link'];
		$instance['linkedin_link'] = $new_instance['linkedin_link'];
		$instance['blogger_link'] = $new_instance['blogger_link'];
		$instance['tumblr_link'] = $new_instance['tumblr_link'];
		$instance['reddit_link'] = $new_instance['reddit_link'];
		$instance['yahoo_link'] = $new_instance['yahoo_link'];
		$instance['deviantart_link'] = $new_instance['deviantart_link'];
		$instance['vimeo_link'] = $new_instance['vimeo_link'];
		$instance['youtube_link'] = $new_instance['youtube_link'];
		$instance['pinterest_link'] = $new_instance['pinterest_link'];

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Get Social');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Título:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('rss_link'); ?>">RSS Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('rss_link'); ?>" name="<?php echo $this->get_field_name('rss_link'); ?>" value="<?php echo $instance['rss_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('fb_link'); ?>">Facebook Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('fb_link'); ?>" name="<?php echo $this->get_field_name('fb_link'); ?>" value="<?php echo $instance['fb_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('twitter_link'); ?>">Twitter Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('twitter_link'); ?>" name="<?php echo $this->get_field_name('twitter_link'); ?>" value="<?php echo $instance['twitter_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dribbble_link'); ?>">Dribbble Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('dribbble_link'); ?>" name="<?php echo $this->get_field_name('dribbble_link'); ?>" value="<?php echo $instance['dribbble_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('google_link'); ?>">Google+ Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('google_link'); ?>" name="<?php echo $this->get_field_name('google_link'); ?>" value="<?php echo $instance['google_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('linkedin_link'); ?>">LinkedIn Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('linkedin_link'); ?>" name="<?php echo $this->get_field_name('linkedin_link'); ?>" value="<?php echo $instance['linkedin_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('blogger_link'); ?>">Blogger Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('blogger_link'); ?>" name="<?php echo $this->get_field_name('blogger_link'); ?>" value="<?php echo $instance['blogger_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tumblr_link'); ?>">Tumblr Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('tumblr_link'); ?>" name="<?php echo $this->get_field_name('tumblr_link'); ?>" value="<?php echo $instance['tumblr_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('reddit_link'); ?>">Reddit Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('reddit_link'); ?>" name="<?php echo $this->get_field_name('reddit_link'); ?>" value="<?php echo $instance['reddit_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('yahoo_link'); ?>">Yahoo Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('yahoo_link'); ?>" name="<?php echo $this->get_field_name('yahoo_link'); ?>" value="<?php echo $instance['yahoo_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('deviantart_link'); ?>">Deviantart Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('deviantart_link'); ?>" name="<?php echo $this->get_field_name('deviantart_link'); ?>" value="<?php echo $instance['deviantart_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('vimeo_link'); ?>">Vimeo Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('vimeo_link'); ?>" name="<?php echo $this->get_field_name('vimeo_link'); ?>" value="<?php echo $instance['vimeo_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('youtube_link'); ?>">Youtube Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('youtube_link'); ?>" name="<?php echo $this->get_field_name('youtube_link'); ?>" value="<?php echo $instance['youtube_link']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('pinterest_link'); ?>">Pinterest Link:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('pinterest_link'); ?>" name="<?php echo $this->get_field_name('pinterest_link'); ?>" value="<?php echo $instance['pinterest_link']; ?>" />
		</p>
	<?php
	}
}
?>