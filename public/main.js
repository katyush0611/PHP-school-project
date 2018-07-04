var id = $('#stdName').attr('class');

$('#edit-std').click(function(e) {
  // event.preventDefault();

  var stdName = $('#stdName').text();
  var stdEmail = $('#stdEmail').text();
  var stdPhone = $('#stdPhone').text();
  var stdImg = $('.form-img').attr('id');

  editStudentForm(stdName, stdImg, stdPhone, stdEmail);
  
  var sog = $('.signed-course');
  $('<button>').text('🗑').attr('class', 'deletesignedstd')
  .click(function(event) {
    event.preventDefault();
    var student_id = $('#stdInfo').attr('class');
    var course_id = $(this).parent().attr('id');
    window.location.replace(student_id+'/unsign/'+course_id);
  }).appendTo(sog);

  $('#edit-std').unbind();

});

$('#edit-crs').click(function(e) {
  // event.preventDefault();
  console.log("clicked");

  var course_img = $('.form-img').attr('id');
  var course_name = $('#crsName').text();
  var course_description = $('#crsDes').text();

  editCourseForm(course_name, course_img, course_description);

  var std = $('.showstd');

  $('<button>').text('🗑').attr('class', 'deletesignedstd')
  .click(function(event) {
    event.preventDefault();
    var course_id = $('.crsInfo').attr('id');
    var student_id = $(this).parent().attr('id');
    // console.log('hello');
    window.location.replace('/unsign/'+student_id+'/from/'+course_id);
  }).appendTo(std);
  $('#edit-crs').unbind();

});

$('#addcourse').click(function(event) {
  event.preventDefault();

  if ($('main').length) {
    $('main').empty();
    $('main').css('height', '15%');
    newCourseForm();
  } else {
    var main_section = $('#main_section');
    $('<main>').appendTo(main_section);
    $('main').css('height', '15%');
    newCourseForm();
  }

});

$('#addstudent').click(function(event) {
  event.preventDefault();

  if ($('main').length) {
    $('main').empty();
    $('main').css('height', '20%');
    newStudentForm();
  } else {
    var main_section = $('#main_section');
    $('<main>').appendTo(main_section);
    $('main').css('height', '20%');
    newStudentForm();
  }
});

function newCourseForm() {
  $('<form>').attr({
    class: 'new-object-form',
    method: 'POST',
    action: '/coursecreated',
    enctype: 'multipart/form-data',
  }).appendTo('main');
  $('main').css('height', '50vh');

  $('<input>').attr({
    class: 'img-input',
    type: 'file',
    name: 'img',
  }).prop('required',true).appendTo('form');

  $('<input>').attr({
    class: 'new-object-input',
    type: 'text',
    name: 'name',
    placeholder: 'Insert name',
  }).prop('required',true).appendTo('form');
  
  $('<input>').attr({
    class: 'new-object-input',
    type: 'text',
    name: 'description',
    placeholder: 'Insert description',
  }).prop('required',true).appendTo('form');
  
  $('<input>').attr({
    type: 'submit',
    value: 'add new course',
  }).appendTo('form');
  return $('form');
};

function newStudentForm() {
  $('<form>').attr({
    class: 'new-object-form',
    method: 'POST',
    action: '/studentadded',
    enctype: 'multipart/form-data',
  }).appendTo('main');
  $('main').css('height', '55vh');

  $('<input>').attr({
    class: 'img-input',
    type: 'file',
    name: 'img',
  }).prop('required',true).appendTo('form');

  $('<input>').attr({
    class: 'new-object-input',
    type: 'text',
    name: 'name',
    placeholder: 'Insert name',
  }).prop('required',true).appendTo('form');

  $('<input>').attr({
    class: 'new-object-input',
    type: 'text',
    name: 'email',
    placeholder: 'Insert email',
  }).prop('required',true).appendTo('form');

  $('<input>').attr({
    class: 'new-object-input',
    type: 'text',
    name: 'phone',
    placeholder: 'Insert phone number',
  }).prop('required',true).appendTo('form');

  $('<input>').attr({
    type: 'submit',
    value: 'add new student',
  }).appendTo('form');

  return $('form');

};

$('#deletestd').click(function(event) {
  event.preventDefault();
  var r = confirm("Are you sure you want to delete?");
  if (r == true) {
    var id = $('#stdName').attr('class');
    window.location.replace('/'+id+'/deleted');
    console.log(id);
  } else {
    console.log("XXX");
  }
});

$('#deletecrs').click(function(event) {
  event.preventDefault();
  var r = confirm("Are you sure you want to delete?");
    if (r == true) {
      var id = $('#crsName').attr('class');
      window.location.replace('/deleted/'+id);
      console.log(id);
    } else {
      console.log("XXX");
    }
});

$('#logo').click(function(event) {
  window.location.replace('/welcom');
});



$('.stdimg').click(function(event) {
  var stdid = $(this).parent().attr('id');
  window.location.replace('/'+stdid);
});

function editCourseForm (course_name, course_img, course_description) {
  $('#crsmain').css('width', '100%');
  $('.crsInfo').attr('style', 'width: 50%;');
  $('.form-img').css('width', '50%');
  $('<div>').attr('id', 'changeble').insertAfter('.form-img');
  $('<div>').attr({
    class: 'data-row',
    id: 'name-row'
  }).appendTo('#changeble');
  $('<div>').attr({
    class: 'data-row',
    id: 'description-row'
  }).appendTo('#changeble');

  $('<input>').attr({
    id: 'img-saver',
    type: 'text',
    name: 'sameImg',
    style: 'display: none;',
    value: course_img, 
  }).insertAfter('.form-img');

  $('.form-img').click(function(e) {
    event.preventDefault();
    $(this).replaceWith(function() {
        return $('<input>').attr({
          type: 'file',
          name: 'crsImg',
          id: 'form-img',
        }).prop('required', true);
    });
    $('#img-saver').remove();
  });

  $('<label>').attr('id', 'name_label').text(course_name)
  .appendTo('#name-row');
  $('<div>').text('✎').attr({
    id: 'edit_name',
    class: 'thisinput',
  }).insertAfter('#name_label');
  $('<input>').attr({
      type: 'text',
      style: 'display: none;',
      name: 'crsName',
      class: 'edit-object-input',
      id: 'name_input',
      value: course_name,
    }).insertAfter($('#edit_name'));

  $('<label>').attr('id', 'des_label').text(course_description)
  .appendTo('#description-row');
  $('<div>').text('✎').attr({
    id: 'edit_des',
    class: 'thisinput',
  }).insertAfter('#des_label');
  $('<input>').attr({
    id: 'description_input', 
    type: 'text',
    style: 'display: none;',
    name: 'crsDes',
    class: 'edit-object-input',
    value: course_description,
  }).insertAfter($('#edit_des'));  

  $('<input>').attr({
    type: 'submit',
    id: 'submit-crs',
    value: 'Update',
    name: 'sumbit',
  }).insertAfter('#changeble');

  $('.data').remove();

  $('.thisinput').click(function(event) {
    $(this).hide();
    $(this).prev().hide();
    $(this).next().show();
    $(this).next().select();
  });
  $('.edit-object-input').blur(function() {
    if ($.trim(this.value) == '') {
       this.value = (this.defaultValue ? this.defaultValue : '');
     } else {
       $(this).prev().prev().html(this.value);
       console.log(this.value);
       $(this).attr('value', this.value);
     }
 
     $(this).hide();
     $(this).prev().show();
     $(this).prev().prev().show();
  });
 
    $('.edit-object-input').keypress(function(event) {
      if (event.keyCode == '13') {
        if ($.trim(this.value) == ''){
         this.value = (this.defaultValue ? this.defaultValue : '');
       } else {
         $(this).prev().prev().html(this.value);
         $(this).attr('value', this.value);
       }
 
       $(this).hide();
       $(this).prev().show();
       $(this).prev().prev().show();
      }
    });

    $('#main').attr('style', 'display: block;');
};

function editStudentForm (student_name, student_img, student_phone, student_email) {
  $('#main').attr('style', 'width: 100%;');
  $('.form-img').attr('style', 'width: 25%; height: 40vh;');
  $('.container').attr('style', 'display: initial;');
  $('<div>').attr('id', 'changeble').insertAfter('.form-img');
  $('<div>').attr({
    class: 'data-row',
    id: 'name-row'
  }).appendTo('#changeble');

  $('<input>').attr({
    id: 'img-saver',
    type: 'text',
    name: 'sameImg',
    style: 'display: none;',
    value: student_img, 
  }).insertAfter('.form-img');

  $('.form-img').click(function(e) {
    event.preventDefault();
    $(this).replaceWith(function() {
        return $('<input>').attr({
          type: 'file',
          name: 'stdImg',
          id: 'form-img',
        }).prop('required', true);
    });
    $('#img-saver').remove();
  });
  $('<label>').attr('id', 'name_label').text(student_name)
  .appendTo('#name-row');

  $('<div>').text('✎').attr({
    id: 'edit_name',
    class: 'thisinput',
  }).insertAfter('#name_label');
  $('<input>').attr({
      type: 'text',
      style: 'display: none;',
      name: 'stdName',
      class: 'edit-object-input',
      id: 'name_input',
      value: student_name,
    }).insertAfter($('#edit_name'));

  $('<div>').attr({
    class: 'data-row',
    id: 'email-row'
  }).insertAfter('#name-row');
  $('<label>').attr('id', 'email_label').text(student_email)
  .appendTo('#email-row');

  $('<div>').text('✎').attr({
    id: 'edit_email',
    class: 'thisinput',
  }).insertAfter('#email_label');

  $('<input>').attr({
    id: 'email_input',
    type: 'text',
    style: 'display: none;',
    name: 'stdEmail',
    class: 'edit-object-input',
    value: student_email,
  }).insertAfter('#edit_email'); 

  $('<div>').attr({
    class: 'data-row',
    id: 'phone-row',
  }).insertAfter('#email-row');

  $('<label>').attr('id', 'phone_label').text(student_phone)
  .appendTo('#phone-row');

  $('<div>').text('✎').attr({
    id: 'edit_phone',
    class: 'thisinput',
  }).insertAfter('#phone_label');

  $('<input>').attr({
      id: 'phone_input',
      type: 'text',
      style: 'display: none;',
      name: 'stdPhone',
      class: 'edit-object-input',
      value: student_phone,
    }).insertAfter('#edit_phone');  

  $('<input>').attr({
    type: 'submit',
    id: 'submit-std',
    value: 'Modify Info',
    name: 'sumbit',
  }).appendTo('#main');

  $('.data').remove();

  $('.thisinput').click(function(event) {
    $(this).hide();
    $(this).prev().hide();
    $(this).next().show();
    $(this).next().select();
  });
  $('.edit-object-input').blur(function() {
    if ($.trim(this.value) == '') {
       this.value = (this.defaultValue ? this.defaultValue : '');
     } else {
       $(this).prev().prev().html(this.value);
       console.log(this.value);
       $(this).attr('value', this.value);
     }
 
     $(this).hide();
     $(this).prev().show();
     $(this).prev().prev().show();
  });
 
    $('.edit-std-input').keypress(function(event) {
      if (event.keyCode == '13') {
        if ($.trim(this.value) == ''){
         this.value = (this.defaultValue ? this.defaultValue : '');
       } else {
         $(this).prev().prev().html(this.value);
         $(this).attr('value', this.value);
       }
 
       $(this).hide();
       $(this).prev().show();
       $(this).prev().prev().show();
      }
    });
};

$(document).ready(function() {
  
  $(".selLabel").click(function () {
    $('.dropdown').toggleClass('active');
  });
  
  $(".dropdown-list li").click(function() {
    $('.selLabel').text($(this).text());

    $('.dropdown').removeClass('active');
    var course_id = $(this).attr('id');
    console.log(course_id);
    window.location.replace('/'+id+'/signedto/'+course_id);
  });
  
});
$('#error-popup').appendTo('body');
if ($('#error-popup').length) {
  $('#main_section').css('opacity', '0.2');
  $('#back-header').css('opacity', '0.2');
};
$('.error-popup-button').click(function(e) {
  event.preventDefault();
  var id = $(this).attr('id'); 
  window.location.replace('/studenteditmode/'+id);
});
$('#error-login > button' ).css({
    width: '30%',
    height: '3rem',
    margin: '1rem 35%',
});
$('#error-login > button' ).click(function() {
  window.location.replace('/');  
});
$('#error-login').parent().css('backgroundColor', '#00334d');
$('#error-login').css({
  backgroundColor: '#ff1a1a',
  width: '40%',
  margin: '10rem auto',
});
$('#error-login > h1').css({
  fontFamily: 'monospace',
  color: '#f2f2f2',
  marginLeft: '9%',
});


$('#backtonew').click(function(e) {
  event.preventDefault();
  window.location.replace('/addingnewstudent');
});

$('#done').click(function(event) {
  // event.preventDefault();
  window.location.replace('/welcom');
});

