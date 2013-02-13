
function fcontrol(param)
{
$('input[type=checkbox]').change(function () { 
var id = $(this).attr('id');

var filter_arr = new Array();
var filter='';
var status = $('input[type=checkbox]').filter('.custom').map(function(){
var name = $(this).attr('name');

if($(this).is(':checked'))
{
filter_arr.push(name);
}
else
{}
});

for(var x=0;x<filter_arr.length;x++)
{
 if(x==filter_arr.length-1)
 filter = filter+x+'='+filter_arr[x];
 else
 filter = filter+x+'='+filter_arr[x]+'&';
}

var and_='';
if (filter!=''){
and_='&';}
var loc=filter;
window.location.href = 'index.php?eis='+param+'&selector=Studiengaenge'+and_+loc;
});
}