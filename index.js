function logOut() {
    window.location.href = "action.php?action=logout";
}

$('#logOut').click(logOut);

setTimeout(function() {
    var e = $('#alert');
    var time = 1000; // ms
    e.animate({'opacity': 0}, time);
    setTimeout(function() {
        e.hide();
    }, time);
}, 1500);
