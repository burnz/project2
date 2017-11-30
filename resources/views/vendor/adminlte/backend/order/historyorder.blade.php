@extends('adminlte::backend.layouts.member')

@section('contentheader_title')
    History Order
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endsection

@section('main-content')
    <div class="row box">
        <div class="col-md-12">
            <table id="todayorder-grid"  cellpadding="0" cellspacing="0" border="0" class="table display" width="100%" >
                <thead>
                <tr>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Ngày</th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <td><input type="text"   data-column="0"  class="search-input-text"></td>
                    <th><input type="number" data-column="1"  class="search-input-text"></td>
                    <th><input type="number" data-column="2"  class="search-input-text"></td>
                    <th><input type="number" data-column="3"  class="search-input-text"></td>
                    <td>
                        <select data-column="4"  class="search-input-select">
                            <option value="">Select all</option>
                            <option value="1">Processing</option>
                            <option value="2">Success</option>
                            <option value="3">Cancel</option>
                        </select>
                    </td>
                    <td>
                        <input type="date" data-column="5"  class="search-input-select" >
                    </td>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            var dataTableToDayOrder = $('#todayorder-grid').DataTable( {
                "processing": true,
                'language':{
                    "loadingRecords": "&nbsp;",
                    "processing": "Updating..."
                },
                "order": [[ 5, "desc" ]],
                "serverSide": true,
                "orderMulti": true,
                "ordering": true,
                "ajax":{
                    url :"gethistorydataorder", // json datasource
                    type: "get",  // method  , by default get
                    error: function(){  // error handling
                        $(".todayorder-grid-error").html("");
                        $("#todayorder-grid tbody").html('<tbody class="market-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#todayorder-grid_processing").css("display","none");
                    },
                    complete : function (dataTableHistory) {

                    }
                }
            } );

            $("#todayorder-grid_filter").css("display","none");

            $('.search-input-text').on( 'keyup change', function () {   // for text boxes
                var i =$(this).attr('data-column');  // getting column index
                var v =$(this).val();  // getting search input value
                dataTableToDayOrder.columns(i).search(v).draw();
            } );
            $('.search-input-select').on( 'change', function () {   // for select box
                var i =$(this).attr('data-column');
                var v =$(this).val();
                dataTableToDayOrder.columns(i).search(v).draw();
            } );
        });
    </script>
@endsection