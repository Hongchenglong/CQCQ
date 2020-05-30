# -*- encoding=utf8 -*-
__author__ = "LIN.L.K"

from airtest.core.api import *

auto_setup(__file__)


# 进入小程序
wait(Template(r"tpl1590578587832.png", record_pos=(-0.344, -0.415), resolution=(1080, 1920)))
touch(Template(r"tpl1590578290493.png", rgb=True, record_pos=(-0.344, -0.42), resolution=(1080, 1920)))

wait(Template(r"tpl1590578625760.png", record_pos=(-0.094, -0.629), resolution=(1080, 1920)))
swipe((500,270),(500,1730), vector=[0.1969, 0.0196])
wait(Template(r"tpl1590578844633.png", record_pos=(-0.338, -0.291), resolution=(1080, 1920)))
touch((175,600))


# 登陆
wait(Template(r"tpl1590578935272.png", record_pos=(-0.003, -0.068), resolution=(1080, 1920)))
touch((400, 820))
# text("211706144")
# # 用touch实现长按， 有问题
# touch((400, 820), duration=5)
swipe((400, 820), (400, 820), duration=1.5)
touch((209, 651)) # 点击粘贴
touch((500, 1000))
# text("211706144")
swipe((500, 1000), (500, 1000), duration=1.5)
touch((230, 824)) # 点击粘贴
# wait(Template(r"tpl1590580878640.png", record_pos=(0.371, 0.795), resolution=(1080, 1920)))
touch((940, 1825))
touch((550, 1200))
print("登陆成功")


# 切换到“我的”页面
wait(Template(r"tpl1590580993230.png", record_pos=(0.015, -0.039), resolution=(1080, 1920)))
touch((808,1830))

wait(Template(r"tpl1590583387263.png", rgb=True, record_pos=(-0.003, -0.182), resolution=(1080, 1920)))
touch((570,760))


# 微信授权
wait(Template(r"tpl1590583435108.png", rgb=True, record_pos=(0.187, 0.68), resolution=(1080, 1920)))
touch((752, 1697))

# 退出
sleep(3.0)
wait(Template(r"tpl1590583574148.png", record_pos=(-0.006, 0.65), resolution=(1080, 1920)))
touch((546,1685))
wait(Template(r"tpl1590583707584.png", rgb=True, record_pos=(0.199, 0.164), resolution=(1080, 1920)))
touch((780, 1148))
keyevent("HOME")












