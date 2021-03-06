<?php

namespace FluentForm\App\Modules\Form;

use FluentForm\App\Services\Parser\Form as FormParser;

/**
 * @method array getShortCodeInputs(\stdClass $form, array $with = ['admin_label'])
 * @method array getValidations(\stdClass $form, array $inputs, array $fields = [])
 * @method array getElement(\stdClass $form, string $name, array $with = [])
 * @method boolean hasElement(\stdClass $form, string $name)
 * @method boolean hasRequiredFields(\stdClass $form, array $fields)
 * @method array|null getField(\stdClass $form, string|array $element, string|array $attribute, array $with = [])
 */
class FormFieldsParser
{
    protected static $forms = [];

    public static function getFields($form, $asArray = false)
    {
        return static::parse('fields', $form, $asArray);
    }

    public static function getInputs($form, $with = [])
    {
        return static::parse('inputs', $form, $with);
    }

    public static function getEntryInputs($form, $with = ['admin_label'])
    {
        return static::parse('entry_inputs', $form, $with);
    }

    public static function parse($key, $form, $with)
    {
        if (!isset(static::$forms[$form->id])) {
            static::$forms[$form->id] = [];
        }

        if (!isset(static::$forms[$form->id][$key])) {
            $parser = new FormParser($form);
            $method = str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            static::$forms[$form->id][$key] = $parser->{'get'.$method}($with);
        }

        return static::$forms[$form->id][$key];
    }

    public static function getAdminLabels($form, $fields = [])
    {
        if (!isset(static::$forms[$form->id])) {
            static::$forms[$form->id] = [];
        }

        if (!isset(static::$forms[$form->id]['admin_labels'])) {
            $parser = new FormParser($form);
            static::$forms[$form->id]['admin_labels'] = $parser->getAdminLabels($fields);
        }
        
        return static::$forms[$form->id]['admin_labels'];
    }

    /**
     * Deligate dynamic static method calls to FormParser method.
     * And set the result to the store before returning to dev.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        // The first item of the parameters is expected to contain the form object.
        $form = array_shift($parameters);

        // If the store doesn't have the requested result we'll
        // deletegate the method call to the Parser method.
        // Set the store before returning it to the dev.
        if (!isset(static::$forms[$form->id][$method])) {
            $parser = new FormParser($form);

            static::$forms[$form->id][$method] = call_user_func_array([$parser, $method], $parameters);
        }

        return static::$forms[$form->id][$method];
    }
}
