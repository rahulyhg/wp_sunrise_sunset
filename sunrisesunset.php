<?php
/*
Plugin Name: Sunrise Sunset
Plugin URI: http://wordpress.org/extend/plugins/sunrise-sunset/
Description: Displays Sunrise and Sunset Times
Version:  1.1.5
Author: Rex Posadas (rexposadas@yahoo.com)
Author URI: http://www.rxnfx.com/ss-plugin
*/

/*  Copyright 2011  Rex Posadas  (email : rexposadas@yahoo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


require_once "city.php";
require_once "utils.php";

add_action("widgets_init", "register_sunrise_sunset");
function register_sunrise_sunset()
{
    register_widget('sunrise_sunset');
}

class sunrise_sunset extends WP_Widget
{
    private $_cities;

    function sunrise_sunset()
    {
        $widget_ops = array('classname' => 'sunrise_sunset_widget'
        , 'description' => 'Displays Sunrise and Sunset Times');

        $this->WP_Widget('ss_widget_bio', 'Sunrise Sunset', $widget_ops);

        $this->_cities = SSUtils::getCities();
    }

    function form($instance)
    {
        $defaults = array(
            'title' => 'Sunrise Sunset Times',
            'ss-plugin');

        $instance = wp_parse_args((array)$instance, $defaults);
        $title = strip_tags($instance['title']);
        $showsunset = strip_tags($instance['showsunset']);
        $showsunrise = strip_tags($instance['showsunrise']);
        $friday = strip_tags($instance['showfriday']);

        ?>
    <p><?php echo 'Title' ?>:
        <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>"
               type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>

    <p><?php echo 'Cities'; ?>:

        <?php

        $select_box = sprintf('<select name="%s">', $this->get_field_name('city'));

        foreach ($this->_cities as $city) {
            if ($instance['city'] == $city->getName()) {
                $select_box .= sprintf('<option value="%s" selected="yes">%s</option>', $city->getName(), $city->getName());
            } else {
                $select_box .= sprintf('<option value="%s">%s</option>', $city->getName(), $city->getName());
            }
        }

        $select_box .= '</select>';
        echo $select_box;

        $field_sunset = $this->get_field_name('showsunset');
        $field_sunrise = $this->get_field_name('showsunrise');
        $field_friday = $this->get_field_name('showfriday');

        $sunset_checkbox;
        $sunrise_checkbox;
        $friday_checkbox;

        if ($instance['showsunset']) {
            $sunset_checkbox = sprintf('<input type="checkbox" name="%s" value="%s" checked/> Display Sunset Time', $field_sunset, $field_sunset);
        } else {
            $sunset_checkbox = sprintf('<input type="checkbox" name="%s" value="%s"/> Display Sunset Time', $field_sunset, $field_sunset);
        }

        if ($instance['showsunrise']) {
            $sunrise_checkbox = sprintf('<input type="checkbox" name="%s" value="%s" checked/> Display Sunrise Time', $field_sunrise, $field_sunrise);
        } else {
            $sunrise_checkbox = sprintf('<input type="checkbox" name="%s" value="%s"/> Display Sunrise Time', $field_sunrise, $field_sunrise);
        }

        if ($instance['showfriday']) {
            $friday_checkbox = sprintf('<input type="checkbox" name="%s" value="%s" checked/> Display only Friday', $field_friday, $field_friday);
        } else {
            $friday_checkbox = sprintf('<input type="checkbox" name="%s" value="%s"/> Display only Friday', $field_friday, $field_friday);
        }


        echo "<br/>" . $sunrise_checkbox;
        echo "<br/>" . $sunset_checkbox;
        echo "<br/>" . $friday_checkbox;

        ?>
    <p>
        <br/>
    </p>
    <?php

    }

    // save our widget
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['city'] = strip_tags($new_instance['city']);
        $instance['showsunset'] = strip_tags($new_instance['showsunset']);
        $instance['showsunrise'] = strip_tags($new_instance['showsunrise']);
        $instance['showfriday'] = strip_tags($new_instance['showfriday']);
        return $instance;
    }

    /**
     * The Front end of our widget.
     * @param $args
     * @param $instance
     */
    function widget($args, $instance)
    {
        extract($args);

        $today = date("D M j Y");

        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }

        $showOnlyFriday = $instance['showfriday']? true: false;


        $result = SSUtils::getTimes($instance, $this->_cities, $showOnlyFriday);

        echo $today . "<br/>";
        if ($instance["showsunrise"]) {
            echo "Sunrise:" . $result['sunrise'] . "<br/>";
        }

        if ($instance["showsunset"]) {
            echo "Sunset:" . $result['sunset'];
        }

        echo $after_widget;
    }
}


?>
