<HTML>
<HEAD>
<TITLE>Disable Back Button in Browser - Online Demo</TITLE>
<STYLE>
body, input{
	font-family: Calibri, Arial;
}

</STYLE>
<script type="text/javascript">
	window.history.forward();
	function noBack(){ window.history.forward(); }
</script>
</HEAD>
<BODY onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload="">
<H2>This page contains the code to avoid Back button.</H2>

<p>Click here to Goto<a href="2nd.php"> NoBack Page</a><a href="1st.php"></a></p>
<p>&nbsp;</p>
</BODY>

</HTML>