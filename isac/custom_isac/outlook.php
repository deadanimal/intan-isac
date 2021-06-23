<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<script language="JavaScript" type="text/JavaScript">
 
function genNewEmail()
 
{
 
  try
 
  {
 
    o = new ActiveXObject("Outlook.Application");
 
    if(o)
 
    {
 
      mailFolder = o.getNameSpace("MAPI").getDefaultFolder(6);
 
 
 
      //You could also use custom forms like IPM.Note.CustomForm
 
      mailItem = mailFolder.Items.add("IPM.Note");
 
      mailItem.Display(0)
 
    }
 
  }
 
  catch(e)
 
  {
 
    window.status = e.Message;
 
  }
 
}
 
</script>
 
<input type="button" value="New Message" NAME="cmdNewMessage" OnClick="genNewEmail()">
</body>
</html>
