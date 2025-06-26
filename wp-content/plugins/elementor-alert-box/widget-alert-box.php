<?php
class Alert_Box_Widget extends \Elementor\Widget_Base {

    public function get_name() { return 'alert_box_widget'; }
    public function get_title() { return 'Alert Box'; }
    public function get_icon() { return 'eicon-alert'; }
    public function get_categories() { return ['general']; }

    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'Alert Box Settings',
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('alert_message', [
            'label' => 'Message',
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'This is an alert!',
        ]);

        $this->add_control('alert_type', [
            'label' => 'Alert Type',
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'success' => 'Success',
                'warning' => 'Warning',
                'error' => 'Error',
                'info' => 'Info',
            ],
            'default' => 'info',
        ]);

        $this->add_control('dismissible', [
            'label' => 'Allow Dismiss',
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => 'Yes',
            'label_off' => 'No',
            'default' => 'yes',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $alert_class = 'alert-box ' . esc_attr($settings['alert_type']);
        $dismissible = $settings['dismissible'] === 'yes' ? "<button class='close-alert'>&times;</button>" : "";

        echo "<div class='{$alert_class}'>
                {$dismissible}
                <p>" . esc_html($settings['alert_message']) . "</p>
              </div>";
    }
}