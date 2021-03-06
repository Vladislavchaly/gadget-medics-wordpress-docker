<?php

/**
 * element_customization_settings
 *
 * Returns an array of countries and codes.
 *
 * @author      WooThemes
 * @category    i18n
 * @package     fluentform/i18n
 * @version     2.5.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$dateFormats = (new \FluentForm\App\Services\FormBuilder\Components\DateTime)->getAvailableDateFormats();

$dateConfigSettings = array(
    'template'    => 'inputTextarea',
    'label'       => __('Advanced Date Configartaion', 'fluentform'),
    'placeholder' => __('Advanced Date Configartaion', 'fluentform'),
    'rows' => (defined('FLUENTFORMPRO')) ? 10 : 2,
    'disabled' => !defined('FLUENTFORMPRO'),
    'css_class' => 'ff_code_editor',
    'inline_help_text' => 'Only valid JS object will work. Please check <a target="_blank" href="https://wpmanageninja.com/docs/fluent-form/field-types/time-date#advanced_configaration">the documentation for available config options</a>',
    'help_text'   => __('You can write your own date configaration as JS object. Please write valid configaration as per flatpickr config.', 'fluentform'),
);

if(!defined('FLUENTFORMPRO')) {
    $dateConfigSettings['inline_help_text'] = 'Available on Fluent Forms Pro';
}


$element_customization_settings = array(
    'name'                => array(
        'template'  => 'nameAttr',
        'label'     => __('Name Attribute', 'fluentform'),
        'help_text' => __('This is the field name attributes which is used to submit form data, name attribute must be unique.', 'fluentform'),
    ),
    'label'               => array(
        'template'  => 'inputText',
        'label'     => __('Element Label', 'fluentform'),
        'help_text' => __('This is the field title the user will see when filling out the form.', 'fluentform'),
    ),
    'label_placement'     => array(
        'template'  => 'radioButton',
        'label'     => __('Label Placement', 'fluentform'),
        'help_text' => __('Determine the position of label title where the user will see this. By choosing "Default", global label placement setting will be applied.', 'fluentform'),
        'options'   => array(
            array(
                'value' => '',
                'label' => __('Default', 'fluentform'),
            ),
            array(
                'value' => 'top',
                'label' => __('Top', 'fluentform'),
            ),
            array(
                'value' => 'left',
                'label' => __('Left', 'fluentform'),
            ),
            array(
                'value' => 'right',
                'label' => __('Right', 'fluentform'),
            ),
            array(
                'value' => 'hide_label',
                'label' => __('Hide Label', 'fluentform'),
            ),
        ),
    ),
    'button_style'        => array(
        'template'  => 'selectBtnStyle',
        'label'     => __('Button Style', 'fluentform'),
        'help_text' => __('Select a button style from the dropdown', 'fluentform'),
    ),
    'button_size'         => array(
        'template'  => 'radioButton',
        'label'     => __('Button Size', 'fluentform'),
        'help_text' => __('Define a size of the button', 'fluentform'),
        'options'   => array(
            array(
                'value' => 'sm',
                'label' => __('Small', 'fluentform'),
            ),
            array(
                'value' => 'md',
                'label' => __('Medium', 'fluentform'),
            ),
            array(
                'value' => 'lg',
                'label' => __('Large', 'fluentform'),
            ),
        )
    ),
    'placeholder'         => array(
        'template'  => 'inputText',
        'label'     => __('Placeholder', 'fluentform'),
        'help_text' => __('This is the field placeholder, the user will see this if the input field is empty.', 'fluentform'),
    ),
    'date_format'         => array(
        'template'    => 'select',
        'label'       => __('Date Format', 'fluentform'),
        'filterable'  => true,
        'creatable'   => true,
        'placeholder' => __('Select Date Format', 'fluentform'),
        'help_text'   => __('Select any date format from the dropdown. The user will be able to choose a date in this given format.', 'fluentform'),
        'options'     => $dateFormats,
    ),
    'date_config'         => $dateConfigSettings,
    'rows'                => array(
        'template'  => 'inputText',
        'label'     => __('Rows', 'fluentform'),
        'help_text' => __('How many rows will textarea take in a form. It\'s an HTML attributes for browser support.', 'fluentform'),
    ),
    'cols'                => array(
        'template'  => 'inputText',
        'label'     => __('Columns', 'fluentform'),
        'help_text' => __('How many cols will textarea take in a form. It\'s an HTML attributes for browser support.', 'fluentform'),
    ),
    'options'             => array(
        'template'  => 'selectOptions',
        'label'     => __('Options', 'fluentform'),
        'help_text' => __('Create options for the field and checkmark them for default selection.', 'fluentform'),
    ),
    'validation_rules'    => array(
        'template'  => 'validationRulesForm',
        'label'     => __('Validation Rules', 'fluentform'),
        'help_text' => '',
    ),
    'tnc_html'            => array(
        'template'  => 'inputHTML',
        'label'     => __('Terms & Conditions', 'fluentform'),
        'help_text' => __('Write HTML content for terms & condition checkbox', 'fluentform'),
        'rows'      => 4,
        'cols'      => 2,
    ),
    'hook_name'           => array(
        'template'  => 'customHookName',
        'label'     => __('Hook Name', 'fluentform'),
        'help_text' => __('WordPress Hook name to hook something in this place.', 'fluentform'),
    ),
    'has_checkbox'        => array(
        'template' => 'inputCheckbox',
        'options'  => array(
            array(
                'value' => true,
                'label' => __('Show Checkbox', 'fluentform'),
            ),
        ),
    ),
    'html_codes'          => array(
        'template'  => 'inputHTML',
        'rows'      => 4,
        'cols'      => 2,
        'label'     => __('HTML Code', 'fluentform'),
        'help_text' => __('Your valid HTML code will be shown to the user as normal content.', 'fluentform'),
    ),
    'description'         => array(
        'template'  => 'inputHTML',
        'rows'      => 4,
        'cols'      => 2,
        'label'     => __('Description', 'fluentform'),
        'help_text' => __('Description will be shown to the user as normal text content.', 'fluentform'),
    ),
    'btn_text'            => array(
        'template'  => 'inputText',
        'label'     => __('Button Text', 'fluentform'),
        'help_text' => __('This will be visible as button text for upload file.', 'fluentform'),
    ),
    'button_ui'           => array(
        'template'  => 'prevNextButton',
        'label'     => __('Submit Button', 'fluentform'),
        'help_text' => __('This is form submission button.', 'fluentform'),
    ),
    'align'               => array(
        'template'  => 'radio',
        'label'     => __('Content Alignment', 'fluentform'),
        'help_text' => __('How the content will be aligned.', 'fluentform'),
        'options'   => array(
            array(
                'value' => 'left',
                'label' => __('Left', 'fluentform'),
            ),
            array(
                'value' => 'center',
                'label' => __('Center', 'fluentform'),
            ),
            array(
                'value' => 'right',
                'label' => __('Right', 'fluentform'),
            ),
        ),
    ),
    'shortcode'           => array(
        'template'  => 'inputText',
        'label'     => __('Shortcode', 'fluentform'),
        'help_text' => __('Your shortcode to render desired content in current place.', 'fluentform'),
    ),
    'apply_styles'        => array(
        'template'  => 'radioButton',
        'label'     => __('Apply Styles', 'fluentform'),
        'help_text' => __('Apply styles provided here', 'fluentform'),
        'options'   => array(
            array(
                'value' => true,
                'label' => __('Yes', 'fluentform'),
            ),
            array(
                'value' => false,
                'label' => __('No', 'fluentform'),
            )
        ),
    ),
    'step_title'          => array(
        'template'  => 'inputText',
        'label'     => __('Step Title', 'fluentform'),
        'help_text' => __('Form step titles, user will see each title in each step.', 'fluentform'),
    ),
    'progress_indicator'  => array(
        'template'  => 'radio',
        'label'     => __('Progress Indicator', 'fluentform'),
        'help_text' => __('Select any of them below, user will see progress of form steps according to your choice.', 'fluentform'),
        'options'   => array(
            array(
                'value' => 'progress-bar',
                'label' => __('Progress Bar', 'fluentform'),
            ),
            array(
                'value' => 'steps',
                'label' => __('Steps', 'fluentform'),
            ),
            array(
                'value' => '',
                'label' => __('None', 'fluentform'),
            ),
        ),
    ),
    'step_titles'         => array(
        'template'  => 'customStepTitles',
        'label'     => __('Step Titles', 'fluentform'),
        'help_text' => __('Form step titles, user will see each title in each step.', 'fluentform'),
    ),
    'prev_btn'            => array(
        'template'  => 'prevNextButton',
        'label'     => __('Previous Button', 'fluentform'),
        'help_text' => __('Multi-step form\'s previous button', 'fluentform'),
    ),
    'next_btn'            => array(
        'template'  => 'prevNextButton',
        'label'     => __('Next Button', 'fluentform'),
        'help_text' => __('Multi-step form\'s next button', 'fluentform'),
    ),
    'address_fields'      => array(
        'template' => 'addressFields',
        'label'    => __('Address Fields', 'fluentform'),
    ),
    'name_fields'         => array(
        'template' => 'nameFields',
        'label'    => __('Name Fields', 'fluentform'),
    ),
    'multi_column'        => array(
        'template' => 'inputCheckbox',
        'options'  => array(
            array(
                'value' => true,
                'label' => __('Enable Multiple Columns', 'fluentform'),
            ),
        ),
    ),
    'repeat_fields'       => array(
        'template'  => 'customRepeatFields',
        'label'     => __('Repeat Fields', 'fluentform'),
        'help_text' => __('This is a form field which a user will be able to repeat.', 'fluentform'),
    ),
    'admin_field_label'   => array(
        'template'  => 'inputText',
        'label'     => __('Admin Field Label', 'fluentform'),
        'help_text' => __('Admin field label is field title which will be used for admin field title.', 'fluentform'),
    ),
    'value'               => array(
        'template'  => 'inputValue',
        'label'     => __('Default Value', 'fluentform'),
        'help_text' => __('If you would like to pre-populate the value of a field, enter it here.', 'fluentform'),
    ),
    'container_class'     => array(
        'template'  => 'inputText',
        'label'     => __('Container Class', 'fluentform'),
        'help_text' => __('Class for the field wrapper. This can be used to style current element.', 'fluentform'),
    ),
    'class'               => array(
        'template'  => 'inputText',
        'label'     => __('Element Class', 'fluentform'),
        'help_text' => __('Class for the field. This can be used to style current element.', 'fluentform'),
    ),
    'country_list'        => array(
        'template' => 'customCountryList',
        'label'    => __('Country List', 'fluentform'),
    ),
    'product_field_types' => array(
        'template' => 'productFieldTypes',
        'label'    => __('Options', 'fluentform'),
    ),
    'help_message'        => array(
        'template'  => 'inputText',
        'label'     => __('Help Message', 'fluentform'),
        'help_text' => __('Help message will be shown as tooltip next to sidebar or below the field.', 'fluentform'),
    ),
    'conditional_logics'  => array(
        'template'  => 'conditionalLogics',
        'label'     => __('Conditional Logic', 'fluentform'),
        'help_text' => __('Create rules to dynamically display or hide this field based on values from another field.', 'fluentform'),
    ),
    'background_color'    => array(
        'template'  => 'inputColor',
        'label'     => __('Background Color', 'fluentform'),
        'help_text' => __('The Background color of the element', 'fluentform')
    ),
    'color'               => array(
        'template'  => 'inputColor',
        'label'     => __('Font Color', 'fluentform'),
        'help_text' => __('Font color of the element', 'fluentform')
    ),
    'show_text'           => array(
        'template'  => 'radio',
        'label'     => __('Show Text?', 'fluentform'),
        'help_text' => __('Show Text beside the ratings', 'fluentform'),
        'options'   => array(
            array(
                'value' => true,
                'label' => __('Yes', 'fluentform'),
            ),
            array(
                'value' => false,
                'label' => __('No', 'fluentform'),
            )
        ),
    ),
    'data-mask'           => array(
        'template'   => 'customMask',
        'label'      => __('Custom Mask', 'fluentform'),
        'help_text'  => __('Write your own mask for this input', 'fluentform'),
        'dependency' => array(
            'depends_on' => 'settings/temp_mask',
            'value'      => 'custom',
            'operator'   => '=='
        )
    ),
    'temp_mask'           => array(
        'template'  => 'select',
        'label'     => __('Mask Input', 'fluentform'),
        'help_text' => __('Select a mask for the input field', 'fluentform'),
        'options'   => array(
            array(
                'value' => '',
                'label' => __('None', 'fluentform'),
            ),
            array(
                'value' => '(000) 000-0000',
                'label' => '(###) ###-####',
            ),
            array(
                'value' => '(00) 0000-0000',
                'label' => '(##) ####-####',
            ),
            array(
                'value' => '00/00/0000',
                'label' => __('23/03/2018', 'fluentform'),
            ),
            array(
                'value' => '00:00:00',
                'label' => __('23:59:59', 'fluentform'),
            ),
            array(
                'value' => '00/00/0000 00:00:00',
                'label' => __('23/03/2018 23:59:59', 'fluentform'),
            ),
            array(
                'value' => 'custom',
                'label' => __('Custom', 'fluentform'),
            )
        ),
    ),
    'grid_columns'        => array(
        'template'  => 'gridRowCols',
        'label'     => __('Grid Columns', 'fluentform'),
        'help_text' => __('Write your own mask for this input', 'fluentform'),
    ),
    'grid_rows'           => array(
        'template'  => 'gridRowCols',
        'label'     => __('Grid Rows', 'fluentform'),
        'help_text' => __('Write your own mask for this input', 'fluentform'),
    ),
    'tabular_field_type'  => array(
        'template'  => 'radio',
        'label'     => __('Field Type', 'fluentform'),
        'help_text' => __('Field Type', 'fluentform'),
        'options'   => array(
            array(
                'value' => 'checkbox',
                'label' => __('Checkbox', 'fluentform'),
            ),
            array(
                'value' => 'radio',
                'label' => __('Radio', 'fluentform'),
            ),
        )
    ),
    'max_repeat_field'    => array(
        'template'  => 'inputNumber',
        'label'     => __('Max Repeat inputs', 'fluentform'),
        'help_text' => __('Please provide max number of rows the user can fill up for this repeat field. Keep blank/0 for unlimited numbers', 'fluentform')
    ),
    'calculation_settings' => array(
        'template' => (defined('FLUENTFORMPRO')) ? 'inputCalculationSettings' : 'infoBlock',
        'text' => '<b>Calculation Field Settings</b><br />Calculate the value based on other numeric field is available on pro version of WP Fluent Forms. Please install WP Fluent Forms Pro to use this feature',
        'label' => 'Calculation Field Settings',
        'status_label' => 'Enable Calculation',
        'formula_label' => 'Calculation Expression',
        'formula_tips' => 'You can use + - * / for calculating the the value. Use context icon to insert the input values',
        'status_tips' => 'Enable this and provide formula expression if you want this field as calculated based on other numeric field value'
    ),
    'min' => array(
        'template'  => 'inputNumber',
        'label'     => __('Min Value', 'fluentform'),
        'help_text' => __('Please provide minimum value', 'fluentform')
    ),
    'max' => array(
        'template'  => 'inputNumber',
        'label'     => __('Max Value', 'fluentform'),
        'help_text' => __('Please provide Maximum value', 'fluentform')
    ),
    'number_step' => array(
        'template'  => 'inputText',
        'label'     => __('Step', 'fluentform'),
        'help_text' => __('Please provide step attribute for this field. Give value "any" for floating value', 'fluentform')
    )
);

return apply_filters('fluent_editor_element_customization_settings', $element_customization_settings);
