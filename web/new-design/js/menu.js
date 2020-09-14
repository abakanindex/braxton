var button_toggle = document.getElementById("sidebar-toggle");
var left_menu = document.getElementById('left-menu');
var content = document.getElementById('content');
var wrap = document.getElementsByClassName('wrap')[0];
var current_width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
var current_range = 0;


if (current_width > 0 && current_width < 769){
    current_range = 1;
} else if (current_width > 769 && current_width < 992){
    current_range = 2;
} else if (current_width > 992){
    current_range = 3;
}


function toggle_menu(){
    left_menu.classList.toggle('toggling-menu-tosmall');
    content.classList.toggle('toggling-menu-content');
    wrap.classList.toggle('toggling-menu-wrap');
}

function resize(e) {
    var previous_range = current_range;

    current_width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
    if (current_width > 0 && current_width < 769) {
        current_range = 1;
    }
    else if (current_width > 769 && current_width < 992) {
        current_range = 2;
    }
    else if (current_width > 992) {
        current_range = 3;
    }


    if (previous_range != current_range) {
        left_menu.classList.remove('toggling-menu-tosmall');
        content.classList.remove('toggling-menu-content');
        wrap.classList.remove('toggling-menu-wrap');
    }
}

button_toggle.addEventListener('click', toggle_menu);
var time;
//window.addEventListener("resize", resize);

(function(){
    var time;
    window.onresize = function(e){
        if (time)
            clearTimeout(time);
        time = setTimeout(function(){
            resize(e);
        },10);
    }
})();




var notification = document.getElementById('notification');
var items = document.getElementById('items');
var settings = document.getElementById('settings');
var notification_menu = document.getElementById('notification-menu');
var items_menu = document.getElementById('items-menu');
var settings_menu = document.getElementById('settings-menu');
var menu_status = 0;

var right_part = document.getElementsByClassName('right-part')[0];

function smallmenu(e) {
    e = e || window.event;
    var target = e.target || e.srcElement;

    var element_id = target.parentElement.id || target.id;
    if (element_id == 'notification'){
        menu_status = 1;
        notification_menu.classList.toggle('right-menu');
        settings_menu.classList.remove('right-menu');
        items_menu.classList.remove('right-menu');
        notification.classList.toggle('active-right-menu');
        items.classList.remove('active-right-menu');
        settings.classList.remove('active-right-menu');

    } else if (element_id == 'settings') {
        menu_status = 1;
        settings.classList.toggle('active-right-menu');
        notification.classList.remove('active-right-menu');
        items.classList.remove('active-right-menu');
        notification_menu.classList.remove('right-menu');
        settings_menu.classList.toggle('right-menu');
        items_menu.classList.remove('right-menu');
    } else if (element_id == 'items'){
        menu_status = 1;
        items.classList.toggle('active-right-menu');
        notification.classList.remove('active-right-menu');
        settings.classList.remove('active-right-menu');
        notification_menu.classList.remove('right-menu');
        settings_menu.classList.remove('right-menu');
        items_menu.classList.toggle('right-menu');
    }
}

function remoove(e) {
    e = e || window.event;
    var target = e.target || e.srcElement;

    var element_id = target.parentElement.id || target.id;
    if((element_id == 'notification') || (element_id == 'settings') || (element_id == 'items')){
        console.log("MENU");
    } else if (menu_status == 1){
        notification_menu.classList.remove('right-menu');
        settings_menu.classList.remove('right-menu');
        items_menu.classList.remove('right-menu');
        notification.classList.remove('active-right-menu');
        items.classList.remove('active-right-menu');
        settings.classList.remove('active-right-menu');
        //console.log(element_id);
    }
    /*
    if (((element_id != 'notification') || (element_id != 'settings') || (element_id != 'items'))&&(menu_status == 1)){

        notification_menu.classList.remove('right-menu');
        settings_menu.classList.remove('right-menu');
        items_menu.classList.remove('right-menu');
        notification.classList.remove('active-right-menu');
        items.classList.remove('active-right-menu');
        settings.classList.remove('active-right-menu');
        console.log(element_id);
    }*/
}

right_part.addEventListener('click', smallmenu);

document.addEventListener('click', remoove);





































