<?php
use homer\widgets\Modal;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
    'options' => ['class' => 'modal', 'tabindex' => false,],
    'size' => 'modal-lg',
]);

Modal::end();