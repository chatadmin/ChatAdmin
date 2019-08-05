/** layuiAdmin.pro-v1.0.0-beta9 LPPL License By http://www.layui.com/admin/ */
;layui.define(function (e) {
    var t = (layui.$, layui.layer, layui.laytpl, layui.setter, layui.view, layui.admin);
    t.events.logout = function () {
        t.req({
            url: layui.setter.URL_ADMIN + "/interface/logout", type: "get", data: {}, done: function (e) {
                t.exit()
            }
        })
    }, t.formatDate = function (e) {
        var t = new Date(1e3 * e);
        return Y = t.getFullYear() + "-", M = (t.getMonth() + 1 < 10 ? "0" + (t.getMonth() + 1) : t.getMonth() + 1) + "-", D = (t.getDate() < 10 ? "0" + t.getDate() : t.getDate()) + " ", h = (t.getHours() < 10 ? "0" + t.getHours() : t.getHours()) + ":", m = (t.getMinutes() < 10 ? "0" + t.getMinutes() : t.getMinutes()) + ":", s = t.getSeconds() < 10 ? "0" + t.getSeconds() : t.getSeconds(), Y + M + D + h + m + s
    }, t.formatDates = function (e) {
        var t = new Date(1e3 * e);
        return Y = t.getFullYear() + "-", M = (t.getMonth() + 1 < 10 ? "0" + (t.getMonth() + 1) : t.getMonth() + 1) + "-", D = (t.getDate() < 10 ? "0" + t.getDate() : t.getDate()) + " ", Y + M + D
    }, t.formatDateNoYear = function (e) {
        var t = new Date(1e3 * e);
        return M = (t.getMonth() + 1 < 10 ? "0" + (t.getMonth() + 1) : t.getMonth() + 1) + "-", D = (t.getDate() < 10 ? "0" + t.getDate() : t.getDate()) + " ", h = (t.getHours() < 10 ? "0" + t.getHours() : t.getHours()) + ":", m = (t.getMinutes() < 10 ? "0" + t.getMinutes() : t.getMinutes()) + ":", s = t.getSeconds() < 10 ? "0" + t.getSeconds() : t.getSeconds(), M + D + h + m + s
    }, t.formatTime = function (e) {
        e = e.replace(/-/g, "/");
        var t = new Date(e), n = t.getTime();
        return n /= 1e3
    }, t.getObjectURL = function (e) {
        var t = null;
        return void 0 != window.createObjectURL ? t = window.createObjectURL(e) : void 0 != window.URL ? t = window.URL.createObjectURL(e) : void 0 != window.webkitURL && (t = window.webkitURL.createObjectURL(e)), t
    }, e("common", {})
});
