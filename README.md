# php-html library


[![Build Status](https://travis-ci.com/agrism/php-html.svg?branch=master)](https://travis-ci.com/agrism/php-html)
[![Latest Stable Version](https://poser.pugx.org/agrism/php-html/v/stable.svg)](https://packagist.org/packages/agrism/php-html)
[![Total Downloads](https://poser.pugx.org/agrism/php-html/downloads.svg)](https://packagist.org/packages/agrism/php-html)
[![License](https://poser.pugx.org/agrism/php-html/license.svg)](https://packagist.org/packages/agrism/php-html)


### Usage:

#### Example 1
```php
<?php

use Agrism\PhpHtml\Builder\Attribute;
use Agrism\PhpHtml\Builder\Element;

$table = Element::factory('table')
  ->addAttribute(Attribute::factory('border')->setValue(1))
  ->addContent(
    Element::factory('tr')->addContent(
        Element::factory('td')
          ->addContent(
            Element::factory()
                ->addValue('A')
                    ->addValue('B')
                    ->addValue('C')
          )
          ->addContent(
            Element::factory('table')
              ->addAttribute(Attribute::factory('border', 3))
              ->addAttribute(Attribute::factory('style', 'background-color:red;'))
              ->addContent(
                Element::factory('tr')
                 ->addContent(
                   Element::factory('td')
                    ->addContent(
                      Element::factory()->addValue(5)
                    )
                 )
                 ->addContent(
                   Element::factory('td')
                    ->addAttribute(Attribute::factory('style', 'background-color:blue;'))
                    ->addContent(
                      Element::factory()->addValue(15)
                    )
                 )
              )
          )
       )
);

Element::factory('html')
  ->addContent($table)
  ->addContent($table)
  ->setEchoValue()
  ->render()
  ->doNothing();
```
#### Result:
```html
<html>
    <table border="1">
        <tr>
            <td>ABC
                <table border="3" style="background-color:red;">
                    <tr>
                        <td>5</td>
                        <td style="background-color:blue;">15</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table border="1">
        <tr>
            <td>ABC
                <table border="3" style="background-color:red;">
                    <tr>
                        <td>5</td>
                        <td style="background-color:blue;">15</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</html>
```


#### Example 2
```php
<?php

use Agrism\PhpHtml\Table\Table;

Table::factory()
  ->addAttribute('border', 13)
  ->addRows([
      ['p1', 'p2', 'p3'],
      ['p11', 'p22', 'p33'],
    ], 
    ['style' => 'background-color:yellowgreen;']
  )
  ->addHead(['title1', 'title2', 'title3'], ['border' => 1, 'style' => 'background-color:brown;'])
  ->addHead(['title11', 'title22', 'title33'], ['border' => 1, 'style' => 'background-color:blue;'])
  ->addRow(['a', 'b', 'c'], ['style' => 'background-color:red;'])
  ->addRow(['a1', 'b1', 'c1'], ['style' => 'background-color:yellow;font-size:28px;color:blue;text-align:right'])
  ->addRow(['a2', 'b2', 'c2'])
  ->render();     

```

#### Result:
```html
<table border="13">
    <tbody>
        <tr style="background-color:yellowgreen;">
            <td>p1</td>
            <td>p2</td>
            <td>p3</td>
        </tr>
    </tbody>
    <tbody>
        <tr style="background-color:yellowgreen;">
            <td>p11</td>
            <td>p22</td>
            <td>p33</td>
        </tr>
    </tbody>
    <thead>
        <tr border="1" style="background-color:brown;">
            <th>title1</th>
            <th>title2</th>
            <th>title3</th>
        </tr>
    </thead>
    <thead>
        <tr border="1" style="background-color:blue;">
            <th>title11</th>
            <th>title22</th>
            <th>title33</th>
        </tr>
    </thead>
    <tbody>
        <tr style="background-color:red;">
            <td>a</td>
            <td>b</td>
            <td>c</td>
        </tr>
    </tbody>
    <tbody>
        <tr style="background-color:yellow;font-size:28px;color:blue;text-align:right">
            <td>a1</td>
            <td>b1</td>
            <td>c1</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>a2</td>
            <td>b2</td>
            <td>c2</td>
        </tr>
    </tbody>
</table>
```
