$(document).ready(function () {
    let nav = $('nav.mt-2');
    let activeItem = nav.find('a.active');
    activeItem.parents('li.has-treeview').addClass('menu-open');
});