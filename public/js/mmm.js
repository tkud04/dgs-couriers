$(document).ready(() => {
  hideElem(['#track-popup-tnum-error']);

  $('#signup-submit').click(e => {
        e.preventDefault();
        let fname = $('#signup-fname').val(), lname = $('#signup-lname').val(), 
        email = $('#signup-email').val(), role = $('#signup-role').val(), 
        pass = $('#signup-password').val(), pass2 = $('#signup-password2').val(),
        validation = fname == "" || lname == "" || email == "" || role == "none" || pass == "" || pass2 == "" || pass !== pass2;

        if(validation){
          alert("All fields are require and passwords must match");
        }
        else{
            $('#signup-form').submit();
        }
    });

    $('#login-submit').click(e => {
        e.preventDefault();
        let email = $('#login-email').val(), pass = $('#login-password').val(),
        validation = email == "" || pass == "";

        if(validation){
          alert("All fields are required");
        }
        else{
            $('#login-form').submit();
        }
    });

    $('#track-popup-submit').click(e => {
      e.preventDefault();
      hideElem('#track-popup-tnum-error');
      let tnum = $('#track-popup-tnum').val();

      if(tnum == ""){
        showElem('#track-popup-tnum-error');
      }
      else{
        window.location = `track?num=${tnum}`;
      }
    });

    $('#quote-btn').click(e => {
      e.preventDefault();
     // hideElem('#track-popup-tnum-error');
      let name = $('#name').val(),  email = $('#email').val()
      subject = $('#subject').val(),  description = $('#description').val();

      if(name == "" || email == "" || subject == "" || description == ""){
        //showElem('#track-popup-tnum-error');
        alert("Please fill allrequired fields");
      }
      else{
        //window.location = `track?num=${tnum}`;
      }
    });
});

function removeStudent(c,s){
   let sure =  confirm("Are you sure? Press OK to cintinue");
   if(sure){
     window.location = `remove-student?class_id=${c}&student_id=${s}`;
   }
   else{}
}