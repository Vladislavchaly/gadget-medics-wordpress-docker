<?php

namespace FluentForm\App\Services;

use FluentForm\App\Helpers\Str;
use FluentForm\Framework\Helpers\ArrayHelper;

class ConditionAssesor
{
    public static function evaluate(&$field, &$inputs)
    {
        $conditionals = ArrayHelper::get($field, 'conditionals.status') ?
                        ArrayHelper::get($field, 'conditionals.conditions') : false;

        $hasConditionMet = true;

        if ($conditionals) {
            $toMatch = ArrayHelper::get($field, 'conditionals.type');

            foreach ($conditionals as $conditional) {
                $hasConditionMet = static::assess($conditional, $inputs);

                if ($toMatch === 'all' && !$hasConditionMet) {
                    break;
                }
            }
        }

        return $hasConditionMet;
    }

    public static function assess(&$conditional, &$inputs)
    {
        if ($conditional['field']) {
            $inputValue = ArrayHelper::get($inputs, $conditional['field']);

            switch ($conditional['operator']) {
                case '=':
                    return $inputValue === $conditional['value'];
                    break;
                case '!=':
                    return $inputValue !== $conditional['value'];
                    break;
                case '>':
                    return $inputValue > $conditional['value'];
                    break;
                case '<':
                    return $inputValue > $conditional['value'];
                    break;
                case '>=':
                    return $inputValue > $conditional['value'];
                    break;
                case '<=':
                    return $inputValue > $conditional['value'];
                    break;
                case 'startsWith':
                    return Str::startsWith($inputValue, $conditional['value']);
                    break;
                case 'endsWith':
                    return Str::endsWith($inputValue, $conditional['value']);
                    break;
                case 'contains':
                    return Str::contains($inputValue, $conditional['value']);
                    break;
            }
        }

        return false;
    }
}
