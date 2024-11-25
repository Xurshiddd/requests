@extends('layouts.admin')
<link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('h1')
    So'rovnomalar
@endsection
@section('content')
    <div class="card">
        <div class="flex">
            <button class="btn btn-primary" onclick="formSubmit('hammasi')">Hammasi</button>
            <button class="btn btn-primary" onclick="formSubmit('bugungi')">Bugungi</button>
            <button class="btn btn-primary" onclick="formSubmit('bajarilmagani')">Bajarilmaganlari</button>
        </div>
    </div>
    <div>
        <table id="datatable" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Kafedra</th>
                <th>Bino</th>
                <th>Qavat</th>
                <th>Xona</th>
                <th>Holat</th>
                <th>Yaratilgan vaqt</th>
                @can('tasdiqlash')
                    <th>Tasdiq</th>
                @endcan
                <th>Xarakat</th>
            </tr>
            </thead>
            <tbody>
            @foreach($requests as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{substr($value->name, 0, 40)}}</td>
                    <td>{{$value->building}}</td>
                    <td>{{$value->floor}}</td>
                    <td>{{$value->room}}</td>
                    <td>@can('change-status')
                            <select class="form-control slct" id="{{$value->id}}">
                                <option value="new" @if($value->status == 'new') selected @endif>Yangi</option>
                                <option value="progress" @if($value->status == 'progress') selected @endif>
                                    Bajarilyapti
                                </option>
                                <option value="done" @if($value->status == 'done') selected @endif>Bajarildi</option>
                                <option value="failed" @if($value->status == 'failed') selected @endif>Bajarilmadi
                                </option>
                            </select>
                        @endcan
                    </td>
                    <td>{{$value->created_at}}</td>
                    @can('tasdiqlash')
                        <td>
                            <input type="checkbox" class="form-checkbox check" id="{{$value->id}}"
                                   @if($value->confirm == true) checked disabled
                                   @endif onclick="return confirm('Rostdan ham tanlamoqchimisiz ?')">
                        </td>
                    @endcan
                    <td>
                        <div style="display: flex; justify-content: space-around">
                            <div>
                                <button class="btn btn-primary" id="show" onclick="openPopup({{$value->id}})">Ochish</button>
                            </div>
                            <div>
                                <form action="">
                                    <button type="submit" class="btn btn-danger">O'chirish</button>
                                </form>
                            </div>
                            <div>
                                <a href="/admin/word/{{$value->id}}" class="btn btn-success">Yuklash</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="popup" style="display: none; position: fixed; top: 50%; left: 50%; width: 60%; transform: translate(-50%, -50%); background: white; border: 1px solid #ccc; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000;">
        <h3 style="text-align: center;">So'rovnoma ko'rinishi</h3>
        <div style="display: flex; justify-content: end">
            <div style="flex-wrap: nowrap; width: 30%">
                "Raqamli ta`lim texnologiyalari markazi" <br>
                rahbari Sherzod Fayazovga <br>
                <p id="kafedra" style="display: inline"></p> kafedrasi mudiri
                <p id="mdr" style="display: inline"></p>dan
            </div>
        </div>
        <h4 class="text-center">So'rovnoma</h4>
        <div id="popup-content">
            <!-- Dinamik ma'lumotlar bu yerga kiritiladi -->
            <p><strong>Bino:</strong> <span id="popup-building"></span></p>
            <p><strong>Qavat:</strong> <span id="popup-floor"></span></p>
            <p><strong>Xona:</strong> <span id="popup-room"></span></p>
            <p><strong>Mazmuni:</strong> <span id="popup-description"></span></p>
            <p><strong>Vaqt:</strong> <span id="popup-create"></span></p>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            @can('tasdiqlash')
                <button onclick="confirmRequest()" id="imzo" data="" style="padding: 10px 20px; background: #4caf50; color: white; border: none; cursor: pointer;">Imzo</button>
            @endcan
            <button onclick="closePopup()" style="padding: 10px 20px; background: #f44336; color: white; border: none; cursor: pointer; margin-left: 10px;">Yopish</button>
        </div>
    </div>
    >

    <div style="display: none">
        <form action="" method="POST" id="frm">
            @csrf
            <input id="inp" name="">
        </form>
    </div>
    <style>
        #popup {
            width: 500px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        #popup h3 {
            background: #f4f4f4;
            padding: 10px;
            margin: 0;
            text-align: center;
        }

        #popup-content p {
            margin: 10px 0;
            line-height: 1.5;
        }
    </style>

@endsection
@section('script')
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openPopup(id) {
            let dat = @json($requests);
            let data = dat.find(item => item.id === id);
            document.getElementById("popup-building").textContent = data.building;
            document.getElementById("popup-floor").textContent = data.floor;
            document.getElementById("kafedra").textContent = data.name;
            document.getElementById("mdr").textContent = data.user;
            document.getElementById("popup-room").textContent = data.room;
            document.getElementById("popup-description").textContent = data.description;
            document.getElementById("popup-create").textContent = data.created_at;

            // Tugma mavjud bo'lsa, unga tegishli ma'lumotni yuklang
            const imzoBtn = document.getElementById("imzo");
            if (imzoBtn) {
                imzoBtn.setAttribute('data', data.id);

                if (data.confirm === 1) {
                    imzoBtn.textContent = 'Imzolangan';
                    imzoBtn.disabled = true;
                    imzoBtn.style.pointerEvents = 'none';
                } else {
                    imzoBtn.textContent = 'Imzolash';
                    imzoBtn.disabled = false;
                    imzoBtn.style.pointerEvents = 'auto';
                }
            }

            // Popapni ko'rsatish
            document.getElementById("popup").style.display = "block";
        }


        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        function confirmRequest() {
            var Token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const button = document.getElementById('imzo');
            const dataValue = button.getAttribute('data');
            $.ajax({
                url: '/admin/confirm',
                method: 'POST',
                data: {
                    id: dataValue,
                    _token: Token
                },
                success: function (res) {
                    alert(res.message);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert(error);
                }
            })
            closePopup();
        }

        // let table = new DataTable('#datatable');
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
        $(document).ready(function () {
            $('.slct').change(function () {
                var status = $(this).find('option:selected').val();
                var id = $(this).attr('id');
                changeStatus(id, status);
            });
            $(".check").change(function () {
                var Token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var id = $(this).attr('id');
                $.ajax({
                    url: '/admin/confirm',
                    method: 'POST',
                    data: {
                        id: id,
                        _token: Token
                    },
                    success: function (res) {
                        alert(res.message);
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        alert(error);
                    }
                });
            })
        });

        function changeStatus(id, status) {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            $.ajax({
                url: '/admin/changestatus',
                method: 'POST',
                data: {
                    id: id,
                    status: status,
                    _token: csrfToken // Add CSRF token to the request data
                },
                success: function (res) {
                    alert(res.message);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error); // Log any errors
                }
            });
        }


        function formSubmit(name) {
            if (name == 'hammasi') {
                location.href = '/admin/requests';
            } else if (name == 'bugungi') {
                $("#frm").attr('action', "/admin/bugungi"); // Full URL or generate dynamically
                $("#inp").attr('name', 'bugungi');
                $("#frm").submit();
            } else if (name == 'bajarilmagani') {
                $("#frm").attr('action', "/admin/bajarilmagani"); // Full URL or generate dynamically
                $("#inp").attr('name', 'bajarilmagani');
                $("#frm").submit();
            }
        }
    </script>
@endsection
