<?php
/**
 * @package DisplayZabbix
 */

namespace Includes\Base;

use Includes\Base\BaseController;

class ZabbixGraph extends BaseController
{
    public $meta_box;

    public function __construct() {
        parent::__construct();
        $prefix = 'zdp_';

        $this->meta_box = array(
            'id' => 'zabbix-meta-box',
            'title' => 'Zabbix graph',
            'page' => 'graph',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => 'Group',
                    'desc' => 'Graph group',
                    'id' => $prefix . 'graph_group',
                    'type' => 'text',
                    'std' => ''
                ),
                array(
                    'name' => 'Graph id',
                    'desc' => 'Enter graph id',
                    'id' => $prefix . 'graph_id',
                    'type' => 'text',
                    'std' => ''
                ),
            )
        );        
    }

    public function register() {
        add_action('init', array($this, 'custom_post_type'));
        add_action('admin_menu', array($this, 'graph_add_box'));
        add_action('save_post_graph', array($this, 'graph_save_data'));
        add_filter('single_template', array($this, 'graph_template'));
        add_filter('archive_template', array($this, 'archive_graph_template'));
        add_action('pre_get_posts', array($this, 'change_query_order'));
    }

    function custom_post_type() {
        register_post_type('graph', ['public' => true, 'label' => 'Graphs', 'has_archive' => true]);
    }

    function graph_add_box() {
        add_meta_box($this->meta_box['id'], $this->meta_box['title'], array($this, 'graph_show_box'), $this->meta_box['page'], $this->meta_box['context'], $this->meta_box['priority']);
    }

    function graph_show_box() {
        global $post;

        // Use nonce for verification
        echo '<input type="hidden" name="graph_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
        echo '<table class="form-table">';

        foreach ($this->meta_box['fields'] as $field) {
            // get current post meta data
            $meta = get_post_meta($post->ID, $field['id'], true);

            echo '<tr>',
                    '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                    '<td>';
            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                    break;
                case 'textarea':
                    echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                    break;
                case 'select':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                    }
                    echo '</select>';
                    break;
                case 'radio':
                    foreach ($field['options'] as $option) {
                        echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                    }
                    break;
                case 'checkbox':
                    echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                    break;
            }
            echo     '</td><td>',
                '</td></tr>';
        }

        echo '</table>';
    }

    // Save data from meta box
    function graph_save_data($post_id) {

         // verify nonce
        if (!wp_verify_nonce($_POST['graph_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        foreach ($this->meta_box['fields'] as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];

            echo "metadata $new";

            if ($new && !$old) {
                add_post_meta($post_id, $field['id'], $new);
            }  elseif ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }

    }

    function graph_template($template) {
        global $post;

        if ($post->post_type == 'graph') {
            return "$this->plugin_path/templates/single-dz_graph.php";
        }
        return $template;
    }

    function archive_graph_template($template) {
        global $post;

        echo $post->post_type;
        if ($post->post_type == 'graph') {
            return "$this->plugin_path/templates/archive-dz_graph.php";
        }
        return $template;
    }

    function change_query_order($query) {
        if ($query->is_post_type_archive('graph')) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
        }
    }

}

