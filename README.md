# php-html library


[![Build Status](https://travis-ci.com/agrism/php-html.svg?branch=master)](https://travis-ci.com/agrism/php-html)
[![Latest Stable Version](https://poser.pugx.org/agrism/php-html/v/stable.svg)](https://packagist.org/packages/agrism/php-html)
[![Total Downloads](https://poser.pugx.org/agrism/php-html/downloads.svg)](https://packagist.org/packages/agrism/php-html)
[![License](https://poser.pugx.org/agrism/php-html/license.svg)](https://packagist.org/packages/agrism/php-html)
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fagrism%2Fphp-html.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2Fagrism%2Fphp-html?ref=badge_shield)
[![codecov](https://codecov.io/gh/agrism/php-html/branch/master/graph/badge.svg?token=NRR5TZ70QL)](https://codecov.io/gh/agrism/php-html)

### Installing

You can clone this git repository into your project 

```
git clone git://github.com/agrism/php-html.git
```

or you can use composer

```
composer require agrism/php-html
```


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
  ->render();
```
#### Example 1 result:
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

#### Example 2 result:
```html
<table border="13">
    <thead>
        <tr border="1" style="background-color:brown;">
            <th>title1</th>
            <th>title2</th>
            <th>title3</th>
        </tr>
        <tr border="1" style="background-color:blue;">
            <th>title11</th>
            <th>title22</th>
            <th>title33</th>
        </tr>
    </thead>
    <tbody>
        <tr style="background-color:yellowgreen;">
            <td>p1</td>
            <td>p2</td>
            <td>p3</td>
        </tr>
        <tr style="background-color:yellowgreen;">
            <td>p11</td>
            <td>p22</td>
            <td>p33</td>
        </tr>
        <tr style="background-color:red;">
            <td>a</td>
            <td>b</td>
            <td>c</td>
        </tr>
        <tr style="background-color:yellow;font-size:28px;color:blue;text-align:right">
            <td>a1</td>
            <td>b1</td>
            <td>c1</td>
        </tr>
        <tr>
            <td>a2</td>
            <td>b2</td>
            <td>c2</td>
        </tr>
    </tbody>
</table>
```

#### Example 3
```php
<?php

use Agrism\PhpHtml\Table\Table;

$nestedTable = Table::factory()
	->addAttribute('border', 13)
	->addRow(['A', 'B'])
	->getOutput();

Table::factory()
	->addAttribute('border', 1)
	->addRow([1,2,3, $nestedTable])
	->render();
```

#### Example 3 result:
```html
<table border="1">
    <thead></thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>
                <table border="13">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <td>A</td>
                            <td>B</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
```
## License
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fagrism%2Fphp-html.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Fagrism%2Fphp-html?ref=badge_large)