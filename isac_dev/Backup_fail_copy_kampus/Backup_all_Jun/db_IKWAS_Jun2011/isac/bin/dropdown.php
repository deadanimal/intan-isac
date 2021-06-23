<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script>
function call(){
var a = document.getElementById('nama').value

if(a==""){alert('pilih');}

}
</script>
</head>

<body>
<label>
<select name="nama" id="nama" size="1">
  <option></option>
  <option>ahmad</option>
  <option>abu</option>
  <option>ali</option>
</select>
</label>
<input type="button" name="button" value="tekan" onclick="call()" >
</body>
</html>
