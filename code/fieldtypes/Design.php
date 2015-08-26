<?php

/**
 * Class Design
 *
 * @property Text InlineStyle
 */
class Design extends Text
{

    private static $casting = array(
        'InlineStyle' => 'Text'
    );

    /**
     * @param null $additions
     * @return bool|string
     */
    public function InlineStyle($additions = null)
    {
        if (isset($this->value)) {
            $out = '';
            $properties = json_decode($this->value);
            foreach ($properties as $property => $value) {
                if (!is_array($value)) {
                    /**
                     * Only parse values, not selectors.
                     */
                    if ($property != 'selector' && $value) {
                        $out .= $property . ': ' . $value . ';';
                    }
                }
            }
            if ((string)$additions) {
                $out .= $additions;
            }
            return ' style="' . Convert::raw2xml($out) . '"';
        }
        return false;
    }

}