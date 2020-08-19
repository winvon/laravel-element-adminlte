// 提示
import {Notification, MessageBox, Message} from 'element-ui'
import _ from 'lodash'
import moment from 'moment'

/**
 * 封装一个简单的提示方法
 * @param mess
 * @param options
 */
export function alert(mess, options = {}) {
    message(mess, options)
}

/**
 * 中间的提示弹出信息
 * @param message
 * @param options
 */
export function message(message, options = {}) {
    options.message = message || options.message
    options.title = options.title || '温情提示'
    options.type = options.type || 'error'
    Message(options)
}

/**
 * @author 封装 element-ui confirm
 * @param text
 * @param title
 * @param config
 * @returns {Promise}
 */
export function confirm(text, title = '温磬提示', config = {}) {
    return new Promise((resolve, reject) => {
        let confirmButtonLoadingClose = () => {
        }
        let _config = _.merge({
            showCancelButton: true,
            closeOnClickModal: false,
            center: true,
            type: 'warning'
        }, config)
        let afterCloseResolve = () => {
        }
        _config.beforeClose = (action, instance, done) => {
            if (_.isFunction(config.beforeClose)) {
                config.beforeClose(action, instance, () => {
                })
            }
            if (_.isFunction(config.confirmCallBack)) {
                if (action === 'confirm') {
                    instance.confirmButtonLoading = true
                    confirmButtonLoadingClose = () => {
                        instance.confirmButtonLoading = false
                    }
                    config.confirmCallBack({
                        confirmButtonLoadingClose,
                        close: () => new Promise((resolve, reject) => {
                            done()
                            afterCloseResolve = resolve
                        }),
                        action
                    })
                } else {
                    done()
                }
            }
            if (!config.confirmButtonLoading) {
                done()
            }
        }
        delete _config.confirmButtonLoading
        MessageBox.confirm(text, title, _config).then(_ => {
            afterCloseResolve()
            resolve()
        }).catch(err => {
            afterCloseResolve()
            reject(err)
        })
    })
}

// 数组转化为主键对象
export function array_pk(arr = [], id = 'id') {
    let refer = {}
    for (let v of arr) {
        refer[v[id]] = v
    }
    return refer
}

/**
 * 数组转化为数结构
 * @param arr
 * @param pk
 * @param pid
 * @param child
 * @param root
 * @param toString 判断是否把数字转化为string
 * @returns {Array}
 */
export function array_to_tree(arr, pk = 'id', pid = 'pid', child = '_child', root = 0, toString = false) {
    let refer = array_pk(arr, pk)
    let tree = []
    let parent = []
    if (toString) {
        root = String(root)
    }
    arr.forEach((data, key) => {
        let parentId = toString ? String(data[pid]) : data[pid]
        if (root === parentId) {
            tree.push(arr[key])
        } else {
            if (refer[parentId]) {
                parent = refer[parentId]
                if (!Array.isArray(parent[child])) {
                    parent[child] = []
                }
                parent[child].push(arr[key])
            }
        }
    })
    return tree
}

// 树结构的数据转化为array 结构
export function tree_to_array(arr, child = '_child') {
    let copyArr = _.cloneDeep(arr)
    let temp = []
    if (Array.isArray(copyArr)) {
        copyArr.forEach(v => {
            let childArr = dotData(v, child)
            if (Array.isArray(childArr) && childArr.length > 0) {
                let deepArr = tree_to_array(childArr, child)
                delete v[child]
                deepArr.forEach(v2 => {
                    temp.push(v2)
                })
            }
            temp.push(v)
        })
    }
    return temp
}

// 格式参数
export function param(json) {
    if (!json) return ''
    return _.cloneDeep(
        Object.keys(json).map(key => {
            if (json[key] === undefined) return ''
            if (Array.isArray(json[key])) {
                return json[key].map((v) => {
                    return encodeURIComponent(key + '[]') + '=' + encodeURIComponent(v)
                }).join('&')
            } else {
                return encodeURIComponent(key) + '=' + encodeURIComponent(json[key])
            }
        })
    ).join('&')
}

// 构建带请求参数的链接
export function build_url(url, obj) {
    if (_.isString(url)) {
        const [clearUrl, search] = url.split('?')
        let params = {}
        if (search) {
            params = param_to_obj(search)
        }
        return clearUrl + '?' + param(Object.assign({}, params, obj))
    }
    return ''
}

/**
 * 把链接解析成对象 如 http://www.baidu.com?a=1&b=2 => {a:1, b:2}
 * @param url
 * @returns {*}
 */
export function param_to_obj(url) {
    const search = url.split('?')[1]
    if (!search) {
        return {}
    }
    return JSON.parse(
        '{"' +
        decodeURIComponent(search)
            .replace(/"/g, '\\"')
            .replace(/&/g, '","')
            .replace(/=/g, '":"') +
        '"}'
    )
}

/**
 * 验证字段必须是完全是字母、数字
 * @param value
 * @returns {boolean}
 */
export function alpha_num(value) {
    return /^[0-9A-Z]*$/i.test(value)
}

/**
 * 验证字段必须是完全是字母、数字，以及破折号 ( - ) 和下划线 ( _ )
 * @param value
 * @returns {boolean}
 */
export function alpha_dash(value) {
    return /^[0-9A-Z_-]*$/i.test(value)
}

/**
 * 验证字段必须完全由字母构成。
 * @param value
 * @returns {boolean}
 */
export function alpha(value) {
    return /^[A-Z]*$/i.test(value)
}

/**
 * 验证字段是否为手机号
 * @param value
 * @returns {boolean}
 */
export function isMobile(value) {
    return !value || /^1[3456789]\d{9}$/.test(value);
}

/**
 * 验证字段必须是url
 * @param value
 * @returns {boolean}
 */
export function isUrl(value) {
    var strRegex = "^((https|http|ftp|rtsp|mms)://)"
        + "(([0-9a-z_!~*’().&=+$%-]+: )?[0-9a-z_!~*’().&=+$%-]+@)?" //ftp的user@
        + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
        + "|" // 允许IP和DOMAIN（域名）
        + "([0-9a-z_!~*’()-]+\.)*" // 域名- www.
        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
        + "[a-z]{2,6})" // first level domain- .com or .museum
        + "(:[0-9]{1,4})?" // 端口- :80

    var re = new RegExp(strRegex);
    return !value || re.test(value)
}

/**
 * 验证字段必须是整数
 * @param value
 * @returns {RegExp}
 */
export function isInt(value) {
    return !value || /^-?\d+$/.test(value)
}

/**
 * 验证字段必须是身份证格式
 * @param value
 * @returns {boolean}
 */
export function isIdCard(value) {
    return !value || /^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/.test(value)
}

/**
 * 是否是
 * @param val
 * @param int
 * @param decimal
 * @returns {boolean}
 */
export function isFormatFloat(val, int = 8, decimal = 2) {
    return !val || (new RegExp(`^-?\\d{1,${int}}(\.\\d{1,${decimal}})?$`)).test(val)
}

/**
 * 是否是数字
 * @param value
 * @returns {boolean}
 */
export function isFloat(value) {
    return !value || /^-?\d+(\.\d+)?$/.test(value)
}


/**
 * 验证字段必须是数组。
 * @param value
 * @returns {boolean}
 */
export function array(value) {
    return Array.isArray(value)
}

/**
 * 变量注入字符串
 * @param str String 字符串
 * @param obj 待替换的值
 * @returns {string}
 */
export function bind_str(str, obj, mark = ':') {
    if (typeof str !== 'string') {
        return str
    }
    for (let k in obj) {
        str = str.replace(new RegExp(mark + k, 'g'), obj[k])
    }
    return str
}

export function fetchList(autoPage = true) {
    if (!this.url) {
        throw Error('请求地址不存在')
    }
    this.innerParams.pageSize = this.innerPageSize
    this.innerParams.page = this.page
    let headers = {}
    // 这里是为了简化请求总数
    if (autoPage && this.isSameParamsExceptPage(this.innerParams)) {
        headers['page-simple'] = true
    } else {
        headers['page-simple'] = false
    }
    this.oldInnerParams = _.cloneDeep(this.innerParams)
    // 判断搜索条件有无变化 如何没有变化就不需要请求总页数
    return ajax.table(this.url, this.innerParams, {headers}).then(response => {
        if (Number.isInteger(response.total)) {
            this.total = response.total
        }
        if (Array.isArray(response.data)) {
            this.data = response.data
        }
    }).finally(_ => {
        this.loading = false
    })
}

/**
 * 过滤对象
 * @param obj
 * @returns {*}
 */
export function filterObj(obj) {
    if (_.isObject(obj)) {
        let temp = {}
        for (let k in obj) {
            if (obj[k] || obj[k] === 0 || obj[k] === false) {
                temp[k] = obj[k]
            }
        }
        return temp
    }
    return obj
}

/**
 * 传入文件字符串 获取文件的基本信息
 * @param path string
 * @returns {{extension: string, basename: string, filename: string, dirname: string}}
 */
export function path_info(path) {

    let basename = ''
    let dirname = ''
    let extension = ''
    let filename = ''

    if (typeof path === 'string') {
        let lastIndexOf = path.lastIndexOf('/')
        if (lastIndexOf > -1) {
            basename = path.substr(lastIndexOf + 1)
            dirname = path.substr(0, lastIndexOf)
        }

        if (basename === '') {
            basename = path
        }

        let index = basename.lastIndexOf('.')
        if (index > -1) {
            extension = basename.substr(index + 1)
            filename = basename.substr(0, index)
        }
    }

    return {
        basename,
        dirname,
        extension,
        filename,
    }
}

/**
 * vue router 替换url
 * @param $router
 * @param $route
 * @param query
 */
export function replaceUrl($router, $route, query) {
    $router.push({path: $route.path, params: $route.params, query: query})
}

/**
 * 移除设置系统消息
 */
export function removeSystemNoticeBadge(num = 0) {
    let removeSystemNoticeBadge = _.get(top, 'removeSystemNoticeBadge')
    if (removeSystemNoticeBadge) {
        removeSystemNoticeBadge(num)
    }
}

// 修改菜单的数量
export function updateMenuCount(url, numberConstructor = 0) {
    let pearMenu = _.get(top, 'layui.pearMenu')
    if (pearMenu) {
        pearMenu.updateBadgeNum(url, numberConstructor)
    }
}

/**
 * 时间格式
 * @param value
 * @param format
 * @returns string
 */
export function dateFormat(value, format = 'YYYY-MM-DD') {
    if (value) {
        return moment(value).format(format)
    }
    return value
}

/**
 * 像一个页面进行跳转
 * @param url
 */
export function toUrl(url, title = '') {
    let pearAdmin = _.get(top, 'layui.pearAdmin')
    if (pearAdmin) {
        pearAdmin.toUrl(url, title)
    } else {
        window.location.href = url
    }
}
