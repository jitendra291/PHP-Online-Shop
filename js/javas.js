$(':radio').change(
  function(){
    $('.choice').text( this.value + ' stars' );
  } 
)
function showLoginArea(){
 var lval = document.getElementById("loginLink").offsetLeft;
 var tval = document.getElementById("loginLink").offsetTop;
 var la = document.getElementById("login");
}

function regInit()
{
 document.getElementById("regemailid").focus();
}

function checkNumber(obj)
{
 if(isNaN(obj.value))
 {
  obj.value = "";
  obj.focus();
 }else if(obj.value < 0){
   obj.value = "";
   obj.focus();
 }
}

function checkLength(val, str){
  if(str == "pincode"){
    if(val.length != 6){
      return "Invalid Pincode!";
    }
  }else if(str == "mobileno"){
    if(val.length != 10){
      return "Invalid Mobile No!";
    }
  }else if(str == "emailid"){
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!filter.test(val)){
      return "Invalid email address!";
    }
  }
  return 0;
}

function validateLogin()
{
 var res = true;
 var e1 = document.getElementById("loginError1");
 var e2 = document.getElementById("loginError2");

 var eid = document.getElementById("emailid").value;
 var pass = document.getElementById("password").value;

 if(eid == "")
 {
  e1.style.display = "block";
  res = false;
 }
 else
 {
  e1.style.display = "none";
 }

 if(pass == "")
 {
  e2.style.display = "block";
  res = false;
 }
 else
 {
  e2.style.display = "none";
 }

 return res;
}


function formValidate(form,err,passVal,pass1,pass2){
 var res = false;
 var i=0;
 var f = document.getElementById(form);
 var eleCount = f.elements.length - 2;
 if(f.id == "orderForm1"){
  eleCount = 6;
 }
 for(i=0;i<eleCount;i++){
  var e = document.getElementById(err+(i+1));
  if(f.elements[i].value == ""){
    e.style.display = "inline-block";
    e.innerHTML = "Field Empty!";
    if(!res){
      f.elements[i].focus();
      res = true;
    }
  }else{
    var lengthValidation = checkLength(f.elements[i].value, f.elements[i].name);
    if(lengthValidation != 0){
      e.style.display = "inline-block";
      e.innerHTML = lengthValidation;
      if(!res){
	 f.elements[i].focus();
	 res = true;
      }
    }else{
      e.style.display = "none";
    }
  }
 }
 
 if(passVal == 1){
   pass1 = pass1 - 1;
   pass2 = pass2 - 1;
   var er = document.getElementById(err+(pass2+1));
   if((f.elements[pass1].value != "")&&(f.elements[pass2].value != "")){
     if(f.elements[pass1].value != f.elements[pass2].value){
       er.innerHTML = "Password Mismatch!!!"
       er.style.display = "inline-block";
       if(!res){
	  f.elements[pass2].focus();
         res = true;
       }
     }else{
       er.innerHTML = "Please Re-enter your Password!!!";
       er.style.display = "none";
     }
   }
 }
 
 return !res;
}

function searchValidate(obj){
  if(obj.elements[0].value == ""){
    return false;
  }else{
    return true;
  }
}

