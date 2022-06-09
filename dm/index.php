<?php 

if (!file_exists("dmku/install/install.lock")){
    header("Location: dmku/install/");
    die();
}
include("tj.php");//统计在线人数代码
include("data.php");//获取播放器配置项
include("config.php");//获取解析配置项
include("AesController.php");//AES加密
header('Content-Type: text/html;charset=utf-8');//utf-8格式
header('Access-Control-Allow-Origin:*'); // *代表允许任何网址请求
header('Access-Control-Allow-Methods:POST,GET,OPTIONS,DELETE'); // 允许请求的类型
header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
header('Access-Control-Allow-Headers: Content-Type,Content-Length,Accept-Encoding,X-Requested-with, Origin'); // 设置允许自定义请求头的字段
$url = $_GET['url'];
$id = explode('?',$url);//过滤视频参数
foreach ($nativeAddress as $val) {
	if (strstr($url, $val['match']) == true) {
	$json['url'] = $url;
	$referrer = $val['referrer'];
	break;
	}
}


foreach ($parsing as $val) {
// 	if (strstr($url, $val['match']) == true) {
    $checkmatch=checkmatch($val['match'],$url);
	if ($checkmatch == true) {
    	$msg = curl($val['url'].$url);//开始解析
    	$json = json_decode($msg,true);
    	$referrer = $val['referrer'];
    	if(empty($json['url'])&&!empty($val['spare_url'])){
    	    $msg = curl($val['spare_url'].$url);//开始解析
    	    $json = json_decode($msg,true);
    	}
    	break;
	}
}


function checkmatch($match,$url){
    $match_arr=explode('|',$match);
    foreach ($match_arr as $val){
        if(strstr($url,$val)){
            return true;
        }
    }
}


if($checkmatch!=true && empty($json['url'])){
    $json['url']=$url;
}


// 	if(empty($json['url'])){
// 	$jk = $lele['json'];//获取选择的json接口
// 	$msg = curl($parsing[ $jk - 1 ]['url'].$url);//开始解析
// 	$json = json_decode($msg,true);
// 	$referrer = $parsing[ $jk - 1 ]['referrer'];
// 	if(empty($json['url'])){
// 	if(!empty($spare['url'])){//启用备用解析
// 	$msg = curl($spare['url'].$url);
// 	$json = json_decode($msg,true);
// 	$referrer = $spare['referrer'];
// 	}}}
	 if (empty($json['url'])) {
		exit('<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
		<meta name="robots" content="noarchive">
		<title>MaoPlayer</title>
		<style>
		h1{color:#FF00FF; text-align:center; font-family: Microsoft Jhenghei;}p{color:#FF00FF; font-size: 1.2rem;text-align:center;font-family: Microsoft Jhenghei;}
		</style>
		</head>
		<body style="background: #FFFFFF url(https://tva4.sinaimg.cn/large/a15b4afegy1fmvj888ouej21hc0u0k4o.jpg) no-repeat fixed center;">
		<table width="100%" height="100%" align="center"><tbody><tr>
		<td align="center">
		<h1><b>MaoPlayer_永久免费<br><h1>解析失败，请稍后再试~</h1><p>本解析只做学习交流，不以盈利为目的使用本接口造成的任何后果概不负责</p><p><font size="2">2018-2021 All Rights Reserved MaoPlayer<br>所有资源均来源第三方资源，并不提供影片资源存储，也不参与录制、上传相关视频，视频版权归属其合法持有人所有<br>本站不对使用者的行为负担任何法律责任。如果有因为本站而导致您的权益受到损害，请与我们联系，我们将理性对待，协助你解决相关问题。<a href="#" target="_Blank">免责声明</a></font></p></b></h1></td></tr></tbody></table>
		</body>
		</html>');
		}
	$url = AesController::encrypt($json['url'], $video_key, $arrAes['str_y']);;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<title data-vue-meta="true">MaoPlayer (゜-゜)つロ 干杯~-dlidl</title>
<meta data-vue-meta="true" itemprop="name" content="MaoPlayer播放器"/>
<meta data-vue-meta="true" itemprop="image" content="./favicon.ico" />
<meta data-vue-meta="true" name="description" itemprop="description" content="dlidl.com是国内知名的视频弹幕网站，这里有最及时的动漫新番，最棒的ACG氛围，最有创意的Up主。大家可以在这里找到许多欢乐。">
<meta data-vue-meta="true" name="keywords" content="dlidl,MaoPlayer,仿bilibili播放器,弹幕播放器,哔哩哔哩动画,哔哩哔哩弹幕网,MaoPlayer弹幕播放器,MaoPlayer视频,B站,弹幕,字幕,AMV,MAD,MTV,ANIME,动漫,动漫音乐,游戏,游戏解说,二次元,游戏视频,ACG,galgame,动画,番组,新番,初音,洛天依,vocaloid,日本动漫,国产动漫,手机游戏,网络游戏,电子竞技,ACG燃曲,ACG神曲,追新番,新番动漫,新番吐槽,巡音,镜音双子,千本樱,初音MIKU,舞蹈MMD,MIKUMIKUDANCE,洛天依原创曲,洛天依翻唱曲,洛天依投食歌,洛天依MMD,vocaloid家族,OST,BGM,动漫歌曲,日本动漫音乐,宫崎骏动漫音乐,动漫音乐推荐,燃系mad,治愈系mad,MAD MOVIE,MAD高燃">
<meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1,viewport-fit=cover">
<link rel="stylesheet" href="./css/Maoplayer.css">
<script>var le_token = "<?php echo $arrAes['str_y'];?>"; </script>
<script type="text/javascript" src="./js/aes.js"></script>
<script language=javascript src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/play.js"></script>
<script type="text/javascript" src="./js/Mao.js"></script>
<script type="text/javascript" src="./js/Maoplay.js"></script>
<script type="text/javascript" src="./js/hls.min.js"></script>
<script type="text/javascript" src="./js/flv.min.js"></script>
<script type="text/javascript" src="./js/layer.js"></script>
<?php
    if ($referrer == "no-referrer") {
        echo '<meta name="referrer" content="no-referrer">';
    } elseif ($referrer == "never") {
        echo '<meta name="referrer" content="never">';
    } else {
        echo '<meta name="referrer" content="never">';
    }
echo '
</head>
<body>
<div id="player" style="position:absolute;left:0px;top:0px;"></div>
<div id="ADplayer" style="position:absolute;left:0px;top:0px;"></div>
<div id="ADtip" style="position:absolute;left:0px;top:0px;"></div>
<script>
var up = {
	"usernum":"'.$users_online.'",//在线人数
	"mylink":"",//域名https://www.dlidl.com
	"diyid":[0,"dlidl",1]//自定义弹幕id
	}
var config = {
	"api":"/dmku/",//弹幕接口，也可以对接外面的弹幕接口
	"url": getVideoInfo("' . $url . '"),//视频链接
	"id":"'.md5($id[0]).'",//视频id
	"sid":"'.$_GET['sid'].'",//集数id
	"pic":"'.$_GET['pic'].'",//视频封面
	"title":"'.$_GET['name'].'",//视频标题
	"next":"'.$_GET['next'].'",//下一集链接
	"user": "'.$_GET['user'].'",//用户名
	"group": "'.$_GET['group'].'",//用户组
	}
lele.start()
</script>';
?>
</body>
</html>