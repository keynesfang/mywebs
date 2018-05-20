var regist_form = {
    title: "新用户注册",
    sub_title: "New",
    error_message: "用户注册失败！",
    form_class: "user_add",
    table_name: "family_user",
    fields: {
        loginName: {
            chn: "用户名称",
            type: "text",
            attributes: {
                conflict: "valueIsNull,alreadyExist",
                placeholder: "系统登陆名称",
                table_name: "family_user",
                invalid_feedback: "用户名称不能为空！_用户名称已被注册！"
            }
        },
        loginPass: {
            chn: "用户密码",
            type: "password",
            attributes: {
                conflict: "valueIsNull",
                placeholder: "系统登陆密码",
                invalid_feedback: "用户密码不能为空！"
            }
        },
        loginPass$: {
            chn: "重复密码",
            type: "password",
            attributes: {
                conflict: "valueNotSame",
                placeholder: "密码录入验证",
                invalid_feedback: "两次密码不相同！"
            }
        }
    },
    button: {
        chn: "新用户注册",
        action: "insertDataToDB",
        callback: "user_regist_callback"
    }
};

var login_form = {
    title: "用户登陆",
    sub_title: "Login",
    error_message: "密码错误，登陆失败！",
    form_class: "user_login",
    table_name: "family_user",
    fields: {
        loginName: {
            chn: "用户名称",
            type: "text",
            attributes: {
                conflict: "valueIsNull,notExist",
                placeholder: "系统登陆名称",
                table_name: "family_user",
                invalid_feedback: "用户名称不能为空！_用户名称未被注册！"
            }
        },
        loginPass: {
            chn: "用户密码",
            type: "password",
            attributes: {
                conflict: "valueIsNull",
                placeholder: "系统登陆密码",
                invalid_feedback: "用户密码不能为空！"
            }
        }
    },
    button: {
        chn: "用户登陆",
        action: "login",
        callback: "page_login_callback"
    }
};

var family_forms = {
    title: "创建族谱",
    sub_title: "New",
    error_message: "族谱创建失败！",
    form_class: "add_family",
    table_name: "family",
    fields: {
        surname: {
            chn: "家族姓氏",
            type: "text",
            attributes: {
                conflict: "valueIsNull,valueLengthTooLong",
                placeholder: "家族姓氏",
                limit_length: 2,
                invalid_feedback: "姓氏不能为空！_姓氏只能在2字以内！"
            }
        },
        name: {
            chn: "族谱名称",
            type: "text",
            attributes: {
                conflict: "valueIsNull,alreadyExist",
                placeholder: "族谱名称",
                table_name: "family",
                invalid_feedback: "族谱名称不能为空！_族谱名称已被注册！"
            }
        },
        city: {
            chn: "所在城市",
            type: "select",
            options: ",北京,上海,天津,重庆,河北,山西,河南,辽宁,吉林,黑龙江,内蒙古,江苏,山东,安徽,浙江,福建,湖北,湖南,广东,广西,江西,四川,海南,贵州,云南,西藏,陕西,甘肃,青海,宁夏,新疆,港澳,台湾,钓鱼岛,海外",
            attributes: {
                conflict: "valueIsNull",
                placeholder: "族谱名称",
                table_name: "family",
                invalid_feedback: "请选择家族所在的城市！"
            }
        },
        clef: {
            chn: "族谱谱号",
            type: "text",
            attributes: {
                placeholder: "族谱房/堂/支号 选填"
            }
        },
        area: {
            chn: "家族地望",
            type: "text",
            attributes: {
                placeholder: "家族所在地域名称 选填"
            }
        },
        create_user_id: {
            chn: "",
            type: "hidden",
            attributes: {
                value: $.cookie("user_id")
            }
        },
        create_date: {
            chn: "",
            type: "hidden",
            attributes: {
                value: getToday()
            }
        }
    },
    button: {
        chn: "创建族谱",
        action: "insertDataToDB",
        callback: "new_family_callback"
    }
};