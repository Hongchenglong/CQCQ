package com.oeong.controller.api;

import com.oeong.service.DormService;
import com.oeong.util.ResultVOUtil;
import com.oeong.vo.DataVO;
import com.oeong.vo.ResultVO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RequestMapping("/draw")
@RestController
public class DrawController {

    @Autowired
    private DormService dormService;

    @PostMapping("/getNumber")
    public ResultVO getNumber(Integer grade, String department) {
        Integer boys = 0;
        boys = dormService.count(grade, department, "男");
        Integer girls = 0;
        girls = dormService.count(grade, department, "女");
        System.out.println("男生宿舍：" + boys);
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
