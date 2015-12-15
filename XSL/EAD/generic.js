$(document).ready(function() {
    $('.toggle').nextAll().toggle();
    $('.toggle').click(function () {     
        $(this).nextAll().toggle(1200);
        var inner = $(this).text().charCodeAt(0);
        if (inner == '9660') {
            $(this).html('&#9650;');
        }
        if (inner == '9650') {
            $(this).html('&#9660;');
        }
    });
});
