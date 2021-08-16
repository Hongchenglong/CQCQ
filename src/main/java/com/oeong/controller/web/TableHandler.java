package com.oeong.controller.web;

import com.oeong.entity.Student;
import com.oeong.entity.User;
import com.oeong.service.StudentService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.util.DigestUtils;
import org.springframework.web.bind.annotation.*;

import javax.servlet.http.HttpServletRequest;
import java.nio.charset.StandardCharsets;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * @Author: Hongchenglong
 * @Date: 2021/8/15 22:36
 * @Description:
 */
@Controller
@RequestMapping("/table")
public class TableHandler {

    @Autowired
    private StudentService studentService;

    @GetMapping("/index")
    public String index() {
        return "table/index";
    }

    @GetMapping("/add")
    public String add() {
        return "table/add";
    }

    @ResponseBody
    @GetMapping("/studentList")
    public Map<String, Object> studentList(@RequestParam Integer grade, @RequestParam String department,
                                            HttpServletRequest request) {
        Map<String, Object> map = new HashMap<>();
        Integer page = Integer.valueOf(request.getParameter("page"));
        Integer limit = Integer.parseInt(request.getParameter("limit"));
        List<Student> studentList = studentService.findByGradeAndDepart(grade, department, page, limit);
        map.put("data", studentList);
        map.put("code", 0);
        map.put("msg", "查询成功");
        map.put("count", studentService.countByGradeAndDepart(grade, department));

        return map;
    }

    @ResponseBody
    @GetMapping("/search/{id}")
    public Map<String, Object> search(@PathVariable("id") Integer id) {
        Map<String, Object> map = new HashMap<>();
        Student student = studentService.findById(id);
        if (student != null) {
            map.put("data", student);
            map.put("success", true);
        } else {
            map.put("success", false);
        }

        return map;
    }

    @ResponseBody
    @PostMapping("/addUser")
    private Map<String, Object> addUser(Student student) {
        // 当前端请求的Content-Type是Json时，可以用@RequestBody这个注解来解决。
        Map<String, Object> map = new HashMap<>();
        try {
            studentService.insert(student.getId(), student.getSex(), student.getUsername(), DigestUtils.md5DigestAsHex(student.getPassword().getBytes()),
                    student.getEmail(), student.getPhone(), student.getGrade(), student.getDepartment(), student.getDorm());
            map.put("success", true);
        } catch (Exception e) {
            e.printStackTrace();
            map.put("success", false);
        }

        return map;
    }
}
