<?php

namespace FluentForm\App\Services\FormBuilder;

use FluentForm\App\Helpers\Helper;

class FormBuilder
{
    /**
     * The Applivcation instance
     * @var Framework\Foundation\Application
     */
    protected $app = null;

    /**
     * Conditional logic for elements
     * @var array
     */
    public $conditions = array();

    /**
     * Validation rules for elements
     * @var array
     */
    public $validationRules = array();

    public $tabIndex = 1;

    /**
     * Construct the form builder instance
     * @param Framework\Foundation\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Render the form
     * @param  StdClass $form [Form entry from database]
     * @return mixed
     */
    public function build($form, $extraCssClass = '', $instanceCssClass = '')
    {
        $hasStepWrapper = isset($form->fields['stepsWrapper']) && $form->fields['stepsWrapper'];
        $labelPlacement = $form->settings['layout']['labelPlacement'];

        $formClass = "frm-fluent-form fluent_form_{$form->id} ff-el-form-{$labelPlacement} ".$extraCssClass;

        if ($hasStepWrapper) {
            $formClass .= ' ff-form-has-steps';
        }

        if ($extraFormClass = Helper::formExtraCssClass($form)) {
            $formClass .= ' ' . $extraFormClass;
        }

        $formBody = $this->buildFormBody($form);
        $formClass = apply_filters('fluentform_form_class', $formClass, $form);

        ob_start();
        echo "<div class='fluentform'>";
        do_action('fluentform_before_form_render', $form);
        echo "<form data-form_id='" . $form->id . "' id='fluentform_" . $form->id . "' class='" . $formClass . "'>";
        do_action('fluentform_form_element_start', $form);
        echo "<input type='hidden' name='__fluent_form_embded_post_id' value='" . get_the_ID() . "' />";
        wp_nonce_field('fluentform-submit-form', '_fluentform_' . $form->id . '_fluentformnonce', true, true);
        echo $formBody;
        echo "</form><div id='fluentform_" . $form->id . "_errors' class='ff-errors-in-stack ".$extraCssClass."_errors ".$instanceCssClass."_errors'></div></div>";
        do_action('fluentform_after_form_render', $form);
        return ob_get_clean();
    }


    public function buildFormBody($form)
    {
        $hasStepWrapper = isset($form->fields['stepsWrapper']) && $form->fields['stepsWrapper'];
        ob_start();
        if ($hasStepWrapper) {
            $this->setUniqueIdentifier($form->fields['stepsWrapper']['stepStart']);
            $this->app->doAction('fluentform_render_item_step_start', $form->fields['stepsWrapper']['stepStart'], $form);
        }

        foreach ($form->fields['fields'] as $item) {
            $this->setUniqueIdentifier($item);
            $item = $this->app->applyFilters('fluentform_before_render_item', $item, $form);
            $this->app->doAction('fluentform_render_item_' . $item['element'], $item, $form);
            $this->extractValidationRules($item);
            $this->extractConditionalLogic($item);
        }

        if ($hasStepWrapper) {
            $this->app->doAction('fluentform_render_item_step_end', $form->fields['stepsWrapper']['stepEnd'], $form);
        }

        $this->app->doAction('fluentform_render_item_submit_button', $form->fields['submitButton'], $form);
        return ob_get_clean();
    }

    /**
     * Set unique name/data-name for an element
     * @param array &$item
     * @return  void
     */
    protected function setUniqueIdentifier(&$item)
    {
        if (isset($item['columns'])) {
            foreach ($item['columns'] as &$column) {
                foreach ($column['fields'] as &$field) {
                    $this->setUniqueIdentifier($field);
                }
            }
        } else {
            if (!isset($item['attributes']['name'])) {
                $item['attributes']['name'] = $item['element'] . '-' . uniqid(rand(), true);
            }

            $item['attributes']['data-name'] = $item['attributes']['name'];
        }
    }

    /**
     * Recursively extract validation rules from a given element
     * @param array $item
     * @return void
     */
    protected function extractValidationRules($item)
    {
        if (isset($item['columns'])) {
            foreach ($item['columns'] as $column) {
                foreach ($column['fields'] as $field) {
                    $this->extractValidationRules($field);
                }
            }
        } elseif (isset($item['fields'])) {
            $rootName = $item['attributes']['name'];
            foreach ($item['fields'] as $key => $innerItem) {
                if ($item['element'] == 'address' || $item['element'] == 'input_name') {
                    $itemName = $innerItem['attributes']['name'];
                    $innerItem['attributes']['name'] = $rootName . '[' . $itemName . ']';
                } else {
                    if ($item['element'] == 'input_repeat') {
                        $innerItem['attributes']['name'] = $rootName . '[' . $key . ']';
                    } else {
                        $innerItem['attributes']['name'] = $rootName;
                    }
                }
                $this->extractValidationRule($innerItem);
            }
        } elseif ($item['element'] == 'tabular_grid') {
            $gridName = $item['attributes']['name'];
            $gridRows = $item['settings']['grid_rows'];
            $gridType = $item['settings']['tabular_field_type'];
            foreach ($gridRows as $rowKey => $rowValue) {
                if ($gridType == 'radio') {
                    $item['attributes']['name'] = $gridName . '[' . $rowKey . ']';
                    $this->extractValidationRule($item);
                } else {
                    $item['attributes']['name'] = $gridName . '[' . $rowKey . ']';
                    $this->extractValidationRule($item);
                }
            }
        } else {
            $this->extractValidationRule($item);
        }
    }

    /**
     * Extract validation rules from a given element
     * @param array $item
     * @return void
     */
    protected function extractValidationRule($item)
    {
        if (isset($item['settings']['validation_rules'])) {
            $rules = $item['settings']['validation_rules'];
            $rules = apply_filters('fluentform_item_rules_' . $item['element'], $rules);
            $this->validationRules[ $item['attributes']['name'] ] = $rules;
        }
    }

    /**
     * Extract conditipnal logic from a given element
     * @param array $item
     * @return void
     */
    protected function extractConditionalLogic($item)
    {
        // If container like element, then recurse
        if (isset($item['columns'])) {
            foreach ($item['columns'] as $column) {
                foreach ($column['fields'] as $field) {
                    $this->extractConditionalLogic($field);
                }
            }
        } elseif (isset($item['settings']['conditional_logics'])) {
            $conditionals = $item['settings']['conditional_logics'];
            if (isset($conditionals['status'])) {
                if ($conditionals['status'] && $conditionals['conditions']) {
                    $this->conditions[$item['attributes']['data-name']] = $item['settings']['conditional_logics'];
                }
            }
        }
    }
}
