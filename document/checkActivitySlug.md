###检查给定的slug是否存在

#####请求地址 
/api/checkActivitySlug
#####请求方式
GET
#####参数说明
参数|是否必须|说明
---|---|---
slug|是|活动slug
#####返回值
返回值|说明
---|---
exist|是否存在["0"为不存在,"1"为存在]
#####例子
> http://hangout.jinzihao.info/api/checkActivitySlug/test
