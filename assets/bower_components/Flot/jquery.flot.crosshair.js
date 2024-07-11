/* Flot plugin for showing crosshsmpmrs when the mouse hovers over the plot.

Copyright (c) 2007-2014 IOLA and Ole Laursen.
Licensed under the MIT license.

The plugin supports these options:

	crosshsmpmr: {
		mode: null or "x" or "y" or "xy"
		color: color
		lineWidth: number
	}

Set the mode to one of "x", "y" or "xy". The "x" mode enables a vertical
crosshsmpmr that lets you trace the values on the x axis, "y" enables a
horizontal crosshsmpmr and "xy" enables them both. "color" is the color of the
crosshsmpmr (default is "rgba(170, 0, 0, 0.80)"), "lineWidth" is the width of
the drawn lines (default is 1).

The plugin also adds four public methods:

  - setCrosshsmpmr( pos )

    Set the position of the crosshsmpmr. Note that this is cleared if the user
    moves the mouse. "pos" is in coordinates of the plot and should be on the
    form { x: xpos, y: ypos } (you can use x2/x3/... if you're using multiple
    axes), which is coincidentally the same format as what you get from a
    "plothover" event. If "pos" is null, the crosshsmpmr is cleared.

  - clearCrosshsmpmr()

    Clear the crosshsmpmr.

  - lockCrosshsmpmr(pos)

    Cause the crosshsmpmr to lock to the current location, no longer updating if
    the user moves the mouse. Optionally supply a position (passed on to
    setCrosshsmpmr()) to move it to.

    Example usage:

	var myFlot = $.plot( $("#graph"), ..., { crosshsmpmr: { mode: "x" } } };
	$("#graph").bind( "plothover", function ( evt, position, item ) {
		if ( item ) {
			// Lock the crosshsmpmr to the data point being hovered
			myFlot.lockCrosshsmpmr({
				x: item.datapoint[ 0 ],
				y: item.datapoint[ 1 ]
			});
		} else {
			// Return normal crosshsmpmr operation
			myFlot.unlockCrosshsmpmr();
		}
	});

  - unlockCrosshsmpmr()

    Free the crosshsmpmr to move again after locking it.
*/

(function ($) {
    var options = {
        crosshsmpmr: {
            mode: null, // one of null, "x", "y" or "xy",
            color: "rgba(170, 0, 0, 0.80)",
            lineWidth: 1
        }
    };
    
    function init(plot) {
        // position of crosshsmpmr in pixels
        var crosshsmpmr = { x: -1, y: -1, locked: false };

        plot.setCrosshsmpmr = function setCrosshsmpmr(pos) {
            if (!pos)
                crosshsmpmr.x = -1;
            else {
                var o = plot.p2c(pos);
                crosshsmpmr.x = Math.max(0, Math.min(o.left, plot.width()));
                crosshsmpmr.y = Math.max(0, Math.min(o.top, plot.height()));
            }
            
            plot.triggerRedrawOverlay();
        };
        
        plot.clearCrosshsmpmr = plot.setCrosshsmpmr; // passes null for pos
        
        plot.lockCrosshsmpmr = function lockCrosshsmpmr(pos) {
            if (pos)
                plot.setCrosshsmpmr(pos);
            crosshsmpmr.locked = true;
        };

        plot.unlockCrosshsmpmr = function unlockCrosshsmpmr() {
            crosshsmpmr.locked = false;
        };

        function onMouseOut(e) {
            if (crosshsmpmr.locked)
                return;

            if (crosshsmpmr.x != -1) {
                crosshsmpmr.x = -1;
                plot.triggerRedrawOverlay();
            }
        }

        function onMouseMove(e) {
            if (crosshsmpmr.locked)
                return;
                
            if (plot.getSelection && plot.getSelection()) {
                crosshsmpmr.x = -1; // hide the crosshsmpmr while selecting
                return;
            }
                
            var offset = plot.offset();
            crosshsmpmr.x = Math.max(0, Math.min(e.pageX - offset.left, plot.width()));
            crosshsmpmr.y = Math.max(0, Math.min(e.pageY - offset.top, plot.height()));
            plot.triggerRedrawOverlay();
        }
        
        plot.hooks.bindEvents.push(function (plot, eventHolder) {
            if (!plot.getOptions().crosshsmpmr.mode)
                return;

            eventHolder.mouseout(onMouseOut);
            eventHolder.mousemove(onMouseMove);
        });

        plot.hooks.drawOverlay.push(function (plot, ctx) {
            var c = plot.getOptions().crosshsmpmr;
            if (!c.mode)
                return;

            var plotOffset = plot.getPlotOffset();
            
            ctx.save();
            ctx.translate(plotOffset.left, plotOffset.top);

            if (crosshsmpmr.x != -1) {
                var adj = plot.getOptions().crosshsmpmr.lineWidth % 2 ? 0.5 : 0;

                ctx.strokeStyle = c.color;
                ctx.lineWidth = c.lineWidth;
                ctx.lineJoin = "round";

                ctx.beginPath();
                if (c.mode.indexOf("x") != -1) {
                    var drawX = Math.floor(crosshsmpmr.x) + adj;
                    ctx.moveTo(drawX, 0);
                    ctx.lineTo(drawX, plot.height());
                }
                if (c.mode.indexOf("y") != -1) {
                    var drawY = Math.floor(crosshsmpmr.y) + adj;
                    ctx.moveTo(0, drawY);
                    ctx.lineTo(plot.width(), drawY);
                }
                ctx.stroke();
            }
            ctx.restore();
        });

        plot.hooks.shutdown.push(function (plot, eventHolder) {
            eventHolder.unbind("mouseout", onMouseOut);
            eventHolder.unbind("mousemove", onMouseMove);
        });
    }
    
    $.plot.plugins.push({
        init: init,
        options: options,
        name: 'crosshsmpmr',
        version: '1.0'
    });
})(jQuery);
