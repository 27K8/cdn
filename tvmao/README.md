猫影视TV客户端爬虫自定义接口工程
思维没有边界 一切皆有可能
本工程最终食用需配合 猫影视TV新版（一下简称为软件） v2.0.0及以上版本。

logo

欢迎各路大佬踊跃提PR，分享爬虫代码。
这里是用户分享的爬虫代码打包的共享包，可以配合自定义配置，直接食用 custom_spider.jar
快速开始
本工程是一个完整的AndroidStudio工程，请你用AS打开编辑。

工程调试完毕后要需要导出生成jar文件配合软件使用，执行根目录下的 buildAndGenJar.bat 会在jar目录生成一个名为custom_spider.jar的jar文件，这个文件就是我们最终要是用的代码包。

代码包食用方式
本地加载：将custom_spider.jar放入设备sd卡根目录即可。 注意，如需本地加载，请手动赋予App存储空间读写权限，App默认不申请存储空间读写权限

远程加载：将custom_spider.jar上传到你的网络空间，获取对应的文件下载地址，在软件自定义配置的json文件中加入下面格式的键值对。

"spider": "http://xxx.xxx.xxx/custom_spider.jar"
支持jar文件本地缓存（需v2.0.5及以上版本）

"spider": "http://xxx.xxx.xxx/custom_spider.jar;md5;jar文件md5"
// 例如
"spider": "https://github.com/catvod/CatVodTVSpider/blob/master/jar/custom_spider.jar?raw=true;md5;c6ed6bc8285f0aca90e7cb3abf7f9caa",
如何在自定义配置中调用我们代码包中的Spider
同样在自定义json中加入相应的播放源即可，type=3, api对应你代码工程中自定义的爬虫类名（api必须是csp_开头），例如实例工程中的Aidi

{
    "key": "csp_Aidi",
    "name": "爱迪",
    "type": 3,
    "api": "csp_Aidi",
    "searchable": 1,
    "quickSearch": 0,
    "filterable": 1
}
Json解析扩展（需v2.0.2及以上版本）

通过jar包可以实现json解析并发、轮询等相关功能，参与并发和轮询的json解析地址，默认为解析地址列表中的所有json解析（即type=1）。

在自定义json中的parse里加入相应的解析配置（type=2）即可启用。调用扩展类的名称配置在parse的url字段里，例如扩展类JsonParallel的json配置url字段值为Parallel。如下：

{
    "name": "Json并发",
    "type": 2,
    "url": "Parallel"
},
{
    "name": "Json轮询",
    "type": 2,
    "url": "Sequence"
}
XPath规则套娃（需v2.0.4及以上版本） 套娃规则祥见XPath.md

M浏览器中APP影视规则支持（测试版）（2021.10.30 by 小黄瓜）支持筛选，接口太多，建议自测，哪个能用用哪个。

代码里读取APP影视配置中的Api接口

所以你需要在自定义配置中增加相关站配置，ext字段填APP影视配置json中的title。

配置代码 点我展开
影视大全搜索接口支持（不再更新维护，建议使用M浏览器APP影视规则）（2021.10.20 by 小黄瓜） 接口杂乱，搜出来能不能播随缘了。

代码里读取影视大全配置json中的搜索接口

所以你需要在自定义配置中增加相关搜索站配置，ext字段填影视大全配置json中的sourceName，当前支持type为AppV0、AppTV、aiKanTv的搜索接口。

注意：这些配置只能用于搜索，也只支持在搜索界面搜索，不支持相关搜索，更不能作为首页源。

配置代码 点我展开
基础类
com.github.catvod.crawler.Spider 爬虫基类

com.github.catvod.crawler.SpiderReq 用于发起网络请求 获取网络数据

com.github.catvod.crawler.SpiderReqResult 网络请求结果

com.github.catvod.crawler.SpiderUrl 用于定义一个网络请求

示例
请查看 仓库中的爱迪影视 相关实现 ，调试可参考 com.github.catvod.demo.MainActivity ，直接调用对应爬虫相关接口

com.github.catvod.spider.Aidi

注意事项!!
除了com.github.catvod.spider包以外的代码，最终都会被软件本身内置的代码代替掉，所以，建议你不要修改除com.github.catvod.spider包以外的代码。

不要在Spider中使用Gson

待补充

爬虫类返回的相关Json字符串格式说明
homeContent
{
	"class": [{   // 分类
		"type_id": "dianying", // 分类id 
		"type_name": "电影" // 分类名
	}, {
		"type_id": "lianxuju",
		"type_name": "连续剧"
	}],
	"filters": { // 筛选
		"dianying": [{ // 分类id 就是上面class中的分类id
			"key": "0", // 筛选key
			"name": "分类", // 筛选名称
			"value": [{ // 筛选选项 
				"n": "全部", // 选项展示的名称
				"v": "dianying" // 选项最终在url中的展现
			}, {
				"n": "动作片",
				"v": "dongzuopian"
			}]
		}],
		"lianxuju": [{
			"key": 0,
			"name": "分类",
			"value": [{
				"n": "全部",
				"v": "lianxuju"
			}, {
				"n": "国产剧",
				"v": "guochanju"
			}, {
				"n": "港台剧",
				"v": "gangtaiju"
			}]
		}]
	},
	"list": [{ // 首页最近更新视频列表
		"vod_id": "1901", // 视频id
		"vod_name": "判决", // 视频名
		"vod_pic": "https:\/\/pic.imgdb.cn\/item\/614631e62ab3f51d918e9201.jpg", // 展示图片
		"vod_remarks": "6.8" // 视频信息 展示在 视频名上方
	}, {
		"vod_id": "1908",
		"vod_name": "移山的父亲",
		"vod_pic": "https:\/\/pic.imgdb.cn\/item\/6146fab82ab3f51d91c01af1.jpg",
		"vod_remarks": "6.7"
	}]
}
categoryContent
{
	"page": 1, // 当前页
	"pagecount": 2, // 总共几页
	"limit": 60, // 每页几条数据
	"total": 120, // 总共多少调数据
	"list": [{ // 视频列表 下面的视频结构 同上面homeContent中的
		"vod_id": "1897",
		"vod_name": "北区侦缉队",
		"vod_pic": "https:\/\/pic.imgdb.cn\/item\/6145d4b22ab3f51d91bd98b6.jpg",
		"vod_remarks": "7.3"
	}, {
		"vod_id": "1879",
		"vod_name": "浪客剑心 最终章 人诛篇",
		"vod_pic": "https:\/\/pic.imgdb.cn\/item\/60e3f37e5132923bf82ef95e.jpg",
		"vod_remarks": "8.0"
	}]
}
detailContent
{
	"list": [{
		"vod_id": "1902",
		"vod_name": "海岸村恰恰恰",
		"vod_pic": "https:\/\/pic.imgdb.cn\/item\/61463fd12ab3f51d91a0f44d.jpg",
		"type_name": "剧情",
		"vod_year": "2021",
		"vod_area": "韩国",
		"vod_remarks": "更新至第8集",
		"vod_actor": "申敏儿,金宣虎,李相二,孔敏晶,徐尚沅,禹美华,朴艺荣,李世亨,边胜泰,金贤佑,金英玉",
		"vod_director": "柳济元",
		"vod_content": "海岸村恰恰恰剧情:　　韩剧海岸村恰恰恰 갯마을 차차차改编自2004年的电影《我的百事通男友洪班长》，海岸村恰恰恰 갯마을 차차차讲述来自大都市的牙医（申敏儿 饰）到充满人情味的海岸村开设牙医诊所，那里住着一位各方面都",
        // 播放源 多个用$$$分隔
		"vod_play_from": "qiepian$$$yun3edu", 
        // 播放列表 注意分隔符 分别是 多个源$$$分隔，源中的剧集用#分隔，剧集的名称和地址用$分隔
		"vod_play_url": "第1集$1902-1-1#第2集$1902-1-2#第3集$1902-1-3#第4集$1902-1-4#第5集$1902-1-5#第6集$1902-1-6#第7集$1902-1-7#第8集$1902-1-8$$$第1集$1902-2-1#第2集$1902-2-2#第3集$1902-2-3#第4集$1902-2-4#第5集$1902-2-5#第6集$1902-2-6#第7集$1902-2-7#第8集$1902-2-8" 
	}]
}
searchContent
{
	"list": [{ // 视频列表 下面的视频结构 同上面homeContent中的
		"vod_id": "1606",
		"vod_name": "陪你一起长大",
		"vod_pic": "https:\/\/img.aidi.tv\/img\/upload\/vod\/20210417-1\/e27d4eb86f7cde375171dd324b2c19ae.jpg",
		"vod_remarks": "更新至第37集"
	}]
}
