@extends('main_layout')

@php
    $olds = session()->getOldInput();
    foreach ($olds as $key => $old)
    {
        if($key !== '_token' &&
            $key != 'item_external' &&
            $key != 'item_username_display' &&
            $key != 'item_username' &&
            $key != 'item_name' &&
            $key != 'item_affiliation'
        )
        {
            $pustaha[$key] = old($key);
        }
    }

    $ctr = 0;
    if(old('item_external.0'))
        $pustaha_items = new \Illuminate\Database\Eloquent\Collection();
    while(old('item_external.' . $ctr))
    {
        $pustaha_item = new \App\PustahaItem();
        $pustaha_item['item_external'] = old('item_external.' . $ctr);
        $pustaha_item['item_username_display'] = old('item_username_display.' . $ctr);
        $pustaha_item['item_username'] = old('item_username.' . $ctr);
        $pustaha_item['item_name'] = old('item_name.' . $ctr);
        $pustaha_item['item_affiliation'] = old('item_affiliation.' . $ctr);
        $pustaha_items->push($pustaha_item);
        $ctr++;
    }

    if(!isset($edit))
        $edit = false;
    if(!isset($pustaha)){
        $pustaha = new \App\Pustaha();
    }
    if(!isset($pustaha_items)){
        $pustaha_items = new \Illuminate\Support\Collection();
    }
@endphp

@section('content')
    <!-- START @PAGE CONTENT -->
    <section id="page-content">

        <!-- Start page header -->
        <div id="tour-11" class="header-content">
            <h2><i class="fa fa-cloud-upload"></i>Pustaha</h2>
            <div class="breadcrumb-wrapper hidden-xs">
                <span class="label">Direktori Anda:</span>
                <ol class="breadcrumb">
                    <li class="active">Pustaha > Reward</li>
                </ol>
            </div>
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <!-- Start body content -->
        <div class="body-content animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title">{{$page_title}}</h3>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-sm" data-action="collapse" data-container="body"
                                        data-toggle="tooltip"
                                        data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i>
                                </button>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- /.panel-heading -->
                        <div id="pustaha-container" class="panel-body">
                            @if($upd_mode == 'display')
                                <div class="form-group">
                                    <h5>History Status: </h5>
                                    @foreach($approvales as $approval)
                                        <div class="col-md-12">
                                            @if($approval->code!="SB" && $approval->code!="UP")
                                                <li class='text-danger'>
                                                    <i>{{$approval->approval_status}} - {{$approval->approval_annotation}}</i>
                                                </li>
                                            @else
                                                <li class='text-danger'>
                                                    <i>{{$approval->approval_status}}</i>
                                                </li>   
                                            @endif
                                        </div>
                                    @endforeach

                                    @if($edit)
                                        <a href="{{url('pustahas/edit?id=' . $pustaha->id)}}" class="btn btn-success rounded">Ubah</a>
                                    @endif
                                    <a href="{{url('/')}}" class="btn btn-danger rounded">Batal</a>
                                </div>
                            @endif
                            <form action="{{url($action_url)}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                @if($disabled == null)
                                                    <button id="pustaha-submit" class="btn btn-success rounded"
                                                            type="submit">Submit
                                                    </button>
                                                @endif
                                                <a href="{{url('/')}}" class="btn btn-danger rounded">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.panel -->
                    </div><!-- /.body-content -->
                </div><!-- /.col-md-12 -->
            </div><!-- /.row -->
        </div>
        <!--/ End body content -->

        <!-- Start footer content -->
    @include('layout.footer')
    <!--/ End footer content -->

    </section><!-- /#page-content -->
    <!--/ END PAGE CONTENT -->
@endsection