<!doctype html>
<html lang="en">
<head>
    @section('htmlheader') @include('adminlte::layouts.partials.htmlheader') @show
</head>
<style type="text/css">
/*.binary-control {
    padding: 10px 10px !important;
    min-width: 56px !important;
    height: 30px !important;
    }*/

    .binary-control i{
        font-size: 10px !important;
    }
    @media screen and (min-width: 600px) {
        #btn_submit_left, #btn_submit_right {
            width:50%!important;
        }
    }
    .chart {
        margin: 5px auto;
        width: auto;
    }
    .Treant > .node {
        min-height:100px !important;
    }
    .Treant > p {
        font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
        font-weight: bold;
        font-size: 12px;
    }
    .node-name {
        font-weight: bold;
        padding: 3px 0;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .tree-node {
    /*padding: 0;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    background-color: #ffffff;
    border: 2px solid #888888;
    width: 12%;
    font-size: 10px;
    text-align: center;
    height: 60px;*/
}
@media only screen and (max-width: 1024px) {
    .tree-node {
        font-size: 8px;
    }
}
@media only screen and (max-width: 768px) {
    .tree-node {
        font-size: 6px;
        height: 50px;
    }
    .box-body{
        overflow: scroll;
    }
    #tree-container{
        width: 1024px;
        overflow-x: scroll;
    }
    .node-loyalty{
        font-size: 1.5rem;
    }
}
.tree-node:hover {
    cursor: pointer;
    background-color: #fff !important;
}
.tree-node img {
    margin: 5px 10px 0 5px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
}
.tree-node p {
    /*margin-bottom: 2px;*/
}
.rotate90 {
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    /* filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1.5); */
    -ms-transform: rotate(90deg);
}
.rotate120 {
    -webkit-transform: rotate(30deg);
    -moz-transform: rotate(30deg);
    -o-transform: rotate(30deg);
    /* filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=1.5); */
    -ms-transform: rotate(30deg);
}


.node-lvl-0{
    background: linear-gradient(90deg, #005200, #008500);
}
.node-lvl-1{
    background: linear-gradient(90deg, #008500, #009e00);
}
.node-lvl-2{
    background: linear-gradient(90deg, #F94952, #FC7279);
}
.node-lvl-3{
    background: linear-gradient(90deg, #FC7279, #FF9A9F);
}
.wp-node-loyalty{
    display: block;
    width: 100%;
    min-height: 145px;
    border: 1px solid #DDDDDD;
    border-radius: 15px;
    text-align: center;
    margin: 0 auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: .3s;
    background: #fff;
    overflow: hidden;
}
.node
{
    width:12%;
}


.node-name{
    min-height: 40px;
    padding: 8px 0;
    color: #fff!important;
    font-weight: 600;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    margin: 0;
    border-bottom: 1px solid transparent;
}
.node-loyalty{
    background: #fff;
    height: 100%;
}   
.node-title{
    margin-top: 10px;
}
.node-contact{
    margin-bottom: 10px;
} 
.node-contact+div{
    bottom: -23px!important;
}
.btn.btn-just-icon{
    border: 1px solid rgba(0, 0, 0, 0.05);
}
.btn.btn-just-icon > i.fa{
    font-size: 16px;
}

.node:hover .node-info{
    display: block;
}
.node-info{
    display: none;
    position: absolute;
    height: 170px;
    background: #fff;
    border-radius: 15px;
    width: 100%;
    border: 1px solid #ddd;
    /*right: -245px; */
    top: 0px;
    z-index: 999999999;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: .3s;
    border-top-left-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
    width: 180%;
}
/*
.tooltip-arrow {
    top: 3%;
    
    margin-top: -5px;
    border-width: 10px 10px 20px 0;
    border-right-color: #6C7A89 !important;
    position: absolute;
    border-style: solid;
    border-color: transparent;
}
*/

.node-if-header{
    padding-top: 5px;
}
/*
.tooltip-content-title
{
    color: #fff;
    padding: 0 10px 4px 10px;
    background: #6C7A89;
    border-top-right-radius: 15px;
}
.tooltip-content-body{
    padding: 2px 10px;
}
*/
.lb-tt-tt{
    line-height: 0;
    width: 20px;
}
.left-posi{
    left: -186%;
    border-top-right-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
    border-bottom-right-radius: 15px !important;
    border-top-left-radius: 15px !important;
}

/*

.left-posi .tooltip-arrow{
    border-left-color: #6C7A89 !important;
    border-width: 10px 0 20px 10px;
    right: -10px;
}
.right-posi .tooltip-arrow{
    left: -10px;
}
.left-posi .tooltip-content-title
{
    border-top-right-radius: 0 !important;
    border-top-left-radius: 15px !important;
}

*/
.disable-tt{
    display: none !important;
}
.tt-saleLeft{
    width: 50%;
    float: left;
    padding-left: 5px;
}
.tt-saleRight{
    width: 50%;
    float: right;
}
.node-footer{
    width:100%;
    padding:5px;
    margin-top:5px !important;
    text-align:left;
}
.node-footer-left{
    width:50%;
    float:left;
}
.node-footer-right{
    with:50%;
    float:right;
}
#tree-container{
    min-height:670px;
}
.right-posi
{
    right:-186%;
}
</style>

<body>
    <div class="wrapper">
        @include('adminlte::layouts.partials.sidebar')
        <div class="main-panel">
            @include('adminlte::layouts.partials.navbar')
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" section="wallet-panel">
                                <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Binary Tree</h4>
                                    <div class="box">
                                        <div class="box-body" style="padding-top:0;">
                                            
<div class="col-xs-12 col-md-4 col-md-offset-7 col-sm-4 col-sm-offset-7 binary-search text-center" style="padding-top: 15px;right:-14px;">
    <!-- <div class="input-group input-group-sm"> -->
        <div class="col-lg-8">
            <input type="text" class="form-control" id="search-input" placeholder="{{ trans('adminlte_lang::member.refferals_username') }}">
        </div>
        <div class="col-lg-2">
            <!-- <span class="input-group-btn"> -->
                <button type="button" id="search-button" class="btn btn-primary btn-flat btn-round" ><i class="fa fa-search"></i> {{ trans('adminlte_lang::member.btn_search') }}</button>
                <!-- </span> -->
            </div>
            <!-- </div> -->
        </div>
        <div class="clearfix"></div>
        <div class="" style="margin-top: 15px;text-align:center;">
            <center>
                <button class="btn btn-round btn-white btn-fill btn-just-icon" type="button" id="refresh-tree"
                style="margin-bottom: 5px;"><i class="fa fa-step-backward rotate90"></i></button>

            </center>
            <center><button class="btn btn-round btn-white btn-fill btn-just-icon" type="button" id="go-up"><i
                class="fa fa-play rotate120 "></i></button></center>
            </div>
                                                        <div class="chart" id="tree-container"></div>

                                                        <div class="pull-left">
                                                            <button class="btn btn-round btn-white btn-fill btn-just-icon" type="button" id="go-endleft"><i
                                                                class="fa fa-fast-forward rotate90"></i></button>
                                                                <button class="btn btn-round btn-white btn-fill btn-just-icon" type="button" id="go-left" style="margin-left: 5px;"><i
                                                                    class="fa fa-step-forward rotate90"></i></button>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <button class="btn btn-round btn-white btn-fill btn-just-icon" type="button" id="go-right" style="margin-right: 5px;"><i
                                                                        class="fa fa-step-forward rotate90"></i></button>
                                                                        <button class="btn btn-round btn-white btn-fill btn-just-icon" type="button" id="go-endright"><i
                                                                            class="fa fa-fast-forward rotate90"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @include('adminlte::layouts.partials.footer')
                                    </div>
                                </div>
                            </body>

                            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
                            <link rel="stylesheet" href="{{ asset('/css/jstree.css') }}"/>
                            <link rel="stylesheet" href="{{ asset('/css/Treant.css') }}"/>

                            <script src="{{ asset('/js/raphael.js') }}"></script>
                            <script src="{{ asset('/js/Treant.js') }}"></script>
                            <script src="{{ asset('/js/jst.js') }}"></script>
                            <script src="{{asset('Carcoin/js/lodash.min.js')}}"></script>
                            <script>
                                $(document).ready(function(){
                                    $('#userSelect').on('change', function () {
                                        var selectId = parseInt($("#userSelect option:selected").val());
                                        if(selectId > 0){
                                            $('#push_into').removeClass('hide');
                                        }else{
                                            $('#push_into').addClass('hide');
                                            $('#legpos').val('');
                                        }
                                    });
                                    $('#btn_submit_left').on('click', function () {
                                        if($("#userSelect option:selected").length == 0){
                                            swal("Please select one username");
                                            return false;
                                        }else{
                                            swal({
                                              title: "Are you sure?",
                                              text: $("#userSelect option:selected").html() + " will be push to the Left!",
                                              type: "warning",
                                              showCancelButton: true,
                                              confirmButtonClass: "btn-danger",
                                              confirmButtonText: "Yes, do it kkkk!",
                                              closeOnConfirm: false,
                                              closeOnCancel: false,
                                            }).then(
                                                function(){
                                                    $('#legpos').val(1);
                                                    $('#pushIntoTreeForm').submit();
                                            });

                                        }
                                    });
                                    $('#btn_submit_right').on('click', function () {
                                        if($("#userSelect option:selected").length == 0){
                                            swal("Please select one username");
                                            return false;
                                        }else{
                                            swal({
                                              title: "Are you sure?",
                                              text: $("#userSelect option:selected").html() + " will be push to the Right!",
                                              type: "warning",
                                              showCancelButton: true,
                                              confirmButtonClass: "btn-danger",
                                              confirmButtonText: "Yes, do it!",
                                              //closeOnConfirm: false
                                          }).then(
                                            function(isConfirm){
                                                $('#legpos').val(2);
                                                $('#pushIntoTreeForm').submit();
                                            });
                                        }
                                    });
                                });
                                var tmpl = window.JST["assets/templates/tree-node.html"],
                                leafTmpl = window.JST["assets/templates/tree-node-leaf.html"];

                                var root = {{ Auth::user()->id }},
                                selectedNodeID = {{ Auth::user()->id }},
                                parentNode = {{ Auth::user()->id }},
                                endLeft = {{ Auth::user()->userData->lastUserIdLeft }},
                                endRight = {{ Auth::user()->userData->lastUserIdRight }},
                                childLeftId = 0,
                                childRightId = 0
                                ;
                                $(document).ready(function () {
                                    getTree();
                                    $('#refresh-tree').on('click', function () {
                                        selectedNodeID = root;
                                        getTree(null, function (err) {
                                            if (err) console.log(err);
                                        })
                                    });
                                    $('#go-up').on('click', function () {
                                        if (parentNode >= root) {
                                            selectedNodeID = parentNode;
                                            getTree(parentNode, function (err) {
                                                if (err) console.log(err);
                                            })
                                        }
                                    });
                                    $('#go-left').on('click', function () {
                                        if (childLeftId > 0) {
                                            selectedNodeID = childLeftId;
                                            getTree(childLeftId, function (err) {
                                                if (err) console.log(err);
                                            })
                                        }
                                    });
                                    $('#go-right').on('click', function () {
                                        if (childRightId > 0) {
                                            selectedNodeID = childRightId;
                                            getTree(childRightId, function (err) {
                                                if (err) console.log(err);
                                            })
                                        }
                                    });
                                    $('#go-endleft').on('click', function () {
                                        if (endLeft > 0) {
                                            selectedNodeID = endLeft;
                                            getTree(endLeft, function (err) {
                                                if (err) console.log(err);
                                            })
                                        }
                                    });
                                    $('#go-endright').on('click', function () {
                                        if (endRight > 0) {
                                            selectedNodeID = endRight;
                                            getTree(endRight, function (err) {
                                                if (err) console.log(err);
                                            })
                                        }
                                    });
                                    $('#search-button').on('click', function (e) {
                                        $.ajax({
                                            url: "?action=getUser",
                                            data: {
                                                username: $('#search-input').val(),
                                            },
                                            timeout : 15000
                                        }).done(function(data) {
                                            if (!data.err) {
                                                selectedNodeID = data.id;
                                                getTree(selectedNodeID, function (err) {
                                                    if (err) console.log(err);
                                                })
                                            } else {
                                                swal({
                                                    title: "There's something wrong",
                                                    text: ErrorCodes[data.err],
                                                    type: "error"
                                                });
                                            }
                                        });
                                    });
                                    $('#search-input').keypress(function (e) {
                                        var key = e.which;
                                        if(key == 13) {
                                            $('#search-button').click();
                                            return false;
                                        }
                                    });
                                });
var drawTree = function (data) {
    var chart_config = {
        chart: {
            container: "#tree-container",
            connectors: {
                type: 'step',
                style: {
                    stroke: '#bbb'
                }
            },
            node: {
                HTMLclass: 'tree-node',
            },
            siblingSeparation: 1,
            subTeeSeparation: 1,
            levelSeparation: 40
        },
        nodeStructure: data,
    }
    new Treant(chart_config, function () {
        //$('.node').wrap('<div class="wp-tree-node"></div>');
        $('.tree-node').on('click', function (e) {
            var id = $(this).attr('id');
            if (id) {
                selectedNodeID = id;
                getTree(id, function (err) {
                    if (err) console.log(err);
                })
            }
        })
    });
}

var getTree = function (id, cb) {
    $.ajax({
        url: "",
        data: {
            id: id,
        },
        timeout: 15000
    }).done(function (data) {
        if (!data.err) {
            var nodeLevel = 0;
            parentNode = data.parentID;
            childLeftId = data.childLeftId;
            childRightId = data.childRightId;

            function fillTree(node) {
                if (node.lvl < 3) {
                    if (!node.children) node.children = [];
                    if (node.children.length == 0) {
                        node.children.push({
                            name: "",
                            levelTitle: null,
                            pkg: -1,
                            weeklySale: -1,
                            avatarURL: 'default-avatar',
                            children: [],
                            loyaltyId: 0,
                            pos: 1,
                            level: 0,
                            lMembers: 0,
                            rMembers: 0
                        });
                        node.children.push({
                            name: "",
                            levelTitle: null,
                            pkg: -1,
                            weeklySale: -1,
                            avatarURL: 'default-avatar',
                            children: [],
                            loyaltyId: 0,
                            pos: 2,
                            level: 0,
                            lMembers: 0,
                            rMembers: 0
                        });
                    } else if (node.children.length == 1) {
                        if (node.children[0].pos == 1) {
                            node.children.push({
                                name: "",
                                levelTitle: null,
                                pkg: -1,
                                weeklySale: -1,
                                loyaltyId: 0,
                                avatarURL: 'default-avatar',
                                children: [],
                                pos: 1,
                                level: 0,
                                lMembers: 0,
                                rMembers: 0
                            });
                        } else {
                            node.children.unshift({
                                name: "",
                                levelTitle: null,
                                pkg: -1,
                                weeklySale: -1,
                                loyaltyId: 0,
                                avatarURL: 'default-avatar',
                                children: [],
                                pos: 2,
                                level: 0,
                                lMembers: 0,
                                rMembers: 0
                            });
                        }
                    }
                }
                if (node.children) {
                    for (var i = 0; i < node.children.length; i++) {
                        node.children[i].lvl = node.lvl + 1;
                        fillTree(node.children[i]);
                    }
                }

            }

            function rebuild(node) {
                node.text = {
                    username: node.name,
                    pkg: node.weeklySale < 0 ? '' : 'BV:' + node.weeklySale,
                    leginfo: node.weeklySale < 0 ? '' : 'L:' + node.left + ' R:' + node.right,
                    level: node.level,
                    loyaltyId: node.loyaltyId,
                    lMembers: node.lMembers,
                    rMembers: node.rMembers,
                    lSale: node.left,
                    rSale: node.right,
                    posi: node.posi,
                    ifLeft:node.ifLeft,
                    ifRight:node.ifRight
                };
                if (node.lvl == 3) {
                    node.innerHTML = leafTmpl(node.text);
                } else {
                    node.innerHTML = tmpl(node.text);
                }
                node.HTMLid = node.id;
                if (node.children) {
                    for (var i = 0; i < node.children.length; i++) {
                        rebuild(node.children[i]);
                    }
                }
            }

            data.lvl = 0;
            fillTree(data);
            rebuild(data);
            $('#tree-container').removeClass('Treant');
            $('#tree-container').removeClass('Treant-loaded');
            $('#tree-container').html('');
            if (data) drawTree(data);
        } else {
            if (cb) cb(data.err);
        }
    });
}
</script>

<link rel="stylesheet" href="{{ asset('/css/jstree.css') }}" />
<script src="{{ asset('/js/jstree.js') }}"></script>
<script src="{{ asset('/js/jstreetable.js') }}"></script>
<script src="{{ asset('/js/genealogy.js') }}"></script>
<!--   Core JS Files   -->
<script src="/Carcoin/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/Carcoin/js/material.min.js" type="text/javascript"></script>
<script src="/Carcoin/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->
<!-- Library for adding dinamically elements -->
<script src="/Carcoin/js/arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="/Carcoin/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="/Carcoin/js/moment.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="/Carcoin/js/chartist.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="/Carcoin/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="/Carcoin/js/bootstrap-notify.js"></script>
<!--   Sharrre Library    -->
<script src="/Carcoin/js/jquery.sharrre.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="/Carcoin/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="/Carcoin/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="/Carcoin/js/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1_8C5Xz9RpEeJSaJ3E_DeBv8i7j_p6Aw"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="/Carcoin/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="/Carcoin/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="/Carcoin/js/sweetalert2.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="/Carcoin/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="/Carcoin/js/fullcalendar.min.js"></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="/Carcoin/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="/Carcoin/js/material-dashboard.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="/Carcoin/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

    // Javascript method's body can be found in Carcoin/js/demos.js
    demo.initDashboardPageCharts();

});
</script>
@yield('script')
</html>