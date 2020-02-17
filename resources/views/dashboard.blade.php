<!DOCTYPE html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard – FROKOST</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @stack('styles')
    </head>
    <body class="h-100 bg-pattern">
        <div class="jumbotron jumbotron-fluid h-100 mb-0 bg-transparent">
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col my-auto">
                        <div class="text-left text-light mb-4">
                            <h1 class="display-4">Dashboard</h1>
                        </div>
                        <form method="POST" action="{{ route('slack.settings.update', $slack) }}" class="card shadow border-0 rounded mb-4">
                            @method('PUT')
                            @csrf

                            <div class="row no-gutters rounded">
                                <div class="col-12 col-lg-6">
                                    <div class="card-header bg-transparent">
                                        <div class="row no-gutters">
                                            <div class="col">
                                                <strong>{{ $slack->team_name }}</strong>
                                            </div>
                                            <div class="col text-right">
                                                <div class="custom-control custom-switch">
                                                    <input name="active" type="checkbox" class="custom-control-input" id="active" value="1" {{ old('active', $slack->setting('active', true)) === true ? 'checked="checked"' : '' }}>
                                                    <label class="custom-control-label" for="active">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body py-6">
                                        <div class="form-group mb-4">
                                            <label for="presence">Whom should be chosen?</label>
                                            <select name="presence" class="custom-select" id="presence">
                                                <option value="all" {{ old('presence', $slack->setting('presence', 'all')) === 'all' ? 'selected' : '' }}>Everyone</option>
                                                <option value="active" {{ old('presence', $slack->setting('presence')) === 'active' ? 'selected' : '' }}>Active-only</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="count">How many unlucky users to choose for lunch?</label>
                                            <input name="count" type="number" class="form-control" id="count" placeholder="1" value="{{ old('count', $slack->setting('count')) }}">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="timeslot">When should they be picked?</label>
                                            <div class="input-group">
                                                <select name="timeslot" class="custom-select" id="timeslot">
                                                    {{-- 10 --}}
                                                    <option value="10:00" {{ old('timeslot', $slack->setting('timeslot')) === '10:00' ? 'selected' : '' }}>10:00</option>
                                                    <option value="10:15" {{ old('timeslot', $slack->setting('timeslot')) === '10:15' ? 'selected' : '' }}>10:15</option>
                                                    <option value="10:30" {{ old('timeslot', $slack->setting('timeslot')) === '10:30' ? 'selected' : '' }}>10:30</option>
                                                    <option value="10:45" {{ old('timeslot', $slack->setting('timeslot')) === '10:45' ? 'selected' : '' }}>10:45</option>
                                                    {{-- 11 --}}
                                                    <option value="11:00" {{ old('timeslot', $slack->setting('timeslot')) === '11:00' ? 'selected' : '' }}>11:00</option>
                                                    <option value="11:15" {{ old('timeslot', $slack->setting('timeslot')) === '11:15' ? 'selected' : '' }}>11:15</option>
                                                    <option value="11:30" {{ old('timeslot', $slack->setting('timeslot', '11:30')) === '11:30' ? 'selected' : '' }}>11:30</option>
                                                    <option value="11:45" {{ old('timeslot', $slack->setting('timeslot')) === '11:45' ? 'selected' : '' }}>11:45</option>
                                                    {{-- 12 --}}
                                                    <option value="12:00" {{ old('timeslot', $slack->setting('timeslot')) === '12:00' ? 'selected' : '' }}>12:00</option>
                                                    <option value="12:15" {{ old('timeslot', $slack->setting('timeslot')) === '12:15' ? 'selected' : '' }}>12:15</option>
                                                    <option value="12:30" {{ old('timeslot', $slack->setting('timeslot')) === '12:30' ? 'selected' : '' }}>12:30</option>
                                                    <option value="12:45" {{ old('timeslot', $slack->setting('timeslot')) === '12:45' ? 'selected' : '' }}>12:45</option>
                                                </select>
                                                <div class="input-group-append">
                                                    <label class="input-group-text bg-primary border-primary text-white">UTC</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="channel">What channel to tag them in?</label>
                                            <input name="channel" type="text" class="form-control" id="channel" placeholder="#general" value="{{ old('channel', $slack->setting('channel')) }}">
                                            <div class="form-text text-muted">
                                                Default channel is <code>#general</code>. For any other channel, you must specify the channel ID.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="language">What language to send the message in?</label>
                                            <select name="language" class="custom-select" id="language">
                                                <option value="en" {{ old('language', $slack->setting('language', 'en')) === 'en' ? 'selected' : '' }}>English</option>
                                                <option value="da" {{ old('language', $slack->setting('language')) === 'da' ? 'selected' : '' }}>Danish</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="row">
                                            <div class="col-auto my-auto">
                                                @if (session()->has('toast'))
                                                    <span class="text-success">
                                                        {{ session('toast') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col text-right">
                                                <button type="submit" class="btn btn-primary px-6">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="d-flex h-100 align-items-end rounded-right" style="background-image: url({{ asset('images/lunch2.jpg') }}); background-size: cover;">
                                        @if ($statistics->isNotEmpty())
                                            <ul class="list-group w-100 m-4 shadow-sm">
                                                <li class="list-group-item">
                                                    <div class="row no-gutters py-2">
                                                        <div class="col-auto my-auto">
                                                            <h4 class="my-0">FROKOST</h4>
                                                        </div>
                                                        <div class="col my-auto text-right text-danger text-uppercase font-weight-bold">
                                                            Top 10
                                                        </div>
                                                    </div>
                                                </li>
                                                @foreach ($statistics as $statistic)
                                                    <li class="list-group-item">
                                                        <div class="row no-gutters">
                                                            <div class="col-9 col-lg-auto">{{ $statistic->value }}</div>
                                                            <div class="col-3 col-lg text-right">{{ $statistic->total }}</div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('slack.message.post', $slack) }}">
                            @csrf
                            <div class="row no-gutters">
                                <div class="col-12 col-lg-6">
                                    <div class="card shadow border-0 rounded mb-4">
                                        <div class="card-header bg-transparent">
                                            <strong>Send a message via FROKOST bot.</strong>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="message">What would you like your message to say?</label>
                                                <textarea name="message" class="form-control" id="message" placeholder="Hello World!" required="required">{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <div class="row">
                                                <div class="col text-right">
                                                    <button type="submit" class="btn btn-primary px-6">
                                                        Send
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
