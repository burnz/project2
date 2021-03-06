<div class="row">
    <a href="{{ Request::url() }}?type={{\App\Http\Controllers\Backend\Report\RepoReportController::NEW_USER}}&opt={{$temp->opt}}&from_date={{$temp->date_custom->from_date}}&to_date={{$temp->date_custom->to_date}}">
        <div class="col-md-4 col-sm-6 col-xs-12 new-user">
            <div class="info-box">
                <span class="info-box-icon bg-yellow-gradient"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">New Members</span>
                    <span class="info-box-number">{{number_format($temp->total->totalNewUser)}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>
    <a href="{{ Request::url() }}?type={{\App\Http\Controllers\Backend\Report\RepoReportController::TOTAL_PACKAGE}}&opt={{$temp->opt}}&from_date={{$temp->date_custom->from_date}}&to_date={{$temp->date_custom->to_date}}">
        <div class="col-md-4 col-sm-6 col-xs-12 total-package">
            <div class="info-box">
                <span class="info-box-icon bg-red-gradient"><i class="fa fa-globe"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Package (USD)</span>
                    <span class="info-box-number">{{number_format($temp->total->totalTotalPackage,2)}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>
    <a href="{{ Request::url() }}?type={{\App\Http\Controllers\Backend\Report\RepoReportController::TOTAL_SELL_CLP}}&opt={{$temp->opt}}&from_date={{$temp->date_custom->from_date}}&to_date={{$temp->date_custom->to_date}}">
        <div class="col-md-4 col-sm-6 col-xs-12 total-sell-clp">
            <div class="info-box">
                <span class="info-box-icon bg-red-gradient"><i class="fa fa-globe"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Package (CAR)</span>
                    <span class="info-box-number">{{number_format($temp->total->totalTotalSellClp,2)}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </a>
</div>
<div class="row">
    <a href="{{ Request::url() }}?type={{\App\Http\Controllers\Backend\Report\RepoReportController::CLP_DEPOSIT}}&opt={{$temp->opt}}&from_date={{$temp->date_custom->from_date}}&to_date={{$temp->date_custom->to_date}}">
    <div class="col-md-4 col-sm-6 col-xs-12 clp-deposit">
        <div class="info-box">
            <span class="info-box-icon bg-green-gradient"><i class="fa fa-arrow-right"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">CAR DEPOSIT</span>
                <span class="info-box-number">{{number_format($temp->total->totalClpDeposit,4)}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    </a>
    <a href="{{ Request::url() }}?type={{\App\Http\Controllers\Backend\Report\RepoReportController::CLP_WITHDRAW}}&opt={{$temp->opt}}&from_date={{$temp->date_custom->from_date}}&to_date={{$temp->date_custom->to_date}}">
    <div class="col-md-4 col-sm-6 col-xs-12 clp-withdraw">
        <div class="info-box">
            <span class="info-box-icon bg-blue-gradient"><i class="fa fa-exchange"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">CAR WITHDRAW</span>
                <span class="info-box-number">{{number_format($temp->total->totalClpWithDraw,4)}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>