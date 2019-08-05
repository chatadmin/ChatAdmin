/**

 @Name：layuiAdmin 公共业务
 @Author：贤心
 @Site：http://www.layui.com/admin/
 @License：LPPL

 */

layui.define(function(exports){
  var $ = layui.$
  ,layer = layui.layer
  ,laytpl = layui.laytpl
  ,setter = layui.setter
  ,view = layui.view
  ,admin = layui.admin

  //公共业务的逻辑处理可以写在此处，切换任何页面都会执行
  //……



  //退出
  admin.events.logout = function(){
    //执行退出接口
    admin.req({
      url: layui.setter.URL_ADMIN+'/interface/logout'
      ,type: 'get'
      ,data: {}
      ,done: function(res){ //这里要说明一下：done 是只有 response 的 code 正常才会执行。而 succese 则是只要 http 为 200 就会执行

        //清空本地记录的 token，并跳转到登入页
        admin.exit();
      }
    });
  };

  admin.formatDate = function(timestamp) {
	  var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
      Y = date.getFullYear() + '-';
      M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
      D = (date.getDate()<10?'0'+date.getDate():date.getDate()) + ' ';
      h = (date.getHours()<10?'0'+date.getHours():date.getHours()) + ':';
      m = (date.getMinutes()<10?'0'+date.getMinutes():date.getMinutes()) + ':';
      s = (date.getSeconds()<10?'0'+date.getSeconds():date.getSeconds());
      return Y+M+D+h+m+s;
  }

    admin.formatDates = function(timestamp) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = (date.getDate()<10?'0'+date.getDate():date.getDate()) + ' ';

        return Y+M+D;
    }
    admin.formatDateNoYear = function(timestamp) {	//输出月-日-时
  	  var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        //Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = (date.getDate()<10?'0'+date.getDate():date.getDate()) + ' ';
        h = (date.getHours()<10?'0'+date.getHours():date.getHours()) + ':';
        m = (date.getMinutes()<10?'0'+date.getMinutes():date.getMinutes()) + ':';
        s = (date.getSeconds()<10?'0'+date.getSeconds():date.getSeconds());
        return M+D+h+m+s;
    }

    //转时间戳
    admin.formatTime = function (str) {
        str = str.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
        var date = new Date(str);
        var time = date.getTime();
            time = time/1000;
        return time;
    };

  //图片预览
    admin.getObjectURL=function getObjectURL(file)
    {
        var url = null ;
        if (window.createObjectURL!=undefined)
        {
            url = window.createObjectURL(file) ;
        }
        else if (window.URL!=undefined)
        {
            url = window.URL.createObjectURL(file) ;
        }
        else if (window.webkitURL!=undefined) {
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    };
  //设置cookie
    admin.setCookie = function setCookie(name,value)
    {
        var Days = 7;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
    };
    //读取cookie
    admin.getCookie = function getCookie(name)
    {
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    };
    //删除cookie
    admin.delCookie = function delCookie(name)
    {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=getCookie(name);
        if(cval!=null)
            document.cookie= name + "="+cval+";expires="+exp.toGMTString();
    };

  //对外暴露的接口
  exports('common', {});
});
