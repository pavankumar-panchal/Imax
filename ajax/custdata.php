<?php
ob_start("ob_gzhandler");

include('../inc/ajax-referer-security.php');
include('../functions/phpfunctions.php');

if(imaxgetcookie('userid')<> '') 
$userid = imaxgetcookie('userid');
else
{ 
	echo('Thinking to redirect');
	exit;
}


$lastslno = $_POST['lastslno'];
$switchtype = $_POST['switchtype'];

switch($switchtype)
{
	case 'getalldata':
	{
		//Count of Blank Emailid
		$query1 = "SELECT count(distinct inv_mas_customer.slno) as slnocount
from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno not in (select inv_contactdetails.customerid as slno
from inv_contactdetails)";
		$fetch1 = runmysqlqueryfetch($query1);
		$blankcount = $fetch1['slnocount'];
		
		//Fetch all Dealer Emailid's 
		$query1 = "select distinct slno,emailid from inv_mas_dealer order by inv_mas_dealer.businessname";
		$fetch1 = runmysqlquery($query1);
		while($resultfetch = mysqli_fetch_array($fetch1))
		{
			$arrayofemailid[] = $resultfetch['emailid'];
		}
		for($i = 0; $i < count($arrayofemailid); $i++)
		{
		   if($i == 0)
			  $concatenatedIDs .= '\''.$arrayofemailid[$i].'\'';
		   else
			  $concatenatedIDs .= ',' . '\''.$arrayofemailid[$i].'\'';
		}

		//Count of Relyon Emailid
		$query2 = 'SELECT count(distinct inv_mas_customer.slno) as slnocount 
 from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno  in (select inv_contactdetails.customerid as slno
from inv_contactdetails where (inv_contactdetails.emailid like "%@relyonsoft.com" and inv_contactdetails.emailid not in ('.$concatenatedIDs.')))';
		$fetch2 = runmysqlqueryfetch($query2);
		$relyoncount = $fetch2['slnocount'];
		
		//Count of Dealer Emailid
		$query3 = 'SELECT count(distinct inv_mas_customer.slno) as slnocount 
 from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno  in (select inv_contactdetails.customerid as slno
from inv_contactdetails where inv_contactdetails.emailid not like "%a@a.com%" 
and (inv_contactdetails.emailid <> "" or  inv_contactdetails.emailid is not null)  and
(inv_contactdetails.emailid  in ('.$concatenatedIDs.')))';
		$fetch3 = runmysqlqueryfetch($query3);
		$dealercount = $fetch3['slnocount'];
		
		//Count of Dummy Emailid
		$query4 ="select count(distinct inv_mas_customer.slno) as slnocount 
from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where LENGTH(inv_contactdetails.emailid) < 8 and (inv_contactdetails.emailid <> '' or inv_contactdetails.emailid is null)
or (inv_contactdetails.emailid REGEXP '([,][\s]|[;][\s]|[,;]|[ ])')
or  (inv_contactdetails.emailid REGEXP '^[ ]$') or  (inv_contactdetails.emailid like '%df@dff.com%');";
		$fetch4 = runmysqlqueryfetch($query4);
		$dummycount = $fetch4['slnocount'];
		
		//Count of total email IDs/records
		$query41 ="SELECT count(distinct inv_contactdetails.emailid) as slnocount
from inv_contactdetails where (inv_contactdetails.emailid <> '' or inv_contactdetails.emailid is  null)";
		$fetch41 = runmysqlqueryfetch($query41);
		$totalemailidcount = $fetch41['slnocount'];
		
		
		//Count of Blank Cell Nos
		$query5 = "SELECT count(distinct inv_mas_customer.slno) as slnocount
from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno not in (select inv_contactdetails.customerid as slno
from inv_contactdetails)";
		$fetch5 = runmysqlqueryfetch($query5);
		$blankcellcount = $fetch5['slnocount'];
		
		//Count of Dummy Cell Nos
		$query6 = "SELECT count(distinct inv_mas_customer.slno) as slnocount
 from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno  in (select inv_contactdetails.customerid as slno
from inv_contactdetails where length(inv_contactdetails.cell)< 10  and 
inv_contactdetails.cell <> '' or (inv_contactdetails.cell like '%9999999999%')
or (inv_contactdetails.cell like '%8888888888%')or (inv_contactdetails.cell like '%7777777777%'))";
		$fetch6 = runmysqlqueryfetch($query6);
		$dummycellcount = $fetch6['slnocount'];
		
		//Count of total cell/records
		$query42 ="SELECT count(distinct inv_contactdetails.cell) as slnocount
from inv_contactdetails where (inv_contactdetails.cell <> '' or inv_contactdetails.cell is  null)";
		$fetch42 = runmysqlqueryfetch($query42);
		$totalcellcount = $fetch42['slnocount'];
		
		//Count of Blank Phone Nos
		$query7 = "SELECT count(distinct inv_mas_customer.slno) as slnocount
from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno not in (select inv_contactdetails.customerid as slno
from inv_contactdetails)";
		$fetch7 = runmysqlqueryfetch($query7);
		$blankphonecount = $fetch7['slnocount'];
		
		//Count of Dummy Phone Nos
		$query8 = "SELECT count(distinct inv_mas_customer.slno) as slnocount
 from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno  in (select inv_contactdetails.customerid as slno
from inv_contactdetails where (length(inv_contactdetails.phone)< 6  and 
inv_contactdetails.phone <> '') or (inv_contactdetails.phone like '%222222%')
or (inv_contactdetails.phone like '%33333%') or (inv_contactdetails.phone like '%44444%')
or (inv_contactdetails.phone like '%55555%') or (inv_contactdetails.phone like '%66666%')
or (inv_contactdetails.phone like '%77777%') or (inv_contactdetails.phone like '%88888%')
or (inv_contactdetails.phone like '%99999%') or (inv_contactdetails.phone like '%00000%')
or (inv_contactdetails.phone like '%11111%') or( inv_contactdetails.phone like '%12345%'))";
		$fetch8 = runmysqlqueryfetch($query8);
		$dummyphonecount = $fetch8['slnocount'];
		
		//Count of total cell/records
		$query43 ="SELECT count(distinct inv_contactdetails.phone) as slnocount
from inv_contactdetails where (inv_contactdetails.phone <> '' or inv_contactdetails.phone is  null)";
		$fetch43 = runmysqlqueryfetch($query43);
		$totalphonecount = $fetch43['slnocount'];
		
		
		//Count of Customer Type Not Selected
		$query9 = "select count(distinct inv_mas_customer.slno) as slnocount from inv_mas_customer where (`type` = '' or `type` is null)";
		$fetch9 = runmysqlqueryfetch($query9);
		$notselectedtype = $fetch9['slnocount'];
		
		//Count of Customer Type Others
		$query11 = "select count(distinct inv_mas_customer.slno) as slnocount from inv_mas_customer where (`type` = '9')";
		$fetch11 = runmysqlqueryfetch($query11);
		$typeothers = $fetch11['slnocount'];
		
		//Count of Customer Type Not Selected
		$query19 = "select count(distinct inv_mas_customer.slno) as slnocount from inv_mas_customer where (`type` <> '')";
		$fetch19 = runmysqlqueryfetch($query19);
		$resultanttotaltype = $fetch19['slnocount'];
		
		//Count of Customer Category Not Selected
		$query10 = "select count(distinct inv_mas_customer.slno) as slnocount from inv_mas_customer where (category = '' or category is null);";
		$fetch10 = runmysqlqueryfetch($query10);
		$notselectedcategory = $fetch10['slnocount'];
		
		//Count of Customer Category Others
		$query12 = "select count(distinct inv_mas_customer.slno) as slnocount from inv_mas_customer where (category = '10');";
		$fetch12 = runmysqlqueryfetch($query12);
		$categoryothers = $fetch12['slnocount'];
		
		//Count of Customer Category Not Selected
		$query13 = "select count(distinct inv_mas_customer.slno) as slnocount from inv_mas_customer where (category <> '');";
		$fetch13 = runmysqlqueryfetch($query13);
		$resultanttotalcategory = $fetch13['slnocount'];
	
		
		echo('1^'.$blankcount.'^'.$relyoncount.'^'.$dealercount.'^'.$dummycount.'^'.$totalemailidcount.'^'.$blankcellcount.'^'.$dummycellcount.'^'.$totalcellcount.'^'.$blankphonecount.'^'.$dummyphonecount.'^'.$totalphonecount.'^'.$notselectedtype.'^'.$notselectedcategory.'^'.$typeothers.'^'.$categoryothers.'^'.$resultanttotaltype.'^'.$resultanttotalcategory);
		
	}
	break;
	
	case 'detailemailgrid':
	{
		$type = $_POST['type'];
		//Fetch all Dealer Emailid's 
		$query1 = "select distinct slno,emailid from inv_mas_dealer order by inv_mas_dealer.businessname";
		$fetch1 = runmysqlquery($query1);
		while($resultfetch = mysqli_fetch_array($fetch1))
		{
			$arrayofemailid[] = $resultfetch['emailid'];
		}
		for($i = 0; $i < count($arrayofemailid); $i++)
		{
		   if($i == 0)
			  $concatenatedIDs .= '\''.$arrayofemailid[$i].'\'';
		   else
			  $concatenatedIDs .= ',' . '\''.$arrayofemailid[$i].'\'';
		}
		switch($type)
		{
			case 'blank' : 
						{
							$query = "SELECT distinct inv_mas_customer.slno as slno, inv_mas_customer.customerid as customerid,inv_mas_customer.customerid as customerid,inv_mas_customer.businessname as company,trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson, trim(both ',' from GROUP_CONCAT(inv_contactdetails.emailid)) as emailid from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno where inv_mas_customer.slno not in (select inv_contactdetails.customerid as slno
from inv_contactdetails) group  by inv_mas_customer.slno order by inv_mas_customer.businessname";
							$tabdescription = "List of customers with Blank Emailid's";
						}
						break;
			
			case 'relyon' : 
						{
							$query = 'SELECT distinct inv_mas_customer.slno as slno,inv_mas_customer.customerid as customerid,
inv_mas_customer.businessname as company,trim(both "," from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson,
trim(both "," from GROUP_CONCAT(inv_contactdetails.emailid)) as emailid
 from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno  in (select inv_contactdetails.customerid as slno
from inv_contactdetails where (inv_contactdetails.emailid like "%@relyonsoft.com" and inv_contactdetails.emailid not in ('.$concatenatedIDs.'))) group  by inv_contactdetails.customerid  order by inv_mas_customer.businessname';
							$tabdescription = "List of customers with Relyon Emailid's";
						}
						break;
			
			case 'dealer' : 
						{
							$query = 'SELECT distinct inv_mas_customer.slno as slno,inv_mas_customer.customerid as customerid,
inv_mas_customer.businessname as company,trim(both "," from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson,
trim(both "," from GROUP_CONCAT(inv_contactdetails.emailid)) as emailid
 from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno  in (select inv_contactdetails.customerid as slno
from inv_contactdetails where inv_contactdetails.emailid not like "%a@a.com%" 
and (inv_contactdetails.emailid <> "" or  inv_contactdetails.emailid is not null)  and
 (inv_contactdetails.emailid in ('.$concatenatedIDs.'))) group  by inv_contactdetails.customerid  order by inv_mas_customer.businessname';
 							$tabdescription = "List of customers with Dealer Emailid's";
						}
						break;
			case 'dummy' : 
						{
							$query = "select distinct inv_mas_customer.slno as slno,inv_mas_customer.customerid as customerid,
inv_mas_customer.businessname as company,trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson,
trim(both ',' from GROUP_CONCAT(inv_contactdetails.emailid)) as emailid
from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where LENGTH(inv_contactdetails.emailid) < 8 and (inv_contactdetails.emailid <> '' or inv_contactdetails.emailid is null)
or (inv_contactdetails.emailid REGEXP '([,][\s]|[;][\s]|[,;]|[ ])')
or  (inv_contactdetails.emailid REGEXP '^[ ]$') or  (inv_contactdetails.emailid like '%df@dff.com%')group  by inv_contactdetails.customerid  order by inv_mas_customer.businessname";
							$tabdescription = "List of customers with Dummy Emailid's";
						}
						break;
		}
		$result = runmysqlquery($query);
		$grid .= '<table width="100%" border="0" cellspacing="0" cellpadding="5" class="table-border-grid" >';
		$grid .= '<tr class="tr-grid-header">';
		$grid .= '<td width="16%" align="center" nowrap = "nowrap" class="td-border-grid">Slno</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Customer ID</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Company</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Contact person</td>';
		$grid .= '<td width="16%" align="center" nowrap = "nowrap" class="td-border-grid">Email ID</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">&nbsp;</td>';
		$grid .= '</tr>';
		if(mysqli_num_rows($result) <> 0)
		{
			$slno = 0;
			while($fetchcount = mysqli_fetch_array($result))
			{
					if($fetchcount['contactperson'] <> '')
					{
						$splitcommaincontact = explode(',',$fetchcount['contactperson']);
						$splitcommaincontactcount = count($splitcommaincontact);
						$splitcommaincontactdisplay = $splitcommaincontact[0];
					}
					else
					{
						$splitcommaincontactdisplay = 'Not Avaliable';
						$splitcommaincontactcount = 0;
					}
					if($fetchcount['emailid'] <> '')
					{
						$splitcommainemail = explode(',',$fetchcount['emailid']);
						$splitcommainemailcount = count($splitcommainemail);
						$splitcommainemaildisplay = $splitcommainemail[0];
					}
					else
					{
						$splitcommainemaildisplay = 'Not Avaliable';
						$splitcommainemailcount = 0;
					}
					
					$slno++;
					$grid .= '<tr >';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.$slno.'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.cusidcombine($fetchcount['customerid']).'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.gridtrim($fetchcount['company']).'</td>';
					
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.gridtrim($splitcommaincontactdisplay.' '.'('.$splitcommaincontactcount.')').'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.$splitcommainemaildisplay.' '.'('.$splitcommainemailcount.')'.'</td>';
					$grid .= '<td nowrap="nowrap" class="td-border-grid" align="center"> <a onclick="viewhistory(\''.$fetchcount['slno'].'\');" class="resendtext" style = "cursor:pointer"> View Details >></a> </td>';
					$grid .= '</tr>';
			}
			$grid .= '</table>';	
		}
		elseif(mysqli_num_rows($result) == 0)
		{
			$grid .= '<tr><td colspan="6" bgcolor="#FFFFD2" class="td-border-grid" style="font-weight:bold"><font color="#FF4F4F" >No Records</font></td></tr>';
		
		}
		//sleep(10);
		echo('1^'.$grid.'^'.$tabdescription);
	}
	break;
	
	case 'detailcellgrid':
	{
		$celltype = $_POST['type'];
		
		switch($celltype)
		{
			case 'blank' : 
						{
							$query = "SELECT distinct inv_mas_customer.slno as slno, inv_mas_customer.customerid as customerid,inv_mas_customer.customerid as customerid,inv_mas_customer.businessname as company,trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson, trim(both ',' from GROUP_CONCAT(inv_contactdetails.cell)) as cell from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno where inv_mas_customer.slno not in (select inv_contactdetails.customerid as slno
from inv_contactdetails) group  by inv_mas_customer.slno order by inv_mas_customer.businessname";
							$tabdescription = "List of customers with Blank Cell Numbers";
						}
						break;
			case 'dummy' : 
						{
							$query = "SELECT distinct inv_mas_customer.slno as slno, inv_mas_customer.customerid as customerid,inv_mas_customer.customerid as customerid,inv_mas_customer.businessname as company,trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson, trim(both ',' from GROUP_CONCAT(inv_contactdetails.cell)) as cell
 from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno  in (select inv_contactdetails.customerid as slno
from inv_contactdetails where length(inv_contactdetails.cell)< 10  and 
inv_contactdetails.cell <> '' or (inv_contactdetails.cell like '%9999999999%')
or (inv_contactdetails.cell like '%8888888888%')or (inv_contactdetails.cell like '%7777777777%')) 
group  by inv_mas_customer.slno order by inv_mas_customer.businessname";
							$tabdescription = "List of customers with Dummy Cell Numbers";
						}
						break;
		}
		$result1 = runmysqlquery($query);
		$grid .= '<table width="100%" border="0" cellspacing="0" cellpadding="5" class="table-border-grid">';
		$grid .= '<tr class="tr-grid-header">';
		$grid .= '<td width="16%" align="center" nowrap = "nowrap" class="td-border-grid">Slno</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Customer ID</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Company</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Contact person</td>';
		$grid .= '<td width="16%" align="center" nowrap = "nowrap" class="td-border-grid">Cell</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">&nbsp;</td>';
		$grid .= '</tr>';
		if(mysqli_num_rows($result1) <> 0)
		{
			$slno = 0;
			while($fetchcount = mysqli_fetch_array($result1))
			{
				
					if($fetchcount['contactperson'] <> '')
					{
						$splitcommaincontact = explode(',',$fetchcount['contactperson']);
						$splitcommaincontactcount = count($splitcommaincontact);
						$splitcommaincontactdisplay = $splitcommaincontact[0];
					}
					else
					{
						$splitcommaincontactdisplay = 'Not Avaliable';
						$splitcommaincontactcount = 0;
					}
					if($fetchcount['cell'] <> '')
					{
						$splitcommaincell = explode(',',$fetchcount['cell']);
						$splitcommaincellcount = count($splitcommaincell);
						$splitcommaincelldisplay = $splitcommaincell[0];
					}
					else
					{
						$splitcommaincelldisplay = 'Not Avaliable';
						$splitcommaincellcount = 0;
					}
					$slno++;
					$grid .= '<tr>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.$slno.'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.cusidcombine($fetchcount['customerid']).'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.gridtrim($fetchcount['company']).'</td>';
					
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.gridtrim($splitcommaincontactdisplay.' '.'('.$splitcommaincontactcount.')').'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.$splitcommaincelldisplay.' '.'('.$splitcommaincellcount.')'.'</td>';
					$grid .= '<td nowrap="nowrap" class="td-border-grid" align="center"> <a onclick="viewhistory(\''.$fetchcount['slno'].'\');" class="resendtext" style = "cursor:pointer"> View Details >></a> </td>';
					$grid .= '</tr>';
			}
			$grid .= '</table>';	
		}
		elseif(mysqli_num_rows($result1) == 0)
		{
			$grid .= '<tr><td colspan="6" bgcolor="#FFFFD2" class="td-border-grid" style="font-weight:bold"><font color="#FF4F4F" >No Records</font></td></tr>';
		
		}
		//sleep(10);
		echo('1^'.$grid.'^'.$tabdescription);
	}
	break;
	
	case 'detailphonegrid':
	{
		$phonetype = $_POST['type'];
		
		switch($phonetype)
		{
			case 'blank' : 
						{
							$query = "SELECT distinct inv_mas_customer.slno as slno, inv_mas_customer.customerid as customerid,inv_mas_customer.customerid as customerid,inv_mas_customer.businessname as company,trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson, trim(both ',' from GROUP_CONCAT(inv_contactdetails.phone)) as phone from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno where inv_mas_customer.slno not in (select inv_contactdetails.customerid as slno from inv_contactdetails) group  by inv_mas_customer.slno order by inv_mas_customer.businessname";
							$tabdescription = "List of customers with Blank Phone Numbers";
						}
						break;
			case 'dummy' : 
						{
							$query = "SELECT distinct inv_mas_customer.slno as slno, inv_mas_customer.customerid as customerid,inv_mas_customer.customerid as customerid,inv_mas_customer.businessname as company,trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson, trim(both ',' from GROUP_CONCAT(inv_contactdetails.phone)) as phone
 from inv_mas_customer left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno
where inv_mas_customer.slno  in (select inv_contactdetails.customerid as slno
from inv_contactdetails where (length(inv_contactdetails.phone)< 6  and 
inv_contactdetails.phone <> '') or (inv_contactdetails.phone like '%222222%')
or (inv_contactdetails.phone like '%33333%') or (inv_contactdetails.phone like '%44444%')
or (inv_contactdetails.phone like '%55555%') or (inv_contactdetails.phone like '%66666%')
or (inv_contactdetails.phone like '%77777%') or (inv_contactdetails.phone like '%88888%')
or (inv_contactdetails.phone like '%99999%') or (inv_contactdetails.phone like '%00000%')
or (inv_contactdetails.phone like '%11111%') or( inv_contactdetails.phone like '%12345%')) group  by inv_mas_customer.slno order by inv_mas_customer.businessname";
							$tabdescription = "List of customers with Dummy Phone Numbers";
						}
						break;
		}
		$result2 = runmysqlquery($query);
		$grid .= '<table width="100%" border="0" cellspacing="0" cellpadding="5" class="table-border-grid">';
		$grid .= '<tr class="tr-grid-header">';
		$grid .= '<td width="16%" align="center" nowrap = "nowrap" class="td-border-grid">Slno</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Customer ID</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Company</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Contact person</td>';
		$grid .= '<td width="16%" align="center" nowrap = "nowrap" class="td-border-grid">Phone</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">&nbsp;</td>';
		$grid .= '</tr>';
		if(mysqli_num_rows($result2) <> 0)
		{
			$slno = 0;
			while($fetchcount = mysqli_fetch_array($result2))
			{
				
					if($fetchcount['contactperson'] <> '')
					{
						$splitcommaincontact = explode(',',$fetchcount['contactperson']);
						$splitcommaincontactcount = count($splitcommaincontact);
						$splitcommaincontactdisplay = $splitcommaincontact[0];
					}
					else
					{
						$splitcommaincontactdisplay = 'Not Avaliable';
						$splitcommaincontactcount = 0;
					}
					if($fetchcount['phone'] <> '')
					{
						$splitcommainphone = explode(',',$fetchcount['phone']);
						$splitcommainphonecount = count($splitcommainphone);
						$splitcommainphonedisplay = $splitcommainphone[0];
					}
					else
					{
						$splitcommainphonedisplay = 'Not Avaliable';
						$splitcommainphonecount = 0;
					}
					$slno++;
					$grid .= '<tr>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.$slno.'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.cusidcombine($fetchcount['customerid']).'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.gridtrim($fetchcount['company']).'</td>';
					
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.gridtrim($splitcommaincontactdisplay.' '.'('.$splitcommaincontactcount.')').'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.$splitcommainphonedisplay.' '.'('.$splitcommainphonecount.')'.'</td>';
					$grid .= '<td nowrap="nowrap" class="td-border-grid" align="center"> <a onclick="viewhistory(\''.$fetchcount['slno'].'\');" class="resendtext" style = "cursor:pointer"> View Details >></a> </td>';
					$grid .= '</tr>';
			}
			$grid .= '</table>';	
		}
		elseif(mysqli_num_rows($result2) == 0)
		{
			$grid .= '<tr><td colspan="6" bgcolor="#FFFFD2" class="td-border-grid" style="font-weight:bold"><font color="#FF4F4F" >No Records</font></td></tr>';
		
		}
		//sleep(10);
		echo('1^'.$grid.'^'.$tabdescription);
	}
	break;
	
	case 'detailcustgrid':
	{
		$type = $_POST['type'];
		
		switch($type)
		{
			case 'custtype' : 
						{
							$query = "SELECT distinct inv_mas_customer.slno as slno, inv_mas_customer.customerid as customerid,
inv_mas_customer.customerid as customerid,inv_mas_customer.businessname as company,
trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson, 
inv_mas_customer.type as typecategory from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno 
where (inv_mas_customer.type = '' or inv_mas_customer.type is null)
group  by inv_mas_customer.slno order by inv_mas_customer.businessname";
							$tabdescription = "List of customers were Customer Type is not selected";
						}
						break;
			case 'category' : 
						{
							$query = "SELECT distinct inv_mas_customer.slno as slno, inv_mas_customer.customerid as customerid,
inv_mas_customer.customerid as customerid,inv_mas_customer.businessname as company,
trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson, 
inv_mas_customer.category as typecategory from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno 
where (inv_mas_customer.category = '' or inv_mas_customer.category is null)
group  by inv_mas_customer.slno order by inv_mas_customer.businessname";
							$tabdescription = "List of customers were Customer Category is not selected";
						}
						break;
			case 'custtypeothers' : 
						{
							$query = "SELECT distinct inv_mas_customer.slno as slno, inv_mas_customer.customerid as customerid,
inv_mas_customer.customerid as customerid,inv_mas_customer.businessname as company,
trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson, 
inv_mas_customer.type as typecategory from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno 
where (inv_mas_customer.type = '9')
group  by inv_mas_customer.slno order by inv_mas_customer.businessname";
							$tabdescription = "List of customers where Customer Type selection is Others";
						}
						break;
			case 'categoryothers' : 
						{
							$query = "SELECT distinct inv_mas_customer.slno as slno, inv_mas_customer.customerid as customerid,
inv_mas_customer.customerid as customerid,inv_mas_customer.businessname as company,
trim(both ',' from GROUP_CONCAT(inv_contactdetails.contactperson)) as contactperson, 
inv_mas_customer.category as typecategory from inv_mas_customer 
left join inv_contactdetails on inv_contactdetails.customerid = inv_mas_customer.slno 
where (inv_mas_customer.category = '10')
group  by inv_mas_customer.slno order by inv_mas_customer.businessname";
							$tabdescription = "List of customers where Customer Category selection is Others";
						}
						break;
		}
		$result2 = runmysqlquery($query);
		$grid .= '<table width="100%" border="0" cellspacing="0" cellpadding="5" class="table-border-grid">';
		$grid .= '<tr class="tr-grid-header">';
		$grid .= '<td width="16%" align="center" nowrap = "nowrap" class="td-border-grid">Slno</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Customer ID</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Company</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">Contact person</td>';
		if($type == 'custtype')
			$grid .= '<td width="16%" align="center" nowrap = "nowrap" class="td-border-grid">Customer Type</td>';
		else
			$grid .= '<td width="16%" align="center" nowrap = "nowrap" class="td-border-grid">Category</td>';
		$grid .= '<td width="17%" align="center" nowrap = "nowrap" class="td-border-grid">&nbsp;</td>';
		$grid .= '</tr>';
		if(mysqli_num_rows($result2) <> 0)
		{
			$slno = 0;
			while($fetchcount = mysqli_fetch_array($result2))
			{
				
					if($fetchcount['contactperson'] <> '')
					{
						$splitcommaincontact = explode(',',$fetchcount['contactperson']);
						$splitcommaincontactcount = count($splitcommaincontact);
						$splitcommaincontactdisplay = $splitcommaincontact[0];
					}
					else
					{
						$splitcommaincontactdisplay = 'Not Avaliable';
						$splitcommaincontactcount = 0;
					}
					if($fetchcount['typecategory'] == '0')
					{
						$resultant = 'Not Avaliable';
					}
					elseif($fetchcount['typecategory'] == '9' or $fetchcount['typecategory'] == '10')
					{
						$resultant = 'Others';
					}
					
					$slno++;
					$grid .= '<tr>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.$slno.'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.cusidcombine($fetchcount['customerid']).'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.gridtrim($fetchcount['company']).'</td>';
					
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.gridtrim($splitcommaincontactdisplay.' '.'('.$splitcommaincontactcount.')').'</td>';
					$grid .= '<td align="left" nowrap = "nowrap" class="td-border-grid">'.$resultant.'</td>';
					$grid .= '<td nowrap="nowrap" class="td-border-grid" align="center"> <a onclick="viewhistory(\''.$fetchcount['slno'].'\');" class="resendtext" style = "cursor:pointer"> View Details >></a> </td>';
					$grid .= '</tr>';
			}
			$grid .= '</table>';	
		}
		elseif(mysqli_num_rows($result2) == 0)
		{
			$grid .= '<tr><td colspan="6" bgcolor="#FFFFD2" class="td-border-grid" style="font-weight:bold"><font color="#FF4F4F" >No Records</font></td></tr>';
		
		}
		//sleep(10);
		echo('1^'.$grid.'^'.$tabdescription);
	}
	break;
	
	case 'generatecustomerlist':
	{
		$query = "SELECT slno,businessname,customerid FROM inv_mas_customer ORDER BY businessname";
		$result = runmysqlquery($query);
		$grid = '';
		$count = 1;
		while($fetch = mysqli_fetch_array($result))
		{
			if($count > 1)
				$grid .='^*^';
			$grid .= $fetch['businessname'].'^'.$fetch['slno'];
			$count++;
		}
		echo($grid);
	}
	break;
	
	case 'customerdetailstoform':
	{
		$lastslno = $_POST['lastslno'];
		$query1 = "SELECT count(*) as count from inv_mas_customer where slno = '".$lastslno."'";
		$fetch1 = runmysqlqueryfetch($query1);
		if($fetch1['count'] > 0)
		{
			$query = "SELECT inv_mas_customer.slno, inv_mas_customer.customerid, inv_mas_customer.businessname,  inv_mas_customer.address,inv_mas_customer.place, inv_mas_district.districtname as districtname,inv_mas_state.statename as state, 
inv_mas_customer.pincode, inv_mas_customer.fax, inv_mas_region.category as regionname,
inv_mas_branch.branchname as branchname, inv_mas_customercategory.businesstype as businesstype,inv_mas_customertype.customertype as customertype,inv_mas_customer.companyclosed, inv_mas_customer.stdcode, inv_mas_customer.website,
inv_mas_customer.category, inv_mas_customer.type, inv_mas_customer.isdealer,inv_mas_customer.remarks, 
inv_mas_dealer.businessname as dealername,inv_mas_customer.disablelogin,
inv_mas_customer.corporateorder,inv_mas_customer.createddate,inv_mas_customer.activecustomer, 
inv_mas_customer.displayinwebsite, inv_mas_customer.promotionalsms,inv_mas_customer.promotionalemail ,inv_mas_state.statecode as statecode ,inv_mas_customer.district as districtcode,inv_mas_customer.region as regioncode,inv_mas_customer.branch as branchcode,inv_mas_customer.type as typecode,inv_mas_customer.category as categorycode,inv_mas_customer.currentdealer as dealerid FROM inv_mas_customer left join inv_mas_district on inv_mas_customer.district = inv_mas_district.districtcode 
left join inv_mas_state on inv_mas_state.statecode = inv_mas_district.statecode
left join inv_mas_region on inv_mas_region.slno = inv_mas_customer.region
left join inv_mas_branch on inv_mas_branch.slno = inv_mas_customer.branch
left join inv_mas_dealer on inv_mas_dealer.slno = inv_mas_customer.currentdealer
left join inv_mas_customercategory on inv_mas_customercategory.slno = inv_mas_customer.category
left join inv_mas_customertype on inv_mas_customertype.slno = inv_mas_customer.type
where inv_mas_customer.slno = '".$lastslno."';";
			$fetch = runmysqlqueryfetch($query);
			
			$query1 ="SELECT * FROM inv_contactdetails where customerid = '".$lastslno."'; ";
			$resultfetch = runmysqlquery($query1);
			$contactgrid .= '<table width="100%" border="0" cellspacing="0" cellpadding="5" class="table-border-grid">';
			$contactgrid .= '<tr class="tr-grid-header">';
			$contactgrid .= '<td width="7%" align="center" nowrap = "nowrap" class="td-border-grid">Slno</td>';
			$contactgrid .= '<td width="15%" align="center" nowrap = "nowrap" class="td-border-grid">Type</td>';
			$contactgrid .= '<td width="19%" align="center" nowrap = "nowrap" class="td-border-grid">Name</td>';
			$contactgrid .= '<td width="18%" align="center" nowrap = "nowrap" class="td-border-grid">Phone</td>';
			$contactgrid .= '<td width="15%" align="center" nowrap = "nowrap" class="td-border-grid">Cell</td>';
			$contactgrid .= '<td width="26%" align="center" nowrap = "nowrap" class="td-border-grid">Email Id</td>';
			$contactgrid .= '</tr>';
			$slno = 0;$i_n = 0;
			if(mysqli_num_rows($resultfetch) > 0)
			{
				while($fetchres = mysqli_fetch_array($resultfetch))
				{
					$slno++;$i_n++;
					if($i_n%2 == 0)
						$color = "#edf4ff";
					else
						$color = "#f7faff";
					$contactgrid .= '<tr class="gridrow" onclick="getcontactdetails(\''.$fetchres['slno'].'\',\''.$slno.'\');">';
					$contactgrid .= '<td width="7%" align="left" nowrap = "nowrap" class="td-border-grid">'.$slno.'</td>';
					$contactgrid .= '<td width="15%" align="left" nowrap = "nowrap" class="td-border-grid" id="selecttype'.$slno.'">'.$fetchres['selectiontype'].'</td>';
					$contactgrid .= '<td width="19%" align="left" nowrap = "nowrap" class="td-border-grid" id="contactperson'.$slno.'">'.$fetchres['contactperson'].'</td>';
					$contactgrid .= '<td width="18%" align="left" nowrap = "nowrap" class="td-border-grid" id="phonetype'.$slno.'">'.$fetchres['phone'].'</td>';
					$contactgrid .= '<td width="15%" align="left" nowrap = "nowrap" class="td-border-grid" id="celltype'.$slno.'">'.$fetchres['cell'].'</td>';
					$contactgrid .= '<td width="26%" align="left" nowrap = "nowrap" class="td-border-grid" id="emailtype'.$slno.'">'.$fetchres['emailid'].'</td>';
					$contactgrid .= '</tr>';
					
				}
			}
			elseif(mysqli_num_rows($resultfetch) == 0)
			{
				$contactgrid .= '<tr><td colspan="6" class="td-border-grid" height="20px"  bgcolor="#FFFFD2"><table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr><td><font color="#FF4F4F">No More Records</font></td></tr></table></td></tr>';
			}
			$contactgrid .= '</table>';
			
			if($fetch['customerid'] == '')
			$customerid = '';
			else
			$customerid = cusidcombine($fetch['customerid']);
			
			$checkboxval = $fetch['activecustomer'].'$#$'.$fetch['disablelogin'].'$#$'.$fetch['corporateorder'].'$#$'.$fetch['companyclosed'].'$#$'.$fetch['isdealer'].'$#$'.$fetch['displayinwebsite'].'$#$'.$fetch['promotionalsms'].'$#$'.$fetch['promotionalemail'];
			if($fetch['fax'] == '')
				$faxtype = 'Not Avaliable';
			else
				$faxtype = $fetch['fax'];
			if($fetch['stdcode'] == '')
				$stdcodetype = 'Not Avaliable';
			else
				$stdcodetype = $fetch['stdcode'];
			if($fetch['website'] == '')
				$websitetype = 'Not Avaliable';
			else
				$websitetype = $fetch['stdcode'];
			if($fetch['customertype'] == '')
				$customertype = 'Not Avaliable';
			else
				$customertype = $fetch['customertype'];
			if($fetch['businesstype'] == '')
				$businesstype = 'Not Avaliable';
			else
				$businesstype = $fetch['businesstype'];
			if($fetch['address'] == '')
				$addresstype = 'Not Avaliable';
			else
				$addresstype = $fetch['address'];
			echo($fetch['slno'].'^'.$customerid.'^'.$fetch['businessname'].'^'.$addresstype.'^'.$fetch['place'].'^'.$fetch['districtname'].'^'.$fetch['state'].'^'.$fetch['pincode'].'^'.$fetch['regionname'].'^'.$stdcodetype.'^'.$websitetype.'^'.$businesstype.'^'.$customertype.'^'.$fetch['dealername'].'^'.$fetch['disablelogin'].'^'.changedateformatwithtime($fetch['createddate']).'^'.$fetch['corporateorder'].'^'.$faxtype.'^'.$fetch['activecustomer'].'^'.$fetch['branchname'].'^'.$fetch['companyclosed'].'^'.$fetch['isdealer'].'^'.$fetch['displayinwebsite'].'^'.$fetch['promotionalsms'].'^'.$fetch['promotionalemail'].'^'.$contactgrid.'^'.$fetch['statecode'].'^'.$fetch['districtcode'].'^'.$fetch['regioncode'].'^'.$fetch['branchcode'].'^'.$fetch['typecode'].'^'.$fetch['categorycode'].'^'.$fetch['dealerid'].'^'.$checkboxval);
		}
		else
		{
			echo($lastslno.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.''.'^'.'');
		}
	}
	break;
	case 'customergridtoform':
	{
		$cusid = $_POST['cusid'];
		$query = "select distinct inv_mas_customer.slno,inv_mas_customer.businessname from inv_mas_customer  where inv_mas_customer.slno = '".$cusid."' order  by inv_mas_customer.businessname;";
		$result = runmysqlquery($query);
		$grid = '';
		$count = 1;
		while($fetch = mysqli_fetch_array($result))
		{
			if($count > 1)
				$grid .='^*^';
			$grid .= $fetch['businessname'].'^'.$fetch['slno'];
			$count++;
		}
		echo($grid);
	}
	break;
	case 'processupdate':
	{
		$fieldname = $_POST['fieldname'];
		$editvalue = $_POST['editvalue'];
		$lastslno = $_POST['lastslno'];
		$updatepiece = $fieldname." = '".$editvalue."'";
		
		$updatequery = "update inv_mas_customer set ".$updatepiece."  where slno = '".$lastslno."'";
		$result = runmysqlquery($updatequery);
		switch($fieldname)
		{
			case 'businessname':
			{
				$selectedfields = ("inv_mas_customer.businessname as resultvalue");
				$joinlink = "";
			}
			break;
			case 'address':
			{
				$selectedfields = ("inv_mas_customer.address as resultvalue");
				$joinlink = "";
			}
			break;
			case 'place':
			{
				$selectedfields = ("inv_mas_customer.place as resultvalue");
				$joinlink = "";
			}
			break;
			case 'district':
			{
				$selectedfields = ("inv_mas_district.districtname as districtname,inv_mas_state.statename as statename");
				$joinlink = "LEFT JOIN inv_mas_district on inv_mas_district.districtcode = inv_mas_customer.district LEFT JOIN inv_mas_state on inv_mas_state.statecode = inv_mas_district.statecode";
			}
			break;
			case 'stdcode':
			{
				$selectedfields = ("inv_mas_customer.stdcode as resultvalue");
				$joinlink = "";
			}
			break;
			case 'fax':
			{
				$selectedfields = ("inv_mas_customer.fax as resultvalue");
				$joinlink = "";
			}
			case 'pincode':
			{
				$selectedfields = ("inv_mas_customer.pincode as resultvalue");
				$joinlink = "";
			}
			break;
			case 'website':
			{
				$selectedfields = ("inv_mas_customer.website as resultvalue");
				$joinlink = "";
			}
			break;
			case 'region':
			{
				$selectedfields = ("inv_mas_region.category as resultvalue");
				$joinlink = ("LEFT JOIN inv_mas_region on inv_mas_region.slno = inv_mas_customer.region ");
			}
			break;
			case 'branch':
			{
				$selectedfields = ("inv_mas_branch.branchname as resultvalue");
				$joinlink = ("LEFT JOIN inv_mas_branch on inv_mas_branch.slno = inv_mas_customer.branch ");
			}
			break;
			case 'type':
			{
				$selectedfields = ("inv_mas_customertype.customertype as resultvalue");
				$joinlink = ("LEFT JOIN inv_mas_customertype on inv_mas_customertype.slno = inv_mas_customer.type ");
			}
			break;
			case 'category':
			{
				$selectedfields = ("inv_mas_customercategory.businesstype as resultvalue");
				$joinlink = ("LEFT JOIN inv_mas_customercategory on inv_mas_customercategory.slno = inv_mas_customer.category ");
			}
			break;
			case 'currentdealer':
			{
				$selectedfields = ("inv_mas_dealer.businessname as resultvalue");
				$joinlink = "LEFT JOIN inv_mas_dealer on inv_mas_dealer.slno = inv_mas_customer.currentdealer ";
			}
			break;
		}
		if($fieldname == 'district')
		{
			$query11 = "Select ".$selectedfields." from  inv_mas_customer ".$joinlink." where inv_mas_customer.slno = '".$lastslno."'";
			$fetch11 = runmysqlqueryfetch($query11);
			$valuedetails = $fetch11['districtname'].'^'. $fetch11['statename'];
		}
		else
		{
			$query11 = "Select ".$selectedfields." from  inv_mas_customer ".$joinlink." where inv_mas_customer.slno = '".$lastslno."'";
			$fetch11 = runmysqlqueryfetch($query11);
			$valuedetails = $fetch11['resultvalue'];
		}
		//echo($updatequery);echo($query11);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','109','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		echo('1^'.'Record Edited Successfully.'.'^'.$valuedetails);
	}
	break;
	
	case 'updatecontactdetails':
	{
		$contactslno = $_POST['contactslno'];
		$lastslno = $_POST['lastslno'];
		$selectiontype = $_POST['selectiontype'];
		$contactperson = $_POST['name'];
		$phone = $_POST['phone'];
		$cell = $_POST['cell'];
		$emailid = $_POST['emailid'];
		
		$updatecontactquery = "update inv_contactdetails set selectiontype = '".$selectiontype."',contactperson = '".$contactperson."',phone = '".$phone."',cell = '".$cell."',emailid = '".$emailid."'  where inv_contactdetails.slno = '".$contactslno."' and inv_contactdetails.customerid = '".$lastslno."';";
		$result = runmysqlquery($updatecontactquery);
		
		$query12 = "Select * from  inv_contactdetails where inv_contactdetails.slno = '".$contactslno."' and inv_contactdetails.customerid = '".$lastslno."';";
		$fetch12 = runmysqlqueryfetch($query12);
		if($fetch12['selectiontype'] == 'general')
			$selectionvalue = 'General';
		elseif($fetch12['selectiontype'] == 'gm/director')
			$selectionvalue = 'GM/Director';
		elseif($fetch12['selectiontype'] == 'hrhead')
			$selectionvalue = 'HR Head';
		elseif($fetch12['selectiontype'] == 'ithead/edp')
			$selectionvalue = 'IT-Head/EDP';
		elseif($fetch12['selectiontype'] == 'softwareuser')
			$selectionvalue = 'Software User';
		elseif($fetch12['selectiontype'] == 'financehead')
			$selectionvalue = 'Finance Head';
		elseif($fetch12['selectiontype'] == 'others')
			$selectionvalue = 'Others';
		//echo($query12);
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','109','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		echo('1^'.'Record Edited Successfully.'.'^'.$selectionvalue.'^'.$fetch12['contactperson'].'^'.$fetch12['phone'].'^'.$fetch12['cell'].'^'.$fetch12['emailid']);
	}
	break;
	case 'updatecheckboxdetails':
	{
		$activecustomer = $_POST['activecustomer'];
		$lastslno = $_POST['lastslno'];
		$disablelogin = $_POST['disablelogin'];
		$corporateorder = $_POST['corporateorder'];
		$companyclosed = $_POST['companyclosed'];
		$isdealer = $_POST['isdealer'];
		$displayinwebsite = $_POST['displayinwebsite'];
		$promotionalsms = $_POST['promotionalsms'];
		$promotionalemail = $_POST['promotionalemail'];
		
		$updatecheckquery = "update inv_mas_customer set activecustomer = '".$activecustomer."',disablelogin = '".$disablelogin."',corporateorder = '".$corporateorder."',companyclosed = '".$companyclosed."',isdealer = '".$isdealer."',displayinwebsite = '".$displayinwebsite."' ,promotionalsms = '".$promotionalsms."',promotionalemail = '".$promotionalemail."' where inv_mas_customer.slno = '".$lastslno."';";
		$result = runmysqlquery($updatecheckquery);
		
		$query13 = "Select activecustomer, disablelogin ,corporateorder, companyclosed, isdealer, displayinwebsite, promotionalsms, promotionalemail from  inv_mas_customer where inv_mas_customer.slno = '".$lastslno."';";
		$fetch13 = runmysqlqueryfetch($query13);
		
		$eventquery = "Insert into inv_logs_event(userid,system,eventtype,eventdatetime) values('".$userid."','".$_SERVER['REMOTE_ADDR']."','109','".date('Y-m-d').' '.date('H:i:s')."')";
		$eventresult = runmysqlquery($eventquery);
		
		//echo($query12);
		echo('1^'.'Record Edited Successfully.'.'^'.strtoupper($fetch13['activecustomer']).'^'.strtoupper($fetch13['disablelogin']).'^'.strtoupper($fetch13['corporateorder']).'^'.strtoupper($fetch13['companyclosed']).'^'.strtoupper($fetch13['isdealer']).'^'.strtoupper($fetch13['displayinwebsite']).'^'.strtoupper($fetch13['promotionalsms']).'^'.strtoupper($fetch13['promotionalemail']));
	}
	break;

}

?>