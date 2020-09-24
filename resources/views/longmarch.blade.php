<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/echarts.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bmap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/china.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/world.js') }}"></script>
    <script src="http://api.map.baidu.com/api?v=2.0&ak=57URnez2jLVQaz8aG0C6mqU3vosho1u0"></script>
</head>
<body>
    <div id="myChart" style="width:900px; height: 500px"></div>

<script type="text/javascript">
    var legendArray = [];
    var posScatterArray = [];
    var posLinesArray = [];
    var series_arr = [];
    var timeArray = [];
    var timeGroupArray = [];
    var timeScatterArray = [];
    var timeLinesArray = [];
    var timeOptionsArray = [];
    var timeEventSeries = [];

    function getPosData(){
        $.ajaxSettings.async = false;
        $.post("{{ url('/lmposdata') }}", {"_token": "{{ csrf_token() }}"}, function(posdata){
            $.each(posdata, function(key, value){
                legendArray.push(key);
                posScatterArray.push(value);
                var cur_posLinesData = [];
                for(var i=0; i<value.length;i++){
                    cur_posLinesData.push(value[i]['value'])
                }
                posLinesArray.push(cur_posLinesData);
            })
        })
    }

    function getTimeData(){
        $.ajaxSettings.async = false;
        $.post("{{ url('/timedata') }}", {"_token": "{{ csrf_token() }}"}, function(timedata){
            $.each(timedata, function(key, value){
                timeArray.push(key);
                var cur_group_array = [];
                var cur_group_scatter = [];
                var cur_group_lines = [];
                var cur_group_events = [];
                $.each(value, function(pos_key, pos_val){
                    if(legendArray.indexOf(pos_key) == -1){
                        legendArray.push(pos_key);
                    }
                    cur_group_array.push(pos_key);
                    cur_group_scatter.push(pos_val);
                    var groupLines = [];
                    var groupEvents = [];
                    for(var i=0; i<pos_val.length; i++){
                        groupLines.push(pos_val[i]["value"]);
                        if(pos_val[i]["detail"] !== "0"){
                            groupEvents.push(pos_val[i]["event"] + ":" + pos_val[i]["detail"]);
                        }
                        else{
                            groupEvents.push(pos_val[i]["event"]);
                        }
                    }
                    cur_group_lines.push(groupLines);
                    cur_group_events.push(groupEvents);
                })
                
                timeGroupArray.push(cur_group_array);
                timeScatterArray.push(cur_group_scatter);
                timeLinesArray.push(cur_group_lines);
                {{--  timeLinesArray.push(cur_group_events);  --}}
            })


            {{-- console.log(timeGroupArray); --}}
            {{-- console.log(timeScatterArray); --}}
        })
    }

    getTimeData();

    for(var i=0; i<timeArray.length; i++){
        var groupSeriesArray = [];
        for(var j=0; j<timeGroupArray[i].length; j++){
            var cur_group_effectscatter_series = {
                name: timeGroupArray[i][j],
                type: "effectScatter",
                coordinateSystem: "bmap",
                showEffectOn: "emphasis",
                rippleEffect: {
                    brushType: "stroke",
                    period: 4,
                    scale: 3.5
                },
                symbol: "pin",
                symbolSize: 14,
                emphasis: {
                    show: true
                },
                tooltip: {
                    trigger: "item",
                    position: "top",
                    formatter: "{b}",
                    backgroundColor: "rgb(50, 50, 0, 0.7)",
                    borderColor: "#FFFFE0",
                    borderWidth: 1,
                    padding: 10,
                    textStyle: {
                        fontFamily: "Candara",
                        fontSize: 14
                    },
                    extraCssText: "box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);"
                },
                animation: true,
                data: timeScatterArray[i][j]
            };

            var cur_group_lines_series = {
                name: timeGroupArray[i][j],
                type: "lines",
                coordinateSystem: 'bmap',
                polyline: true,
                data: [
                    {
                        name: timeGroupArray[i][j],
                        coords: timeLinesArray[i][j]
                    }
                ],  
                z: 20,

                effect: {
                    show: true,
                    constantSpeed: 40, // 点移动的速度
                    symbol: 'arrow', // 图形 'circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow'
                    symbolSize: 5, // 标记的大小，可以设置成诸如 10 这样单一的数字，也可以用数组分开表示宽和高，例如 [20, 10] 表示标记宽为20，高为10。
                    trailLength: 0, // 线的宽度
                },

                tooltip: {
                    trigger: "item",
                    position: ["45%", "20%"],
                    formatter: "The Path of {b}",
                    backgroundColor: "transparent",
                    textStyle: {
                        fontStyle: "italic",
                        fontFamily: "Candara",
                        fontSize: 30,
                        fontWeight: "bolder",
                        color: "#fff",
                        textBorderColor: "#ccc",
                        textBorderWidth: 20,
                        textShadowColor: "rgb(255, 255, 0)",
                        textShadowBlur: 20,
                        textShadowOffsetY: 10,
                        textShadowOffsetY: 10,
                    },
                },

                // symbol:"triangle",
                showSymbol: false,
                symbolSize: 15,
                lineStyle: {
                    width: 3, // 线的宽度
                    opacity: 0.5, // 线的透明度
                    curveness: 0.5 // 线的弯曲程度
                },

                emphasis: {
                    lineStyle: {
                        width: 5,
                        opacity: 0.7, // 线的透明度
                        shadowColor: 'rgba(0, 0, 0, 0.5)',
                        shadowBlur: 20
                    }
                },

                animationEasing: "linear",

            }
            

            groupSeriesArray.push(cur_group_effectscatter_series);
            groupSeriesArray.push(cur_group_lines_series);
        }

        var time_str_arr = timeArray[i].split("-")
        var cur_text = time_str_arr[0]+ "年" + time_str_arr[1] + "月" + " 长征路线图";

        var cur_time_series = {
            title:{
                text: cur_text,
                bottom: 10,
                right: 10,
                textStyle: {
                    color: "#fff",
                    fontSize: 24,
                    textBorderColor: "#000"

                }

            },
            z: 30,
            series: groupSeriesArray
        }

        timeOptionsArray.push(cur_time_series);
    }

    console.log(timeOptionsArray)

    for(var i=0; i<legendArray.length; i++){
        var cur_line_series = {
            name: legendArray[i],
            type: "line",
            coordinateSystem: 'bmap',
            polyline: true,
            data: posLinesArray[i],
            // symbol:"triangle",
            showSymbol: false,
            symbolSize: 15,
            smooth: false,
            lineStyle: {
                width: 1.5, // 线的宽度
                opacity: 0.6, // 线的透明度
                curveness: 0.1 // 线的完全程度
            },

            z: 10,

            animationEasing: "linear",
            animationDuration: 10000,
            animationDelay: function (idx) {
                // 越往后的数据延迟越大
                return idx * 100;
            },
            
        }; 

        var cur_lines_series = {
            name: legendArray[i],
            type: "lines",
            coordinateSystem: 'bmap',
            polyline: true,
            data: [
                {
                    name: legendArray[i],
                    coords: posLinesArray[i]
                }
            ],  
            z: 20,

            effect: {
                show: true,
                constantSpeed: 40, // 点移动的速度
                symbol: 'arrow', // 图形 'circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow'
                symbolSize: 5, // 标记的大小，可以设置成诸如 10 这样单一的数字，也可以用数组分开表示宽和高，例如 [20, 10] 表示标记宽为20，高为10。
                trailLength: 0, // 线的宽度
            },

            tooltip: {
                trigger: "item",
                position: ["45%", "20%"],
                formatter: "The Path of {b}",
                backgroundColor: "transparent",
                textStyle: {
                    fontStyle: "italic",
                    fontFamily: "Candara",
                    fontSize: 30,
                    fontWeight: "bolder",
                    color: "#333",
                    textBorderColor: "#ccc",
                    textBorderWidth: 20,
                    textShadowColor: "rgb(255, 255, 0)",
                    textShadowBlur: 20,
                    textShadowOffsetY: 10,
                    textShadowOffsetY: 10,
                },
            },

             // symbol:"triangle",
            showSymbol: false,
            symbolSize: 15,
            lineStyle: {
                width: 3, // 线的宽度
                opacity: 0.5, // 线的透明度
                curveness: 0.5 // 线的弯曲程度
            },

            emphasis: {
                lineStyle: {
                    width: 5,
                    opacity: 0.7, // 线的透明度
                    shadowColor: 'rgba(0, 0, 0, 0.5)',
                    shadowBlur: 20
                }
            },

            animationEasing: "linear",
        }; 

        var cur_scatter_series = {
            name: legendArray[i],
            type: "effectScatter",
            coordinateSystem: "bmap",
            showEffectOn: "emphasis",
            rippleEffect: {
                brushType: "stroke",
                period: 4,
                scale: 3.5
            },
            symbol: "pin",
            symbolSize: 12,
            emphasis: {
                show: true
            },
            tooltip: {
                trigger: "item",
                position: "top",
                formatter: "{b}",
                backgroundColor: "rgb(50, 50, 0, 0.7)",
                borderColor: "#FFFFE0",
                borderWidth: 1,
                padding: 10,
                textStyle: {
                    fontFamily: "Candara",
                    fontSize: 14
                },
                extraCssText: "box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);"
            },
            animation: true,
            data: posScatterArray[i]
        }

        series_arr.push(cur_scatter_series);
        {{-- series_arr.push(cur_line_series); --}}
        series_arr.push(cur_lines_series);
        
    }

    var time_option = {
        baseOption: {
            bmap: {
                center: [100.13066322374, 30.240018034923],
                zoom: 5,
                roam: true,
                mapStyle: {
                    styleJson: [{
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": {
                            "color": "#153368"
                        }
                    }, 
                    {
                        "featureType": "land",
                        "elementType": "all",
                        "stylers": {
                            "color": "#eee4be",
                            "visibility": "on"
                        }
                    },
                    {
                        "featureType": "boundary",
                        "elementType": "geometry",
                        "stylers": {
                            "color": "#585341",
                        }
                    }, 
                    {
                        "featureType": "railway",
                        "elementType": "all",
                        "stylers": {
                            "visibility": "on"
                        }
                    }, 
                    {
                        "featureType": "highway",
                        "elementType": "geometry",
                        "stylers": {
                            "visibility": "on"
                        }
                    }, 
                    {
                        "featureType": "highway",
                        "elementType": "geometry.fill",
                        "stylers": {
                            "color": "#3B65B7",
                            "lightness": 1,
                        }
                    }, 
                    {
                        "featureType": "highway",
                        "elementType": "labels",
                        "stylers": {
                            "visibility": "off"
                        }
                    }, 
                    {
                        "featureType": "arterial",
                        "elementType": "geometry",
                        "stylers": {
                            "color": "#3B65B7",
                        }
                    }, 
                    {
                        "featureType": "arterial",
                        "elementType": "geometry.fill",
                        "stylers": {
                            "color": "#3B65B7",
                        }
                    }, 
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": {
                            "visibility": "off"
                        }
                    }, 
                    {
                        "featureType": "green",
                        "elementType": "all",
                        "stylers": {
                            "color": "#056197",
                            "visibility": "on"
                        }
                    }, 
                    {
                        "featureType": "subway",
                        "elementType": "all",
                        "stylers": {
                            "visibility": "on"
                        }
                    }, 
                    {
                        "featureType": "manmade",
                        "elementType": "all",
                        "stylers": {
                            "visibility": "on"
                        }
                    }, 
                    {
                        "featureType": "local",
                        "elementType": "all",
                        "stylers": {
                            "visibility": "off"
                        }
                    }, 
                    {
                        "featureType": "arterial",
                        "elementType": "labels",
                        "stylers": {
                            "visibility": "off"
                        }
                    }, 
                    {
                        "featureType": "boundary",
                        "elementType": "geometry.fill",
                        "stylers": {
                            "color": "#9c804f"
                        }
                    }, 
                    {
                        "featureType": "building",
                        "elementType": "all",
                        "stylers": {
                            "color": "#1a5787"
                        }
                    },
                    {
                        "featureType": "label",
                        "elementType": "all",
                        "stylers": {
                            "visibility": "on"
                        }
                    }
                ]}
            },

            title: {
                text: "长征路线可视化"
            },

            timeline: {
                show: true,
                type: "slider",
                axisType: "category",
                autoPlay: true,
                data: timeArray,
                label: {
                    position: "top",
                    color: "#ccc"
                }
            },

            legend: {
                data: legendArray
            },

            tooltip: {
                show: true,
                trigger: "item",
                position: "top",
                alwaysShowContent: true,
                // backgroundColor: "red",
                formatter: function (params) {
                    return params.name
                },
                textStyle: {
                    fontStyle: "normal",
                    fontSize: 16,
                    fontFamily: "Constantia"
                }
            },
        },

        options: timeOptionsArray


    }


    var mapChart = echarts.init(document.getElementById('myChart'));
    mapChart.setOption(time_option);
    
    
    
    </script>
    
</body>
</html>