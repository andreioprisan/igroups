(function ($) {
    $.fn.dp_calendar = function (options) {
        var opts, events_array, date_selected, order_by, show_datepicker, onChangeMonth, onChangeDay, onClickMonthName, onClickEvents, DP_LBL_NO_ROWS, DP_LBL_SORT_BY, DP_LBL_TIME, DP_LBL_TITLE, DP_LBL_PRIORITY, div_main_date, main_date, prev_month, toggleDP, next_month, div_dates, list_days, clear, day_name, calendar_list, h2_sort_by, cl_sort_by, li_time, li_title, li_priority, ul_list, $dp, curr_day, curr_day_name, curr_date, curr_month_name_short, curr_month, curr_month_name, curr_year, ul_list_days, added_events;
        opts = $.extend({}, $.fn.dp_calendar.defaults, options);
        events_array = opts.events_array;
        date_selected = opts.date_selected;
        order_by = opts.order_by;
        show_datepicker = opts.show_datepicker;
        onChangeMonth = opts.onChangeMonth;
        onChangeDay = opts.onChangeDay;
        onClickMonthName = opts.onClickMonthName;
        onClickEvents = opts.onClickEvents;
        DP_LBL_NO_ROWS = $.fn.dp_calendar.regional['']['DP_LBL_NO_ROWS'];
        DP_LBL_SORT_BY = $.fn.dp_calendar.regional['']['DP_LBL_SORT_BY'];
        DP_LBL_TIME = $.fn.dp_calendar.regional['']['DP_LBL_TIME'];
        DP_LBL_TITLE = $.fn.dp_calendar.regional['']['DP_LBL_TITLE'];
        DP_LBL_PRIORITY = $.fn.dp_calendar.regional['']['DP_LBL_PRIORITY'];

        function dp_str_pad(input, pad_length, pad_string, pad_type) {
            var half = '',
                pad_to_go, str_pad_repeater;
            str_pad_repeater = function (s, len) {
                var collect = '',
                    i;
                while (collect.length < len) {
                    collect += s
                }
                collect = collect.substr(0, len);
                return collect
            };
            input += '';
            pad_string = pad_string !== undefined ? pad_string : ' ';
            if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
                pad_type = 'STR_PAD_RIGHT'
            }
            if ((pad_to_go = pad_length - input.length) > 0) {
                if (pad_type === 'STR_PAD_LEFT') {
                    input = str_pad_repeater(pad_string, pad_to_go) + input
                } else if (pad_type === 'STR_PAD_RIGHT') {
                    input = input + str_pad_repeater(pad_string, pad_to_go)
                } else if (pad_type === 'STR_PAD_BOTH') {
                    half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
                    input = half + input + half;
                    input = input.substr(0, pad_length)
                }
            }
            return input
        }
        function dp_in_array(needle, haystack, argStrict) {
            var key = '',
                strict = !! argStrict;
            if (strict) {
                for (key in haystack) {
                    if (haystack[key] === needle) {
                        return true
                    }
                }
            } else {
                for (key in haystack) {
                    if (haystack[key] == needle) {
                        return true
                    }
                }
            }
            return false
        }
        function calculeDates() {
            var newLI, newText, i;
            curr_day = date_selected.getDay();
            curr_day_name = $.datepicker.regional[""].dayNames[curr_day];
            curr_date = date_selected.getDate();
            curr_month = date_selected.getMonth();
            curr_month_name = $.datepicker.regional[""].monthNames[curr_month];
            curr_month_name_short = $.datepicker.regional[""].monthNamesShort[curr_month];
            curr_year = date_selected.getFullYear();
            $.fn.dp_calendar.date_selected = date_selected;
            $.fn.dp_calendar.order_by = order_by;
            $.fn.dp_calendar.curr_day = curr_day;
            $.fn.dp_calendar.curr_day_name = curr_day_name;
            $.fn.dp_calendar.curr_date = curr_date;
            $.fn.dp_calendar.curr_month = curr_month;
            $.fn.dp_calendar.curr_month_name = curr_month_name;
            $.fn.dp_calendar.curr_month_name_short = curr_month_name_short;
            $.fn.dp_calendar.curr_year = curr_year;
            while (ul_list_days.firstChild) {
                ul_list_days.removeChild(ul_list_days.firstChild)
            }
            if (order_by === 1) {
                events_array.sort()
            }
            if (order_by === 2) {
                events_array.sort(function (a, b) {
                    a = a[1];
                    b = b[1];
                    return a == b ? 0 : (a < b ? -1 : 1)
                })
            }
            if (order_by === 3) {
                events_array.sort(function (a, b) {
                    a = a[3];
                    b = b[3];
                    return a == b ? 0 : (a > b ? -1 : 1)
                })
            }
            for (i = 1; i <= new Date(curr_year, (curr_month + 1), 0).getDate(); i++) {
                newLI = document.createElement("li");
                if (curr_date === i) {
                    newLI.setAttribute("class", "active")
                }
                newText = document.createTextNode(dp_str_pad(i, 2, "0", "STR_PAD_LEFT"));
                newLI.appendChild(newText);
                ul_list_days.appendChild(newLI)
            }
            ul_list_days.style.width = (new Date(curr_year, (curr_month + 1), 0).getDate() * 14) + "px";
            $("#list_days li").click(function (e) {
                date_selected = new Date(curr_year, curr_month, $(this).html());
                $("#list_days li").each(function (i) {
                    this.className = ""
                });
                this.className = "active";
                calculeDates();
                onChangeDay()
            });
            $("#day_name").html("");
            //$("#day_name").append("<h1>" + curr_day_name + ', ' + curr_month_name_short + ' ' + dp_str_pad(curr_date, 2, "0", "STR_PAD_LEFT") + '</h1>');
            $dp.datepicker("setDate", date_selected);
            $("#toggleDP").html(curr_month_name + " " + curr_year);
            $("#list").html("<div class='loading'></div>");
            added_events = 0;
            $(events_array).each(function (i) {
                if (typeof (this[0]) == "object") {
                    if (curr_year === this[0].getFullYear() && curr_month === this[0].getMonth()) {
                        $("#list_days").children("li")[(this[0].getDate() - 1)].className = $("#list_days").children("li")[(this[0].getDate() - 1)].className == "active" ? "active" : "has_events"
                    }
                    if (new Date(date_selected.getFullYear(), date_selected.getMonth(), date_selected.getDate()).getTime() === new Date(this[0].getFullYear(), this[0].getMonth(), this[0].getDate()).getTime()) {
                        var li_event, li_event_time, li_event_title, li_event_description;
                        if (added_events === 0) {
                            $("#list").html("")
                        }
                        added_events++;
                        li_event = document.createElement("li");
                        if (this[3] == 1) {
                            li_event.setAttribute("class", "low")
                        } else if (this[3] == 2) {
                            li_event.setAttribute("class", "medium")
                        } else {
                            li_event.setAttribute("class", "urgent")
                        }
                        $(ul_list).append(li_event);
                        li_event_time = document.createElement("div");
                        li_event_time.setAttribute("class", "time");
                        $(li_event_time).append(dp_str_pad(this[0].getHours(), 2, "0", "STR_PAD_LEFT") + ":" + dp_str_pad(this[0].getMinutes(), 2, "0", "STR_PAD_LEFT"));
                        li_event_title = document.createElement("h1");
                        $(li_event_title).append(this[1]);
                        clear = document.createElement("div");
                        clear.setAttribute("class", "clear");
                        li_event_description = document.createElement("p");
                        $(li_event_description).append(this[2]);
                        $(li_event).append(li_event_time);
                        $(li_event).append(li_event_title);
                        $(li_event).append(clear);
                        $(li_event).append(li_event_description)
                    }
                }
            });
            $("#list li").click(function (e) {
                onClickEvents();
                if ($(this).find("p").css("display") === "none") {
                    $(this).find("p").slideDown(300)
                } else {
                    $(this).find("p").slideUp(300)
                }
            });
            if (added_events === 0) {
                $("#list").html(DP_LBL_NO_ROWS)
            }
        }
        this.addClass("dp_calendar");
        this.html("");
        div_main_date = document.createElement("div");
        div_main_date.setAttribute("class", "div_main_date");
        main_date = document.createElement("div");
        main_date.setAttribute("class", "main_date");
        div_main_date.appendChild(main_date);
        prev_month = document.createElement("a");
        prev_month.setAttribute("href", "javascript:void(0);");
        prev_month.setAttribute("id", "prev_month");
        $(prev_month).append("&laquo;");
        toggleDP = document.createElement("a");
        toggleDP.setAttribute("href", "javascript:void(0);");
        toggleDP.setAttribute("id", "toggleDP");
        next_month = document.createElement("a");
        next_month.setAttribute("href", "javascript:void(0);");
        next_month.setAttribute("id", "next_month");
        $(next_month).append("&raquo;");
        main_date.appendChild(prev_month);
        main_date.appendChild(toggleDP);
        main_date.appendChild(next_month);
        this.append(div_main_date);
        div_dates = document.createElement("div");
        div_dates.setAttribute("class", "div_dates");
        list_days = document.createElement("ul");
        list_days.setAttribute("id", "list_days");
        clear = document.createElement("div");
        clear.setAttribute("class", "clear");
        day_name = document.createElement("div");
        day_name.setAttribute("class", "day_name");
        day_name.setAttribute("id", "day_name");
        div_dates.appendChild(list_days);
        div_dates.appendChild(clear);
        div_dates.appendChild(day_name);
        this.append(div_dates);
        calendar_list = document.createElement("div");
        calendar_list.setAttribute("class", "calendar_list");
        h2_sort_by = document.createElement("h2");
        $(h2_sort_by).append(DP_LBL_SORT_BY);
        cl_sort_by = document.createElement("ul");
        cl_sort_by.setAttribute("id", "cl_sort_by");
        li_time = document.createElement("li");
        if (order_by === 1) {
            li_time.setAttribute("class", "active")
        }
        $(li_time).append(DP_LBL_TIME);
        li_title = document.createElement("li");
        if (order_by === 2) {
            li_title.setAttribute("class", "active")
        }
        $(li_title).append(DP_LBL_TITLE);
        li_priority = document.createElement("li");
        if (order_by === 3) {
            li_priority.setAttribute("class", "active")
        }
        $(li_priority).append(DP_LBL_PRIORITY);
        cl_sort_by.appendChild(li_time);
        cl_sort_by.appendChild(li_title);
        cl_sort_by.appendChild(li_priority);
        ul_list = document.createElement("ul");
        ul_list.setAttribute("id", "list");
        //calendar_list.appendChild(h2_sort_by);
        //calendar_list.appendChild(cl_sort_by);
        calendar_list.appendChild(clear);
        calendar_list.appendChild(ul_list);
        this.append(calendar_list);
        $dp = $("<input type='text' />").hide().datepicker({
            onSelect: function (dateText, inst) {
                date_selected = new Date(dateText);
                calculeDates()
            }
        }).appendTo('body');
        $("#toggleDP").click(function (e) {
            if (show_datepicker === true) {
                if ($dp.datepicker('widget').is(':hidden')) {
                    $dp.datepicker("show");
                    $dp.datepicker("widget").position({
                        my: "top",
                        at: "top",
                        of: this
                    })
                } else {
                    $dp.hide()
                }
            }
            onClickMonthName();
            e.preventDefault()
        });
        ul_list_days = document.getElementById("list_days");
        calculeDates();
        $("#next_month").click(function (e) {
            date_selected = date_selected.add(1).month();
            calculeDates();
            onChangeMonth()
        });
        $("#prev_month").click(function (e) {
            date_selected = date_selected.add(-1).month();
            calculeDates();
            onChangeMonth()
        });
        $("#cl_sort_by li").click(function (e) {
            $("#cl_sort_by li").each(function (i) {
                this.className = ""
            });
            this.className = "active";
            $("#cl_sort_by li").each(function (i) {
                if (this.className === "active") {
                    order_by = (i + 1)
                }
            });
            calculeDates()
        })
    };
    $.fn.dp_calendar.defaults = {
        events_array: new Array(),
        date_selected: new Date(),
        order_by: 1,
        show_datepicker: true,
        onChangeMonth: function () {},
        onChangeDay: function () {},
        onClickMonthName: function () {},
        onClickEvents: function () {}
    };
    $.fn.dp_calendar.date_selected = $.fn.dp_calendar.defaults.date_selected;
    $.fn.dp_calendar.order_by = $.fn.dp_calendar.defaults.order_by;
    $.fn.dp_calendar.curr_day = "";
    $.fn.dp_calendar.curr_day_name = "";
    $.fn.dp_calendar.curr_date = "";
    $.fn.dp_calendar.curr_month = "";
    $.fn.dp_calendar.curr_month_name = "";
    $.fn.dp_calendar.curr_month_name_short = "";
    $.fn.dp_calendar.curr_year = "";
    $.fn.dp_calendar.regional = [];
    $.fn.dp_calendar.regional[''] = {
        closeText: 'Done',
        prevText: 'Prev',
        nextText: 'Next',
        currentText: 'Today',
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        DP_LBL_NO_ROWS: '',
        DP_LBL_SORT_BY: 'Sort by',
        DP_LBL_TIME: 'time',
        DP_LBL_TITLE: 'name',
        DP_LBL_PRIORITY: 'priority'
    };
    $.fn.dp_calendar.setDate = function (date) {
        $.fn.dp_calendar({
            date_selected: date
        })
    };
    $.fn.dp_calendar.setDay = function (day) {
        $.fn.dp_calendar({
            date_selected: new Date($.fn.dp_calendar.curr_year, $.fn.dp_calendar.curr_month, day)
        })
    };
    $.fn.dp_calendar.setMonth = function (month) {
        $.fn.dp_calendar({
            date_selected: new Date($.fn.dp_calendar.curr_year, month, $.fn.dp_calendar.curr_date)
        })
    };
    $.fn.dp_calendar.setYear = function (year) {
        $.fn.dp_calendar({
            date_selected: new Date(year, $.fn.dp_calendar.curr_month, $.fn.dp_calendar.curr_date)
        })
    };
    $.fn.dp_calendar.getDate = function () {
        return $.fn.dp_calendar.date_selected
    };
    $.fn.dp_calendar.getDay = function () {
        return $.fn.dp_calendar.curr_date
    };
    $.fn.dp_calendar.getMonth = function () {
        return $.fn.dp_calendar.curr_month
    };
    $.fn.dp_calendar.getYear = function () {
        return $.fn.dp_calendar.curr_year
    }
})(jQuery);