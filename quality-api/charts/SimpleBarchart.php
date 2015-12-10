<!DOCTYPE html>
<meta charset="utf-8">
<style>
    div.bar {
        display: inline-block;
        width: 20px;
        height: 75px;   /* We'll override this later */
        background-color: teal;
        margin-right: 2px;
    }
</style>
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script>
<?php
    if(isset($_GET['yValues']) && isset($_GET['xValues'])) {
        $yValues = explode(",", $_GET['yValues']);
        $xValues = explode(",", $_GET['xValues']);
        if(count($yValues) == count($xValues)) {
            echo "var dataset = [ ";
            for($i = 0; $i < count($yValues); $i++) {
                echo "[" . $yValues[$i] . "," . $xValues[$i] . "]";
                if($i <  count($yValues) -1) {
                    echo ",";
                }
            }
            echo "]";
        }
    }
?>


    var w = 700;
    var h = 100;
    var barPadding = 1;
    var padding = 30;

    //Create SVG element
    var svg = d3.select("body")
            .append("svg")
            .attr("width", w)
            .attr("height", h);

    var maxValue = d3.max(dataset, function(d) {
        return d[1];  //References first value in each sub-array
    });
    var minValue = d3.min(dataset,function(d) {
        return d[1];
    });
    var yScale = d3.scale.linear()
            .domain([0.5*minValue, maxValue]) // reange Input vlaues?
            .range([0,h]);   // range output values

    //Barchart itself
    svg.selectAll("rect")
            .data(dataset)
            .enter()
            .append("rect")
            .attr("x", function(d, i) {
                return i * (w / dataset.length);
            })
            .attr("y", function(d) {
                return h - yScale(d[1]);  //Height minus data value
            })
            .attr("height", function(d) {
                return yScale(d[1]);
            })
            .attr("width", w / dataset.length - barPadding)
            .attr("fill", "teal");

    //Labels for each bar
    svg.selectAll("text")
            .data(dataset)
            .enter()
            .append("text")
            .text(function(d) {
                return d[1] + ": " + d[0];
            })
            .attr("x", function(d, i) {
                return  (w / dataset.length) / 3 + i * (w / dataset.length);
            })
            .attr("y", h-5)
            .attr("font-family", "sans-serif")
            .attr("font-size", "11px")
            .attr("fill", "white");
</script>