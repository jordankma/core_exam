<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thi thật | Cuộc thi tìm hiểu về biển, đảo Việt Nam</title>
  
    <meta name="viewport" content="initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="screen-orientation" content="portrait"/>
    <meta name="x5-fullscreen" content="true"/>
    <meta name="360-fullscreen" content="true"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127077588-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-127077588-1');
    </script>
    <style>
        body, canvas, div {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            -khtml-user-select: none;
        }
    </style>

</head>
<body>
<script src="{{ asset('client/cocos_test/res/loading.js') }}"></script>
<canvas id="gameCanvas" width="1140px" height="700px"></canvas>
<button id="button_back"><a href="http://timhieubiendao.daknong.vn/">Trở về trang chủ</a></button>
<input type="hidden" name="game_token" id="token_key" value="{{ $game_token }}"/>
<input type="hidden" name="uid" id="uid" value="{{ $uid }}"/>
<input type="hidden" name="ip_port" id="ip_port" value="{{ $ip_port }}"/>
<input type="hidden" name="linkresult" id="link" value="{{ $url_result }}"/>
<input type="hidden" name="linkhome" id="link1" value="http://timhieubiendao.daknong.vn/"/>
<input type="hidden" name="linkaudio" id="linkaudio" value="res/sound/"/>
<input type="hidden" name="test" id="test" value="false"/>
<script cocos src="{{ asset('client/cocos_test/game.min.js?v=0.0.12') }}"></script>
</body>
</html>