# read in life的im

## 项目概述

提供即时通讯功能

## 项目部署

```
1. cd docker
2. docker build . -t read-in-life-im:v1
3. docker run -itd -p 8282:8282 -v ./read_in_life_im/:/home/runtime/read_in_life_im/ --name read-in-life-im read-in-life-im:v1 serve
```