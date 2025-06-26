<?php
class PC_Component_Widget extends \Elementor\Widget_Base {

    public function get_name() { return 'pc_component_widget'; }
    public function get_title() { return 'PC Component Display'; }
    public function get_icon() { return 'eicon-posts-grid'; }
    public function get_categories() { return ['general']; }

    protected function _register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'Content',
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('component_title', [
            'label' => 'Component Title',
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Sample Component',
        ]);

        $this->add_control('component_price', [
            'label' => 'Price ($)',
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 100,
        ]);

        $this->add_control('component_stock', [
            'label' => 'Stock Availability',
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'in_stock' => '✅ In Stock',
                'out_of_stock' => '❌ Out of Stock',
            ],
            'default' => 'in_stock',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        echo "<div class='pc-component'>
                <h3>{$settings['component_title']}</h3>
                <p>Price: \${$settings['component_price']}</p>
                <p>Status: {$settings['component_stock']}</p>
              </div>";
    }
}