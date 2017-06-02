<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'baw-post-views-count/bawpv.php' ) ) {
    class DevVN_BAW_Widget_Most_Viewed_Posts extends WP_Widget
    {

        function __construct()
        {
            $widget_ops = array('classname' => 'devvn_widget_most_viewed_entries', 'description' => __('The most viewed posts on your site', 'devvn'));
            parent::__construct('devvn_widget_most_viewed_entries', __('[DevVN] Most Viewed Posts With Thumbnail', 'devvn'), $widget_ops);
            $this->alt_option_name = 'devvn_widget_most_viewed_entries';

            add_action('save_post', array(&$this, 'flush_widget_cache'));
            add_action('deleted_post', array(&$this, 'flush_widget_cache'));
            add_action('switch_theme', array(&$this, 'flush_widget_cache'));
        }

        function widget($args, $instance)
        {
            $cache = wp_cache_get('devvn_widget_most_viewed_entries', 'widget');
            if (!is_array($cache))
                $cache = array();

            if (!isset($args['widget_id']))
                $args['widget_id'] = $this->id;

            if (isset($cache[$args['widget_id']])) {
                echo $cache[$args['widget_id']];
                return;
            }

            ob_start();
            extract($args);

            $title = apply_filters('widget_title', empty($instance['title']) ? __('Most Viewed Posts') : $instance['title'], $instance, $this->id_base);
            if (empty($instance['number']) || !$number = absint($instance['number']))
                $number = 10;
            $timings = bawpcv_get_timings();
            $date = $instance['date'] != '' ? $instance['date'] : date($timings[$instance['time']]);
            $date = $instance['time'] == 'all' ? '' : '-' . $date;
            $time = $instance['time'];
            $post_type = isset($instance['post_type']) ? $instance['post_type'] : 'post';
            //$exclude_cat = ($instance['exclude_cat']) ? $instance['exclude_cat'] : array();
            $order = $instance['order'] == 'ASC' ? 'ASC' : 'DESC';
            $author_id = $instance['author'];
            $meta_key = apply_filters('baw_count_views_meta_key', '_count-views_' . $time . $date, $time, $date);
            $bawpvc_options = bawpvc_get_options();
            $r = new WP_Query(array('posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'meta_key' => $meta_key, 'meta_value_num' => '0',
                    'meta_compare' => '>',
                    'orderby' => 'meta_value_num',
                    'order' => $order,
                    'author' => $author_id,
                    //'category__not_in' => $exclude_cat,
                    'post_type' => $post_type
                )
            );
            if ($r->have_posts()) :
                ?>
                <style>
                    .devvn_widget_most_viewed_entries ul {
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }
                    .devvn_widget_most_viewed_entries ul li {
                        overflow: hidden;
                        margin: 0 0 10px 0;
                    }
                    .devvn_widget_most_viewed_entries ul li img {
                        width: 90px;
                        height: auto;
                        float: left;
                        margin: 0 10px 0 0;
                    }
                    .devvn_widget_most_viewed_entries ul li strong {
                        margin: 0 0 10px;
                        display: block;
                    }
                </style>
                <?php echo $before_widget; ?>
                <?php if ($title) echo $before_title . $title . $after_title; ?>
                <ul>
                    <?php while ($r->have_posts()) : $r->the_post(); ?>
                        <?php
                        $count = '';
                        if ($instance['show']):
                            $count = (int)get_post_meta(get_the_ID(), $meta_key, true);
                            do_action('baw_count_views_count_action', $count, $meta_key, $time, $date, get_the_ID());
                            $count = apply_filters('baw_count_views_count', $count, $meta_key, $time, $date);
                        endif;
                        ?>
                        <li><a href="<?php the_permalink() ?>"
                               title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
                                <?php the_post_thumbnail('thumbnail'); ?>
                                <strong><?php if (get_the_title()) the_title(); else the_ID(); ?></strong>
                                <div class="news_infor">
                                    <span><i class="fa fa-calendar"></i> <?php echo get_the_date('d/m/Y')?></span>
                                    <span><i class="fa fa-comment"></i> <?php comments_number( '0 comment', '1 comment', '% comments' )?></span>
                                </div>
                            </a></li>
                    <?php endwhile; ?>
                </ul>
                <?php echo $after_widget; ?>
                <?php
                // Reset the global $the_post as this query will have stomped on it
                wp_reset_postdata();

            endif;

            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set('devvn_widget_most_viewed_entries', $cache, 'widget');
        }

        function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            //$instance['exclude_cat'] = $new_instance['exclude_cat'];
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['author'] = $new_instance['author'];
            $instance['time'] = $new_instance['time'];
            $instance['post_type'] = $new_instance['post_type'];
            $instance['date'] = $new_instance['date'];
            $instance['number'] = (int)$new_instance['number'];
            $instance['show'] = (bool)$new_instance['show'];
            $instance['order'] = $new_instance['order'] == 'ASC' ? 'ASC' : 'DESC';

            $this->flush_widget_cache();

            $alloptions = wp_cache_get('alloptions', 'options');
            if (isset($alloptions['devvn_widget_most_viewed_entries']))
                delete_option('devvn_widget_most_viewed_entries');

            return $instance;
        }

        function flush_widget_cache()
        {
            wp_cache_delete('devvn_widget_most_viewed_entries', 'widget');
        }

        function form($instance)
        {
            //$exclude_cat = isset($instance['exclude_cat']) ? $instance['exclude_cat'] : '';
            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            $number = isset($instance['number']) ? absint($instance['number']) : 5;
            $time = isset($instance['time']) ? ($instance['time']) : 'all';
            $post_type = isset($instance['post_type']) ? ($instance['post_type']) : 'post';
            $author_id = isset($instance['author']) ? ($instance['author']) : '';
            $date = isset($instance['date']) ? ($instance['date']) : '';
            $show = isset($instance['show']) ? $instance['show'] == 'on' : true;
            if (isset($instance['order']))
                $order = $instance['order'] == 'ASC' ? 'ASC' : 'DESC';
            else
                $order = 'DESC';
            ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'devvn'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('How many posts:', 'devvn'); ?></label>
                <input id="<?php echo $this->get_field_id('number'); ?>"
                       name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>"
                       size="3"/></p>

            <p>
                <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post type:', 'devvn'); ?></label>
                <select id="<?php echo $this->get_field_id('post_type'); ?>"
                        name="<?php echo $this->get_field_name('post_type'); ?>">
                    <?php
                    $all_post_type = bawpvc_get_options();
                    $all_post_type = $all_post_type['post_types'];
                    foreach ($all_post_type as $post_type_slug) { ?>
                        <option value="<?php echo esc_attr($post_type_slug); ?>" <?php selected($post_type, $post_type_slug); ?>><?php echo ucwords(esc_html($post_type_slug)); ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('time'); ?>"><?php _e('Which top do you want:', 'devvn'); ?></label>
                <select id="<?php echo $this->get_field_id('time'); ?>"
                        name="<?php echo $this->get_field_name('time'); ?>">
                    <?php
                    $timings = bawpcv_get_timings();
                    foreach ($timings as $timing => $dummy) { ?>
                        <option value="<?php echo esc_attr($timing); ?>" <?php selected($timing, $time); ?>><?php echo ucwords(esc_html($timing)); ?></option>
                    <?php } ?>
                </select>

            <p>
                <label for="<?php echo $this->get_field_id('author'); ?>"><?php _e('Top for this author only:', 'devvn'); ?></label>
                <select id="<?php echo $this->get_field_id('author'); ?>"
                        name="<?php echo $this->get_field_name('author'); ?>">
                    <option value=""><?php _e('All authors', 'devvn'); ?></option>
                    <?php foreach (get_users() as $u) { ?>
                        <option value="<?php echo $u->ID; ?>" <?php selected($author_id, $u->ID); ?>><?php echo ucwords(esc_html($u->display_name)); ?></option>
                    <?php } ?>
                </select>
                <?php /* // todo
		<p><label for="<?php echo $this->get_field_id('author'); ?>"><?php _e( 'Exclude categories: (Multiple choise possible)', 'devvn' ); ?></label>
		<?php add_filter( 'wp_dropdown_cats', 'bawmrp_wp_dropdown_cats' ); ?>
		<?php wp_dropdown_categories( array( 'name'=>$this->get_field_name('exclude_cat').'[]' ) ); //// ?>
		<?php remove_filter( 'wp_dropdown_cats', 'bawmrp_wp_dropdown_cats' ); ?>
		<?php print_r( $exclude_cat ); ?>
		*/ ?>
            <p><label for="<?php echo $this->get_field_id('date'); ?>"><?php _e('Date format', 'devvn'); ?> <code>YYYYMMAA</code></label>
                <input id="<?php echo $this->get_field_id('date'); ?>"
                       name="<?php echo $this->get_field_name('date'); ?>" type="text"
                       value="<?php echo esc_attr($date); ?>" size="6" maxlength="8"/><br/>
                <code><?php _e('If you leave blank the actual time will be used.', 'devvn'); ?></code></p>

            <p>
                <label for="<?php echo $this->get_field_id('show'); ?>"><?php _e('Show posts count:', 'devvn'); ?></label>
                <input id="<?php echo $this->get_field_id('show'); ?>"
                       name="<?php echo $this->get_field_name('show'); ?>"
                       type="checkbox" <?php checked($show == true, true); ?> /></p>

            <p><label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'devvn'); ?></label>
                <select id="<?php echo $this->get_field_id('order'); ?>"
                        name="<?php echo $this->get_field_name('order'); ?>">
                    <option value="DESC" <?php selected($order, 'DESC'); ?>><?php _e('From most viewed to less viewed', 'devvn'); ?></option>
                    <option value="ASC" <?php selected($order, 'ASC'); ?>><?php _e('From less viewed to most viewed', 'devvn'); ?></option>
                </select>
            </p>

            <?php
        }
    }

    add_action('widgets_init', 'devvn_bawpvc_widgets_init');
    function devvn_bawpvc_widgets_init()
    {
        register_widget('DevVN_BAW_Widget_Most_Viewed_Posts');
    }
}