
var customerarray = new Array();
var customerarray1 = new Array();
var customerarray2 = new Array();
var customerarray3 = new Array();
var customerarray4 = new Array();
var process1;
var process2;
var process3;
var process4;


function formsubmit(command)
{
	var form = $('#submitform');
	var error = $('#form-error');
	var disablesmsaccount;
	var field = $('#disablesmsaccount').is(':checked');
	if(field == true) disablesmsaccount = 'yes'; else  disablesmsaccount = 'no';
	
	var croptext;
	var field = $('#croptext').is(':checked');
	if(field == true) croptext = 'yes'; else  croptext = 'no';
	
	var field = $('#contactperson');
	if(!field.val()) { error.html(errormessage("Enter the Contact Person Name . ")); field.focus(); return false; }
	if(field.val()) { if(!validatecontactperson(field.val())) { error.html(errormessage('Contact person name contains special characters. Please use only Alpha / Numeric / space.')); field.focus(); return false; } }
	
	var field = $('#emailid');
	if(!field.val()) { error.html(errormessage("Enter the Email ID. ")); field.focus(); return false; }
	if(field.val())	{ if(!emailvalidation(field.val())) { error.html(errormessage('Enter the valid Email ID.')); field.focus(); return false; } }
	
	
	var field = $('#cell');
	if(!field.val()) { error.html(errormessage("Enter the Cell Number. ")); field.focus(); return false; }
	if(field.val()) { if(!validatecell(field.val())) { error.html(errormessage('Enter the valid Cell Number.')); field.focus(); return false; } }
	
	var field = $('#accounttype');
	if(!field.val()) { error.html(errormessage("Select an Account Type")); field.focus(); return false; }
	
	var field = $('#username');
	if(!field.val()) { error.html(errormessage("Enter the Username. ")); field.focus(); return false; }
	if(field.val())	{ if(!validatesmsusername(field.val())) { error.html(errormessage('User Name is not valid (Allowed Aplhabhets, Numbers, Hyphen).')); field.focus(); return false; } }
	
	var field = $('#fromname');
	if(!field.val()) { error.html(errormessage("Enter the Fromname. ")); field.focus(); return false; }
	if(field.val())	{ if(!validatesmsfromname(field.val())) { error.html(errormessage('From Name is not valid (Allowed Aplhabhets, Numbers, Hyphen).')); field.focus(); return false; } }
	
	var field = $('#password');
	if(!field.val()) { error.html(errormessage("Enter the Password. ")); field.focus(); return false; }
	else
	{
		var passData = "";
		if(disablesmsaccount == 'no')
		{
			passData =  "switchtype=save&customerreference=" + encodeURIComponent($('#customerlist').val()) + "&contactperson=" + encodeURIComponent($('#contactperson').val()) + "&emailid=" + encodeURIComponent($('#emailid').val()) + "&cell=" + encodeURIComponent($('#cell').val())+ "&username=" + encodeURIComponent($('#username').val()) + "&fromname=" + encodeURIComponent($('#fromname').val()) +  "&password=" + encodeURIComponent($('#password').val())  + "&disablesmsaccount=" + encodeURIComponent(disablesmsaccount)+ "&croptext=" + encodeURIComponent(croptext) +  "&lastslno=" + encodeURIComponent($('#lastslno').val()) +  "&smslastslno=" + encodeURIComponent($('#smslastslno').val())+  "&accounttype=" + encodeURIComponent($('#accounttype').val()) + "&dummy=" + Math.floor(Math.random()*100000000);
		}
		else
		{
			passData =  "switchtype=disable&customerreference=" + encodeURIComponent($('#customerlist').val()) + "&disablesmsaccount=" + encodeURIComponent(disablesmsaccount) +  "&smslastslno=" + encodeURIComponent($('#smslastslno').val())+  "&accounttype=" + encodeURIComponent($('#accounttype').val()) + "&dummy=" + Math.floor(Math.random()*100000000);	
		}
		queryString = '../ajax/smsaccount.php';
		error.html(getprocessingimage());
		ajaxcall1 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
			success: function(ajaxresponse,status)
			{	
				if(ajaxresponse == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					var response = ajaxresponse.split('^');
					if(response[0] == '1')
					{
						error.html(successmessage(response[1]));
						newaccountentry();
						generateaccountgrid('');
					}
					else if(response[0] == '2')
					{
						error.html(errormessage(response[1]));
						//newentry();
					}
					else
					{
						error.html(errormessage('Unable to Connect...' + ajaxresponse));
					}
				}
			}, 
			error: function(a,b)
			{
				error.html(scripterror());
			}
		});	
	}
}

function gettotalcustomercount()
{
	var form = $('#customerselectionprocess');
	var passData = "switchtype=getcustomercount&dummy=" + Math.floor(Math.random()*10054300000);
	queryString = "../ajax/smsaccount.php";
	ajaxcall1 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse;
				if(response == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				$("#totalcount").html(response['count']);
				refreshcustomerarray(response['count']);
			}
		}, 
		error: function(a,b)
		{
			$("#customerselectionprocess").html(scripterror());
		}
	});	
}



function refreshcustomerarray(customercount)
{
	var form = $('#customerselectionprocess');
	var totalcustomercount = customercount;
	var limit = Math.round(totalcustomercount/4);
	//alert(limit);
	var startindex = 0;
	var startindex1 = (limit)+1;
	var startindex2 = (limit*2)+1;
	var startindex3 = (limit*3)+1;
	var form = $('#cardsearchfilterform');
	var passData = "switchtype=generatecustomerlist&dummy=" + Math.floor(Math.random()*10054300000) + "&limit=" + encodeURIComponent(limit) + "&startindex=" + encodeURIComponent(startindex);
	var passData1 = "switchtype=generatecustomerlist&dummy=" + Math.floor(Math.random()*10054300000) + "&limit=" + encodeURIComponent(limit) + "&startindex=" + encodeURIComponent(startindex1);
	var passData2 = "switchtype=generatecustomerlist&dummy=" + Math.floor(Math.random()*10054300000) + "&limit=" + encodeURIComponent(limit) + "&startindex=" + encodeURIComponent(startindex2);
	var passData3 = "switchtype=generatecustomerlist&dummy=" + Math.floor(Math.random()*10054300000) + "&limit=" + encodeURIComponent(limit) + "&startindex=" + encodeURIComponent(startindex3);
	$('#customerselectionprocess').html(getprocessingimage());
	queryString = "../ajax/smsaccount.php";
	ajaxcall2 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse;
				for( var i=0; i<response.length; i++)
				{
					customerarray1[i] = response[i];
				}
				process1 = true;
				compilecustomerarray();
			}
		}, 
		error: function(a,b)
		{
			$("#customerselectionprocess").html(scripterror());
		}
	});	
	
	queryString = "../ajax/smsaccount.php";
	ajaxcall3 = $.ajax(
	{
		type: "POST",url: queryString, data: passData1, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse;//alert(response)
				for( var i=0; i<response.length; i++)
				{
					customerarray2[i] = response[i];
				}
				process2 = true;
				compilecustomerarray();
			}
		}, 
		error: function(a,b)
		{
			$("#customerselectionprocess").html(scripterror());
		}
	});	

	queryString = "../ajax/smsaccount.php";
	ajaxcall4 = $.ajax(
	{
		type: "POST",url: queryString, data: passData2, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse;//alert(response)
				for( var i=0; i<response.length; i++)
				{
					customerarray3[i] = response[i];
				}
				process3 = true;
				compilecustomerarray();
			}
		}, 
		error: function(a,b)
		{
			$("#customerselectionprocess").html(scripterror());
		}
	});	
	
	queryString = "../ajax/smsaccount.php";
	ajaxcall5 = $.ajax(
	{
		type: "POST",url: queryString, data: passData3, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse;//alert(response)
				for( var i=0; i<response.length; i++)
				{
					customerarray4[i] = response[i];
				}
				process4 = true;
				compilecustomerarray();
			}
		}, 
		error: function(a,b)
		{
			$("#customerselectionprocess").html(scripterror());
		}
	});	

}

function compilecustomerarray()
{
	if(process1 == true && process2 == true && process3 == true && process4 == true)
	{
		customerarray = customerarray1.concat(customerarray2.concat(customerarray3.concat(customerarray4)));
		flag = true;
		$("#customerselectionprocess").html(successsearchmessage('All Customers...'))
		getcustomerlist1();
		
	}
	else
	return false;
}

function getcustomerlist1()
{	
	disableformelemnts();
	var form = $('#filterform');
	var selectbox = $('#customerlist');
	var numberofcustomers = customerarray.length;
	$('#detailsearchtext').focus();
	var actuallimit = 500;
	var limitlist = (numberofcustomers > actuallimit)?actuallimit:numberofcustomers;
	
	$('option', selectbox).remove();
	var options = selectbox.attr('options');
	//selectbox.options.length = 0;
	
	for( var i=0; i<limitlist; i++)
	{
		var splits = customerarray[i].split("^");
		options[options.length] = new Option(splits[0], splits[1]);
	}
}

function newaccountentry()
{
	var form = $('#submitform');
	$('#submitform')[0].reset();
	$('#lastslno').val('');
	$('#smslastslno').val('');
}

function selectfromlist()
{
	var selectbox = $("#customerlist option:selected").val();
	$('#detailsearchtext').val($("#customerlist option:selected").text());
	$('#detailsearchtext').select();
	$('#displaycustomername').html($("#customerlist option:selected").text());
	$('#form-error').html('');
	getcustomerid(selectbox);
	enableformelemnts();
	generateaccountgrid('');
	newaccountentry();
}

function selectacustomer(input)
{
	var selectbox = $('#customerlist');
	var pattern = new RegExp("^" + input.toLowerCase());
	
	if(input == "")
	{
		getcustomerlist1();
	}
		else
	{
		$('option', selectbox).remove();
		var options = selectbox.attr('options');
		var addedcount = 0;
		for( var i=0; i < customerarray.length; i++)
		{
				if(input.charAt(0) == "%")
				{
					withoutspace = input.substring(1,input.length);
					pattern = new RegExp(withoutspace.toLowerCase());
					comparestringsplit = customerarray[i].split("^");
					comparestring = comparestringsplit[1];
				}
				else
				{
					pattern = new RegExp("^" + input.toLowerCase());
					comparestring = customerarray[i];
				}
				var result1 = pattern.test(trimdotspaces(customerarray[i]).toLowerCase());
				var result2 = pattern.test(customerarray[i].toLowerCase());
				if(result1 || result2)
				{
					var splits = customerarray[i].split("^");
					options[options.length] = new Option(splits[0], splits[1]);
					addedcount++;
					if(addedcount == 100)
						break;
				}
		}
	}
}


function customersearch(e)
{ 
	var KeyID = (window.event) ? event.keyCode : e.keyCode;
	if(KeyID == 38)
		scrollcustomer('up');
	else if(KeyID == 40)
		scrollcustomer('down');
	else
	{
		var form = $('#submitform');
		var input = $('#detailsearchtext').val();
		selectacustomer(input);
	}
}

function scrollcustomer(type)
{
	var selectbox = $('#customerlist');
	var totalcus = $("#customerlist option").length;
	var selectedcus = $("select#customerlist").attr('selectedIndex');
	if(type == 'up' && selectedcus != 0)
		$("select#customerlist").attr('selectedIndex', selectedcus - 1);
	else if(type == 'down' && selectedcus != totalcus)
		$("select#customerlist").attr('selectedIndex', selectedcus + 1);
	selectfromlist()
}




function disableformelemnts()
{
	var count = document.submitform.elements.length;
	for (i=0; i<count; i++) 
	{
		var element = document.submitform.elements[i]; 
		element.disabled=true; 
	}
}

function enableformelemnts()
{
	var count = document.submitform.elements.length;
	for (i=0; i<count; i++) 
	{
		var element = document.submitform.elements[i]; 
		element.disabled=false; 
	}
}

function gridtoform(slno)
{
	if(slno != '')
	{
		var form = $('#submitform');
		var error = $('#form-error');
		var passData = "switchtype=gridtoform&smslastslno=" + encodeURIComponent(slno) + "&dummy=" + Math.floor(Math.random()*100032680100);
		$('#form-error').html(getprocessingimage());
		var queryString = "../ajax/smsaccount.php";
		ajaxcall3 = $.ajax(
		{
			type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
			success: function(ajaxresponse,status)
			{	
				if(ajaxresponse == 'Thinking to redirect')
				{
					window.location = "../logout.php";
					return false;
				}
				else
				{
					var response = ajaxresponse;
					if(response['errorcode'] == '1' )
					{
						error.html('');
						$('#smslastslno').val(response['slno']);
						$('#contactperson').val(response['contactperson']);
						$('#emailid').val(response['emailid']);
						$('#cell').val(response['cell']);
						$('#fromname').val(response['smsfromname']);
						$('#username').val(response['smsusername']);
						$('#password').val(response['smspassword']);
						autochecknew($('#disablesmsaccount'),response['smsaccountdisabled']);
						autochecknew($('#croptext'),response['croptext']);
						$('#accounttype').val(response['accounttype']);
					}
					else
					{
						error.html(errormessage('Unable to Connect.'));
					}
				}
			}, 
			error: function(a,b)
			{
				error.html(scripterror());
			}
		});
	}
}


function validatecontactperson(contactname)
{
	var numericExpression = /^([A-Z\s\()]+[a-zA-Z\s()])$/i;
	if(contactname.match(numericExpression)) return true;
	else return false;
}

function emailvalidation(emailid)
{
	var emailExp = /^[A-Z0-9\._%-]+@[A-Z0-9\.-]+\.[A-Z]{2,4}$/i;
	if(emailid.match(emailExp)) { return true; }
	else { return false; }
} 

function validatecell(cellnumber)
{
	var numericExpression = /^[7|8|9]+[0-9]{9,9}$/i;
	if(cellnumber.match(numericExpression)) return true;
	else return false;
}
function generateaccountgrid(startlimit)
{
	
	var form = $('#submitform');
	var startlimit = '';
	$('#cuslastslno').val($('#customerlist').val());
	var passData = "switchtype=generateaccountgrid&startlimit="+ encodeURIComponent(startlimit) + "&customerreference=" + encodeURIComponent($('#cuslastslno').val());
	var queryString = "../ajax/smsaccount.php";
	$('#tabgroupgridc1_1').html(getprocessingimage());
	$('#tabgroupgridc1link').html('');
	ajaxcall4 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse.split('^');
				if(response[0] == '1')
				{
					$('#tabgroupgridwb1').html("Total Count :  " + response[2]);
					$('#tabgroupgridc1_1').html(response[1]);
					$('#tabgroupgridc1link').html(response[3]);
				}
				else
				{
					$('#tabgroupgridc1_1').html("No datas found to be displayed.");
				}
			}
		}, 
		error: function(a,b)
		{
			$("#tabgroupgridc1_1").html(scripterror());
		}
	});
}

//Function for "show more records" or  "show all records" link  - to get registration records
function getmoregenerateaccountgrid(startlimit,slnocount,showtype)
{
	var form = $('#submitform');
//	$('#lastslno').value = id;	
	var passData = "switchtype=generateaccountgrid&startlimit="+ encodeURIComponent(startlimit) + "&slnocount=" + encodeURIComponent(slnocount) + "&showtype=" + encodeURIComponent(showtype) + "&customerreference=" + encodeURIComponent($('#cuslastslno').val())  + "&dummy=" + Math.floor(Math.random()*1000782200000);
	//alert(passData);
	var queryString = "../ajax/smsaccount.php";
	$('#tabgroupgridc1link').html(getprocessingimage());
	ajaxcall5 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = ajaxresponse.split('^');//alert(response);
				if(response[0] == '1')
				{
					$('#tabgroupgridwb1').html("Total Count :  " + response[2]);
					$('#resultgrid').html($('#tabgroupgridc1_1').html());
					$('#tabgroupgridc1_1').html($('#resultgrid').html().replace(/\<\/table\>/gi,'')+ response[1]);
					$('#tabgroupgridc1link').html(response[3]);
				}
				else
				{
					$('#tabgroupgridc1_1').html("No datas found to be displayed.");
				}
			}
		}, 
		error: function(a,b)
		{
			$("#tabgroupgridc1_1").html(scripterror());
		}
	});
}

function searchbycustomeridevent(e)
{ 
	var KeyID = (window.event) ? event.keyCode : e.keyCode;
	if(KeyID == 13)
	{
		var input = $('#searchcustomerid').val();
		searchbycustomerid(input);
	}
}

function searchbycustomerid(cusid)
{
	$('#form-error').html('');
	var form = $('#submitform');
	$('#submitform')[0].reset();
	var passData = "switchtype=searchbycustomerid&customerid=" + encodeURIComponent(cusid) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
	var queryString = "../ajax/smsaccount.php";
	ajaxcall8 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = (ajaxresponse);
				if(response['errorcode'] == 1)
				{
					$('#detailsearchtext').val(response['businessname']);
					selectacustomer(response['businessname']);
					$('#customerlist').val(response['customerid']);
					generateaccountgrid('');
					enableformelemnts();
					$('#displaycustomername').html(response['businessname']);
				}
				else
				{
					alert('Customer Not Available');
				}
			}
		}, 
		error: function(a,b)
		{
			$("#form-error").html(scripterror());
		}
	});
}

function getcustomerid(cusid)
{
	$('#form-error').html('');
	var form = $('#submitform');
	$('#submitform')[0].reset();
	var passData = "switchtype=getcustomerid&lastslno=" + encodeURIComponent(cusid) + "&dummy=" + Math.floor(Math.random()*100032680100);//alert(passData)
	var queryString = "../ajax/smsaccount.php";
	ajaxcall9 = $.ajax(
	{
		type: "POST",url: queryString, data: passData, cache: false,dataType: "json",
		success: function(ajaxresponse,status)
		{	
			if(ajaxresponse == 'Thinking to redirect')
			{
				window.location = "../logout.php";
				return false;
			}
			else
			{
				var response = (ajaxresponse).split("^");
				if(response[0] == 1)
				{
					$('#displaycustomerid').html(response[1]);
				}
				else
				{
					alert('Customer Not Available');
				}
			}
		}, 
		error: function(a,b)
		{
			$("#form-error").html(scripterror());
		}
	});
}
