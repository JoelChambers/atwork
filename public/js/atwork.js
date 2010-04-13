////
// atwork/js/atwork.js

function lpad(str, pad, len)
{
  str = String(str); // make sure it's a String
  while(str.length < len) {
    str = pad+str;
  }
  return str;
}

function load_day(day)
{
  $('#dialog').load('day.php', {d: day},
    function() {
      $('#dialog').dialog('option', 'title', day);
      $('#dialog').dialog('open');
    });
}

function load_month(month)
{
  // Update the calendar
  $('#month').load('month.php', {m: month},
    function() {
      $('.day').click(function() {
        load_day($(this).attr('title'));
      });
    });
}

$(function()
{
  load_month(0);
  
  $('#dialog').dialog({
    autoOpen: false,
    height:380,
    width:395,
    modal:false,
    draggable:false,
    resizable:false,
    buttons: {
      'Tallenna': function() {
        $('#timeform').submit();
      },
      'Oletus': function() {
        // Sets default hours
        $('#type').val('1');
        $('#lunch').attr('checked', 'checked');
        $('.start_h:first').val('10');
        $('.start_m:first').val('00');
        $('.finish_h:first').val('18');
        $('.finish_m:first').val('00');
      },
      'Peruuta': function() {
        $('#dialog').dialog('close');
      }
    }
  });
   
 $('a#next').button({icons: {primary: 'ui-icon-circle-triangle-e'}, text:false})
    .click(function(){
     load_month('+1');
     return false;
    });
   
 $('a#previous').button({icons: {primary: 'ui-icon-circle-triangle-w'}, text:false})
  .click(function() {
    load_month('-1');
    return false;
  });
 
 $('a#print').button({icons: {primary: 'ui-icon-print'}, text:false})
   .click(function() {
     var w = 820; var h = 800;
     var x = (screen.width/2)-(w/2);
     var y = (screen.height/2)-(h/2);
     window.open('print.php', 'Tulosta',
      'scrollbars=yes,menubar=no,location=no,width='+w+',height='+h+',left='+x+',top='+y);
     return false;
   });
   
 $('a#now').button({icons: {primary: 'ui-icon-home'}, text:false})
   .click(function() {
     load_month(0);
     return false;
   });
  
 $('a#refresh').button({icons: {primary: 'ui-icon-refresh'}, text:false})
   .click(function() {
     window.location.replace('/ma/public/');
     return false;
   });
   
 $('a#today').button({icons: {primary: 'ui-icon-calendar'}, text:false})
   .click(function() {
     // JS:s date formatting is not the best...
     var d = new Date();
     var year = d.getFullYear();
     var month = lpad(d.getMonth()+1, 0, 2);
     var day = lpad(d.getDate(), 0, 2);
     load_day(day+'.'+month+'.'+year);
     return false;
   });
});
