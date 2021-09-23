<x-app-layout>
    <!--    --><?php //var_dump($view)?>
    <div class="container">
        <div class="view-account">
            <section class="module">
                <div class="module-inner">
                    <div class="side-bar">
                        <div class="user-info">
                            <img class="img-profile img-circle img-responsive center-block"
                                 src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="">
                            <ul class="meta list list-unstyled">
                                <li class="name">{{ Auth::user()->name }}
                                    <label class="label label-info">UX Designer</label>
                                </li>
                                <li class="email"><a href="#">{{ Auth::user()->email }}</a></li>
                                <li class="activity">Last logged in: Today at 2:18pm</li>
                            </ul>
                        </div>
                        <nav class="side-menu">
                            <ul class="nav">
                                <li><a href="#"><span class="fa fa-user"></span> Profile</a></li>
                                <li><a href="#"><span class="fa fa-cog"></span> Settings</a></li>
                                <li class=""><a href="#"><span class="fa fa-credit-card"></span> Billing</a></li>
                                <li><a href="#"><span class="fa fa-envelope"></span> Messages</a></li>

                                <li class="active"><a href="#"><span class="fa fa-th"></span> Drive</a></li>
                                <li><a href="#"><span class="fa fa-clock-o"></span> Reminders</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="content-panel">
                        <div class="content-header-wrapper">
                            <h2 class="title"><a href="/dashboard">My Drive</a></h2>
                            <div class="actions">
                                <button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Upload attached file
                                </button>
                            </div>
                        </div>
                        <div class="content-utilities">
                            <div class="actions">
                                <div class="btn-group">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button"
                                            aria-expanded="false">All Items <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"><i class="fa fa-file"></i> Documents</a></li>
                                        <li><a href="#"><i class="fa fa-file-image-o"></i> Images</a></li>
                                        <li><a href="#"><i class="fa fa-file-video-o"></i> Media Files</a></li>
                                        <li><a href="#"><i class="fa fa-folder"></i> Folders</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button"
                                            aria-expanded="false"><i class="fa fa-filter"></i> Sorting <span
                                            class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Newest first</a></li>
                                        <li><a href="#">Oldest first</a></li>
                                    </ul>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="bottom" title="" data-original-title="Refresh">
                                        <i class="fa fa-refresh"></i></button>
                                    <button type="button" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="bottom" title="" data-original-title="Archive">
                                        <i class="fa fa-archive"></i></button>

                                    <button type="button" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="bottom" title="" data-original-title="Report spam">
                                        <i class="fa fa-exclamation-triangle"></i></button>
                                    <button type="button" class="btn btn-default" data-toggle="tooltip"
                                            data-placement="bottom" title="" data-original-title="Delete">
                                        <i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="drive-wrapper drive-list-view">
                            <div class="table-responsive drive-items-table-wrapper">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="name truncate">Name</th>
                                        <th class="size">Type</th>
                                        <th class="size">Path</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="form module-footer form-control-plaintext">
                                                <input type="text" name="name" value="{{$view['shortName']??''}}">
                                                <input type="submit" class="btn btn-sm btn-success" value="Save rename">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form module-footer form-control-plaintext">
                                                {{$view['type']??''}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form module-footer form-control-plaintext">
                                                {{$view['fullName']??''}}
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div>
                                    <form action="/getmodels?dir={{$view['fullName']??''}}" method="post" id="change-model" name="changemodel">
                                        @csrf
                                        <fieldset>
                                            <label for="change-model">Select model:</label>
                                            <select onchange="document.changemodel.submit()" name="page"
                                                    id="change-model">
                                                <option value="#" @if ($view['modelled']==='') selected @endif>Default</option>
                                                <option value="messages" @if ($view['modelled']==='Message') selected @endif>Messages</option>
                                                <option value="schemas" @if ($view['modelled']==='Schemas') selected @endif>Schemas</option>
                                                <option value="reports" @if ($view['modelled']==='Reports') selected @endif>Reports</option>
                                                <option value="acts" @if ($view['modelled']==='Acts') selected @endif>Acts</option>
                                                <option value="certificates" @if ($view['modelled']==='Certificates') selected @endif>Сertificates</option>
                                                <option value="estimates" @if ($view['modelled']==='Estimates') selected @endif>Estimates</option>
                                                <option value="contracts" @if ($view['modelled']==='Contracts') selected @endif>Contracts</option>
                                                <option value="requests" @if ($view['modelled']==='Requests') selected @endif>Requests</option>
                                            </select>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <form action="/save" method="post">
                                @csrf
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="name truncate">Name metadata</th>
                                        <th class="size">Value metadata (editable)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="form module-footer form-control-plaintext">
                                                Title:
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form module-footer form-control-plaintext">
                                                <input type="text" name="title" value="{{$view['title']??''}}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form module-footer form-control-plaintext">
                                                Description:
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form module-footer form-control-plaintext">
                                                <input type="text" name="description"
                                                       value="{{$view['description']??''}}">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form module-footer form-control-plaintext">
                                                Comment:
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form module-footer form-control-plaintext">
                                                <input type="text" name="comment" value="{{$view['comment']??''}}">
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" name="guid" value="{{json_encode($view)}}">
                                <input type="submit" class="btn btn-sm btn-success" value="Save">
                                <a class="btn btn-sm btn-danger" href="/dashboard?dir={{ dirname($view['fullName']??'') }}">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <style type="text/css">
        body {
            background: #f9f9fb;
        }

        .view-account {
            background: #FFFFFF;
            margin-top: 20px;
        }

        .view-account .pro-label {
            font-size: 13px;
            padding: 4px 5px;
            position: relative;
            top: -5px;
            margin-left: 10px;
            display: inline-block
        }

        .view-account .side-bar {
            padding-bottom: 30px
        }

        .view-account .side-bar .user-info {
            text-align: center;
            margin-bottom: 15px;
            padding: 30px;
            color: #616670;
            border-bottom: 1px solid #f3f3f3
        }

        .view-account .side-bar .user-info .img-profile {
            width: 120px;
            height: 120px;
            margin-bottom: 15px
        }

        .view-account .side-bar .user-info .meta li {
            margin-bottom: 10px
        }

        .view-account .side-bar .user-info .meta li span {
            display: inline-block;
            width: 100px;
            margin-right: 5px;
            text-align: right
        }

        .view-account .side-bar .user-info .meta li a {
            color: #616670
        }

        .view-account .side-bar .user-info .meta li.activity {
            color: #a2a6af
        }

        .view-account .side-bar .side-menu {
            text-align: center
        }

        .view-account .side-bar .side-menu .nav {
            display: inline-block;
            margin: 0 auto
        }

        .view-account .side-bar .side-menu .nav > li {
            font-size: 14px;
            margin-bottom: 0;
            border-bottom: none;
            display: inline-block;
            float: left;
            margin-right: 15px;
            margin-bottom: 15px
        }

        .view-account .side-bar .side-menu .nav > li:last-child {
            margin-right: 0
        }

        .view-account .side-bar .side-menu .nav > li > a {
            display: inline-block;
            color: #9499a3;
            padding: 5px;
            border-bottom: 2px solid transparent
        }

        .view-account .side-bar .side-menu .nav > li > a:hover {
            color: #616670;
            background: none
        }

        .view-account .side-bar .side-menu .nav > li.active a {
            color: #40babd;
            border-bottom: 2px solid #40babd;
            background: none;
            border-right: none
        }

        .theme-2 .view-account .side-bar .side-menu .nav > li.active a {
            color: #6dbd63;
            border-bottom-color: #6dbd63
        }

        .theme-3 .view-account .side-bar .side-menu .nav > li.active a {
            color: #497cb1;
            border-bottom-color: #497cb1
        }

        .theme-4 .view-account .side-bar .side-menu .nav > li.active a {
            color: #ec6952;
            border-bottom-color: #ec6952
        }

        .view-account .side-bar .side-menu .nav > li .icon {
            display: block;
            font-size: 24px;
            margin-bottom: 5px
        }

        .view-account .content-panel {
            padding: 30px
        }

        .view-account .content-panel .title {
            margin-bottom: 15px;
            margin-top: 0;
            font-size: 18px
        }

        .view-account .content-panel .fieldset-title {
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaf1;
            margin-bottom: 30px;
            color: #616670;
            font-size: 16px
        }

        .view-account .content-panel .avatar .figure img {
            float: right;
            width: 64px
        }

        .view-account .content-panel .content-header-wrapper {
            position: relative;
            margin-bottom: 30px
        }

        .view-account .content-panel .content-header-wrapper .actions {
            position: absolute;
            right: 0;
            top: 0
        }

        .view-account .content-panel .content-utilities {
            position: relative;
            margin-bottom: 30px
        }

        .view-account .content-panel .content-utilities .btn-group {
            margin-right: 5px;
            margin-bottom: 15px
        }

        .view-account .content-panel .content-utilities .fa {
            font-size: 16px;
            margin-right: 0
        }

        .view-account .content-panel .content-utilities .page-nav {
            position: absolute;
            right: 0;
            top: 0
        }

        .view-account .content-panel .content-utilities .page-nav .btn-group {
            margin-bottom: 0
        }

        .view-account .content-panel .content-utilities .page-nav .indicator {
            color: #a2a6af;
            margin-right: 5px;
            display: inline-block
        }

        .view-account .content-panel .mails-wrapper .mail-item {
            position: relative;
            padding: 10px;
            border-bottom: 1px solid #f3f3f3;
            color: #616670;
            overflow: hidden
        }

        .view-account .content-panel .mails-wrapper .mail-item > div {
            float: left
        }

        .view-account .content-panel .mails-wrapper .mail-item .icheck {
            background-color: #fff
        }

        .view-account .content-panel .mails-wrapper .mail-item:hover {
            background: #f9f9fb
        }

        .view-account .content-panel .mails-wrapper .mail-item:nth-child(even) {
            background: #fcfcfd
        }

        .view-account .content-panel .mails-wrapper .mail-item:nth-child(even):hover {
            background: #f9f9fb
        }

        .view-account .content-panel .mails-wrapper .mail-item a {
            color: #616670
        }

        .view-account .content-panel .mails-wrapper .mail-item a:hover {
            color: #494d55;
            text-decoration: none
        }

        .view-account .content-panel .mails-wrapper .mail-item .checkbox-container,
        .view-account .content-panel .mails-wrapper .mail-item .star-container {
            display: inline-block;
            margin-right: 5px
        }

        .view-account .content-panel .mails-wrapper .mail-item .star-container .fa {
            color: #a2a6af;
            font-size: 16px;
            vertical-align: middle
        }

        .view-account .content-panel .mails-wrapper .mail-item .star-container .fa.fa-star {
            color: #f2b542
        }

        .view-account .content-panel .mails-wrapper .mail-item .star-container .fa:hover {
            color: #868c97
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-to {
            display: inline-block;
            margin-right: 5px;
            min-width: 120px
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-subject {
            display: inline-block;
            margin-right: 5px
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-subject .label {
            margin-right: 5px
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-subject .label:last-child {
            margin-right: 10px
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-subject .label a,
        .view-account .content-panel .mails-wrapper .mail-item .mail-subject .label a:hover {
            color: #fff
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-1 {
            background: #f77b6b
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-2 {
            background: #58bbee
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-3 {
            background: #f8a13f
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-4 {
            background: #ea5395
        }

        .view-account .content-panel .mails-wrapper .mail-item .mail-subject .label-color-5 {
            background: #8a40a7
        }

        .view-account .content-panel .mails-wrapper .mail-item .time-container {
            display: inline-block;
            position: absolute;
            right: 10px;
            top: 10px;
            color: #a2a6af;
            text-align: left
        }

        .view-account .content-panel .mails-wrapper .mail-item .time-container .attachment-container {
            display: inline-block;
            color: #a2a6af;
            margin-right: 5px
        }

        .view-account .content-panel .mails-wrapper .mail-item .time-container .time {
            display: inline-block;
            text-align: right
        }

        .view-account .content-panel .mails-wrapper .mail-item .time-container .time.today {
            font-weight: 700;
            color: #494d55
        }

        .drive-wrapper {
            padding: 15px;
            background: #f5f5f5;
            overflow: hidden
        }

        .drive-wrapper .drive-item {
            width: 130px;
            margin-right: 15px;
            display: inline-block;
            float: left
        }

        .drive-wrapper .drive-item:hover {
            box-shadow: 0 1px 5px rgba(0, 0, 0, .1);
            z-index: 1
        }

        .drive-wrapper .drive-item-inner {
            padding: 15px
        }

        .drive-wrapper .drive-item-title {
            margin-bottom: 15px;
            max-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis
        }

        .drive-wrapper .drive-item-title a {
            color: #494d55
        }

        .drive-wrapper .drive-item-title a:hover {
            color: #40babd
        }

        .theme-2 .drive-wrapper .drive-item-title a:hover {
            color: #6dbd63
        }

        .theme-3 .drive-wrapper .drive-item-title a:hover {
            color: #497cb1
        }

        .theme-4 .drive-wrapper .drive-item-title a:hover {
            color: #ec6952
        }

        .drive-wrapper .drive-item-thumb {
            width: 100px;
            height: 80px;
            margin: 0 auto;
            color: #616670
        }

        .drive-wrapper .drive-item-thumb a {
            -webkit-opacity: .8;
            -moz-opacity: .8;
            opacity: .8
        }

        .drive-wrapper .drive-item-thumb a:hover {
            -webkit-opacity: 1;
            -moz-opacity: 1;
            opacity: 1
        }

        .drive-wrapper .drive-item-thumb .fa {
            display: inline-block;
            font-size: 36px;
            margin: 0 auto;
            margin-top: 20px
        }

        .drive-wrapper .drive-item-footer .utilities {
            margin-bottom: 0
        }

        .drive-wrapper .drive-item-footer .utilities li:last-child {
            padding-right: 0
        }

        .drive-list-view .name {
            width: 60%
        }

        .drive-list-view .name.truncate {
            max-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis
        }

        .drive-list-view .type {
            width: 15px
        }

        .drive-list-view .date,
        .drive-list-view .size {
            max-width: 60px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis
        }

        .drive-list-view a {
            color: #494d55
        }

        .drive-list-view a:hover {
            color: #40babd
        }

        .theme-2 .drive-list-view a:hover {
            color: #6dbd63
        }

        .theme-3 .drive-list-view a:hover {
            color: #497cb1
        }

        .theme-4 .drive-list-view a:hover {
            color: #ec6952
        }

        .drive-list-view td.date,
        .drive-list-view td.size {
            color: #a2a6af
        }

        @media (max-width: 767px) {
            .view-account .content-panel .title {
                text-align: center
            }

            .view-account .side-bar .user-info {
                padding: 0
            }

            .view-account .side-bar .user-info .img-profile {
                width: 60px;
                height: 60px
            }

            .view-account .side-bar .user-info .meta li {
                margin-bottom: 5px
            }

            .view-account .content-panel .content-header-wrapper .actions {
                position: static;
                margin-bottom: 30px
            }

            .view-account .content-panel {
                padding: 0
            }

            .view-account .content-panel .content-utilities .page-nav {
                position: static;
                margin-bottom: 15px
            }

            .drive-wrapper .drive-item {
                width: 100px;
                margin-right: 5px;
                float: none
            }

            .drive-wrapper .drive-item-thumb {
                width: auto;
                height: 54px
            }

            .drive-wrapper .drive-item-thumb .fa {
                font-size: 24px;
                padding-top: 0
            }

            .view-account .content-panel .avatar .figure img {
                float: none;
                margin-bottom: 15px
            }

            .view-account .file-uploader {
                margin-bottom: 15px
            }

            .view-account .mail-subject {
                max-width: 100px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis
            }

            .view-account .content-panel .mails-wrapper .mail-item .time-container {
                position: static
            }

            .view-account .content-panel .mails-wrapper .mail-item .time-container .time {
                width: auto;
                text-align: left
            }
        }

        @media (min-width: 768px) {
            .view-account .side-bar .user-info {
                padding: 0;
                padding-bottom: 15px
            }

            .view-account .mail-subject .subject {
                max-width: 200px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis
            }
        }

        @media (min-width: 992px) {
            .view-account .content-panel {
                min-height: 800px;
                border-left: 1px solid #f3f3f7;
                margin-left: 200px
            }

            .view-account .mail-subject .subject {
                max-width: 280px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis
            }

            .view-account .side-bar {
                position: absolute;
                width: 200px;
                min-height: 600px
            }

            .view-account .side-bar .user-info {
                margin-bottom: 0;
                border-bottom: none;
                padding: 30px
            }

            .view-account .side-bar .user-info .img-profile {
                width: 120px;
                height: 120px
            }

            .view-account .side-bar .side-menu {
                text-align: left
            }

            .view-account .side-bar .side-menu .nav {
                display: block
            }

            .view-account .side-bar .side-menu .nav > li {
                display: block;
                float: none;
                font-size: 14px;
                border-bottom: 1px solid #f3f3f7;
                margin-right: 0;
                margin-bottom: 0
            }

            .view-account .side-bar .side-menu .nav > li > a {
                display: block;
                color: #9499a3;
                padding: 10px 15px;
                padding-left: 30px
            }

            .view-account .side-bar .side-menu .nav > li > a:hover {
                background: #f9f9fb
            }

            .view-account .side-bar .side-menu .nav > li.active a {
                background: #f9f9fb;
                border-right: 4px solid #40babd;
                border-bottom: none
            }

            .theme-2 .view-account .side-bar .side-menu .nav > li.active a {
                border-right-color: #6dbd63
            }

            .theme-3 .view-account .side-bar .side-menu .nav > li.active a {
                border-right-color: #497cb1
            }

            .theme-4 .view-account .side-bar .side-menu .nav > li.active a {
                border-right-color: #ec6952
            }

            .view-account .side-bar .side-menu .nav > li .icon {
                font-size: 24px;
                vertical-align: middle;
                text-align: center;
                width: 40px;
                display: inline-block
            }
        }

        .module {
            border: 1px solid #f3f3f3;
            border-bottom-width: 2px;
            background: #fff;
            margin-bottom: 30px;
            position: relative;
            border-radius: 4px;
            background-clip: padding-box;
        }

        .module .module-footer {
            background: #fff;
            border-top: 1px solid #f3f3f7;
            padding: 15px;
        }

        .module .module-footer a {
            color: #9499a3;
        }
    </style>

    <script type="text/javascript">
        $(function () {
            $("[data-toggle='tooltip']").tooltip();
        })
    </script>
</x-app-layout>
