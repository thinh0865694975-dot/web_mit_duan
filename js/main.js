$(document).ready(function () {

    // Load page khi click menu
    $('.menu-link').click(function (e) {
        e.preventDefault();

        let page = $(this).data('page');
        $('#main-content').load('pages/' + page + '.html');

        // Active menu
        $('.menu-link').removeClass('active');
        $(this).addClass('active');
    });

    // Load trang mặc định
    $('#main-content').load('pages/users.html');
});
