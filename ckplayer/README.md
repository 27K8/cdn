ckplayer
#### 软件介绍
本软件为开源软件，遵守开源协议：MIT

#### 功能介绍
用于在网页端播放视频，支持mp4,flv,m3u8及rtmp协议的直播，支持移动端，PC端

#### 软件架构
软件分为两部分，1：javascript构建支持HTML5环境的播放器，2：actionscript3.0构建支持ie9以前支持flashplayer环境的播放器

#### 安装教程
ckplayer不存在安装过程，将下载包里的ckplayer文件夹（该文件夹包含ckplayer.js,ckplayer.swf,ckplayer.json等文件）上传到网站环境中即可使用，在需要播放视频的页面上插入下面代码即可，注意引入ckplayer.js文件的路径

```
<script type="text/javascript" src="ckplayer/ckplayer.js" charset="utf-8" data-name="ckplayer"></script>
<div class="video" style="width: 600px;height: 400px;">播放器容器</div>
<script type="text/javascript">
    //定义一个变量：videoObject，用来做为视频初始化配置
    var videoObject = {
        container: '.video', //“#”代表容器的ID，“.”或“”代表容器的class
        variable: 'player', //播放函数名称，该属性必需设置，值等于下面的new ckplayer()的对象
        video: 'http://ckplayer-video.oss-cn-shanghai.aliyuncs.com/sample-mp4/05cacb4e02f9d9e.mp4'//视频地址
    };
    var player = new ckplayer(videoObject);//初始化播放器
</script>
```


#### 使用说明
使用过程中碰到问题，请至官网查看手册：http://www.ckplayer.com/manual/

#### 参与贡献
niandeng

