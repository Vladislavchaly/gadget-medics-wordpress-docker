<?php

namespace FluentForm\App\Helpers;

use FluentForm\Framework\Helpers\ArrayHelper;

class Helper
{
    static $tabIndex = 0;

    static $formInstance = 0;

    /**
     * Sanitize form inputs recursively.
     *
     * @param $input
     *
     * @return string $input
     */
    public static function sanitizer($input, $attribute = null, $fields = [])
    {
        if (is_string($input)) {
            if (ArrayHelper::get($fields, $attribute . '.element') === 'textarea') {
                $input = sanitize_textarea_field($input);
            } else {
                $input = sanitize_text_field($input);
            }
        } elseif (is_array($input)) {
            foreach ($input as $key => &$value) {
                $attribute = $attribute ? $attribute . '[' . $key . ']' : $key;

                $value = Helper::sanitizer($value, $attribute, $fields);

                $attribute = null;
            }
        }
        return $input;
    }

    public static function makeMenuUrl($page = 'fluent_forms_settings', $component = null)
    {
        $baseUrl = admin_url('admin.php?page=' . $page);

        $hash = ArrayHelper::get($component, 'hash', '');
        if ($hash) {
            $baseUrl = $baseUrl . '#' . $hash;
        }

        $query = ArrayHelper::get($component, 'query');

        if ($query) {
            $paramString = http_build_query($query);
            if ($hash) {
                $baseUrl .= '?' . $paramString;
            } else {
                $baseUrl .= '&' . $paramString;
            }
        }

        return $baseUrl;

    }

    public static function getHtmlElementClass($value1, $value2, $class = 'active', $default = '')
    {
        return $value1 === $value2 ? $class : $default;
    }

    /**
     * Determines if the given string is a valid json.
     *
     * @param $string
     *
     * @return bool
     */
    public static function isJson($string)
    {
        json_decode($string);


        return json_last_error() === JSON_ERROR_NONE;
    }


    public static function isSlackEnabled()
    {
        $globalModules = get_option('fluentform_global_modules_status');
        return $globalModules && isset($globalModules['slack']) && $globalModules['slack'] == 'yes';
    }

    public static function getEntryStutuses($form_id = false)
    {
        $statuses = apply_filters('fluentform_entry_statuses', [
            'unread' => 'Unread',
            'read'   => 'Read'
        ], $form_id);
        $statuses['trashed'] = 'Trashed';
        return $statuses;
    }

    public static function getReportableInputs()
    {
        return apply_filters('fluentform_reportable_inputs', [
            'select',
            'input_radio',
            'input_checkbox',
            'ratings',
            'select_country'
        ]);
    }

    public static function getSubFieldReportableInputs()
    {
        return apply_filters('fluentform_subfield_reportable_inputs', [
            'tabular_grid'
        ]);
    }

    public static function getFormMeta($formId, $metaKey, $default = '')
    {
        $meta = wpFluent()->table('fluentform_form_meta')
            ->where('meta_key', $metaKey)
            ->where('form_id', $formId)
            ->first();
        if (!$meta || $meta->value) {
            return $default;
        }

        $metaValue = $meta->value;
        // decode the JSON data
        $result = json_decode($metaValue, true);
        if ($result === FALSE) {
            return $metaValue;
        }
        return $result;
    }

    public static function setFormMeta($formId, $metaKey, $value)
    {
        $meta = wpFluent()->table('fluentform_form_meta')
            ->where('meta_key', $metaKey)
            ->where('form_id', $formId)
            ->first();
        if (!$meta) {
            $insetid = wpFluent()->table('fluentform_form_meta')
                ->insert([
                    'meta_key' => $metaKey,
                    'form_id'  => $formId,
                    'value'    => json_encode($value)
                ]);
            return $insetid;
        } else {
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value);
            }
            wpFluent()->table('fluentform_form_meta')
                ->where('id', $meta->id)
                ->update([
                    'value' => $value
                ]);
        }
        return $meta->id;
    }

    public static function isEntryAutoDeleteEnabled($formId)
    {
        $settings = wpFluent()->table('fluentform_form_meta')
            ->where('form_id', $formId)
            ->where('meta_key', 'formSettings')
            ->first();

        if (!$settings) {
            return false;
        }

        $formSettings = json_decode($settings->value, true);
        if ($formSettings && ArrayHelper::get($formSettings, 'delete_entry_on_submission') == 'yes') {
            return true;
        }
        return false;
    }

    public static function formExtraCssClass($form)
    {
        if(!$form->settings) {
            $settings = wpFluent()->table('fluentform_form_meta')
                ->where('form_id', $form->id)
                ->where('meta_key', 'formSettings')
                ->first();
            $formSettings = json_decode($settings->value, true);
        } else {
            $formSettings = $form->settings;
        }

        if (!$formSettings) {
            return '';
        }


        if ($formSettings && $extraClass = ArrayHelper::get($formSettings, 'form_extra_css_class')) {
            return esc_attr($extraClass);
        }

        return '';
    }

    public static function getNextTabIndex($increment = 1)
    {
        static::$tabIndex += $increment;
        return  static::$tabIndex;
    }

    public static function getFormInstaceClass($formId)
    {
        static::$formInstance += 1;
        return  'ff_form_instance_'.$formId.'_'.static::$formInstance;
    }

    public static function resetTabIndex()
    {
        static::$tabIndex = 0;
    }


    public static function isFluentAdminPage()
    {
        $fluentPages = [
            'fluent_forms',
            'fluent_forms_transfer',
            'fluent_forms_settings',
            'fluent_form_add_ons',
            'fluent_forms_docs'
        ];
        $status = true;
        if (!isset($_GET['page']) || !in_array($_GET['page'], $fluentPages)) {
            $status = false;
        }

        return apply_filters('fluentform_is_admin_page', $status);
    }

}