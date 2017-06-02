$(function() {
    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
});

//var flag = 0;
//$(function() {
//    ('#login-form-link').click(function(flag){
//        flag = 0;
//    });
//    ('#register-form-link').click(function(flag){
//        flag = 1;
//    });
//});
//
//if(flag === 1){
//    $("#login-form").delay(100).fadeIn(100);
// 		$("#register-form").fadeOut(100);
//		$('#register-form-link').removeClass('active');
//		$(this).addClass('active');
//		e.preventDefault();
//}else{
//    $("#register-form").delay(100).fadeIn(100);
// 		$("#login-form").fadeOut(100);
//		$('#login-form-link').removeClass('active');
//		$(this).addClass('active');
//		e.preventDefault();
//}