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
        $this->register_content_controls();
        $this->register_style_controls();
    }

    private function register_content_controls(): void {
        $this->start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__( 'Accordion Settings', 'dope-accordion' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
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
            )
        );

        echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';

        foreach ( $settings['items'] as $index => $item ) {
            $button_id    = 'da-button-' . $uid . '-' . $index;
            $panel_id     = 'da-panel-' . $uid . '-' . $index;
            $title        = isset( $item['item_title'] ) ? $item['item_title'] : '';
            $content      = isset( $item['item_content'] ) ? $item['item_content'] : '';
            $is_first     = 0 === $index;
            $open_default = $is_first && ( 'yes' === $settings['first_item_open'] );

            echo '<div class="da-item' . ( $open_default ? ' is-open' : '' ) . '">';
            echo '<button class="da-header" id="' . esc_attr( $button_id ) . '" type="button" aria-controls="' . esc_attr( $panel_id ) . '" aria-expanded="' . ( $open_default ? 'true' : 'false' ) . '">';

            $this->render_toggle_icon( $settings, $open_default );

            echo '<span class="da-title">' . esc_html( $title ) . '</span>';
            echo '</button>';

            echo '<div class="da-panel" id="' . esc_attr( $panel_id ) . '" role="region" aria-labelledby="' . esc_attr( $button_id ) . '"' . ( $open_default ? '' : ' hidden' ) . '>';
            echo '<div class="da-content-wrap">';
            echo '<div class="da-content">' . wp_kses_post( $content ) . '</div>';

            $this->render_media( $item, $settings );

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

                if ( $single_image_id > 0 ) {
                    $used_attachment_ids[] = $single_image_id;
                }

                $this->render_media_card(
                    '<img class="da-media da-media-image" src="' . esc_url( $item['item_image']['url'] ) . '" alt="' . esc_attr( $item['item_media_caption'] ?? '' ) . '" loading="lazy" />',
                    $item,
                    ! empty( $single_image_link ) ? $single_image_link : $link_url,
                    $target,
                    $rel_attr
                );
            }

            if ( ! empty( $gallery ) ) {
                foreach ( $gallery as $gallery_item ) {
                    if ( empty( $gallery_item['url'] ) ) {
                        continue;
                    }
                    $gallery_id = ! empty( $gallery_item['id'] ) ? (int) $gallery_item['id'] : 0;
                    if ( $gallery_id > 0 && in_array( $gallery_id, $used_attachment_ids, true ) ) {
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
                        '<img class="da-media da-media-image" src="' . esc_url( $gallery_item['url'] ) . '" alt="' . esc_attr( $item['item_media_caption'] ?? '' ) . '" loading="lazy" />',
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
