<!DOCTYPE html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>FROKOST</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @stack('styles')
    </head>
    <body class="h-100">
        <div class="jumbotron jumbotron-fluid h-100 mb-0" style="background-image: url({{ asset('images/lunch.jpg') }}); background-size: cover;">
            <div class="container">
                <div class="row">
                    <div class="col col-lg-6">
                        <div class="card shadow-lg text-center rounded-pill border-0">
                            <div class="card-body px-6">
                                <h1 class="display-3 text-danger">FROKOST</h1>
                                <p class="lead">Choose who's gonna get lunch with an impartial robot.</p>
                                <a href="https://slack.com/oauth/authorize?scope=bot&client_id=7507495621.821163576727"><img alt=""Add to Slack"" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" />
                                    <span class="sr-only">
                                        Add to Slack
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ mix('js/manifest.js') }}"></script>
        <script src="{{ mix('js/vendor.js') }}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        @stack('scripts')
    </body>
</html>
