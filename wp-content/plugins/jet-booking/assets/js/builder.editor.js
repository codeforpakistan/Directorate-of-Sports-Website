/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./actions/apartment-booking.js":
/*!**************************************!*\
  !*** ./actions/apartment-booking.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { var _i = arr && (typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]); if (_i == null) return; var _arr = []; var _n = true; var _d = false; var _s, _e; try { for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

var _wp$components = wp.components,
    SelectControl = _wp$components.SelectControl,
    TextControl = _wp$components.TextControl,
    BaseControl = _wp$components.BaseControl,
    Button = _wp$components.Button,
    Notice = _wp$components.Notice;
var _wp$element = wp.element,
    useState = _wp$element.useState,
    useEffect = _wp$element.useEffect;
var _JetFBActions = JetFBActions,
    addAction = _JetFBActions.addAction,
    getFormFieldsBlocks = _JetFBActions.getFormFieldsBlocks;
var _JetFBComponents = JetFBComponents,
    ActionFieldsMap = _JetFBComponents.ActionFieldsMap,
    WrapperRequiredControl = _JetFBComponents.WrapperRequiredControl,
    RepeaterWithState = _JetFBComponents.RepeaterWithState,
    ActionModal = _JetFBComponents.ActionModal;
var addNewOption = {
  type: '',
  label: '',
  format: '',
  field: '',
  link_label: ''
};
addAction('apartment_booking', function ApartmentBooking(_ref) {
  var settings = _ref.settings,
      source = _ref.source,
      label = _ref.label,
      help = _ref.help,
      onChangeSetting = _ref.onChangeSetting;

  var _useState = useState([]),
      _useState2 = _slicedToArray(_useState, 2),
      formFieldsList = _useState2[0],
      setFormFieldsList = _useState2[1];

  var _useState3 = useState([]),
      _useState4 = _slicedToArray(_useState3, 2),
      columnsMap = _useState4[0],
      setColumnsMap = _useState4[1];

  var _useState5 = useState([]),
      _useState6 = _slicedToArray(_useState5, 2),
      wcFields = _useState6[0],
      setWcFields = _useState6[1];

  var _useState7 = useState(false),
      _useState8 = _slicedToArray(_useState7, 2),
      wcDetailsModal = _useState8[0],
      setWcDetailsModal = _useState8[1];

  var _useState9 = useState(false),
      _useState10 = _slicedToArray(_useState9, 2),
      isLoading = _useState10[0],
      setLoading = _useState10[1];

  useEffect(function () {
    var columnsMap = {};
    source.columns.forEach(function (col) {
      columnsMap[col] = {
        label: col
      };
    });
    var wcColumnsMap = {};
    source.wc_fields.forEach(function (col) {
      wcColumnsMap[col] = {
        label: col
      };
    });
    setColumnsMap(Object.entries(columnsMap));
    setWcFields(Object.entries(wcColumnsMap));
    setFormFieldsList(getFormFieldsBlocks([], '--'));
  }, []);

  function saveWCDetails(items) {
    setLoading(true);
    jQuery.ajax({
      url: window.ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'jet_booking_save_wc_details',
        post_id: source.apartment,
        nonce: source.nonce,
        details: items
      }
    }).done(function (response) {
      setLoading(false);

      if (!response.success) {
        alert(response.data.message);
      } else {
        JetBookingActionData.details = items;
        setWcDetailsModal(false);
      }
    }).fail(function (jqXHR, textStatus, errorThrown) {
      setLoading(false);
      alert(errorThrown);
    });
  }

  return wp.element.createElement(React.Fragment, null, wp.element.createElement(SelectControl, {
    label: label('booking_apartment_field'),
    labelPosition: "side",
    value: settings.booking_apartment_field,
    onChange: function onChange(val) {
      return onChangeSetting(val, 'booking_apartment_field');
    },
    options: formFieldsList
  }), wp.element.createElement(SelectControl, {
    label: label('booking_dates_field'),
    labelPosition: "side",
    value: settings.booking_dates_field,
    onChange: function onChange(val) {
      return onChangeSetting(val, 'booking_dates_field');
    },
    options: formFieldsList
  }), wp.element.createElement(ActionFieldsMap, {
    label: label('db_columns_map'),
    fields: columnsMap,
    plainHelp: help('db_columns_map')
  }, function (_ref2) {
    var fieldId = _ref2.fieldId,
        fieldData = _ref2.fieldData,
        index = _ref2.index;
    return wp.element.createElement(WrapperRequiredControl, {
      field: [fieldId, fieldData]
    }, wp.element.createElement(TextControl, {
      key: fieldId + index,
      value: settings["db_columns_map_".concat(fieldId)],
      onChange: function onChange(val) {
        return onChangeSetting(val, "db_columns_map_".concat(fieldId));
      }
    }));
  }), Boolean(source.wc_integration) && wp.element.createElement(React.Fragment, null, wp.element.createElement(SelectControl, {
    label: label('booking_wc_price'),
    help: help('booking_wc_price'),
    labelPosition: "side",
    value: settings.booking_wc_price,
    onChange: function onChange(val) {
      return onChangeSetting(val, 'booking_wc_price');
    },
    options: formFieldsList
  }), wp.element.createElement(BaseControl, {
    label: label('wc_order_details'),
    help: help('wc_order_details')
  }, wp.element.createElement(Button, {
    isSecondary: true,
    onClick: function onClick() {
      return setWcDetailsModal(true);
    }
  }, 'Set up')), wp.element.createElement(ActionFieldsMap, {
    label: label('wc_fields_map'),
    fields: wcFields,
    plainHelp: help('wc_fields_map')
  }, function (_ref3) {
    var fieldId = _ref3.fieldId,
        fieldData = _ref3.fieldData,
        index = _ref3.index;
    return wp.element.createElement(WrapperRequiredControl, {
      field: [fieldId, fieldData]
    }, wp.element.createElement(SelectControl, {
      key: fieldId + index,
      labelPosition: "side",
      value: settings["wc_fields_map__".concat(fieldId)],
      onChange: function onChange(val) {
        return onChangeSetting(val, "wc_fields_map__".concat(fieldId));
      },
      options: formFieldsList
    }));
  }), wcDetailsModal && wp.element.createElement(ActionModal, {
    title: 'Set up WooCommerce order details',
    onRequestClose: function onRequestClose() {
      return setWcDetailsModal(false);
    },
    classNames: ['width-60'],
    style: {
      opacity: isLoading ? '0.5' : '1'
    },
    updateBtnProps: {
      isBusy: isLoading
    }
  }, function (_ref4) {
    var actionClick = _ref4.actionClick,
        onRequestClose = _ref4.onRequestClose;
    return wp.element.createElement(RepeaterWithState, {
      items: source.details,
      onSaveItems: saveWCDetails,
      newItem: addNewOption,
      onUnMount: function onUnMount() {
        if (!actionClick) {
          onRequestClose();
        }
      },
      isSaveAction: actionClick,
      addNewButtonLabel: isLoading ? 'Saving...' : 'Add new item +'
    }, function (_ref5) {
      var currentItem = _ref5.currentItem,
          changeCurrentItem = _ref5.changeCurrentItem;
      return wp.element.createElement(React.Fragment, null, wp.element.createElement(SelectControl, {
        label: label('wc_details__type'),
        labelPosition: "side",
        value: currentItem.type,
        onChange: function onChange(type) {
          return changeCurrentItem({
            type: type
          });
        },
        options: source.details_types
      }), wp.element.createElement(TextControl, {
        label: label('wc_details__label'),
        value: currentItem.label,
        onChange: function onChange(label) {
          return changeCurrentItem({
            label: label
          });
        }
      }), ['check-in', 'check-out'].includes(currentItem.type) && wp.element.createElement(React.Fragment, null, wp.element.createElement(TextControl, {
        label: label('wc_details__format'),
        value: currentItem.format,
        onChange: function onChange(format) {
          return changeCurrentItem({
            format: format
          });
        }
      }), wp.element.createElement("a", {
        href: "https://codex.wordpress.org/Formatting_Date_and_Time",
        target: "_blank"
      }, "Formatting docs")), 'field' === currentItem.type && wp.element.createElement(SelectControl, {
        label: label('wc_details__field'),
        labelPosition: "side",
        value: currentItem.field,
        onChange: function onChange(field) {
          return changeCurrentItem({
            field: field
          });
        },
        options: formFieldsList
      }), 'add_to_calendar' === currentItem.type && wp.element.createElement(TextControl, {
        label: label('wc_details__link_label'),
        value: currentItem.link_label,
        onChange: function onChange(link_label) {
          return changeCurrentItem({
            link_label: link_label
          });
        }
      }));
    });
  })));
});

/***/ }),

/***/ "./blocks/check-in-out/block.json":
/*!****************************************!*\
  !*** ./blocks/check-in-out/block.json ***!
  \****************************************/
/*! exports provided: apiVersion, name, category, icon, keywords, textdomain, supports, attributes, default */
/***/ (function(module) {

module.exports = JSON.parse("{\"apiVersion\":2,\"name\":\"jet-forms/check-in-out\",\"category\":\"jet-form-builder-fields\",\"icon\":\"<svg width=\\\"64\\\" height=\\\"64\\\" viewBox=\\\"0 0 64 64\\\" fill=\\\"none\\\" xmlns=\\\"http://www.w3.org/2000/svg\\\">\\n<rect width=\\\"64\\\" height=\\\"64\\\" fill=\\\"white\\\"/>\\n<rect x=\\\"10\\\" y=\\\"10\\\" width=\\\"44\\\" height=\\\"47\\\" rx=\\\"3\\\" fill=\\\"white\\\" stroke=\\\"#162B40\\\" stroke-width=\\\"2\\\"/>\\n<path d=\\\"M10 13C10 11.3431 11.3431 10 13 10H51C52.6569 10 54 11.3431 54 13V23H10V13Z\\\" fill=\\\"#4AF3BA\\\" stroke=\\\"#162B40\\\" stroke-width=\\\"2\\\"/>\\n<path d=\\\"M17 7C17 6.44772 17.4477 6 18 6C18.5523 6 19 6.44772 19 7V13C19 13.5523 18.5523 14 18 14C17.4477 14 17 13.5523 17 13V7Z\\\" fill=\\\"#162B40\\\"/>\\n<path d=\\\"M45 7C45 6.44772 45.4477 6 46 6C46.5523 6 47 6.44772 47 7V13C47 13.5523 46.5523 14 46 14C45.4477 14 45 13.5523 45 13V7Z\\\" fill=\\\"#162B40\\\"/>\\n<rect x=\\\"14.5\\\" y=\\\"27.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"white\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"14.5\\\" y=\\\"37.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"#4AF3BA\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"14.5\\\" y=\\\"47.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"#4AF3BA\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"24.5\\\" y=\\\"27.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"#4AF3BA\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"24.5\\\" y=\\\"37.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"#4AF3BA\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"24.5\\\" y=\\\"47.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"white\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"34.5\\\" y=\\\"27.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"#4AF3BA\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"34.5\\\" y=\\\"37.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"#4AF3BA\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"34.5\\\" y=\\\"47.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"white\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"44.5\\\" y=\\\"27.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"#4AF3BA\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"44.5\\\" y=\\\"37.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"#4AF3BA\\\" stroke=\\\"#162B40\\\"/>\\n<rect x=\\\"44.5\\\" y=\\\"47.5\\\" width=\\\"5\\\" height=\\\"5\\\" rx=\\\"0.5\\\" fill=\\\"white\\\" stroke=\\\"#162B40\\\"/>\\n</svg>\\n\",\"keywords\":[\"field\",\"check-in-out\",\"check_in_out\",\"booking\",\"apartment\"],\"textdomain\":\"jet-form-builder\",\"supports\":{\"customClassName\":false,\"html\":false},\"attributes\":{\"cio_field_layout\":{\"type\":\"string\",\"default\":\"\"},\"cio_fields_position\":{\"type\":\"string\",\"default\":\"\"},\"first_field_label\":{\"type\":\"string\",\"default\":\"\"},\"first_field_placeholder\":{\"type\":\"string\",\"default\":\"\"},\"second_field_label\":{\"type\":\"string\",\"default\":\"\"},\"second_field_placeholder\":{\"type\":\"string\",\"default\":\"\"},\"cio_fields_format\":{\"type\":\"string\",\"default\":\"\"},\"cio_fields_separator\":{\"type\":\"string\",\"default\":\"\"},\"start_of_week\":{\"type\":\"string\",\"default\":\"\"},\"label\":{\"type\":\"string\",\"default\":\"\"},\"name\":{\"type\":\"string\",\"default\":\"field_name\"},\"desc\":{\"type\":\"string\",\"default\":\"\"},\"default\":{\"type\":\"string\",\"default\":\"\"},\"required\":{\"type\":\"boolean\",\"default\":false},\"add_prev\":{\"type\":\"boolean\",\"default\":false},\"prev_label\":{\"type\":\"string\",\"default\":\"\"},\"visibility\":{\"type\":\"string\",\"default\":\"\"},\"class_name\":{\"type\":\"string\",\"default\":\"\"},\"className\":{\"type\":\"string\",\"default\":\"\"}}}");

/***/ }),

/***/ "./blocks/check-in-out/edit.js":
/*!*************************************!*\
  !*** ./blocks/check-in-out/edit.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _source__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./source */ "./blocks/check-in-out/source.js");
function _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }


var _JetFBComponents = JetFBComponents,
    AdvancedFields = _JetFBComponents.AdvancedFields,
    GeneralFields = _JetFBComponents.GeneralFields,
    ToolBarFields = _JetFBComponents.ToolBarFields,
    FieldWrapper = _JetFBComponents.FieldWrapper;
var _JetFBActions = JetFBActions,
    withPlaceholder = _JetFBActions.Tools.withPlaceholder;
var _wp$components = wp.components,
    TextControl = _wp$components.TextControl,
    SelectControl = _wp$components.SelectControl,
    PanelBody = _wp$components.PanelBody,
    Flex = _wp$components.Flex,
    FlexItem = _wp$components.FlexItem;
var __ = wp.i18n.__;
var _wp$blockEditor = wp.blockEditor,
    InspectorControls = _wp$blockEditor.InspectorControls,
    useBlockProps = _wp$blockEditor.useBlockProps;

function CheckInOutEdit(props) {
  var blockProps = useBlockProps();
  var attributes = props.attributes,
      setAttributes = props.setAttributes,
      isSelected = props.isSelected,
      uniqKey = props.editProps.uniqKey;
  return [wp.element.createElement(ToolBarFields, _extends({
    key: uniqKey('ToolBarFields')
  }, props)), isSelected && wp.element.createElement(InspectorControls, {
    key: uniqKey('InspectorControls')
  }, wp.element.createElement(GeneralFields, _extends({
    key: uniqKey('GeneralFields')
  }, props)), wp.element.createElement(PanelBody, {
    title: __('Field Settings'),
    key: uniqKey('PanelBody')
  }, wp.element.createElement(SelectControl, {
    label: _source__WEBPACK_IMPORTED_MODULE_0__["label"].cio_field_layout,
    labelPosition: "top",
    value: attributes.cio_field_layout,
    onChange: function onChange(cio_field_layout) {
      setAttributes({
        cio_field_layout: cio_field_layout
      });
    },
    options: withPlaceholder(_source__WEBPACK_IMPORTED_MODULE_0__["options"].cio_field_layout)
  }), wp.element.createElement(SelectControl, {
    label: _source__WEBPACK_IMPORTED_MODULE_0__["label"].cio_fields_position,
    labelPosition: "top",
    help: _source__WEBPACK_IMPORTED_MODULE_0__["help"].cio_fields_position,
    value: attributes.cio_fields_position,
    onChange: function onChange(cio_fields_position) {
      setAttributes({
        cio_fields_position: cio_fields_position
      });
    },
    options: withPlaceholder(_source__WEBPACK_IMPORTED_MODULE_0__["options"].cio_fields_position)
  }), wp.element.createElement(TextControl, {
    label: _source__WEBPACK_IMPORTED_MODULE_0__["label"].first_field_label,
    value: attributes.first_field_label,
    help: _source__WEBPACK_IMPORTED_MODULE_0__["help"].first_field_label,
    onChange: function onChange(first_field_label) {
      setAttributes({
        first_field_label: first_field_label
      });
    }
  }), wp.element.createElement(TextControl, {
    label: _source__WEBPACK_IMPORTED_MODULE_0__["label"].first_field_placeholder,
    value: attributes.first_field_placeholder,
    help: _source__WEBPACK_IMPORTED_MODULE_0__["help"].first_field_placeholder,
    onChange: function onChange(first_field_placeholder) {
      setAttributes({
        first_field_placeholder: first_field_placeholder
      });
    }
  }), wp.element.createElement(TextControl, {
    label: _source__WEBPACK_IMPORTED_MODULE_0__["label"].second_field_label,
    value: attributes.second_field_label,
    help: _source__WEBPACK_IMPORTED_MODULE_0__["help"].second_field_label,
    onChange: function onChange(second_field_label) {
      setAttributes({
        second_field_label: second_field_label
      });
    }
  }), wp.element.createElement(TextControl, {
    label: _source__WEBPACK_IMPORTED_MODULE_0__["label"].second_field_placeholder,
    value: attributes.second_field_placeholder,
    help: _source__WEBPACK_IMPORTED_MODULE_0__["help"].second_field_placeholder,
    onChange: function onChange(second_field_placeholder) {
      setAttributes({
        second_field_placeholder: second_field_placeholder
      });
    }
  }), wp.element.createElement(SelectControl, {
    label: _source__WEBPACK_IMPORTED_MODULE_0__["label"].cio_fields_format,
    help: _source__WEBPACK_IMPORTED_MODULE_0__["help"].cio_fields_format,
    labelPosition: "top",
    value: attributes.cio_fields_format,
    onChange: function onChange(cio_fields_format) {
      setAttributes({
        cio_fields_format: cio_fields_format
      });
    },
    options: withPlaceholder(_source__WEBPACK_IMPORTED_MODULE_0__["options"].cio_fields_format)
  }), wp.element.createElement(SelectControl, {
    label: _source__WEBPACK_IMPORTED_MODULE_0__["label"].cio_fields_separator,
    labelPosition: "top",
    value: attributes.cio_fields_separator,
    onChange: function onChange(cio_fields_separator) {
      setAttributes({
        cio_fields_separator: cio_fields_separator
      });
    },
    options: withPlaceholder(_source__WEBPACK_IMPORTED_MODULE_0__["options"].cio_fields_separator)
  }), wp.element.createElement(SelectControl, {
    label: _source__WEBPACK_IMPORTED_MODULE_0__["label"].start_of_week,
    labelPosition: "top",
    value: attributes.start_of_week,
    onChange: function onChange(start_of_week) {
      setAttributes({
        start_of_week: start_of_week
      });
    },
    options: withPlaceholder(_source__WEBPACK_IMPORTED_MODULE_0__["options"].start_of_week)
  })), wp.element.createElement(AdvancedFields, _extends({
    key: uniqKey('AdvancedFields')
  }, props))), wp.element.createElement("div", _extends({}, blockProps, {
    key: uniqKey('viewBlock')
  }), wp.element.createElement(FieldWrapper, _extends({
    key: uniqKey('FieldWrapper')
  }, props), 'separate' !== attributes.cio_field_layout && wp.element.createElement(TextControl, {
    placeholder: attributes.first_field_placeholder,
    key: uniqKey('place_holder_block'),
    onChange: function onChange() {}
  }), 'separate' === attributes.cio_field_layout && wp.element.createElement(React.Fragment, null, 'list' !== attributes.cio_fields_position && wp.element.createElement(Flex, {
    expanded: true
  }, wp.element.createElement(FlexItem, {
    isBlock: true,
    style: {
      flex: 1
    }
  }, wp.element.createElement(TextControl, {
    label: attributes.first_field_label,
    placeholder: attributes.first_field_placeholder,
    key: uniqKey('place_holder_block'),
    onChange: function onChange() {}
  })), wp.element.createElement(FlexItem, {
    isBlock: true,
    style: {
      flex: 1
    }
  }, wp.element.createElement(TextControl, {
    label: attributes.second_field_label,
    placeholder: attributes.second_field_placeholder,
    key: uniqKey('place_holder_block'),
    onChange: function onChange() {}
  }))), 'list' === attributes.cio_fields_position && wp.element.createElement(React.Fragment, null, wp.element.createElement(TextControl, {
    label: attributes.first_field_label,
    placeholder: attributes.first_field_placeholder,
    key: uniqKey('place_holder_block'),
    onChange: function onChange() {}
  }), wp.element.createElement(TextControl, {
    label: attributes.second_field_label,
    placeholder: attributes.second_field_placeholder,
    key: uniqKey('place_holder_block'),
    onChange: function onChange() {}
  })))))];
}

/* harmony default export */ __webpack_exports__["default"] = (CheckInOutEdit);

/***/ }),

/***/ "./blocks/check-in-out/index.js":
/*!**************************************!*\
  !*** ./blocks/check-in-out/index.js ***!
  \**************************************/
/*! exports provided: metadata, name, settings */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "name", function() { return name; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "settings", function() { return settings; });
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./edit */ "./blocks/check-in-out/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./block.json */ "./blocks/check-in-out/block.json");
var _block_json__WEBPACK_IMPORTED_MODULE_1___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./block.json */ "./blocks/check-in-out/block.json", 1);
/* harmony reexport (default from named exports) */ __webpack_require__.d(__webpack_exports__, "metadata", function() { return _block_json__WEBPACK_IMPORTED_MODULE_1__; });


var __ = wp.i18n.__;
var name = _block_json__WEBPACK_IMPORTED_MODULE_1__.name,
    icon = _block_json__WEBPACK_IMPORTED_MODULE_1__.icon;
/**
 * Available items for `useEditProps`:
 *  - uniqKey
 *  - formFields
 *  - blockName
 *  - attrHelp
 */

var settings = {
  title: __('Check-in/check-out dates'),
  icon: wp.element.createElement("span", {
    dangerouslySetInnerHTML: {
      __html: icon
    }
  }),
  edit: _edit__WEBPACK_IMPORTED_MODULE_0__["default"],
  useEditProps: ['uniqKey', 'blockName', 'attrHelp'],
  example: {
    attributes: {
      label: 'Check-in/check-out dates',
      desc: 'Field description...'
    }
  }
};


/***/ }),

/***/ "./blocks/check-in-out/source.js":
/*!***************************************!*\
  !*** ./blocks/check-in-out/source.js ***!
  \***************************************/
/*! exports provided: help, label, options */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "help", function() { return help; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "label", function() { return label; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "options", function() { return options; });
var __ = wp.i18n.__;
var label = {
  cio_field_layout: __('Layout:', 'jet-booking'),
  cio_fields_position: __('Fields position:', 'jet-booking'),
  first_field_label: __('Check In field label:', 'jet-booking'),
  first_field_placeholder: __('Placeholder:', 'jet-booking'),
  second_field_label: __('Check Out field label:', 'jet-booking'),
  second_field_placeholder: __('Check Out field placeholder:', 'jet-booking'),
  cio_fields_format: __('Date format:', 'jet-booking'),
  cio_fields_separator: __('Date field separator:', 'jet-booking'),
  start_of_week: __('First day of the week:', 'jet-booking')
};
var help = {
  cio_fields_position: __('For separate fields layout'),
  first_field_label: __("If you are using separate fields for check in and check out dates,\n\tyou need to left default \"Label\" empty and use this option for field label"),
  cio_fields_format: __("Applies only for date in the form checkin/checkout fields.\n\tFor `MM-DD-YYYY` date format use the `/` date separator")
};
var options = {
  cio_field_layout: [{
    value: 'single',
    label: __('Single field', 'jet-booking')
  }, {
    value: 'separate',
    label: __('Separate fields for check in and check out dates', 'jet-booking')
  }],
  cio_fields_position: [{
    value: 'inline',
    label: __('Inline', 'jet-booking')
  }, {
    value: 'list',
    label: __('List', 'jet-booking')
  }],
  cio_fields_format: [{
    value: 'YYYY-MM-DD',
    label: __('YYYY-MM-DD', 'jet-booking')
  }, {
    value: 'MM-DD-YYYY',
    label: __('MM-DD-YYYY', 'jet-booking')
  }, {
    value: 'DD-MM-YYYY',
    label: __('DD-MM-YYYY', 'jet-booking')
  }],
  cio_fields_separator: [{
    value: '-',
    label: '-'
  }, {
    value: '.',
    label: '.'
  }, {
    value: '/',
    label: '/'
  }, {
    value: 'space',
    label: __('Space', 'jet-booking')
  }],
  start_of_week: [{
    value: 'monday',
    label: __('Monday', 'jet-booking')
  }, {
    value: 'sunday',
    label: __('Sunday', 'jet-booking')
  }]
};


/***/ }),

/***/ "./main.js":
/*!*****************!*\
  !*** ./main.js ***!
  \*****************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _blocks_check_in_out__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./blocks/check-in-out */ "./blocks/check-in-out/index.js");
/* harmony import */ var _actions_apartment_booking__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./actions/apartment-booking */ "./actions/apartment-booking.js");
/* harmony import */ var _actions_apartment_booking__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_actions_apartment_booking__WEBPACK_IMPORTED_MODULE_1__);


var addFilter = wp.hooks.addFilter;
addFilter('jet.fb.register.fields', 'jet-form-builder', function (blocks) {
  blocks.push(_blocks_check_in_out__WEBPACK_IMPORTED_MODULE_0__);
  return blocks;
});
addFilter('jet.fb.calculated.field.available.fields', 'jet-form-builder', function (fields) {
  fields.push('%ADVANCED_PRICE::field_name%', '%META::_apartment_price%');
  return fields;
});

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnVpbGRlci5lZGl0b3IuanMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vYWN0aW9ucy9hcGFydG1lbnQtYm9va2luZy5qcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3MvY2hlY2staW4tb3V0L2VkaXQuanMiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL2NoZWNrLWluLW91dC9pbmRleC5qcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3MvY2hlY2staW4tb3V0L3NvdXJjZS5qcyIsIndlYnBhY2s6Ly8vLi9tYWluLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSBcIi4vbWFpbi5qc1wiKTtcbiIsImNvbnN0IHtcclxuXHRcdCAgU2VsZWN0Q29udHJvbCxcclxuXHRcdCAgVGV4dENvbnRyb2wsXHJcblx0XHQgIEJhc2VDb250cm9sLFxyXG5cdFx0ICBCdXR0b24sXHJcblx0XHQgIE5vdGljZSxcclxuXHQgIH0gPSB3cC5jb21wb25lbnRzO1xyXG5cclxuY29uc3Qge1xyXG5cdFx0ICB1c2VTdGF0ZSxcclxuXHRcdCAgdXNlRWZmZWN0LFxyXG5cdCAgfSA9IHdwLmVsZW1lbnQ7XHJcblxyXG5jb25zdCB7XHJcblx0XHQgIGFkZEFjdGlvbixcclxuXHRcdCAgZ2V0Rm9ybUZpZWxkc0Jsb2NrcyxcclxuXHQgIH0gPSBKZXRGQkFjdGlvbnM7XHJcblxyXG5jb25zdCB7XHJcblx0XHQgIEFjdGlvbkZpZWxkc01hcCxcclxuXHRcdCAgV3JhcHBlclJlcXVpcmVkQ29udHJvbCxcclxuXHRcdCAgUmVwZWF0ZXJXaXRoU3RhdGUsXHJcblx0XHQgIEFjdGlvbk1vZGFsLFxyXG5cdCAgfSA9IEpldEZCQ29tcG9uZW50cztcclxuXHJcbmNvbnN0IGFkZE5ld09wdGlvbiA9IHtcclxuXHR0eXBlOiAnJyxcclxuXHRsYWJlbDogJycsXHJcblx0Zm9ybWF0OiAnJyxcclxuXHRmaWVsZDogJycsXHJcblx0bGlua19sYWJlbDogJycsXHJcbn07XHJcblxyXG5hZGRBY3Rpb24oICdhcGFydG1lbnRfYm9va2luZycsIGZ1bmN0aW9uIEFwYXJ0bWVudEJvb2tpbmcoIHtcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICAgc2V0dGluZ3MsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgIHNvdXJjZSxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0ICAgbGFiZWwsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgIGhlbHAsXHJcblx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgIG9uQ2hhbmdlU2V0dGluZyxcclxuXHRcdFx0XHRcdFx0XHRcdFx0XHRcdFx0XHRcdCAgIH0gKSB7XHJcblxyXG5cdGNvbnN0IFsgZm9ybUZpZWxkc0xpc3QsIHNldEZvcm1GaWVsZHNMaXN0IF0gPSB1c2VTdGF0ZSggW10gKTtcclxuXHRjb25zdCBbIGNvbHVtbnNNYXAsIHNldENvbHVtbnNNYXAgXSA9IHVzZVN0YXRlKCBbXSApO1xyXG5cdGNvbnN0IFsgd2NGaWVsZHMsIHNldFdjRmllbGRzIF0gPSB1c2VTdGF0ZSggW10gKTtcclxuXHRjb25zdCBbIHdjRGV0YWlsc01vZGFsLCBzZXRXY0RldGFpbHNNb2RhbCBdID0gdXNlU3RhdGUoIGZhbHNlICk7XHJcblx0Y29uc3QgWyBpc0xvYWRpbmcsIHNldExvYWRpbmcgXSA9IHVzZVN0YXRlKCBmYWxzZSApO1xyXG5cclxuXHR1c2VFZmZlY3QoICgpID0+IHtcclxuXHRcdGNvbnN0IGNvbHVtbnNNYXAgPSB7fTtcclxuXHRcdHNvdXJjZS5jb2x1bW5zLmZvckVhY2goIGNvbCA9PiB7XHJcblx0XHRcdGNvbHVtbnNNYXBbIGNvbCBdID0geyBsYWJlbDogY29sIH07XHJcblx0XHR9ICk7XHJcblxyXG5cdFx0Y29uc3Qgd2NDb2x1bW5zTWFwID0ge307XHJcblx0XHRzb3VyY2Uud2NfZmllbGRzLmZvckVhY2goIGNvbCA9PiB7XHJcblx0XHRcdHdjQ29sdW1uc01hcFsgY29sIF0gPSB7IGxhYmVsOiBjb2wgfTtcclxuXHRcdH0gKTtcclxuXHJcblx0XHRzZXRDb2x1bW5zTWFwKCBPYmplY3QuZW50cmllcyggY29sdW1uc01hcCApICk7XHJcblx0XHRzZXRXY0ZpZWxkcyggT2JqZWN0LmVudHJpZXMoIHdjQ29sdW1uc01hcCApICk7XHJcblx0XHRzZXRGb3JtRmllbGRzTGlzdCggZ2V0Rm9ybUZpZWxkc0Jsb2NrcyggW10sICctLScgKSApO1xyXG5cdH0sIFtdICk7XHJcblxyXG5cdGZ1bmN0aW9uIHNhdmVXQ0RldGFpbHMoIGl0ZW1zICkge1xyXG5cdFx0c2V0TG9hZGluZyggdHJ1ZSApO1xyXG5cclxuXHRcdGpRdWVyeS5hamF4KCB7XHJcblx0XHRcdHVybDogd2luZG93LmFqYXh1cmwsXHJcblx0XHRcdHR5cGU6ICdQT1NUJyxcclxuXHRcdFx0ZGF0YVR5cGU6ICdqc29uJyxcclxuXHRcdFx0ZGF0YToge1xyXG5cdFx0XHRcdGFjdGlvbjogJ2pldF9ib29raW5nX3NhdmVfd2NfZGV0YWlscycsXHJcblx0XHRcdFx0cG9zdF9pZDogc291cmNlLmFwYXJ0bWVudCxcclxuXHRcdFx0XHRub25jZTogc291cmNlLm5vbmNlLFxyXG5cdFx0XHRcdGRldGFpbHM6IGl0ZW1zLFxyXG5cdFx0XHR9LFxyXG5cdFx0fSApLmRvbmUoIGZ1bmN0aW9uKCByZXNwb25zZSApIHtcclxuXHRcdFx0c2V0TG9hZGluZyggZmFsc2UgKTtcclxuXHJcblx0XHRcdGlmICggISByZXNwb25zZS5zdWNjZXNzICkge1xyXG5cdFx0XHRcdGFsZXJ0KCByZXNwb25zZS5kYXRhLm1lc3NhZ2UgKTtcclxuXHRcdFx0fSBlbHNlIHtcclxuXHRcdFx0XHRKZXRCb29raW5nQWN0aW9uRGF0YS5kZXRhaWxzID0gaXRlbXM7XHJcblx0XHRcdFx0c2V0V2NEZXRhaWxzTW9kYWwoIGZhbHNlICk7XHJcblx0XHRcdH1cclxuXHJcblx0XHR9ICkuZmFpbCggZnVuY3Rpb24oIGpxWEhSLCB0ZXh0U3RhdHVzLCBlcnJvclRocm93biApIHtcclxuXHRcdFx0c2V0TG9hZGluZyggZmFsc2UgKTtcclxuXHRcdFx0YWxlcnQoIGVycm9yVGhyb3duICk7XHJcblx0XHR9ICk7XHJcblx0fVxyXG5cclxuXHRyZXR1cm4gPD5cclxuXHRcdDxTZWxlY3RDb250cm9sXHJcblx0XHRcdGxhYmVsPXsgbGFiZWwoICdib29raW5nX2FwYXJ0bWVudF9maWVsZCcgKSB9XHJcblx0XHRcdGxhYmVsUG9zaXRpb249J3NpZGUnXHJcblx0XHRcdHZhbHVlPXsgc2V0dGluZ3MuYm9va2luZ19hcGFydG1lbnRfZmllbGQgfVxyXG5cdFx0XHRvbkNoYW5nZT17IHZhbCA9PiBvbkNoYW5nZVNldHRpbmcoIHZhbCwgJ2Jvb2tpbmdfYXBhcnRtZW50X2ZpZWxkJyApIH1cclxuXHRcdFx0b3B0aW9ucz17IGZvcm1GaWVsZHNMaXN0IH1cclxuXHRcdC8+XHJcblx0XHQ8U2VsZWN0Q29udHJvbFxyXG5cdFx0XHRsYWJlbD17IGxhYmVsKCAnYm9va2luZ19kYXRlc19maWVsZCcgKSB9XHJcblx0XHRcdGxhYmVsUG9zaXRpb249J3NpZGUnXHJcblx0XHRcdHZhbHVlPXsgc2V0dGluZ3MuYm9va2luZ19kYXRlc19maWVsZCB9XHJcblx0XHRcdG9uQ2hhbmdlPXsgdmFsID0+IG9uQ2hhbmdlU2V0dGluZyggdmFsLCAnYm9va2luZ19kYXRlc19maWVsZCcgKSB9XHJcblx0XHRcdG9wdGlvbnM9eyBmb3JtRmllbGRzTGlzdCB9XHJcblx0XHQvPlxyXG5cdFx0PEFjdGlvbkZpZWxkc01hcFxyXG5cdFx0XHRsYWJlbD17IGxhYmVsKCAnZGJfY29sdW1uc19tYXAnICkgfVxyXG5cdFx0XHRmaWVsZHM9eyBjb2x1bW5zTWFwIH1cclxuXHRcdFx0cGxhaW5IZWxwPXsgaGVscCggJ2RiX2NvbHVtbnNfbWFwJyApIH1cclxuXHRcdD5cclxuXHRcdFx0eyAoIHsgZmllbGRJZCwgZmllbGREYXRhLCBpbmRleCB9ICkgPT4gPFdyYXBwZXJSZXF1aXJlZENvbnRyb2xcclxuXHRcdFx0XHRmaWVsZD17IFsgZmllbGRJZCwgZmllbGREYXRhIF0gfVxyXG5cdFx0XHQ+XHJcblx0XHRcdFx0PFRleHRDb250cm9sXHJcblx0XHRcdFx0XHRrZXk9eyBmaWVsZElkICsgaW5kZXggfVxyXG5cdFx0XHRcdFx0dmFsdWU9eyBzZXR0aW5nc1sgYGRiX2NvbHVtbnNfbWFwXyR7IGZpZWxkSWQgfWAgXSB9XHJcblx0XHRcdFx0XHRvbkNoYW5nZT17IHZhbCA9PiBvbkNoYW5nZVNldHRpbmcoIHZhbCwgYGRiX2NvbHVtbnNfbWFwXyR7IGZpZWxkSWQgfWAgKSB9XHJcblx0XHRcdFx0Lz5cclxuXHRcdFx0PC9XcmFwcGVyUmVxdWlyZWRDb250cm9sPiB9XHJcblx0XHQ8L0FjdGlvbkZpZWxkc01hcD5cclxuXHRcdHsgQm9vbGVhbiggc291cmNlLndjX2ludGVncmF0aW9uICkgJiYgPD5cclxuXHRcdFx0PFNlbGVjdENvbnRyb2xcclxuXHRcdFx0XHRsYWJlbD17IGxhYmVsKCAnYm9va2luZ193Y19wcmljZScgKSB9XHJcblx0XHRcdFx0aGVscD17IGhlbHAoICdib29raW5nX3djX3ByaWNlJyApIH1cclxuXHRcdFx0XHRsYWJlbFBvc2l0aW9uPSdzaWRlJ1xyXG5cdFx0XHRcdHZhbHVlPXsgc2V0dGluZ3MuYm9va2luZ193Y19wcmljZSB9XHJcblx0XHRcdFx0b25DaGFuZ2U9eyB2YWwgPT4gb25DaGFuZ2VTZXR0aW5nKCB2YWwsICdib29raW5nX3djX3ByaWNlJyApIH1cclxuXHRcdFx0XHRvcHRpb25zPXsgZm9ybUZpZWxkc0xpc3QgfVxyXG5cdFx0XHQvPlxyXG5cdFx0XHQ8QmFzZUNvbnRyb2xcclxuXHRcdFx0XHRsYWJlbD17IGxhYmVsKCAnd2Nfb3JkZXJfZGV0YWlscycgKSB9XHJcblx0XHRcdFx0aGVscD17IGhlbHAoICd3Y19vcmRlcl9kZXRhaWxzJyApIH1cclxuXHRcdFx0PlxyXG5cdFx0XHRcdDxCdXR0b25cclxuXHRcdFx0XHRcdGlzU2Vjb25kYXJ5XHJcblx0XHRcdFx0XHRvbkNsaWNrPXsgKCkgPT4gc2V0V2NEZXRhaWxzTW9kYWwoIHRydWUgKSB9XHJcblx0XHRcdFx0PnsgJ1NldCB1cCcgfTwvQnV0dG9uPlxyXG5cdFx0XHQ8L0Jhc2VDb250cm9sPlxyXG5cdFx0XHQ8QWN0aW9uRmllbGRzTWFwXHJcblx0XHRcdFx0bGFiZWw9eyBsYWJlbCggJ3djX2ZpZWxkc19tYXAnICkgfVxyXG5cdFx0XHRcdGZpZWxkcz17IHdjRmllbGRzIH1cclxuXHRcdFx0XHRwbGFpbkhlbHA9eyBoZWxwKCAnd2NfZmllbGRzX21hcCcgKSB9XHJcblx0XHRcdD5cclxuXHRcdFx0XHR7ICggeyBmaWVsZElkLCBmaWVsZERhdGEsIGluZGV4IH0gKSA9PiA8V3JhcHBlclJlcXVpcmVkQ29udHJvbFxyXG5cdFx0XHRcdFx0ZmllbGQ9eyBbIGZpZWxkSWQsIGZpZWxkRGF0YSBdIH1cclxuXHRcdFx0XHQ+XHJcblx0XHRcdFx0XHQ8U2VsZWN0Q29udHJvbFxyXG5cdFx0XHRcdFx0XHRrZXk9eyBmaWVsZElkICsgaW5kZXggfVxyXG5cdFx0XHRcdFx0XHRsYWJlbFBvc2l0aW9uPSdzaWRlJ1xyXG5cdFx0XHRcdFx0XHR2YWx1ZT17IHNldHRpbmdzWyBgd2NfZmllbGRzX21hcF9fJHsgZmllbGRJZCB9YCBdIH1cclxuXHRcdFx0XHRcdFx0b25DaGFuZ2U9eyB2YWwgPT4gb25DaGFuZ2VTZXR0aW5nKCB2YWwsIGB3Y19maWVsZHNfbWFwX18keyBmaWVsZElkIH1gICkgfVxyXG5cdFx0XHRcdFx0XHRvcHRpb25zPXsgZm9ybUZpZWxkc0xpc3QgfVxyXG5cdFx0XHRcdFx0Lz5cclxuXHRcdFx0XHQ8L1dyYXBwZXJSZXF1aXJlZENvbnRyb2w+IH1cclxuXHRcdFx0PC9BY3Rpb25GaWVsZHNNYXA+XHJcblx0XHRcdHsgd2NEZXRhaWxzTW9kYWwgJiYgPEFjdGlvbk1vZGFsXHJcblx0XHRcdFx0dGl0bGU9eyAnU2V0IHVwIFdvb0NvbW1lcmNlIG9yZGVyIGRldGFpbHMnIH1cclxuXHRcdFx0XHRvblJlcXVlc3RDbG9zZT17ICgpID0+IHNldFdjRGV0YWlsc01vZGFsKCBmYWxzZSApIH1cclxuXHRcdFx0XHRjbGFzc05hbWVzPXsgWyAnd2lkdGgtNjAnIF0gfVxyXG5cdFx0XHRcdHN0eWxlPXsgeyBvcGFjaXR5OiBpc0xvYWRpbmcgPyAnMC41JyA6ICcxJyB9IH1cclxuXHRcdFx0XHR1cGRhdGVCdG5Qcm9wcz17IHsgaXNCdXN5OiBpc0xvYWRpbmcgfSB9XHJcblx0XHRcdD5cclxuXHRcdFx0XHR7ICggeyBhY3Rpb25DbGljaywgb25SZXF1ZXN0Q2xvc2UgfSApID0+IDxSZXBlYXRlcldpdGhTdGF0ZVxyXG5cdFx0XHRcdFx0aXRlbXM9eyBzb3VyY2UuZGV0YWlscyB9XHJcblx0XHRcdFx0XHRvblNhdmVJdGVtcz17IHNhdmVXQ0RldGFpbHMgfVxyXG5cdFx0XHRcdFx0bmV3SXRlbT17IGFkZE5ld09wdGlvbiB9XHJcblx0XHRcdFx0XHRvblVuTW91bnQ9eyAoKSA9PiB7XHJcblx0XHRcdFx0XHRcdGlmICggISBhY3Rpb25DbGljayApIHtcclxuXHRcdFx0XHRcdFx0XHRvblJlcXVlc3RDbG9zZSgpO1xyXG5cdFx0XHRcdFx0XHR9XHJcblx0XHRcdFx0XHR9IH1cclxuXHRcdFx0XHRcdGlzU2F2ZUFjdGlvbj17IGFjdGlvbkNsaWNrIH1cclxuXHRcdFx0XHRcdGFkZE5ld0J1dHRvbkxhYmVsPXsgaXNMb2FkaW5nID8gJ1NhdmluZy4uLicgOiAnQWRkIG5ldyBpdGVtICsnIH1cclxuXHRcdFx0XHQ+XHJcblx0XHRcdFx0XHR7ICggeyBjdXJyZW50SXRlbSwgY2hhbmdlQ3VycmVudEl0ZW0gfSApID0+IHtcclxuXHRcdFx0XHRcdFx0cmV0dXJuIDw+XHJcblx0XHRcdFx0XHRcdFx0PFNlbGVjdENvbnRyb2xcclxuXHRcdFx0XHRcdFx0XHRcdGxhYmVsPXsgbGFiZWwoICd3Y19kZXRhaWxzX190eXBlJyApIH1cclxuXHRcdFx0XHRcdFx0XHRcdGxhYmVsUG9zaXRpb249J3NpZGUnXHJcblx0XHRcdFx0XHRcdFx0XHR2YWx1ZT17IGN1cnJlbnRJdGVtLnR5cGUgfVxyXG5cdFx0XHRcdFx0XHRcdFx0b25DaGFuZ2U9eyB0eXBlID0+IGNoYW5nZUN1cnJlbnRJdGVtKCB7IHR5cGUgfSApIH1cclxuXHRcdFx0XHRcdFx0XHRcdG9wdGlvbnM9eyBzb3VyY2UuZGV0YWlsc190eXBlcyB9XHJcblx0XHRcdFx0XHRcdFx0Lz5cclxuXHRcdFx0XHRcdFx0XHQ8VGV4dENvbnRyb2xcclxuXHRcdFx0XHRcdFx0XHRcdGxhYmVsPXsgbGFiZWwoICd3Y19kZXRhaWxzX19sYWJlbCcgKSB9XHJcblx0XHRcdFx0XHRcdFx0XHR2YWx1ZT17IGN1cnJlbnRJdGVtLmxhYmVsIH1cclxuXHRcdFx0XHRcdFx0XHRcdG9uQ2hhbmdlPXsgbGFiZWwgPT4gY2hhbmdlQ3VycmVudEl0ZW0oIHsgbGFiZWwgfSApIH1cclxuXHRcdFx0XHRcdFx0XHQvPlxyXG5cdFx0XHRcdFx0XHRcdHsgWyAnY2hlY2staW4nLCAnY2hlY2stb3V0JyBdLmluY2x1ZGVzKCBjdXJyZW50SXRlbS50eXBlICkgJiYgPD5cclxuXHRcdFx0XHRcdFx0XHRcdDxUZXh0Q29udHJvbFxyXG5cdFx0XHRcdFx0XHRcdFx0XHRsYWJlbD17IGxhYmVsKCAnd2NfZGV0YWlsc19fZm9ybWF0JyApIH1cclxuXHRcdFx0XHRcdFx0XHRcdFx0dmFsdWU9eyBjdXJyZW50SXRlbS5mb3JtYXQgfVxyXG5cdFx0XHRcdFx0XHRcdFx0XHRvbkNoYW5nZT17IGZvcm1hdCA9PiBjaGFuZ2VDdXJyZW50SXRlbSggeyBmb3JtYXQgfSApIH1cclxuXHRcdFx0XHRcdFx0XHRcdC8+XHJcblx0XHRcdFx0XHRcdFx0XHQ8YSBocmVmPVwiaHR0cHM6Ly9jb2RleC53b3JkcHJlc3Mub3JnL0Zvcm1hdHRpbmdfRGF0ZV9hbmRfVGltZVwiIHRhcmdldD1cIl9ibGFua1wiPlxyXG5cdFx0XHRcdFx0XHRcdFx0XHRGb3JtYXR0aW5nIGRvY3NcclxuXHRcdFx0XHRcdFx0XHRcdDwvYT5cclxuXHRcdFx0XHRcdFx0XHQ8Lz4gfVxyXG5cdFx0XHRcdFx0XHRcdHsgJ2ZpZWxkJyA9PT0gY3VycmVudEl0ZW0udHlwZSAmJiA8U2VsZWN0Q29udHJvbFxyXG5cdFx0XHRcdFx0XHRcdFx0bGFiZWw9eyBsYWJlbCggJ3djX2RldGFpbHNfX2ZpZWxkJyApIH1cclxuXHRcdFx0XHRcdFx0XHRcdGxhYmVsUG9zaXRpb249J3NpZGUnXHJcblx0XHRcdFx0XHRcdFx0XHR2YWx1ZT17IGN1cnJlbnRJdGVtLmZpZWxkIH1cclxuXHRcdFx0XHRcdFx0XHRcdG9uQ2hhbmdlPXsgZmllbGQgPT4gY2hhbmdlQ3VycmVudEl0ZW0oIHsgZmllbGQgfSApIH1cclxuXHRcdFx0XHRcdFx0XHRcdG9wdGlvbnM9eyBmb3JtRmllbGRzTGlzdCB9XHJcblx0XHRcdFx0XHRcdFx0Lz4gfVxyXG5cdFx0XHRcdFx0XHRcdHsgJ2FkZF90b19jYWxlbmRhcicgPT09IGN1cnJlbnRJdGVtLnR5cGUgJiYgPFRleHRDb250cm9sXHJcblx0XHRcdFx0XHRcdFx0XHRsYWJlbD17IGxhYmVsKCAnd2NfZGV0YWlsc19fbGlua19sYWJlbCcgKSB9XHJcblx0XHRcdFx0XHRcdFx0XHR2YWx1ZT17IGN1cnJlbnRJdGVtLmxpbmtfbGFiZWwgfVxyXG5cdFx0XHRcdFx0XHRcdFx0b25DaGFuZ2U9eyBsaW5rX2xhYmVsID0+IGNoYW5nZUN1cnJlbnRJdGVtKCB7IGxpbmtfbGFiZWwgfSApIH1cclxuXHRcdFx0XHRcdFx0XHQvPiB9XHJcblx0XHRcdFx0XHRcdDwvPjtcclxuXHRcdFx0XHRcdH0gfVxyXG5cdFx0XHRcdDwvUmVwZWF0ZXJXaXRoU3RhdGU+IH1cclxuXHRcdFx0PC9BY3Rpb25Nb2RhbD4gfVxyXG5cdFx0PC8+IH1cclxuXHQ8Lz47XHJcbn0gKTsiLCJpbXBvcnQge1xyXG5cdGhlbHAsXHJcblx0bGFiZWwsXHJcblx0b3B0aW9ucyxcclxufSBmcm9tICcuL3NvdXJjZSc7XHJcblxyXG5jb25zdCB7XHJcblx0XHQgIEFkdmFuY2VkRmllbGRzLFxyXG5cdFx0ICBHZW5lcmFsRmllbGRzLFxyXG5cdFx0ICBUb29sQmFyRmllbGRzLFxyXG5cdFx0ICBGaWVsZFdyYXBwZXIsXHJcblx0ICB9ID0gSmV0RkJDb21wb25lbnRzO1xyXG5cclxuY29uc3Qge1xyXG5cdFx0ICBUb29sczogeyB3aXRoUGxhY2Vob2xkZXIgfSxcclxuXHQgIH0gPSBKZXRGQkFjdGlvbnM7XHJcblxyXG5jb25zdCB7XHJcblx0XHQgIFRleHRDb250cm9sLFxyXG5cdFx0ICBTZWxlY3RDb250cm9sLFxyXG5cdFx0ICBQYW5lbEJvZHksXHJcblx0XHQgIEZsZXgsXHJcblx0XHQgIEZsZXhJdGVtLFxyXG5cdCAgfSA9IHdwLmNvbXBvbmVudHM7XHJcbmNvbnN0IHsgX18gfSA9IHdwLmkxOG47XHJcblxyXG5jb25zdCB7XHJcblx0XHQgIEluc3BlY3RvckNvbnRyb2xzLFxyXG5cdFx0ICB1c2VCbG9ja1Byb3BzLFxyXG5cdCAgfSA9IHdwLmJsb2NrRWRpdG9yO1xyXG5cclxuZnVuY3Rpb24gQ2hlY2tJbk91dEVkaXQoIHByb3BzICkge1xyXG5cdGNvbnN0IGJsb2NrUHJvcHMgPSB1c2VCbG9ja1Byb3BzKCk7XHJcblxyXG5cdGNvbnN0IHtcclxuXHRcdFx0ICBhdHRyaWJ1dGVzLFxyXG5cdFx0XHQgIHNldEF0dHJpYnV0ZXMsXHJcblx0XHRcdCAgaXNTZWxlY3RlZCxcclxuXHRcdFx0ICBlZGl0UHJvcHM6IHsgdW5pcUtleSB9LFxyXG5cdFx0ICB9ID0gcHJvcHM7XHJcblxyXG5cdHJldHVybiBbXHJcblx0XHQ8VG9vbEJhckZpZWxkc1xyXG5cdFx0XHRrZXk9eyB1bmlxS2V5KCAnVG9vbEJhckZpZWxkcycgKSB9XHJcblx0XHRcdHsgLi4ucHJvcHMgfVxyXG5cdFx0Lz4sXHJcblx0XHRpc1NlbGVjdGVkICYmIDxJbnNwZWN0b3JDb250cm9sc1xyXG5cdFx0XHRrZXk9eyB1bmlxS2V5KCAnSW5zcGVjdG9yQ29udHJvbHMnICkgfVxyXG5cdFx0PlxyXG5cdFx0XHQ8R2VuZXJhbEZpZWxkc1xyXG5cdFx0XHRcdGtleT17IHVuaXFLZXkoICdHZW5lcmFsRmllbGRzJyApIH1cclxuXHRcdFx0XHR7IC4uLnByb3BzIH1cclxuXHRcdFx0Lz5cclxuXHRcdFx0PFBhbmVsQm9keVxyXG5cdFx0XHRcdHRpdGxlPXsgX18oICdGaWVsZCBTZXR0aW5ncycgKSB9XHJcblx0XHRcdFx0a2V5PXsgdW5pcUtleSggJ1BhbmVsQm9keScgKSB9XHJcblx0XHRcdD5cclxuXHRcdFx0XHQ8U2VsZWN0Q29udHJvbFxyXG5cdFx0XHRcdFx0bGFiZWw9eyBsYWJlbC5jaW9fZmllbGRfbGF5b3V0IH1cclxuXHRcdFx0XHRcdGxhYmVsUG9zaXRpb249J3RvcCdcclxuXHRcdFx0XHRcdHZhbHVlPXsgYXR0cmlidXRlcy5jaW9fZmllbGRfbGF5b3V0IH1cclxuXHRcdFx0XHRcdG9uQ2hhbmdlPXsgY2lvX2ZpZWxkX2xheW91dCA9PiB7XHJcblx0XHRcdFx0XHRcdHNldEF0dHJpYnV0ZXMoIHsgY2lvX2ZpZWxkX2xheW91dCB9ICk7XHJcblx0XHRcdFx0XHR9IH1cclxuXHRcdFx0XHRcdG9wdGlvbnM9eyB3aXRoUGxhY2Vob2xkZXIoIG9wdGlvbnMuY2lvX2ZpZWxkX2xheW91dCApIH1cclxuXHRcdFx0XHQvPlxyXG5cdFx0XHRcdDxTZWxlY3RDb250cm9sXHJcblx0XHRcdFx0XHRsYWJlbD17IGxhYmVsLmNpb19maWVsZHNfcG9zaXRpb24gfVxyXG5cdFx0XHRcdFx0bGFiZWxQb3NpdGlvbj0ndG9wJ1xyXG5cdFx0XHRcdFx0aGVscD17IGhlbHAuY2lvX2ZpZWxkc19wb3NpdGlvbiB9XHJcblx0XHRcdFx0XHR2YWx1ZT17IGF0dHJpYnV0ZXMuY2lvX2ZpZWxkc19wb3NpdGlvbiB9XHJcblx0XHRcdFx0XHRvbkNoYW5nZT17IGNpb19maWVsZHNfcG9zaXRpb24gPT4ge1xyXG5cdFx0XHRcdFx0XHRzZXRBdHRyaWJ1dGVzKCB7IGNpb19maWVsZHNfcG9zaXRpb24gfSApO1xyXG5cdFx0XHRcdFx0fSB9XHJcblx0XHRcdFx0XHRvcHRpb25zPXsgd2l0aFBsYWNlaG9sZGVyKCBvcHRpb25zLmNpb19maWVsZHNfcG9zaXRpb24gKSB9XHJcblx0XHRcdFx0Lz5cclxuXHRcdFx0XHQ8VGV4dENvbnRyb2xcclxuXHRcdFx0XHRcdGxhYmVsPXsgbGFiZWwuZmlyc3RfZmllbGRfbGFiZWwgfVxyXG5cdFx0XHRcdFx0dmFsdWU9eyBhdHRyaWJ1dGVzLmZpcnN0X2ZpZWxkX2xhYmVsIH1cclxuXHRcdFx0XHRcdGhlbHA9eyBoZWxwLmZpcnN0X2ZpZWxkX2xhYmVsIH1cclxuXHRcdFx0XHRcdG9uQ2hhbmdlPXsgZmlyc3RfZmllbGRfbGFiZWwgPT4ge1xyXG5cdFx0XHRcdFx0XHRzZXRBdHRyaWJ1dGVzKCB7IGZpcnN0X2ZpZWxkX2xhYmVsIH0gKTtcclxuXHRcdFx0XHRcdH0gfVxyXG5cdFx0XHRcdC8+XHJcblx0XHRcdFx0PFRleHRDb250cm9sXHJcblx0XHRcdFx0XHRsYWJlbD17IGxhYmVsLmZpcnN0X2ZpZWxkX3BsYWNlaG9sZGVyIH1cclxuXHRcdFx0XHRcdHZhbHVlPXsgYXR0cmlidXRlcy5maXJzdF9maWVsZF9wbGFjZWhvbGRlciB9XHJcblx0XHRcdFx0XHRoZWxwPXsgaGVscC5maXJzdF9maWVsZF9wbGFjZWhvbGRlciB9XHJcblx0XHRcdFx0XHRvbkNoYW5nZT17IGZpcnN0X2ZpZWxkX3BsYWNlaG9sZGVyID0+IHtcclxuXHRcdFx0XHRcdFx0c2V0QXR0cmlidXRlcyggeyBmaXJzdF9maWVsZF9wbGFjZWhvbGRlciB9ICk7XHJcblx0XHRcdFx0XHR9IH1cclxuXHRcdFx0XHQvPlxyXG5cdFx0XHRcdDxUZXh0Q29udHJvbFxyXG5cdFx0XHRcdFx0bGFiZWw9eyBsYWJlbC5zZWNvbmRfZmllbGRfbGFiZWwgfVxyXG5cdFx0XHRcdFx0dmFsdWU9eyBhdHRyaWJ1dGVzLnNlY29uZF9maWVsZF9sYWJlbCB9XHJcblx0XHRcdFx0XHRoZWxwPXsgaGVscC5zZWNvbmRfZmllbGRfbGFiZWwgfVxyXG5cdFx0XHRcdFx0b25DaGFuZ2U9eyBzZWNvbmRfZmllbGRfbGFiZWwgPT4ge1xyXG5cdFx0XHRcdFx0XHRzZXRBdHRyaWJ1dGVzKCB7IHNlY29uZF9maWVsZF9sYWJlbCB9ICk7XHJcblx0XHRcdFx0XHR9IH1cclxuXHRcdFx0XHQvPlxyXG5cdFx0XHRcdDxUZXh0Q29udHJvbFxyXG5cdFx0XHRcdFx0bGFiZWw9eyBsYWJlbC5zZWNvbmRfZmllbGRfcGxhY2Vob2xkZXIgfVxyXG5cdFx0XHRcdFx0dmFsdWU9eyBhdHRyaWJ1dGVzLnNlY29uZF9maWVsZF9wbGFjZWhvbGRlciB9XHJcblx0XHRcdFx0XHRoZWxwPXsgaGVscC5zZWNvbmRfZmllbGRfcGxhY2Vob2xkZXIgfVxyXG5cdFx0XHRcdFx0b25DaGFuZ2U9eyBzZWNvbmRfZmllbGRfcGxhY2Vob2xkZXIgPT4ge1xyXG5cdFx0XHRcdFx0XHRzZXRBdHRyaWJ1dGVzKCB7IHNlY29uZF9maWVsZF9wbGFjZWhvbGRlciB9ICk7XHJcblx0XHRcdFx0XHR9IH1cclxuXHRcdFx0XHQvPlxyXG5cdFx0XHRcdDxTZWxlY3RDb250cm9sXHJcblx0XHRcdFx0XHRsYWJlbD17IGxhYmVsLmNpb19maWVsZHNfZm9ybWF0IH1cclxuXHRcdFx0XHRcdGhlbHA9eyBoZWxwLmNpb19maWVsZHNfZm9ybWF0IH1cclxuXHRcdFx0XHRcdGxhYmVsUG9zaXRpb249J3RvcCdcclxuXHRcdFx0XHRcdHZhbHVlPXsgYXR0cmlidXRlcy5jaW9fZmllbGRzX2Zvcm1hdCB9XHJcblx0XHRcdFx0XHRvbkNoYW5nZT17IGNpb19maWVsZHNfZm9ybWF0ID0+IHtcclxuXHRcdFx0XHRcdFx0c2V0QXR0cmlidXRlcyggeyBjaW9fZmllbGRzX2Zvcm1hdCB9ICk7XHJcblx0XHRcdFx0XHR9IH1cclxuXHRcdFx0XHRcdG9wdGlvbnM9eyB3aXRoUGxhY2Vob2xkZXIoIG9wdGlvbnMuY2lvX2ZpZWxkc19mb3JtYXQgKSB9XHJcblx0XHRcdFx0Lz5cclxuXHRcdFx0XHQ8U2VsZWN0Q29udHJvbFxyXG5cdFx0XHRcdFx0bGFiZWw9eyBsYWJlbC5jaW9fZmllbGRzX3NlcGFyYXRvciB9XHJcblx0XHRcdFx0XHRsYWJlbFBvc2l0aW9uPSd0b3AnXHJcblx0XHRcdFx0XHR2YWx1ZT17IGF0dHJpYnV0ZXMuY2lvX2ZpZWxkc19zZXBhcmF0b3IgfVxyXG5cdFx0XHRcdFx0b25DaGFuZ2U9eyBjaW9fZmllbGRzX3NlcGFyYXRvciA9PiB7XHJcblx0XHRcdFx0XHRcdHNldEF0dHJpYnV0ZXMoIHsgY2lvX2ZpZWxkc19zZXBhcmF0b3IgfSApO1xyXG5cdFx0XHRcdFx0fSB9XHJcblx0XHRcdFx0XHRvcHRpb25zPXsgd2l0aFBsYWNlaG9sZGVyKCBvcHRpb25zLmNpb19maWVsZHNfc2VwYXJhdG9yICkgfVxyXG5cdFx0XHRcdC8+XHJcblx0XHRcdFx0PFNlbGVjdENvbnRyb2xcclxuXHRcdFx0XHRcdGxhYmVsPXsgbGFiZWwuc3RhcnRfb2Zfd2VlayB9XHJcblx0XHRcdFx0XHRsYWJlbFBvc2l0aW9uPSd0b3AnXHJcblx0XHRcdFx0XHR2YWx1ZT17IGF0dHJpYnV0ZXMuc3RhcnRfb2Zfd2VlayB9XHJcblx0XHRcdFx0XHRvbkNoYW5nZT17IHN0YXJ0X29mX3dlZWsgPT4ge1xyXG5cdFx0XHRcdFx0XHRzZXRBdHRyaWJ1dGVzKCB7IHN0YXJ0X29mX3dlZWsgfSApO1xyXG5cdFx0XHRcdFx0fSB9XHJcblx0XHRcdFx0XHRvcHRpb25zPXsgd2l0aFBsYWNlaG9sZGVyKCBvcHRpb25zLnN0YXJ0X29mX3dlZWsgKSB9XHJcblx0XHRcdFx0Lz5cclxuXHRcdFx0PC9QYW5lbEJvZHk+XHJcblx0XHRcdDxBZHZhbmNlZEZpZWxkc1xyXG5cdFx0XHRcdGtleT17IHVuaXFLZXkoICdBZHZhbmNlZEZpZWxkcycgKSB9XHJcblx0XHRcdFx0eyAuLi5wcm9wcyB9XHJcblx0XHRcdC8+XHJcblx0XHQ8L0luc3BlY3RvckNvbnRyb2xzPixcclxuXHRcdDxkaXYgeyAuLi5ibG9ja1Byb3BzIH0ga2V5PXsgdW5pcUtleSggJ3ZpZXdCbG9jaycgKSB9PlxyXG5cdFx0XHQ8RmllbGRXcmFwcGVyXHJcblx0XHRcdFx0a2V5PXsgdW5pcUtleSggJ0ZpZWxkV3JhcHBlcicgKSB9XHJcblx0XHRcdFx0eyAuLi5wcm9wcyB9XHJcblx0XHRcdD5cclxuXHRcdFx0XHR7ICdzZXBhcmF0ZScgIT09IGF0dHJpYnV0ZXMuY2lvX2ZpZWxkX2xheW91dCAmJiA8VGV4dENvbnRyb2xcclxuXHRcdFx0XHRcdHBsYWNlaG9sZGVyPXsgYXR0cmlidXRlcy5maXJzdF9maWVsZF9wbGFjZWhvbGRlciB9XHJcblx0XHRcdFx0XHRrZXk9eyB1bmlxS2V5KCAncGxhY2VfaG9sZGVyX2Jsb2NrJyApIH1cclxuXHRcdFx0XHRcdG9uQ2hhbmdlPXsgKCkgPT4ge1xyXG5cdFx0XHRcdFx0fSB9XHJcblx0XHRcdFx0Lz4gfVxyXG5cdFx0XHRcdHsgJ3NlcGFyYXRlJyA9PT0gYXR0cmlidXRlcy5jaW9fZmllbGRfbGF5b3V0ICYmIDw+XHJcblx0XHRcdFx0XHR7ICdsaXN0JyAhPT0gYXR0cmlidXRlcy5jaW9fZmllbGRzX3Bvc2l0aW9uICYmIDxGbGV4IGV4cGFuZGVkPlxyXG5cdFx0XHRcdFx0XHQ8RmxleEl0ZW0gaXNCbG9jayBzdHlsZT17IHsgZmxleDogMSB9IH0+XHJcblx0XHRcdFx0XHRcdFx0PFRleHRDb250cm9sXHJcblx0XHRcdFx0XHRcdFx0XHRsYWJlbD17IGF0dHJpYnV0ZXMuZmlyc3RfZmllbGRfbGFiZWwgfVxyXG5cdFx0XHRcdFx0XHRcdFx0cGxhY2Vob2xkZXI9eyBhdHRyaWJ1dGVzLmZpcnN0X2ZpZWxkX3BsYWNlaG9sZGVyIH1cclxuXHRcdFx0XHRcdFx0XHRcdGtleT17IHVuaXFLZXkoICdwbGFjZV9ob2xkZXJfYmxvY2snICkgfVxyXG5cdFx0XHRcdFx0XHRcdFx0b25DaGFuZ2U9eyAoKSA9PiB7XHJcblx0XHRcdFx0XHRcdFx0XHR9IH1cclxuXHRcdFx0XHRcdFx0XHQvPlxyXG5cdFx0XHRcdFx0XHQ8L0ZsZXhJdGVtPlxyXG5cdFx0XHRcdFx0XHQ8RmxleEl0ZW0gaXNCbG9jayBzdHlsZT17IHsgZmxleDogMSB9IH0+XHJcblx0XHRcdFx0XHRcdFx0PFRleHRDb250cm9sXHJcblx0XHRcdFx0XHRcdFx0XHRsYWJlbD17IGF0dHJpYnV0ZXMuc2Vjb25kX2ZpZWxkX2xhYmVsIH1cclxuXHRcdFx0XHRcdFx0XHRcdHBsYWNlaG9sZGVyPXsgYXR0cmlidXRlcy5zZWNvbmRfZmllbGRfcGxhY2Vob2xkZXIgfVxyXG5cdFx0XHRcdFx0XHRcdFx0a2V5PXsgdW5pcUtleSggJ3BsYWNlX2hvbGRlcl9ibG9jaycgKSB9XHJcblx0XHRcdFx0XHRcdFx0XHRvbkNoYW5nZT17ICgpID0+IHtcclxuXHRcdFx0XHRcdFx0XHRcdH0gfVxyXG5cdFx0XHRcdFx0XHRcdC8+XHJcblx0XHRcdFx0XHRcdDwvRmxleEl0ZW0+XHJcblx0XHRcdFx0XHQ8L0ZsZXg+IH1cclxuXHRcdFx0XHRcdHsgJ2xpc3QnID09PSBhdHRyaWJ1dGVzLmNpb19maWVsZHNfcG9zaXRpb24gJiYgPD5cclxuXHRcdFx0XHRcdFx0PFRleHRDb250cm9sXHJcblx0XHRcdFx0XHRcdFx0bGFiZWw9eyBhdHRyaWJ1dGVzLmZpcnN0X2ZpZWxkX2xhYmVsIH1cclxuXHRcdFx0XHRcdFx0XHRwbGFjZWhvbGRlcj17IGF0dHJpYnV0ZXMuZmlyc3RfZmllbGRfcGxhY2Vob2xkZXIgfVxyXG5cdFx0XHRcdFx0XHRcdGtleT17IHVuaXFLZXkoICdwbGFjZV9ob2xkZXJfYmxvY2snICkgfVxyXG5cdFx0XHRcdFx0XHRcdG9uQ2hhbmdlPXsgKCkgPT4ge1xyXG5cdFx0XHRcdFx0XHRcdH0gfVxyXG5cdFx0XHRcdFx0XHQvPlxyXG5cdFx0XHRcdFx0XHQ8VGV4dENvbnRyb2xcclxuXHRcdFx0XHRcdFx0XHRsYWJlbD17IGF0dHJpYnV0ZXMuc2Vjb25kX2ZpZWxkX2xhYmVsIH1cclxuXHRcdFx0XHRcdFx0XHRwbGFjZWhvbGRlcj17IGF0dHJpYnV0ZXMuc2Vjb25kX2ZpZWxkX3BsYWNlaG9sZGVyIH1cclxuXHRcdFx0XHRcdFx0XHRrZXk9eyB1bmlxS2V5KCAncGxhY2VfaG9sZGVyX2Jsb2NrJyApIH1cclxuXHRcdFx0XHRcdFx0XHRvbkNoYW5nZT17ICgpID0+IHtcclxuXHRcdFx0XHRcdFx0XHR9IH1cclxuXHRcdFx0XHRcdFx0Lz5cclxuXHRcdFx0XHRcdDwvPiB9XHJcblx0XHRcdFx0PC8+IH1cclxuXHRcdFx0PC9GaWVsZFdyYXBwZXI+XHJcblx0XHQ8L2Rpdj4sXHJcblx0XTtcclxufVxyXG5cclxuZXhwb3J0IGRlZmF1bHQgQ2hlY2tJbk91dEVkaXQ7IiwiaW1wb3J0IENoZWNrSW5PdXRFZGl0IGZyb20gXCIuL2VkaXRcIjtcclxuaW1wb3J0IG1ldGFkYXRhIGZyb20gXCIuL2Jsb2NrLmpzb25cIjtcclxuXHJcbmNvbnN0IHsgX18gfSA9IHdwLmkxOG47XHJcblxyXG5jb25zdCB7IG5hbWUsIGljb24gfSA9IG1ldGFkYXRhO1xyXG5cclxuLyoqXHJcbiAqIEF2YWlsYWJsZSBpdGVtcyBmb3IgYHVzZUVkaXRQcm9wc2A6XHJcbiAqICAtIHVuaXFLZXlcclxuICogIC0gZm9ybUZpZWxkc1xyXG4gKiAgLSBibG9ja05hbWVcclxuICogIC0gYXR0ckhlbHBcclxuICovXHJcbmNvbnN0IHNldHRpbmdzID0ge1xyXG5cdHRpdGxlOiBfXyggJ0NoZWNrLWluL2NoZWNrLW91dCBkYXRlcycgKSxcclxuXHRpY29uOiA8c3BhbiBkYW5nZXJvdXNseVNldElubmVySFRNTD17IHsgX19odG1sOiBpY29uIH0gfT48L3NwYW4+LFxyXG5cdGVkaXQ6IENoZWNrSW5PdXRFZGl0LFxyXG5cdHVzZUVkaXRQcm9wczogWyAndW5pcUtleScsICdibG9ja05hbWUnLCAnYXR0ckhlbHAnIF0sXHJcblx0ZXhhbXBsZToge1xyXG5cdFx0YXR0cmlidXRlczoge1xyXG5cdFx0XHRsYWJlbDogJ0NoZWNrLWluL2NoZWNrLW91dCBkYXRlcycsXHJcblx0XHRcdGRlc2M6ICdGaWVsZCBkZXNjcmlwdGlvbi4uLicsXHJcblx0XHR9LFxyXG5cdH0sXHJcbn07XHJcblxyXG5leHBvcnQge1xyXG5cdG1ldGFkYXRhLFxyXG5cdG5hbWUsXHJcblx0c2V0dGluZ3NcclxufTsiLCJjb25zdCB7IF9fIH0gPSB3cC5pMThuO1xyXG5cclxuY29uc3QgbGFiZWwgPSB7XHJcblx0Y2lvX2ZpZWxkX2xheW91dDogX18oICdMYXlvdXQ6JywgJ2pldC1ib29raW5nJyApLFxyXG5cdGNpb19maWVsZHNfcG9zaXRpb246IF9fKCAnRmllbGRzIHBvc2l0aW9uOicsICdqZXQtYm9va2luZycgKSxcclxuXHRmaXJzdF9maWVsZF9sYWJlbDogX18oICdDaGVjayBJbiBmaWVsZCBsYWJlbDonLCAnamV0LWJvb2tpbmcnICksXHJcblx0Zmlyc3RfZmllbGRfcGxhY2Vob2xkZXI6IF9fKCAnUGxhY2Vob2xkZXI6JywgJ2pldC1ib29raW5nJyApLFxyXG5cdHNlY29uZF9maWVsZF9sYWJlbDogX18oICdDaGVjayBPdXQgZmllbGQgbGFiZWw6JywgJ2pldC1ib29raW5nJyApLFxyXG5cdHNlY29uZF9maWVsZF9wbGFjZWhvbGRlcjogX18oICdDaGVjayBPdXQgZmllbGQgcGxhY2Vob2xkZXI6JywgJ2pldC1ib29raW5nJyApLFxyXG5cdGNpb19maWVsZHNfZm9ybWF0OiBfXyggJ0RhdGUgZm9ybWF0OicsICdqZXQtYm9va2luZycgKSxcclxuXHRjaW9fZmllbGRzX3NlcGFyYXRvcjogX18oICdEYXRlIGZpZWxkIHNlcGFyYXRvcjonLCAnamV0LWJvb2tpbmcnICksXHJcblx0c3RhcnRfb2Zfd2VlazogX18oICdGaXJzdCBkYXkgb2YgdGhlIHdlZWs6JywgJ2pldC1ib29raW5nJyApLFxyXG59O1xyXG5cclxuY29uc3QgaGVscCA9IHtcclxuXHRjaW9fZmllbGRzX3Bvc2l0aW9uOiBfXyggJ0ZvciBzZXBhcmF0ZSBmaWVsZHMgbGF5b3V0JyApLFxyXG5cdGZpcnN0X2ZpZWxkX2xhYmVsOiBfXyggYElmIHlvdSBhcmUgdXNpbmcgc2VwYXJhdGUgZmllbGRzIGZvciBjaGVjayBpbiBhbmQgY2hlY2sgb3V0IGRhdGVzLFxyXG5cdHlvdSBuZWVkIHRvIGxlZnQgZGVmYXVsdCBcIkxhYmVsXCIgZW1wdHkgYW5kIHVzZSB0aGlzIG9wdGlvbiBmb3IgZmllbGQgbGFiZWxgICksXHJcblx0Y2lvX2ZpZWxkc19mb3JtYXQ6IF9fKCBgQXBwbGllcyBvbmx5IGZvciBkYXRlIGluIHRoZSBmb3JtIGNoZWNraW4vY2hlY2tvdXQgZmllbGRzLlxyXG5cdEZvciBcXGBNTS1ERC1ZWVlZXFxgIGRhdGUgZm9ybWF0IHVzZSB0aGUgXFxgL1xcYCBkYXRlIHNlcGFyYXRvcmAgKSxcclxufTtcclxuXHJcbmNvbnN0IG9wdGlvbnMgPSB7XHJcblx0Y2lvX2ZpZWxkX2xheW91dDogW1xyXG5cdFx0e1xyXG5cdFx0XHR2YWx1ZTogJ3NpbmdsZScsXHJcblx0XHRcdGxhYmVsOiBfXyggJ1NpbmdsZSBmaWVsZCcsICdqZXQtYm9va2luZycgKSxcclxuXHRcdH0sXHJcblx0XHR7XHJcblx0XHRcdHZhbHVlOiAnc2VwYXJhdGUnLFxyXG5cdFx0XHRsYWJlbDogX18oICdTZXBhcmF0ZSBmaWVsZHMgZm9yIGNoZWNrIGluIGFuZCBjaGVjayBvdXQgZGF0ZXMnLCAnamV0LWJvb2tpbmcnICksXHJcblx0XHR9LFxyXG5cdF0sXHJcblx0Y2lvX2ZpZWxkc19wb3NpdGlvbjogW1xyXG5cdFx0e1xyXG5cdFx0XHR2YWx1ZTogJ2lubGluZScsXHJcblx0XHRcdGxhYmVsOiBfXyggJ0lubGluZScsICdqZXQtYm9va2luZycgKSxcclxuXHRcdH0sXHJcblx0XHR7XHJcblx0XHRcdHZhbHVlOiAnbGlzdCcsXHJcblx0XHRcdGxhYmVsOiBfXyggJ0xpc3QnLCAnamV0LWJvb2tpbmcnICksXHJcblx0XHR9LFxyXG5cdF0sXHJcblx0Y2lvX2ZpZWxkc19mb3JtYXQ6IFtcclxuXHRcdHtcclxuXHRcdFx0dmFsdWU6ICdZWVlZLU1NLUREJyxcclxuXHRcdFx0bGFiZWw6IF9fKCAnWVlZWS1NTS1ERCcsICdqZXQtYm9va2luZycgKSxcclxuXHRcdH0sXHJcblx0XHR7XHJcblx0XHRcdHZhbHVlOiAnTU0tREQtWVlZWScsXHJcblx0XHRcdGxhYmVsOiBfXyggJ01NLURELVlZWVknLCAnamV0LWJvb2tpbmcnICksXHJcblx0XHR9LFxyXG5cdFx0e1xyXG5cdFx0XHR2YWx1ZTogJ0RELU1NLVlZWVknLFxyXG5cdFx0XHRsYWJlbDogX18oICdERC1NTS1ZWVlZJywgJ2pldC1ib29raW5nJyApLFxyXG5cdFx0fSxcclxuXHRdLFxyXG5cdGNpb19maWVsZHNfc2VwYXJhdG9yOiBbXHJcblx0XHR7XHJcblx0XHRcdHZhbHVlOiAnLScsXHJcblx0XHRcdGxhYmVsOiAnLScsXHJcblx0XHR9LFxyXG5cdFx0e1xyXG5cdFx0XHR2YWx1ZTogJy4nLFxyXG5cdFx0XHRsYWJlbDogJy4nLFxyXG5cdFx0fSxcclxuXHRcdHtcclxuXHRcdFx0dmFsdWU6ICcvJyxcclxuXHRcdFx0bGFiZWw6ICcvJyxcclxuXHRcdH0sXHJcblx0XHR7XHJcblx0XHRcdHZhbHVlOiAnc3BhY2UnLFxyXG5cdFx0XHRsYWJlbDogX18oICdTcGFjZScsICdqZXQtYm9va2luZycgKSxcclxuXHRcdH0sXHJcblx0XSxcclxuXHRzdGFydF9vZl93ZWVrOiBbXHJcblx0XHR7XHJcblx0XHRcdHZhbHVlOiAnbW9uZGF5JyxcclxuXHRcdFx0bGFiZWw6IF9fKCAnTW9uZGF5JywgJ2pldC1ib29raW5nJyApLFxyXG5cdFx0fSxcclxuXHRcdHtcclxuXHRcdFx0dmFsdWU6ICdzdW5kYXknLFxyXG5cdFx0XHRsYWJlbDogX18oICdTdW5kYXknLCAnamV0LWJvb2tpbmcnICksXHJcblx0XHR9LFxyXG5cdF0sXHJcbn07XHJcblxyXG5leHBvcnQge1xyXG5cdGhlbHAsXHJcblx0bGFiZWwsXHJcblx0b3B0aW9ucyxcclxufTtcclxuXHJcbiIsImltcG9ydCAqIGFzIGNoZWNrSW5PdXQgZnJvbSAnLi9ibG9ja3MvY2hlY2staW4tb3V0J1xyXG5pbXBvcnQgJy4vYWN0aW9ucy9hcGFydG1lbnQtYm9va2luZyc7XHJcblxyXG5jb25zdCB7XHJcblx0XHQgIGFkZEZpbHRlcixcclxuXHQgIH0gPSB3cC5ob29rcztcclxuXHJcbmFkZEZpbHRlciggJ2pldC5mYi5yZWdpc3Rlci5maWVsZHMnLCAnamV0LWZvcm0tYnVpbGRlcicsIGJsb2NrcyA9PiB7XHJcblx0YmxvY2tzLnB1c2goIGNoZWNrSW5PdXQgKTtcclxuXHJcblx0cmV0dXJuIGJsb2NrcztcclxufSApO1xyXG5cclxuYWRkRmlsdGVyKCAnamV0LmZiLmNhbGN1bGF0ZWQuZmllbGQuYXZhaWxhYmxlLmZpZWxkcycsICdqZXQtZm9ybS1idWlsZGVyJywgZmllbGRzID0+IHtcclxuXHRmaWVsZHMucHVzaCggJyVBRFZBTkNFRF9QUklDRTo6ZmllbGRfbmFtZSUnLCAnJU1FVEE6Ol9hcGFydG1lbnRfcHJpY2UlJyApO1xyXG5cclxuXHRyZXR1cm4gZmllbGRzO1xyXG59ICkiXSwibWFwcGluZ3MiOiI7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNsRkE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBUUE7QUFBQTtBQUFBO0FBS0E7QUFBQTtBQUFBO0FBS0E7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQU9BO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUxBO0FBUUE7QUFNQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQ0E7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFKQTtBQUpBO0FBV0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUFBO0FBQ0E7QUFMQTtBQVFBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBTEE7QUFRQTtBQUNBO0FBQ0E7QUFIQTtBQUtBO0FBQUE7QUFBQTtBQUFBO0FBQ0E7QUFEQTtBQUlBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFIQTtBQUhBO0FBWUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFDQTtBQU5BO0FBU0E7QUFDQTtBQUZBO0FBS0E7QUFDQTtBQUFBO0FBQUE7QUFGQTtBQU1BO0FBQ0E7QUFDQTtBQUhBO0FBS0E7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQURBO0FBSUE7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUFBO0FBQ0E7QUFMQTtBQUhBO0FBYUE7QUFDQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBQUE7QUFBQTtBQUxBO0FBT0E7QUFBQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFWQTtBQVlBO0FBQUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUxBO0FBUUE7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFIQTtBQU9BO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBSEE7QUFLQTtBQUFBO0FBQUE7QUFLQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQ0E7QUFMQTtBQVFBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBSEE7QUFNQTtBQWpEQTtBQXNEQTs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDMU5BO0FBTUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQU9BO0FBQUE7QUFJQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFPQTtBQUVBO0FBQUE7QUFBQTtBQUNBO0FBSUE7QUFDQTtBQUVBO0FBQUE7QUFBQTtBQUFBO0FBT0E7QUFFQTtBQURBO0FBS0E7QUFEQTtBQUlBO0FBREE7QUFLQTtBQUNBO0FBRkE7QUFLQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFQQTtBQVVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBUkE7QUFXQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBTkE7QUFTQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBTkE7QUFTQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBTkE7QUFTQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBTkE7QUFTQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUFBO0FBQ0E7QUFDQTtBQVJBO0FBV0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBUEE7QUFVQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFQQTtBQVdBO0FBREE7QUFLQTtBQUFBO0FBRUE7QUFEQTtBQUtBO0FBQ0E7QUFDQTtBQUhBO0FBT0E7QUFBQTtBQUNBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUpBO0FBUUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBSkE7QUFXQTtBQUNBO0FBQ0E7QUFDQTtBQUpBO0FBUUE7QUFDQTtBQUNBO0FBQ0E7QUFKQTtBQVlBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDcE1BO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUVBO0FBRUE7QUFBQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUZBO0FBREE7QUFMQTs7Ozs7Ozs7Ozs7OztBQ2RBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQVRBO0FBWUE7QUFDQTtBQUNBO0FBRUE7QUFKQTtBQVFBO0FBQ0E7QUFFQTtBQUNBO0FBRkE7QUFLQTtBQUNBO0FBRkE7QUFLQTtBQUVBO0FBQ0E7QUFGQTtBQUtBO0FBQ0E7QUFGQTtBQUtBO0FBRUE7QUFDQTtBQUZBO0FBS0E7QUFDQTtBQUZBO0FBS0E7QUFDQTtBQUZBO0FBS0E7QUFFQTtBQUNBO0FBRkE7QUFLQTtBQUNBO0FBRkE7QUFLQTtBQUNBO0FBRkE7QUFLQTtBQUNBO0FBRkE7QUFLQTtBQUVBO0FBQ0E7QUFGQTtBQUtBO0FBQ0E7QUFGQTtBQTFEQTs7Ozs7Ozs7Ozs7OztBQ3RCQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQ0E7QUFFQTtBQUlBO0FBQ0E7QUFFQTtBQUNBO0FBRUE7QUFDQTtBQUVBO0FBQ0E7Ozs7QSIsInNvdXJjZVJvb3QiOiIifQ==