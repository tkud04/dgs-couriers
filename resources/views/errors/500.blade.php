<?php
$void = 'javascript:void(0)';
?>
@extends('layout')

@section('title',"Server Downtime")


@section('content')
<section class="block">
<div class="container">
      <div class="row">
        @include('_admin-nav')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          
          <div class="row">
           <div class="col-md-12">
            <h2 class="primary">Don't worry, this has nothingto do with you.</h2>
            <p>Our server is trying toprocess your request. Ths could happen as a result of network or using a VPN.</p>
            <p>But not to worry! Please try again in a few minutes.</p>
           </div>
          </div>

        </main>
      </div>
    </div>
</section>
@stop