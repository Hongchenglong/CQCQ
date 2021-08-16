package com.oeong.controller.web;

import com.oeong.entity.Instructor;
import com.oeong.entity.Student;
import com.oeong.entity.User;
import com.oeong.service.InstructorService;
import com.oeong.service.StudentService;
import com.oeong.util.ResultVOUtil;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.util.DigestUtils;
import org.springframework.web.bind.annotation.*;

import javax.servlet.http.HttpSession;
import javax.websocket.Session;
import java.util.HashMap;
import java.util.Map;

/**
 * @Author: Hongchenglong
 * @Date: 2021/8/15 15:46
 * @Description:
 */
@Controller
@RequestMapping("/login")
public class LoginHandler {

    @Autowired
    private InstructorService instructorService;
    @Autowired
    private StudentService studentService;

    @GetMapping("/index")
    public String index() {
        return "login/index";
    }

    @PostMapping("/valid")
    public String valid(User user, Model model, HttpSession session) {
        Instructor instructor = instructorService.findById(user.getId());
        if (instructor != null) {
            String pwd = instructor.getPassword();
            String password = DigestUtils.md5DigestAsHex(user.getPassword().getBytes()); // md5加密
            if (pwd.equals(password)) {
                session.setAttribute("user", instructor);
                return "redirect:/column/index";
            }
        }
        model.addAttribute("msg", "用户名或密码错误~");
        return "login/index";
    }
}
