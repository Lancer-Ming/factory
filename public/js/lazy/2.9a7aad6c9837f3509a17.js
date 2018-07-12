webpackJsonp([2],{

/***/ 193:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(194)
/* script */
var __vue_script__ = __webpack_require__(213)
/* template */
var __vue_template__ = __webpack_require__(215)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources\\assets\\js\\views\\Permission.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-loader/node_modules/vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-41063a1c", Component.options)
  } else {
    hotAPI.reload("data-v-41063a1c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 194:
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ 195:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_axios__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_element_ui__ = __webpack_require__(25);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_element_ui___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_element_ui__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_error_message_vue__ = __webpack_require__(196);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_error_message_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_error_message_vue__);
function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }





// http response 拦截器
__WEBPACK_IMPORTED_MODULE_0_axios___default.a.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    // 403 没有权限
    if (error.response.status == 403) {
        Object(__WEBPACK_IMPORTED_MODULE_1_element_ui__["Message"])({
            message: '您没有权限操作',
            type: 'warning'
        });
    }

    // 422 表单或者其他的规则不符
    if (error.response.status == 422) {
        var errors = error.response.data.errors;
        var arr = Object.values(errors);
        var html = '';
        var result = [];
        arr.forEach(function (item) {
            result.push.apply(result, _toConsumableArray(item));
        });

        result.forEach(function (item) {
            html += '<li style="list-style: none;">' + item + '</li>';
        });

        Object(__WEBPACK_IMPORTED_MODULE_1_element_ui__["Message"])({
            message: html,
            type: 'error',
            dangerouslyUseHTMLString: true
        });
    }
    return Promise.reject(error.response.data);
});

/* harmony default export */ __webpack_exports__["a"] = (__WEBPACK_IMPORTED_MODULE_0_axios___default.a);

/***/ }),

/***/ 196:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(194)
/* script */
var __vue_script__ = __webpack_require__(197)
/* template */
var __vue_template__ = __webpack_require__(198)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources\\assets\\js\\components\\_error_message.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-loader/node_modules/vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3cf28d30", Component.options)
  } else {
    hotAPI.reload("data-v-3cf28d30", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 197:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    props: {
        messages: {
            type: Array
        }
    }
});

/***/ }),

/***/ 198:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "ul",
    _vm._l(_vm.messages, function(message) {
      return _c("li", [_vm._v(" " + _vm._s(message) + " ")])
    })
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-loader/node_modules/vue-hot-reload-api")      .rerender("data-v-3cf28d30", module.exports)
  }
}

/***/ }),

/***/ 213:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__api_permission__ = __webpack_require__(214);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
    data: function data() {
        return {
            treeData: [],
            options: [],
            defaultProps: {
                children: 'children',
                label: 'label'
            },
            form: {
                parent_id: null,
                name: '',
                label: '',
                icon: '',
                is_category: 1
            },
            formLabelWidth: "100px",
            formType: '',
            showForm: false,
            id: null
        };
    },
    created: function created() {
        var _this = this;

        Object(__WEBPACK_IMPORTED_MODULE_0__api_permission__["d" /* getPermissions */])().then(function (res) {
            if (res.data.response_status === "success") {
                _this.treeData = res.data.data.permissions;
                _this.options = res.data.data.simplePermissions;
            }
        });
    },

    methods: {
        submitForm: function submitForm() {
            var _this2 = this;

            if (this.formType === 'edit') {
                Object(__WEBPACK_IMPORTED_MODULE_0__api_permission__["e" /* updatePermissions */])(this.id, this.form).then(function (res) {
                    _this2.successCallback(res);
                });
            } else {
                Object(__WEBPACK_IMPORTED_MODULE_0__api_permission__["a" /* addPermissions */])(this.form).then(function (res) {
                    _this2.successCallback(res);
                });
            }
        },
        handleEdit: function handleEdit(data) {
            var _this3 = this;

            this.formType = 'edit';
            Object(__WEBPACK_IMPORTED_MODULE_0__api_permission__["c" /* editPermissions */])(data.id).then(function (res) {
                if (res.data.response_status === "success") {
                    var editData = res.data.data;
                    _this3.form = {
                        name: editData.name,
                        label: editData.label,
                        icon: editData.icon,
                        is_category: editData.is_category
                    };
                    _this3.$set(_this3.form, 'parent_id', editData.parent_id);
                    _this3.id = editData.id;
                    _this3.showForm = true;
                }
            });
        },
        handleAdd: function handleAdd(data) {
            // 改变表单类型
            this.formType = 'add';
            // 清空form
            this.form = {
                parent_id: null,
                name: '',
                label: '',
                icon: '',
                is_category: 1
                // 改变表单的上级菜单
            };this.$set(this.form, 'parent_id', data.id);
            // 使表单显示
            this.showForm = true;
        },
        handleDelete: function handleDelete(data) {
            var _this4 = this;

            this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning',
                center: true
            }).then(function () {
                Object(__WEBPACK_IMPORTED_MODULE_0__api_permission__["b" /* deletePermissions */])(data.id).then(function (res) {
                    _this4.successCallback(res);
                });
            }).catch(function () {
                return;
            });
        },
        handleDragEnd: function handleDragEnd() {
            var data = JSON.stringify(this.treeData);
        },
        successCallback: function successCallback(res) {
            if (res.data.response_status === "success") {
                this.treeData = res.data.data;
                this.showForm = false;
                this.$message({
                    type: 'success',
                    showClose: true,
                    message: res.data.msg
                });
            }
        }
    }
});

/***/ }),

/***/ 214:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["d"] = getPermissions;
/* harmony export (immutable) */ __webpack_exports__["c"] = editPermissions;
/* harmony export (immutable) */ __webpack_exports__["e"] = updatePermissions;
/* harmony export (immutable) */ __webpack_exports__["a"] = addPermissions;
/* harmony export (immutable) */ __webpack_exports__["b"] = deletePermissions;
/* unused harmony export sortPermissions */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utils_request__ = __webpack_require__(195);


function getPermissions() {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: '/permission?is_category=1',
        method: 'get'
    });
}

function editPermissions(id) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: '/permission/' + id + '/edit',
        method: 'get'
    });
}

function updatePermissions(id, form) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: '/permission/' + id,
        method: 'patch',
        data: form
    });
}

function addPermissions(form) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: '/permission',
        method: 'post',
        data: form
    });
}

function deletePermissions(id) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: '/permission/' + id,
        method: 'delete'
    });
}

function sortPermissions(data) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__utils_request__["a" /* default */])({
        url: '/permission/sort',
        method: { sort: data }
    });
}

/***/ }),

/***/ 215:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "container" },
    [
      _c("el-tree", {
        attrs: {
          data: _vm.treeData,
          "node-key": "id",
          "expand-on-click-node": false,
          "default-expand-all": true,
          draggable: ""
        },
        on: { "node-drag-end": _vm.handleDragEnd },
        scopedSlots: _vm._u([
          {
            key: "default",
            fn: function(ref) {
              var node = ref.node
              var data = ref.data
              return _c("span", { staticClass: "custom-tree-node" }, [
                _c("span", [_vm._v(_vm._s(node.label))]),
                _vm._v(" "),
                _c("span", [
                  data.is_category > 0
                    ? _c("i", {
                        staticClass: "el-icon-plus",
                        on: {
                          click: function($event) {
                            _vm.handleAdd(data)
                          }
                        }
                      })
                    : _vm._e(),
                  _vm._v(" "),
                  _c("i", {
                    staticClass: "el-icon-edit",
                    on: {
                      click: function($event) {
                        _vm.handleEdit(data)
                      }
                    }
                  }),
                  _vm._v(" "),
                  _c("i", {
                    staticClass: "el-icon-delete",
                    on: {
                      click: function($event) {
                        _vm.handleDelete(data)
                      }
                    }
                  })
                ])
              ])
            }
          }
        ])
      }),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          attrs: { title: "编辑菜单权限", visible: _vm.showForm, width: "22%" },
          on: {
            "update:visible": function($event) {
              _vm.showForm = $event
            }
          }
        },
        [
          _c(
            "el-form",
            { attrs: { model: _vm.form } },
            [
              _c(
                "el-form-item",
                {
                  attrs: {
                    label: "上级菜单",
                    "label-width": _vm.formLabelWidth
                  }
                },
                [
                  _c(
                    "el-select",
                    {
                      attrs: {
                        placeholder: "请选择",
                        "value-key": "item",
                        disabled: ""
                      },
                      model: {
                        value: _vm.form.parent_id,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "parent_id", $$v)
                        },
                        expression: "form.parent_id"
                      }
                    },
                    _vm._l(_vm.options, function(item) {
                      return _c("el-option", {
                        key: item.id,
                        attrs: { value: item.id, label: item.label }
                      })
                    })
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                {
                  attrs: {
                    label: "权限路由名",
                    "label-width": _vm.formLabelWidth
                  }
                },
                [
                  _c("el-input", {
                    staticStyle: { width: "200px" },
                    attrs: { "auto-complete": "off", size: "mini" },
                    model: {
                      value: _vm.form.name,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "name", $$v)
                      },
                      expression: "form.name"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                {
                  attrs: {
                    label: "权限菜单名",
                    "label-width": _vm.formLabelWidth
                  }
                },
                [
                  _c("el-input", {
                    staticStyle: { width: "200px" },
                    attrs: { "auto-complete": "off", size: "mini" },
                    model: {
                      value: _vm.form.label,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "label", $$v)
                      },
                      expression: "form.label"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                {
                  attrs: {
                    label: "图标icon",
                    "label-width": _vm.formLabelWidth
                  }
                },
                [
                  _c("el-input", {
                    staticStyle: { width: "250px" },
                    attrs: { "auto-complete": "off", size: "mini" },
                    model: {
                      value: _vm.form.icon,
                      callback: function($$v) {
                        _vm.$set(_vm.form, "icon", $$v)
                      },
                      expression: "form.icon"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                {
                  attrs: {
                    label: "是否为菜单",
                    "label-width": _vm.formLabelWidth
                  }
                },
                [
                  _c(
                    "el-radio",
                    {
                      attrs: { label: 1 },
                      model: {
                        value: _vm.form.is_category,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "is_category", $$v)
                        },
                        expression: "form.is_category"
                      }
                    },
                    [_vm._v("是")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-radio",
                    {
                      attrs: { label: 0 },
                      model: {
                        value: _vm.form.is_category,
                        callback: function($$v) {
                          _vm.$set(_vm.form, "is_category", $$v)
                        },
                        expression: "form.is_category"
                      }
                    },
                    [_vm._v("否")]
                  )
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "dialog-footer",
              attrs: { slot: "footer" },
              slot: "footer"
            },
            [
              _c(
                "el-button",
                {
                  on: {
                    click: function($event) {
                      _vm.showForm = false
                    }
                  }
                },
                [_vm._v("取 消")]
              ),
              _vm._v(" "),
              _c(
                "el-button",
                { attrs: { type: "primary" }, on: { click: _vm.submitForm } },
                [_vm._v("确 定")]
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-loader/node_modules/vue-hot-reload-api")      .rerender("data-v-41063a1c", module.exports)
  }
}

/***/ })

});