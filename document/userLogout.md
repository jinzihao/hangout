###活动参与者登出

#####请求地址 
/api/userLogout
#####请求方式
GET
#####参数说明
参数|是否必须|说明
---|---|---
id|是|活动id
#####返回值
返回值|说明
---|---
status|执行结果,0为成功,1为未登录
#####例子
> http://hangout.jinzihao.info/api/userLogout/3
