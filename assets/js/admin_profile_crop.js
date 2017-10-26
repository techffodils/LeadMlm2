var ImageCropping = function () {
	"use strict";    
    var jcrop_api, boundx, boundy;
    var runBasicHandler = function () {//for Cropping DP
        $('#target').Jcrop({
            onChange: showCoords,
            onSelect: showCoords,
            onRelease: clearCoords
        }, function () {
            jcrop_api = this;
        });
        $('#coords').on('change', 'input', function (e) {
            var x1 = $('#x1').val(),
                x2 = $('#x2').val(),
                y1 = $('#y1').val(),
                y2 = $('#y2').val();
            jcrop_api.setSelect([x1, y1, x2, y2]);
        });
    };
    
    var runBasicHandler2 = function () {//for Cropping Cover
        $('#target2').Jcrop({
            onChange: showCoords2,
            onSelect: showCoords2,
            onRelease: clearCoords
        }, function () {
            jcrop_api = this;
        });
        $('#coords').on('change', 'input', function (e) {
            var x11 = $('#x11').val(),
                x22 = $('#x22').val(),
                y11 = $('#y11').val(),
                y22 = $('#y22').val();
            jcrop_api.setSelect([x11, y11, x22, y22]);
        });
    };

   var showCoords = function(c) {
        $('.jcrop-keymgr').hide();
        $('#x1').val(c.x);
        $('#y1').val(c.y);
        $('#x2').val(c.x2);
        $('#y2').val(c.y2);
        $('#w').val(c.w);
        $('#h').val(c.h);
    };

    var clearCoords = function() {
        $('#coords input').val('');
    };
    
    var showCoords2 = function(c) {
       $('.jcrop-keymgr').hide();
        $('#x11').val(c.x);
        $('#y11').val(c.y);
        $('#x22').val(c.x2);
        $('#y22').val(c.y2);
        $('#w2').val(c.w);
        $('#h2').val(c.h);
    };


    return {
        init: function () {
            runBasicHandler();
            runBasicHandler2();
        }
    };
}();