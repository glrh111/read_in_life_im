# read in life的im

## 项目概述

提供即时通讯功能

## 与API的协同

![架构图](http://o9hjg7h8u.bkt.clouddn.com/1529013671.jpg)

API管理着用户的相关信息, 而且聊天客户端, 在登录的时候, 需要历史消息和未读消息.

API同时有向IM发送消息的需求.

总之, API与IM需要合为一体.

c1, c2 代表在线的两个客户端; c3代表不在线的一个客户端

1. c1给c2发消息的流程
   - 上线, c1, c2 链接ws, 更新连接和user_id的关系表: 
     { client_id: user_id }, {user_id: client_id_list } 因为用户可以连接多个客户端, 并同时收到消息
   - c1向c2发送消息, IM将消息存储到DB里边, 然后找到user_id2 对应的client_id列表, 发送消息给c2
   - c2收到消息后, 向API

## 项目部署

```
1. cd docker
2. docker build . -t read-in-life-im:v1
3. docker run -itd -p 8282:8282 -v ./read_in_life_im/:/home/runtime/read_in_life_im/ --name read-in-life-im read-in-life-im:v1 serve
```