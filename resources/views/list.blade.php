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
    @if(session('status'))
        <div class="status alert alert-success">{{session('status')}}</div>
    @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div id="app">
        <ajax-form
            :fields="{{ json_encode($fields) }}"
            :headers="{{json_encode($headers)}}"
            :csrf="{{  json_encode(csrf_token()) }}">
        </ajax-form>
    </div>
    @if(!empty($known_tires))
        <h5 class="text-center">Объекты</h5>
        <div class="row">
        <table class="table table-hover table-dark">
            <thead>
            <tr>
                @foreach($headers as $header)
                    <th scope="col">{{$header}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($known_tires as $key => $tire)
                <tr>
                    <td>{{$tire['name']}}</td>
                    <td>{{$tire['width']}}</td>
                    <td>{{$tire['profile']}}</td>
                    <td>{{$tire['diameter']}}</td>
                    <td>{{$tire['load_index']}}</td>
                    <td>{{$tire['speed_index']}}</td>
                    <td>{{$tire['vendor']['name']}}</td>
                    <td>{{$tire['model']['name'] }}</td>
                    <td>{{$tire['quantity']}}</td>
                    <td>{{$tire['price']}}</td>
                    <td>{{$tire['created_at']}}</td>
                    <td>{{$tire['updated_at']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    @endif
    @if(!empty($unknown_tires))
        <h4>Ручное распределение</h4>
        <table class="table table-hover table-dark">
            <thead>
            <tr>
                @foreach($headers as $header)
                    <th scope="col">{{$header}}</th>
                @endforeach
                <th scope="col">edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($unknown_tires as $key => $tire)
                <tr data-id="{{$tire['id']}}">
                    <td data-name="name">{{$tire['name']}}</td>
                    <td data-name="width">{{$tire['width']}}</td>
                    <td data-name="profile">{{$tire['profile']}}</td>
                    <td data-name="diameter">{{$tire['diameter']}}</td>
                    <td data-name="load_index">{{$tire['load_index']}}</td>
                    <td data-name="speed_index">{{$tire['speed_index']}}</td>
                    <td data-name="vendor_id">{{$tire['vendor']['name'] ?? ''}}</td>
                    <td data-name="model_id">{{$tire['model']['name'] ?? '' }}</td>
                    <td data-name="quantity">{{$tire['quantity']}}</td>
                    <td data-name="price">{{$tire['price']}}</td>
                    <td>{{$tire['created_at']}}</td>
                    <td>{{$tire['updated_at']}}</td>
                    <td onclick="editRow(this)">
                        <a
                            href="javascript:void(0)"
                        >
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <form hidden action="/update" class="update" method="POST">
        @csrf
        <button
            class="btn btn-primary"
        >Сохранить и перенести в таблицу для отображения
        </button>
        <input type="hidden" name="id">
    </form>
</div>

<script src="/js/app.js"></script>
</body>
</html>
