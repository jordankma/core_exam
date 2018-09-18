<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img src="{!! asset('/vendor/' . $group_name . '/' . $skin . '/images/authors/no_avatar.jpg') !!}" alt="img" height="35px" width="35px"
             class="img-circle img-responsive pull-left"/>
        <div class="riot">
            <div>
                <p class="user_name_max">{{ $USER_LOGGED->contact_name }}</p>
                <span><i class="caret"></i></span>
            </div>
        </div>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header bg-light-blue">
            <img src="{!! asset('/vendor/' . $group_name . '/' . $skin . '/images/authors/no_avatar.jpg') !!}" alt="img" height="35px" width="35px"
                 class="img-circle img-responsive pull-left"/>
        </li>
        <li class="user-footer">
            <div class="pull-right">
                <a href="{{ URL::route('adtech.core.auth.logout') }}">
                    <i class="livicon" data-name="sign-out" data-s="15"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</li>
