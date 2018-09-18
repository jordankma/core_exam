<li class="dropdown">
    <ul class="dropdown-menu">
        @if (count($LOCALES) > 0)
            @foreach($LOCALES as $locale)
                @if ($locale->alias == config('app.locale'))
                <?php $localeCurrent = $locale; ?>
                @endif
                <li style="padding: 3px 5px">
                    <a href="{{ route("adtech.core.setting.set-language", ['language' => $locale->alias]) }}" style="padding: 3px">
                        <span><img src="{{ config('site.url_storage') . '/' . $locale->icon }}" width="20px" height="20px" />&nbsp;&nbsp;&nbsp;{{ $locale->name }}</span>
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 5px">
        @if (isset($localeCurrent))
        <span><img src="{{ config('site.url_storage') . '/' . $localeCurrent->icon }}" width="40px" height="40px" /></span>
        @endif
    </a>
</li>
