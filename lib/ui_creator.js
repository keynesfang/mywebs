/**
 * For bootstrap-4.0.0
 * you should import bootstrap.css and bootstrap.js first
 */

(function ($, window, document, undefined) {
    'use strict';
    var pluginName = 'ui_create';
    var _default = {};

    _default.settings = {
        color: '#000000',
        backColor: '#FFFFFF',
        borderColor: '#dddddd',
        onHoverColor: '#F5F5F5',
        selectedColor: '#FFFFFF',
        selectedBackColor: '#428bca'
    };

    var UI = function (options) {
        this.init(options);

        return {
            options: this.options,
            init: $.proxy(this.init, this)
        }
    };

    UI.prototype.init = function (options) {
        if(typeof(options.elements) != "object") {
            alert("Initial Fail!");
            return false;
        }
        this.initElement(options.elements);
    };
    
    UI.prototype.initElement = function (element) {
        var _this = this;
        $.each(element.elements, function (index, element) {
            alert(element.elementId);
            if (element.elements) {
                _this.initElement(element);
            }
        });
    };

    $.fn[pluginName] = function (options) {
        this.addClass(options.elements.elementClass);
        new UI(options);
    };
})(jQuery, window, document);