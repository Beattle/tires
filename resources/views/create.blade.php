<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <form method="post" action="/create">
        @csrf
        @foreach($fields as $field)
            @if($field === 'vendor_id')
                <label for="{{$field}}">{{$headers[$field]}}</label>
                <select required name="{{$field}}}" class="form-control" id="{{$field}}">
                    @foreach($Vendors as $vendor)
                        <option value="{{$vendor['id']}}">{{$vendor['name']}}</option>
                    @endforeach
                </select>
                @continue
            @endif
            @if($field === 'model_id')
                <label for="{{$field}}">{{$headers[$field]}}</label>
                <select required name="{{$field}}}" class="form-control" id="{{$field}}">
                    @foreach($Models as $model)
                        <option value="{{$model['id']}}">{{$model['name']}}</option>
                    @endforeach
                </select>
                @continue
            @endif
            <div class="form-group">
                <label for="{{$field}}">{{$headers[$field]}}</label>
                <input name="{{$field}}" type="text" class="form-control" id="{{$field}}">
            </div>
        @endforeach
        <button class="btn btn-secondary">Добавить</button>
    </form>
</div>

<script src="/js/app.js"></script>
</body>
</html>
