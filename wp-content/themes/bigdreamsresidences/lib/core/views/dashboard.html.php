<div class="wrap" id="BookingDashboard">
	<h1>Dashboard</h1>
    <?php bigdream_notices(); ?>
	<div class="row text-center">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <div class="huge"><?php format_price(get_today_sales()); ?></div>
                            <div>Today</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                       <div class="col-xs-12 text-center">
                            <div class="huge"><?php format_price(get_week_sales()); ?></div>
                            <div>This Week</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <div class="huge"><?php format_price(get_month_sales()); ?></div>
                            <div>This Month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <div class="huge"><?php format_price(get_year_sales()); ?></div>
                            <div>This Year</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="row" style="width:100%">
        <div id="legend"></div>
		<canvas id="canvas"></canvas>
	</div>
	
</div>
<?php $sales = get_monthly_chart_sales(); ?>
<script>
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
		var lineChartData = {
			labels : ["January","February","March","April","May","June","July", "August", "September", "October", "November", "December"],
			datasets : [
				{
					label: "Total Booking Amount %",
					fillColor : "rgba(220,220,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [<?php echo implode(',', $sales['amount']); ?>]
				},
				{
					label: "Amount Paid %",
					fillColor : "rgba(151,187,205,0.2)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : [<?php echo implode(',', $sales['amount_paid']); ?>]
				}
			]

		}

	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true,
            legendTemplate : '<ul>'
                  +'<% for (var i=0; i<datasets.length; i++) { %>'
                    +'<li>'
                    +'<span style=\"background-color:<%=datasets[i].fillColor%>\"></span>'
                    +'<% if (datasets[i].label) { %><%= datasets[i].label %><% } %>'
                  +'</li>'
                +'<% } %>'
              +'</ul>'
		});
         document.getElementById("legend").innerHTML = window.myLine.generateLegend();
	}


	</script>
