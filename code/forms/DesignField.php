<?php

/**
 * Class DesignField
 */
class DesignField extends FormField
{

    /**
     * @var null|string
     */
    protected $selector;

    /**
     * @var array|null
     */
    protected $fields;

    /**
     * @var
     */
    protected $children;

    /**
     * @param string $name
     * @param null $title
     * @param null $value
     * @param null $selector
     * @param null $fields
     */
    public function __construct($name, $title = null, $selector = null, $fields = null, $value = null)
    {
        /**
         * Selector
         */
        $this->selector = ($selector === null) ? '' : $selector;

        /**
         * Fields
         */
        $this->fields = ($fields === null) ? array(
            'padding-top' => 'TextField',
            'padding-right' => 'TextField',
            'padding-bottom' => 'TextField',
            'padding-left' => 'TextField',
            'margin-top' => 'TextField',
            'margin-right' => 'TextField',
            'margin-bottom' => 'TextField',
            'margin-left' => 'TextField',
            'color' => 'ColorField',
            'background' => 'ColorField'
        ) : $fields;

        /**
         * Create form fields for the Field() method
         */
        $this->children = FieldList::create();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $field) {
                /**
                 * If the field has a set value
                 */
                if (is_array($field)) {
                    $output = $field['type']::create($name . '[' . $key . ']', $key, $field['value']);
                } else {
                    $output = $field::create($name . '[' . $key . ']', $key);
                }
                $this->children->push(
                    $output
                );
            }
        }

        /**
         * If there is any sizing fields used,
         * add the "has-sizing" class to the field.
         */
        $sizingKeys = array(
            'margin-top',
            'margin-right',
            'margin-bottom',
            'margin-left',
            'padding-top',
            'padding-right',
            'padding-bottom',
            'padding-left'
        );
        for ($i = 0; $i < count($sizingKeys); $i++) {
            if (array_key_exists($sizingKeys[$i], $this->fields)) {
                $this->addExtraClass('has-sizing');
                break;
            }
        }

        parent::__construct($name, $title, $value);
    }

    /**
     * Generate Field
     *
     * @param array $properties
     * @return string
     */
    public function Field($properties = array())
    {
        /**
         * Loop through the Fieldlist and create
         * fields for the CMS
         */
        $content = '';
        $valueArray = json_decode($this->value);
        foreach ($this->children as $field) {
            $fieldName = $field->title;
            isset($valueArray->$fieldName) ? $field->setValue($valueArray->$fieldName) : $field->setValue('');
            $field->addExtraClass($fieldName);
            $content .= $field->FieldHolder();
        }

        return $content;
    }

    /**
     * Save
     *
     * @param DataObjectInterface $record
     */
    public function saveInto(DataObjectInterface $record)
    {
        $value = $this->value;

        /**
         * If the $this->value has multiple values.
         */
        if (is_array($value)) {
            $combinedArray = array(
                'selector' => $this->selector
            );
            if (is_array($this->fields)) {
                foreach ($this->fields as $key => $item) {
                    $combinedArray = array_merge($combinedArray, array(
                        $key => $value[$key]
                    ));
                }
            }
            $return = json_encode($combinedArray);
        } else {
            $return = $value;
        }
        /**
         * If name exists:
         * Save content from a form into a field on this data object.
         */
        if ($this->name) {
            $record->setCastedField($this->name, $return);
        }
    }

}