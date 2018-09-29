<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cocos2d-html5 Hello World test</title>
  
    <meta name="viewport" content="initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="screen-orientation" content="portrait"/>
    <meta name="x5-fullscreen" content="true"/>
    <meta name="360-fullscreen" content="true"/>

</head>
<body style="padding: 0px;margin-top: -51px">
<script src="{{ asset('client/cocos/res/loading.js') }}"></script>

<canvas id="gameCanvas" width="1900px" height="1070px"></canvas>
{{-- <input type="hidden" name="game_token" id="token_key" value="{{ $_GET['game_token'] }}"/>
<input type="hidden" name="uid" id="uid" value="{{ $_GET['uid'] }}"/>
<input type="hidden" name="ip_port" id="ip_port" value="{{ $_GET['ip_port'] }}"/>
<input type="hidden" name="link" id="link" value="http://renluyendoivien.vn/"/>
<input type="hidden" name="link1" id="link1" value="http://renluyendoivien.vn/"/>
<input type="hidden" name="linkaudio" id="linkaudio" value="res/sound/"/> --}}
<input type="hidden" name="game_token" id="token_key" value="minhnt"/>
<input type="hidden" name="link" id="link" value="http://renluyendoivien.vn/"/>
<input type="hidden" name="linkaudio" id="linkaudio" value="res/sound/"/>
<input type="hidden" name="link1" id="link1" value="http://renluyendoivien.vn/"/>
<input type="hidden" name ="ip_port" value="http://123.30.174.148:4555/">


<script cocos src="{{ asset('client/cocos/game.min.js?v=0.0.1') }}"></script>
<style>
    body, canvas, div {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        -khtml-user-select: none;
    }
    #Cocos2dGameContainer{
        width: 890px !important;
        height: 560px !important;
        margin: 0px 1px !important;
        position: relative !important;
        overflow: hidden !important;
    }
    #gameCanvas{
        width: 920px !important;
    }
</style>
</body>
</html>