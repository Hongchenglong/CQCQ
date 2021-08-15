package com.oeong.controller.web;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

/**
 * @Author: Hongchenglong
 * @Date: 2021/8/15 15:46
 * @Description:
 */
@Controller
@RequestMapping("/login")
public class LoginHandler {

    @GetMapping("/index")
    public String index() {
        return "login/index";
    }
}
