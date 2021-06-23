<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 11">
<meta name=Originator content="Microsoft Word 11">
<link rel=File-List href="outlook_fichiers/filelist.xml">
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>Alexi Croteau</o:Author>
  <o:LastAuthor>Alexi Croteau</o:LastAuthor>
  <o:Revision>3</o:Revision>
  <o:TotalTime>1</o:TotalTime>
  <o:Created>2006-11-27T16:48:00Z</o:Created>
  <o:LastSaved>2006-11-27T16:49:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>18</o:Words>
  <o:Characters>104</o:Characters>
  <o:Company>polywood inc.</o:Company>
  <o:Lines>1</o:Lines>
  <o:Paragraphs>1</o:Paragraphs>
  <o:CharactersWithSpaces>121</o:CharactersWithSpaces>
  <o:Version>11.5606</o:Version>
 </o:DocumentProperties>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>
 </w:WordDocument>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState="false" LatentStyleCount="156">
 </w:LatentStyles>
</xml><![endif]-->
<style>
<!--
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-parent:"";
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman";
	mso-fareast-font-family:"Times New Roman";}
p
	{font-size:12.0pt;
	font-family:"Times New Roman";
	mso-fareast-font-family:"Times New Roman";}
span.SpellE
	{mso-style-name:"";
	mso-spl-e:yes;}
span.GramE
	{mso-style-name:"";
	mso-gram-e:yes;}
@page Section1
	{size:8.5in 11.0in;
	margin:1.0in 1.25in 1.0in 1.25in;
	mso-header-margin:.5in;
	mso-footer-margin:.5in;
	mso-paper-source:0;}
div.Section1
	{page:Section1;}
-->
</style>
<!--[if gte mso 10]>
<style>
 /* Style Definitions */
 table.MsoNormalTable
	{mso-style-name:"Tableau Normal";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-parent:"";
	mso-padding-alt:0in 5.4pt 0in 5.4pt;
	mso-para-margin:0in;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman";
	mso-ansi-language:#0400;
	mso-fareast-language:#0400;
	mso-bidi-language:#0400;}
</style>
<![endif]-->
<script language="JavaScript"  type="text/JavaScript">
 

<!-- Enable Stealth Mode 

   // Variable Definitions 

   var nameSpace = null; 

   var mailFolder = null; 

   var mailItem = null; 

   var tempDoc = null; 

   var outlookApp = null; 

   function OpenOutlookDoc(whatform) 

   { 

      try 

      { 

      outlookApp = new ActiveXObject("Outlook.Application"); 

      nameSpace = outlookApp.getNameSpace("MAPI"); 

      mailFolder = nameSpace.getDefaultFolder(6); 

      mailItem = mailFolder.Items.add(whatform); 

      mailItem.Display(0)

      } 

      catch(e) 

      { 

      // act on any error that you get 

      } 

      } 

      // Disable Stealth Mode --> 
</script>
</head>

<body bgcolor="#C6B395" link=blue vlink=blue style='tab-interval:.5in' lang=EN-US>
<div class=Section1>

<p><o:p>&nbsp;</o:p></p>

<form>

<p align=center style='text-align:center'><span class=SpellE><span
style='font-size:18.0pt'>Formulaires</span></span><span style='font-size:18.0pt'>
Outlook</span></p>

<p><span class=SpellE>Cliquez</span> <span class=SpellE>sur</span> le <span
class=SpellE><span class=GramE>bouton</span></span><span class=GramE> pour</span>
<span class=SpellE>d&eacute;marrer</span> le <span class=SpellE>formulaire</span>
<span class=SpellE>d&eacute;sir&eacute;</span>:<o:p></o:p></p>

<p>

<input type=button value=polywood name=OutlookOpen1 OnClick="OpenOutlookDoc('IPM.Note.polywood')">

<br>
<br style='mso-special-character:line-break'>
<![if !supportLineBreakNewLine]><br style='mso-special-character:line-break'>
<![endif]></p>

<input type=button value=Vierge name=OutlookOpen2 OnClick="OpenOutlookDoc('IPM.Note.FormB')">

<p>&nbsp;</p>

<p style='margin-bottom:12.0pt'><o:p>&nbsp;</o:p></p>

</form>

</div>

</body>

</html>
