<?php

namespace Elementor;

class BTEA_Flexible_Widget extends Widget_Base {

    public function get_name() {
        return 'btea-flexible-content';
    }

    public function get_title() {
        return esc_html__( 'BTEA Flexible Content', 'btea' );
    }

    public function get_icon() {
        return 'fa fa-code';
    }

    public function get_categories() {
        return [ 'btea-category' ];
    }

    public function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Field Names', 'btea' ),
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
            $this->add_control(
                'btea_layout_text',
                [
                    'label' => __( 'Add Layout Name', 'btea' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
            $this->add_control(
                'btea_repeater_text',
                [
                    'label' => __( 'Add Repeater Name', 'btea' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
            $this->add_control(
                'btea_field_text',
                [
                    'label' => __( 'Add Field Name', 'btea' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'btea_icon_section',
            [
                'label' => __( 'Icon', 'btea' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'btea_icon',
			[
				'label' => __( 'Choose Icons', 'btea' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'fa4compatibility' => 'icon',
			]
		);

        $this->end_controls_section();

        // Style Tab
        $this->style_tab();
    }

    private function style_tab() {

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __( 'Content', 'btea' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'btea_color',
                [
                    'label' => __( 'Color', 'btea' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btea-li' => 'color: {{VALUE}}'
                    ]
                ]
            );

            $this->add_responsive_control(
                'btea_content_space',
                [
                    'label' => __( 'Content Space', 'btea' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 2,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 2,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .btea-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'btea_content_typography',
                    'label' => __( 'Typography', 'plugin-domain' ),
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .btea-li',
                ]
            );

            $this->add_responsive_control(
                'align',
                [
                    'label' => __( 'Alignment', 'elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'elementor' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'elementor' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'elementor' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'elementor' ),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .btea-li' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => __( 'Icon', 'btea' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'btea_icon_space',
                [
                    'label' => __( 'Icon Space', 'btea' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 2,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 2,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .btea-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();


    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $btea_icon = $settings['btea_icon']['value'];

        $icon_html = '<i class="' . $btea_icon . ' btea-icon"></i>';

        if (have_rows($settings['btea_gropu_text'])):

            while(have_rows($settings['btea_gropu_text'])): the_row();
        
                if(get_row_layout() == ($settings['btea_layout_text'])):
        
                    if( have_rows($settings['btea_repeater_text']) ):
                            while( have_rows($settings['btea_repeater_text']) ) : the_row();
        
                                // Get sub value.
                                $child_title = get_sub_field($settings['btea_field_text']);
                                echo '<li class="btea-li">' . $icon_html . $child_title . '</li>';
        
                            endwhile;
                    endif;
        
                endif;
        
            endwhile;
        
        endif;
       
    }

    protected function _content_template() {

    }

}
Plugin::instance()->widgets_manager->register_widget_type( new BTEA_Flexible_Widget() );

?>