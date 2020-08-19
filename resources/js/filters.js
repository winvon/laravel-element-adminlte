import _ from 'lodash'
import Vue from 'vue'
import {isFloat} from "./helper"
import moment from 'moment'
// 真假过滤器
Vue.filter('isTrue', function (value) {
    if (/^\d+$/.test(value)) {
        switch (parseInt(value)) {
            case 0:
                return '否'
            case 1:
                return '是'
        }
    }
    return value
})


// 百分比过滤器
Vue.filter('percentage', function (value) {
    if (isFloat(value)) {
        return (value * 100).toFixed(2) + '%'
    } else {
        return value
    }
})

// 四舍五入转数字类型
Vue.filter('toFixed', function (value, decimal = 2) {
    if (isFloat(value)) {
        return parseFloat((value)).toFixed(decimal)
    } else {
        return value
    }
})

// YYYY-MM-DD HH:mm:ss
Vue.filter('date_format', function (value, format = 'YYYY-MM-DD') {
    return moment(value).format(format)
})
