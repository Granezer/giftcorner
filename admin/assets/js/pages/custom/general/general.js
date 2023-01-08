var getUrlParams = function () {
  var url = window.location.href;
  var params = {};
  (url + '?').split('?')[1].split('&').forEach(function (pair) {
    pair = (pair + '=').split('=').map(decodeURIComponent);
    if (pair[0].length) {
      params[pair[0]] = pair[1];
    }
  });

  return params;
};

var getTransactionId = function(length = 20) {
        var result = '',
            characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
            charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    };

var getCookie = function (cname) {
    var name = cname + "=",
        ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

var main_url = "http://localhost/giftcorner/admin/",
  endPoint =  main_url + "classes/actions/",
  imageDestination =  main_url + "assets/media/employees/",
  productImages =  main_url + "assets/media/products/",
  logoURL =  main_url + "assets/media/logos/",
  all_employees,
  all_product_status,
  all_order_status,
  all_notification_types,
  all_payment_status,
  all_categories_type,
  all_main_categories,

  monthNames = [
    "January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"
  ],

  dayOfWeekNames = [
    "Sunday", "Monday", "Tuesday",
    "Wednesday", "Thursday", "Friday", "Saturday"
  ];

function twoDigitPad(num) {
    return num < 10 ? "0" + num : num;
}

function convertDate(dateInput) {
    var date = new Date(dateInput),
        dd = date.getDate(), 
        mm = date.getMonth()+1, //January is 0! 
        yyyy = date.getFullYear(); 
  if(dd<10) {
    dd='0'+dd;
  } 

  if(mm<10) {
    mm='0'+mm;
  } 

  var dateFormated = dd+'/'+mm+'/'+yyyy; 

  return dateFormated;
}

function convertTime(time, patternStr) {
  if (!patternStr) {
        patternStr = 'h:mm aaa';
    }
    time =new Date(time);
    var hour = time.getHours(),
        minute = time.getMinutes(),
        h = hour % 12,
        hh = twoDigitPad(h),
        HH = twoDigitPad(hour),
        mm = twoDigitPad(minute),
        aaa = hour < 12 ? 'AM' : 'PM'
    ;

    patternStr = patternStr
      .replace('hh', hh).replace('h', h)
      .replace('HH', HH).replace('H', hour)
      .replace('mm', mm).replace('m', minute);

    return patternStr;
}

function formatDate(date, patternStr){
    if (!patternStr) {
        patternStr = 'EEEE, MMMM d, yyyy h:mm:ss aaa';
    }
    date =new Date(date);
    var day = date.getDate(),
        month = date.getMonth(),
        year = date.getFullYear(),
        hour = date.getHours(),
        minute = date.getMinutes(),
        second = date.getSeconds(),
        miliseconds = date.getMilliseconds(),
        h = hour % 12,
        hh = twoDigitPad(h),
        HH = twoDigitPad(hour),
        mm = twoDigitPad(minute),
        ss = twoDigitPad(second),
        aaa = hour < 12 ? 'AM' : 'PM',
        EEEE = dayOfWeekNames[date.getDay()],
        EEE = EEEE.substr(0, 3),
        dd = twoDigitPad(day),
        M = month + 1,
        MM = twoDigitPad(M),
        MMMM = monthNames[month],
        MMM = MMMM.substr(0, 3),
        yyyy = year + "",
        yy = yyyy.substr(2, 2)
    ;
    // checks to see if month name will be used
    patternStr = patternStr
      .replace('hh', hh).replace('h', h)
      .replace('HH', HH).replace('H', hour)
      .replace('mm', mm).replace('m', minute)
      .replace('ss', ss).replace('s', second)
      .replace('S', miliseconds)
      .replace('dd', dd).replace('d', day)
      
      .replace('EEEE', EEEE).replace('EEE', EEE)
      .replace('yyyy', yyyy)
      .replace('yy', yy)
      .replace('aaa', aaa);
    if (patternStr.indexOf('MMM') > -1) {
        patternStr = patternStr
          .replace('MMMM', MMMM)
          .replace('MMM', MMM);
    }
    else {
        patternStr = patternStr
          .replace('MM', MM)
          .replace('M', M);
    }
    return patternStr;
}

function numbers(evt,id)
{
  try {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if (charCode==46) {
      var txt=document.getElementById(id).value;
      if (!(txt.indexOf(".") > -1)) {
        return true;
      }
    }

    if (charCode > 31 && (charCode < 48 || charCode > 57) )
      return false;

    return true;
  } catch(w) {
    alert(w);
  }
}

function digits(evt,id)
{
  try {
    var charCode = (evt.which) ? evt.which : event.keyCode;

    if (charCode==46) {
      return false;
    }

    if (charCode > 31 && (charCode < 48 || charCode > 57) )
      return false;

    return true;
  } catch(w) {
    alert(w);
  }
}

function get_file_ext( url ) {
    return url.split(/[#?]/)[0].split('.').pop().trim();
}