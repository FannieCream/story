<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Game of Thrones Network</title>
  <link href="https://fonts.font.im/css?family=Love+Ya+Like+A+Sister" rel="stylesheet">
  <link href="https://fonts.font.im/css?family=Love+Ya+Like+A+Sister|Luckiest+Guy" rel="stylesheet">
  <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-select.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" >
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css')}}">
  <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://d3js.org/d3.v4.min.js"></script>
  <script type="text/javascript" src="{{ URL::asset('js/bootstrap-select.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}"></script>
<script>
  (function() {
  // If window.HTMLWidgets is already defined, then use it; otherwise create a
  // new object. This allows preceding code to set options that affect the
  // initialization process (though none currently exist).
  window.HTMLWidgets = window.HTMLWidgets || {};

  // See if we're running in a viewer pane. If not, we're in a web browser.
  var viewerMode = window.HTMLWidgets.viewerMode =
      /\bviewer_pane=1\b/.test(window.location);

  // See if we're running in Shiny mode. If not, it's a static document.
  // Note that static widgets can appear in both Shiny and static modes, but
  // obviously, Shiny widgets can only appear in Shiny apps/documents.
  var shinyMode = window.HTMLWidgets.shinyMode =
      typeof(window.Shiny) !== "undefined" && !!window.Shiny.outputBindings;

  // We can't count on jQuery being available, so we implement our own
  // version if necessary.
  function querySelectorAll(scope, selector) {
    if (typeof(jQuery) !== "undefined" && scope instanceof jQuery) {
      return scope.find(selector);
    }
    if (scope.querySelectorAll) {
      return scope.querySelectorAll(selector);
    }
  }

  function asArray(value) {
    if (value === null)
      return [];
    if ($.isArray(value))
      return value;
    return [value];
  }

  // Implement jQuery's extend
  function extend(target /*, ... */) {
    if (arguments.length == 1) {
      return target;
    }
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var prop in source) {
        if (source.hasOwnProperty(prop)) {
          target[prop] = source[prop];
        }
      }
    }
    return target;
  }

  // IE8 doesn't support Array.forEach.
  function forEach(values, callback, thisArg) {
    if (values.forEach) {
      values.forEach(callback, thisArg);
    } else {
      for (var i = 0; i < values.length; i++) {
        callback.call(thisArg, values[i], i, values);
      }
    }
  }

  // Replaces the specified method with the return value of funcSource.
  //
  // Note that funcSource should not BE the new method, it should be a function
  // that RETURNS the new method. funcSource receives a single argument that is
  // the overridden method, it can be called from the new method. The overridden
  // method can be called like a regular function, it has the target permanently
  // bound to it so "this" will work correctly.
  function overrideMethod(target, methodName, funcSource) {
    var superFunc = target[methodName] || function() {};
    var superFuncBound = function() {
      return superFunc.apply(target, arguments);
    };
    target[methodName] = funcSource(superFuncBound);
  }

  // Add a method to delegator that, when invoked, calls
  // delegatee.methodName. If there is no such method on
  // the delegatee, but there was one on delegator before
  // delegateMethod was called, then the original version
  // is invoked instead.
  // For example:
  //
  // var a = {
  //   method1: function() { console.log('a1'); }
  //   method2: function() { console.log('a2'); }
  // };
  // var b = {
  //   method1: function() { console.log('b1'); }
  // };
  // delegateMethod(a, b, "method1");
  // delegateMethod(a, b, "method2");
  // a.method1();
  // a.method2();
  //
  // The output would be "b1", "a2".
  function delegateMethod(delegator, delegatee, methodName) {
    var inherited = delegator[methodName];
    delegator[methodName] = function() {
      var target = delegatee;
      var method = delegatee[methodName];

      // The method doesn't exist on the delegatee. Instead,
      // call the method on the delegator, if it exists.
      if (!method) {
        target = delegator;
        method = inherited;
      }

      if (method) {
        return method.apply(target, arguments);
      }
    };
  }

  // Implement a vague facsimilie of jQuery's data method
  function elementData(el, name, value) {
    if (arguments.length == 2) {
      return el["htmlwidget_data_" + name];
    } else if (arguments.length == 3) {
      el["htmlwidget_data_" + name] = value;
      return el;
    } else {
      throw new Error("Wrong number of arguments for elementData: " +
        arguments.length);
    }
  }

  // http://stackoverflow.com/questions/3446170/escape-string-for-use-in-javascript-regex
  function escapeRegExp(str) {
    return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
  }

  function hasClass(el, className) {
    var re = new RegExp("\\b" + escapeRegExp(className) + "\\b");
    return re.test(el.className);
  }

  // elements - array (or array-like object) of HTML elements
  // className - class name to test for
  // include - if true, only return elements with given className;
  //   if false, only return elements *without* given className
  function filterByClass(elements, className, include) {
    var results = [];
    for (var i = 0; i < elements.length; i++) {
      if (hasClass(elements[i], className) == include)
        results.push(elements[i]);
    }
    return results;
  }

  function on(obj, eventName, func) {
    if (obj.addEventListener) {
      obj.addEventListener(eventName, func, false);
    } else if (obj.attachEvent) {
      obj.attachEvent(eventName, func);
    }
  }

  function off(obj, eventName, func) {
    if (obj.removeEventListener)
      obj.removeEventListener(eventName, func, false);
    else if (obj.detachEvent) {
      obj.detachEvent(eventName, func);
    }
  }

  // Translate array of values to top/right/bottom/left, as usual with
  // the "padding" CSS property
  // https://developer.mozilla.org/en-US/docs/Web/CSS/padding
  function unpackPadding(value) {
    if (typeof(value) === "number")
      value = [value];
    if (value.length === 1) {
      return {top: value[0], right: value[0], bottom: value[0], left: value[0]};
    }
    if (value.length === 2) {
      return {top: value[0], right: value[1], bottom: value[0], left: value[1]};
    }
    if (value.length === 3) {
      return {top: value[0], right: value[1], bottom: value[2], left: value[1]};
    }
    if (value.length === 4) {
      return {top: value[0], right: value[1], bottom: value[2], left: value[3]};
    }
  }

  // Convert an unpacked padding object to a CSS value
  function paddingToCss(paddingObj) {
    return paddingObj.top + "px " + paddingObj.right + "px " + paddingObj.bottom + "px " + paddingObj.left + "px";
  }

  // Makes a number suitable for CSS
  function px(x) {
    if (typeof(x) === "number")
      return x + "px";
    else
      return x;
  }

  // Retrieves runtime widget sizing information for an element.
  // The return value is either null, or an object with fill, padding,
  // defaultWidth, defaultHeight fields.
  function sizingPolicy(el) {
    var sizingEl = document.querySelector("script[data-for='" + el.id + "'][type='application/htmlwidget-sizing']");
    if (!sizingEl)
      return null;
    var sp = JSON.parse(sizingEl.textContent || sizingEl.text || "{}");
    if (viewerMode) {
      return sp.viewer;
    } else {
      return sp.browser;
    }
  }

  // @param tasks Array of strings (or falsy value, in which case no-op).
  //   Each element must be a valid JavaScript expression that yields a
  //   function. Or, can be an array of objects with "code" and "data"
  //   properties; in this case, the "code" property should be a string
  //   of JS that's an expr that yields a function, and "data" should be
  //   an object that will be added as an additional argument when that
  //   function is called.
  // @param target The object that will be "this" for each function
  //   execution.
  // @param args Array of arguments to be passed to the functions. (The
  //   same arguments will be passed to all functions.)
  function evalAndRun(tasks, target, args) {
    if (tasks) {
      forEach(tasks, function(task) {
        var theseArgs = args;
        if (typeof(task) === "object") {
          theseArgs = theseArgs.concat([task.data]);
          task = task.code;
        }
        var taskFunc = tryEval(task);
        if (typeof(taskFunc) !== "function") {
          throw new Error("Task must be a function! Source:\n" + task);
        }
        taskFunc.apply(target, theseArgs);
      });
    }
  }

  // Attempt eval() both with and without enclosing in parentheses.
  // Note that enclosing coerces a function declaration into
  // an expression that eval() can parse
  // (otherwise, a SyntaxError is thrown)
  function tryEval(code) {
    var result = null;
    try {
      result = eval(code);
    } catch(error) {
      if (!error instanceof SyntaxError) {
        throw error;
      }
      try {
        result = eval("(" + code + ")");
      } catch(e) {
        if (e instanceof SyntaxError) {
          throw error;
        } else {
          throw e;
        }
      }
    }
    return result;
  }

  function initSizing(el) {
    var sizing = sizingPolicy(el);
    if (!sizing)
      return;

    var cel = document.getElementById("htmlwidget_container");
    if (!cel)
      return;

    if (typeof(sizing.padding) !== "undefined") {
      document.body.style.margin = "0";
      document.body.style.padding = paddingToCss(unpackPadding(sizing.padding));
    }

    if (sizing.fill) {
      document.body.style.overflow = "hidden";
      document.body.style.width = "100%";
      document.body.style.height = "100%";
      document.documentElement.style.width = "100%";
      document.documentElement.style.height = "100%";
      if (cel) {
        cel.style.position = "absolute";
        var pad = unpackPadding(sizing.padding);
        cel.style.top = pad.top + "px";
        cel.style.right = pad.right + "px";
        cel.style.bottom = pad.bottom + "px";
        cel.style.left = pad.left + "px";
        el.style.width = "100%";
        el.style.height = "100%";
      }

      return {
        getWidth: function() { return cel.offsetWidth; },
        getHeight: function() { return cel.offsetHeight; }
      };

    } else {
      el.style.width = px(sizing.width);
      el.style.height = px(sizing.height);

      return {
        getWidth: function() { return el.offsetWidth; },
        getHeight: function() { return el.offsetHeight; }
      };
    }
  }

  // Default implementations for methods
  var defaults = {
    find: function(scope) {
      return querySelectorAll(scope, "." + this.name);
    },
    renderError: function(el, err) {
      var $el = $(el);

      this.clearError(el);

      // Add all these error classes, as Shiny does
      var errClass = "shiny-output-error";
      if (err.type !== null) {
        // use the classes of the error condition as CSS class names
        errClass = errClass + " " + $.map(asArray(err.type), function(type) {
          return errClass + "-" + type;
        }).join(" ");
      }
      errClass = errClass + " htmlwidgets-error";

      // Is el inline or block? If inline or inline-block, just display:none it
      // and add an inline error.
      var display = $el.css("display");
      $el.data("restore-display-mode", display);

      if (display === "inline" || display === "inline-block") {
        $el.hide();
        if (err.message !== "") {
          var errorSpan = $("<span>").addClass(errClass);
          errorSpan.text(err.message);
          $el.after(errorSpan);
        }
      } else if (display === "block") {
        // If block, add an error just after the el, set visibility:none on the
        // el, and position the error to be on top of the el.
        // Mark it with a unique ID and CSS class so we can remove it later.
        $el.css("visibility", "hidden");
        if (err.message !== "") {
          var errorDiv = $("<div>").addClass(errClass).css("position", "absolute")
            .css("top", el.offsetTop)
            .css("left", el.offsetLeft)
            // setting width can push out the page size, forcing otherwise
            // unnecessary scrollbars to appear and making it impossible for
            // the element to shrink; so use max-width instead
            .css("maxWidth", el.offsetWidth)
            .css("height", el.offsetHeight);
          errorDiv.text(err.message);
          $el.after(errorDiv);

          // Really dumb way to keep the size/position of the error in sync with
          // the parent element as the window is resized or whatever.
          var intId = setInterval(function() {
            if (!errorDiv[0].parentElement) {
              clearInterval(intId);
              return;
            }
            errorDiv
              .css("top", el.offsetTop)
              .css("left", el.offsetLeft)
              .css("maxWidth", el.offsetWidth)
              .css("height", el.offsetHeight);
          }, 500);
        }
      }
    },
    clearError: function(el) {
      var $el = $(el);
      var display = $el.data("restore-display-mode");
      $el.data("restore-display-mode", null);

      if (display === "inline" || display === "inline-block") {
        if (display)
          $el.css("display", display);
        $(el.nextSibling).filter(".htmlwidgets-error").remove();
      } else if (display === "block"){
        $el.css("visibility", "inherit");
        $(el.nextSibling).filter(".htmlwidgets-error").remove();
      }
    },
    sizing: {}
  };

  // Called by widget bindings to register a new type of widget. The definition
  // object can contain the following properties:
  // - name (required) - A string indicating the binding name, which will be
  //   used by default as the CSS classname to look for.
  // - initialize (optional) - A function(el) that will be called once per
  //   widget element; if a value is returned, it will be passed as the third
  //   value to renderValue.
  // - renderValue (required) - A function(el, data, initValue) that will be
  //   called with data. Static contexts will cause this to be called once per
  //   element; Shiny apps will cause this to be called multiple times per
  //   element, as the data changes.
  window.HTMLWidgets.widget = function(definition) {
    if (!definition.name) {
      throw new Error("Widget must have a name");
    }
    if (!definition.type) {
      throw new Error("Widget must have a type");
    }
    // Currently we only support output widgets
    if (definition.type !== "output") {
      throw new Error("Unrecognized widget type '" + definition.type + "'");
    }
    // TODO: Verify that .name is a valid CSS classname

    // Support new-style instance-bound definitions. Old-style class-bound
    // definitions have one widget "object" per widget per type/class of
    // widget; the renderValue and resize methods on such widget objects
    // take el and instance arguments, because the widget object can't
    // store them. New-style instance-bound definitions have one widget
    // object per widget instance; the definition that's passed in doesn't
    // provide renderValue or resize methods at all, just the single method
    //   factory(el, width, height)
    // which returns an object that has renderValue(x) and resize(w, h).
    // This enables a far more natural programming style for the widget
    // author, who can store per-instance state using either OO-style
    // instance fields or functional-style closure variables (I guess this
    // is in contrast to what can only be called C-style pseudo-OO which is
    // what we required before).
    if (definition.factory) {
      definition = createLegacyDefinitionAdapter(definition);
    }

    if (!definition.renderValue) {
      throw new Error("Widget must have a renderValue function");
    }

    // For static rendering (non-Shiny), use a simple widget registration
    // scheme. We also use this scheme for Shiny apps/documents that also
    // contain static widgets.
    window.HTMLWidgets.widgets = window.HTMLWidgets.widgets || [];
    // Merge defaults into the definition; don't mutate the original definition.
    var staticBinding = extend({}, defaults, definition);
    overrideMethod(staticBinding, "find", function(superfunc) {
      return function(scope) {
        var results = superfunc(scope);
        // Filter out Shiny outputs, we only want the static kind
        return filterByClass(results, "html-widget-output", false);
      };
    });
    window.HTMLWidgets.widgets.push(staticBinding);

    if (shinyMode) {
      // Shiny is running. Register the definition with an output binding.
      // The definition itself will not be the output binding, instead
      // we will make an output binding object that delegates to the
      // definition. This is because we foolishly used the same method
      // name (renderValue) for htmlwidgets definition and Shiny bindings
      // but they actually have quite different semantics (the Shiny
      // bindings receive data that includes lots of metadata that it
      // strips off before calling htmlwidgets renderValue). We can't
      // just ignore the difference because in some widgets it's helpful
      // to call this.renderValue() from inside of resize(), and if
      // we're not delegating, then that call will go to the Shiny
      // version instead of the htmlwidgets version.

      // Merge defaults with definition, without mutating either.
      var bindingDef = extend({}, defaults, definition);

      // This object will be our actual Shiny binding.
      var shinyBinding = new Shiny.OutputBinding();

      // With a few exceptions, we'll want to simply use the bindingDef's
      // version of methods if they are available, otherwise fall back to
      // Shiny's defaults. NOTE: If Shiny's output bindings gain additional
      // methods in the future, and we want them to be overrideable by
      // HTMLWidget binding definitions, then we'll need to add them to this
      // list.
      delegateMethod(shinyBinding, bindingDef, "getId");
      delegateMethod(shinyBinding, bindingDef, "onValueChange");
      delegateMethod(shinyBinding, bindingDef, "onValueError");
      delegateMethod(shinyBinding, bindingDef, "renderError");
      delegateMethod(shinyBinding, bindingDef, "clearError");
      delegateMethod(shinyBinding, bindingDef, "showProgress");

      // The find, renderValue, and resize are handled differently, because we
      // want to actually decorate the behavior of the bindingDef methods.

      shinyBinding.find = function(scope) {
        var results = bindingDef.find(scope);

        // Only return elements that are Shiny outputs, not static ones
        var dynamicResults = results.filter(".html-widget-output");

        // It's possible that whatever caused Shiny to think there might be
        // new dynamic outputs, also caused there to be new static outputs.
        // Since there might be lots of different htmlwidgets bindings, we
        // schedule execution for later--no need to staticRender multiple
        // times.
        if (results.length !== dynamicResults.length)
          scheduleStaticRender();

        return dynamicResults;
      };

      // Wrap renderValue to handle initialization, which unfortunately isn't
      // supported natively by Shiny at the time of this writing.

      shinyBinding.renderValue = function(el, data) {
        Shiny.renderDependencies(data.deps);
        // Resolve strings marked as javascript literals to objects
        if (!(data.evals instanceof Array)) data.evals = [data.evals];
        for (var i = 0; data.evals && i < data.evals.length; i++) {
          window.HTMLWidgets.evaluateStringMember(data.x, data.evals[i]);
        }
        if (!bindingDef.renderOnNullValue) {
          if (data.x === null) {
            el.style.visibility = "hidden";
            return;
          } else {
            el.style.visibility = "inherit";
          }
        }
        if (!elementData(el, "initialized")) {
          initSizing(el);

          elementData(el, "initialized", true);
          if (bindingDef.initialize) {
            var result = bindingDef.initialize(el, el.offsetWidth,
              el.offsetHeight);
            elementData(el, "init_result", result);
          }
        }
        bindingDef.renderValue(el, data.x, elementData(el, "init_result"));
        evalAndRun(data.jsHooks.render, elementData(el, "init_result"), [el, data.x]);
      };

      // Only override resize if bindingDef implements it
      if (bindingDef.resize) {
        shinyBinding.resize = function(el, width, height) {
          // Shiny can call resize before initialize/renderValue have been
          // called, which doesn't make sense for widgets.
          if (elementData(el, "initialized")) {
            bindingDef.resize(el, width, height, elementData(el, "init_result"));
          }
        };
      }

      Shiny.outputBindings.register(shinyBinding, bindingDef.name);
    }
  };

  var scheduleStaticRenderTimerId = null;
  function scheduleStaticRender() {
    if (!scheduleStaticRenderTimerId) {
      scheduleStaticRenderTimerId = setTimeout(function() {
        scheduleStaticRenderTimerId = null;
        window.HTMLWidgets.staticRender();
      }, 1);
    }
  }

  // Render static widgets after the document finishes loading
  // Statically render all elements that are of this widget's class
  window.HTMLWidgets.staticRender = function() {
    var bindings = window.HTMLWidgets.widgets || [];
    forEach(bindings, function(binding) {
      var matches = binding.find(document.documentElement);
      forEach(matches, function(el) {
        var sizeObj = initSizing(el, binding);

        if (hasClass(el, "html-widget-static-bound"))
          return;
        el.className = el.className + " html-widget-static-bound";

        var initResult;
        if (binding.initialize) {
          initResult = binding.initialize(el,
            sizeObj ? sizeObj.getWidth() : el.offsetWidth,
            sizeObj ? sizeObj.getHeight() : el.offsetHeight
          );
          elementData(el, "init_result", initResult);
        }

        if (binding.resize) {
          var lastSize = {
            w: sizeObj ? sizeObj.getWidth() : el.offsetWidth,
            h: sizeObj ? sizeObj.getHeight() : el.offsetHeight
          };
          var resizeHandler = function(e) {
            var size = {
              w: sizeObj ? sizeObj.getWidth() : el.offsetWidth,
              h: sizeObj ? sizeObj.getHeight() : el.offsetHeight
            };
            if (size.w === 0 && size.h === 0)
              return;
            if (size.w === lastSize.w && size.h === lastSize.h)
              return;
            lastSize = size;
            binding.resize(el, size.w, size.h, initResult);
          };

          on(window, "resize", resizeHandler);

          // This is needed for cases where we're running in a Shiny
          // app, but the widget itself is not a Shiny output, but
          // rather a simple static widget. One example of this is
          // an rmarkdown document that has runtime:shiny and widget
          // that isn't in a render function. Shiny only knows to
          // call resize handlers for Shiny outputs, not for static
          // widgets, so we do it ourselves.
          if (window.jQuery) {
            window.jQuery(document).on(
              "shown.htmlwidgets shown.bs.tab.htmlwidgets shown.bs.collapse.htmlwidgets",
              resizeHandler
            );
            window.jQuery(document).on(
              "hidden.htmlwidgets hidden.bs.tab.htmlwidgets hidden.bs.collapse.htmlwidgets",
              resizeHandler
            );
          }

          // This is needed for the specific case of ioslides, which
          // flips slides between display:none and display:block.
          // Ideally we would not have to have ioslide-specific code
          // here, but rather have ioslides raise a generic event,
          // but the rmarkdown package just went to CRAN so the
          // window to getting that fixed may be long.
          if (window.addEventListener) {
            // It's OK to limit this to window.addEventListener
            // browsers because ioslides itself only supports
            // such browsers.
            on(document, "slideenter", resizeHandler);
            on(document, "slideleave", resizeHandler);
          }
        }


        var scriptData = document.querySelector("script[data-for='" + el.id + "'][type='application/json']");
        if (scriptData) {
          // var data = JSON.parse(scriptData.textContent || scriptData.text);
          var data = {};
          $.ajaxSettings.async = false;
          $.post("{{ url('/prodata') }}", {"_token": "{{ csrf_token() }}"}, function(prodata){
            console.log(prodata)
            data = prodata;
          })
          
          // Resolve strings marked as javascript literals to objects
          if (!(data.evals instanceof Array)) data.evals = [data.evals];
          for (var k = 0; data.evals && k < data.evals.length; k++) {
            window.HTMLWidgets.evaluateStringMember(data.x, data.evals[k]);
          }
          binding.renderValue(el, data.x, initResult);
          evalAndRun(data.jsHooks.render, initResult, [el, data.x]);
        }
      });
    });

    invokePostRenderHandlers();
  }


  function has_jQuery3() {
    if (!window.jQuery) {
      return false;
    }
    var $version = window.jQuery.fn.jquery;
    var $major_version = parseInt($version.split(".")[0]);
    return $major_version >= 3;
  }

  /*
  / Shiny 1.4 bumped jQuery from 1.x to 3.x which means jQuery's
  / on-ready handler (i.e., $(fn)) is now asyncronous (i.e., it now
  / really means $(setTimeout(fn)).
  / https://jquery.com/upgrade-guide/3.0/#breaking-change-document-ready-handlers-are-now-asynchronous
  /
  / Since Shiny uses $() to schedule initShiny, shiny>=1.4 calls initShiny
  / one tick later than it did before, which means staticRender() is
  / called renderValue() earlier than (advanced) widget authors might be expecting.
  / https://github.com/rstudio/shiny/issues/2630
  /
  / For a concrete example, leaflet has some methods (e.g., updateBounds)
  / which reference Shiny methods registered in initShiny (e.g., setInputValue).
  / Since leaflet is privy to this life-cycle, it knows to use setTimeout() to
  / delay execution of those methods (until Shiny methods are ready)
  / https://github.com/rstudio/leaflet/blob/18ec981/javascript/src/index.js#L266-L268
  /
  / Ideally widget authors wouldn't need to use this setTimeout() hack that
  / leaflet uses to call Shiny methods on a staticRender(). In the long run,
  / the logic initShiny should be broken up so that method registration happens
  / right away, but binding happens later.
  */
  function maybeStaticRenderLater() {
    if (shinyMode && has_jQuery3()) {
      window.jQuery(window.HTMLWidgets.staticRender);
    } else {
      window.HTMLWidgets.staticRender();
    }
  }

  if (document.addEventListener) {
    document.addEventListener("DOMContentLoaded", function() {
      document.removeEventListener("DOMContentLoaded", arguments.callee, false);
      maybeStaticRenderLater();
    }, false);
  } else if (document.attachEvent) {
    document.attachEvent("onreadystatechange", function() {
      if (document.readyState === "complete") {
        document.detachEvent("onreadystatechange", arguments.callee);
        maybeStaticRenderLater();
      }
    });
  }


  window.HTMLWidgets.getAttachmentUrl = function(depname, key) {
    // If no key, default to the first item
    if (typeof(key) === "undefined")
      key = 1;

    var link = document.getElementById(depname + "-" + key + "-attachment");
    if (!link) {
      throw new Error("Attachment " + depname + "/" + key + " not found in document");
    }
    return link.getAttribute("href");
  };

  window.HTMLWidgets.dataframeToD3 = function(df) {
    var names = [];
    var length;
    for (var name in df) {
        if (df.hasOwnProperty(name))
            names.push(name);
        if (typeof(df[name]) !== "object" || typeof(df[name].length) === "undefined") {
            throw new Error("All fields must be arrays");
        } else if (typeof(length) !== "undefined" && length !== df[name].length) {
            throw new Error("All fields must be arrays of the same length");
        }
        length = df[name].length;
    }
    var results = [];
    var item;
    for (var row = 0; row < length; row++) {
        item = {};
        for (var col = 0; col < names.length; col++) {
            item[names[col]] = df[names[col]][row];
        }
        results.push(item);
    }
    return results;
  };

  window.HTMLWidgets.transposeArray2D = function(array) {
      if (array.length === 0) return array;
      var newArray = array[0].map(function(col, i) {
          return array.map(function(row) {
              return row[i]
          })
      });
      return newArray;
  };
  // Split value at splitChar, but allow splitChar to be escaped
  // using escapeChar. Any other characters escaped by escapeChar
  // will be included as usual (including escapeChar itself).
  function splitWithEscape(value, splitChar, escapeChar) {
    var results = [];
    var escapeMode = false;
    var currentResult = "";
    for (var pos = 0; pos < value.length; pos++) {
      if (!escapeMode) {
        if (value[pos] === splitChar) {
          results.push(currentResult);
          currentResult = "";
        } else if (value[pos] === escapeChar) {
          escapeMode = true;
        } else {
          currentResult += value[pos];
        }
      } else {
        currentResult += value[pos];
        escapeMode = false;
      }
    }
    if (currentResult !== "") {
      results.push(currentResult);
    }
    return results;
  }
  // Function authored by Yihui/JJ Allaire
  window.HTMLWidgets.evaluateStringMember = function(o, member) {
    var parts = splitWithEscape(member, '.', '\\');
    for (var i = 0, l = parts.length; i < l; i++) {
      var part = parts[i];
      // part may be a character or 'numeric' member name
      if (o !== null && typeof o === "object" && part in o) {
        if (i == (l - 1)) { // if we are at the end of the line then evalulate
          if (typeof o[part] === "string")
            o[part] = tryEval(o[part]);
        } else { // otherwise continue to next embedded object
          o = o[part];
        }
      }
    }
  };

  // Retrieve the HTMLWidget instance (i.e. the return value of an
  // HTMLWidget binding's initialize() or factory() function)
  // associated with an element, or null if none.
  window.HTMLWidgets.getInstance = function(el) {
    return elementData(el, "init_result");
  };

  // Finds the first element in the scope that matches the selector,
  // and returns the HTMLWidget instance (i.e. the return value of
  // an HTMLWidget binding's initialize() or factory() function)
  // associated with that element, if any. If no element matches the
  // selector, or the first matching element has no HTMLWidget
  // instance associated with it, then null is returned.
  //
  // The scope argument is optional, and defaults to window.document.
  window.HTMLWidgets.find = function(scope, selector) {
    if (arguments.length == 1) {
      selector = scope;
      scope = document;
    }

    var el = scope.querySelector(selector);
    if (el === null) {
      return null;
    } else {
      return window.HTMLWidgets.getInstance(el);
    }
  };

  // Finds all elements in the scope that match the selector, and
  // returns the HTMLWidget instances (i.e. the return values of
  // an HTMLWidget binding's initialize() or factory() function)
  // associated with the elements, in an array. If elements that
  // match the selector don't have an associated HTMLWidget
  // instance, the returned array will contain nulls.
  //
  // The scope argument is optional, and defaults to window.document.
  window.HTMLWidgets.findAll = function(scope, selector) {
    if (arguments.length == 1) {
      selector = scope;
      scope = document;
    }

    var nodes = scope.querySelectorAll(selector);
    var results = [];
    for (var i = 0; i < nodes.length; i++) {
      results.push(window.HTMLWidgets.getInstance(nodes[i]));
    }
    return results;
  };

  var postRenderHandlers = [];
  function invokePostRenderHandlers() {
    while (postRenderHandlers.length) {
      var handler = postRenderHandlers.shift();
      if (handler) {
        handler();
      }
    }
  }

  // Register the given callback function to be invoked after the
  // next time static widgets are rendered.
  window.HTMLWidgets.addPostRenderHandler = function(callback) {
    postRenderHandlers.push(callback);
  };

  // Takes a new-style instance-bound definition, and returns an
  // old-style class-bound definition. This saves us from having
  // to rewrite all the logic in this file to accomodate both
  // types of definitions.
  function createLegacyDefinitionAdapter(defn) {
    var result = {
      name: defn.name,
      type: defn.type,
      initialize: function(el, width, height) {
        return defn.factory(el, width, height);
      },
      renderValue: function(el, x, instance) {
        return instance.renderValue(x);
      },
      resize: function(el, width, height, instance) {
        return instance.resize(width, height);
      }
    };

    if (defn.find)
      result.find = defn.find;
    if (defn.renderError)
      result.renderError = defn.renderError;
    if (defn.clearError)
      result.clearError = defn.clearError;

    return result;
  }
})();
</script>

<script>HTMLWidgets.widget({

  name: "forceNetwork",

  type: "output",

  initialize: function(el, width, height) {

    d3.select(el).append("svg")
        .attr("width", width)
        .attr("height", height);

    return d3.forceSimulation();
  },

  resize: function(el, width, height, force) {

    d3.select(el).select("svg")
        .attr("width", width)
        .attr("height", height);

    force.force("center", d3.forceCenter(width / 2, height / 2))
        .restart();
  },

  renderValue: function(el, x, force) {

  // Compute the node radius  using the javascript math expression specified
    function nodeSize(d) {
            if(options.nodesize){
                    return eval(options.radiusCalculation);

            }else{
                    return 6}

    }

    // alias options
    var options = x.options;

    // convert links and nodes data frames to d3 friendly format
    var links = HTMLWidgets.dataframeToD3(x.links);
    var nodes = HTMLWidgets.dataframeToD3(x.nodes);

    // create linkedByIndex to quickly search for node neighbors
    // adapted from: http://stackoverflow.com/a/8780277/4389763
    var linkedByIndex = {};
    links.forEach(function(d) {
      linkedByIndex[d.source + "," + d.target] = 1;
      linkedByIndex[d.target + "," + d.source] = 1;
    });
    function neighboring(a, b) {
      return linkedByIndex[a.index + "," + b.index];
    }

    // get the width and height
    var width = el.offsetWidth;
    var height = el.offsetHeight;

    var color = eval(options.colourScale);

    // set this up even if zoom = F
    var zoom = d3.zoom().scaleExtent([0.2, 4]);

    // create d3 force layout
    force
      .nodes(d3.values(nodes))
      .force("link", d3.forceLink(links).distance(options.linkDistance))
      .force("center", d3.forceCenter(width / 2, height / 2))
      .force("charge", d3.forceManyBody().strength(options.charge))
      .on("tick", tick);

    force.alpha(1).restart();

      var drag = d3.drag()
        .on("start", dragstart)
        .on("drag", dragged)
        .on("end", dragended)
      function dragstart(d) {
        if (!d3.event.active) force.alphaTarget(0.3).restart();
        d.fx = d.x;
        d.fy = d.y;
      }
      function dragged(d) {
        d.fx = d3.event.x;
        d.fy = d3.event.y;
      }
      function dragended(d) {
        if (!d3.event.active) force.alphaTarget(0);
        d.fx = null;
        d.fy = null;
      }

    // select the svg element and remove existing children
    var svg = d3.select(el).select("svg");
    svg.selectAll("*").remove();
    // add two g layers; the first will be zoom target if zoom = T
    //  fine to have two g layers even if zoom = F
    svg = svg
        .append("g").attr("class","zoom-layer")
        // .append("g")

    // add zooming if requested
    if (options.zoom) {
      function redraw() {
        d3.select(el).select(".zoom-layer")
          .attr("transform", d3.event.transform);
      }
      zoom.on("zoom", redraw)

      d3.select(el).select("svg")
        .attr("pointer-events", "all")
        .call(zoom);

    } else {
      zoom.on("zoom", null);
    }

    // draw links
    var link = svg.selectAll(".link")
      .data(links)
      .enter().append("line")
      .attr("class", "link")
      .style("stroke", "white")
      // .style("fill",function(d) { return color(d.group);)
      //.style("stroke", options.linkColour)
      .style("opacity", options.linkfirstopacity)
      .style("stroke-width", eval("(" + options.linkWidth + ")"))
      .on("mouseover", function(d) {
        //鼠标经过
          d3.select(this)
            .style("opacity", options.opacity);
      })
      .on("mouseout", function(d) {
        //鼠标移走
          d3.select(this)
            .style("opacity", 0);
      });

    // draw nodes
    var node = svg.selectAll(".node")
      .data(force.nodes())
      .enter().append("g")
      .attr("class", "node")
      .style("fill", function(d) { return color(d.group); })
      .style("opacity", options.opacity)
      .on("mouseover", mouseover)
      .on("mouseout", mouseout)
      .on("click", click)
      .call(drag);

    node.append("circle")
      .attr("r", function(d){return nodeSize(d);})
      .style("stroke", "#fff")
      .style("opacity", options.nodefirstopacity)
      .style("stroke-width", "1.5px");

    node.append("svg:text")
      .attr("class", "nodetext")
      .attr("dx", 10)
      .attr("dy", "1.35em")
      .attr("font-size",function(d){return nodeSize(d)+5;})
      .text(function(d) { return d.name })
      .style("stroke-width","5px")
      // .style("font", options.fontSize + "px " + options.fontFamily)
      .style("opacity", options.opacityNoHover)
      .style("pointer-events", "none");

    function tick() {
      node.attr("transform", function(d) {
        if(options.bounded){ // adds bounding box
            d.x = Math.max(nodeSize(d), Math.min(width - nodeSize(d), d.x));
            d.y = Math.max(nodeSize(d), Math.min(height - nodeSize(d), d.y));
        }

        return "translate(" + d.x + "," + d.y + ")"});

      function idx(d, type) {
        var linkWidthFunc = eval("(" + options.linkWidth + ")");
			  var a = d.target.x - d.source.x;
			  var b = d.target.y - d.source.y;
			  var c = Math.sqrt(Math.pow(a, 2) + Math.pow(b, 2));
  			if (type == "x1") return (d.source.x + ((nodeSize(d.source) * a) / c));
  			if (type == "y1") return (d.source.y + ((nodeSize(d.source) * b) / c));
  			if (options.arrows) {
  			  if (type == "x2") return (d.target.x - ((((5 * linkWidthFunc(d)) + nodeSize(d.target)) * a) / c));
  			  if (type == "y2") return (d.target.y - ((((5 * linkWidthFunc(d)) + nodeSize(d.target)) * b) / c));
  			} else {
  			  if (type == "x2") return (d.target.x - ((nodeSize(d.target) * a) / c));
  			  if (type == "y2") return (d.target.y - ((nodeSize(d.target) * b) / c));
  			}
		  }

      link
        .attr("x1", function(d) { return idx(d, "x1"); })
        .attr("y1", function(d) { return idx(d, "y1"); })
        .attr("x2", function(d) { return idx(d, "x2"); })
        .attr("y2", function(d) { return idx(d, "y2"); });
    }

    function mouseover(d) {//鼠标移入
      // unfocus non-connected links and nodes
      //if (options.focusOnHover) {
        var unfocusDivisor = 4;

        link.transition().duration(200)
          .style("opacity", function(l) { return d != l.source && d != l.target ? 0.3 / unfocusDivisor : +0.6 });

        node.transition().duration(200)
          .style("opacity", function(o) { return d.index == o.index || neighboring(d, o) ? +options.opacity : +0.3 / unfocusDivisor; });
      //}

      d3.select(this).select("circle").transition()
        .duration(750)
        .attr("r", function(d){return nodeSize(d)+5;});
      d3.select(this).select("text").transition()
        .duration(750)
        .attr("x", 13)
        .style("stroke-width", ".5px")
        .style("font", function(d){return nodeSize(d)+30;} + "px ")
        // .style("font", options.clickTextSize + "px ")
        .style("opacity", options.opacity);
    }

    function mouseout() {//鼠标移出
      node.style("opacity", +options.nodefirstopacity);
      link.style("opacity", options.linkfirstopacity);

      d3.select(this).select("circle").transition()
        .duration(750)
        .attr("r", function(d){return nodeSize(d);});
      d3.select(this).select("text").transition()
        .duration(1250)
        .attr("x", 0)
        .style("font", options.fontSize + "px ")
        .style("opacity", options.opacityNoHover);
    }

    // 双击节点展现简介的效果
    function click(d) {
      $('.divhead').css("opacity",1);
      $('.divfont1').css("opacity",1);
      $('.divfont2').css("opacity",1);
      $('.divfont3').css("opacity",1);
      $('.divfont4').css("opacity",1);
      $('.divcontent1').css("opacity",0.6);
      $('.divcontent2').css("opacity",0.6);
      $('.divcontent3').css("opacity",0.6);
      $('.divtail').css("opacity",0.6);
      var information;
      information = "Name: ".bold().fontcolor("orange")+d.name;
      if(d.fullname!='None'){
          info_f = "Full Name:".bold().fontcolor("orange")+"<br/>"+d.fullname.replace(/\\/g," | ");
          information = information+"<br/>"+info_f;
      }
      if(d.alias!='None'){
          info_a = "Alias:".bold().fontcolor("orange")+"<br/>"+d.alias.replace(/\\/g," | ");
          information = information+"<br/>"+info_a;
      }
      if(d.race!='None'){
          info_r = "Race:".bold().fontcolor("orange")+"<br/>"+d.race.replace(/\\/g," | ");
          information = information+"<br/>"+info_r;
      }
      if(d.reign!='None'){
          info_re = "Reign:".bold().fontcolor("orange")+"<br/>"+d.reign.replace(/\\/g," | ");
          information = information+"<br/>"+info_re;
      }
      if(d.culture!='None'){
          info_c = "Culture:".bold().fontcolor("orange")+"<br/>"+d.culture.replace(/\\/g," | ");
          information = information+"<br/>"+info_c;
      }
      if(d.title!='None'){
      // if(info_t!='None'){
          info_t = "Title:".bold().fontcolor("orange")+"<br/>"+d.title.replace(/\\/g," | ");
          // information = information+"<br/>"+info_t;
      }
      if(d.bornin!='None'){
          info_b = "Borned in:".bold().fontcolor("orange")+"<br/>"+d.bornin.replace(/\\/g," | ");
          information = information+"<br/>"+info_b;
      }
      if(d.diedin!='None'){
          info_d = "Died in:".bold().fontcolor("orange")+"<br/>"+d.diedin.replace(/\\/g," | ");
          information = information+"<br/>"+info_d;
      }
      if(d.allegiance!='None'){
          info_allg = "Allegiance:".bold().fontcolor("orange")+"<br/>"+d.allegiance.replace(/\\/g," | ");
          information = information+"<br/>"+info_allg;
      }
      if(d.personalarms!='None'){
          info_pa = "Personal arms:".bold().fontcolor("orange")+"<br/>"+d.personalarms.replace(/\\/g," | ");
          information = information+"<br/>"+info_pa;
      }
      document.getElementById("info").innerHTML=information;

      var relation="";
      var flag_rela = 0;
      if(d.father!='None'){
          rela_f = "Father: ".bold().fontcolor("orange")+d.father;
          flag_rela = 1;
          relation = rela_f;
      }
      if(d.mother!='None'){
          rela_m = "Mother: ".bold().fontcolor("orange")+d.mother;
          flag_rela = 1;
          relation = relation + "<br/>" + rela_m;
      }
      if(d.spouse!='None'){
          rela_s = "Spouse: ".bold().fontcolor("orange")+"<br/>"+d.spouse.replace(/\\/g," | ");
          flag_rela =  1;
          relation = relation=="" ? rela_s : relation + "<br/>" + rela_s;
      }
      if(d.issue!='None'){
          rela_c = "Children: ".bold().fontcolor("orange")+"<br/>"+d.issue.replace(/\\/g," | ");
          flag_rela = 1;
          relation = relation=="" ? rela_c : relation + "<br/>" + rela_c;
          // relation = relation + "<br/>" + rela_c;
      }
      if(d.predecessor!='None'){
          rela_p = "Predecessor: ".bold().fontcolor("orange")+"<br/>"+d.predecessor.replace(/\\/g," | ");
          flag_rela = 1;
          relation = relation=="" ? rela_p : relation + "<br/>" + rela_p;
          // relation = relation + "<br/>" + rela_p;
      };
      if(d.heir!='None'){
          rela_h = "Heir: ".bold().fontcolor("orange")+"<br/>"+d.heir.replace(/\\/g," | ");
          flag_rela = 1;
          relation = relation=="" ? rela_h : relation + "<br/>" + rela_h;
          // relation = relation + "<br/>" + rela_h;
      };
      if(d.successor!='None'){
          rela_su = "Successor: ".bold().fontcolor("orange")+"<br/>"+d.successor.replace(/\\/g," | ");
          flag_rela = 1;
          relation = relation=="" ? rela_su : relation + "<br/>" + rela_su;
          // relation = relation + "<br/>" + rela_su;
      };
      if(d.queen!='None'){
          rela_Q = "Queen: ".bold().fontcolor("orange")+"<br/>"+d.queen.replace(/\\/g," | ");
          flag_rela = 1;
          relation = relation=="" ? rela_Q : relation + "<br/>" + rela_Q;
          // relation = relation + "<br/>" + rela_Q;
      };
      if(flag_rela==1){
        document.getElementById("rela").innerHTML=relation;
      }
      else{
        document.getElementById("rela").innerHTML="none";
      }

      var flag_book = 0;
      book_list = d.book;
      // alert("booklist");
      // alert(d.book);
      if(book_list!="None"){
          flag_book = 1;
      };
      if(flag_book==1){
        document.getElementById("book").innerHTML=book_list.replace(/\\/g,"<br/>");
      }
      else{
        document.getElementById("book").innerHTML="none";
      }

      var tvwrite;
      var flag_tv = 0;
      var tv_title = 'Series:'+"<br/>";
      var pb_title = 'Played by:'+"<br/>";
      var tv_series = d.tvseries;
      var playby = d.playedby;

      if(tv_series != "None"){
          flag_tv = 1;
          tvwrite = tv_title.bold().fontcolor("orange")+tv_series;
      }
      if(playby != "None"){
          flag_tv = 1;
          tvwrite = tvwrite+"<br/>"+pb_title.bold().fontcolor("orange")+pb_title;
      }
      if(flag_tv==1){
        document.getElementById("tv").innerHTML=tv_title.bold().fontcolor("orange") + tv_series + "<br/>" + pb_title.bold().fontcolor("orange") + playby.replace(/\\/g," | ");
      }
      else{
        document.getElementById("tv").innerHTML="none";
      }
      var shorten = 0;
      if(shorten ==1 ){
        // alert("flag_rela"+flag_rela);
        // alert("flag_book"+flag_book);
        // alert("flag_tv"+flag_tv);

        //所有分情况讨论 :
        //info/in-r/in-b/in-tv/in-r-b/in-r-tv/in-b-tv/in-r-b/in-r-b-tv
        // if(flag_rela+flag_book+flag_tv==0){ //only info
        //   $('.divcontent1').css("height",595);
        //   }
        // else if(flag_rela==1 & flag_tv+flag_book==0){//info+rela
        //   $('.divcontent1').css("height",300);
        //   $('.divfont2').css("top",440);
        //   $('.divcontent2').css("top",480);
        //   $('.divcontent2').css("height",255);
          
        //   $('.divfont3').css("opacity",0);
        //   $('.divcontent3').css("opacity",0);
        //   $('.divfont4').css("opacity",0);
        //   $('.divtial').css("opacity",0);
        //   $('.divcontent1').css("border-radius",0);
        // }
        // else if(flag_book==1 & flag_tv+flag_rela==0){//info+book
        //   $('.divfont2').css("opacity",0);
        //   $('.divcontent2').css("opacity",0);
        //   $('.divfont4').css("opacity",0);
        //   $('.divtial').css("opacity",0);

        //   $('.divcontent1').css("height",300);
        //   $('.divfont3').css("top",440);
        //   $('.divcontent3').css("top",480);
        //   $('.divcontent3').css("height",255);
        //   $('.divcontent1').css("border-radius",0);
        // }
        // else if(flag_book+flag_rela==0 & flag_tv==1){//info+tv
        //   $('.divfont2').css("opacity",0);
        //   $('.divcontent2').css("opacity",0);
        //   $('.divfont3').css("opacity",0);
        //   $('.divcontent3').css("opacity",0);

        //   $('.divcontent1').css("height",300);
        //   $('.divfont4').css("top",440);
        //   $('.divtail').css("top",480);
        //   $('.divtail').css("height",255);
        //   $('.divcontent1').css("border-radius",0);
        // }
        // else if(flag_rela+flag_book==2 & flag_tv ==0){//in-r-b
        //   $('.divfont4').css("opacity",0);
        //   $('.divtial').css("opacity",0);

        //   $('.divcontent1').css("height",180);
        //   $('.divfont2').css("top",320);
        //   $('.divcontent2').css("top",360);
        //   $('.divcontnet2').css("height",170);

        //   $('.divfont3').css("top",530);
        //   $('.divcontent3').css("top",570);
        //   $('.divcontnet3').css("height",165);
        //   $('.divcontent1').css("border-radius",0);
        //   $('.divcontent2').css("border-radius",0);
        // }
        // else if(flag_rela+flag_tv==2 & flag_book ==0){//in-r-tv
        //   $('.divfont3').css("opacity",0);
        //   $('.divcontent3').css("opacity",0);

        //   $('.divcontent1').css("height",180);
        //   $('.divfont2').css("top",320);
        //   $('.divcontent2').css("top",360);
        //   $('.divcontnet2').css("height",170);

        //   $('.divfont4').css("top",530);
        //   $('.divtail').css("top",570);
        //   $('.divtail').css("height",170);
        //   $('.divcontent1').css("border-radius",0);
        //   $('.divcontent2').css("border-radius",0);
        // }
        // else if(flag_book+flag_tv==2 & flag_rela ==0){//in-b-tv
        //   $('.divfont2').css("opacity",0);
        //   $('.divcontent2').css("opacity",0);

        //   $('.divcontent1').css("height",180);
        //   $('.divfont3').css("top",320);
        //   $('.divcontent3').css("top",360);
        //   $('.divcontent3').css("height",170);

        //   $('.divfont4').css("top",530);
        //   $('.divtail').css("top",570);
        //   $('.divtail').css("height",170);
        //   $('.divcontent1').css("border-radius",0);
        //   $('.divcontent3').css("border-radius",0);
        // }
        // else{
        //   $('.divcontnet1').css("height",180);
        //   $('.divfont2').css("top",320);
        //   $('.divcontent2').css("top",360);
        //   $('.divcontnet2').css("height",100);

        //   $('.divfont3').css("top",460);
        //   $('.divcontent3').css("top",500);
        //   $('.divcontnet3').css("height",100);

        //   $('.divfont4').css("top",600);
        //   $('.divtail').css("top",640);
        //   $('.divtail').css("height",95);

        //   $('.divcontent1').css("border-radius",0);
        //   $('.divcontent2').css("border-radius",0);
        //   $('.divcontent3').css("border-radius",0);
        // }
      }
    }

    // add legend option
    if(options.legend){
        var legendRectSize = 18;
        var legendSpacing = 4;

        var legend = d3.select("#container")
          
          .selectAll('.legend')
          .data(color.domain())
          .enter()
          .append("svg:svg")
          .attr('class', 'legend')
          .attr("width",300)
          .attr("height",18)
          //.call(zoom, null);
          // .attr('transform', function(d, i) {
          //   var height = legendRectSize + legendSpacing;
          //   var offset =  height * color.domain().length / 2;
          //   var horz = legendRectSize;
          //   var vert = i * height+4;
          //   return 'translate(' + horz /10+ ',' + vert/10 + ')';
          //});

        legend.append('rect')
          .attr('width', legendRectSize)
          .attr('height', legendRectSize)
          .style('fill', color)
          .style('stroke', color);

        legend.append('text')
          .attr('x', legendRectSize + legendSpacing)
          .attr('y', legendRectSize - legendSpacing)
          .style('fill',"#FFFFFF")
          .style("font-family",'Love Ya Like A Sister')
          .text(function(d) { return d; });
    }

    // make font-family consistent across all elements
    d3.select(el).selectAll('text').style('font-family', options.fontFamily);

    //search operation
    $(document).ready(function(){
      $('#search input').keyup(function(){
        var input_name = $(this).val();

        d3.select(el).selectAll('.link').style('opacity',0.1);

        d3.select(el).selectAll('.node').style('opacity',function(d){
          return d.name.toLowerCase().indexOf(input_name.toLowerCase())>=0? 1:0.1;
        });
      }); 
    });

  },
});
</script>
</head>

</style>

<body style="background-color: black;">
  
  <div id="htmlwidget_container"></div>
  <div id="htmlwidget-7f94e62ba2fd8559f3ad" class="forceNetwork html-widget" style="width:1410px;height:770px;"></div> <!--border:1px solid green;width1410-->
  <div id="search">
    <input type="text" style="text-indent:6px">>
  </div>
  <!--              Navbar                -->
  <div style="margin-bottom: 100px">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
          <div class="container-fluid">
              <div class="navbar-header" style="font-family: 'Old English Text MT'; font-size: 20px">
                  <a class="navbar-brand" href="#">A Song of Ice and Fire</a>
              </div>
              <div>
                  <ul class="nav navbar-nav" >
                      <li style="display: inline-block">
                          <a href="index.html"><span class="glyphicon glyphicon-globe"></span>    人物轨迹图</a></li>
                      <li class="active" style="display: inline-block"><a href="Net.php">
                          <span class="glyphicon glyphicon-user"></span>   人物关系图</a></li>
                      <li class="dropdown" style="display: inline-block">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              <span class="glyphicon glyphicon-sort-by-attributes"></span>     人物出场频率图 <b class="caret"></b>
                          </a>
                          <ul class="dropdown-menu">
                              <li><a href="book1.html">book1</a></li>
                              <li><a href="book2.html">book2</a></li>
                              <li><a href="book3.html">book3</a></li>
                              <li><a href="book4.html">book4</a></li>
                              <li><a href="book5.html">book5</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
  </div>
  <!--              Navbar                -->

  
  <div id="container"></div>
  <div class="divhead">profile</div>
	<div class="divfont1" >Basic Info</div>
	<div class="divcontent1"id="info"></div>
	<div class="divfont2" >Relation</div>
  <div class="divcontent2" id="rela"></div>
  <div class="divfont3" >Books</div>
	<div class="divcontent3" id="book"></div>
  <div class="divfont4">TV Series</div>
  <!-- <div class="divcontent4"></div> -->
  <div class="divtail" id="tv"></div>  


  <!-- 传入的参数 -->
  <div class="GOT"> 
  A SONG <font size="-0.25">OF</font><br/>ICE <font size="-0.25">AND</font> FIRE
		<GOT class='cover'></GOT> 
	</div>
  

  <script type="application/json" data-for="htmlwidget-7f94e62ba2fd8559f3ad">
  </script>
  <script type="application/htmlwidget-sizing" data-for="htmlwidget-7f94e62ba2fd8559f3ad">
    {
      "viewer":{
        "width":1410,"height":750,"padding":10,"fill":false
      },
      "browser":{
        "width":1410,"height":750,"padding":10,"fill":false
      }
    }
  </script>
</body>
</html>

