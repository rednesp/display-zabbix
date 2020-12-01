<?php

get_header();
?>
    <div id="content-wrap" class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
        <article id="posts" <?php post_class(); ?>>
        <header class="entry-header">
        <h2 class="entry-title">Gráficos de monitoramento dos links</h2>
        </header>
        <div class="entry-content">
        <?php
        $graphs = array();
        if (have_posts()):
            while(have_posts()): the_post();
                $post = get_post();
                $graph_group = get_post_meta($post->ID, 'zdp_graph_group', true);
                if (array_key_exists($graph_group, $graphs)) {
                    array_push($graphs[$graph_group], $post);
                }
                else {
                    $graphs[$graph_group] = array($post);
                }
            endwhile;
        endif;

        ksort($graphs);

        foreach($graphs as $group=>$posts){
            echo "<h3>".strstr($group, ' ')."</h3>";
            echo '<ul>';
            foreach($posts as $post) {
                ?>
                <li style="float:left; list-style:none;width:230px;min-height:180px;">
                <?php
                $graph_id = get_post_meta($post->ID, 'zdp_graph_id', true);
                echo '<p>'.the_title().'</p>';
                ?>
                <p><a href="<?php echo get_post_permalink(); ?>"><img src="http://ansp.br/?mini=1&option=com_monitor&grafico=<?php echo $graph_id; ?>&period=3600&view=grafico&format=png"></a></p>
                </li>
                <?php
            }
            echo '</ul><div style="clear:both;"></div>';
        }
        ?>

        </div>
        </article>
        </main>
    </div>
    </div>

<?php
get_footer();
?>