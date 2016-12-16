// ====== Active menu in nav bar. =======
// URL of current page.
var url = window.location;
$('ul.nav a').filter(function () {
    return this.href == url;
}).parent().addClass('active');
// ======================================

