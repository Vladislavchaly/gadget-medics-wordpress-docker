(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _yoast$analysis = yoast.analysis,
    Paper = _yoast$analysis.Paper,
    Researcher = _yoast$analysis.Researcher,
    AssessmentResult = _yoast$analysis.AssessmentResult,
    Assessment = _yoast$analysis.Assessment;

var LocalSchemaAssessment = function (_Assessment) {
	_inherits(LocalSchemaAssessment, _Assessment);

	function LocalSchemaAssessment(settings) {
		_classCallCheck(this, LocalSchemaAssessment);

		var _this = _possibleConstructorReturn(this, (LocalSchemaAssessment.__proto__ || Object.getPrototypeOf(LocalSchemaAssessment)).call(this));

		_this.settings = settings;
		return _this;
	}

	/**
  * Runs an assessment for scoring schema in the paper's text.
  *
  * @param {Paper} paper The paper to run this assessment on.
  * @param {Researcher} researcher The researcher used for the assessment.
  * @param {Object} i18n The i18n-object used for parsing translations.
  *
  * @returns {object} an assessment result with the score and formatted text.
  */


	_createClass(LocalSchemaAssessment, [{
		key: 'getResult',
		value: function getResult(paper, researcher, i18n) {
			var assessmentResult = new AssessmentResult();
			var schema = new RegExp('class=["\']wpseo-location["\'] itemscope', 'ig');
			var matches = paper.getText().match(schema) || 0;
			var result = this.score(matches);

			assessmentResult.setScore(result.score);
			assessmentResult.setText(result.text);

			return assessmentResult;
		}

		/**
   * Scores the content based on the matches of the location schema.
   *
   * @param {Array} matches The matches in the video title.
   *
   * @returns {{score: number, text: *}} An object containing the score and text
   */

	}, {
		key: 'score',
		value: function score(matches) {
			if (matches.length > 0) {
				return {
					score: 9,
					text: this.settings.address_schema
				};
			}
			return {
				score: 4,
				text: this.settings.no_address_schema
			};
		}
	}]);

	return LocalSchemaAssessment;
}(Assessment);

exports.default = LocalSchemaAssessment;

},{}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _yoast$analysis = yoast.analysis,
    Paper = _yoast$analysis.Paper,
    Researcher = _yoast$analysis.Researcher,
    AssessmentResult = _yoast$analysis.AssessmentResult,
    Assessment = _yoast$analysis.Assessment;

var LocalTitleAssessment = function (_Assessment) {
	_inherits(LocalTitleAssessment, _Assessment);

	function LocalTitleAssessment(settings) {
		_classCallCheck(this, LocalTitleAssessment);

		var _this = _possibleConstructorReturn(this, (LocalTitleAssessment.__proto__ || Object.getPrototypeOf(LocalTitleAssessment)).call(this));

		_this.settings = settings;
		return _this;
	}

	/**
  * Tests if the selected location is present in the title or headings.
  *
  * @param {Paper} paper The paper to run this assessment on.
  * @param {Researcher} researcher The researcher used for the assessment.
  * @param {Object} i18n The i18n-object used for parsing translations.
  *
  * @returns {object} an assessment result with the score and formatted text.
  */


	_createClass(LocalTitleAssessment, [{
		key: 'getResult',
		value: function getResult(paper, researcher, i18n) {
			var assessmentResult = new AssessmentResult();
			if (this.settings.location !== '') {
				var businessCity = new RegExp(this.settings.location, 'ig');
				var matches = paper.getTitle().match(businessCity) || 0;
				var result = this.scoreTitle(matches);

				// When no results, check for the location in h1 or h2 tags in the content.
				if (!matches) {
					var headings = new RegExp('<h(1|2)>.*?' + this.settings.location + '.*?<\/h(1|2)>', 'ig');
					matches = paper.getText().match(headings) || 0;
					result = this.scoreHeadings(matches);
				}

				assessmentResult.setScore(result.score);
				assessmentResult.setText(result.text);
			}
			return assessmentResult;
		}

		/**
   * Scores the url based on the matches of the location's city in the title.
   *
   * @param {Array} matches The matches in the video title.
   *
   * @returns {{score: number, text: *}} An object containing the score and text
   */

	}, {
		key: 'scoreTitle',
		value: function scoreTitle(matches) {
			if (matches.length > 0) {
				return {
					score: 9,
					text: this.settings.title_location
				};
			}
			return {
				score: 4,
				text: this.settings.title_no_location
			};
		}

		/**
   * Scores the url based on the matches of the location's city in headings.
   *
   * @param {Array} matches The matches in the video title.
   *
   * @returns {{score: number, text: *}} An object containing the score and text
   */

	}, {
		key: 'scoreHeadings',
		value: function scoreHeadings(matches) {
			if (matches.length > 0) {
				return {
					score: 9,
					text: this.settings.heading_location
				};
			}
			return {
				score: 4,
				text: this.settings.heading_no_location
			};
		}
	}]);

	return LocalTitleAssessment;
}(Assessment);

exports.default = LocalTitleAssessment;

},{}],3:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

var _escapeRegExp = require("lodash/escapeRegExp");

var _escapeRegExp2 = _interopRequireDefault(_escapeRegExp);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _yoast$analysis = yoast.analysis,
    Paper = _yoast$analysis.Paper,
    Researcher = _yoast$analysis.Researcher,
    AssessmentResult = _yoast$analysis.AssessmentResult,
    Assessment = _yoast$analysis.Assessment;

var LocalUrlAssessment = function (_Assessment) {
	_inherits(LocalUrlAssessment, _Assessment);

	function LocalUrlAssessment(settings) {
		_classCallCheck(this, LocalUrlAssessment);

		var _this = _possibleConstructorReturn(this, (LocalUrlAssessment.__proto__ || Object.getPrototypeOf(LocalUrlAssessment)).call(this));

		_this.settings = settings;
		return _this;
	}

	/**
  * Runs an assessment for scoring the location in the URL.
  *
  * @param {Paper} paper The paper to run this assessment on.
  * @param {Researcher} researcher The researcher used for the assessment.
  * @param {Object} i18n The i18n-object used for parsing translations.
  *
  * @returns {object} an assessment result with the score and formatted text.
  */


	_createClass(LocalUrlAssessment, [{
		key: "getResult",
		value: function getResult(paper, researcher, i18n) {
			var assessmentResult = new AssessmentResult();
			if (this.settings.location !== '') {
				var location = this.settings.location;
				location = location.replace("'", "").replace(/\s/ig, "-");
				location = (0, _escapeRegExp2.default)(location);
				var business_city = new RegExp(location, 'ig');
				var matches = paper.getUrl().match(business_city) || 0;
				var result = this.score(matches);
				assessmentResult.setScore(result.score);
				assessmentResult.setText(result.text);
			}
			return assessmentResult;
		}

		/**
   * Scores the url based on the matches of the location.
   *
   * @param {Array} matches The matches in the video title.
   *
   * @returns {{score: number, text: *}} An object containing the score and text
   */

	}, {
		key: "score",
		value: function score(matches) {
			if (matches.length > 0) {
				return {
					score: 9,
					text: this.settings.url_location
				};
			}
			return {
				score: 4,
				text: this.settings.url_no_location
			};
		}
	}]);

	return LocalUrlAssessment;
}(Assessment);

exports.default = LocalUrlAssessment;

},{"lodash/escapeRegExp":13}],4:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }(); /* global analysisWorker */


var _localTitleAssessment = require('./assessments/local-title-assessment');

var _localTitleAssessment2 = _interopRequireDefault(_localTitleAssessment);

var _localUrlAssessment = require('./assessments/local-url-assessment');

var _localUrlAssessment2 = _interopRequireDefault(_localUrlAssessment);

var _localSchemaAssessment = require('./assessments/local-schema-assessment');

var _localSchemaAssessment2 = _interopRequireDefault(_localSchemaAssessment);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var LocalLocationsWorker = function () {
	function LocalLocationsWorker() {
		_classCallCheck(this, LocalLocationsWorker);
	}

	_createClass(LocalLocationsWorker, [{
		key: 'register',
		value: function register() {
			analysisWorker.registerMessageHandler('initializeLocations', this.initialize.bind(this), 'YoastLocalSEO');
		}
	}, {
		key: 'initialize',
		value: function initialize(settings) {
			this.titleAssessment = new _localTitleAssessment2.default(settings);
			this.urlAssessment = new _localUrlAssessment2.default(settings);
			this.schemaAssessment = new _localSchemaAssessment2.default(settings);

			analysisWorker.registerAssessment('localTitle', this.titleAssessment, 'YoastLocalSEO');
			analysisWorker.registerAssessment('localUrl', this.urlAssessment, 'YoastLocalSEO');
			analysisWorker.registerAssessment('localSchema', this.schemaAssessment, 'YoastLocalSEO');
		}
	}]);

	return LocalLocationsWorker;
}();

var localLocationsWorker = new LocalLocationsWorker();

localLocationsWorker.register();

},{"./assessments/local-schema-assessment":1,"./assessments/local-title-assessment":2,"./assessments/local-url-assessment":3}],5:[function(require,module,exports){
var root = require('./_root');

/** Built-in value references. */
var Symbol = root.Symbol;

module.exports = Symbol;

},{"./_root":12}],6:[function(require,module,exports){
/**
 * A specialized version of `_.map` for arrays without support for iteratee
 * shorthands.
 *
 * @private
 * @param {Array} [array] The array to iterate over.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Array} Returns the new mapped array.
 */
function arrayMap(array, iteratee) {
  var index = -1,
      length = array == null ? 0 : array.length,
      result = Array(length);

  while (++index < length) {
    result[index] = iteratee(array[index], index, array);
  }
  return result;
}

module.exports = arrayMap;

},{}],7:[function(require,module,exports){
var Symbol = require('./_Symbol'),
    getRawTag = require('./_getRawTag'),
    objectToString = require('./_objectToString');

/** `Object#toString` result references. */
var nullTag = '[object Null]',
    undefinedTag = '[object Undefined]';

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * The base implementation of `getTag` without fallbacks for buggy environments.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the `toStringTag`.
 */
function baseGetTag(value) {
  if (value == null) {
    return value === undefined ? undefinedTag : nullTag;
  }
  return (symToStringTag && symToStringTag in Object(value))
    ? getRawTag(value)
    : objectToString(value);
}

module.exports = baseGetTag;

},{"./_Symbol":5,"./_getRawTag":10,"./_objectToString":11}],8:[function(require,module,exports){
var Symbol = require('./_Symbol'),
    arrayMap = require('./_arrayMap'),
    isArray = require('./isArray'),
    isSymbol = require('./isSymbol');

/** Used as references for various `Number` constants. */
var INFINITY = 1 / 0;

/** Used to convert symbols to primitives and strings. */
var symbolProto = Symbol ? Symbol.prototype : undefined,
    symbolToString = symbolProto ? symbolProto.toString : undefined;

/**
 * The base implementation of `_.toString` which doesn't convert nullish
 * values to empty strings.
 *
 * @private
 * @param {*} value The value to process.
 * @returns {string} Returns the string.
 */
function baseToString(value) {
  // Exit early for strings to avoid a performance hit in some environments.
  if (typeof value == 'string') {
    return value;
  }
  if (isArray(value)) {
    // Recursively convert values (susceptible to call stack limits).
    return arrayMap(value, baseToString) + '';
  }
  if (isSymbol(value)) {
    return symbolToString ? symbolToString.call(value) : '';
  }
  var result = (value + '');
  return (result == '0' && (1 / value) == -INFINITY) ? '-0' : result;
}

module.exports = baseToString;

},{"./_Symbol":5,"./_arrayMap":6,"./isArray":14,"./isSymbol":16}],9:[function(require,module,exports){
(function (global){
/** Detect free variable `global` from Node.js. */
var freeGlobal = typeof global == 'object' && global && global.Object === Object && global;

module.exports = freeGlobal;

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})

},{}],10:[function(require,module,exports){
var Symbol = require('./_Symbol');

/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * A specialized version of `baseGetTag` which ignores `Symbol.toStringTag` values.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the raw `toStringTag`.
 */
function getRawTag(value) {
  var isOwn = hasOwnProperty.call(value, symToStringTag),
      tag = value[symToStringTag];

  try {
    value[symToStringTag] = undefined;
    var unmasked = true;
  } catch (e) {}

  var result = nativeObjectToString.call(value);
  if (unmasked) {
    if (isOwn) {
      value[symToStringTag] = tag;
    } else {
      delete value[symToStringTag];
    }
  }
  return result;
}

module.exports = getRawTag;

},{"./_Symbol":5}],11:[function(require,module,exports){
/** Used for built-in method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/**
 * Converts `value` to a string using `Object.prototype.toString`.
 *
 * @private
 * @param {*} value The value to convert.
 * @returns {string} Returns the converted string.
 */
function objectToString(value) {
  return nativeObjectToString.call(value);
}

module.exports = objectToString;

},{}],12:[function(require,module,exports){
var freeGlobal = require('./_freeGlobal');

/** Detect free variable `self`. */
var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

/** Used as a reference to the global object. */
var root = freeGlobal || freeSelf || Function('return this')();

module.exports = root;

},{"./_freeGlobal":9}],13:[function(require,module,exports){
var toString = require('./toString');

/**
 * Used to match `RegExp`
 * [syntax characters](http://ecma-international.org/ecma-262/7.0/#sec-patterns).
 */
var reRegExpChar = /[\\^$.*+?()[\]{}|]/g,
    reHasRegExpChar = RegExp(reRegExpChar.source);

/**
 * Escapes the `RegExp` special characters "^", "$", "\", ".", "*", "+",
 * "?", "(", ")", "[", "]", "{", "}", and "|" in `string`.
 *
 * @static
 * @memberOf _
 * @since 3.0.0
 * @category String
 * @param {string} [string=''] The string to escape.
 * @returns {string} Returns the escaped string.
 * @example
 *
 * _.escapeRegExp('[lodash](https://lodash.com/)');
 * // => '\[lodash\]\(https://lodash\.com/\)'
 */
function escapeRegExp(string) {
  string = toString(string);
  return (string && reHasRegExpChar.test(string))
    ? string.replace(reRegExpChar, '\\$&')
    : string;
}

module.exports = escapeRegExp;

},{"./toString":17}],14:[function(require,module,exports){
/**
 * Checks if `value` is classified as an `Array` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an array, else `false`.
 * @example
 *
 * _.isArray([1, 2, 3]);
 * // => true
 *
 * _.isArray(document.body.children);
 * // => false
 *
 * _.isArray('abc');
 * // => false
 *
 * _.isArray(_.noop);
 * // => false
 */
var isArray = Array.isArray;

module.exports = isArray;

},{}],15:[function(require,module,exports){
/**
 * Checks if `value` is object-like. A value is object-like if it's not `null`
 * and has a `typeof` result of "object".
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
 * @example
 *
 * _.isObjectLike({});
 * // => true
 *
 * _.isObjectLike([1, 2, 3]);
 * // => true
 *
 * _.isObjectLike(_.noop);
 * // => false
 *
 * _.isObjectLike(null);
 * // => false
 */
function isObjectLike(value) {
  return value != null && typeof value == 'object';
}

module.exports = isObjectLike;

},{}],16:[function(require,module,exports){
var baseGetTag = require('./_baseGetTag'),
    isObjectLike = require('./isObjectLike');

/** `Object#toString` result references. */
var symbolTag = '[object Symbol]';

/**
 * Checks if `value` is classified as a `Symbol` primitive or object.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a symbol, else `false`.
 * @example
 *
 * _.isSymbol(Symbol.iterator);
 * // => true
 *
 * _.isSymbol('abc');
 * // => false
 */
function isSymbol(value) {
  return typeof value == 'symbol' ||
    (isObjectLike(value) && baseGetTag(value) == symbolTag);
}

module.exports = isSymbol;

},{"./_baseGetTag":7,"./isObjectLike":15}],17:[function(require,module,exports){
var baseToString = require('./_baseToString');

/**
 * Converts `value` to a string. An empty string is returned for `null`
 * and `undefined` values. The sign of `-0` is preserved.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to convert.
 * @returns {string} Returns the converted string.
 * @example
 *
 * _.toString(null);
 * // => ''
 *
 * _.toString(-0);
 * // => '-0'
 *
 * _.toString([1, 2, 3]);
 * // => '1,2,3'
 */
function toString(value) {
  return value == null ? '' : baseToString(value);
}

module.exports = toString;

},{"./_baseToString":8}]},{},[4])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJqcy9zcmMvYXNzZXNzbWVudHMvbG9jYWwtc2NoZW1hLWFzc2Vzc21lbnQuanMiLCJqcy9zcmMvYXNzZXNzbWVudHMvbG9jYWwtdGl0bGUtYXNzZXNzbWVudC5qcyIsImpzL3NyYy9hc3Nlc3NtZW50cy9sb2NhbC11cmwtYXNzZXNzbWVudC5qcyIsImpzL3NyYy93cC1zZW8tbG9jYWwtd29ya2VyLWxvY2F0aW9ucy5qcyIsIm5vZGVfbW9kdWxlcy9sb2Rhc2gvX1N5bWJvbC5qcyIsIm5vZGVfbW9kdWxlcy9sb2Rhc2gvX2FycmF5TWFwLmpzIiwibm9kZV9tb2R1bGVzL2xvZGFzaC9fYmFzZUdldFRhZy5qcyIsIm5vZGVfbW9kdWxlcy9sb2Rhc2gvX2Jhc2VUb1N0cmluZy5qcyIsIm5vZGVfbW9kdWxlcy9sb2Rhc2gvX2ZyZWVHbG9iYWwuanMiLCJub2RlX21vZHVsZXMvbG9kYXNoL19nZXRSYXdUYWcuanMiLCJub2RlX21vZHVsZXMvbG9kYXNoL19vYmplY3RUb1N0cmluZy5qcyIsIm5vZGVfbW9kdWxlcy9sb2Rhc2gvX3Jvb3QuanMiLCJub2RlX21vZHVsZXMvbG9kYXNoL2VzY2FwZVJlZ0V4cC5qcyIsIm5vZGVfbW9kdWxlcy9sb2Rhc2gvaXNBcnJheS5qcyIsIm5vZGVfbW9kdWxlcy9sb2Rhc2gvaXNPYmplY3RMaWtlLmpzIiwibm9kZV9tb2R1bGVzL2xvZGFzaC9pc1N5bWJvbC5qcyIsIm5vZGVfbW9kdWxlcy9sb2Rhc2gvdG9TdHJpbmcuanMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7Ozs7Ozs7Ozs7Ozs7OztzQkNBNEQsTUFBTSxRO0lBQTFELEssbUJBQUEsSztJQUFPLFUsbUJBQUEsVTtJQUFZLGdCLG1CQUFBLGdCO0lBQWtCLFUsbUJBQUEsVTs7SUFFeEIscUI7OztBQUNwQixnQ0FBYSxRQUFiLEVBQXdCO0FBQUE7O0FBQUE7O0FBRXZCLFFBQUssUUFBTCxHQUFn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QTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUNyQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7OztBQ0pBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDOUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDdEJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQ1RBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUNoQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQzFCQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDN0JBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUM3QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsImZpbGUiOiJnZW5lcmF0ZWQuanMiLCJzb3VyY2VSb290IjoiIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uKCl7ZnVuY3Rpb24gcihlLG4sdCl7ZnVuY3Rpb24gbyhpLGYpe2lmKCFuW2ldKXtpZighZVtpXSl7dmFyIGM9XCJmdW5jdGlvblwiPT10eXBlb2YgcmVxdWlyZSYmcmVxdWlyZTtpZighZiYmYylyZXR1cm4gYyhpLCEwKTtpZih1KXJldHVybiB1KGksITApO3ZhciBhPW5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIraStcIidcIik7dGhyb3cgYS5jb2RlPVwiTU9EVUxFX05PVF9GT1VORFwiLGF9dmFyIHA9bltpXT17ZXhwb3J0czp7fX07ZVtpXVswXS5jYWxsKHAuZXhwb3J0cyxmdW5jdGlvbihyKXt2YXIgbj1lW2ldWzFdW3JdO3JldHVybiBvKG58fHIpfSxwLHAuZXhwb3J0cyxyLGUsbix0KX1yZXR1cm4gbltpXS5leHBvcnRzfWZvcih2YXIgdT1cImZ1bmN0aW9uXCI9PXR5cGVvZiByZXF1aXJlJiZyZXF1aXJlLGk9MDtpPHQubGVuZ3RoO2krKylvKHRbaV0pO3JldHVybiBvfXJldHVybiByfSkoKSIsImNvbnN0IHsgUGFwZXIsIFJlc2VhcmNoZXIsIEFzc2Vzc21lbnRSZXN1bHQsIEFzc2Vzc21lbnQgfSA9IHlvYXN0LmFuYWx5c2lzO1xuXG5leHBvcnQgZGVmYXVsdCBjbGFzcyBMb2NhbFNjaGVtYUFzc2Vzc21lbnQgZXh0ZW5kcyBBc3Nlc3NtZW50IHtcblx0Y29uc3RydWN0b3IoIHNldHRpbmdzICkge1xuXHRcdHN1cGVyKCk7XG5cdFx0dGhpcy5zZXR0aW5ncyA9IHNldHRpbmdzO1xuXHR9XG5cblx0LyoqXG5cdCAqIFJ1bnMgYW4gYXNzZXNzbWVudCBmb3Igc2NvcmluZyBzY2hlbWEgaW4gdGhlIHBhcGVyJ3MgdGV4dC5cblx0ICpcblx0ICogQHBhcmFtIHtQYXBlcn0gcGFwZXIgVGhlIHBhcGVyIHRvIHJ1biB0aGlzIGFzc2Vzc21lbnQgb24uXG5cdCAqIEBwYXJhbSB7UmVzZWFyY2hlcn0gcmVzZWFyY2hlciBUaGUgcmVzZWFyY2hlciB1c2VkIGZvciB0aGUgYXNzZXNzbWVudC5cblx0ICogQHBhcmFtIHtPYmplY3R9IGkxOG4gVGhlIGkxOG4tb2JqZWN0IHVzZWQgZm9yIHBhcnNpbmcgdHJhbnNsYXRpb25zLlxuXHQgKlxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fSBhbiBhc3Nlc3NtZW50IHJlc3VsdCB3aXRoIHRoZSBzY29yZSBhbmQgZm9ybWF0dGVkIHRleHQuXG5cdCAqL1xuXHRnZXRSZXN1bHQoIHBhcGVyLCByZXNlYXJjaGVyLCBpMThuICkge1xuXHRcdGNvbnN0IGFzc2Vzc21lbnRSZXN1bHQgPSBuZXcgQXNzZXNzbWVudFJlc3VsdCgpO1xuXHRcdGNvbnN0IHNjaGVtYSA9IG5ldyBSZWdFeHAoICdjbGFzcz1bXCJcXCddd3BzZW8tbG9jYXRpb25bXCJcXCddIGl0ZW1zY29wZScsICdpZycgKTtcblx0XHRjb25zdCBtYXRjaGVzID0gcGFwZXIuZ2V0VGV4dCgpLm1hdGNoKCBzY2hlbWEgKSB8fCAwO1xuXHRcdGNvbnN0IHJlc3VsdCA9IHRoaXMuc2NvcmUoIG1hdGNoZXMgKTtcblxuXHRcdGFzc2Vzc21lbnRSZXN1bHQuc2V0U2NvcmUoIHJlc3VsdC5zY29yZSApO1xuXHRcdGFzc2Vzc21lbnRSZXN1bHQuc2V0VGV4dCggcmVzdWx0LnRleHQgKTtcblxuXHRcdHJldHVybiBhc3Nlc3NtZW50UmVzdWx0O1xuXHR9XG5cblx0LyoqXG5cdCAqIFNjb3JlcyB0aGUgY29udGVudCBiYXNlZCBvbiB0aGUgbWF0Y2hlcyBvZiB0aGUgbG9jYXRpb24gc2NoZW1hLlxuXHQgKlxuXHQgKiBAcGFyYW0ge0FycmF5fSBtYXRjaGVzIFRoZSBtYXRjaGVzIGluIHRoZSB2aWRlbyB0aXRsZS5cblx0ICpcblx0ICogQHJldHVybnMge3tzY29yZTogbnVtYmVyLCB0ZXh0OiAqfX0gQW4gb2JqZWN0IGNvbnRhaW5pbmcgdGhlIHNjb3JlIGFuZCB0ZXh0XG5cdCAqL1xuXHRzY29yZSggbWF0Y2hlcyApIHtcblx0XHRpZiAoIG1hdGNoZXMubGVuZ3RoID4gMCApIHtcblx0XHRcdHJldHVybntcblx0XHRcdFx0c2NvcmU6IDksXG5cdFx0XHRcdHRleHQ6IHRoaXMuc2V0dGluZ3MuYWRkcmVzc19zY2hlbWFcblx0XHRcdH1cblx0XHR9XG5cdFx0cmV0dXJue1xuXHRcdFx0c2NvcmU6IDQsXG5cdFx0XHR0ZXh0OiB0aGlzLnNldHRpbmdzLm5vX2FkZHJlc3Nfc2NoZW1hXG5cdFx0fVxuXHR9XG59XG4iLCJjb25zdCB7IFBhcGVyLCBSZXNlYXJjaGVyLCBBc3Nlc3NtZW50UmVzdWx0LCBBc3Nlc3NtZW50IH0gPSB5b2FzdC5hbmFseXNpcztcblxuZXhwb3J0IGRlZmF1bHQgY2xhc3MgTG9jYWxUaXRsZUFzc2Vzc21lbnQgZXh0ZW5kcyBBc3Nlc3NtZW50IHtcblx0Y29uc3RydWN0b3IoIHNldHRpbmdzICkge1xuXHRcdHN1cGVyKCk7XG5cdFx0dGhpcy5zZXR0aW5ncyA9IHNldHRpbmdzO1xuXHR9XG5cblx0LyoqXG5cdCAqIFRlc3RzIGlmIHRoZSBzZWxlY3RlZCBsb2NhdGlvbiBpcyBwcmVzZW50IGluIHRoZSB0aXRsZSBvciBoZWFkaW5ncy5cblx0ICpcblx0ICogQHBhcmFtIHtQYXBlcn0gcGFwZXIgVGhlIHBhcGVyIHRvIHJ1biB0aGlzIGFzc2Vzc21lbnQgb24uXG5cdCAqIEBwYXJhbSB7UmVzZWFyY2hlcn0gcmVzZWFyY2hlciBUaGUgcmVzZWFyY2hlciB1c2VkIGZvciB0aGUgYXNzZXNzbWVudC5cblx0ICogQHBhcmFtIHtPYmplY3R9IGkxOG4gVGhlIGkxOG4tb2JqZWN0IHVzZWQgZm9yIHBhcnNpbmcgdHJhbnNsYXRpb25zLlxuXHQgKlxuXHQgKiBAcmV0dXJucyB7b2JqZWN0fSBhbiBhc3Nlc3NtZW50IHJlc3VsdCB3aXRoIHRoZSBzY29yZSBhbmQgZm9ybWF0dGVkIHRleHQuXG5cdCAqL1xuXHRnZXRSZXN1bHQoIHBhcGVyLCByZXNlYXJjaGVyLCBpMThuICkge1xuXHRcdGNvbnN0IGFzc2Vzc21lbnRSZXN1bHQgPSBuZXcgQXNzZXNzbWVudFJlc3VsdCgpO1xuXHRcdGlmKCB0aGlzLnNldHRpbmdzLmxvY2F0aW9uICE9PSAnJyApIHtcblx0XHRcdGNvbnN0IGJ1c2luZXNzQ2l0eSA9IG5ldyBSZWdFeHAoIHRoaXMuc2V0dGluZ3MubG9jYXRpb24sICdpZycpO1xuXHRcdFx0bGV0IG1hdGNoZXMgPSBwYXBlci5nZXRUaXRsZSgpLm1hdGNoKCBidXNpbmVzc0NpdHkgKSB8fCAwO1xuXHRcdFx0bGV0IHJlc3VsdCA9IHRoaXMuc2NvcmVUaXRsZSggbWF0Y2hlcyApO1xuXG5cdFx0XHQvLyBXaGVuIG5vIHJlc3VsdHMsIGNoZWNrIGZvciB0aGUgbG9jYXRpb24gaW4gaDEgb3IgaDIgdGFncyBpbiB0aGUgY29udGVudC5cblx0XHRcdGlmKCAhIG1hdGNoZXMgKSB7XG5cdFx0XHRcdGNvbnN0IGhlYWRpbmdzID0gbmV3IFJlZ0V4cCggJzxoKDF8Mik+Lio/JyArIHRoaXMuc2V0dGluZ3MubG9jYXRpb24gKyAnLio/PFxcL2goMXwyKT4nLCAnaWcnICk7XG5cdFx0XHRcdG1hdGNoZXMgPSBwYXBlci5nZXRUZXh0KCkubWF0Y2goIGhlYWRpbmdzICkgfHwgMDtcblx0XHRcdFx0cmVzdWx0ID0gdGhpcy5zY29yZUhlYWRpbmdzKCBtYXRjaGVzICk7XG5cdFx0XHR9XG5cblx0XHRcdGFzc2Vzc21lbnRSZXN1bHQuc2V0U2NvcmUoIHJlc3VsdC5zY29yZSApO1xuXHRcdFx0YXNzZXNzbWVudFJlc3VsdC5zZXRUZXh0KCByZXN1bHQudGV4dCApO1xuXHRcdH1cblx0XHRyZXR1cm4gYXNzZXNzbWVudFJlc3VsdDtcblx0fVxuXG5cdC8qKlxuXHQgKiBTY29yZXMgdGhlIHVybCBiYXNlZCBvbiB0aGUgbWF0Y2hlcyBvZiB0aGUgbG9jYXRpb24ncyBjaXR5IGluIHRoZSB0aXRsZS5cblx0ICpcblx0ICogQHBhcmFtIHtBcnJheX0gbWF0Y2hlcyBUaGUgbWF0Y2hlcyBpbiB0aGUgdmlkZW8gdGl0bGUuXG5cdCAqXG5cdCAqIEByZXR1cm5zIHt7c2NvcmU6IG51bWJlciwgdGV4dDogKn19IEFuIG9iamVjdCBjb250YWluaW5nIHRoZSBzY29yZSBhbmQgdGV4dFxuXHQgKi9cblx0c2NvcmVUaXRsZSggbWF0Y2hlcyApIHtcblx0XHRpZiAoIG1hdGNoZXMubGVuZ3RoID4gMCApIHtcblx0XHRcdHJldHVybiB7XG5cdFx0XHRcdHNjb3JlOiA5LFxuXHRcdFx0XHR0ZXh0OiB0aGlzLnNldHRpbmdzLnRpdGxlX2xvY2F0aW9uXG5cdFx0XHR9XG5cdFx0fVxuXHRcdHJldHVybiB7XG5cdFx0XHRzY29yZTogNCxcblx0XHRcdHRleHQ6IHRoaXMuc2V0dGluZ3MudGl0bGVfbm9fbG9jYXRpb25cblx0XHR9XG5cdH1cblxuXHQvKipcblx0ICogU2NvcmVzIHRoZSB1cmwgYmFzZWQgb24gdGhlIG1hdGNoZXMgb2YgdGhlIGxvY2F0aW9uJ3MgY2l0eSBpbiBoZWFkaW5ncy5cblx0ICpcblx0ICogQHBhcmFtIHtBcnJheX0gbWF0Y2hlcyBUaGUgbWF0Y2hlcyBpbiB0aGUgdmlkZW8gdGl0bGUuXG5cdCAqXG5cdCAqIEByZXR1cm5zIHt7c2NvcmU6IG51bWJlciwgdGV4dDogKn19IEFuIG9iamVjdCBjb250YWluaW5nIHRoZSBzY29yZSBhbmQgdGV4dFxuXHQgKi9cblx0c2NvcmVIZWFkaW5ncyggbWF0Y2hlcyApIHtcblx0XHRpZiAoIG1hdGNoZXMubGVuZ3RoID4gMCApIHtcblx0XHRcdHJldHVybntcblx0XHRcdFx0c2NvcmU6IDksXG5cdFx0XHRcdHRleHQ6IHRoaXMuc2V0dGluZ3MuaGVhZGluZ19sb2NhdGlvblxuXHRcdFx0fVxuXHRcdH1cblx0XHRyZXR1cm57XG5cdFx0XHRzY29yZTogNCxcblx0XHRcdHRleHQ6IHRoaXMuc2V0dGluZ3MuaGVhZGluZ19ub19sb2NhdGlvblxuXHRcdH1cblx0fVxufVxuIiwiaW1wb3J0IGVzY2FwZVJlZ0V4cCBmcm9tIFwibG9kYXNoL2VzY2FwZVJlZ0V4cFwiO1xuXG5jb25zdCB7IFBhcGVyLCBSZXNlYXJjaGVyLCBBc3Nlc3NtZW50UmVzdWx0LCBBc3Nlc3NtZW50IH0gPSB5b2FzdC5hbmFseXNpcztcblxuZXhwb3J0IGRlZmF1bHQgY2xhc3MgTG9jYWxVcmxBc3Nlc3NtZW50IGV4dGVuZHMgQXNzZXNzbWVudCB7XG5cdGNvbnN0cnVjdG9yKCBzZXR0aW5ncyApIHtcblx0XHRzdXBlcigpO1xuXHRcdHRoaXMuc2V0dGluZ3MgPSBzZXR0aW5ncztcblx0fVxuXG5cdC8qKlxuXHQgKiBSdW5zIGFuIGFzc2Vzc21lbnQgZm9yIHNjb3JpbmcgdGhlIGxvY2F0aW9uIGluIHRoZSBVUkwuXG5cdCAqXG5cdCAqIEBwYXJhbSB7UGFwZXJ9IHBhcGVyIFRoZSBwYXBlciB0byBydW4gdGhpcyBhc3Nlc3NtZW50IG9uLlxuXHQgKiBAcGFyYW0ge1Jlc2VhcmNoZXJ9IHJlc2VhcmNoZXIgVGhlIHJlc2VhcmNoZXIgdXNlZCBmb3IgdGhlIGFzc2Vzc21lbnQuXG5cdCAqIEBwYXJhbSB7T2JqZWN0fSBpMThuIFRoZSBpMThuLW9iamVjdCB1c2VkIGZvciBwYXJzaW5nIHRyYW5zbGF0aW9ucy5cblx0ICpcblx0ICogQHJldHVybnMge29iamVjdH0gYW4gYXNzZXNzbWVudCByZXN1bHQgd2l0aCB0aGUgc2NvcmUgYW5kIGZvcm1hdHRlZCB0ZXh0LlxuXHQgKi9cblx0Z2V0UmVzdWx0KCBwYXBlciwgcmVzZWFyY2hlciwgaTE4biApIHtcblx0XHRjb25zdCBhc3Nlc3NtZW50UmVzdWx0ID0gbmV3IEFzc2Vzc21lbnRSZXN1bHQoKTtcblx0XHRpZiggdGhpcy5zZXR0aW5ncy5sb2NhdGlvbiAhPT0gJycgKSB7XG5cdFx0XHRsZXQgbG9jYXRpb24gPSB0aGlzLnNldHRpbmdzLmxvY2F0aW9uO1xuXHRcdFx0bG9jYXRpb24gPSBsb2NhdGlvbi5yZXBsYWNlKCBcIidcIiwgXCJcIiApLnJlcGxhY2UoIC9cXHMvaWcsIFwiLVwiICk7XG5cdFx0XHRsb2NhdGlvbiA9IGVzY2FwZVJlZ0V4cCggbG9jYXRpb24gKTtcblx0XHRcdGNvbnN0IGJ1c2luZXNzX2NpdHkgPSBuZXcgUmVnRXhwKCBsb2NhdGlvbiwgJ2lnJyApO1xuXHRcdFx0Y29uc3QgbWF0Y2hlcyA9IHBhcGVyLmdldFVybCgpLm1hdGNoKCBidXNpbmVzc19jaXR5ICkgfHwgMDtcblx0XHRcdGNvbnN0IHJlc3VsdCA9IHRoaXMuc2NvcmUoIG1hdGNoZXMgKTtcblx0XHRcdGFzc2Vzc21lbnRSZXN1bHQuc2V0U2NvcmUoIHJlc3VsdC5zY29yZSApO1xuXHRcdFx0YXNzZXNzbWVudFJlc3VsdC5zZXRUZXh0KCByZXN1bHQudGV4dCApO1xuXHRcdH1cblx0XHRyZXR1cm4gYXNzZXNzbWVudFJlc3VsdDtcblx0fVxuXG5cdC8qKlxuXHQgKiBTY29yZXMgdGhlIHVybCBiYXNlZCBvbiB0aGUgbWF0Y2hlcyBvZiB0aGUgbG9jYXRpb24uXG5cdCAqXG5cdCAqIEBwYXJhbSB7QXJyYXl9IG1hdGNoZXMgVGhlIG1hdGNoZXMgaW4gdGhlIHZpZGVvIHRpdGxlLlxuXHQgKlxuXHQgKiBAcmV0dXJucyB7e3Njb3JlOiBudW1iZXIsIHRleHQ6ICp9fSBBbiBvYmplY3QgY29udGFpbmluZyB0aGUgc2NvcmUgYW5kIHRleHRcblx0ICovXG5cdHNjb3JlKCBtYXRjaGVzICkge1xuXHRcdGlmICggbWF0Y2hlcy5sZW5ndGggPiAwICkge1xuXHRcdFx0cmV0dXJue1xuXHRcdFx0XHRzY29yZTogOSxcblx0XHRcdFx0dGV4dDogdGhpcy5zZXR0aW5ncy51cmxfbG9jYXRpb25cblx0XHRcdH1cblx0XHR9XG5cdFx0cmV0dXJue1xuXHRcdFx0c2NvcmU6IDQsXG5cdFx0XHR0ZXh0OiB0aGlzLnNldHRpbmdzLnVybF9ub19sb2NhdGlvblxuXHRcdH1cblx0fVxufVxuIiwiLyogZ2xvYmFsIGFuYWx5c2lzV29ya2VyICovXG5pbXBvcnQgTG9jYWxUaXRsZUFzc2Vzc21lbnQgZnJvbSAnLi9hc3Nlc3NtZW50cy9sb2NhbC10aXRsZS1hc3Nlc3NtZW50JztcbmltcG9ydCBMb2NhbFVybEFzc2Vzc21lbnQgZnJvbSAnLi9hc3Nlc3NtZW50cy9sb2NhbC11cmwtYXNzZXNzbWVudCc7XG5pbXBvcnQgTG9jYWxTY2hlbWFBc3Nlc3NtZW50IGZyb20gJy4vYXNzZXNzbWVudHMvbG9jYWwtc2NoZW1hLWFzc2Vzc21lbnQnO1xuXG5jbGFzcyBMb2NhbExvY2F0aW9uc1dvcmtlciB7XG5cdHJlZ2lzdGVyKCkge1xuXHRcdGFuYWx5c2lzV29ya2VyLnJlZ2lzdGVyTWVzc2FnZUhhbmRsZXIoICdpbml0aWFsaXplTG9jYXRpb25zJywgdGhpcy5pbml0aWFsaXplLmJpbmQoIHRoaXMgKSwgJ1lvYXN0TG9jYWxTRU8nICk7XG5cdH1cblxuXHRpbml0aWFsaXplKCBzZXR0aW5ncyApIHtcblx0XHR0aGlzLnRpdGxlQXNzZXNzbWVudCA9IG5ldyBMb2NhbFRpdGxlQXNzZXNzbWVudCggc2V0dGluZ3MgKTtcblx0XHR0aGlzLnVybEFzc2Vzc21lbnQgPSBuZXcgTG9jYWxVcmxBc3Nlc3NtZW50KCBzZXR0aW5ncyApO1xuXHRcdHRoaXMuc2NoZW1hQXNzZXNzbWVudCA9IG5ldyBMb2NhbFNjaGVtYUFzc2Vzc21lbnQoIHNldHRpbmdzICk7XG5cblx0XHRhbmFseXNpc1dvcmtlci5yZWdpc3RlckFzc2Vzc21lbnQoICdsb2NhbFRpdGxlJywgdGhpcy50aXRsZUFzc2Vzc21lbnQsICdZb2FzdExvY2FsU0VPJyApO1xuXHRcdGFuYWx5c2lzV29ya2VyLnJlZ2lzdGVyQXNzZXNzbWVudCggJ2xvY2FsVXJsJywgdGhpcy51cmxBc3Nlc3NtZW50LCAnWW9hc3RMb2NhbFNFTycgKTtcblx0XHRhbmFseXNpc1dvcmtlci5yZWdpc3RlckFzc2Vzc21lbnQoICdsb2NhbFNjaGVtYScsIHRoaXMuc2NoZW1hQXNzZXNzbWVudCwgJ1lvYXN0TG9jYWxTRU8nICk7XG5cdH1cbn1cblxuY29uc3QgbG9jYWxMb2NhdGlvbnNXb3JrZXIgPSBuZXcgTG9jYWxMb2NhdGlvbnNXb3JrZXIoKTtcblxubG9jYWxMb2NhdGlvbnNXb3JrZXIucmVnaXN0ZXIoKTtcbiIsInZhciByb290ID0gcmVxdWlyZSgnLi9fcm9vdCcpO1xuXG4vKiogQnVpbHQtaW4gdmFsdWUgcmVmZXJlbmNlcy4gKi9cbnZhciBTeW1ib2wgPSByb290LlN5bWJvbDtcblxubW9kdWxlLmV4cG9ydHMgPSBTeW1ib2w7XG4iLCIvKipcbiAqIEEgc3BlY2lhbGl6ZWQgdmVyc2lvbiBvZiBgXy5tYXBgIGZvciBhcnJheXMgd2l0aG91dCBzdXBwb3J0IGZvciBpdGVyYXRlZVxuICogc2hvcnRoYW5kcy5cbiAqXG4gKiBAcHJpdmF0ZVxuICogQHBhcmFtIHtBcnJheX0gW2FycmF5XSBUaGUgYXJyYXkgdG8gaXRlcmF0ZSBvdmVyLlxuICogQHBhcmFtIHtGdW5jdGlvbn0gaXRlcmF0ZWUgVGhlIGZ1bmN0aW9uIGludm9rZWQgcGVyIGl0ZXJhdGlvbi5cbiAqIEByZXR1cm5zIHtBcnJheX0gUmV0dXJucyB0aGUgbmV3IG1hcHBlZCBhcnJheS5cbiAqL1xuZnVuY3Rpb24gYXJyYXlNYXAoYXJyYXksIGl0ZXJhdGVlKSB7XG4gIHZhciBpbmRleCA9IC0xLFxuICAgICAgbGVuZ3RoID0gYXJyYXkgPT0gbnVsbCA/IDAgOiBhcnJheS5sZW5ndGgsXG4gICAgICByZXN1bHQgPSBBcnJheShsZW5ndGgpO1xuXG4gIHdoaWxlICgrK2luZGV4IDwgbGVuZ3RoKSB7XG4gICAgcmVzdWx0W2luZGV4XSA9IGl0ZXJhdGVlKGFycmF5W2luZGV4XSwgaW5kZXgsIGFycmF5KTtcbiAgfVxuICByZXR1cm4gcmVzdWx0O1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGFycmF5TWFwO1xuIiwidmFyIFN5bWJvbCA9IHJlcXVpcmUoJy4vX1N5bWJvbCcpLFxuICAgIGdldFJhd1RhZyA9IHJlcXVpcmUoJy4vX2dldFJhd1RhZycpLFxuICAgIG9iamVjdFRvU3RyaW5nID0gcmVxdWlyZSgnLi9fb2JqZWN0VG9TdHJpbmcnKTtcblxuLyoqIGBPYmplY3QjdG9TdHJpbmdgIHJlc3VsdCByZWZlcmVuY2VzLiAqL1xudmFyIG51bGxUYWcgPSAnW29iamVjdCBOdWxsXScsXG4gICAgdW5kZWZpbmVkVGFnID0gJ1tvYmplY3QgVW5kZWZpbmVkXSc7XG5cbi8qKiBCdWlsdC1pbiB2YWx1ZSByZWZlcmVuY2VzLiAqL1xudmFyIHN5bVRvU3RyaW5nVGFnID0gU3ltYm9sID8gU3ltYm9sLnRvU3RyaW5nVGFnIDogdW5kZWZpbmVkO1xuXG4vKipcbiAqIFRoZSBiYXNlIGltcGxlbWVudGF0aW9uIG9mIGBnZXRUYWdgIHdpdGhvdXQgZmFsbGJhY2tzIGZvciBidWdneSBlbnZpcm9ubWVudHMuXG4gKlxuICogQHByaXZhdGVcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIHF1ZXJ5LlxuICogQHJldHVybnMge3N0cmluZ30gUmV0dXJucyB0aGUgYHRvU3RyaW5nVGFnYC5cbiAqL1xuZnVuY3Rpb24gYmFzZUdldFRhZyh2YWx1ZSkge1xuICBpZiAodmFsdWUgPT0gbnVsbCkge1xuICAgIHJldHVybiB2YWx1ZSA9PT0gdW5kZWZpbmVkID8gdW5kZWZpbmVkVGFnIDogbnVsbFRhZztcbiAgfVxuICByZXR1cm4gKHN5bVRvU3RyaW5nVGFnICYmIHN5bVRvU3RyaW5nVGFnIGluIE9iamVjdCh2YWx1ZSkpXG4gICAgPyBnZXRSYXdUYWcodmFsdWUpXG4gICAgOiBvYmplY3RUb1N0cmluZyh2YWx1ZSk7XG59XG5cbm1vZHVsZS5leHBvcnRzID0gYmFzZUdldFRhZztcbiIsInZhciBTeW1ib2wgPSByZXF1aXJlKCcuL19TeW1ib2wnKSxcbiAgICBhcnJheU1hcCA9IHJlcXVpcmUoJy4vX2FycmF5TWFwJyksXG4gICAgaXNBcnJheSA9IHJlcXVpcmUoJy4vaXNBcnJheScpLFxuICAgIGlzU3ltYm9sID0gcmVxdWlyZSgnLi9pc1N5bWJvbCcpO1xuXG4vKiogVXNlZCBhcyByZWZlcmVuY2VzIGZvciB2YXJpb3VzIGBOdW1iZXJgIGNvbnN0YW50cy4gKi9cbnZhciBJTkZJTklUWSA9IDEgLyAwO1xuXG4vKiogVXNlZCB0byBjb252ZXJ0IHN5bWJvbHMgdG8gcHJpbWl0aXZlcyBhbmQgc3RyaW5ncy4gKi9cbnZhciBzeW1ib2xQcm90byA9IFN5bWJvbCA/IFN5bWJvbC5wcm90b3R5cGUgOiB1bmRlZmluZWQsXG4gICAgc3ltYm9sVG9TdHJpbmcgPSBzeW1ib2xQcm90byA/IHN5bWJvbFByb3RvLnRvU3RyaW5nIDogdW5kZWZpbmVkO1xuXG4vKipcbiAqIFRoZSBiYXNlIGltcGxlbWVudGF0aW9uIG9mIGBfLnRvU3RyaW5nYCB3aGljaCBkb2Vzbid0IGNvbnZlcnQgbnVsbGlzaFxuICogdmFsdWVzIHRvIGVtcHR5IHN0cmluZ3MuXG4gKlxuICogQHByaXZhdGVcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIHByb2Nlc3MuXG4gKiBAcmV0dXJucyB7c3RyaW5nfSBSZXR1cm5zIHRoZSBzdHJpbmcuXG4gKi9cbmZ1bmN0aW9uIGJhc2VUb1N0cmluZyh2YWx1ZSkge1xuICAvLyBFeGl0IGVhcmx5IGZvciBzdHJpbmdzIHRvIGF2b2lkIGEgcGVyZm9ybWFuY2UgaGl0IGluIHNvbWUgZW52aXJvbm1lbnRzLlxuICBpZiAodHlwZW9mIHZhbHVlID09ICdzdHJpbmcnKSB7XG4gICAgcmV0dXJuIHZhbHVlO1xuICB9XG4gIGlmIChpc0FycmF5KHZhbHVlKSkge1xuICAgIC8vIFJlY3Vyc2l2ZWx5IGNvbnZlcnQgdmFsdWVzIChzdXNjZXB0aWJsZSB0byBjYWxsIHN0YWNrIGxpbWl0cykuXG4gICAgcmV0dXJuIGFycmF5TWFwKHZhbHVlLCBiYXNlVG9TdHJpbmcpICsgJyc7XG4gIH1cbiAgaWYgKGlzU3ltYm9sKHZhbHVlKSkge1xuICAgIHJldHVybiBzeW1ib2xUb1N0cmluZyA/IHN5bWJvbFRvU3RyaW5nLmNhbGwodmFsdWUpIDogJyc7XG4gIH1cbiAgdmFyIHJlc3VsdCA9ICh2YWx1ZSArICcnKTtcbiAgcmV0dXJuIChyZXN1bHQgPT0gJzAnICYmICgxIC8gdmFsdWUpID09IC1JTkZJTklUWSkgPyAnLTAnIDogcmVzdWx0O1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGJhc2VUb1N0cmluZztcbiIsIi8qKiBEZXRlY3QgZnJlZSB2YXJpYWJsZSBgZ2xvYmFsYCBmcm9tIE5vZGUuanMuICovXG52YXIgZnJlZUdsb2JhbCA9IHR5cGVvZiBnbG9iYWwgPT0gJ29iamVjdCcgJiYgZ2xvYmFsICYmIGdsb2JhbC5PYmplY3QgPT09IE9iamVjdCAmJiBnbG9iYWw7XG5cbm1vZHVsZS5leHBvcnRzID0gZnJlZUdsb2JhbDtcbiIsInZhciBTeW1ib2wgPSByZXF1aXJlKCcuL19TeW1ib2wnKTtcblxuLyoqIFVzZWQgZm9yIGJ1aWx0LWluIG1ldGhvZCByZWZlcmVuY2VzLiAqL1xudmFyIG9iamVjdFByb3RvID0gT2JqZWN0LnByb3RvdHlwZTtcblxuLyoqIFVzZWQgdG8gY2hlY2sgb2JqZWN0cyBmb3Igb3duIHByb3BlcnRpZXMuICovXG52YXIgaGFzT3duUHJvcGVydHkgPSBvYmplY3RQcm90by5oYXNPd25Qcm9wZXJ0eTtcblxuLyoqXG4gKiBVc2VkIHRvIHJlc29sdmUgdGhlXG4gKiBbYHRvU3RyaW5nVGFnYF0oaHR0cDovL2VjbWEtaW50ZXJuYXRpb25hbC5vcmcvZWNtYS0yNjIvNy4wLyNzZWMtb2JqZWN0LnByb3RvdHlwZS50b3N0cmluZylcbiAqIG9mIHZhbHVlcy5cbiAqL1xudmFyIG5hdGl2ZU9iamVjdFRvU3RyaW5nID0gb2JqZWN0UHJvdG8udG9TdHJpbmc7XG5cbi8qKiBCdWlsdC1pbiB2YWx1ZSByZWZlcmVuY2VzLiAqL1xudmFyIHN5bVRvU3RyaW5nVGFnID0gU3ltYm9sID8gU3ltYm9sLnRvU3RyaW5nVGFnIDogdW5kZWZpbmVkO1xuXG4vKipcbiAqIEEgc3BlY2lhbGl6ZWQgdmVyc2lvbiBvZiBgYmFzZUdldFRhZ2Agd2hpY2ggaWdub3JlcyBgU3ltYm9sLnRvU3RyaW5nVGFnYCB2YWx1ZXMuXG4gKlxuICogQHByaXZhdGVcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIHF1ZXJ5LlxuICogQHJldHVybnMge3N0cmluZ30gUmV0dXJucyB0aGUgcmF3IGB0b1N0cmluZ1RhZ2AuXG4gKi9cbmZ1bmN0aW9uIGdldFJhd1RhZyh2YWx1ZSkge1xuICB2YXIgaXNPd24gPSBoYXNPd25Qcm9wZXJ0eS5jYWxsKHZhbHVlLCBzeW1Ub1N0cmluZ1RhZyksXG4gICAgICB0YWcgPSB2YWx1ZVtzeW1Ub1N0cmluZ1RhZ107XG5cbiAgdHJ5IHtcbiAgICB2YWx1ZVtzeW1Ub1N0cmluZ1RhZ10gPSB1bmRlZmluZWQ7XG4gICAgdmFyIHVubWFza2VkID0gdHJ1ZTtcbiAgfSBjYXRjaCAoZSkge31cblxuICB2YXIgcmVzdWx0ID0gbmF0aXZlT2JqZWN0VG9TdHJpbmcuY2FsbCh2YWx1ZSk7XG4gIGlmICh1bm1hc2tlZCkge1xuICAgIGlmIChpc093bikge1xuICAgICAgdmFsdWVbc3ltVG9TdHJpbmdUYWddID0gdGFnO1xuICAgIH0gZWxzZSB7XG4gICAgICBkZWxldGUgdmFsdWVbc3ltVG9TdHJpbmdUYWddO1xuICAgIH1cbiAgfVxuICByZXR1cm4gcmVzdWx0O1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGdldFJhd1RhZztcbiIsIi8qKiBVc2VkIGZvciBidWlsdC1pbiBtZXRob2QgcmVmZXJlbmNlcy4gKi9cbnZhciBvYmplY3RQcm90byA9IE9iamVjdC5wcm90b3R5cGU7XG5cbi8qKlxuICogVXNlZCB0byByZXNvbHZlIHRoZVxuICogW2B0b1N0cmluZ1RhZ2BdKGh0dHA6Ly9lY21hLWludGVybmF0aW9uYWwub3JnL2VjbWEtMjYyLzcuMC8jc2VjLW9iamVjdC5wcm90b3R5cGUudG9zdHJpbmcpXG4gKiBvZiB2YWx1ZXMuXG4gKi9cbnZhciBuYXRpdmVPYmplY3RUb1N0cmluZyA9IG9iamVjdFByb3RvLnRvU3RyaW5nO1xuXG4vKipcbiAqIENvbnZlcnRzIGB2YWx1ZWAgdG8gYSBzdHJpbmcgdXNpbmcgYE9iamVjdC5wcm90b3R5cGUudG9TdHJpbmdgLlxuICpcbiAqIEBwcml2YXRlXG4gKiBAcGFyYW0geyp9IHZhbHVlIFRoZSB2YWx1ZSB0byBjb252ZXJ0LlxuICogQHJldHVybnMge3N0cmluZ30gUmV0dXJucyB0aGUgY29udmVydGVkIHN0cmluZy5cbiAqL1xuZnVuY3Rpb24gb2JqZWN0VG9TdHJpbmcodmFsdWUpIHtcbiAgcmV0dXJuIG5hdGl2ZU9iamVjdFRvU3RyaW5nLmNhbGwodmFsdWUpO1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IG9iamVjdFRvU3RyaW5nO1xuIiwidmFyIGZyZWVHbG9iYWwgPSByZXF1aXJlKCcuL19mcmVlR2xvYmFsJyk7XG5cbi8qKiBEZXRlY3QgZnJlZSB2YXJpYWJsZSBgc2VsZmAuICovXG52YXIgZnJlZVNlbGYgPSB0eXBlb2Ygc2VsZiA9PSAnb2JqZWN0JyAmJiBzZWxmICYmIHNlbGYuT2JqZWN0ID09PSBPYmplY3QgJiYgc2VsZjtcblxuLyoqIFVzZWQgYXMgYSByZWZlcmVuY2UgdG8gdGhlIGdsb2JhbCBvYmplY3QuICovXG52YXIgcm9vdCA9IGZyZWVHbG9iYWwgfHwgZnJlZVNlbGYgfHwgRnVuY3Rpb24oJ3JldHVybiB0aGlzJykoKTtcblxubW9kdWxlLmV4cG9ydHMgPSByb290O1xuIiwidmFyIHRvU3RyaW5nID0gcmVxdWlyZSgnLi90b1N0cmluZycpO1xuXG4vKipcbiAqIFVzZWQgdG8gbWF0Y2ggYFJlZ0V4cGBcbiAqIFtzeW50YXggY2hhcmFjdGVyc10oaHR0cDovL2VjbWEtaW50ZXJuYXRpb25hbC5vcmcvZWNtYS0yNjIvNy4wLyNzZWMtcGF0dGVybnMpLlxuICovXG52YXIgcmVSZWdFeHBDaGFyID0gL1tcXFxcXiQuKis/KClbXFxde318XS9nLFxuICAgIHJlSGFzUmVnRXhwQ2hhciA9IFJlZ0V4cChyZVJlZ0V4cENoYXIuc291cmNlKTtcblxuLyoqXG4gKiBFc2NhcGVzIHRoZSBgUmVnRXhwYCBzcGVjaWFsIGNoYXJhY3RlcnMgXCJeXCIsIFwiJFwiLCBcIlxcXCIsIFwiLlwiLCBcIipcIiwgXCIrXCIsXG4gKiBcIj9cIiwgXCIoXCIsIFwiKVwiLCBcIltcIiwgXCJdXCIsIFwie1wiLCBcIn1cIiwgYW5kIFwifFwiIGluIGBzdHJpbmdgLlxuICpcbiAqIEBzdGF0aWNcbiAqIEBtZW1iZXJPZiBfXG4gKiBAc2luY2UgMy4wLjBcbiAqIEBjYXRlZ29yeSBTdHJpbmdcbiAqIEBwYXJhbSB7c3RyaW5nfSBbc3RyaW5nPScnXSBUaGUgc3RyaW5nIHRvIGVzY2FwZS5cbiAqIEByZXR1cm5zIHtzdHJpbmd9IFJldHVybnMgdGhlIGVzY2FwZWQgc3RyaW5nLlxuICogQGV4YW1wbGVcbiAqXG4gKiBfLmVzY2FwZVJlZ0V4cCgnW2xvZGFzaF0oaHR0cHM6Ly9sb2Rhc2guY29tLyknKTtcbiAqIC8vID0+ICdcXFtsb2Rhc2hcXF1cXChodHRwczovL2xvZGFzaFxcLmNvbS9cXCknXG4gKi9cbmZ1bmN0aW9uIGVzY2FwZVJlZ0V4cChzdHJpbmcpIHtcbiAgc3RyaW5nID0gdG9TdHJpbmcoc3RyaW5nKTtcbiAgcmV0dXJuIChzdHJpbmcgJiYgcmVIYXNSZWdFeHBDaGFyLnRlc3Qoc3RyaW5nKSlcbiAgICA/IHN0cmluZy5yZXBsYWNlKHJlUmVnRXhwQ2hhciwgJ1xcXFwkJicpXG4gICAgOiBzdHJpbmc7XG59XG5cbm1vZHVsZS5leHBvcnRzID0gZXNjYXBlUmVnRXhwO1xuIiwiLyoqXG4gKiBDaGVja3MgaWYgYHZhbHVlYCBpcyBjbGFzc2lmaWVkIGFzIGFuIGBBcnJheWAgb2JqZWN0LlxuICpcbiAqIEBzdGF0aWNcbiAqIEBtZW1iZXJPZiBfXG4gKiBAc2luY2UgMC4xLjBcbiAqIEBjYXRlZ29yeSBMYW5nXG4gKiBAcGFyYW0geyp9IHZhbHVlIFRoZSB2YWx1ZSB0byBjaGVjay5cbiAqIEByZXR1cm5zIHtib29sZWFufSBSZXR1cm5zIGB0cnVlYCBpZiBgdmFsdWVgIGlzIGFuIGFycmF5LCBlbHNlIGBmYWxzZWAuXG4gKiBAZXhhbXBsZVxuICpcbiAqIF8uaXNBcnJheShbMSwgMiwgM10pO1xuICogLy8gPT4gdHJ1ZVxuICpcbiAqIF8uaXNBcnJheShkb2N1bWVudC5ib2R5LmNoaWxkcmVuKTtcbiAqIC8vID0+IGZhbHNlXG4gKlxuICogXy5pc0FycmF5KCdhYmMnKTtcbiAqIC8vID0+IGZhbHNlXG4gKlxuICogXy5pc0FycmF5KF8ubm9vcCk7XG4gKiAvLyA9PiBmYWxzZVxuICovXG52YXIgaXNBcnJheSA9IEFycmF5LmlzQXJyYXk7XG5cbm1vZHVsZS5leHBvcnRzID0gaXNBcnJheTtcbiIsIi8qKlxuICogQ2hlY2tzIGlmIGB2YWx1ZWAgaXMgb2JqZWN0LWxpa2UuIEEgdmFsdWUgaXMgb2JqZWN0LWxpa2UgaWYgaXQncyBub3QgYG51bGxgXG4gKiBhbmQgaGFzIGEgYHR5cGVvZmAgcmVzdWx0IG9mIFwib2JqZWN0XCIuXG4gKlxuICogQHN0YXRpY1xuICogQG1lbWJlck9mIF9cbiAqIEBzaW5jZSA0LjAuMFxuICogQGNhdGVnb3J5IExhbmdcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIGNoZWNrLlxuICogQHJldHVybnMge2Jvb2xlYW59IFJldHVybnMgYHRydWVgIGlmIGB2YWx1ZWAgaXMgb2JqZWN0LWxpa2UsIGVsc2UgYGZhbHNlYC5cbiAqIEBleGFtcGxlXG4gKlxuICogXy5pc09iamVjdExpa2Uoe30pO1xuICogLy8gPT4gdHJ1ZVxuICpcbiAqIF8uaXNPYmplY3RMaWtlKFsxLCAyLCAzXSk7XG4gKiAvLyA9PiB0cnVlXG4gKlxuICogXy5pc09iamVjdExpa2UoXy5ub29wKTtcbiAqIC8vID0+IGZhbHNlXG4gKlxuICogXy5pc09iamVjdExpa2UobnVsbCk7XG4gKiAvLyA9PiBmYWxzZVxuICovXG5mdW5jdGlvbiBpc09iamVjdExpa2UodmFsdWUpIHtcbiAgcmV0dXJuIHZhbHVlICE9IG51bGwgJiYgdHlwZW9mIHZhbHVlID09ICdvYmplY3QnO1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGlzT2JqZWN0TGlrZTtcbiIsInZhciBiYXNlR2V0VGFnID0gcmVxdWlyZSgnLi9fYmFzZUdldFRhZycpLFxuICAgIGlzT2JqZWN0TGlrZSA9IHJlcXVpcmUoJy4vaXNPYmplY3RMaWtlJyk7XG5cbi8qKiBgT2JqZWN0I3RvU3RyaW5nYCByZXN1bHQgcmVmZXJlbmNlcy4gKi9cbnZhciBzeW1ib2xUYWcgPSAnW29iamVjdCBTeW1ib2xdJztcblxuLyoqXG4gKiBDaGVja3MgaWYgYHZhbHVlYCBpcyBjbGFzc2lmaWVkIGFzIGEgYFN5bWJvbGAgcHJpbWl0aXZlIG9yIG9iamVjdC5cbiAqXG4gKiBAc3RhdGljXG4gKiBAbWVtYmVyT2YgX1xuICogQHNpbmNlIDQuMC4wXG4gKiBAY2F0ZWdvcnkgTGFuZ1xuICogQHBhcmFtIHsqfSB2YWx1ZSBUaGUgdmFsdWUgdG8gY2hlY2suXG4gKiBAcmV0dXJucyB7Ym9vbGVhbn0gUmV0dXJucyBgdHJ1ZWAgaWYgYHZhbHVlYCBpcyBhIHN5bWJvbCwgZWxzZSBgZmFsc2VgLlxuICogQGV4YW1wbGVcbiAqXG4gKiBfLmlzU3ltYm9sKFN5bWJvbC5pdGVyYXRvcik7XG4gKiAvLyA9PiB0cnVlXG4gKlxuICogXy5pc1N5bWJvbCgnYWJjJyk7XG4gKiAvLyA9PiBmYWxzZVxuICovXG5mdW5jdGlvbiBpc1N5bWJvbCh2YWx1ZSkge1xuICByZXR1cm4gdHlwZW9mIHZhbHVlID09ICdzeW1ib2wnIHx8XG4gICAgKGlzT2JqZWN0TGlrZSh2YWx1ZSkgJiYgYmFzZUdldFRhZyh2YWx1ZSkgPT0gc3ltYm9sVGFnKTtcbn1cblxubW9kdWxlLmV4cG9ydHMgPSBpc1N5bWJvbDtcbiIsInZhciBiYXNlVG9TdHJpbmcgPSByZXF1aXJlKCcuL19iYXNlVG9TdHJpbmcnKTtcblxuLyoqXG4gKiBDb252ZXJ0cyBgdmFsdWVgIHRvIGEgc3RyaW5nLiBBbiBlbXB0eSBzdHJpbmcgaXMgcmV0dXJuZWQgZm9yIGBudWxsYFxuICogYW5kIGB1bmRlZmluZWRgIHZhbHVlcy4gVGhlIHNpZ24gb2YgYC0wYCBpcyBwcmVzZXJ2ZWQuXG4gKlxuICogQHN0YXRpY1xuICogQG1lbWJlck9mIF9cbiAqIEBzaW5jZSA0LjAuMFxuICogQGNhdGVnb3J5IExhbmdcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIGNvbnZlcnQuXG4gKiBAcmV0dXJucyB7c3RyaW5nfSBSZXR1cm5zIHRoZSBjb252ZXJ0ZWQgc3RyaW5nLlxuICogQGV4YW1wbGVcbiAqXG4gKiBfLnRvU3RyaW5nKG51bGwpO1xuICogLy8gPT4gJydcbiAqXG4gKiBfLnRvU3RyaW5nKC0wKTtcbiAqIC8vID0+ICctMCdcbiAqXG4gKiBfLnRvU3RyaW5nKFsxLCAyLCAzXSk7XG4gKiAvLyA9PiAnMSwyLDMnXG4gKi9cbmZ1bmN0aW9uIHRvU3RyaW5nKHZhbHVlKSB7XG4gIHJldHVybiB2YWx1ZSA9PSBudWxsID8gJycgOiBiYXNlVG9TdHJpbmcodmFsdWUpO1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IHRvU3RyaW5nO1xuIl19
