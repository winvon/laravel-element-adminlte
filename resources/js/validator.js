
/**
 * 验证字段必须是完全是字母、数字
 * @param rule Object 验证规则
 * @param value String 值
 * @param callback function
 */
export function alpha_num(rule, value, callback) {
    if (helper.alpha_num(value)) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 验证字段必须是完全是字母、数字，以及破折号 ( - ) 和下划线 ( _ )
 * @param rule Object 验证规则
 * @param value String 值
 * @param callback function
 */
export function alpha_dash(rule, value, callback) {
    if (helper.alpha_dash(value)) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 验证字段必须是完全是字母
 * @param rule Object 验证规则
 * @param value String 值
 * @param callback function
 */
export function alpha(rule, value, callback) {
    if (helper.alpha(value)) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 整型
 * @param rule
 * @param value
 * @param callback
 */
export function isInt(rule, value, callback) {
    if (helper.isInt(value)) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 正整型
 * @param rule
 * @param value
 * @param callback
 */
export function isPositiveInt(rule, value, callback) {
    const min = rule.min > 0 ? rule.min : 0
    if (helper.isInt(value) && value >= min) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 验证和其他值是否相同
 * @param rule
 * @param value
 * @param callback
 */
export function same(rule, value, callback) {
    let otherValue = rule.value || ''
    if (value === otherValue) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 小数(整数8位，小数两位)
 * @param rule
 * @param value
 * @param callback
 */
export function isFormatFloat(rule, value, callback) {
    let int = rule.int || 8
    let decimal = rule.decimal || 2
    if (helper.isFormatFloat(value, int, decimal)) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 验证字段必须是url
 * @param value
 * @returns {boolean}
 */
export function isUrl(rule, value, callback) {
    if (helper.isUrl(value)) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 验证字段必须是手机号格式
 * @param value
 * @returns {boolean}
 */
export function isMobile(rule, value, callback) {
    if (helper.isMobile(value)) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 验证字段必须是身份证格式
 * @param value
 * @returns {boolean}
 */
export function isIdCard(rule, value, callback) {
    if (helper.isIdCard(value)) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

/**
 * 验证最小值
 * @param rule
 * @param value
 * @param callback
 */
export function range(rule, value, callback) {
    let min = parseFloat(rule.min)
    let max = parseFloat(rule.max)
    value = parseFloat(value)
    if (value < min) {
        callback(new Error(rule.message))
        return
    }
    if (value > max) {
        callback(new Error(rule.message))
        return
    }
    callback()
}

/**
 * 验证字符串长度
 * @param rule
 * @param value
 * @param callback
 */
export function strLen(rule, value, callback) {
    let min = parseFloat(rule.min)
    let max = parseFloat(rule.max)
    if (typeof value !== 'string') {
        callback(new Error('必须是字符串'))
        return
    }
    value = value.length
    if (value < min) {
        callback(new Error(rule.message))
        return
    }
    if (value > max) {
        callback(new Error(rule.message))
        return
    }
    callback()
}

/**
 * 含有特殊符合
 * @returns {boolean}
 */
export function symbol(value) {
    var strRegex = '[`~!@#$%^&*()_\\-+=<>?:"{}|,.\\/;\'\\\\[\\]·~！@#￥%……&*（）——\\-+={}|《》？：“”【】、；‘\'，。、]'
    var re = new RegExp(strRegex);
    return re.test(value)
}

/**
 * 不能含有特殊符号
 * @param rule
 * @param value
 * @param callback
 */
export function notSymbol(rule, value, callback) {
    if (!value){
        callback()
    }
    if (!symbol(value)) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}


export function imageGroup(rule, value, callback) {
    let group = rule.group
    let pass = true

    if (Array.isArray(value)) {
        for (let v of value) {
            for (let item of group) {
                if (!v[item['name']]) {
                    pass = false
                    break
                }
            }
        }
    }

    if (pass) {
        callback()
    } else {
        callback(new Error(rule.message));
    }
}

