#Silverstripe Design Field
A field that can generate inline styles for an object.
The field is saved into the database as a JSON string. Here's an example of the output:
```json
{  
   "selector":".myobject",
   "padding-top":"100px",
   "padding-bottom":"100px",
   "margin-top":"10px",
   "margin-bottom":"10px",
   "background":"#ffffff"
}
```
###Methods Summary
- | -
---- | ----
public | __construct($name, $title = null, $selector = null, $fields = null, $value = null)
The *$fields* parameter supports pretty much all silverstripe fields, bar UploadFields and FileFields.
###Screenshot
![Design Field](https://cloud.githubusercontent.com/assets/1136811/9507672/e9ae41f4-4ca3-11e5-8ef4-3d5ecf36afc9.png)
###Example Usage
```php
private static $db = array(
  'MyObject' => 'Design'
);
```

```php
DesignField::create('MyObject', _t('DesignField.MyObject', 'My Object'),
  '.myobject',
  array(
      'padding-top' => 'TextField',
      'padding-right' => 'TextField',
      'padding-bottom' => 'TextField',
      'padding-left' => 'TextField',
      'margin-top' => 'TextField',
      'margin-right' => 'TextField',
      'margin-bottom' => 'TextField',
      'margin-left' => 'TextField',
      'color' => 'ColorField',
      'background' => 'ColorField',
      'font-size' => array(
          'type' => 'DropdownField',
          'value' => array(
              '16px',
              '25px',
              '36px'
          )
      )
  ));
```
Return the string of styles
```php
$this->dbObject('MyObject')->InlineStyle();
```
