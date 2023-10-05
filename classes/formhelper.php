<?php

namespace Anstech;

use Fuel\Core\Arr;

class FormHelper
{
    protected static $form_fields = [];

    public static function forge($fields = [])
    {
        return new static($fields);
    }

    public function __construct($fields = [])
    {
        if ($fields) {
            static::$form_fields = $fields;
        }
    }


    protected static function formFields()
    {
        return static::$form_fields;
    }


    public static function formElements($output = 'form')
    {
        $fields = static::formFields();

        if ($output === 'form') {
            foreach ($fields as $key => $field) {
                // Encode JSON validation rules
                if ($validation = Arr::get($field, 'validation')) {
                    foreach ($validation as $rule) {
                        foreach ($rule as $type => $parameters) {
                            if (($type === 'required') && $parameters && ! isset($field['required'])) {
                                $fields[$key]['required'] = $parameters;
                            }
                        }
                    }

                    $fields[$key]['validation'] = json_encode($validation);
                }

                // Type file for rendering
                switch (Arr::get($field, 'type')) {
                    case 'button':
                    case 'submit':
                        $type = 'button';
                        break;

                    case 'switch':
                        $type = 'switch';
                        break;

                    case 'password':
                    case 'text':
                    default:
                        $type = 'text';
                        break;
                }

                $fields[$key][$type] = true;

                // Visibility
                if ($visibility = Arr::get($field, 'visibility')) {
                    if (in_array('hidden', $visibility)) {
                        unset($fields[$key]);
                    }
                }
            }

            return array_values($fields);
        }

        return $fields;
    }
}
