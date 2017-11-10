$(document).ready(function () {
    $('#myTable tbody').on('click', 'tr', function () {
        var _packageId = parseInt($(this).data('id'));
        if (_packageId > 0) {
            if (_packageId < packageId) {
                $('.error-mining-package').html("<div class='alert alert-danger'>You can not downgrade package.</div>");
            } else if (_packageId == packageId) {
                $('.error-mining-package').html("<div class='alert alert-danger'>You purchased this package.</div>");
            } else {
                $('.error-mining-package').html("");
                $('#myTable tbody tr').removeClass('selected');
                $('#table_th').removeClass('selected');
                $(this).addClass('selected');
                $("#packageId").val(_packageId);
                packageIdPick = _packageId;
            }
        }
    });

    $('#btn_submit').on('click', function () {
        if(!$('#termsPackage').is(':checked')){
            $("#termsPackage").parents("div.form-group").addClass('has-error');
            $("#termsPackage").parents("div.form-group").find('.help-block').text('Please checked term');
            return false;
        }else{
            $("#termsPackage").parents("div.form-group").removeClass('has-error');
            $("#termsPackage").parents("div.form-group").find('.help-block').text('');
            if (packageIdPick > packageId) {
                swal({
                        title: "Are you sure?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-info",
                        confirmButtonText: "Yes, buy it!",
                        closeOnConfirm: false
                    },
                    $('#formPackage').submit() );

            } else {
                swal('You select invalid package')
                return false;
            }
        }

    });

    function checkDiv10(amount,dataId) {
        if ( amount % 10 != 0 ){
            $('#myTable tbody tr').removeClass('selected');
            $('.error-mining-package').html("Input value must div by 10");
        } else {
            $('.error-mining-package').html("");
            $('#myTable tbody tr').removeClass('selected');
            $("#myTable tbody tr[data-id="+dataId+"]").addClass('selected');
        }
    }

    function convert(amount) {
        $('#amount_convert').val( amount/globalCLPUSD )
    }

    $('#amount_lending').on('keyup change', function() {
        var amount = $(this).val();
        convert(amount);
        if (200 <= amount && amount <= 1000) {
            checkDiv10(amount,1);
        } else if(1010 <= amount && amount <= 10000) {
            checkDiv10(amount,2);
        } else if(10010 <= amount && amount <= 50000) {
            checkDiv10(amount,3);
        } else if(50010 <= amount && amount <= 100000) {
            checkDiv10(amount,4);
        } else {
            $('#myTable tbody tr').removeClass('selected');
            $('.error-mining-package').html("Input value into 200 to 100000 ");
        }
    });
});