<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Define Your Network</title>
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

    <table>  
        <form enctype='multipart/form-data' name='myform' action='define/net/upload' method='POST'>
        <tr><td>书名：<input name='book_name' type='text'></td></tr>  
        <INPUT TYPE = "hidden" NAME = "MAX_FILE_SIZE" VALUE ="1000000">
        <tr><td>选择上传的人物关系(link)数据集：<input name='myfile_links' type='file'></td></tr>
        <INPUT TYPE = "hidden" NAME = "MAX_FILE_SIZE" VALUE ="1000000">
        <tr><td>选择上传的人物属性(node)数据集：<input name='myfile_nodes' type='file'></td></tr>  
        <tr><td colspan='2'><input name='submit' value='Upload file'  type='submit'></td></tr> 
    </table>  
</body>
</html>