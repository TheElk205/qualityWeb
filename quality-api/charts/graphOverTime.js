/**
 * Created by ferdi on 03.02.16.
 */

/**
 * Client side, pure Java Script
 * @param generaLInformation api->getgetQualityWithIdJson()
 * @param psnrValues api->getPSNROfIDJson();
 * @param objectName where should the graph be displayed?
 */

var _index = 0;
var _frame = 0;


function createPSNRGraphOverTime(generaLInformation, psnrValues, objectName, width, height) {
    //Values:
    //representations[x].values[..]

    //Video ID:
    //representations[x].id

    //Number of lines == numberOfRepresentations
    //numberOfRepresentations

    var general = JSON.parse(generaLInformation);
    var psnr = JSON.parse(psnrValues);
    console.log("Number of Representations: " + psnr.representations.length);
    console.log("Number OF Frames: " + psnr.numberOfFrames);

    var graphIds = [];
    for (var i = 0; i < psnr.representations.length; i++) {
        graphIds.push(psnr.representations[i].id);
    }

    var data =  [];
    for(var frameNumber = 0; frameNumber < psnr.numberOfFrames; frameNumber++) {
        var Frame = {};
        Frame.frame = frameNumber;
        for (var i = 0; i < psnr.representations.length; i++) {
            var name = psnr.representations[i].id;
            Frame[i] = psnr.representations[i].values[frameNumber];
        }
        data.push(Frame);
    }

    //teste
    var lineChart1  = dc.compositeChart("#" + objectName);
    var ndx = crossfilter(data);
    var all = ndx.groupAll();

    var runDimension = ndx.dimension(function (d) { return d.frame; });
    var graphs = new Array(psnr.representations.length);
    //hacky solution, but it works so...
    for (var i = 0; i < psnr.representations.length; i++) {
        var gra = runDimension.group().reduceSum(function (d) {
            _frame++;
            var currentIndex = _index;
            if(_frame % psnr.numberOfFrames == 0) {
                _frame = 0;
                _index++;
            }
            return d[currentIndex];
        });
        graphs[i] = dc.lineChart(lineChart1).group(gra);
    }


    lineChart1.width(width)
        .height(height)
        .margins({ top: 10, right: 10, bottom: 20, left: 40 })
        .dimension(runDimension)
        .transitionDuration(500)
        .elasticY(true)
        .brushOn(false)
        .valueAccessor(function (d) {
            console.log("Value: " + d.value + " Frame: " + d.frame);
            return player.seek(d.frame/24);
        })
        .title(function (d) {
            return "\nPSNR: " + d.key;

        })
        .x(d3.scale.linear().domain([0, psnr.numberOfFrames]))
        .compose(graphs)
    ;

    dc.renderAll();

    var g1 = document.querySelector("#" + objectName);
}

function createPSNRGraphOverTime2(generaLInformation,  objectName, width, height) {
    //Values:
    //representations[x].values[..]

    //Video ID:
    //representations[x].id

    //Number of lines == numberOfRepresentations
    //numberOfRepresentations

    console.log("test");
    var general = JSON.parse(generaLInformation);
    console.log("Number of Representations: " + general.psnrFrames.length);
    console.log("Number OF Frames: " + general.numberOfFrames);

    var graphIds = [];
    for (var i = 0; i < general.psnrFrames.length; i++) {
        graphIds.push(general.psnrFrames[i].id);
    }

    var data =  [];
    for(var frameNumber = 0; frameNumber < general.numberOfFrames; frameNumber++) {
        var Frame = {};
        Frame.frame = frameNumber;
        for (var i = 0; i < general.psnrFrames.length; i++) {
            var name = general.psnrFrames[i].id;
            Frame[i] = general.psnrFrames[i].results[frameNumber];
        }
        data.push(Frame);
    }

    //teste
    var lineChart1  = dc.compositeChart("#" + objectName);
    var ndx = crossfilter(data);
    var all = ndx.groupAll();

    var runDimension = ndx.dimension(function (d) { return d.frame; });
    var graphs = new Array(general.psnrFrames.length);
    //hacky solution, but it works so...
    for (var i = 0; i < general.psnrFrames.length; i++) {
        var gra = runDimension.group().reduceSum(function (d) {
            _frame++;
            var currentIndex = _index;
            if(_frame % general.numberOfFrames == 0) {
                _frame = 0;
                _index++;
            }
            return d[currentIndex];
        });
        graphs[i] = dc.lineChart(lineChart1).group(gra);
    }


    lineChart1.width(width)
        .height(height)
        .margins({ top: 10, right: 10, bottom: 20, left: 40 })
        .dimension(runDimension)
        .transitionDuration(500)
        .elasticY(true)
        .brushOn(false)
        .valueAccessor(function (d) {
            console.log("Value: " + d.value + " Frame: " + d.frame);
            return player.seek(d.frame/24);
        })
        .title(function (d) {
            return "\nPSNR: " + d.key;

        })
        .x(d3.scale.linear().domain([0, general.numberOfFrames]))
        .compose(graphs)
    ;

    dc.renderAll();

    var g1 = document.querySelector("#" + objectName);
}