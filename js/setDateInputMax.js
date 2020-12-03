
// For form input with type=date and class of .datepicker
// Sets the maximum enterable date equal to today's date

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0
var yyyy = today.getFullYear();

if (dd < 10) {
  dd = '0' + dd;
} 

if (mm < 10) {
  mm = '0' + mm;
} 

today = yyyy + '-' + mm + '-' + dd;
document.querySelector('.datepicker').setAttribute('max', today);