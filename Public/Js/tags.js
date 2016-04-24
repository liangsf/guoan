function gettags(t,id){
	var pid = $(t).val();
	$.post("getAjaxTag", {pid:pid}, function(data){
		if (data.status==1) {
			tags = data.data;
			var html='';
			if(id == '#tag_w'){
				html = format_option(tags);
			}else{
				html = format_input(tags);
			}
			
			$(id).empty();
			$(id).html(html);
		}
	}, "json");
}
function format_option(data)
{
	var opt = '<option value="0" selected>请选择</option>';
	for(var i=0;i<data.length;i++){
		opt += '<option value="'+data[i].id+'" >'+data[i].name+'</option>';
	}
	return opt;
}
function format_input(data)
{
	var opt='';
	for(var i=0;i<data.length;i++){
		opt += '<input type="checkbox" name="tags[]" value="'+data[i].id+'" />'+data[i].name;
	}
	return opt;
}