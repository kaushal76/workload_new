
$(function () {
    var RETotal = JSON.parse (RE)
    var FSTTotal = JSON.parse (FST)
    var TRATotal = JSON.parse (TRA)
    var AdminTotal = JSON.parse (ADMIN)
    var MgtTotal = JSON.parse (MGT)
    Highcharts.chart('chart', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: false
        },
        title: {
            text: 'W/L Breakdown',
            align: 'center',
            verticalAlign: 'middle',
            y: 70
        },
        credits: {
            enabled: false
        },

        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: false,
                    distance: -50,
                    style: {
                        fontWeight: 'bold',
                        color: 'white'
                    }
                },
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '75%']
            }
        },
        series: [{
            type: 'pie',
            name: 'Hours allocated',
            innerSize: '70%',
            data: [
                ['Research and Enterprise',   parseInt(RETotal)],
                ['Formal scheduled teaching',       parseInt(FSTTotal)],
                ['Teaching related activities', parseInt(TRATotal)],
                ['Management',   parseInt(MgtTotal)],
                ['Administration',     parseInt(AdminTotal)],
            ]
        }]
    });
    });


