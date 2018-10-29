<?php

/**
 * This example element comes with Layotter and can be disabled in settings
 */
class Layotter_Example_Element extends Layotter_Element
{
    protected function attributes() {
        $this->title = __('Example element', 'layotter');
        $this->description = __('Use this element to play around and get started with Layotter.', 'layotter');
        $this->icon = 'star';
        $this->field_group = Layotter_ACF::get_example_field_group_name();
    }

    protected function frontend_view($fields) {
        echo '<div class="layotter-example-element">';
        echo $fields['content'];
        echo '</div>';
    }

    protected function backend_view($fields) {
        echo '<div class="layotter-example-element">';

        if (empty($fields['content'])) {
            echo '<center>';
            _e('This element is empty. Click the edit button at the top right to add some content.', 'layotter');
            echo '</center>';
        } else {
            echo $fields['content'];
        }

        echo '</div>';
    }
}

Layotter::register_element('layotter_example_element', 'Layotter_Example_Element');