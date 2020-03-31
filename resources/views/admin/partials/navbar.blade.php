<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-logo">
            <a href="/">
                <b class="uppercase logo-default">Mudaw<span class="font-red">ana</span></b>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
            data-target=".navbar-collapse">
            <span></span>
        </a>
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <span class="username username-hide-on-mobile"> {{ Auth()->user()->name }} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="icon-key"></i> <span>
                                    {{ trans('admin.log_out') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <i class="fa fa-language" aria-hidden="true"></i>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        @if (direction() == 'ltr')
                        <li>
                            <a href="/admin/lang/ar"> <i class="fa fa-globe" aria-hidden="true"></i>
                                {{ trans('admin.arabic') }}</a>
                        </li>
                        @else
                        <li>
                            <a href="/admin/lang/en"> <i class="fa fa-globe" aria-hidden="true"></i>
                                {{ trans('admin.english') }} </a>
                        </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="clearfix"> </div>

<div class="page-container">
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200" style="padding-top: 20px">
                <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                </li>
                <li class="{{ (request()->is('/*')) ? 'active' : '' }}">
                    <a href="/" class="nav-link">
                        <i class="fa fa-home font-green"></i>
                        <span class="title">{{ trans('admin.home') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->is('admin/comments*')) ? 'active' : '' }}">
                    <a href="/admin/comments" class="nav-link">
                        <i class="fa fa-comments font-green"></i>
                        <span class="title">{{ trans('admin.comments') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->is('admin/posts*')) ? 'active' : '' }}">
                    <a href="/admin/posts" class="nav-link">
                        <i class="fa fa-sticky-note-o font-green"></i>
                        <span class="title">{{ trans('admin.posts') }}</span>
                    </a>
                </li>
                <li class="{{ (request()->is('admin/tags*')) ? 'active' : '' }}">
                    <a href="/admin/tags" class="nav-link">
                        <i class="fa fa-tags font-green"></i>
                        <span class="title">{{ trans('admin.tags') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @include('admin.partials.menu')
</div>