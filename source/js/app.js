/***************************************************
 * BY: Randy S. Baker
 * ON: 17-MAR-2020
 * FILE: app.js
 * NOTE: Application scripts & helpers...
 ***************************************************/

 /**************************************
 * Get the current environment...
 **************************************/
var strHost = window.location.hostname;
if (strHost == 'localhost')
{
  var strURL = 'http://localhost/fixyourfunnel/';
} else {
  var strURL = 'https://www.domain.com/';
}

/**************************************
 * Check if document is 'ready'...
 **************************************/
$(document).ready(function(){
  console.log('Application ready...');
});

/**************************************
 * Disabled links...
 **************************************/
$(document).ready(function(){
  $('.disabled-link').on('click', function(event){
    event.preventDefault();
    return false;
  });
});

/**************************************
 * Open links in a new tab / window...
 **************************************/
$(document).ready(function(){
  $('.new-window').on('click', function(event){
    event.preventDefault();
    if ($(this).attr('data-enabled') != 'false')
    {
      window.open($(this).attr('data-url'), '_blank');
    }
  });
});

/**************************************
 * Open links in same tab / window...
 **************************************/
$(document).ready(function(){
  $('.same-window').on('click', function(event){
    event.preventDefault();
    if ($(this).attr('data-enabled') != 'false')
    {
      window.open($(this).attr('data-url'), '_self');
    }
  });
});

/****************************************
 * Initialize FancyBox...
 ****************************************/
$(document).ready(function(){
  $().fancybox({
    selector : '.fancybox'
  });
});