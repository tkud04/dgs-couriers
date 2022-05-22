<?php
$void = 'javascript:void(0)';
?>
@extends('layout')

@section('title',"Tracking")

@section('content')
<?php
if($valid)
{
?>
 @include('tracking-found',['t' => $t])
<?php
}

else{
?>
  @include('tracking-not-found')
<?php
}
?>
@stop