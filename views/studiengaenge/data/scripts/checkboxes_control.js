function filter(arrayFromPHP)
{
$.each(arrayFromPHP, function (i, elem) {
$('#'+elem).attr('checked',true);
});
}