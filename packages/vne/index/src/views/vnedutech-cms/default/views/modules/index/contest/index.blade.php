<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thi thử | Cuộc thi tìm hiểu về biển, đảo Việt Nam</title>
  
    <meta name="viewport" content="initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="screen-orientation" content="portrait"/>
    <meta name="x5-fullscreen" content="true"/>
    <meta name="360-fullscreen" content="true"/>

    <style>
        body, canvas, div {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            -khtml-user-select: none;
        }
        #button_back {
            position: absolute;
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 30px;
        }
        #button_back a{
            text-decoration: none;
            color: white;
        }
    </style>

</head>
<body>
<script src="{{ asset('client/cocos/res/loading.js') }}"></script>
<button id="button_back"><a href="http://timhieubiendao.daknong.vn/">Trở về trang chủ</a></button>
<canvas id="gameCanvas" width="1140px" height="700px"></canvas>
<input type="hidden" name="game_token" id="token_key" value="{{ $game_token }}"/>
<input type="hidden" name="uid" id="uid" value="{{ $uid }}"/>
<input type="hidden" name="ip_port" id="ip_port" value="{{ $ip_port }}"/>
<input type="hidden" name="linkresult" id="link" value="http://timhieubiendao.daknong.vn/"/>
<input type="hidden" name="linkhome" id="link1" value="http://timhieubiendao.daknong.vn/"/>
<input type="hidden" name="linkaudio" id="linkaudio" value="res/sound/"/>
<input type="hidden" name="test" id="test" value="true"/>

<script cocos src="{{ asset('client/cocos/game.min.js?v=0.0.9') }}"></script>
</body>
</html>