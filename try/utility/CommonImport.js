(function() {
    'use strict';
    var script = '';
    script += '<script src="../library/jquery-3.2.1.min.js"></script>';
    script += '<script src="../library/jquery.transit.js"></script>';
    script += '<script src="./UIWidget.js"></script>';
    script += '<script src="./UIWrapper.js"></script>';

    /* jshint evil:true */
    document.write(script);
    document.write('<link rel="stylesheet" type="text/css" href="../css/common.css">');
})();