<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class Dope_Accordion_Widget extends Widget_Base {
    public function get_name(): string {
        return 'dope_accordion';
    }

    public function get_title(): string {
        return esc_html__( 'Dope Accordion', 'dope-accordion' );
    }

    public function get_icon(): string {
        return 'eicon-accordion';
    }

    public function get_categories(): array {
        return array( 'general' );
    }

    public function get_keywords(): array {
        return array( 'accordion', 'timeline', 'content', 'media', 'toggle' );
    }

    public function get_style_depends(): array {
        return array( 'dope-accordion-widget' );
    }

    public function get_script_depends(): array {
        return array( 'dope-accordion-widget' );
    }

    protected function register_controls(): void {
        $this->register_items_controls();
        $this->register_settings_controls();
        $this->register_style_controls();
    }

    private function register_items_controls(): void {
        $this->start_controls_section(
            'section_items',
            array(
                'label' => esc_html__( 'Accordion Items', 'dope-accordion' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_title',
            array(
                'label'       => esc_html__( 'Title', 'dope-accordion' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Accordion Item', 'dope-accordion' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'item_position',
            array(
                'label'       => esc_html__( 'Position', 'dope-accordion' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Consultant | Aug 2024 - Present', 'dope-accordion' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'item_content',
            array(
                'label'   => esc_html__( 'Content', 'dope-accordion' ),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Add your content here.', 'dope-accordion' ),
            )
        );

        $repeater->add_control(
            'media_type',
            array(
                'label'   => esc_html__( 'Media Type', 'dope-accordion' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => array(
                    'none'  => esc_html__( 'None', 'dope-accordion' ),
                    'image' => esc_html__( 'Image', 'dope-accordion' ),
                    'video' => esc_html__( 'Video', 'dope-accordion' ),
                ),
            )
        );

        $repeater->add_control(
            'item_image',
            array(
                'label'     => esc_html__( 'Image', 'dope-accordion' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => array(
                    'media_type' => 'image',
                ),
            )
        );

        $repeater->add_control(
            'item_top_image',
            array(
                'label' => esc_html__( 'Top Image (Top Image Layout)', 'dope-accordion' ),
                'type'  => Controls_Manager::MEDIA,
            )
        );

        $repeater->add_control(
            'item_gallery',
            array(
                'label'       => esc_html__( 'Image Gallery', 'dope-accordion' ),
                'type'        => Controls_Manager::GALLERY,
                'condition'   => array(
                    'media_type' => 'image',
                ),
                'description' => esc_html__( 'Optional: add multiple images for a grid.', 'dope-accordion' ),
            )
        );

        $repeater->add_control(
            'item_video_url',
            array(
                'label'       => esc_html__( 'Video URL', 'dope-accordion' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'https://www.youtube.com/watch?v=xxxxx',
                'condition'   => array(
                    'media_type' => 'video',
                ),
            )
        );

        $repeater->add_control(
            'item_video_poster',
            array(
                'label'     => esc_html__( 'Video Poster Image', 'dope-accordion' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => array(
                    'media_type' => 'video',
                ),
            )
        );

        $repeater->add_control(
            'item_media_caption',
            array(
                'label'       => esc_html__( 'Media Caption', 'dope-accordion' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Optional caption', 'dope-accordion' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'item_link',
            array(
                'label'       => esc_html__( 'Media Link', 'dope-accordion' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://example.com',
                'dynamic'     => array(
                    'active' => true,
                ),
                'description' => esc_html__( 'Fallback link. Gallery images use their own link from Media Library field "Accordion Image Link".', 'dope-accordion' ),
            )
        );

        $this->add_control(
            'items',
            array(
                'label'       => esc_html__( 'Items', 'dope-accordion' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'item_title'   => '2026',
                        'item_content' => '<ul><li><strong>Sample item:</strong> Add details here.</li></ul>',
                        'media_type'   => 'none',
                    ),
                    array(
                        'item_title'   => '2025',
                        'item_content' => '<p>Add your content for this year.</p>',
                        'media_type'   => 'none',
                    ),
                ),
                'title_field' => '{{{ item_title }}}',
            )
        );

        $this->end_controls_section();
    }

    private function register_settings_controls(): void {
        $this->start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__( 'Accordion Settings', 'dope-accordion' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'layout_variant',
            array(
                'label'   => esc_html__( 'Layout Variant', 'dope-accordion' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => array(
                    'default'   => esc_html__( 'Default', 'dope-accordion' ),
                    'top_image' => esc_html__( 'Top Image', 'dope-accordion' ),
                ),
            )
        );

        $this->add_control(
            'first_item_open',
            array(
                'label'        => esc_html__( 'First Item Open By Default', 'dope-accordion' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => esc_html__( 'Yes', 'dope-accordion' ),
                'label_off'    => esc_html__( 'No', 'dope-accordion' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'top_desc_limit_enabled',
            array(
                'label'        => esc_html__( 'Limit Description Characters', 'dope-accordion' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => esc_html__( 'Yes', 'dope-accordion' ),
                'label_off'    => esc_html__( 'No', 'dope-accordion' ),
                'return_value' => 'yes',
                'condition'    => array(
                    'layout_variant' => 'top_image',
                ),
            )
        );

        $this->add_control(
            'top_desc_char_limit',
            array(
                'label'     => esc_html__( 'Description Character Limit', 'dope-accordion' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 220,
                'min'       => 20,
                'step'      => 1,
                'condition' => array(
                    'layout_variant'        => 'top_image',
                    'top_desc_limit_enabled' => 'yes',
                ),
            )
        );

        $this->add_control(
            'top_desc_read_more_label',
            array(
                'label'     => esc_html__( 'Read More Label', 'dope-accordion' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'see more', 'dope-accordion' ),
                'condition' => array(
                    'layout_variant' => 'top_image',
                ),
            )
        );

        $this->add_control(
            'top_desc_read_less_label',
            array(
                'label'     => esc_html__( 'Read Less Label', 'dope-accordion' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'see less', 'dope-accordion' ),
                'condition' => array(
                    'layout_variant' => 'top_image',
                ),
            )
        );

        $this->add_control(
            'open_all_by_default',
            array(
                'label'        => esc_html__( 'Open All Items By Default', 'dope-accordion' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => esc_html__( 'Yes', 'dope-accordion' ),
                'label_off'    => esc_html__( 'No', 'dope-accordion' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'allow_multiple_open',
            array(
                'label'        => esc_html__( 'Allow Multiple Open Items', 'dope-accordion' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => esc_html__( 'Yes', 'dope-accordion' ),
                'label_off'    => esc_html__( 'No', 'dope-accordion' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'allow_collapse',
            array(
                'label'        => esc_html__( 'Allow Closing Open Item', 'dope-accordion' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => esc_html__( 'Yes', 'dope-accordion' ),
                'label_off'    => esc_html__( 'No', 'dope-accordion' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'link_target_default',
            array(
                'label'   => esc_html__( 'Default Link Target', 'dope-accordion' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '_self',
                'options' => array(
                    '_self'  => esc_html__( 'Current Tab', 'dope-accordion' ),
                    '_blank' => esc_html__( 'New Tab', 'dope-accordion' ),
                ),
            )
        );

        $this->add_control(
            'icon_position',
            array(
                'label'   => esc_html__( 'Toggle Icon Position', 'dope-accordion' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => array(
                    'left'  => array(
                        'title' => esc_html__( 'Left', 'dope-accordion' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'dope-accordion' ),
                        'icon'  => 'eicon-h-align-right',
                    ),
                ),
                'default' => 'left',
                'toggle'  => false,
            )
        );

        $this->add_control(
            'icon_collapsed',
            array(
                'label'   => esc_html__( 'Collapsed Icon', 'dope-accordion' ),
                'type'    => Controls_Manager::ICONS,
                'default' => array(
                    'value'   => 'fas fa-plus',
                    'library' => 'fa-solid',
                ),
            )
        );

        $this->add_control(
            'icon_expanded',
            array(
                'label'   => esc_html__( 'Expanded Icon', 'dope-accordion' ),
                'type'    => Controls_Manager::ICONS,
                'default' => array(
                    'value'   => 'fas fa-minus',
                    'library' => 'fa-solid',
                ),
            )
        );

        $this->end_controls_section();
    }

    private function register_style_controls(): void {
        $this->start_controls_section(
            'section_style_container',
            array(
                'label' => esc_html__( 'Container', 'dope-accordion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'container_background',
                'selector' => '{{WRAPPER}} .da-accordion',
            )
        );

        $this->add_responsive_control(
            'container_padding',
            array(
                'label'      => esc_html__( 'Padding', 'dope-accordion' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em', 'rem' ),
                'selectors'  => array(
                    '{{WRAPPER}} .da-accordion' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_item',
            array(
                'label' => esc_html__( 'Item', 'dope-accordion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'item_border_color',
            array(
                'label'     => esc_html__( 'Border Color', 'dope-accordion' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6aa6ff',
                'selectors' => array(
                    '{{WRAPPER}} .da-item' => 'border-top-color: {{VALUE}}; border-bottom-color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'item_spacing',
            array(
                'label'      => esc_html__( 'Spacing', 'dope-accordion' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 60,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .da-item + .da-item' => 'margin-top: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'item_border_width',
            array(
                'label'      => esc_html__( 'Border Width', 'dope-accordion' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 10,
                    ),
                ),
                'default'    => array(
                    'size' => 2,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .da-item' => 'border-top-width: {{SIZE}}{{UNIT}}; border-bottom-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_header',
            array(
                'label' => esc_html__( 'Header', 'dope-accordion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'header_title_color',
            array(
                'label'     => esc_html__( 'Title Color', 'dope-accordion' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1b2430',
                'selectors' => array(
                    '{{WRAPPER}} .da-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'header_icon_color',
            array(
                'label'     => esc_html__( 'Icon Color', 'dope-accordion' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#2563eb',
                'selectors' => array(
                    '{{WRAPPER}} .da-toggle-icon' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'header_typography',
                'selector' => '{{WRAPPER}} .da-title',
            )
        );

        $this->add_responsive_control(
            'header_padding',
            array(
                'label'      => esc_html__( 'Padding', 'dope-accordion' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .da-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'toggle_icon_size',
            array(
                'label'      => esc_html__( 'Toggle Icon Size', 'dope-accordion' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 40,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .da-toggle-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            array(
                'label' => esc_html__( 'Content', 'dope-accordion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'content_text_color',
            array(
                'label'     => esc_html__( 'Text Color', 'dope-accordion' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => array(
                    '{{WRAPPER}} .da-content' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .da-content',
            )
        );

        $this->add_responsive_control(
            'content_padding',
            array(
                'label'      => esc_html__( 'Padding', 'dope-accordion' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .da-content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_read_more',
            array(
                'label'     => esc_html__( 'Read More Button', 'dope-accordion' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'layout_variant' => 'top_image',
                ),
            )
        );

        $this->add_control(
            'read_more_color',
            array(
                'label'     => esc_html__( 'Color', 'dope-accordion' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#2563eb',
                'selectors' => array(
                    '{{WRAPPER}} .da-accordion[data-layout="top_image"] .da-top-description button.da-desc-toggle' => 'color: {{VALUE}} !important;',
                ),
            )
        );

        $this->add_control(
            'read_more_hover_color',
            array(
                'label'     => esc_html__( 'Hover Color', 'dope-accordion' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1d4ed8',
                'selectors' => array(
                    '{{WRAPPER}} .da-accordion[data-layout="top_image"] .da-top-description button.da-desc-toggle:hover, {{WRAPPER}} .da-accordion[data-layout="top_image"] .da-top-description button.da-desc-toggle:focus, {{WRAPPER}} .da-accordion[data-layout="top_image"] .da-top-description button.da-desc-toggle:active' => 'color: {{VALUE}} !important;',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'read_more_typography',
                'selector' => '{{WRAPPER}} .da-accordion[data-layout="top_image"] .da-top-description button.da-desc-toggle',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_media',
            array(
                'label' => esc_html__( 'Media Card', 'dope-accordion' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'media_columns',
            array(
                'label'    => esc_html__( 'Columns', 'dope-accordion' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => '4',
                'options'  => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .da-media-wrap' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
                ),
            )
        );

        $this->add_responsive_control(
            'media_gap',
            array(
                'label'      => esc_html__( 'Gap', 'dope-accordion' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 40,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .da-media-wrap' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'media_border',
                'selector' => '{{WRAPPER}} .da-media-card',
            )
        );

        $this->add_responsive_control(
            'media_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'dope-accordion' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .da-media-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'media_shadow',
                'selector' => '{{WRAPPER}} .da-media-card',
            )
        );

        $this->add_control(
            'media_link_icon_color',
            array(
                'label'     => esc_html__( 'Link Icon Color', 'dope-accordion' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => array(
                    '{{WRAPPER}} .da-link-indicator' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'media_link_icon_bg',
            array(
                'label'     => esc_html__( 'Link Icon Background', 'dope-accordion' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .da-link-indicator' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $layout_variant      = ! empty( $settings['layout_variant'] ) ? $settings['layout_variant'] : 'default';
        $limit_enabled       = ( ! empty( $settings['top_desc_limit_enabled'] ) && 'yes' === $settings['top_desc_limit_enabled'] );
        $desc_char_limit     = ! empty( $settings['top_desc_char_limit'] ) ? (int) $settings['top_desc_char_limit'] : 220;
        $desc_char_limit     = max( 20, $desc_char_limit );
        $read_more_label     = ! empty( $settings['top_desc_read_more_label'] ) ? (string) $settings['top_desc_read_more_label'] : esc_html__( 'see more', 'dope-accordion' );
        $read_less_label     = ! empty( $settings['top_desc_read_less_label'] ) ? (string) $settings['top_desc_read_less_label'] : esc_html__( 'see less', 'dope-accordion' );
        $open_all_by_default = ( ! empty( $settings['open_all_by_default'] ) && 'yes' === $settings['open_all_by_default'] );

        if ( empty( $settings['items'] ) || ! is_array( $settings['items'] ) ) {
            return;
        }

        $uid = $this->get_id();

        $this->add_render_attribute(
            'wrapper',
            array(
                'class'               => 'da-accordion',
                'data-first-open'     => ( 'yes' === $settings['first_item_open'] ) ? '1' : '0',
                'data-multiple-open'  => ( 'yes' === $settings['allow_multiple_open'] ) ? '1' : '0',
                'data-allow-collapse' => ( 'yes' === $settings['allow_collapse'] ) ? '1' : '0',
                'data-icon-position'  => ! empty( $settings['icon_position'] ) ? $settings['icon_position'] : 'left',
                'data-layout'         => $layout_variant,
                'data-open-all'       => $open_all_by_default ? '1' : '0',
                'data-top-desc-limit-enabled' => $limit_enabled ? '1' : '0',
                'data-top-desc-char-limit'    => (string) $desc_char_limit,
                'data-top-read-more-label'    => $read_more_label,
                'data-top-read-less-label'    => $read_less_label,
            )
        );

        echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';

        foreach ( $settings['items'] as $index => $item ) {
            $button_id    = 'da-button-' . $uid . '-' . $index;
            $panel_id     = 'da-panel-' . $uid . '-' . $index;
            $title        = isset( $item['item_title'] ) ? $item['item_title'] : '';
            $content      = isset( $item['item_content'] ) ? $item['item_content'] : '';
            $is_first     = 0 === $index;
            $open_default = $open_all_by_default || ( $is_first && ( 'yes' === $settings['first_item_open'] ) );
            $top_image_url = ! empty( $item['item_top_image']['url'] ) ? $item['item_top_image']['url'] : '';
            $position      = ! empty( $item['item_position'] ) ? (string) $item['item_position'] : '';
            $is_top_layout = 'top_image' === $layout_variant;

            echo '<div class="da-item' . ( $open_default ? ' is-open' : '' ) . '">';

            if ( $is_top_layout && ! empty( $top_image_url ) ) {
                echo '<div class="da-top-image-block">';
                echo '<img class="da-top-image" src="' . esc_url( $top_image_url ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" />';
                echo '</div>';
            }

            echo '<button class="da-header" id="' . esc_attr( $button_id ) . '" type="button" aria-controls="' . esc_attr( $panel_id ) . '" aria-expanded="' . ( $open_default ? 'true' : 'false' ) . '">';

            $this->render_toggle_icon( $settings, $open_default );

            echo '<span class="da-title">' . esc_html( $title ) . '</span>';
            echo '</button>';

            echo '<div class="da-panel" id="' . esc_attr( $panel_id ) . '" role="region" aria-labelledby="' . esc_attr( $button_id ) . '"' . ( $open_default ? '' : ' hidden' ) . '>';
            echo '<div class="da-content-wrap">';

            if ( $is_top_layout ) {
                if ( ! empty( $position ) ) {
                    echo '<div class="da-top-position">' . esc_html( $position ) . '</div>';
                }

                $this->render_top_image_description( $content, $settings, $button_id, $panel_id, $index );
                $this->render_media( $item, $settings );
            } else {
                echo '<div class="da-content">' . wp_kses_post( $content ) . '</div>';
                $this->render_media( $item, $settings );
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
    }

    private function render_toggle_icon( array $settings, bool $open_default ): void {
        $collapsed_icon = ! empty( $settings['icon_collapsed']['value'] ) ? $settings['icon_collapsed'] : null;
        $expanded_icon  = ! empty( $settings['icon_expanded']['value'] ) ? $settings['icon_expanded'] : null;

        echo '<span class="da-toggle-icon" aria-hidden="true">';
        echo '<span class="da-icon-collapsed' . ( $open_default ? ' da-hidden' : '' ) . '">';
        if ( $collapsed_icon ) {
            Icons_Manager::render_icon( $collapsed_icon, array( 'aria-hidden' => 'true' ) );
        }
        echo '</span>';
        echo '<span class="da-icon-expanded' . ( $open_default ? '' : ' da-hidden' ) . '">';
        if ( $expanded_icon ) {
            Icons_Manager::render_icon( $expanded_icon, array( 'aria-hidden' => 'true' ) );
        }
        echo '</span>';
        echo '</span>';
    }

    private function render_media( array $item, array $settings ): void {
        if ( empty( $item['media_type'] ) || 'none' === $item['media_type'] ) {
            return;
        }

        $link_url = isset( $item['item_link']['url'] ) ? $item['item_link']['url'] : '';
        $target   = ( ! empty( $item['item_link']['is_external'] ) ) ? '_blank' : $settings['link_target_default'];

        $rel = array();
        if ( '_blank' === $target ) {
            $rel[] = 'noopener';
        }
        if ( ! empty( $item['item_link']['nofollow'] ) ) {
            $rel[] = 'nofollow';
        }
        $rel_attr = implode( ' ', $rel );

        echo '<div class="da-media-wrap">';

        if ( 'image' === $item['media_type'] ) {
            $gallery = ! empty( $item['item_gallery'] ) && is_array( $item['item_gallery'] ) ? $item['item_gallery'] : array();
            $used_attachment_ids = array();

            if ( ! empty( $item['item_image']['url'] ) ) {
                $single_image_id   = ! empty( $item['item_image']['id'] ) ? (int) $item['item_image']['id'] : 0;
                $single_image_link = $this->get_media_link_by_id( $single_image_id );
                $single_image_url  = (string) $item['item_image']['url'];

                if ( $single_image_id > 0 ) {
                    $used_attachment_ids[] = $single_image_id;
                }

                if ( ! $this->should_skip_top_image_duplicate( $item, $single_image_id, $single_image_url, $settings ) ) {
                    $this->render_media_card(
                        '<img class="da-media da-media-image" src="' . esc_url( $single_image_url ) . '" alt="' . esc_attr( $item['item_media_caption'] ?? '' ) . '" loading="lazy" />',
                        $item,
                        ! empty( $single_image_link ) ? $single_image_link : $link_url,
                        $target,
                        $rel_attr
                    );
                }
            }

            if ( ! empty( $gallery ) ) {
                foreach ( $gallery as $gallery_item ) {
                    if ( empty( $gallery_item['url'] ) ) {
                        continue;
                    }
                    $gallery_id = ! empty( $gallery_item['id'] ) ? (int) $gallery_item['id'] : 0;
                    $gallery_url = (string) $gallery_item['url'];
                    if ( $gallery_id > 0 && in_array( $gallery_id, $used_attachment_ids, true ) ) {
                        continue;
                    }
                    if ( $this->should_skip_top_image_duplicate( $item, $gallery_id, $gallery_url, $settings ) ) {
                        continue;
                    }
                    $card_link  = $this->get_media_link_by_id( $gallery_id );
                    if ( empty( $card_link ) ) {
                        $card_link = $link_url;
                    }

                    if ( $gallery_id > 0 ) {
                        $used_attachment_ids[] = $gallery_id;
                    }

                    $this->render_media_card(
                        '<img class="da-media da-media-image" src="' . esc_url( $gallery_url ) . '" alt="' . esc_attr( $item['item_media_caption'] ?? '' ) . '" loading="lazy" />',
                        $item,
                        $card_link,
                        $target,
                        $rel_attr
                    );
                }
            }
        }

        if ( 'video' === $item['media_type'] ) {
            $video_url = ! empty( $item['item_video_url'] ) ? $item['item_video_url'] : '';
            $poster    = ! empty( $item['item_video_poster']['url'] ) ? $item['item_video_poster']['url'] : '';
            $inner     = '';

            if ( $poster ) {
                $inner .= '<div class="da-video-poster-wrap">';
                $inner .= '<img class="da-media da-media-video-poster" src="' . esc_url( $poster ) . '" alt="' . esc_attr( $item['item_media_caption'] ?? '' ) . '" loading="lazy" />';
                $inner .= '<span class="da-video-badge" aria-hidden="true">&#9658;</span>';
                $inner .= '</div>';
            } elseif ( $video_url ) {
                $inner .= '<div class="da-video-url">' . esc_html( $video_url ) . '</div>';
            }

            if ( $inner ) {
                $this->render_media_card( $inner, $item, $link_url, $target, $rel_attr );
            }
        }

        echo '</div>';
    }

    private function render_top_image_description( string $content, array $settings, string $button_id, string $panel_id, int $index ): void {
        $allowed_tags = $this->get_description_allowed_tags();
        $full_html    = wp_kses( $content, $allowed_tags );
        $text_length  = $this->get_string_length( wp_strip_all_tags( $full_html ) );

        if ( 0 === $text_length ) {
            return;
        }

        $limit_enabled   = ! empty( $settings['top_desc_limit_enabled'] ) && 'yes' === $settings['top_desc_limit_enabled'];
        $char_limit      = ! empty( $settings['top_desc_char_limit'] ) ? (int) $settings['top_desc_char_limit'] : 220;
        $char_limit      = max( 20, $char_limit );
        $read_more_label = ! empty( $settings['top_desc_read_more_label'] ) ? (string) $settings['top_desc_read_more_label'] : esc_html__( 'see more', 'dope-accordion' );
        $desc_id_base    = sanitize_html_class( $button_id . '-' . $panel_id . '-' . $index );

        echo '<div class="da-top-description">';

        if ( $limit_enabled && $text_length > $char_limit ) {
            $truncated = $this->truncate_html_by_chars( $full_html, $char_limit );

            echo '<div class="da-content da-desc-preview">' . $truncated['html'] . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo '<div class="da-content da-desc-full" id="da-desc-full-' . esc_attr( $desc_id_base ) . '" hidden>' . $full_html . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo '<button class="da-desc-toggle" type="button" aria-expanded="false" aria-controls="da-desc-full-' . esc_attr( $desc_id_base ) . '">' . esc_html( $read_more_label ) . '</button>';
        } else {
            echo '<div class="da-content da-desc-full">' . $full_html . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        echo '</div>';
    }

    private function get_description_allowed_tags(): array {
        return array(
            'p'      => array(),
            'ul'     => array(),
            'ol'     => array(),
            'li'     => array(),
            'strong' => array(),
            'b'      => array(),
            'em'     => array(),
            'i'      => array(),
            'a'      => array(
                'href'   => true,
                'target' => true,
                'rel'    => true,
                'title'  => true,
            ),
            'br'     => array(),
        );
    }

    private function truncate_html_by_chars( string $html, int $limit ): array {
        $tokens       = wp_html_split( $html );
        $void_tags    = array( 'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr' );
        $open_tags    = array();
        $output       = '';
        $char_count   = 0;
        $is_truncated = false;

        foreach ( $tokens as $token ) {
            if ( '' === $token ) {
                continue;
            }

            if ( $char_count >= $limit ) {
                $is_truncated = true;
                break;
            }

            if ( '<' === substr( $token, 0, 1 ) ) {
                if ( preg_match( '/^<\s*\/\s*([a-z0-9]+)/i', $token, $close_match ) ) {
                    $tag = strtolower( $close_match[1] );
                    for ( $i = count( $open_tags ) - 1; $i >= 0; $i-- ) {
                        if ( $open_tags[ $i ] === $tag ) {
                            array_splice( $open_tags, $i, 1 );
                            break;
                        }
                    }
                    $output .= $token;
                    continue;
                }

                if ( preg_match( '/^<\s*([a-z0-9]+)/i', $token, $open_match ) ) {
                    $tag            = strtolower( $open_match[1] );
                    $trimmed_token  = trim( $token );
                    $is_self_closed = '/>' === substr( $trimmed_token, -2 ) || in_array( $tag, $void_tags, true );

                    if ( ! $is_self_closed ) {
                        $open_tags[] = $tag;
                    }
                }

                $output .= $token;
                continue;
            }

            $decoded_token = html_entity_decode( $token, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
            $token_length  = $this->get_string_length( $decoded_token );
            $remaining     = $limit - $char_count;

            if ( $token_length <= $remaining ) {
                $output     .= $token;
                $char_count += $token_length;
                continue;
            }

            $snippet       = $this->get_string_substr( $decoded_token, 0, $remaining );
            $output       .= esc_html( $snippet ) . '&hellip;';
            $char_count    = $limit;
            $is_truncated  = true;
            break;
        }

        if ( $char_count >= $limit ) {
            $is_truncated = true;
        }

        if ( $is_truncated ) {
            for ( $i = count( $open_tags ) - 1; $i >= 0; $i-- ) {
                $output .= '</' . $open_tags[ $i ] . '>';
            }
        }

        return array(
            'html'         => $output,
            'is_truncated' => $is_truncated,
        );
    }

    private function get_string_length( string $value ): int {
        if ( function_exists( 'mb_strlen' ) ) {
            return (int) mb_strlen( $value, 'UTF-8' );
        }

        return strlen( $value );
    }

    private function get_string_substr( string $value, int $start, int $length ): string {
        if ( function_exists( 'mb_substr' ) ) {
            return (string) mb_substr( $value, $start, $length, 'UTF-8' );
        }

        return (string) substr( $value, $start, $length );
    }

    private function should_skip_top_image_duplicate( array $item, int $media_id, string $media_url, array $settings ): bool {
        if ( empty( $settings['layout_variant'] ) || 'top_image' !== $settings['layout_variant'] ) {
            return false;
        }

        $top_image_id  = ! empty( $item['item_top_image']['id'] ) ? (int) $item['item_top_image']['id'] : 0;
        $top_image_url = ! empty( $item['item_top_image']['url'] ) ? (string) $item['item_top_image']['url'] : '';

        if ( $top_image_id > 0 && $media_id > 0 ) {
            return $top_image_id === $media_id;
        }

        if ( '' === $top_image_url || '' === $media_url ) {
            return false;
        }

        return $this->normalize_url_for_compare( $top_image_url ) === $this->normalize_url_for_compare( $media_url );
    }

    private function normalize_url_for_compare( string $url ): string {
        $url = trim( (string) $url );
        $url = esc_url_raw( $url );

        if ( '' === $url ) {
            return '';
        }

        $url = (string) strtok( $url, '?' );

        return strtolower( untrailingslashit( $url ) );
    }

    private function render_media_card( string $inner_html, array $item, string $link_url, string $target, string $rel_attr ): void {
        echo '<article class="da-media-card">';

        if ( ! empty( $link_url ) ) {
            echo '<a class="da-media-link" href="' . esc_url( $link_url ) . '" target="' . esc_attr( $target ) . '"' . ( $rel_attr ? ' rel="' . esc_attr( $rel_attr ) . '"' : '' ) . '>';
        }

        echo $inner_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

        if ( ! empty( $item['item_media_caption'] ) ) {
            echo '<span class="da-media-caption">' . esc_html( $item['item_media_caption'] ) . '</span>';
        }

        if ( ! empty( $link_url ) ) {
            echo '<span class="da-link-indicator" aria-hidden="true">&#8599;</span>';
            echo '</a>';
        }

        echo '</article>';
    }

    private function get_media_link_by_id( int $attachment_id ): string {
        if ( $attachment_id <= 0 ) {
            return '';
        }

        $media_link = get_post_meta( $attachment_id, '_da_media_link', true );

        if ( ! is_string( $media_link ) || '' === $media_link ) {
            return '';
        }

        return esc_url_raw( $media_link );
    }
}
