<?php

get_header();
?>
        <div id="content-wrap" class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
                <article id="posts" <?php post_class(); ?>>

<?php
        global $post;
?>
        <header class="entry-header">
        <h2 class="entry-title"><?php the_title(); ?></h2>
        <p><img src="http://ansp.br/?option=com_monitor&grafico=<?php echo get_post_meta($post->ID, 'zdp_graph_id', true); ?>&period=3600&view=grafico&format=png"></p>
        <p><img src="http://ansp.br/?option=com_monitor&grafico=<?php echo get_post_meta($post->ID, 'zdp_graph_id', true); ?>&period=86400&view=grafico&format=png"></p>	    
        <p><img src="http://ansp.br/?option=com_monitor&grafico=<?php echo get_post_meta($post->ID, 'zdp_graph_id', true); ?>&period=2592000&view=grafico&format=png"></p>
        <p><img src="http://ansp.br/?option=com_monitor&grafico=<?php echo get_post_meta($post->ID, 'zdp_graph_id', true); ?>&period=31536000&view=grafico&format=png"></p>       
        </header>
        </article>
        </main>
    </div>
    </div>

<?php
get_footer();
?>