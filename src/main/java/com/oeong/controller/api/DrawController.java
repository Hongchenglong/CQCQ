package com.oeong.controller.api;

import com.oeong.dao.mybatis.DormDao;
import com.oeong.entity.Dorm;
import com.oeong.entity.Record;
import com.oeong.entity.Student;
import com.oeong.service.*;
import com.oeong.util.ResultVOUtil;
import com.oeong.vo.DataVO;
import com.oeong.vo.ResultVO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.*;

@RequestMapping("/draw")
@RestController
public class DrawController {

    @Autowired
    private DormService dormService;
    @Autowired
    private DormDao dormDao;
    @Autowired
    private NoticeService noticeService;
    @Autowired
    private RecordService recordService;
    @Autowired
    private StudentService studentService;
    @Autowired
    private ResultService resultService;
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

    /**
     * @Author: Hongchenglong
     * @Date: 2021/6/27 15:03
     * @Decription: 确认查寝名单
     */
    @PostMapping("/verify")
    public ResultVO verify(Integer grade, String department, String start_time, String end_time,
                           String dorm_id, String rand_num, Integer instructor_id) {
        // 通知辅导员
        Integer notice = noticeService.findByInstructorId(instructor_id, start_time, end_time);
        if (notice == null) {
            noticeService.insertNotice(instructor_id, start_time, end_time);
        }

        Integer ret = 0;
        List<String> dormList = Arrays.asList(dorm_id.split(","));
        List<String> randList = Arrays.asList(rand_num.split(","));
        Integer len = dormList.size();
        for (int i = 0; i < len; i++) {
            Integer dormId = Integer.valueOf(dormList.get(i));
            Integer randNum = Integer.valueOf(randList.get(i));
            // 插入记录表
            recordService.insertRecord(dormId, randNum, start_time, end_time);
            // 记录ID
            Integer recordId = recordService.getLastId();
            System.out.println("recordService=============" + recordService);
            // 宿舍门牌号
            String dormNum = dormService.findByDormId(dormId, grade, department).getDormNum();
            System.out.println("dormService=============" + dormService);
            List<Student> studentList = studentService.findByDorm(dormNum, grade, department);
            // // 将学号和记录号依次插入到result表中
            for (Student student : studentList) {
                ret = resultService.insertResult(student.getId(), recordId);
            }
        }
        if (ret > 0) {
            return ResultVOUtil.success(null);
        } else {
            return ResultVOUtil.error("抽签失败，没有选择宿舍！");
        }
    }

    /**
     * @Author: Hongchenglong
     * @Date: 2021/6/28 22:12
     * @Decription: 显示宿舍和随机号
     */
    @PostMapping("/result")
    public ResultVO result(Integer grade, String department) {
        // 先找到本系、本年级的id最大的开始时间和结束时间
        Record record = recordService.selectMaxTime(grade, department);
        String startTime = record.getStartTime();
        String endTime = record.getEndTime();
        // 获取宿舍号和随机号码
        List<Dorm> dormAndNumbers = dormService.selectDormAndNumber(grade, department, startTime, endTime);
        if (dormAndNumbers.size() > 0) {
            return ResultVOUtil.success(dormAndNumbers);
        } else {
            return ResultVOUtil.error("未查找到数据");
        }
    }

    @PostMapping("/getBlock")
    public ResultVO getBlock(Integer grade, String department) {
        List<String> block = dormDao.getBlock(grade, department);
        if (block.size() > 0) {
            return ResultVOUtil.success(block);
        } else {
            return ResultVOUtil.error("未查找到数据");
        }
    }

    /**
     * @Author: Hongchenglong
     * @Date: 2021/6/28 22:51
     * @Decription: 判断宿舍是否存在
     */
    @PostMapping("/doesItExist")
    public ResultVO doesItExist(Integer grade, String department, String block, Integer room) {
        Integer exit = dormDao.doesItExist(grade, department, block, room);
        if (exit != null) {
            return ResultVOUtil.success(null);
        } else {
            return ResultVOUtil.error("未查找到数据");
        }
    }

    @PostMapping("/customize")
    public ResultVO customize(Integer grade, String department, String block, String room) {
        List<Map<String, String>> dormSuc = new ArrayList<>();
        List<String> blockList = Arrays.asList(block.split(","));
        List<String> roomList = Arrays.asList(room.split(","));
        Integer len = blockList.size();
        for (Integer i = 0; i < len; i++) {
            // 判断指定宿舍是否存在
            ResultVO resultVO = doesItExist(grade, department, blockList.get(i), Integer.valueOf(roomList.get(i)));
            if (resultVO.getCode() == 0) {
                System.out.println(blockList.get(i) + "#" + roomList.get(i));
                Map<String, String> map = new HashMap<>();
                map.put("dorm_num", blockList.get(i) + "#" + roomList.get(i));
                map.put("rand_num", String.valueOf(new Random().nextInt(9000) + 1000));
                dormSuc.add(map);
            }
        }
        DataVO dataVO = new DataVO();
        dataVO.setDormSuc(dormSuc);
        if (dataVO != null) {
            return ResultVOUtil.success(dataVO);
        } else {
            return ResultVOUtil.error("未提供数据");
        }

    }
}
