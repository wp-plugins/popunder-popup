function _popunderpopup_submit()
{
	if(document.popunderpopup_form.url.value == "")
	{
		alert("Enter popunder popup url. url must start with either http or https.")
		document.popunderpopup_form.url.focus();
		return false;
	}
}

function _popunderpopup_submit_setting()
{
	if(document.popunderpopup_form_setting.popunderpopup_session.value == "")
	{
		alert("Select session option for popunder popup.")
		document.popunderpopup_form_setting.popunderpopup_session.focus();
		return false;
	}
}

function _popunderpopup_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_popunderpopup_display.action="options-general.php?page=popunder-popup&ac=del&did="+id;
		document.frm_popunderpopup_display.submit();
	}
}	

function _popunderpopup_redirect()
{
	window.location = "options-general.php?page=popunder-popup";
}

function _popunderpopup_help()
{
	window.open("http://www.gopiplus.com/work/2014/05/13/popunder-popup-wordpress-plugin/");
}

function _popunderpopup_checkall(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}