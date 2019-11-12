@extends('admin.layout.base')

@section('title')
@endsection

@section('resources')
    <meta name="_token" content="{{ csrf_token() }}"/>
@endsection

@section('container')
    <form class="layui-form layui-form-pane" action=""  lay-filter="example">

        <input type="hidden" name="type_id">
        <div class="layui-form-item">
            <label class="layui-form-label">配置类型名称</label>
            <div class="layui-input-block">
                <input type="text" name="type_name" lay-verify="required" placeholder="请输入配置类型名称" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">类型状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" value="1" lay-skin="switch" lay-text="ON|OFF">
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">类型描述</label>
            <div class="layui-input-block">
                <textarea name="type_desc" placeholder="请输入描述内容" class="layui-textarea"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="button" class="layui-btn" lay-submit="" lay-filter="submit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')

    <script>
        var id = "{{ Request ()->get('id', 0) }}";

        layui.use(['form', 'jquery'], function(){
            var form = layui.form
                ,$ = layui.jquery
                ,layer = layui.layer;

            //自定义验证规则
            form.verify({
            });

            //监听指定开关
            form.on('switch(switchTest)', function(data){
                layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
                    offset: '6px'
                });
                layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
            });


            let _params = {
                "type_id": id // id
                ,"type_name": "" // 配置分类名称
                ,"type_desc": '' // 配置分类描述
                ,"status": 1 // 配置分类状态
            };

            if (parseInt(id) !== 0) {
                //表单取值
                $.ajax({
                    url: "{{ route('admin.config_type.info') }}",
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(res){
                        if(res.code > 0){
                            _params.type_name = res.data.type_name;
                            _params.status = res.data.status;
                            _params.type_desc = res.data.type_desc;
                            form.val('example', _params);
                        } else {
                            layer.msg(res.msg, {icon:2, shade:0.5,anim:6})
                        }
                    }
                });
            }
            //表单赋值
            form.val('example', _params);
            // alert(JSON.stringify(data));

            //监听提交
            form.on('submit(submit)', function(data){
                //表单取值
                $.ajax({
                    url: "{{ route('admin.config_type.create') }}",
                    type: 'post',
                    data: form.val('example'),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(res){
                        if(res.code > 0){
                            layer.msg(res.msg, {icon:1, shade:0.5,anim:6})
                        } else {
                            layer.msg(res.msg, {icon:2, shade:0.5,anim:6})
                        }
                    }
                });

                return false;
            });
        });
    </script>
@endsection
