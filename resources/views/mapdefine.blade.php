<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Your Map</title>
    <script type="text/javascript" src="https://assets.pyecharts.org/assets/echarts.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/mapdefine.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" >
    {{--  <!--    图片过大，需进行预渲染  chrome兼容  -->  --}}
    <link rel="prerender" href="{{ URL::asset('images/map9.png') }}" />
    <script type="text/javascript" src="{{ URL::asset('js/map.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/echarts.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ URL::asset('js/bmap.js.map') }}"></script> --}}
    <script type="text/javascript" src="{{ URL::asset('js/bmap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/china.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/world.js') }}"></script>
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
                        <li style="display: inline-block">
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
                        <li class="active" class="dropdown" style="display: inline-block">
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

    <p id="f_map" hidden>{{ $f_map }}</p>

    <p id="f_position" hidden>{{ $fp_json }}</p>
    {{-- <p id="f_event">{{ $fe_json }}</p> --}}
    {{-- @if($json) --}}
    
    {{-- {{ $json }} --}}
    {{-- @endif --}}
    <!--              Navbar                -->

    <div id="myChart">
        <div id="defineChart" style="width: 800px;height:500px"></div>
    </div>

    <script type="text/javascript">
        var f_map = $("#f_map").text();
        var f_position = $("#f_position").text();
        var fp_json = JSON.parse(f_position);
        console.log(fp_json);
        var legendData = [];
        var posLinesData = [];
        var posScatterData = []
        var series_arr = [];
        for(key in fp_json.keys()){
            legendData.push(key);
            posScatterData.push(fp_json[key]);
            var cur_lines_data = []
            for(var i=0; i<fp_json[key].length; i++){
                cur_lines_data.push(fp_json[key][i]["value"])
            }
            posLinesData.push(cur_lines_data);
        }

        for(var i=0; i<legendData.length; i++){
            var cur_lines_series = {
                name: legendData[i],
                type: "lines",
                coordinateSystem: "geo",
                polyline: true,
                data: {
                    name: legendData[i],
                    coords: posLinesData[i]
                },

                effect: {
                    show: true,
                    constantSpeed: 40, // 点移动的速度
                    symbol: 'arrow', // 图形 'circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow'
                    symbolSize: 5, // 标记的大小，可以设置成诸如 10 这样单一的数字，也可以用数组分开表示宽和高，例如 [20, 10] 表示标记宽为20，高为10。
                    trailLength: 0, // 线的宽度
                },
            }

            var cur_scatter_series = {
                name: legendData[i],
                type: "effectScatter",
                coordinateSystem: 'geo',
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
                showEffectOn: "emphasis",
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
            }

            series_arr.push(cur_lines_series);
            series_arr.push(cur_scatter_series);
        }


        if(f_map === "China"){
            map_type = "china"

        }
        else if(f_map === "World"){
            map_type = "world"
        }
        else{

        }

        var defineoption = {
            title: {
                text: "自定义地图",
                left: "center",
            },

            legend: {
                data: legendData
            }

            series: [
                {
                    type: "map",
                    map: map_type,
                }
            ]
        }

        var defineChart = echarts.init(document.getElementById('defineChart'));
        defineChart.setOption(defineoption);


    </script>

    
</body>
</html>