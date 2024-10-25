<!doctype html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 999; /* Ensure it stays on top */
        }

        /* Popup box */
        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        /* Close button */
        .close-popup {
            margin-top: 10px;
            cursor: pointer;
            padding: 5px 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .dropdown {
            display: inline-block;
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            width: max-content;
            z-index: 100;
            overflow: auto;
            box-shadow: 0px 10px 10px 0px rgba(0, 0, 0, 0.4);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            display: block;
            color: #000000;
            padding: 5px;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            color: #FFFFFF;
            background-color: #00A4BD;
        }
    </style>
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
            </ul>
            <div class="dropdown">
                <div>{{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                <div class="dropdown-content">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- begin alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('errors'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
        {{ session('errors') }}
    </div>
@endif
<!-- end alert -->
<!-- main -->
<div class="container">
    <div class="card mt-3">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">So'rovnomalar
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">So'rovnoma jo'natish
                    </button>
                </li>
{{--                <li class="nav-item" role="presentation">--}}
{{--                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"--}}
{{--                            data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"--}}
{{--                            aria-selected="false">Contact--}}
{{--                    </button>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            So'rovnomalar
        </div>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">


                    <table id="Table_ID">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kafedra</th>
                            <th>Bino</th>
                            <th>Qavat</th>
                            <th>Xona</th>
                            <th>Holat</th>
                            <th>Yaratilgan vaqt</th>
                            <th>Xarakat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ substr($kafedras->where('id', $value->kafedra_id)->first()->name, 0, 40).'...' }}</td>
                            <td>{{ $value->building }}</td>
                            <td>{{ $value->floor }}</td>
                            <td>{{ $value->room }}</td>
                            <td style="
    @if($value->status == 'new') color: green;
    @elseif($value->status == 'done') color: blue;
    @elseif($value->status == 'progress') color: yellow;
    @elseif($value->status == 'failed') color: red;
    @endif
">{{ $value->status }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td style="display: flex">
                                <button class="btn btn-primary" id="show" onclick="openpopap({{$value->id}})">Ochish</button>
                                @if($value->status == 'new')
                                    <form action="{{route('requests.destroy', $value->id)}}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <form action="{{ route('requests.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-2">
                                    <label class="col-sm-2 form-label">Kafedra</label>
                                    <select class="form-control" name="kafedra_id">
                                        @foreach($kafedras as $kafedra)
                                            <option value="{{ $kafedra->id }}">{{$kafedra->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-2">
                                    <label class="col-sm-2 form-label">Bino</label>
                                    <select class="form-control" name="building">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-2">
                                    <label class="col-sm-2 form-label">Qavat</label>
                                    <input type="number" class="form-control" name="floor" id="floor" min="1" max="6" step="1">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-2">
                                    <label class="col-sm-2 form-label">Xona raqami</label>
                                    <input type="number" class="form-control" name="room">
                                </div>
                                <div class="form-group col-12 mt-2">
                                    <label class="col-sm-2 form-label">Mazmun</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Rostdan ham so\'rovni jo\'natmoqchimisiz?')">Jo'natish</button>
                                </div>
                            </div>
                        </form>
                </div>
{{--                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <div class="popup-overlay" id="popup">
        <div class="popup-content">
            <div id="dt"></div>
            <button class="close-popup" onclick="closePopup()">Close</button>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#Table_ID').DataTable();
    });
    setTimeout(function() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.classList.remove('show');  // Hide alert with Bootstrap fade out effect
        }
    }, 3000);

    // Hide the error alert after 3 seconds
    setTimeout(function() {
        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.classList.remove('show');  // Hide alert with Bootstrap fade out effect
        }
    }, 3000);
    var data = @json($requests);

    function openpopap(id){
        var rq = data.find(item => item.id === id);
        document.querySelector('#dt').innerHTML = rq.description
        document.getElementById("popup").style.display = "flex";
    }
    function closePopup() {
        document.getElementById("popup").style.display = "none"; // Hide popup
    }
</script>
</body>
</html>
