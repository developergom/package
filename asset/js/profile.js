/** PROFILE SECTION **/
$('#qf-profile').hide();
$('.action').css('visibility', 'hidden');
$('#birth-section').mouseover(function () {
    $('#qe-profile').css('visibility', 'visible');
}).mouseleave(function () {
    $('#qe-profile').css('visibility', 'hidden');
});
$('#qt-profile').click(function (e) {
    e.preventDefault();
    $('#qf-profile').fadeIn();
});
$('#cqe-profile').click(function () {
    $('#qf-profile').fadeOut();
});

//Datemask dd/mm/yyyy
$("#ubirth").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

$('#qf-avatar').hide();
$('.action-avatar').css('visibility', 'hidden');
$('#avatar-section').mouseover(function () {
    $('#qe-avatar').css('visibility', 'visible');
}).mouseleave(function () {
    $('#qe-avatar').css('visibility', 'hidden');
});
$('#qt-avatar').click(function (e) {
    e.preventDefault();
    $('#qf-avatar').fadeIn();
});
$('#cqe-avatar').click(function () {
    $('#qf-avatar').fadeOut();
});

/*****************************/
/*********END PROFILE*********/