window.exObject = {
    exVar: 123,
    exFunc: function(callback) {
        var t = this;
        t.exVar = 321;
        callback();
    }
}
//--
window.exHooks = [];
window.exCallHooks = function () {
    for(hook in window.exHoks)
        window.exHooks[hook]();
};
window.exObject = (function (orig) {
    return function (callback) {
        var cbNew = callback ? function () {
            callback();
            window.exCallHooks();
        } : window.exCallHooks;
        return orig.call(this, cbNew);
    };
})(window.exObject);
