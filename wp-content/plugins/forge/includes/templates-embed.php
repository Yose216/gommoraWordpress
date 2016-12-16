<?php


//Load all blocks and assign them to corresponding actions
add_action('wp_head', 'forge_templating_embed');
function forge_templating_embed(){
	//Make sure closures are available
	if(version_compare(PHP_VERSION, '5.3.0') >= 0){
		$args = array(
		'post_type' => 'forge_template',
		'posts_per_page' => -1,
		'meta_query' => array(array('key' => 'template_hook', 'value' => '', 'compare' => '!=')));
		$blocks = new WP_Query($args);
		
		if($blocks->posts){
			foreach($blocks->posts as $post){
				$post_id = $post->ID;
				$template_hook = get_post_meta($post->ID, 'template_hook', true);
				$template_display = get_post_meta($post->ID, 'template_display', true);
				$template_priority = get_post_meta($post->ID, 'template_priority', true);
				if($template_priority == ''){
					$template_priority = 10;
				}
				$template_priority = absint($template_priority);
					
				//Add block to desired hook using anonymous function
				if($template_hook != ''){
					if(forge_templating_display_filter($template_display)){
						$template_type = get_post_meta($post->ID, 'template_type', true);
						if($template_type == 'action'){
							//Display template on an action hook
							add_action($template_hook, function() use ($post_id){ 
								echo forge_templating_embed_render($post_id); 
							}, $template_priority);
						}elseif($template_type == 'append'){
							//Append template to filter
							add_filter($template_hook, function($data) use ($post_id){ 
								$data .= forge_templating_embed_render($post_id); 
								return $data;
							}, $template_priority);
						}elseif($template_type == 'prepend'){
							//Prepend template to filter
							add_filter($template_hook, function($data) use ($post_id){ 
								$data = forge_templating_embed_render($post_id).$data;
								return $data;
							}, $template_priority);
						}					
					}
				}
			}
		}
	}
}