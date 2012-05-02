// Copyright 2006 Google Inc.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

/*
---
description: Graphing/chart tool for mootools 1.2

license: Apache License, Version 2.0

authors:
- Brett Dixon

requires: 
  core/1.2.5:Core

provides: [MilkChart.Column, MilkChart.Bar, MilkChart.Line, MilkChart.Scatter, MilkChart.Pie]

...
*/

// Add our namespace
var MilkChart;

// Simple Point class
var Point = new Class({
    initialize: function(x,y) {
        this.x = x || 0;
        this.y = y || 0;
    }
});

function contains(a, obj) {
    for (var i = 0; i < a.length; i++) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}

function date_to_float(date) {
	// running total for dates per month
    var reg_year = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
    var leap_year = [0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335];
    d = new Date(date);
    var days = d.getDate();
    var month = d.getMonth();
    var year = d.getFullYear();
	
	// year is before decimal, after decimal is the day of the year/ total days in the year
    if(year % 4 == 0) {
        return 1.0*year + (reg_year[month] + days)/ 365.0;
    }
    else {
        return 1.0*year + (leap_year[month] + days) / 366.0;
    }
}

function float_to_date(date) {
    var reg_year = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
    var leap_year = [0, 31, 60, 91, 121, 152, 182, 213, 244, 274, 305, 335];
    var year = Math.floor(date);
    var month = 0;
    var day = 0;
    var i = 0;
    date -= year;
    if((365 * date) % 4 == 0) { // not a leap year
        while(365*date > reg_year[i]) {
            i++;
        }
        month = i;
        day = 365*date - leap_year[i];
        return new Date(year, month, day);
    }
    else {
        while(366*date > leap_year[i]) {
            i++;
        }
        month = i;
        day = 366*date - leap_year[i];
        return new Date(year, month, day);
    }
}



MilkChart = new Class({
    Implements: [Options,Events],
    options: {
        width: 480,
        height: 290,
		colors: ['#4f81bd', '#c0504d', '#9bbb59', '#8064a2', '#4198af', '#db843d'],
        padding: 12,
        font: "Verdana",
        fontColor: "#000000",
        fontSize: 10,
        background: "#FFFFFF",
        chartLineColor: "#878787",
        chartLineWeight: 1,
        border: true,
        borderWeight: 1,
        borderColor: "#878787",
        titleSize: 18,
        titleFont: "Verdana",
        titleColor: "#000000",
        showRowNames: true,
        showValues: true,
        showKey: true,
		useZero: true,
		copy: false,
		data: {}
    },
    initialize: function(el, options) {
        this.setOptions(options);
        this.element = document.id(el);
        this.width = this.options.width;
        this.height = this.options.height;
        this.container = new Element('div').inject(this.element.getParent());
		this.container.setStyles({width:this.width, height:this.height})
        this._canvas = new Element('canvas', {width:this.options.width,height:this.options.height}).inject(this.container);
        this.ctx = this._canvas.getContext('2d');
        this.colNames = [];
        this.rowNames = [];
		this.rowCount = this.element.getElement('thead').getChildren()[0].getChildren().length;
		// Hacky, oh the shame!
        this.minY = (this.options.useZero) ? 0 : 10000000000;
        this.maxY = 0;
        this.rows = [];
        this.options.title = false || this.element.title;
        this.bounds = [new Point(), new Point(this.width, this.height)];
        this.chartWidth = 0;
        this.chartHeight = 0;
        this.keyPadding = this.width * .2;
        this.rowPadding = this.height * .1;
		this.colors = this.__getColors(this.options.colors);
		this.shapes = [];
		// This could be done in a list, but an object is more readable
        MilkChart.Shapes.each(function(shape) {
            this.shapes.push(shape);
        }.bind(this));
    },
    prepareCanvas: function() {
		if (!this.options.copy) {
			this.element.setStyle('display', 'none');
		}
        
        // Fill our canvas' bg color
        this.ctx.fillStyle = this.options.background;
        this.ctx.fillRect(0, 0, this.width, this.height);
        
        this.ctx.font = this.options.fontSize + "px " + this.options.font;
        
        if (this.options.border) {
			this.ctx.lineWeight = this.options.borderWeight;
            this.ctx.strokeRect(0.5,0.5,this.width-1, this.height-1);
        }
        
        if (this.options.showValues) {
            // Accomodate the width of the values column
            this.bounds[0].x += this.getValueColumnWidth();
        }
        
        this.bounds[0].x += this.options.padding;
        this.bounds[0].y += this.options.padding;
        this.bounds[1].x -= this.options.padding*2;
        this.bounds[1].y -= this.options.padding*2;
        
        if (this.options.showKey) {
            // Apply key padding
            var longestName = "";
            this.colNames.each(function(col) {
            	if (col.length > longestName.length) {
	            	longestName = String(col);
	            }
            });
            var colorSquareWidth = 14
            this.keyPadding = this.ctx.measureText(longestName).width + colorSquareWidth;
            this.bounds[1].x -= this.keyPadding;
            // Set key bounds
            var chartKeyPadding = 1.02;
            this.keyBounds = [
                new Point(this.bounds[1].x * chartKeyPadding, this.bounds[0].y),
                new Point(this.keyPadding, this.bounds[1].y)
            ];
        }
        
        if (this.options.title) {
            titleHeight = this.bounds[0].y + this.height * .1;
            this.bounds[0].y = titleHeight;
            this.titleBounds = [new Point(this.bounds[0].x, 0), new Point(this.bounds[1].x, titleHeight)];
            this.drawTitle();
        }
        if (this.options.showRowNames) {
			this.ctx.font = this.options.fontSize + "px " + this.options.font;
			this.rowPadding = (this.ctx.measureText(this.longestRowName).width > ((this.bounds[1].x - this.bounds[0].x) / this.rows.length)) ? this.ctx.measureText(this.longestRowName).width : this.height * 0.1;
			this.bounds[1].y -= this.rowPadding;
		}
		else {
			this.rowPadding = 0;
		}
        
        this.chartWidth = this.bounds[1].x - this.bounds[0].x;
        this.chartHeight = this.bounds[1].y - this.bounds[0].y;
    },
    getValueColumnWidth: function() {
        return this.ctx.measureText(String(this.maxY)).width;
    },
    drawTitle: function() {
		var titleHeightRatio = 1.25;
        var titleHeight = this.options.titleSize * titleHeightRatio;
        this.ctx.textAlign = 'center';
        this.ctx.font = this.options.titleSize + "px " + this.options.titleFont;
        this.ctx.fillStyle = this.options.titleColor;
        this.ctx.fillText(this.options.title, this.bounds[0].x + (this.bounds[1].x - this.bounds[0].x)/2, titleHeight, this.chartWidth);
    },
    drawAxes: function() {
        /**********************************
         * Draws X & Y axes
         *********************************/
        this.ctx.beginPath();
        this.ctx.strokeStyle = this.options.chartLineColor;
        // The +.5 is to put lines between pixels so they draw sharply
        this.ctx.moveTo(this.bounds[0].x+.5, this.bounds[0].y+.5);
        this.ctx.lineTo(this.bounds[0].x+.5, this.bounds[1].y+.5);
        this.ctx.moveTo(this.bounds[0].x+.5, this.bounds[1].y+.5);
        this.ctx.lineTo(this.bounds[1].x+.5, this.bounds[1].y+.5);
        this.ctx.stroke();
    },
    drawValueLines: function() {
        /**********************************
         * Draws horizontal value lines
         *
         * Finds the line values based on Array dist, and sets the numbers of lines
         * to use.  This formula is similar how excel handles it.  Not sure if there
         * is a cleaner way of creating this type of list.
         *
         * Next it draws in the lines and the values.  Also sets the ratio to apply
         * to the values in the table.
         *********************************/
		
		var dist = [1, 2, 5, 10, 20, 50, 100, 150, 500, 1000, 1500, 2000, 2500, 5000, 10000];
		var maxLines = 9;
		var i = 0;
		this.chartLines = 1;
		delta = Math.floor((this.maxY - this.minY));
		while (Math.floor((delta / dist[i])) > maxLines) {
			i++;
		}
		this.chartLines = Math.floor((delta / dist[i])) + 2;
		var mult = dist[i];
		var negativeScale = (this.minY < 0) ? (mult + this.minY) : 0;
		
		// Set the bounds ratio
		this.ratio = (this.chartHeight) / ((this.chartLines - 1) * mult);
		
		this.ctx.font = this.options.fontSize + "px " + this.options.font;
		this.ctx.textAlign = "right";
		this.ctx.fillStyle = this.options.fontColor;
		
		var boundsHeight = this.bounds[1].y - this.bounds[0].y;
		var lineHeight = Math.floor(boundsHeight / (this.chartLines - 1));
		
		for (i = 0; i < this.chartLines; i++) {
			this.ctx.fillStyle = this.options.fontColor;
			var lineY = this.bounds[1].y - (i * lineHeight);
			
			var lineValue = (this.chartLines * mult) - ((this.chartLines - i) * mult) + this.minY - negativeScale;
			this.ctx.beginPath();
			// Correct values for crisp lines
			lineY += .5;
			this.ctx.moveTo(this.bounds[0].x - 4, lineY);
			if (this.options.showValues) {
				var offsetX = 8;
				var offsetY = 3
				this.ctx.fillText(String(lineValue), this.bounds[0].x - offsetX, lineY + offsetY);
			}
			this.ctx.lineTo(this.bounds[1].x, lineY);
			this.ctx.stroke();
			}
    },
    getData: function() {
        /**********************************
         * This function should be overridden for each new graph type as the data
         * is represented different for the different graphs.
         *********************************/
		
		return null;
    },
    
    draw: function() {
        // Abstract
        /**********************************
         * This function should be overridden for each new graph type as the data
         * is represented different for the different graphs.
         *********************************/
		
		return null;
    },
    drawKey: function() {
        // Abstract
        /**********************************
         * This function should be overridden for each new graph type.  The keys are
         * similar but the icons that represent the columns are not.
         *********************************/
		
		return null;
    },
	__getColors: function(clr) {
		/**********************************
		 * This accepts a single color to be a monochromatic gradient
		 * that will go from the given color to white, two colors as
		 * a gradient between the two, or use the default colors.
		 * 
		 * Keyword args may be implemented for convenience.
		 * i.e. "blue", "orange", etc.
		 */
		
		var colors = [];
		if (clr.length == 1 || clr.length == 2) {
			var min = new Color(clr[0]);
			// We either use the second color to get a gradient or use white mixed with 20% of the first color
			var max = (clr.length == 2) ? new Color(clr[1]) : new Color("#ffffff").mix(clr[0], 20);
			var delta = [(max[0] - min[0])/this.rowCount,(max[1] - min[1])/this.rowCount,(max[2] - min[2])/this.rowCount];
			var startColor = min;
			
			for (i=0;i<this.rowCount;i++) {
				colors.push(startColor.rgbToHex());
				for (j=0;j<delta.length;j++) {
					startColor[j] += parseInt(delta[j]);
				}
			}
		}
		else {
			//Use default, but make sure we have enough!
			var mix = 0;
			var colorArray = clr.slice(0);
			while (colors.length != this.rowCount) {
				if (colorArray.length == 0) {
					colorArray = clr.slice(0);
					mix += 20;
				}
				newColor = new Color(colorArray.shift()).mix("#ffffff", mix);
				colors.push(newColor.rgbToHex());
				
			}
		}
		
		return colors;
	}
});

// Shapes for tick marks
MilkChart.Shapes = new Hash({
	/*********************************************
	 * This object is here for easy reference. Feel
	 * free to add any additional shapes here.
	 ********************************************/
    square: function(ctx, x, y, size, color) {
        ctx.fillStyle = color;
        ctx.fillRect(x-(size/2), y-(size/2), size, size);
    },
    circle: function(ctx, x, y, size, color) {
        ctx.fillStyle = color;
        ctx.beginPath();
        ctx.arc(x, y, size/2, 0, (Math.PI/180)*360, true);
        ctx.closePath();
        ctx.fill();
    },
    triangle: function(ctx, x,y,size,color) {
        ctx.fillStyle = color;
        ctx.beginPath();
        x -= size/2;
        y -= size/2;
        lr = new Point(x+size, y+size);
        ctx.moveTo(x, lr.y);
        ctx.lineTo(x + (size/2), y);
        ctx.lineTo(lr.x, lr.y);
        ctx.closePath();
        ctx.fill();
    },
    cross: function(ctx,x,y,size,color) {
        x -= size/2;
        y -= size/2;
        ctx.strokeStyle = color;
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.moveTo(x,y);
        ctx.lineTo(x+size, y+size);
        ctx.moveTo(x,y+size);
        ctx.lineTo(x+size,y);
        ctx.closePath();
        ctx.stroke();
    },
    diamond: function(ctx,x,y,size,color) {
        x -= size/2;
        y -= size/2;
        ctx.fillStyle = color;
        ctx.beginPath();
        ctx.moveTo(x+(size/2), y);
        ctx.lineTo(x+size,y+(size/2));
        ctx.lineTo(x+(size/2),y+size);
        ctx.lineTo(x, y+(size/2));
        ctx.closePath();
        ctx.fill();
    }
})
MilkChart.escape = function(str) {
	str = String(str);
	var patterns = [
		[/\&amp;/g,'&'],
		[/\&lt;/g,'<'],
		[/\&gt;/g,'>']
	]
	patterns.each(function(item) {
		str = str.replace(item[0], item[1]);
	})
	
	return str
}

MilkChart.Base_rpb = new Class({
	Implements: [Options,Events],
		options: {
			width: 1200,	// default width for the graph
			height: 800,	// default height for the graph
			colors: ['#4f81bd', '#c0504d', '#9bbb59', '#8064a2', '#4198af', '#db843d'],
			padding: 12,
			font: "Verdana",
			fontColor: "#000000",
			fontSize: 10,
			background: "#FFFFFF",
			chartLineColor: "#878787",
			chartLineWeight: 1,
			border: true,
			borderWeight: 1,
			borderColor: "#878787",
			titleSize: 18,
			titleFont: "Verdana",
			titleColor: "#000000",
			showPoints: true,
			showLines: true,
			bubble: true,
			showRowNames: true,
			showValues: true,
			showKey: true,
			useZero: true,
			copy: false,
			rowPrefix: "",
			ignoreFirstColumn: false,
			mapping: false,
			fillArea: false,
			motion: false,
			xaxis: -1,
			yaxis: -1,
			color: -1,
			size: -1,
			time: -1,
			location: -1
		},
		setStep: function(ev) {
			var value = ev.newValue;
			var timestep_approx = this.minTime + Number(value)*(this.maxTime - this.minTime)/1000;
			var i =0;
			var disp = 1000;
			var ind = -1;
			for(i = 0; i < this.data.time.length; i++) {
				var t_disp = Math.abs(this.data.time[i] - timestep_approx);
				if(t_disp < disp) {
					disp = t_disp;
					ind = i;
				}
			}
			if(ind != -1) {
				this.timestep = this.data.time[ind];
				this.render();
			}
		},
		// this function sets up the graphing options
		initialize: function(el, cur, options) {
			this.setOptions(options);	// initialize the options
			this.ssc = -1;	// series column
			this.tc = this.options.time;	// time column
			this.xc = this.options.xaxis;	// x column
			this.sc = this.options.size;	// size column
			this.cc = this.options.color;	// color column
			this.yc = [this.options.yaxis];	// y column(s)
			
			this.element = document.id(el);
			this.width = this.options.width;
			this.height = this.options.height;
			//this.container = (this.element.get('tag') == "table") ? new Element('div').inject(this.element.getParent()) : this.element;
			this.container = document.id("drawpane");
			this.container.setStyles({width:this.width, height:this.height, display: 'inline-block'})
			this._canvas = new Element('canvas', {width:this.options.width,height:this.options.height}).inject(this.container);
			this.ctx = this._canvas.getContext('2d');
			this.grid_width = this.options.width - 2*this.options.padding;
			this.grid_height = this.options.height - 2*this.options.padding;
			this.canvas_init = false;

			this.grid_left_offset = this.options.padding;
			this.grid_right_offset = this.options.padding;
			this.grid_upper_offset = this.options.padding;
			this.grid_lower_offset = this.options.padding;

			// initialize column markers
			this.x_col = this.xc;
			this.color_col = this.cc;
			this.size_col = this.sc;
			this.time_col = this.tc;
			this.series_col = this.ssc;

			// initialize data variables
			this.maxX = 0;
			this.maxY = 0;
			this.minX = 0;
			this.minY = 0;
			this.maxSize = 0;
			this.minSize = 0;
			
			this.maxColor = 0;
			this.minColor = 0;
			
			this.timestep = 0;
			
			this.data = {
				title: this.element.title,
				xLabel: '',
				yLabel: '',
				legend: [],
				rows: [],
				size: [],
				x: [],
				y: [],
				time: [],
				series: [],
				color: []
			}
			
			// establish bounds
			this.bounds = [new Point(), new Point(this.width, this.height)];
			
			// read the data from the table
			this.getData();
			
			if (this.options.motion && cur && cur.firstChild.addEventListener) {
				cur.firstChild.addEventListener('DOMCharacterDataModified', function(ev) { 
					// this function executes at a larger scope... 
					
					// render the graph
					window.mychart.setStep(ev);
				}, false);
			}
			
			
			
			// load the map image if needed
			if (this.options.mapping) {
				this.img=new Image();
				this.img.onload = function() { 
					// this function executes at a larger scope... 
					
					// render the graph
					window.mychart.render();
				};
				this.img.src="img/colordetail1.png";
			}
			else {
				// render the graph
				this.render();
			}
		},
		prepareCanvas: function() {
					
			// Fill our canvas' bg color
			this.ctx.fillStyle = this.options.background;
			this.ctx.fillRect(0, 0, this.width, this.height);
			
			// sets the default font
			this.ctx.font = this.options.fontSize + "px " + this.options.font;
			
			if (this.options.border) {
				this.ctx.lineWeight = this.options.borderWeight;
				this.ctx.strokeRect(0.5,0.5,this.width-1, this.height-1);
			}
			
			// if labels are required, determine width of values to add padding
			if (this.options.showValues) {
				// Accomodate the width of the values column
				this.bounds[0].x += this.getValueColumnWidth();
			}
			
			// if the legend is shown, determine width of legend
			if (this.options.showKey) {
				// Apply key padding
				var longestName = "";
				this.data.legend.each(function(col) {
					if (col.length > longestName.length) {
						longestName = String(col);
					}
				});
				var colorSquareWidth = 14
				this.keyPadding = this.ctx.measureText(longestName).width + colorSquareWidth;
				this.bounds[1].x -= this.keyPadding+ 5;
				// Set key bounds
				var chartKeyPadding = 1.02;
				this.keyBounds = [
					new Point(this.bounds[1].x + chartKeyPadding, this.bounds[0].y),
					new Point(this.keyPadding, this.bounds[1].y)
				];
			}
			
			// draw the title
			if (this.data.title) {
				titleHeight = this.bounds[0].y + this.height * .1;
				this.bounds[0].y += titleHeight;
				this.titleBounds = [new Point(this.bounds[0].x, 0), new Point(this.bounds[1].x, titleHeight)];
				this.drawTitle();
			}
			
			// draw the x-axis label
			if (this.data.xLabel && !this.options.mapping) {
				this.bounds[1].y -= titleHeight/2;
				this.x_labelBounds = [new Point(this.bounds[0].x, this.bounds[1].y ), new Point(this.bounds[1].x, this.bounds[1].y + titleHeight/4)];
				this.drawXLabel();
			}
			
			// draw the y-axis label
			if (this.data.yLabel && !this.options.mapping) {
				var y_width = this.bounds[0].x + 15;
				this.y_labelBounds = [new Point(this.bounds[0].x + 7.5, this.bounds[0].y), new Point(this.bounds[0].x + y_width, this.bounds[1].y)];
				this.bounds[0].x += y_width;
				this.drawYLabel();
			}
			
			// finish the bounds
			this.bounds[0].x += this.options.padding;
			this.bounds[0].y += this.options.padding;
			this.bounds[1].x -= 2*this.options.padding;
			this.bounds[1].y -= 2*this.options.padding;
			
			// get the chart width and height
			this.chartWidth = this.bounds[1].x - this.bounds[0].x;
			this.chartHeight = this.bounds[1].y - this.bounds[0].y;
		},
		getValueColumnWidth: function() {
			return this.ctx.measureText(String(this.maxY)).width+3;
		},
		getRowPadding: function() {
			this.rowPadding = (this.ctx.measureText(this.longestRowName).width > ((this.bounds[1].x - this.bounds[0].x) / this.data.rows.length)) ? this.ctx.measureText(this.longestRowName).width : this.height * 0.1;
		},
		drawKey: function() {
			var colorID = 0;
			// Add a margin to the column names
			var textMarginLeft = 14;
			var charHeightRatio = 0.06;
			var keyNameHeight = Math.ceil(this.height * charHeightRatio);
			var keyHeight = this.data.legend.length * keyNameHeight;
			var keyOrigin = (this.height - keyHeight) / 2;
			var keySquareWidth = 10;
			
			this.data.legend.each(function(item) {
				this.ctx.font =  "10px Verdana";
				this.ctx.fillStyle = this.options.fontColor;
				this.ctx.textAlign = "left";
				item = MilkChart.escape(item)
				this.ctx.fillText(item, this.keyBounds[0].x + textMarginLeft, keyOrigin+8);
				this.ctx.fillStyle = this.options.colors[colorID];
				this.ctx.fillRect(Math.ceil(this.keyBounds[0].x),Math.ceil(keyOrigin),keySquareWidth,keySquareWidth);
				
				colorID++;
				keyOrigin += keyNameHeight;
			}, this);
		},
		drawTitle: function() {
			var titleHeightRatio = 1.25;
			var titleHeight = this.options.titleSize * titleHeightRatio;
			this.ctx.textAlign = 'center';
			this.ctx.font = 2*this.options.titleSize + "px " + this.options.titleFont;
			this.ctx.fillStyle = this.options.titleColor;
			this.ctx.fillText(this.data.title, this.titleBounds[0].x + (this.titleBounds[1].x - this.titleBounds[0].x)/2, 2*titleHeight, this.titleBounds[1].x - this.titleBounds[0].x);
		},
		drawYLabel: function() {
			this.ctx.save();
			this.ctx.textAlign = "center";
			this.ctx.translate(this.y_labelBounds[0].x, this.y_labelBounds[0].y + (this.y_labelBounds[1].y - this.y_labelBounds[0].y)/2);
			this.ctx.rotate(-1.57079633);
			this.ctx.font = this.options.titleSize + "px " + this.options.titleFont;
			this.ctx.fillStyle = this.options.titleColor;
			this.ctx.fillText(this.data.yLabel, 0,0, this.y_labelBounds[1].y - this.y_labelBounds[0].y);
			this.ctx.restore();
		},
		drawXLabel: function() {
			this.ctx.textAlign = "center";
			this.ctx.font = this.options.titleSize + "px " + this.options.titleFont;
			this.ctx.fillStyle = this.options.titleColor;
			this.ctx.fillText(this.data.xLabel, this.x_labelBounds[0].x + (this.x_labelBounds[1].x - this.x_labelBounds[0].x)/2, this.x_labelBounds[1].y, this.x_labelBounds[1].x - this.x_labelBounds[0].x);
		},
		drawMap: function() {
			this.ctx.drawImage(this.img,this.bounds[0].x,this.bounds[0].y,this.chartWidth,this.chartHeight);
			this.buffer = document.createElement('canvas');
			this.buffer.width = this.chartWidth;
			this.buffer.height = this.chartHeight;
			this.buffer.getContext('2d').drawImage(this.img, 0, 0);
		},
		drawAxes: function() {
			/**********************************
			 * Draws X & Y axes
			 *********************************/
			this.ctx.beginPath();
			this.ctx.strokeStyle = this.options.chartLineColor;
			// The +.5 is to put lines between pixels so they draw sharply
			this.ctx.moveTo(this.bounds[0].x+.5, this.bounds[0].y+.5);
			this.ctx.lineTo(this.bounds[0].x+.5, this.bounds[1].y+.5);
			this.ctx.moveTo(this.bounds[0].x+.5, this.bounds[1].y+.5);
			this.ctx.lineTo(this.bounds[1].x+.5, this.bounds[1].y+.5);
			this.ctx.stroke();
		},
		drawValueLines: function() {
			/**********************************
			 * Draws horizontal value lines
			 *
			 * Finds the line values based on Array dist, and sets the numbers of lines
			 * to use.  This formula is similar how excel handles it.  Not sure if there
			 * is a cleaner way of creating this type of list.
			 *
			 * Next it draws in the lines and the values.  Also sets the ratio to apply
			 * to the values in the table.
			 *********************************/
			
			var dist = [1, 2, 5, 10, 20, 50, 100, 150, 500, 1000, 1500, 2000, 2500, 5000, 10000];
			var maxLines = 9;
			var i = 0;
			var j = 0;
			this.vchartLines = 1;
			this.hchartLines = 1;
			var delta_y = Math.floor((this.maxY - this.minY));
			var delta_x = Math.floor((this.maxX - this.minX));
			while (Math.floor((delta_y / dist[i])) > maxLines) {
				i++;
			}
			while (Math.floor((delta_x / dist[j])) > maxLines) {
				j++;
			}
			this.vchartLines = Math.floor((delta_y / dist[i])) + 2;
			this.hchartLines = Math.floor((delta_x / dist[j])) + 2;
			var mult_y = dist[i];
			var mult_x = dist[j];
			var vnegativeScale = (this.minY < 0) ? (mult_y + this.minY) : 0;
			var hnegativeScale = (this.minX < 0) ? (mult_x + this.minX) : 0;
			
			// Set the bounds ratio
			this.vratio = (this.chartHeight) / ((this.vchartLines - 1) * mult_y);
			this.hratio = (this.chartWidth) / ((this.hchartLines - 1) * mult_x);
			
			this.ctx.font = this.options.fontSize + "px " + this.options.font;
			this.ctx.textAlign = "right";
			this.ctx.fillStyle = this.options.fontColor;
			
			var boundsHeight = this.bounds[1].y - this.bounds[0].y;
			var boundsWidth = this.bounds[1].x - this.bounds[0].x;
			var lineHeight = Math.floor(boundsHeight / (this.vchartLines - 1));
			var lineWidth = Math.floor(boundsWidth / (this.hchartLines - 1));
			
			this.chartHeight = this.bounds[1].y - this.bounds[0].y;
			this.chartWidth = this.bounds[1].x - this.bounds[0].x;
			
			for (i = 0; i < this.vchartLines; i++) {
				this.ctx.fillStyle = this.options.fontColor;
				var lineY = this.bounds[1].y - (i * lineHeight);
				
				var lineValue = Math.round((this.vchartLines * mult_y) - ((this.vchartLines - i) * mult_y) + this.minY - vnegativeScale);
				this.ctx.beginPath();
				// Correct values for crisp lines
				lineY = this.bounds[0].y + Math.round((this.chartHeight/delta_y)*(this.maxY - lineValue)) + .5;
				if(lineY >= this.bounds[0].y && lineY -.5 <= this.bounds[1].y) {
					this.ctx.moveTo(this.bounds[0].x - 4, lineY);
					if (this.options.showValues) {
						var offsetX = 8;
						var offsetY = 3;
						this.ctx.fillText(String(lineValue), this.bounds[0].x - offsetX, lineY + offsetY);
					}
					this.ctx.lineTo(this.bounds[1].x, lineY);
					this.ctx.stroke();
				}
			}
			this.ctx.textAlign = "center";
			
			for (i = 0; i < this.hchartLines; i++) {
				this.ctx.fillStyle = this.options.fontColor;
				var lineX = this.bounds[0].x + (i * lineWidth);
				
				var lineValue = Math.round((this.hchartLines * mult_x) - ((this.hchartLines - i) * mult_x) + this.minX - hnegativeScale);
				this.ctx.beginPath();
				// Correct values for crisp lines
				lineX = this.bounds[0].x + Math.round((this.chartWidth/delta_x)*(lineValue - this.minX)) + .5;
				if(lineX >= this.bounds[0].x && lineX-.5 <= this.bounds[1].x) {
					this.ctx.moveTo(lineX, this.bounds[1].y + 4);
					if (this.options.showValues) {
						var offsetX = 0;
						var offsetY = 16;
						this.ctx.fillText(String(lineValue), lineX + offsetX, this.bounds[1].y + offsetY);
					}
					this.ctx.lineTo(lineX, this.bounds[0].y);
					this.ctx.stroke();
				}
			}
		},
		clearChart: function() {
			this.ctx.fillStyle = this.options.background;
			this.ctx.fillRect(0,0, this.width, this.height);//this.bounds[0].x, this.bounds[0].y, this.chartWidth, this.chartHeight);
		},
		swapAxes: function() {
			var row = this.data.rowNames.slice(0);
			var col = this.data.colNames.slice(0);
			this.data.rowNames = col;
			this.data.colNames = row;
			var newRows = [];
			this.data.rows.each(function(row, idx) {
				row.each(function(cell, index) {
					if (!newRows[index]) {
						newRows[index] = [];
					}
					newRows[index][idx] = cell;
				})
			});
			this.data.rows = newRows;
			
			this.setData(this.data);
			this.render();
		},
		load: function(options) {
			var self = this;
			options = options || {};
			var reqOptions = {
				method: 'get',
				onSuccess: function(res) {
					self.setData(res);
					self.render();
				}
			};
			var merged = $merge(options, reqOptions);
			var req = new Request.JSON(merged);
			req.send();
			
			return req;
		},
		getData: function() {
			var table = this.element;

			for (var i = 0, row; row = table.rows[i]; i++) {
				var y_ind = 0;
				for (var j = 0, col; col = row.cells[j]; j++) {
					if(col.nodeName == 'TH'){
						if (j == this.x_col) {
							this.data.xLabel = col.innerHTML;
						}
						if (this.options.bubble && j == this.size_col) {
							this.data.legend.push('Size: ' + col.innerHTML);
						}
						if (this.options.bubble && j == this.color_col) {
							this.data.legend.push('Color: ' + col.innerHTML);
						}
						if (contains(this.yc, j)) {
							if(!this.options.bubble)
								this.data.legend.push(col.innerHTML);
							else
								this.data.yLabel = col.innerHTML;
						}
					}
					else {
						var val = 0;
						val = Number(col.innerHTML);
						if (!val) {
							var val = date_to_float(new Date(col.innerHTML));
						}
						if (!val) {
							var val = col.innerHTML.toFloat();
						}
						
						if (j == this.x_col) {
							this.data.x.push(val);
							if (i==1 || val > this.maxX)
								this.maxX = val;
							if (i==1 || val < this.minX)
								this.minX = val;
						}
						if (j == this.size_col) {
							this.data.size.push(val);
							if (i==1 || val > this.maxSize)
								this.maxSize = val;
							if (i==1 || val < this.minSize)
								this.minSize = val;
						}
						if (j == this.color_col) {
							this.data.color.push(val);
							if (i==1 || val > this.maxColor)
								this.maxColor = val;
							if (i==1 || val < this.minColor)
								this.minColor = val;
						}
						if (j == this.time_col) {
							this.data.time.push(date_to_float(new Date(col.innerHTML)));
							if (i==1 || val > this.maxTime)
								this.maxTime = val;
							if (i==1 || val < this.minTime)
								this.minTime = val;
						}
						if(j == this.series_col) {
							this.data.series.push(col.innerHTML);
						}
						if (contains(this.yc, j)) {
							if(!this.data.y[y_ind]) {
								this.data.y.push([]);
							}
							this.data.y[y_ind].push(val);
							if (i==1 || val > this.maxY)
								this.maxY = val;
							if (i==1 || val < this.minY)
								this.minY = val;
							y_ind++;
						}
					}
				}  
			}
			this.minX = this.options.mapping ? 0 : Math.floor(this.minX);
			this.minY = this.options.mapping ? 0 : Math.floor(this.minY);
			this.maxX = this.options.mapping ? 4000 : Math.ceil(this.maxX);
			this.maxY = this.options.mapping ? 3000 : Math.ceil(this.maxY);
		},
		render: function() {
			this.ctx.save();
			
			if(!this.canvas_init) {
				// Sets up bounds for the graph, key, and other paddings
				this.prepareCanvas();
				this.canvas_init = true;
			}
			else {
				this.clearChart();
				if(this.data.title)
					this.drawTitle();
				if(this.data.xLabel)
					this.drawXLabel();
				if(this.data.yLabel)
					this.drawYLabel();
			}
			
			if(!this.options.mapping) {
			// Draws the X and Y axes lines
				this.drawAxes();
				// Draws the value lines
				this.drawValueLines();
			}
			else {
				//draws the map
				this.drawMap();
			}
			
			//draws the legend
			this.drawKey();
			
			// Main function to draw the graph
			this.draw();
			
			this.ctx.restore();
		},
		draw: function() {
			var x_range = this.maxX - this.minX;
			var y_range = this.maxY - this.minY;
			var size_range = this.maxSize - this.minSize;
			var color_range = this.maxColor - this.minColor;
			if(size_range == 0)
				size_range = 10000;
			if(size_range == 0)
				size_range = 10000;
				
			for(var j=0; j <this.data.y.length; j++) {
				var x_pos_pre = 0;
				var y_pos_pre = 0;
				for(var i=0; i<this.data.x.length; i++) {
					var x_val = this.data.x[i];
					var y_val = this.options.mapping ? 3000 - this.data.y[j][i] : this.data.y[j][i];
					var x_pos = this.bounds[0].x + (this.chartWidth/x_range)*(x_val - this.minX);
					var y_pos = this.bounds[0].y + (this.chartHeight/y_range)*(this.maxY - y_val);
					
					if (!this.options.motion || this.timestep == this.data.time[i]) {
						if (this.options.showLines) {
							if(i > 0) {
								this.ctx.beginPath();
								this.ctx.moveTo(x_pos_pre, y_pos_pre);
								this.ctx.strokeStyle = j == 0 ? "#4f81bd" : "#c0504d";
								this.ctx.lineTo(x_pos, y_pos);
								this.ctx.stroke();
							}
						}
						if(this.options.showPoints) {
							var s_pos = 5; var col = "#0800245";
							if(this.options.bubble && this.sc != -1) {
								s_pos = (1+4*Math.sqrt((this.data.size[i] - this.minSize)/(size_range)))*5;
								this.drawCircle(this.ctx, x_pos, y_pos, s_pos, "#000000");
							}
							if(this.options.bubble && this.cc != -1) {
								var cols = this.hsv_to_rgb(240, ((this.data.color[i] - this.minColor)/(color_range))*1, .78);
								this.fillCircle(this.ctx, x_pos, y_pos, s_pos, "rgb("+Math.round(cols[0])+", "+Math.round(cols[1])+", "+Math.round(cols[2])+")");
							}
							else
								this.fillCircle(this.ctx, x_pos, y_pos, s_pos, this.options.colors[j]);
						}
						if(this.options.fillArea) {
							var col = 25+ Math.round(Math.pow((this.maxColor - this.data.color[i])/(color_range), 2)*230);
							this.fillPixels(this.ctx, Math.round(x_val/2), Math.round(1500 - (y_val/2)), [8, 8, col])
						}
						x_pos_pre = x_pos;
						y_pos_pre = y_pos;
					}
				}
			}
			if(this.options.fillArea) {
				this.colorLayer = this.buffer.getContext('2d').getImageData(0,0,2000,1500)
				ctx.putImageData(this.colorLayer, this.bounds[0].x,this.bounds[0].y,this.chartWidth,this.chartHeight);
			}
		},
		drawCircle: function(ctx, x, y, size, clr) {
			this.ctx.strokeStyle = clr;
			ctx.beginPath();
			ctx.arc(x, y, size/2, 0, (Math.PI/180)*360, true);
			ctx.closePath();
			ctx.stroke();
		},
		fillCircle: function(ctx, x, y, size, clr) {
			ctx.fillStyle = clr;
			ctx.beginPath();
			ctx.arc(x, y, size/2, 0, (Math.PI/180)*360, true);
			ctx.closePath();
			ctx.fill();
		},
		fillPixels: function(ctx, startX, startY, clr) {
			var pixelStack = [[startX, startY]];
			this.colorLayer = this.buffer.getContext('2d').getImageData(0,0,this.chartWidth,this.chartHeight)
			var R, G, B;
			var loc = (startY*this.chartWidth + startX) * 4;
				R = this.colorLayer.data[loc];	
				G = this.colorLayer.data[loc+1];	
				B = this.colorLayer.data[loc+2];
			if( R + G + B == 0) {
				return;
			}
			while(pixelStack.length)
			{
				var newPos, x, y, pixelPos, reachLeft, reachRight;
				newPos = pixelStack.pop();
				x = newPos[0];
				y = newPos[1];
				
				pixelPos = (y*this.chartWidth + x) * 4;
				while(y-- >= 0 && this.matchStartColor(pixelPos, [R, G, B])) {
					pixelPos -= this.chartWidth * 4;
				}
				pixelPos += this.chartWidth * 4;
				++y;
				reachLeft = false;
				reachRight = false;
				while(y++ < this.chartHeight-1 && this.matchStartColor(pixelPos, [R, G, B])) {
					this.colorPixel(pixelPos, clr);

					if(x > 0) {
						if(this.matchStartColor(pixelPos - 4, [R, G, B])) {
							if(!reachLeft) {
								pixelStack.push([x - 1, y]);
								reachLeft = true;
							}
						}
						else if(reachLeft) {
							reachLeft = false;
						}
					}
				
					if(x < this.chartWidth-1) {
						if(this.matchStartColor(pixelPos + 4, [R, G, B])) {
							if(!reachRight) {
								pixelStack.push([x + 1, y]);
								reachRight = true;
							}
						}
						else if(reachRight) {
							reachRight = false;
						}
					}
						
					pixelPos += this.chartWidth * 4;
				}
			}
			this.buffer.getContext('2d').putImageData(this.colorLayer, 0,0);
			ctx.putImageData(this.colorLayer, this.bounds[0].x,this.bounds[0].y,this.chartWidth,this.chartHeight);
		},
		matchStartColor: function(pixelPos, clr) {
			var r = this.colorLayer.data[pixelPos];	
			var g = this.colorLayer.data[pixelPos+1];	
			var b = this.colorLayer.data[pixelPos+2];

			return (r == clr[0] && g == clr[1] && b == clr[2]);
		},
		colorPixel: function(pixelPos, clr) {
			this.colorLayer.data[pixelPos] = clr[0];
			this.colorLayer.data[pixelPos+1] = clr[1];
			this.colorLayer.data[pixelPos+2] = clr[2];
			this.colorLayer.data[pixelPos+3] = 255;
		},
		hsv_to_rgb: function(h, s, v) {
			var c = v * s;  
			var h1 = h / 60;  
			var x = c * (1 - Math.abs((h1 % 2) - 1));  
			var m = v - c;  
			var rgb;  
			  
			if (typeof h == 'undefined') rgb = [0, 0, 0];  
			else if (h1 < 1) rgb = [c, x, 0];  
			else if (h1 < 2) rgb = [x, c, 0];  
			else if (h1 < 3) rgb = [0, c, x];  
			else if (h1 < 4) rgb = [0, x, c];  
			else if (h1 < 5) rgb = [x, 0, c];  
			else if (h1 <= 6) rgb = [c, 0, x];  
      
			return [255 * (rgb[0] + m), 255 * (rgb[1] + m), 255 * (rgb[2] + m)];  
		},
		__getColors: function(clr) {
			/**********************************
			 * This accepts a single color to be a monochromatic gradient
			 * that will go from the given color to white, two colors as
			 * a gradient between the two, or use the default colors.
			 * 
			 * Keyword args may be implemented for convenience.
			 * i.e. "blue", "orange", etc.
			 */
			
			var colors = [];
			if (clr.length == 1 || clr.length == 2) {
				var min = new Color(clr[0]);
				// We either use the second color to get a gradient or use white mixed with 20% of the first color
				var max = (clr.length == 2) ? new Color(clr[1]) : new Color("#ffffff").mix(clr[0], 20);
				var delta = [(max[0] - min[0]) / this.data.colNames.length,(max[1] - min[1]) / this.data.colNames.length,(max[2] - min[2]) / this.data.colNames.length];
				var startColor = min;
				
				for (i=0;i<this.data.colNames.length;i++) {
					colors.push(startColor.rgbToHex());
					for (j=0;j<delta.length;j++) {
						startColor[j] += parseInt(delta[j]);
					}
				}
			}
			else {
				//Use default, but make sure we have enough!
				var mix = 0;
				var colorArray = clr.slice(0);
				while (colors.length != this.data.colNames.length) {
					if (colorArray.length == 0) {
						colorArray = clr.slice(0);
						mix += 20;
					}
					newColor = new Color(colorArray.shift()).mix("#ffffff", mix);
					colors.push(newColor.rgbToHex());
					
				}
			}
			
			return colors;
		}
	});

MilkChart.Scatter_rpb = new Class({
    /**********************************
    * Scatter
    *
    * The Scatter graph type has the following options:
    * - showTicks: Display tick marks at every point on the line
    * - showLines: Display the lines
    * - lineWeight: The thickness of the lines
    *********************************/
    Extends: MilkChart.Base_rpb,
    options: {
        showTicks: 	true,
        showLines: 	false,
		bubble: 	false,
		showKey:	true
    },
    initialize: function(el, cur, options) {
        this.parent(el, cur, options);
    }
});

MilkChart.Line_rpb = new Class({
    /**********************************
    * Scatter
    *
    * The Scatter graph type has the following options:
    * - showTicks: Display tick marks at every point on the line
    * - showLines: Display the lines
    * - lineWeight: The thickness of the lines
    *********************************/
    Extends: MilkChart.Base_rpb,
    options: {
        showTicks: 	false,
        showLines: 	true,
		bubble: 	false,
		showKey:	true
    },
    initialize: function(el, cur, options) {
        this.parent(el, cur, options);
    }
});

MilkChart.Bubble_rpb = new Class({
    /**********************************
    * Scatter
    *
    * The Scatter graph type has the following options:
    * - showTicks: Display tick marks at every point on the line
    * - showLines: Display the lines
    * - lineWeight: The thickness of the lines
    *********************************/
    Extends: MilkChart.Scatter_rpb,
    options: {
        bubble: 	true,
		showKey:	true
    },
    initialize: function(el, cur, options) {
        this.parent(el, cur, options);
    }
});

MilkChart.Bubble_Motion_rpb = new Class({
    /**********************************
    * Scatter
    *
    * The Scatter graph type has the following options:
    * - showTicks: Display tick marks at every point on the line
    * - showLines: Display the lines
    * - lineWeight: The thickness of the lines
    *********************************/
    Extends: MilkChart.Scatter_rpb,
    options: {
        bubble: 	true,
		showKey:	true,
		motion:		true
    },
    initialize: function(el, cur, options) {
        this.parent(el, cur, options);
    }
});

MilkChart.Map_rpb = new Class({
    /**********************************
    * Scatter
    *
    * The Scatter graph type has the following options:
    * - showTicks: Display tick marks at every point on the line
    * - showLines: Display the lines
    * - lineWeight: The thickness of the lines
    *********************************/
    Extends: MilkChart.Bubble_rpb,
    options: {
        mapping: true,
		showKey:	true
    },
    initialize: function(el, cur, options) {
        this.parent(el, cur, options);
    }
});

MilkChart.Map_Motion_rpb = new Class({
    /**********************************
    * Scatter
    *
    * The Scatter graph type has the following options:
    * - showTicks: Display tick marks at every point on the line
    * - showLines: Display the lines
    * - lineWeight: The thickness of the lines
    *********************************/
    Extends: MilkChart.Bubble_rpb,
    options: {
        mapping: true,
		motion:	 true,
		showKey:	true
    },
    initialize: function(el, cur, options) {
        this.parent(el, cur, options);
    }
});

MilkChart.Fill_Map_rpb = new Class({
    /**********************************
    * Scatter
    *
    * The Scatter graph type has the following options:
    * - showTicks: Display tick marks at every point on the line
    * - showLines: Display the lines
    * - lineWeight: The thickness of the lines
    *********************************/
    Extends: MilkChart.Bubble_rpb,
    options: {
        mapping:	true,
		fillArea:	true,
		showPoints:	false
    },
    initialize: function(el, cur, options) {
        this.parent(el, cur, options);
    }
});


