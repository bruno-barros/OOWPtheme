<?php
add_action('widgets_init', 'flickr_footer_load_widgets');

function flickr_footer_load_widgets()
{
	register_widget('Flickr_Footer_Widget');
}

class Flickr_Footer_Widget extends WP_Widget {
	
	function Flickr_Footer_Widget()
	{
		$widget_ops = array('classname' => 'flickr_footer', 'description' => 'The most recent photos from flickr.');

		$control_ops = array('id_base' => 'flickr_footer-widget');

		$this->WP_Widget('flickr_footer-widget', 'Flickr (Footer)', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$screen_name = $instance['screen_name'];
		$number = $instance['number'];
		
		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		if($screen_name && $number) {
			$api_key = 'c9d2c2fda03a2ff487cb4769dc0781ea';
			
			@$person = wp_remote_get('http://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key='.$api_key.'&username='.urlencode($screen_name).'&format=json');
			@$person = trim($person['body'], 'jsonFlickrApi()');
			@$person = json_decode($person);
			
			if($person->user->id) {
				$photos_url = wp_remote_get('http://api.flickr.com/services/rest/?method=flickr.urls.getUserPhotos&api_key='.$api_key.'&user_id='.$person->user->id.'&format=json');
				$photos_url = trim($photos_url['body'], 'jsonFlickrApi()');
				$photos_url = json_decode($photos_url);
				
				$photos = wp_remote_get('http://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key='.$api_key.'&user_id='.$person->user->id.'&per_page='.$number.'&format=json');
				$photos = trim($photos['body'], 'jsonFlickrApi()');
				$photos = json_decode($photos);
				?>
				<ul class='img-list'>
					<?php foreach($photos->photos->photo as $photo): $photo = (array) $photo; ?>
					<li class='flickr-photo'>
						<a href='<?php echo $photos_url->user->url; ?><?php echo $photo['id']; ?>' target='_blank'>
							<img src='<?php $url = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . '_s' . ".jpg"; echo $url; ?>' alt='<?php echo $photo['title']; ?>' width="44" height="44" />
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php
			} else {
				echo '<p>Invalid flickr username.</p>';
			}
		}
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['screen_name'] = $new_instance['screen_name'];
		$instance['number'] = $new_instance['number'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Photos from Flickr', 'screen_name' => '', 'number' => 6);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Título:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('screen_name'); ?>">Nome do álbum:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('screen_name'); ?>" name="<?php echo $this->get_field_name('screen_name'); ?>" value="<?php echo $instance['screen_name']; ?>" />
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Número de fotos exibidas:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
		
	<?php
	}
}
?>