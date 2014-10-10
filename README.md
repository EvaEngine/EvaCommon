EvaCommon
---------

Common模块提供基础的Admin Layout及默认配置文件。同时提供一组可复用的前端组件主要用于后台。

页面组件
=========

###单按钮表单提交 FormDataBatcher

最简实例：

``` html
<button data-ajax-form="1" data-form-action="/url" date-method="delete" data-callback="window.location.reload();" data-confirm="1" data-confirm-message="Are you sure?">
Submit
</button>
```
- 选择器： `*[data-batch-form]`
- 绑定事件：click

