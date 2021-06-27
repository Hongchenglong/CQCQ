package com.oeong.controller.api;

import com.oeong.entity.Dorm;
import com.oeong.entity.Instructor;
import com.oeong.entity.Student;
import com.oeong.service.DormService;
import com.oeong.service.InstructorService;
import com.oeong.service.StudentService;
import com.oeong.util.ResultVOUtil;
import com.oeong.vo.DataVO;
import com.oeong.vo.ResultVO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RequestMapping("/info")
@RestController
public class InfoController {

    @Autowired
    private StudentService studentService;
    @Autowired
    private InstructorService instructorService;
    @Autowired
    private DormService dormService;

    /**
     * 获取辅导员或学生的个人信息
     * @param id
     * @return
     */
    @PostMapping("/getHomeInfo")
    public ResultVO getHomeInfo(Integer id) {
        Instructor instructor = instructorService.findById(id);
        if (instructor != null) {
            return ResultVOUtil.success(instructor);
        } else {
            Student student = studentService.findById(id);
            if (student != null) {
                System.out.println(student.getDorm());
                Dorm dorm = dormService.findByDormNum(student.getDorm(), student.getGrade(), student.getDepartment());
                System.out.println(dorm);
                DataVO dataVO = new DataVO();
                dataVO.setRoomInfo(dorm);
                dataVO.setStuInfo(student);
                return ResultVOUtil.success(dataVO);
            }
        }
        return ResultVOUtil.error("用户不存在");
    }
}
