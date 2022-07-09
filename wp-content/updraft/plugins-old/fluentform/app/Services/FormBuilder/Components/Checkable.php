<?php

namespace FluentForm\App\Services\FormBuilder\Components;

use FluentForm\App\Helpers\Helper;

class Checkable extends BaseComponent
{
    /**
     * Compile and echo the html element
     * @param  array $data [element data]
     * @param  stdClass $form [Form Object]
     * @return viod
     */
    public function compile($data, $form)
    {
        $elementName = $data['element'];
        $data = apply_filters('fluenform_rendering_field_data_'.$elementName, $data, $form);

        $data['attributes']['class'] = trim(
            'ff-el-form-check-input ' .
            @$data['attributes']['class']
        );

        if ($data['attributes']['type'] == 'checkbox') {
            $data['attributes']['name'] = $data['attributes']['name'] . '[]';
        }

        $defaultValues = (array)$this->extractValueFromAttributes($data);

        $elMarkup = '';
        $firstTabIndex = Helper::getNextTabIndex();
        foreach ($data['options'] as $value => $label) {

            if (in_array($value, $defaultValues)) {
                $data['attributes']['checked'] = true;
            } else {
                $data['attributes']['checked'] = false;
            }

            $data['attributes']['tabindex'] = $firstTabIndex;
            $firstTabIndex = '-1';

            $data['attributes']['value'] = $value;
            $atts = $this->buildAttributes($data['attributes']);
            $id = $this->getUniqueid(str_replace(['[', ']'], ['', ''], $data['attributes']['name']));
            $displayType = isset($data['settings']['display_type']) ? ' ff-el-form-check-' . $data['settings']['display_type'] : '';

            $elMarkup .= "<div class='ff-el-form-check{$displayType}'>";
            $elMarkup .= "<label class='ff-el-form-check-label' for={$id}><input {$atts} id='{$id}'> {$label}</label>";
            $elMarkup .= "</div>";
        }


        $html = $this->buildElementMarkup($elMarkup, $data, $form);

        echo apply_filters('fluenform_rendering_field_data_'.$elementName, $html, $data, $form);
    }
}