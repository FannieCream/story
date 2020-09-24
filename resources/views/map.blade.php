<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Character Trajectory</title>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css')}}">
    {{--  <!--    图片过大，需进行预渲染  chrome兼容  -->  --}}
    <link rel="prerender" href="{{ URL::asset('images/map9.png') }}" />
    <script type="text/javascript" src="{{ URL::asset('js/map.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/echarts.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}"></script>
    {{--  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  --}}
    {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">  --}}
    {{--  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.js"></script>  --}}
    {{--  <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.0/js/bootstrap.js"></script>  --}}
    {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>  --}}
    <style>
        body{
            /*background: url("assets/images/bg.jpg") no-repeat center center;*/
            /*background-size: 100%;*/
            background-color: #404a59;
            /*background-color: #a5c0de;*/
            z-index: -1000;
        }
    </style>
</head>
<body>
<!--              Navbar                -->
<div style="margin-bottom: 100px">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header" style="font-family: 'Old English Text MT'; font-size: 20px">
                <a class="navbar-brand" href="#">A Song of Ice and Fire</a>
            </div>
            <div>
                <ul class="nav navbar-nav" >
                    <li class="active" style="display: inline-block">
                        <a href="{{ url('map') }}">
                        <span class="glyphicon glyphicon-globe"></span>    人物轨迹图</a></li>
                    <li style="display: inline-block">
                        <a href="{{ url('net') }}">
                        <span class="glyphicon glyphicon-user"></span>   人物关系图</a></li>
                    <li class="dropdown" style="display: inline-block">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-sort-by-attributes"></span>     人物出场频率图 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('detail/book1') }}">book1</a></li>
                            <li><a href="{{ url('detail/book2') }}">book2</a></li>
                            <li><a href="{{ url('detail/book3') }}">book3</a></li>
                            <li><a href="{{ url('detail/book4') }}">book4</a></li>
                            <li><a href="{{ url('detail/book5') }}">book5</a></li>
                        </ul>
                    </li>
                    <li class="dropdown" style="display: inline-block">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-pencil"></span> 私人定制 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ url('define/map') }}">自定义轨迹图</a></li>
                            <li><a href="{{ url('define/net') }}">自定义关系图</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<!--              Navbar                -->

<h3>The Path of Characters in the Song of Ice and Fire in 1800</h3>

<div id="search">
    <form target="myIframe">
            <select class="selectpicker show-tick" id="selectBox" actionsBox="true" multiple title="Character" data-size="7" data-width="auto">
                <option value="" class="optionIntro">-- Please Choose --</option>
                <option> Aeron Greyjoy</option>
                <option> Areo Hotah</option>
                <option> Arianne Martell</option>
                <option> Arya Stark</option>
                <option> Arys Oakheart</option>
                <option> Asha Greyjoy</option>
                <option> Barristan Selmy</option>
                <option> Bran Stark</option>
                <option> Brienne of Tarth</option>
                <option> Catelyn Tully</option>
                <option> Cersei Lannister</option>
                <option> Chett</option>
                <option> Daenerys Targaryen</option>
                <option> Davos Seaworth</option>
                <option> Eddard Stark</option>
                <option> Jaime Lannister</option>
                <option> Jon Connington</option>
                <option> Jon Snow</option>
                <option> Kevan Lannister</option>
                <option> Maester Cressen</option>
                <option> Melisandre</option>
                <option> Quentyn Martell</option>
                <option> Samwell Tarly</option>
                <option> Sansa Stark</option>
                <option> Theon Greyjoy</option>
                <option> Tyrion Lannister</option>
                <option> Varamyr Sixskins</option>
                <option> Victarion Greyjoy</option>
                <option>All</option>
                <option>None</option>
            </select>
        <button class="submitBtn" type="submit" onclick="searchInfo()">Search</button>

    </form>
<!--    避免页面重新加载   -->
    <iframe id="myIframe" class="myIframe" name="myIframe" style="display: none"></iframe>
</div>

<div id="myMap">
    <!--    <img src="assets/images/map3.png">-->
    <div id="myChart" style="width: 110%;height:105%"></div>
</div>


<div id="sizeButton">
    <ul>
        <li><button class="big" onclick="bigImage()"><span class="glyphicon glyphicon-zoom-in"></span></button></li>
        <li><button class="small" onclick="smallImage()"><span class="glyphicon glyphicon-zoom-out"></span></button></li>
        <li><button class="init" onclick="initImage()">O</button></li>
    </ul>
</div>



<script type="text/javascript">
    var posLinesArray = []
    var posScatterArray = []
    var posLegendArray = []
    var eventSeriesArray = []
    var eventLegendArray = []
    var series_arr = []
    var emphasis_series_arr = []

    dragChart();

    function getPosData(){
        $.ajaxSettings.async = false;
        $.post("{{ url('/posdata') }}", {"_token": "{{ csrf_token() }}"}, function(posdata){
            $.each(posdata, function(key, value){
                posLegendArray.push(key);
                posScatterArray.push(value);
                var cur_posLinesData = [];
                for(var i=0; i<value.length;i++){
                    cur_posLinesData.push(value[i]['value'])
                }
                posLinesArray.push(cur_posLinesData);
            })
        })
    }

    function getEventData(){
        $.ajaxSettings.async = false;
        $.post("{{ url('/eventdata') }}", {"_token": "{{ csrf_token() }}"}, function(eventdata){
            $.each(eventdata, function(key, value){
                eventLegendArray.push(key);
                var cur_eventSeriesData = [];
                for(var i=0; i<value.length;i++){
                    cur_eventSeriesData.push(value[i]['value'])
                }
                eventSeriesArray.push(cur_eventSeriesData);
            })
        })
    }
    
    getPosData();
    getEventData()

    /*  设置position样式  */

    for(var i=0; i<posLegendArray.length; i++){
        var cur_line_series = {
            name: posLegendArray[i],
            type: "line",
            coordinateSystem: 'cartesian2d',
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
            name: posLegendArray[i],
            type: "lines",
            coordinateSystem: 'cartesian2d',
            polyline: true,
            data: [
                {
                    name: posLegendArray[i],
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
                width: 1, // 线的宽度
                opacity: 0, // 线的透明度
                curveness: 0.1 // 线的完全程度
            },

            emphasis: {
                lineStyle: {
                    width: 5,
                    opacity: 0.2, // 线的透明度
                    shadowColor: 'rgba(0, 0, 0, 0.5)',
                    shadowBlur: 20
                }
            },

            animationEasing: "linear",
        }; 

        var cur_effectscatter_series = {
            name: posLegendArray[i],
            type: "effectScatter",
            coordinateSystem: 'cartesian2d',
            showEffectOn: "emphasis",
            rippleEffect: {
                brushType: "stroke",
                period: 4,
                scale: 3.5
            },
            symbol: "pin",
            symbolSize: 8,
            emphasis: {
                show: true
            },
            z: 30,
            tooltip: {
                trigger: "item",
                position: "top",
                formatter: "position: {b}",
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
        };

        series_arr.push(cur_effectscatter_series)
        series_arr.push(cur_lines_series)
        series_arr.push(cur_line_series)
    }

    for (var j = 0; j < eventLegendArray.length; j++) {
        var cur_scatter_series = {
            name: eventLegendArray[j],
            type: "scatter",
            encode: {
                x: 0,
                y: 1,
                tooltip: 2
            },
            coordinateSystem: 'cartesian2d',
            z: 10,
            data: eventSeriesArray[j],
            symbol: "emptyCircle",
            symbolSize: 15,
            tooltip: {
                show: true,
                trigger: "item",
                position: "right",
                formatter: function (params, ticket, callback) {
                    var get_event = params.data[2].split('#');
                    var get_event = get_event.filter(function (el) {
                        return el != ""
                    })
                    var res = ""
                    for (var k = 0; k < get_event.length; k++) {
                        res += "No." + (k + 1).toString() + ": " + get_event[k] + '<br/>'
                    }
                    return res
                },
                backgroundColor: "rgb(150, 75, 0, 0.8)",
                textStyle: {
                    fontSize: 18,
                    fontFamily: "Calibri",
                },
                extraCssText: 'width:500px; white-space:pre-wrap'
            },
            itemStyle: {
                color: "transparent"
            }
        }
        // console.log(seriesEventData[j])
        series_arr.push(cur_scatter_series)
    };


    var option = {
        xAxis: {
            show: false,
            type: "value",
            max: 110,
            min: 0,
            maxInterval: 1,
            axisLabel: {
                show: true,
                fontSize: 8
            }
        },

        yAxis: {
            show: false,
            type: "value",
            max: 100,
            min: 0,
            maxInterval: 1,
            axisLabel: {
                show: true,
                fontSize: 8
            }
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

        legend: {
            data: posLegendArray,
            type: "scroll",
            scrollDataIndex: 0,
            pageButtonPosition: "start",
            pageButtonItemGap: 20,
            pageButtomGap: 10,
            pageIconSize: 15,
            pageIconColor: "#FFFACD",
            pageIconInactiveColor: "rgb(204, 204, 204, 0.3)",
            pageTextStyle: {
                color: "#eee",
                fontFamily: "Candara",
                fontSize: 16
            },
            orient: "vertical",
            show: true,
            top: 20,
            bottom: 710,
            right: 150,
            itemGap: 8,
            z: 10,
            textStyle: {
                fontSize: 18,
                fontWeight: "normal",
                fontFamily: "Candara",
                color: "#ccc"
            },
            inactiveColor: "#333",
            selector: [
                {
                    type: 'all',
                    // 可以是任意你喜欢的 title
                    title: '   All   '
                },
                {
                    type: 'inverse',
                    title: ' Inverse '
                }
            ],
            selectorButtonGap: 15,
            selectorItemGap: 10,
            {{-- selected: {
                "Aeron Greyjoy": true,
                "Areo Hotah": true,
                "Arianne Martell": true,
                "Arya Stark": true,
                "Arys Oakheart": true,
                "Asha Greyjoy": true,
                "Barristan Selmy": true,
                "Bran Stark": true,
                "Brienne of Tarth": true,
                "Catelyn Tully": true,
                "Cersei Lannister": true,
                "Chett": true,
                "Daenerys Targaryen": true,
                "Davos Seaworth": true,
                "Eddard Stark": true,
                "Jaime Lannister": true,
                "Jon Connington": true,
                "Jon Snow": true,
                "Kevan Lannister": true,
                "Maester Cressen": true,
                "Melisandre": true,
                "Quentyn Martel": true,
                "Samwell Tarly": true,
                "Sansa Stark": true,
                "Theon Greyjoy": true,
                "Tyrion Lannister": true,
                "Varamyr Sixskins": true,
                "Victarion Greyjoy": true,
            } --}}
            selected: {
                "Aeron Greyjoy": true,
                "Areo Hotah": true,
                "Arianne Martell": true,
                "Arya Stark": false,
                "Arys Oakheart": true,
                "Asha Greyjoy": true,
                "Barristan Selmy": true,
                "Bran Stark": true,
                "Brienne of Tarth": true,
                "Catelyn Tully": true,
                "Cersei Lannister": false,
                "Chett": false,
                "Daenerys Targaryen": false,
                "Davos Seaworth": false,
                "Eddard Stark": false,
                "Jaime Lannister": false,
                "Jon Connington": false,
                "Jon Snow": false,
                "Kevan Lannister": false,
                "Maester Cressen": false,
                "Melisandre": false,
                "Quentyn Martell": false,
                "Samwell Tarly": false,
                "Sansa Stark": false,
                "Theon Greyjoy": false,
                "Tyrion Lannister": false,
                "Varamyr Sixskins": false,
                "Victarion Greyjoy": false
            }
        },

        series: series_arr,
        color: ["#CD6090", "#EEA9B8", "#CD853F", "#FFDEAD", "#FF7256", "#87CEFA", "#7FFFD4","#A2CD5A","#8B658B", "#4F94CD"]
    }

    {{-- function drawChart(tmp_option){
        var mapChart = echarts.init(document.getElementById('myChart'));
        /*   折线图设置   */
        
        mapChart.setOption(option);
    } --}}
    var mapChart = echarts.init(document.getElementById('myChart'));
    mapChart.setOption(option);
    {{-- setTimeout('drawChart()', 1000);   --}}

    /* 点击折线只显示该图例的直线，隐藏其他直线 */


    
    
   
</script>
</body>
</html>