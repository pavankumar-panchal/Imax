<?php
if($p_surrenderreport <> 'yes')
{
    $pagelink = getpagelink("unauthorised"); include($pagelink);
}
else
{
    include("../inc/eventloginsert.php");
    ?>
    <link href="../style/main.css?dummy=<?php echo (rand());?>" rel=stylesheet>
    <script language="javascript" src="../functions/surrenderreport.js?dummy=<?php echo (rand());?>"></script>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
            <td width="77%" valign="top" style="border-bottom:#1f4f66 1px solid;"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="mainwrap">
                    <tr>
                        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><table width="100%" border="0" cellspacing="0 `" cellpadding="0">
                                            <tr>
                                                <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                        <tr>
                                                            <td width="27%" class="active-leftnav">Report - Surrender Details</td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td height="5"></td>
                                            </tr>
                                            <tr>
                                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #308ebc; border-top:none;">
                                                        <tr>
                                                            <td class="header-line" style="padding:0">&nbsp;&nbsp;Make A Report</td>
                                                            <td align="right" class="header-line" style="padding-right:7px"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" valign="top"><div id="maindiv">
                                                                    <form action="" method="post" name="submitform" id="submitform" onsubmit="return false;">
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                            <tr>
                                                                                <td width="50%" valign="top" style="border-right:1px solid #d1dceb;"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                        <tr>
                                                                                            <td colspan="2"><strong>Surrendered Date</strong></td>
                                                                                        </tr>
                                                                                        <tr bgcolor="#f7faff">
                                                                                            <td valign="top" align="left">From Date:</td>
                                                                                            <td valign="top" bgcolor="#f7faff"  align="left"><input name="fromdate" type="text" class="swifttext-mandatory" id="DPC_surrenderfromdate" size="30" autocomplete="off" value="<?php echo(datetimelocal('d-m-Y')); ?>" readonly="readonly"/>
                                                                                                <input type="hidden" name="flag" id="flag" value="true" />
                                                                                                <br /></td>
                                                                                        </tr>
                                                                                        <tr bgcolor="#f7faff">
                                                                                            <td valign="top" bgcolor="#EDF4FF"  align="left">To Date:</td>
                                                                                            <td valign="top" bgcolor="#EDF4FF"  align="left"><input name="todate" type="text" class="swifttext-mandatory" id="DPC_surrendertodate" size="30" autocomplete="off" value="<?php echo(datetimelocal('d-m-Y')); ?>" readonly="readonly" /></td>
                                                                                        </tr>
                                                                                        <tr bgcolor="#edf4ff">
                                                                                            <td colspan="2" valign="top" bgcolor="#F7FAFF" height="12px"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2"><fieldset style="border:1px solid #666666; padding:2px;">
                                                                                                    <legend><strong>Options</strong></legend>
                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                                        <tr bgcolor="#f7faff">
                                                                                                            <td colspan="2" valign="top" style="padding:0"></td>
                                                                                                        </tr>
                                                                                                        <tr bgcolor="#EDF4FF">
                                                                                                            <td valign="top" align="left">Forcefully Surrender By:</td>
                                                                                                            <td valign="top" align="left"><select name="fsurrenderby" class="swiftselect" id="fsurrenderby"  style=" width:225px" >
                                                                                                                    <option value="">ALL</option>
                                                                                                                    <?php include('../inc/selectusers.php'); ?>
                                                                                                                </select></td>
                                                                                                        </tr>
                                                                                                        <tr bgcolor="#f7faff">
                                                                                                            <td valign="top" align="left">Force/Online Surrender:</td>
                                                                                                            <td valign="top" align="left"><select name="fosurrender" class="swiftselect" id="fosurrender"  style=" width:225px" >
                                                                                                                    <option value="">ALL</option>
                                                                                                                    <option value="1">Force Surrender</option>
                                                                                                                    <option value="0">Online Surrender</option>
                                                                                                                </select></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </fieldset></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2"  bgcolor="#f7faff">&nbsp;</td>
                                                                                        </tr>
                                                                                        <!--<tr bgcolor="#f7faff">
                                            <td colspan="2" valign="top" bgcolor="#EDF4FF"><fieldset style="border:1px solid #666666; padding:2px;">
                                                <legend><strong>Geography Of Customers</strong></legend>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="3" height="100">
                                                  <tr>
                                                    <td valign="top"  align="left"><label for="geography1">
                                                        <input type="radio" name="geography" id="geography1" value="all"  checked="checked" onclick="enablegeography();" />
                                                        All </label>
                                                      <label for="geography0">
                                                        <input name="geography" type="radio" id="geography0" value="region" onclick="enablegeography();" />
                                                        Region </label>
                                                      <label for="geography2">
                                                        <input type="radio" name="geography" id="geography2" value="state" onclick="enablegeography();" />
                                                        State </label></td>
                                                  </tr>
                                                  <tr>
                                                    <td valign="top"><div id="regiondiv" style="display:none;">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                          <tr>
                                                            <td width="29%" align="left">Select A Region:&nbsp;&nbsp;</td>
                                                            <td width="71%" align="left"><select name="region" class="swiftselect-mandatory" id="region" disabled="disabled">
                                                                <option value="">Select A Region</option>
                                                                <?php/* include('../inc/region.php'); */?>
                                                              </select></td>
                                                          </tr>
                                                        </table>
                                                      </div>
                                                      <div id="statediv" style="display:none;">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                          <tr>
                                                            <td width="29%" align="left">Select A State: </td>
                                                            <td width="71%" align="left"><select name="state" class="swiftselect-mandatory" id="state" onchange="districtcodeFunction();" disabled="disabled">
                                                                <option value="">Select A State</option>
                                                                <?php/* include('../inc/state.php'); */?>
                                                              </select></td>
                                                          </tr>
                                                        </table>
                                                        <div id="districtdiv" style="display:none;">
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                            <tr>
                                                              <td width="29%" align="left">Select A District:</td>
                                                              <td width="71%" id="districtcodedisplay" align="left"><select name="district" class="swiftselect-mandatory" id="district" disabled="disabled">
                                                                  <option value="">Select A State First</option>
                                                                </select></td>
                                                            </tr>
                                                          </table>
                                                        </div>
                                                      </div></td>
                                                  </tr>
                                                </table>
                                              </fieldset></td>
                                          </tr>-->

                                                                                        <tr bgcolor="#f7faff">
                                                                                            <td colspan="2" valign="top" bgcolor="#EDF4FF"><fieldset style="border:1px solid #666666; padding:2px;">
                                                                                                    <legend><strong>Serach </strong></legend>
                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="3" height="100">
                                                                                                        <tr align="center">
                                                                                                            <td valign="top"  align="left"><label for="searchref1">
                                                                                                                    <input type="radio" name="searchref" id="searchref1" value="all"  checked="checked" onclick="enablesearchref();" />
                                                                                                                    All </label>
                                                                                                                <label for="searchref0">
                                                                                                                    <input name="searchref" type="radio" id="searchref0" value="refslno" onclick="enablesearchref();" />
                                                                                                                    Ref slno</label>
                                                                                                                <label for="searchref2">
                                                                                                                    <input type="radio" name="searchref" id="searchref2" value="businessname" onclick="enablesearchref();" />
                                                                                                                    Business Name</label><br /><br />

                                                                                                                <label for="searchref3">
                                                                                                                    <input type="radio" name="searchref" id="searchref3" value="customerid" onclick="enablesearchref();" />
                                                                                                                    Customer ID</label>
                                                                                                                <label for="searchref4">
                                                                                                                    <input type="radio" name="searchref" id="searchref4" value="cardid" onclick="enablesearchref();" />
                                                                                                                    Cardid ID</label>
                                                                                                                <label for="searchref5">
                                                                                                                    <input type="radio" name="searchref" id="searchref5" value="maxcount" onclick="enablesearchref();" />
                                                                                                                    Max Count</label>
                                                                                                                <input type="hidden" name="searchrefresult" id="searchrefresult" value="all" /></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td valign="top"  align="left"><div id="searchdiv" style="display:none;">
                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                                                        <tr>
                                                                                                                            <td width="29%" align="left"><span id="searchtextheader">Enter Text Here:&nbsp;&nbsp;</span></td>
                                                                                                                            <td width="71%" align="left"><label for="searchinput">
                                                                                                                                    <input type="text" name="searchinput" id="searchinput" class="swifttext-mandatory" size="30" autocomplete="off" />
                                                                                                                                </label></td>
                                                                                                                        </tr>
                                                                                                                    </table>
                                                                                                                </div>

                                                                                                                <div id="maxcountdiv" style="display:none;">
                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                                                        <tr>
                                                                                                                            <td width="29%" align="left"><span id="maxcounttextheader">Enter Text Here:&nbsp;&nbsp;</span></td>
                                                                                                                            <td width="71%" align="left"><label for="maxcount">
                                                                                                                                    <input type="text" name="maxcount" id="maxcount" class="swifttext-mandatory" size="30" autocomplete="off" />
                                                                                                                                </label></td>
                                                                                                                        </tr>
                                                                                                                    </table>
                                                                                                                </div>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </fieldset></td>
                                                                                        </tr>
                                                                                    </table></td>
                                                                                <td width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                                        <tr bgcolor="#f7faff">
                                                                                            <td colspan="4" valign="top" style="padding:0"></td>
                                                                                        </tr>
                                                                                        <tr bgcolor="#f7faff">
                                                                                            <td colspan="4" valign="top" bgcolor="#EDF4FF" align="left"><strong>Products </strong></td>
                                                                                        </tr>
                                                                                        <tr bgcolor="#f7faff">
                                                                                            <td colspan="4" valign="top" bgcolor="#f7faff" align="left"><div style="height:327px; overflow:scroll">
                                                                                                    <?php include('../inc/product-report.php'); ?>
                                                                                                </div></td>
                                                                                        </tr>
                                                                                        <tr bgcolor="#EDF4FF">
                                                                                            <td width="10%">Select: </td>
                                                                                            <td width="34%" align="left"><strong>
                                                                                                    <select name="selectproduct" class="swiftselect" id="selectproduct" style="width:140px" >
                                                                                                        <option value="ALL" >ALL</option>
                                                                                                        <option value="NONE" selected="selected">NONE</option>
                                                                                                        <?php include('../inc/productgroup.php') ?>
                                                                                                    </select>
                                                                                                </strong></td>
                                                                                            <td width="56%" align="left"><a onclick="selectdeselectall('one');"><strong class="resendtext">Go &#8250;&#8250;</strong></a>&nbsp;<strong>OR</strong>&nbsp;<a onclick="selectdeselectall('more');"> <span class="reg-text">Add to selection &#8250;&#8250;</span></a></td>
                                                                                            <input type="hidden" name="groupvalue" id="groupvalue"  />
                                                                                        </tr>
                                                                                    </table></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" align="right" valign="middle" style="padding-right:15px; border-top:1px solid #d1dceb;"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                                                                                        <tr>
                                                                                            <td width="57%" align="left" valign="middle" height="35"><div id="form-error"></div></td>
                                                                                            <td width="43%" align="right" valign="middle"><input name="view" type="button" class="swiftchoicebutton" id="view" value="View & Export" onclick="formsubmit();" />
                                                                                                &nbsp;
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table></td>
                                                                            </tr>
                                                                        </table>
                                                                    </form>
                                                                </div></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table></td>
                    </tr>
                </table></td>
        </tr>
    </table>
<?php } ?>
