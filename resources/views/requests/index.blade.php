@extends('layouts.admin')
<link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
</style>
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
        <table id="datatable" class="datatable">
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
                    <td>{{$key+1}}</td>
                    <td>{{substr($value->name, 0, 40)}}</td>
                    <td>{{$value->building}}</td>
                    <td>{{$value->floor}}</td>
                    <td>{{$value->room}}</td>
                    <td>@can('change-status')
                        <select class="form-control slct" id="{{$value->id}}">
                            <option value="new" @if($value->status == 'new') selected @endif>new</option>
                            <option value="progress" @if($value->status == 'progress') selected @endif>progress</option>
                            <option value="done" @if($value->status == 'done') selected @endif>done</option>
                            <option value="failed" @if($value->status == 'failed') selected @endif>failed</option>
                        </select>
                        @endcan
                    </td>
                    <td>{{$value->created_at}}</td>
                    <td>
                        <button class="btn btn-primary" id="show" onclick="openpopap({{$value->id}})">Ochish</button>
                        <form action="">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="display: none">
        <form action="" method="POST" id="frm">
            @csrf
            <input id="inp" name="">
        </form>
    </div>
    <div class="popup-overlay" id="popup">
        <div class="popup-content">
            <div id="dt"></div>
            <button class="close-popup" onclick="closePopup()">Close</button>
        </div>
    </div>
@endsection
@section('script')
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
{{--    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // let table = new DataTable('#datatable');
        $(document).ready(function () {
            $('#datatable').DataTable();
        });
        $(document).ready(function () {
            $('.slct').change(function () {
                var status = $(this).find('option:selected').text();
                var id = $(this).attr('id');
                changeStatus(id, status);
            });
        });
        function changeStatus(id, status) {
            // Get CSRF token from the meta tag
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
            }else if (name == 'bajarilmagani'){
                $("#frm").attr('action', "/admin/bajarilmagani"); // Full URL or generate dynamically
                $("#inp").attr('name', 'bajarilmagani');
                $("#frm").submit();
            }
        }
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
@endsection
