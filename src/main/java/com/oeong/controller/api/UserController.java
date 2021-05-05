package com.oeong.controller.api;

import com.oeong.entity.Instructor;
import com.oeong.entity.Student;
import com.oeong.service.InstructorService;
import com.oeong.service.StudentService;
import com.oeong.util.ResultVOUtil;
import com.oeong.vo.ResultVO;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.util.DigestUtils;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

@RequestMapping("/user")
@Controller
public class UserController {

    @Autowired
    private StudentService studentService;
    @Autowired
    private InstructorService instructorService;

    @PostMapping("/login")
    @ResponseBody
    public ResultVO login(Integer id, String password) {
        System.out.println("用户正在登录");
        Instructor instructor = instructorService.findById(id);
        if (instructor != null) {
            String pwd = instructor.getPassword();
            password = DigestUtils.md5DigestAsHex(password.getBytes()); // md5加密
            if (pwd.equals(password)) {
                System.out.println("辅导员登录成功");
                return ResultVOUtil.success(instructor);
            }
        } else {
            Student student = studentService.findById(id);
            if (student != null) {
                String pwd = student.getPassword();
                password = DigestUtils.md5DigestAsHex(password.getBytes()); // md5加密
                if (pwd.equals(password)) {
                    System.out.println("学生登录成功");
                    return ResultVOUtil.success(student);
                }
            }
        }
        return ResultVOUtil.error("您输入的账号或密码不正确");
    }
}
