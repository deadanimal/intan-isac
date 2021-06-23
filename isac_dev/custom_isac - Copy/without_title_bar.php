<html>
<head>
<title>Window Without a Title Bar</title>
<HTA:APPLICATION 
     ID="objNoTitleBar"
     APPLICATIONNAME="Window Without a Title Bar"
     SCROLL="auto"
     SINGLEINSTANCE="yes"
     CAPTION="no"
>
</head>
<SCRIPT LANGUAGE="VBScript">

    Sub CloseWindow
       self.close
    End Sub

</SCRIPT>

<body onkeypress='CloseWindow'>
Press any key to close this window.

</body>
</html>