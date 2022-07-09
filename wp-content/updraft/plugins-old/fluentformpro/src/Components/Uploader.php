<?php

namespace FluentFormPro\Components;

use FluentForm\App\Services\FormBuilder\Components\BaseComponent;
use FluentForm\Framework\Helpers\ArrayHelper;

class Uploader extends BaseComponent
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

        $data['attributes']['class'] = @trim('ff-el-form-control '. $data['attributes']['class']);
        $data['attributes']['id'] = $this->makeElementId($data, $form);
        $data['attributes']['multiple'] = true;

        $data['attributes']['tabindex'] = \FluentForm\App\Helpers\Helper::getNextTabIndex();

        $elMarkup = "<label for='".$data['attributes']['id']."' class='ff_file_upload_holder'><input %s></label>";

        $elMarkup = sprintf($elMarkup, $this->buildAttributes($data['attributes'], $form));

		$html = $this->buildElementMarkup($elMarkup, $data, $form);

        echo apply_filters('fluenform_rendering_field_data_'.$elementName, $html, $data, $form);
        $this->enqueueProScripts();
    }

	/**
     * Enqueue required scripts
     * @return void
     */
    public function enqueueProScripts()
    {
        wp_enqueue_script('fluentform-uploader-jquery-ui-widget');
        wp_enqueue_script('fluentform-uploader-iframe-transport');
        wp_enqueue_script('fluentform-uploader');
    }
}