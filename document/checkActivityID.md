###检查给定的id是否存在

#####请求地址 
/api/checkActivityID
#####请求方式
GET
#####参数说明
参数|是否必须|说明
---|---|---
id|是|活动ID
#####返回值
返回值|说明
---|---
exist|是否存在["0"为不存在,"1"为存在]
#####例子
> http://hangout.jinzihao.info/api/checkActivityID?id=1
