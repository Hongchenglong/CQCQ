package com.oeong.controller.web;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

/**
 * @Author: Hongchenglong
 * @Date: 2021/8/15 20:39
 * @Description:
 */
@Controller
@RequestMapping("/welcome")
public class WelcomeHandler {

    @GetMapping("/index")
    public String index() {
        return "welcome/index";
    }
}
