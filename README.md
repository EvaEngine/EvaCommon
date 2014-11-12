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