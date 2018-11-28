<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii2 Extension</h1>
    <br>
</p>

## Installation

To install

```
$ composer require m-comscience/yii2-datepicker-thai "@dev"
```

## Usage

```php
use mcomscience\datepicker\DatePicker;

// usage without model
echo \yii\helpers\Html::label('Date');
echo DatePicker::widget([
	'name' => 'date', 
	'value' => date('d/m/Y'), // 10/10/2561
	'options' => ['placeholder' => 'Select date ...'],
	'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy',
            'language' => 'th',
            'todayHighlight' => true,
            'todayBtn' => true,
        ],
]);
```
