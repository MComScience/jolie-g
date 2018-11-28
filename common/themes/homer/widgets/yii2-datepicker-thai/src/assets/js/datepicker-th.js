/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @package yii2-widgets
 * @subpackage yii2-widget-datepicker
 * @version 1.4.6
 *
 * Extension to bootstrap datepicker to use noconflict approach
 * so that the plugin does not conflict with other jquery plugins
 * of similar name
 *
 * Built for Yii Framework 2.0
 * Author: Kartik Visweswaran
 * For more Yii related demos visit http://demos.krajee.com
 */
var initDPRemove = function () {
}, initDPAddon = function () {
};
(function ($) {
    "use strict";
    initDPRemove = function (id, range) {
        var $id = $('#' + id), $el = $id.parent(), $input;
        $el.find('.kv-date-remove').on('click.kvdatepicker', function () {
            if (range) {
                $el.find('input[type="text"]').each(function () {
                    $(this).datepicker('clearDates').trigger('change');
                });
            } else {
                $el.datepicker('clearDates');
                $input = $el.is('input') ? $el : $el.find('input[type="text"]');
                $input.trigger('change');
            }
        });
    };
    initDPAddon = function (id) {
        var $id = $('#' + id), $el = $id.parent(),
            pickers = '.input-group-addon:not(.kv-date-picker):not(.kv-date-remove)' +
                ',.input-group-text:not(.kv-date-picker):not(.kv-date-remove)';
        $el.find(pickers).each(function () {
            var $addon = $(this);
            $addon.on('click.kvdatepicker', function () {
                $el.datepicker('hide');
            });
        });
        $el.find('.input-group-addon.kv-date-picker').on('click.kvdatepicker', function () {
            $id.focus();
        });
    };
})(window.jQuery);
