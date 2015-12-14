/**
 * Created by Ferdi on 08.12.2015.
 */
/**
 *
 * @param data Datapairs such as [ [Description1, value],[Description2, value] ]
 * @param title The Title of the Grpah
 * @param htmlElementName The htmlelement to include the Graph into
 */
function drawSimpleBarchart(data, title, xLabel, yLabel, htmlElementName)
{
    google.load('visualization', '1', {packages: ['corechart', 'bar']});
    google.setOnLoadCallback(drawAnnotations);

    var data = google.visualization.arrayToDataTable(data);
    var options = {
        title: title,
        legend: 'none',
        chartArea: {width: '90%'},
        annotations: {
            alwaysOutside: true,
            textStyle: {
                fontSize: 12,
                auraColor: 'none',
                color: '#555',
            },
            boxStyle: {
                stroke: '#ccc',
                strokeWidth: 1,
                gradient: {
                    color1: '#f3e5f5',
                    color2: '#f3e5f5',
                    x1: '0%', y1: '0%',
                    x2: '100%', y2: '100%'
                }
            }
        },
        hAxis: {
            title: xLabel,
            minValue: 0,
        },
        vAxis: {
            title: yLabel,
            minValue: 0,
        }
    };
    var chart = new google.visualization.ColumnChart(document.getElementById(htmlElementName));
    chart.draw(data, options);
}