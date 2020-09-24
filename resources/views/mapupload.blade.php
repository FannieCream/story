<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Define Your Map</title>
    <script type="text/javascript" src="https://assets.pyecharts.org/assets/echarts.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" >
    {{--  <!--    图片过大，需进行预渲染  chrome兼容  -->  --}}
    <link rel="prerender" href="{{ URL::asset('images/map9.png') }}" />
    <script type="text/javascript" src="{{ URL::asset('js/map.js') }}" ></script>
    <script type="text/javascript" src="{{ URL::asset('js/echarts.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}"></script>
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
    <!--              Navbar                -->

    <div class="container">
        <form class="form-horizontal" method="POST" action="/define/map/upload" enctype="multipart/form-data">
            {{ csrf_field() }}           
            <label for="file" style="color: white">选择轨迹文件</label>
            <input id="file" type="file" class="form-control" name="f_position" accept=".csv" required>
            <p style="color: #ccc">表格形式为：person, position, pos_x, pos_y</p>
            <label for="file" style="color: white">选择事件文件</label>
            <input id="file" type="file" class="form-control" name="f_event" accept=".csv" required>
            <p style="color: #ccc">表格形式为：person, position, pos_x, pos_y, event</p>
            <label for="file" style="color: white">选择地图类型</label>
            <select class="selectpicker" title="Your Map Type" name="f_map">
                <option value="" class="optionIntro">-- Please Choose --</option>
                <option>China</option>
                <option>World</option>
                <option>Virtual</option>
            </select>
            <button type="submit" class="btn btn-primary">确定</button>
        </form>
    </div>
</body>
</html>