
<div class="wrapper">
    <div id="main-exam">
        <div id="play-game" class="">
            <div class="play-main">
                <div class="play-content">
                    <div class="game">
                        <style>
                            iframe,game{
                                overflow: hidden;
                                z-index: -1000;
                            }
                        </style>
                        {{--<iframe width="902px" height="600px" style="margin-left:50px" src="/files/game_rldv/thithu5/index.php?game_token={$token}&link=http://renluyendoivien.vn/front/site/result?p=ur&uid={$uid}&type={$type}"></iframe>--}}
                        <iframe width="902px" height="600px" style="margin-left:50px"
                                src="{!! $src !!}}"></iframe>
                    </div>
                </div>
                {{--<a href="{!! $url_close !!}" class="exam-close">--}}
                    {{--<img src="/files/images/close.png" />--}}
                {{--</a>--}}
            </div>
        </div>
    </div>
</div>