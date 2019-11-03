<!DOCTYPE html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Settings – FROKOST</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @stack('styles')
    </head>
    <body class="h-100">
        <div class="jumbotron jumbotron-fluid h-100 mb-0 bg-transparent">
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col my-auto">
                        <div class="text-left text-light mb-4">
                            <h1 class="display-4">Settings</h1>
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
                                                    <input type="checkbox" class="custom-control-input" id="active" {{ old('active', $slack->setting('active', true)) === true ? 'checked="checked"' : '' }}>
                                                    <label class="custom-control-label" for="active">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body py-6">
                                        <div class="form-group mb-4">
                                            <label for="count">How many unlucky users to choose for lunch?</label>
                                            <input name="count" type="number" class="form-control" id="count" placeholder="1" value="{{ old('count', $slack->setting('count')) }}">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="timeslot">When should they be picked?</label>
                                            <div class="input-group">
                                                <select class="custom-select" id="inputGroupSelect01">
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
                                                    <label class="input-group-text">UTC</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="channel">What channel to tag them in?</label>
                                            <input name="channel" type="text" class="form-control" id="channel" placeholder="#general" value="{{ old('channel', $slack->setting('channel')) }}">
                                            <div class="form-text text-muted">
                                                Default channel is <code>#general</code>.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center bg-transparent">
                                        <button type="submit" class="btn btn-success px-6">
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="h-100 rounded-right" style="background-image: url({{ asset('images/lunch2.jpg') }}); background-size: cover;"></div>
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
