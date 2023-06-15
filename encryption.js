function validate() {
	var valid = true;
	valid = checkEmpty($("#fileToUpload"));
	valid = valid && checkEmpty($("#fileToUpload2"));
    $("#btn-submit").attr("disabled",true);
	if(valid) {
		$("#btn-submit").attr("disabled",false);
	}	
}
function validated() {
	var valid = true;
	valid = checkEmpty($("#plaintextarea"));
	valid = valid && checkEmpty($("#keywordtextarea"));
    $("#btn-encrypt").attr("disabled",true);
	if(valid) {
		$("#btn-encrypt").attr("disabled",false);
	}	
}
function checkEmpty(obj) {
	var name = $(obj).attr("name");
	$("."+name+"-validation").html("");	
	$(obj).css("border","");
	if($(obj).val() == "") {
		$(obj).css("border","#FF0000 1px solid");
		$("."+name+"-validation").html("Required");
		return false;
	}
	return true;	
}
function enableButton2() {
    document.getElementById("btn-encrt").disabled = false;
 }
 