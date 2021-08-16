package com.oeong.controller.web;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

/**
 * @Author: Hongchenglong
 * @Date: 2021/8/15 17:29
 * @Description:
 */
@Controller
@RequestMapping("/column")
public class ColumnHandler {

    @GetMapping("/index")
    public String index() {
        return "column/index";
    }
}
