<template>
    <div id="main" class="elevator">
        <div id="leftInfo">
            <select id="deviceList" style="width: 30em; background-color: darkgray;">
                <option value="0">4号</option>
                <option value="1">6号</option>
                <option value="2">2号</option>
                <option value="3" selected="selected">3号</option>
                <option value="4">金马腾苑7号</option>
                <option value="5">8号</option>
                <option value="6">5号</option>
                <option value="7">1号</option>
            </select>
            <canvas id="sideviewCanvas" width="475" height="495" style="margin: 5px;"></canvas>
        </div>
        <div id="rightInfo">
            <div id="msgInfo">
                <div class="deviceinfo">
                    <div>
                        <img class="lock" src="/static/img/锁机.png">
                    </div>
                    <div class="normalFontState">
                        <p class="normalFont">点击锁定</p>
                    </div>
                </div>
                <div class="deviceinfo">
                    <div>
                        <img class="msg" src="/static/img/消息框.png">
                    </div>
                    <div class="normalFontState">
                        <p class="normalFont">发送消息</p>
                    </div>
                </div>
                <table class="msgInfo_table">
                    <tbody>
                    <tr>
                        <td class="msgInfo_tabletrtd">黑匣子编号:</td>
                        <td class="msgInfo_tabletrtd hidinfo" id="infoSn">010613110012</td>
                    </tr>
                    <tr>
                        <td class="msgInfo_tabletrtd">黑匣子品牌:</td>
                        <td class="msgInfo_tabletrtd hidinfo" id="infoCompany">品茗科技</td>
                    </tr>
                    <tr>
                        <td class="msgInfo_tabletrtd">GPRS:</td>
                        <td class="msgInfo_tabletrtd hidinfo" id="infoGprsTel">15656322694</td>
                    </tr>
                    <tr>
                        <td class="msgInfo_tabletrtd">备案编号:</td>
                        <td class="msgInfo_tabletrtd hidinfo " id="infoFilingNO"></td>
                    </tr>
                    <!-- <tr>
                        <td>剩余流量：</td>
                        <td id="infoRemain"></td>
                    </tr>-->
                    </tbody>
                </table>
            </div>
            <div id="driverInfo">
                <!--司机信息-->
                <img id="driverPhoto" src="/static/img/司机照片.png" style="display:none">
                <table style="margin: 10px;display:none">
                    <tbody>
                    <tr>
                        <td>司机姓名:</td>
                        <td id="driverName"></td>
                    </tr>
                    <tr>
                        <td>司机编号:</td>
                        <td id="driverNo"></td>
                    </tr>
                    <tr>
                        <td>司机电话:</td>
                        <td id="driverPhone"></td>
                    </tr>
                    <tr>
                        <td>作业证号:</td>
                        <td id="cerNo"></td>
                    </tr>
                    </tbody>
                </table>
                <canvas id="overlookCanvas" width="450" height="408"></canvas>
                <!--俯视图-->
                <div class="Identification">
                    <p class="normalFont" style="float: right">其他</p>
                    <div style="width: 14px; height: 14px; background-color: #009afe; margin: 3px; float: right"></div>
                    <p class="normalFont" style="float: right">离线</p>
                    <div style="width: 14px; height: 14px; background-color: #d4d4d4; margin: 3px; float: right"></div>
                    <p class="normalFont" style="float: right">在线</p>
                    <div style="width: 14px; height: 14px; background-color: #00ffef; margin: 3px; float: right"></div>
                    <p class="normalFont" style="float: right">当前塔吊</p>
                    <div style="width: 14px; height: 14px; background-color: #ffcb33; margin: 3px; float: right"></div>
                </div>
            </div>
        </div>
        <div id="alarmInfo">
            <marquee direction="left" id="Marquee1" class="alarmFont" style="color: yellow;" hidden="hidden">
                <p id="alarmStatus" class="alarmFont" style="color: yellow;"></p></marquee>
        </div>
    </div>

</template>

<script>
    var ctxSideView = null;
    //静态参数的数组
    const CANVASWIDTH_SIDE = 495;
    const CANVASHEIGHT_SIDE = 495;

    const SIDE_DRAW_X = 10; //侧视图的X
    const SIDE_DRAW_Y = 20; //侧视图的Y
    const SIDE_DRAW_LEFT = 180; //小车活动区域的左边距
    const SIDE_DRAW_TOP = 98;//小车活动区域的上边距
    const SIDE_DRAW_WIDTH = 280; //小车绘图区域的宽度
    const SIDE_DRAW_HEIGHT = 355; //小车绘图区域的高度
    const SIDE_CAR_HOCK_ALIGN = 8; //小车和重物对齐的差值

    const CAR_HEIGHT = 5;
    const CAR_WIDTH = 27;
    const HOCK_HEIGHT = 52;
    const HOCK_WIDTH = 44;

    const SIDE_LUFF_BODY_X = 0; //塔身的X
    const SIDE_LUFF_BODY_Y = 154;//塔身的Y
    const SIDE_LUFF_BODY_HEIGHT = 214; //塔身的高度
    const SIDE_LUFF_CTJIB_LINE_X = 70; //起重臂上拉绳的X
    const SIDE_LUFF_CTJIB_LINE_Y = 163; //起重臂上拉绳的Y
    const SIDE_LUFF_JIB_X = 150;//动臂铰点的X
    const SIDE_LUFF_JIB_Y = 245;//动臂铰点的Y
    const SIDE_LUFF_JIB_WIDTH = 240; //动臂起重臂宽度
    const SIDE_LUFF_JIB_HEIGHT = 18; //动臂起重臂高度
    const SIDE_LUFF_JIB_RECT_WIDTH = 13;
    const SIDE_LUFF_JIB_RECT_HEIGHT = 6;
    const TC_FLAT = 0;
    const TC_LUFF = 1;
    const TC_TOPKIT = 2;

    var sideViewTcL1 = 0;
    var sideViewTcH1 = 0;
    var tcType = 0;
    var latitude = 0;
    var longtitude = 0;
    var hasTrolley = 0;
    var hasHeight = 0;
    var hasCrane = 0;
    var hasWindSpeed = 0;
    var hasGyration = 0;
    var hasRelay = 0;
    var hasOblique = 0;
    var hasICCard = 0;
    var imgTowerCrane = null;
    var imgCar = null;
    var imgHock = null;
    var imgPlat = null; //平臂
    var imgLuffBody = null; //动臂塔身
    var imgLuffJib = null; //动臂的起重臂
    var imgLuffJibRect = null; //动臂臂尖的矩形

    var radiusCoor = 1; //幅度系数
    var heightCoor = 1; //高度系数


    //缓动
    var endRadius = 0;
    var endHeight = 0;
    var intRadius = 0;
    var intHeight = 0;
    var currRadius = 0; //当前幅度
    var currHeight = 0; //当前高度
    var realDataObj = new Object();
    var TWEEN_TIME = 2; //单位ms
    function initSideView(canvasId, projectId) {
        var c = document.getElementById(canvasId);
        if (c == null)
            return false;
        ctxSideView = c.getContext("2d");
        //
        if (projectId == null || projectId == "") {
            setSideviewInfo("Invalid ProjectId");
            return false;
        }
        imgTowerCrane = new Image();
        imgTowerCrane.onload = function () {
            ctxSideView.drawImage(imgTowerCrane, SIDE_DRAW_X, SIDE_DRAW_Y);
            imgWindSpeed = new Image();
            imgWindSpeed.onload = function () {
                //ctxSideView.drawImage(imgWindSpeed,137-26/2,3);
                imgCar = new Image();
                imgCar.onload = function () {
                    //ctxSideView.drawImage(imgCar,SIDE_DRAW_X+SIDE_DRAW_LEFT+SIDE_CAR_HOCK_ALIGN,SIDE_DRAW_Y+SIDE_DRAW_TOP);
                    imgHock = new Image();
                    imgHock.onload = function () {
                        //ctxSideView.drawImage(imgHock,SIDE_DRAW_X+SIDE_DRAW_LEFT,SIDE_DRAW_Y+SIDE_DRAW_TOP+CAR_HEIGHT);
                    }
                    imgHock.src = "/static/img/hock.png";
                }
                imgCar.src = "/static/img/car.png";
            }
            imgWindSpeed.src = "/static/img/风速.png";
        }
        imgTowerCrane.src = "/static/img/tcSideView.png";
        imgPlat = new Image();
        imgPlat.onload = function () {
        }
        imgPlat.src = "/static/img/tcSideViewPlat.png";
        imgLuffBody = new Image();
        imgLuffBody.onload = function () {
        }
        imgLuffBody.src = "/static/img/tcSideViewLufBody.png";
        imgLuffJib = new Image();
        imgLuffJib.onload = new function () {
        }
        imgLuffJib.src = "/static/img/tcSideViewLufJib.png";
        imgLuffJibRect = new Image();
        imgLuffJibRect.onload = new function () {
        }
        imgLuffJibRect.src = "/static/img/tcSideviewLuffJibRect.png";
        setSideviewInfo("加载中....");
        return true;
    }

    function setSideView(obj) {
        tcType = obj.TCType; //塔机类型
        sideViewTcL1 = parseFloat(obj.L1);
        sideViewTcH1 = parseFloat(obj.H1);
        latitude = parseInt(obj.Latitude);
        longtitude = parseInt(obj.Longtitude);
        hasTrolley = parseInt(obj.HasTrolley);
        hasHeight = parseInt(obj.HasHeight);
        hasCrane = parseInt(obj.HasCrane);
        hasWindSpeed = parseInt(obj.HasWindSpeed);
        hasGyration = parseInt(obj.HasGyration);
        hasRelay = parseInt(obj.HasRelay);
        hasOblique = parseInt(obj.HasOblique);
        hasICCard = parseInt(obj.HasIcCard);

        if (sideViewTcL1 > 0 && sideViewTcH1 > 0) {
            if (tcType == TC_FLAT || tcType == TC_TOPKIT) {
                radiusCoor = (SIDE_DRAW_WIDTH - CAR_WIDTH - SIDE_CAR_HOCK_ALIGN) / sideViewTcL1;
                heightCoor = (SIDE_DRAW_HEIGHT - CAR_HEIGHT) / sideViewTcH1;
            }
            else {
                //动臂
                heightCoor = SIDE_LUFF_BODY_HEIGHT / sideViewTcH1;
                radiusCoor = SIDE_LUFF_JIB_WIDTH / sideViewTcL1;
            }
        }
    }

    function setSideviewInfo(msg) {
        if (ctxSideView == null)
            return;
        clearSideviewCanvas();
        ctxSideView.fillStyle = "#FFFFFF";
        ctxSideView.font = "16px Arial";
        ctxSideView.fillText(msg, 5, 15);
    }

    function clearSideviewCanvas() {

        ctxSideView.fillStyle = "#000000";
        ctxSideView.beginPath();
        ctxSideView.fillRect(0, 0, CANVASWIDTH_SIDE, CANVASHEIGHT_SIDE);
        ctxSideView.closePath();
    }

    function refrenshSideview(info) {
        if (sideViewTcL1 < 0.001 || sideViewTcH1 < 0.001) {
            setSideviewInfo("塔高或臂长的参数无效！");
            return;
        }
        realDataObj.time = info.DeviceTime;
        realDataObj.load = parseFloat(info.Load);
        realDataObj.radius = parseFloat(info.Radius);
        realDataObj.percent = info.Percent;
        realDataObj.angle = parseFloat(info.Angle);
        realDataObj.height = parseFloat(info.Height);
        realDataObj.windspeed = info.WindSpeed;
        realDataObj.safeLoad = parseFloat(info.SafeLoad);
        realDataObj.fall = parseFloat(info.Fall);
        realDataObj.obliqueDirection = info.ObliqueDirection;
        realDataObj.obliqueState = info.ObliqueState;
        realDataObj.ObliqueAngle = info.ObliqueAngle;
        realDataObj.radius = realDataObj.radius < 0 ? 0 : realDataObj.radius;
        realDataObj.radius = realDataObj.radius > sideViewTcL1 ? sideViewTcL1 : realDataObj.radius;
        var radius = info.Radius;
        var height = info.Height;
        if (tcType != TC_LUFF) //非动臂，高度不能大于塔高
        {
            realDataObj.height = realDataObj.height > sideViewTcH1 ? sideViewTcH1 : realDataObj.height;
        }
        //动臂将幅度转换成仰角
        if (tcType == TC_LUFF) {
            radius = radius > 90 ? 90 : radius;
            radius = radius > sideViewTcL1 ? sideViewTcL1 : radius;
            radius = Math.acos(radius / sideViewTcL1) * 180 / Math.PI;
            radius = radius < 0 ? 0 : radius;
            radius = radius > 90 ? 90 : radius;
            realDataObj.radius = radius;
        }
        //计算缓动
        endRadius = parseFloat(radius);
        endHeight = parseFloat(height);
        //停止计时器
        $('body').stopTime('sideViewTween');
        if (tcType != TC_LUFF)//非动臂，高度不能大于塔高
        {
            //如果值没发生变化
            if (currRadius > sideViewTcL1)
                currRadius = sideViewTcL1;
            currRadius = currRadius < 0 ? 0 : currRadius;
            if (currHeight > sideViewTcH1)
                currHeight = sideViewTcH1;
        }
        var decRadius = endRadius - currRadius;
        var decHeight = endHeight - currHeight;
        var maxDec = Math.abs(decRadius) > Math.abs(decHeight) ? decRadius : decHeight;
        //缓动间隔
        var addVal = 0;
        if (Math.abs(maxDec) < 10)
            addVal = 5;
        else if (Math.abs(maxDec) < 30)
            addVal = 10;
        else if (Math.abs(maxDec) < 100)
            addVal = 20;
        else
            addVal = 20;
        //计算间隔变量
        intRadius = 0;
        if (Math.abs(decRadius) > 0)
            intRadius = decRadius / addVal;

        intHeight = 0;
        if (Math.abs(decHeight) > 0)
            intHeight = decHeight / addVal;

        drawSideview(tcType,
            realDataObj.time,
            realDataObj.load,
            currRadius,
            realDataObj.percent,
            realDataObj.angle,
            currHeight,
            realDataObj.windspeed,
            realDataObj.safeLoad,
            realDataObj.fall,
            realDataObj.obliqueDirection,
            realDataObj.obliqueState,
            realDataObj.ObliqueAngle,
            endRadius,
            endHeight);
        var timeStr = (TWEEN_TIME / addVal).toString() + 's';
        $('body').everyTime(timeStr, 'sideViewTween', function () {
            var bStop = false;
            if (intRadius != 0) {
                currRadius += intRadius;
                if (intRadius > 0 && currRadius >= endRadius
                    || intRadius < 0 && currRadius <= endRadius) {
                    currRadius = endRadius;
                    currHeight = endHeight;
                    bStop = true;
                }
            }
            if (intHeight != 0) {
                currHeight += intHeight;
                if (intHeight > 0 && currHeight >= endHeight
                    || intHeight < 0 && currHeight <= endHeight) {
                    currRadius = endRadius;
                    currHeight = endHeight;
                    bStop = true;
                }
            }
            drawSideview(
                tcType,
                realDataObj.time,
                realDataObj.load,
                currRadius,
                realDataObj.percent,
                realDataObj.angle,
                currHeight,
                realDataObj.windspeed,
                realDataObj.safeLoad,
                realDataObj.fall,
                realDataObj.obliqueDirection,
                realDataObj.obliqueState,
                realDataObj.ObliqueAngle,
                endRadius,
                endHeight
            );

            if (bStop || (currHeight == endHeight && currRadius == endRadius)) {
                //运动到了终点，停止缓动定时器
                $('body').stopTime('sideViewTween');
            }
        });
    }

    /**
     * 绘制侧视图动臂
     */
    function drawSideViewLuff(time, load, radius, percent, angle, height, windspeed, safeLoad, fall, obliqueDirection, obliqueState, ObliqueAngle, radius1, height1) {
        let baseX = 0;
        let baseY = 0;
        if (ctxSideView == null)
            return;
        //清空绘图区域
        clearSideviewCanvas();
        if (imgLuffBody != null && imgLuffJib != null) {
            //绘制塔身
            let x = SIDE_LUFF_BODY_X + baseX;
            let y = SIDE_LUFF_BODY_Y + baseX;
            ctxSideView.drawImage(imgLuffBody, x, y);
            //绘制起重臂
            x = SIDE_LUFF_JIB_X + baseX;
            y = SIDE_LUFF_JIB_Y + baseY;
            //
            ctxSideView.save();
            ctxSideView.translate(x, y);
            ctxSideView.rotate(-radius * Math.PI / 180);
            ctxSideView.drawImage(imgLuffJib, 0, 0 - SIDE_LUFF_JIB_HEIGHT);
            ctxSideView.restore();
            //平衡臂上的支点去绘制拉线
            ctxSideView.lineWidth = 1;
            ctxSideView.strokeStyle = "#267f2c";
            let startX = SIDE_LUFF_CTJIB_LINE_X + baseX;
            let startY = SIDE_LUFF_CTJIB_LINE_Y + baseY;
            let rX = SIDE_LUFF_JIB_X + baseX + Math.cos(-radius * Math.PI / 180) * SIDE_LUFF_JIB_WIDTH;
            let rY = SIDE_LUFF_JIB_Y + baseY + Math.sin(-radius * Math.PI / 180) * SIDE_LUFF_JIB_WIDTH;
            let endX = rX;
            let endY = rY;
            ctxSideView.moveTo(startX, startY);
            ctxSideView.lineTo(endX, endY);
            ctxSideView.stroke();
            //计算仰高
            let arcHeight = sideViewTcL1 * Math.sin(radius * Math.PI / 180);
            startX = endX;
            startY = endY;
            endX = startX;
            if (height > sideViewTcH1) {
                endY = startY + arcHeight * radiusCoor - (height - sideViewTcH1) * radiusCoor + 2;
            }
            else {
                endY = startY + arcHeight * radiusCoor + SIDE_LUFF_BODY_HEIGHT - height * heightCoor + 2;
            }
            //不能超出上顶点
            if (endY < startY)
                endY = startY;
            //超出画布底部,最大为画布的高度
            if (endY > CANVASHEIGHT_SIDE)
                endY = CANVASHEIGHT_SIDE;
            if (fall == 1) //1倍率
            {
                ctxSideView.moveTo(startX, startY);
                ctxSideView.lineTo(endX, endY);
                ctxSideView.stroke();
            }
            else //其他倍率默认绘制两倍率
            {
                ctxSideView.moveTo(startX - 3, startY);
                ctxSideView.lineTo(endX - 3, endY);
                ctxSideView.stroke();

                ctxSideView.moveTo(startX + 3, startY);
                ctxSideView.lineTo(endX + 3, endY);
                ctxSideView.stroke();
            }
            //绘制吊钩
            x = startX - HOCK_WIDTH / 2;
            if (height > sideViewTcH1) {
                y = endY = startY + arcHeight * radiusCoor - (height - sideViewTcH1) * radiusCoor;
            }
            else {
                y = startY + arcHeight * radiusCoor + SIDE_LUFF_BODY_HEIGHT - height * heightCoor;
            }
            if (y < startY)
                y = startY;
            ctxSideView.drawImage(imgHock, x, y);
            //绘制臂尖的遮盖矩形
            x = startX - SIDE_LUFF_JIB_RECT_WIDTH / 2;
            y = startY - SIDE_LUFF_JIB_RECT_HEIGHT / 2;
            if (y < startY)
                y = startY;
            ctxSideView.drawImage(imgLuffJibRect, x, y);
        }
    }

    /**
     * 绘制侧视图平臂
     */
    function drawSideViewFlat(time, load, radius, percent, angle, height, windspeed, safeLoad, fall, obliqueDirection, obliqueState, ObliqueAngle, radius1, height1) {
        if (ctxSideView == null)
            return;
        //清空绘图区域
        clearSideviewCanvas();
        //绘制侧视图
        ctxSideView.drawImage(imgPlat, SIDE_DRAW_X, SIDE_DRAW_Y);
        //ctxSideView.drawImage(imgWindSpeed,137-26/2,3);
        if (imgCar != null && imgHock != null) {
            var baseX = SIDE_DRAW_X + SIDE_DRAW_LEFT + SIDE_CAR_HOCK_ALIGN;
            var baseY = SIDE_DRAW_Y + SIDE_DRAW_TOP;
            var x = baseX + radius * radiusCoor;
            var y = baseY;
            //绘制小车
            ctxSideView.drawImage(imgCar, x, y);
            //绘制吊绳
            ctxSideView.lineWidth = 1;
            ctxSideView.strokeStyle = "#ec5e00";
            var yStart = baseY + CAR_HEIGHT;
            var yEnd = baseY - CAR_HEIGHT + SIDE_DRAW_HEIGHT - height * heightCoor + 2;
            if (fall == 4) {
                //最左侧
                ctxSideView.moveTo(x + 2, yStart);
                ctxSideView.lineTo(x + 2, yEnd);
                ctxSideView.stroke();
                //最右侧
                ctxSideView.moveTo(x + CAR_WIDTH - 2, yStart);
                ctxSideView.lineTo(x + CAR_WIDTH - 2, yEnd);
                ctxSideView.stroke();
            }
            //
            ctxSideView.moveTo(x + CAR_WIDTH / 3, yStart);
            ctxSideView.lineTo(x + CAR_WIDTH / 3, yEnd);
            ctxSideView.stroke();
            ctxSideView.moveTo(x + CAR_WIDTH / 3 * 2, yStart);
            ctxSideView.lineTo(x + CAR_WIDTH / 3 * 2, yEnd);
            ctxSideView.stroke();
            x = SIDE_DRAW_X + SIDE_DRAW_LEFT + radius * radiusCoor;
            y = baseY - CAR_HEIGHT + SIDE_DRAW_HEIGHT - height * heightCoor;
            //绘制重物
            ctxSideView.drawImage(imgHock, x, y);
            ctxSideView.stroke();
        }
    }

    function drawSideViewTopKit(time, load, radius, percent, angle, height, windspeed, safeLoad, fall, obliqueDirection, obliqueState, ObliqueAngle, radius1, height1) {
        if (ctxSideView == null)
            return;
        //清空绘图区域
        clearSideviewCanvas();
        //绘制侧视图
        ctxSideView.drawImage(imgTowerCrane, SIDE_DRAW_X, SIDE_DRAW_Y);
        ctxSideView.drawImage(imgWindSpeed, 137 - 26 / 2, 3);
        if (imgCar != null && imgHock != null) {
            var baseX = SIDE_DRAW_X + SIDE_DRAW_LEFT + SIDE_CAR_HOCK_ALIGN;
            var baseY = SIDE_DRAW_Y + SIDE_DRAW_TOP;
            var x = baseX + radius * radiusCoor;
            var y = baseY;
            //绘制小车
            ctxSideView.drawImage(imgCar, x, y);
            //绘制吊绳
            ctxSideView.lineWidth = 1;
            ctxSideView.strokeStyle = "#ec5e00";
            var yStart = baseY + CAR_HEIGHT;
            var yEnd = baseY - CAR_HEIGHT + SIDE_DRAW_HEIGHT - height * heightCoor + 2;
            if (fall == 4) {
                //最左侧
                ctxSideView.moveTo(x + 2, yStart);
                ctxSideView.lineTo(x + 2, yEnd);
                ctxSideView.stroke();
                //最右侧
                ctxSideView.moveTo(x + CAR_WIDTH - 2, yStart);
                ctxSideView.lineTo(x + CAR_WIDTH - 2, yEnd);
                ctxSideView.stroke();
            }
            //
            ctxSideView.moveTo(x + CAR_WIDTH / 3, yStart);
            ctxSideView.lineTo(x + CAR_WIDTH / 3, yEnd);
            ctxSideView.stroke();
            ctxSideView.moveTo(x + CAR_WIDTH / 3 * 2, yStart);
            ctxSideView.lineTo(x + CAR_WIDTH / 3 * 2, yEnd);
            ctxSideView.stroke();
            x = SIDE_DRAW_X + SIDE_DRAW_LEFT + radius * radiusCoor;
            y = baseY - CAR_HEIGHT + SIDE_DRAW_HEIGHT - height * heightCoor;
            //绘制重物
            ctxSideView.drawImage(imgHock, x, y);
            ctxSideView.stroke();
        }
    }

    function drawSideview(type, time, load, radius, percent, angle, height, windspeed, safeLoad, fall, obliqueDirection, obliqueState, ObliqueAngle, radius1, height1) {
        if (type == TC_FLAT) {
            drawSideViewFlat(realDataObj.time,
                realDataObj.load,
                currRadius,
                realDataObj.percent,
                realDataObj.angle,
                currHeight,
                realDataObj.windspeed,
                realDataObj.safeLoad,
                realDataObj.fall,
                realDataObj.obliqueDirection,
                realDataObj.obliqueState,
                realDataObj.ObliqueAngle,
                endRadius,
                endHeight);
        }
        else if (type == TC_LUFF) {
            drawSideViewLuff(realDataObj.time,
                realDataObj.load,
                currRadius,
                realDataObj.percent,
                realDataObj.angle,
                currHeight,
                realDataObj.windspeed,
                realDataObj.safeLoad,
                realDataObj.fall,
                realDataObj.obliqueDirection,
                realDataObj.obliqueState,
                realDataObj.ObliqueAngle,
                endRadius,
                endHeight);
        }
        else {
            drawSideViewTopKit(realDataObj.time,
                realDataObj.load,
                currRadius,
                realDataObj.percent,
                realDataObj.angle,
                currHeight,
                realDataObj.windspeed,
                realDataObj.safeLoad,
                realDataObj.fall,
                realDataObj.obliqueDirection,
                realDataObj.obliqueState,
                realDataObj.ObliqueAngle,
                endRadius,
                endHeight);
        }
        //绘制文本
        drawText(type,
            realDataObj.time,
            realDataObj.load,
            currRadius,
            realDataObj.percent,
            realDataObj.angle,
            currHeight,
            realDataObj.windspeed,
            realDataObj.safeLoad,
            realDataObj.fall,
            realDataObj.obliqueDirection,
            realDataObj.obliqueState,
            realDataObj.ObliqueAngle,
            realDataObj.radius,
            realDataObj.height);
    }

    function drawText(type, time, load, radius, percent, angle, height, windspeed, safeLoad, fall, obliqueDirection, obliqueState, ObliqueAngle, radius1, height1) {
        var baseX = SIDE_DRAW_X + SIDE_DRAW_LEFT + SIDE_CAR_HOCK_ALIGN;
        var baseY = SIDE_DRAW_Y + SIDE_DRAW_TOP;
        ctxSideView.fillStyle = "#FFFFFF";
        ctxSideView.lineWidth = 1;
        ctxSideView.font = "16px 黑体";
        var textX = baseX + 130;
        var textY = baseY + 180;
        var textHeiDis = 25;
        var textIdx = 0;
        //绘制文本
        var strRealTimeInfo = "前臂长：" + sideViewTcL1.toString().replace("NaN", "0") + "m";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        strRealTimeInfo = "塔机高：" + sideViewTcH1.toString().replace("NaN", "0") + "m";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        strRealTimeInfo = "载重：" + load.toString() + "t";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        strRealTimeInfo = type == TC_LUFF ? "仰角:" + radius1.toFixed(2).toString() + "°" : "幅度：" + radius1.toString() + "m";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        //if(hasHeight != 0)
        //{
        strRealTimeInfo = "高度：" + height1.toString() + "m";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        //}
        //if(hasGyration != 0 )
        //{
        strRealTimeInfo = "回转角度：" + angle.toString() + "°";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        // }
        //if(hasOblique != 0)
        //{
        strRealTimeInfo = "倾斜角度：" + ObliqueAngle.toString() + "°";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        // }
        //顶部的信息
        textX = SIDE_DRAW_X + 250;
        textY = SIDE_DRAW_Y + 10;
        textIdx = 0;
        //if(hasWindSpeed != 0)
        //{
        strRealTimeInfo = "风速:" + windspeed.toString() + "级";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        //}

        strRealTimeInfo = "力矩百分比：" + percent.toString() + "%";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        strRealTimeInfo = "安全吊重：" + safeLoad.toString() + "t";
        ctxSideView.fillText(strRealTimeInfo, textX + 40, textY + textIdx++ * textHeiDis);
        //左侧GPS信息
        textX = SIDE_DRAW_X;
        textY = SIDE_DRAW_Y + 310;
        textIdx = 0;
        if (latitude != 0 && longtitude != 0) {
            strRealTimeInfo = "GPRS坐标:";
            ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
            strRealTimeInfo = "北纬:" + latitude.toString();
            ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
            strRealTimeInfo = "东经:" + longtitude.toString();
            ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        }

        textIdx++;
        strRealTimeInfo = "数据发送时间:";
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        strRealTimeInfo = time.toString();
        ctxSideView.fillText(strRealTimeInfo, textX, textY + textIdx++ * textHeiDis);
        ctxSideView.strokeStyle = "#00af0b";
        ctxSideView.stroke();
    }

</script>

<style>
    #main {
        width: 100%;
        height: 600px;
    }
    #leftInfo {
        width: 30em;
        height: 37.3em;
        background-color: black;
        border: solid #3265A7 2px;
        float: left;
    }
    select {
        font-size: 16px;
        font-family: "黑体";
    }
    #rightInfo {
        width: 29.3em;
        height: 37.3em;
        background-color: black;
        float: left;
        border: solid #3265A7 2px;
    }
    #msgInfo {
        width: 100%;
        height: 8em;
        background-color: black;
        border-bottom: solid #3265A7 2px;
        float: left;
    }
    .deviceinfo {
        width: 6em;
        height: 130px;
        float: left;
        margin-top: 15px;
    }
    .normalFont {
        font-size: 16px;
        font-family: 黑体;
        color: white;
        text-align: center;
    }
    .deviceinfo {
        width: 6em;
        height: 130px;
        float: left;
        margin-top: 15px;
    }
    .msgInfo_table {
        position: relative;
        top: 1em;
    }
    .elevator td {
        width: 10vw;
        font-size: 18px;
        font-family: 黑体;
        color: white;
        text-align: left;
    }
    .hidinfo {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    #driverInfo {
        width: 450px;
        height: 28em;
        float: left;
    }
    #overlookCanvas {
        margin: 8px 0px auto 9px;
        background-color: black;
    }
    .Identification {
        position: relative;
        margin: -2vw 4vw 0px 0px;
    }
    #alarmInfo {
        position: absolute;
        width: 30.1em;
        height: 3.9vw;
        background-color: black;
        border: solid #3265A7 2px;
        border-left: 0px;
        top: 34em;
    }
</style>