<?php

namespace Elementor;

class BTEA_Nested_Flexible_Widget extends Widget_Base {

    public function get_name() {
        return 'btea-nested-flexible-content';
    }

    public function get_title() {
        return esc_html__( 'BTEA Nested Flexible Content', 'btea' );
    }

    public function get_icon() {
        return 'fa fa-code';
    }

    public function get_categories() {
        return [ 'btea-category' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Flexible Section', 'btea' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

            $this->add_control(
                'btea_gropu_text',
                [
                    'label' => __( 'Add Group Name', 'btea' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            // Defining New Repeater
            $repeater = new \Elementor\Repeater();

            // Adding Controls to Newly Created Repeater ($repeater not $this)
            $repeater->add_control(
                'btea_layout_text',
                [
                    'label' => __( 'Add Layout Name', 'btea' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $repeater->add_control(
                'btea_field_text',
                [
                    'label' => __( 'Add Field Name', 'btea' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $repeater->add_control(
                'btea_html_element',
                [
                    'label' => __( 'HTML Tag', 'btea' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                        'div' => 'div',
                        'img' => 'img',
                        'span' => 'span',
                        'p' => 'p',
                    ],
                    'default' => 'div',
                ]
            );

            
            $repeater->add_group_control(
                \Elementor\Group_Control_Image_Size::get_type(),
                [
                    'name' => 'btea_image', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                    'exclude' => [ 'custom' ],
                    'include' => [],
                    'default' => 'large',
                    'condition' => [
                        'btea_html_element' => 'img'
                    ],
                ]
            );

            //Adding Repeater to the Elementor TAB Area ($this)
            $this->add_control(
                'btea_repeater',
                [
                    'label' => __( 'Repeater List', 'btea' ),
				    'type' => \Elementor\Controls_Manager::REPEATER,
				    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'btea_layout_text' => __( 'Layout Name', 'btea' ),
                            'btea_field_text' => __( 'Field Name', 'btea' ),
                        ],
                    ],
                ]
            );
        
        $this->end_controls_section();

        // Style Tab
        $this->style_tab();
    }

    protected function style_tab() {

        $this->start_controls_section(
            'image_style_section',
            [
                'label' => __( 'Image Settings', 'btea' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
            $this->add_responsive_control(
                'btea_image_align',
                [
                    'label' => __( 'Alignment', 'btea' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'btea' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'btea' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'btea' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .btea-image-wrapper' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'btea_image_width',
                [
                    'label' => __( 'Width', 'btea' ),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'unit' => '%',
                    ],
                    'tablet_default' => [
                        'unit' => '%',
                    ],
                    'mobile_default' => [
                        'unit' => '%',
                    ],
                    'size_units' => [ '%', 'px', 'vw' ],
                    'range' => [
                        '%' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                        'px' => [
                            'min' => 1,
                            'max' => 1000,
                        ],
                        'vw' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .btea-content-img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'btea_image_padding',
                [
                    'label' => __( 'Margin', 'btea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .btea-image-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
    

        $this->end_controls_section();

        $this->start_controls_section(
            'heading_style_section',
            [
                'label' => __( 'Heading Settings', 'btea' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
            //Heading Styling Start Here
            $this->add_control(
                'btea_heading_color',
                [
                    'label' => __( 'Heading Color', 'btea' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btea-heading-wrapper ' => 'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'btea_heading_background',
                    'label' => __( 'Background', 'btea' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .btea-heading-wrapper',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btea_heading_typography',
                    'selector' => '{{WRAPPER}} .btea-heading-wrapper',
                    'separator' => 'before',
                ]
            );

            /*$this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'image_border',
                    'selector' => '{{WRAPPER}} .btea-heading-wrapper',
                    'separator' => 'before',
                ]
            );*/

            $this->add_control(
                'btea_heading_broder_radius',
                [
                    'label' => __( 'Border Radius', 'btea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .btea-heading-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'btea_heading_padding',
                [
                    'label' => __( 'Padding', 'btea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .btea-heading-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __( 'Content Settings', 'btea' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

            //Content Styling Start Here
            $this->add_control(
                'btea_content_color',
                [
                    'label' => __( 'Content Color', 'btea' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btea-content-wrapper ' => 'color: {{VALUE}}'
                    ]
                ]
            );
    
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'btea_content_typography',
                    'selector' => '{{WRAPPER}} .btea-content-wrapper',
                ]
            );

            $this->add_control(
                'btea_content_padding',
                [
                    'label' => __( 'Padding', 'btea' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .btea-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();


    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if (have_rows($settings['btea_gropu_text'])):
            
            while(have_rows($settings['btea_gropu_text'])): the_row();
                echo '<div class="btea-section-wrapper">';
                    foreach( $settings['btea_repeater'] as $repeater ){
                        if(get_row_layout() == $repeater['btea_layout_text']):
                            if( get_sub_field($repeater['btea_field_text']) ):
                                if( $repeater['btea_html_element'] == 'img' ){
                                    $image_url = Group_Control_Image_Size::get_attachment_image_src( get_sub_field($repeater['btea_field_text'])['id'], 'btea_image', $repeater );
                                    //print_r( $image_url );
                                    $btea_html = sprintf( '<div class="btea-image-wrapper"><%1$s src="%2$s" class="btea-content-img"></div>', $repeater['btea_html_element'], esc_attr( $image_url ));
                                    //echo $btea_html;
                                }elseif( $repeater['btea_html_element'] == 'h1' || $repeater['btea_html_element'] ==  'h2' || $repeater['btea_html_element'] == 'h3' || $repeater['btea_html_element'] == 'h4' || $repeater['btea_html_element'] == 'h5' || $repeater['btea_html_element'] == 'h6' ) {
                                    $btea_html = sprintf( '<%1$s class="btea-heading-wrapper">%2$s</%1$s>', $repeater['btea_html_element'], $i . get_sub_field($repeater['btea_field_text']) );
                                }else{
                                    $btea_html = sprintf( '<%1$s class="btea-content-wrapper">%2$s</%1$s>', $repeater['btea_html_element'], get_sub_field($repeater['btea_field_text']) );
                                    //echo $btea_html;
                                }
                                echo $btea_html;
                            endif;
                        endif;
                    }
                echo '</div>';
            endwhile;
        
        endif;

    }

    protected function _content_template() {

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new BTEA_Nested_Flexible_Widget() );

?>