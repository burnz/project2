@extends('adminlte::layouts.backend')

@section('contentheader_title')
    {{ trans('adminlte_lang::member.binary') }}
@endsection
<style type="text/css">
    .binary-control {
        padding: 10px 10px !important;
        min-width: 56px !important;
        height: 30px !important;
    }

    .binary-control i{
        font-size: 10px !important;
    }
    @media screen and (min-width: 600px) {
        #btn_submit_left, #btn_submit_right {
            width:50%!important;
        }
    }
</style>

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row" section="binary-tree">
            <div class="col-md-12">
                <div class="row">
                    <!-- Level 1 -->
                    <div class="col-md-12">
                        <div class="binary">
                            <div class="binary-title" data-background-color="carcoin-primary-1">Admin</div>
                            <div class="binary-content">
                                BV : <b>0</b>
                                <br>
                                L : <b>0</b>
                                | R : <b>0</b>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6 col-sm-6 col-centered binary-horizontal-arrow"></div>
                    <div class="clearfix"></div>
                    <!-- Level 2 -->
                    <div class="col-md-6 col-sm-6">
                        <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                        <div class="binary">
                            <div class="binary-title" data-background-color="carcoin-primary-2">Johny</div>
                            <div class="binary-content">
                                BV : <b>0</b>
                                <br>
                                L : <b>0</b>
                                | R : <b>0</b>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-6 col-centered binary-horizontal-arrow"></div>
                        <div class="clearfix"></div>
                        <!-- Level 3 -->
                        <div class="col-md-6 col-sm-6">
                            <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                            <div class="binary">
                                <div class="binary-title" data-background-color="carcoin-primary-3">Mike</div>
                                <div class="binary-content">
                                    BV : <b>0</b>
                                    <br>
                                    L : <b>0</b>
                                    | R : <b>0</b>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-sm-6 col-centered binary-horizontal-arrow"></div>
                            <div class="clearfix"></div>
                            <!-- Level 4 -->
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-4">Post Malone</div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-4">Micheal Blúe</div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                            <div class="binary">
                                <div class="binary-title" data-background-color="carcoin-primary-3">Justin Bieber</div>
                                <div class="binary-content">
                                    BV : <b>0</b>
                                    <br>
                                    L : <b>0</b>
                                    | R : <b>0</b>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-sm-6 col-centered binary-horizontal-arrow"></div>
                            <div class="clearfix"></div>
                            <!-- Level 4 -->
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-4">Bruno Mars</div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-4">Sam Smith</div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Level 2 -->
                    <div class="col-md-6 col-sm-6">
                        <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                        <div class="binary">
                            <div class="binary-title" data-background-color="carcoin-primary-2">Admin</div>
                            <div class="binary-content">
                                BV : <b>0</b>
                                <br>
                                L : <b>0</b>
                                | R : <b>0</b>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-6 col-centered binary-horizontal-arrow"></div>
                        <div class="clearfix"></div>
                        <!-- Level 3 -->
                        <div class="col-md-6 col-sm-6">
                            <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                            <div class="binary">
                                <div class="binary-title" data-background-color="carcoin-primary-3">Admin</div>
                                <div class="binary-content">
                                    BV : <b>0</b>
                                    <br>
                                    L : <b>0</b>
                                    | R : <b>0</b>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-sm-6 col-centered binary-horizontal-arrow"></div>
                            <div class="clearfix"></div>
                            <!-- Level 4 -->
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-4">Admin</div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-4">Admin</div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                            <div class="binary">
                                <div class="binary-title" data-background-color="carcoin-primary-3">Admin</div>
                                <div class="binary-content">
                                    BV : <b>0</b>
                                    <br>
                                    L : <b>0</b>
                                    | R : <b>0</b>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-sm-6 col-centered binary-horizontal-arrow"></div>
                            <div class="clearfix"></div>
                            <!-- Level 4 -->
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-4">Admin</div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="col-md-6 col-sm-6 col-centered binary-vertical-arrow"></div>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-4">Admin</div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" section="binary-tree-mobile">
            <div class="col-md-12">
                <div class="card">
                    <ul class="nav" data-level-0>
                        <li>
                            <div class="binary">
                                <div class="binary-title" data-background-color="carcoin-primary-1">Admin</div>
                                <div class="binary-content">
                                    BV : <b>0</b>
                                    <br>
                                    L : <b>0</b>
                                    | R : <b>0</b>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-2">
                                        <span class="badge left">L</span>
                                        Mike
                                    </div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                                <span>
                                    <button class="btn btn-round btn-white btn-fill btn-just-icon" toggle-node>
                                        <i class="material-icons">chevron_right</i>
                                    </button>
                                </span>
                            </span>
                            <!-- Child Node Level 1 -->
                            <ul class="child-node" data-level-1>
                                <li>
                                    <span>
                                        <div class="binary">
                                            <div class="binary-title" data-background-color="carcoin-primary-2">Level 1</div>
                                            <div class="binary-content">
                                                BV : <b>0</b>
                                                <br>
                                                L : <b>0</b>
                                                | R : <b>0</b>
                                            </div>
                                        </div>
                                        <span>
                                            <button class="btn btn-round btn-white btn-fill btn-just-icon" toggle-node>
                                                <i class="material-icons">chevron_right</i>
                                            </button>
                                            <a href="#" back-parent-node>Back</a>
                                        </span>
                                    </span>
                                    <!-- Child Node Level 2 -->
                                    <ul class="child-node" data-level-2>
                                        <li>
                                            <span>
                                                <div class="binary">
                                                    <div class="binary-title" data-background-color="carcoin-primary-2">Level 2</div>
                                                    <div class="binary-content">
                                                        BV : <b>0</b>
                                                        <br>
                                                        L : <b>0</b>
                                                        | R : <b>0</b>
                                                    </div>
                                                </div>
                                                <span>
                                                    <button class="btn btn-round btn-white btn-fill btn-just-icon" toggle-node>
                                                        <i class="material-icons">chevron_right</i>
                                                    </button>
                                                    <a href="#" back-parent-node>Back</a>
                                                </span>
                                            </span>
                                            <!-- Child Node Level 3 -->
                                            <ul class="child-node" data-level-3>
                                                <li>
                                                    <span>
                                                        <div class="binary">
                                                            <div class="binary-title" data-background-color="carcoin-primary-2">Level 3</div>
                                                            <div class="binary-content">
                                                                BV : <b>0</b>
                                                                <br>
                                                                L : <b>0</b>
                                                                | R : <b>0</b>
                                                            </div>
                                                        </div>
                                                        <span>
                                                            <button class="btn btn-round btn-white btn-fill btn-just-icon" toggle-node>
                                                                <i class="material-icons">chevron_right</i>
                                                            </button>
                                                            <a href="#" back-parent-node>Back</a>
                                                        </span>
                                                    </span>
                                                    <!-- Child Node Level 4 -->
                                                    <ul class="child-node" data-level-4>
                                                        <li>
                                                            <span>
                                                                <div class="binary">
                                                                    <div class="binary-title" data-background-color="carcoin-primary-2">Level 4</div>
                                                                    <div class="binary-content">
                                                                        BV : <b>0</b>
                                                                        <br>
                                                                        L : <b>0</b>
                                                                        | R : <b>0</b>
                                                                    </div>
                                                                </div>
                                                                <span>
                                                                    <button class="btn btn-round btn-white btn-fill btn-just-icon" toggle-node>
                                                                        <i class="material-icons">chevron_right</i>
                                                                    </button>
                                                                    <a href="#" back-parent-node>Back</a>
                                                                </span>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                    <!-- END Child Node Level 4 -->
                                                </li>
                                            </ul>
                                            <!-- END Child Node Level 3 -->
                                        </li>
                                    </ul>
                                    <!-- END Child Node Level 2 -->
                                </li>
                            </ul>
                            <!-- END Child Node Level 1 -->
                        </li>
                        <li>
                            <span>
                                <div class="binary">
                                    <div class="binary-title" data-background-color="carcoin-primary-2">
                                        <span class="badge right">R</span>
                                        Mike
                                    </div>
                                    <div class="binary-content">
                                        BV : <b>0</b>
                                        <br>
                                        L : <b>0</b>
                                        | R : <b>0</b>
                                    </div>
                                </div>
                                <!-- <span>
                                <button class="btn btn-round btn-white btn-fill btn-just-icon" toggle-node>
                                    <i class="material-icons">chevron_right</i>
                                </button>
                            </span> -->
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- <style>
        .chart {
            height: 400px;
            margin: 5px auto;
            width: auto;
        }
        .Treant > .node {
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
            padding: 0;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            background-color: #ffffff;
            border: 2px solid #888888;
            width: 12%;
            font-size: 10px;
            text-align: center;
            height: 60px;
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
        }
        .tree-node:hover {
            cursor: pointer;
            background-color: #f5f5f5;
        }
        .tree-node img {
            margin: 5px 10px 0 5px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
        .tree-node p {
            margin-bottom: 2px;
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
    </style> -->
    <!-- <link rel="stylesheet" href="{{ asset('/css/jstree.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/Treant.css') }}"/>

    <script src="{{ asset('/js/raphael.js') }}"></script>
    <script src="{{ asset('/js/Treant.js') }}"></script>
    <script src="{{ asset('/js/jst.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script> -->
    <!-- <script>
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
                      confirmButtonText: "Yes, do it!",
                      closeOnConfirm: false
                    },
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
                      closeOnConfirm: false
                    },
                    function(){
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
                            rMembers: node.rMembers
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
    </script> -->
@endsection