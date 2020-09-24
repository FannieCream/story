/*  图片放大缩小功能   */

var curSize = 0.8;
var step = 0.1;
var maxSize = 2;
var minSize = 0.3;
// var initImage = document.getElementById("myMap");
// var initL = initImage.offsetLeft;
// var initT = initImage.offsetTop;
//
// function getInitSize(event){
//     // 获取x,y坐标
//     var initX = event.clientX;
//     var initY = event.clientY;
//     // 获取左部和顶部的偏移量
//     var initL = initImage.offsetLeft;
//     var initT = initImage.offsetTop;
// }

function bigImage() {
    let curImage = document.getElementById("myMap");
    // curImage.style.transform.big()
    curSize = curSize < maxSize ?  (curSize + step) : curSize;
    curImage.style.transform = "scale(" + curSize + ")";
    console.log("big；",curSize);
}

function smallImage() {
    let curImage = document.getElementById("myMap");
    // curImage.style.transform.big()
    curSize = curSize > minSize ?  (curSize - step) : curSize;
    curImage.style.transform = "scale(" + curSize + ")";
    console.log("small: ",curSize);
}

function initImage() {
    let curImage = document.getElementById("myMap");
    // curImage.style.transform.big()
    curSize = 0.7;
    curImage.style.transform = "scale(" + curSize + ")";
    curImage.style.left = initL + "px";
    curImage.style.top = 30 + "px";
    console.log("init: ",curSize);
}


/*        多选搜索框       */

// function selectBox(){
//     var tmp = ""
//     for(var i=0; i< maplegend.length; i++){
//         tmp += "<option data-content=\"<span class='label label-success'>"+maplegend[i] +"</span>\">" + maplegend[i] + "<option>";
//     }
//     document.getElementById('selectBox').innerHTML = tmp;
// }
/*     人物搜索功能    */
// var nameList = ["person1","person2","person3","person4"];
//

function searchInfo() {
    var getName = document.getElementById('selectBox');
    console.log(getName)
    var showName= []
    for(var i=0; i<getName.options.length; i++){
        if(getName.options[i].selected){
            showName.push(getName.options[i].value);
        }
    }

    var maplegend = ['Aeron Greyjoy', 'Areo Hotah', 'Arianne Martell', 'Arya Stark', 'Arys Oakheart', 'Asha Greyjoy', 'Barristan Selmy', 'Bran Stark', 'Brienne of Tarth', 'Catelyn Tully', 'Cersei Lannister', 'Chett', 'Daenerys Targaryen', 'Davos Seaworth', 'Eddard Stark', 'Jaime Lannister', 'Jon Connington', 'Jon Snow', 'Kevan Lannister', 'Maester Cressen', 'Melisandre', 'Quentyn Martell', 'Samwell Tarly', 'Sansa Stark', 'Theon Greyjoy', 'Tyrion Lannister', 'Varamyr Sixskins', 'Victarion Greyjoy']
    if(showName){
        if(showName[0] === "All"){
            for(var t=0; t < maplegend.length; t++ ){
                var curLegend = maplegend[t];
                // var selected =  '{' + '"'+ curLegend + '"' + ":" + "true" + '}';
                option.legend.show = true;
                option.legend.selected[curLegend] = true;
            }
            mapChart.setOption(option);
        }
        else if(showName[0] === 'None'){
            for(var t=0; t < maplegend.length; t++ ){
                var curLegend = maplegend[t];
                // var selected =  '{' + '"'+ curLegend + '"' + ":" + "true" + '}';
                option.legend.show = true;
                option.legend.selected[curLegend] = false;
            }
            mapChart.setOption(option);
        }
        else {
            for(var j=0; j < maplegend.length; j++ ){
                var curLegend = maplegend[j];
                if(showName.indexOf(curLegend)!= -1) {
                    var selected =  '{' + '"'+ curLegend + '"' + ":" + "true" + '}';
                    // console.log(selected)
                    // option.legend.selected[curLegend] = true
                    option.legend.show = true;
                    option.legend.selected = JSON.parse(selected);
                    // option.legend.show = "true";
                    console.log("true ok")
                }
                else {
                    var unselected =  '{' + '"'+ curLegend + '"' + ":" + "false" + '}';
                    option.legend.show = true
                    option.legend.selected = JSON.parse(unselected)
                    // option.legend.show = "false";
                    // option.legend.selected[curLegend] = false
                    // console.log(selected)
                    console.log("false ok")
                }
                mapChart.setOption(option);
            }
        }
    }

    // selected += "{" + selected + "}";
    // option.legend.selected = JSON.parse(selected);
    alert("Root of " + showName.toString() + "!")
};


/*    图表拖拽功能    */
function dragChart(){
    var box = document.getElementById('myMap');
    var x = 0;
    var y = 0;
    var l = 0;
    var t = 0;
    var isDown = false;

    //鼠标按下事件
    box.onmousedown = function(event){
        // 获取x,y坐标
        x = event.clientX;
        y = event.clientY;
        // 获取左部和顶部的偏移量
        l = box.offsetLeft;
        t = box.offsetTop;
        // 开关打开
        isDown = true;
        // 设置样式
        box.style.cursor = "move";
    }

    // 鼠标移动
    window.onmousemove = function(event){
        if(isDown == false){
            return;
        }
        // 获取x,y坐标
        var nx = event.clientX;
        var ny = event.clientY;
        // 计算移动后的左偏移量和顶部的偏移量
        var nl = nx - (x - l);
        var nt = ny - (y - t);

        box.style.left = nl + "px";
        box.style.top = nt + "px";
    }

    // 鼠标抬起事件
    box.onmouseup = function(){
        // 开关关闭
        isDown = false;
        box.style.cursor = "default";
    }    
}

