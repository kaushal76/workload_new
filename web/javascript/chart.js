var IDValue = JSON.parse(ID);
$(function () {
    $.ajax({
        url: Routing.generate('staff_totals',{id: IDValue }),
        cache: false,
        dataType: 'json',
        success: function(data){
            displayChart(data)
        }
    });

    function displayChart(data) {

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
                    ['Research and Enterprise',  data.re],
                    ['Formal scheduled teaching', data.fst],
                    ['Teaching related activities', data.tra],
                    ['Management', data.mgt],
                    ['Administration', data.admin],
                ],
                showInLegend: true,
            }]
        });
    }
});


