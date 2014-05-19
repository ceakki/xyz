var source = (function(undefined) {
    function s(o) {
        // config
        this.o = {};
        if(!o || typeof o === 'object') {
            o = o || {};
            this.o.a = typeof o.a === 'string' ? o.a : 'A';
            this.o.b = typeof o.b === 'string' ? o.b : 'B';
        }
    }
    s.prototype.x = function(m) {
        console.log(m);
    };
    return s;
})();
var extender = (function(undefined) {
    function e(o) {
        // instanciate parent
        source.call(this, o);
        // child config
        if(!o || typeof o === 'object') {
            o = o || {};
            e = this.o;
            e.c = typeof o.c === 'number' ? o.c : 1;
            e.d = typeof o.d === 'number' ? o.d : 2;
        }
    }
    // inherit
    e.prototype = source.prototype;
    // extend
    e.prototype.y = function(m) {
        console.log(m);
    };
    return e;
})();
var e = new extender({d:3});
console.log(e);
