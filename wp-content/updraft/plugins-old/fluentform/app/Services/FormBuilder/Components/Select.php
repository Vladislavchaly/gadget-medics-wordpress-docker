<?php

namespace FluentForm\App\Services\FormBuilder\Components;

use FluentForm\App\Helpers\Helper;

class Select extends BaseComponent
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

        $data['attributes']['id'] = $this->makeElementId($data, $form);
		
		if (@$data['attributes']['multiple']) {
			$data['attributes']['name'] = $data['attributes']['name'].'[]';
			wp_enqueue_script('selectWoo');
			wp_enqueue_style('select2');
            $data['attributes']['class'] .= ' ff_has_multi_select';
		}

        $data['attributes']['class'] = trim('ff-el-form-control ' . $data['attributes']['class']);
        $data['attributes']['tabindex'] = Helper::getNextTabIndex();
		$defaultValues = (array) $this->extractValueFromAttributes($data);
		if (!empty($data['settings']['placeholder'])) {
            $data['options'] = array('' => $data['settings']['placeholder']) + $data['options'];
		}

        $elMarkup = "<select %s>%s</select>";
        $elMarkup = sprintf(
            $elMarkup,
            $this->buildAttributes($data['attributes']),
            $this->buildOptions($data['options'], $defaultValues)
        );

        $html = $this->buildElementMarkup($elMarkup, $data, $form);
        echo apply_filters('fluenform_rendering_field_data_'.$elementName, $html, $data, $form);
    }

	/**
	 * Build options for select
	 * @param  array $options
	 * @return string/html [compiled options]
	 */
	protected function buildOptions($options, $defaultValues)
	{
		$opts = '';
		foreach ($options as $value => $label) {
			if(in_array($value, $defaultValues)) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$opts .="<option value='{$value}' {$selected}>{$label}</option>";
		}
		return $opts;
	}
}
