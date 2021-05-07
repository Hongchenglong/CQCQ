package com.oeong.controller.api;

import com.oeong.entity.Dorm;
import com.oeong.service.DormService;
import com.oeong.util.ResultVOUtil;
import com.oeong.vo.DataVO;
import com.oeong.vo.ResultVO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

@RequestMapping("/draw")
@RestController
public class DrawController {

    @Autowired
    private DormService dormService;

    /**
     * 随机抽取宿舍
     * @param grade
     * @param department
     * @param numOfBoys
     * @param numOfGirls
     * @return
     */
    @PostMapping("/draw")
    public ResultVO draw(Integer grade, String department, Integer numOfBoys, Integer numOfGirls) {
        System.out.println("男生数量：" + numOfBoys + ", 女生数量："+ numOfGirls);
        List<Dorm> boy = new ArrayList<>();
        List<Dorm> girl = new ArrayList<>();
        if (numOfBoys > 0) {
            boy = dormService.randomDraw(grade, department, "男", numOfBoys);
            for (Dorm b : boy) {
                b.setRandNum(new Random().nextInt(9000) + 1000);
            }
        }
        if (numOfGirls > 0) {
            girl = dormService.randomDraw(grade, department, "女", numOfGirls);
            for (Dorm g : girl) {
                g.setRandNum(new Random().nextInt(9000) + 1000);
            }
        }
        List<Dorm> dorms = new ArrayList<>();
        dorms.addAll(boy);
        dorms.addAll(girl);
        if (dorms.size() > 0) {
            DataVO dataVO = new DataVO();
            dataVO.setDorm(dorms);
            return ResultVOUtil.success(dataVO);
        } else {
            return ResultVOUtil.error("抽签失败，没有选择宿舍！");
        }
    }

    /**
     * 获取宿舍数量
     * @param grade
     * @param department
     * @return
     */
    @PostMapping("/getNumber")
    public ResultVO getNumber(Integer grade, String department) {
        Integer boys = dormService.count(grade, department, "男").size();
        Integer girls = dormService.count(grade, department, "女").size();
        System.out.println("男生宿舍：" + boys);
        System.out.println("女生宿舍：" + girls);
        if (boys + girls > 0) {
            DataVO dataVO = new DataVO();
            dataVO.setBoys(boys);
            dataVO.setGirls(girls);
            return ResultVOUtil.success(dataVO);
        } else {
            return ResultVOUtil.error("该系暂无宿舍，请导入！");
        }
    }
}
