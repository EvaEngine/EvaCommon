EvaCommon
---------

Common模块提供基础的Admin模板、默认配置文件、基础前端解决方案，同时提供一组可复用的前端组件。

Admin模板采用[Ace - Responsive Admin Template](https://wrapbootstrap.com/theme/ace-responsive-admin-template-WB0B30DGR)，授权费用为$18，如在EvaEngine以外的网站使用请自觉付费。


前端基础类
==========


页面组件
=========

###单按钮表单提交 FormDataBatcher

使用场景：

点击按钮向后端发起一个请求，点击按钮前可能会弹出确认框，请求成功后调用一个callback。

例如文章列表中的删除按钮，点击后弹出确认框“Are you sure?”，确认后向后端`/url`发起一个DELETE请求，成功后刷新页面。

上述场景的实例代码：

``` html
<button data-ajax-form="1" data-form-action="/url" date-method="delete" data-callback="window.location.reload();" data-confirm="1" data-confirm-message="Are you sure?">
Submit
</button>
```
- 选择器： `*[data-batch-form]`
- 绑定事件：click


### 表单多选

### 批处理

### 日期/时间选择组件 + 时间戳转换

### Grid排序

### 表单不同按钮提交

### 用户名输入补全

### 自动生成Slug


=======
EvaEngine 公共模块
=======
# 禁止直接向本仓库推送代码！！

## 代码推送方法
首先确保在 wallstreetcn 项目下添加过本仓库的 remote:
```shell
git remote add eva-common git@github.com:wallstreetcn/eva-common.git
```
在 wallstreetcn 项目下 commit 后，使用如下命令更新到本仓库：

```shell
git subtree push --prefix=modules/EvaCommon eva-common master
```
