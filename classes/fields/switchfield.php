<?php

namespace Anstech\Form\Fields;

class SwitchField
{
    public static function convertToSwitch(&$field_properties)
    {
        // Selected option should be the value
        $selected_value = $field_properties['form']['value'];
        $selected_label = $field_properties['form']['options'][$selected_value];

        // Remaining option is default
        unset($field_properties['form']['options'][$selected_value]);
        $default_value = key($field_properties['form']['options']);

        $field_properties['form']['class'] = 'form-check-input';
        $field_properties['form']['options'] = [$selected_value => $selected_label];
        $field_properties['form']['sub_type'] = 'switch';
        $field_properties['form']['type'] = 'checkbox';
        $field_properties['default'] = $default_value;                  // Change default to 'no'
        unset($field_properties['null']);                               // Remove 'null' check
        static::removeRequired($field_properties['validation']);       // Remove 'required'
    }


    protected static function removeRequired(&$validation)
    {
        $validation = array_filter($validation, function ($rule) {
            if (is_string($rule) && ($rule === 'required')) {
                return false;
            }

            return true;
        });
    }
}
