@extends('layouts.app')
@section('title', '首页')



@section('content')

  <h1>这里是首页</h1>
  
@stop



@section('scripts')

<script>
	
	layui.config({
        base: '/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'upload','table'],function() {


    	layer.alert('1231')

    });
</script>

@stop