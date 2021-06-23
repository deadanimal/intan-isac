<?php 
//error_reporting(E_ERROR | E_PARSE);
include "connection.php";
$con = new connect();

include_once 'log_user.php';

 
 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>e-Sijil ISAC</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
     <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
 <style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

#customers td, #customers th {
    font-size: 1em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
	text-align:left
}

#customers th {
    font-size: 1.1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #ffffff;
}
 
</style>
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <strong> Emel: </strong>isachelp@intanbk.intan.my
                    &nbsp;&nbsp;
                    <strong>Telefon: </strong>03-2084 7798 / 7714
                </div>

            </div>
        </div>
    </header>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">

                <img src="img/esijil.png" width="361" /></a>

            </div>

            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">

                        <li class="dropdown">
                            
                             
                        </li>


                    </ul>
                </div>
            </div>
        </div>
    </div>
 
     
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12" align="center">
                        <h1 class="page-head-line">Cetak sijil online </h1>
                    </div>
                    <a href="http://isac.intan.my/isac"><h3><i class=" fa fa-home "></i>  <strong>Utama</strong></h3></a>
                </div>
                 
                <div>
                    <div>
                        <div class="panel panel-default">
                        <div class="panel-heading">
                       <strong>    Semakan Keputusan</strong>
                        </div>
                        <div class="panel-body" style=" text-align:center">
                       
                      <form id="semak" class="form-inline" action="" method="post">
  <div class="form-group">
    <!--<label for="exampleInputEmail1">No.Mykad&nbsp;&nbsp</label>-->

    <input type="text" class="validate[required] form-control" name="ic" placeholder="No. Mykad" style="text-align:center;" onkeypress="return isNumberKey(event)" maxlength="12"/>&nbsp;&nbsp<button name="btn-search" type="submit" class="btn btn-default">Cari</button>
  </div>
 
  </form>
   <?php      if(isset($_POST['btn-search'])) {
$nokp = trim(addslashes(htmlentities($_REQUEST['ic'])));
$sqlquery = $con->getdata("SELECT
pro_peserta.ID_PESERTA,
pro_peserta.NAMA_PESERTA,
pro_peserta.KOD_KATEGORI_PESERTA,
pro_peserta.NO_KAD_PENGENALAN,
pro_peserta.NO_KAD_PENGENALAN_LAIN,
pro_sijil.ID_SIJIL,
pro_sijil.NO_SIJIL,
pro_sijil.KOD_IAC,
pro_sijil.TAHUN,
pro_sijil.ID_PESERTA,
pro_sijil.ID_PERMOHONAN,
pro_sijil.`TIMESTAMP`,
prs_penilaian_peserta.KOD_STATUS_KELULUSAN,
prs_permohonan.ID_SESI
FROM
pro_peserta
INNER JOIN pro_sijil ON pro_sijil.ID_PESERTA = pro_peserta.ID_PESERTA
INNER JOIN prs_penilaian_peserta ON pro_peserta.ID_PESERTA = prs_penilaian_peserta.ID_PESERTA
INNER JOIN prs_permohonan ON prs_permohonan.ID_PERMOHONAN = pro_sijil.ID_PERMOHONAN
WHERE prs_penilaian_peserta.KOD_STATUS_KELULUSAN ='Lulus' AND NO_KAD_PENGENALAN = '".$nokp."'"); 	

/*$sqlquery = $con->getdata("SELECT
pro_peserta.ID_PESERTA,
pro_peserta.NAMA_PESERTA,
pro_peserta.KOD_KATEGORI_PESERTA,
pro_peserta.NO_KAD_PENGENALAN,
pro_peserta.NO_KAD_PENGENALAN_LAIN,
pro_sijil.ID_SIJIL,
pro_sijil.NO_SIJIL,
pro_sijil.KOD_IAC,
pro_sijil.TAHUN,
pro_sijil.ID_PESERTA,
pro_sijil.ID_PERMOHONAN,
pro_sijil.`TIMESTAMP`,
prs_penilaian_peserta.KOD_STATUS_KELULUSAN,
prs_permohonan.ID_SESI
FROM
pro_peserta
INNER JOIN pro_sijil ON pro_sijil.ID_PESERTA = pro_peserta.ID_PESERTA
INNER JOIN prs_penilaian_peserta ON pro_peserta.ID_PESERTA = prs_penilaian_peserta.ID_PESERTA
INNER JOIN prs_permohonan ON prs_permohonan.ID_PERMOHONAN = pro_sijil.ID_PERMOHONAN
WHERE prs_penilaian_peserta.KOD_STATUS_KELULUSAN ='Lulus' AND YEAR(pro_sijil.`TIMESTAMP`) >= '2015' AND NO_KAD_PENGENALAN = '".$nokp."'"); */

$user_ip = getUserIP();
$datelog = datelog();
$sqllog="INSERT INTO sijil_log(Ip,Ic,DateLog,Activity) VALUES('".$user_ip."','".$_REQUEST['ic']."','".$datelog."','Semak')";
$con->setdata($sqllog);
 
if(mysql_num_rows($sqlquery)==0) 

{ 

echo "<hr />";

echo "<font color='#FF0000'>Maaf, maklumat anda tiada dalam rekod</font>"; } else {

 $matched=mysql_fetch_array($sqlquery);
 {
		  				?>  
                           <hr />
                           <table id="customers">
                             <tr>
                               <th colspan="3"><strong>Maklumat Peserta</strong></th>
                             </tr>
                             <tr>
                               <td width="34%" bgcolor="#EAF2D3" class="alt"><strong>Nama</strong></td>
                               <td width="66%" bgcolor="#FFFFFF"><?php echo $matched['NAMA_PESERTA'];?></td>
                             </tr>
                             <tr class="alt">
                               <td bgcolor="#EAF2D3"><strong>No.Mykad</strong></td>
                               <td bgcolor="#FFFFFF"> <?php echo $matched['NO_KAD_PENGENALAN'];?></td>
                             </tr>
                             <tr>
                               <td bgcolor="#EAF2D3" class="alt"><strong>Tarikh Penilaian</strong></td>
                               <td bgcolor="#FFFFFF"><?php  echo date_format (new DateTime($matched['TIMESTAMP']), 'd-m-Y');  ?></td>
                             </tr>
                             <tr class="alt">
                               <td bgcolor="#EAF2D3" class="alt"><strong>Tempat Penilaian</strong></td>
                               <td bgcolor="#FFFFFF"><?php  
 
 switch ($matched['KOD_IAC']) {
    case "01":
        echo "INTAN Bukit Kiara, Kuala Lumpur";
        break;
    case "05":
        echo "INTAN Wilayah Timur (INTIM)";
        break;
    case "04":
        echo "INTAN Wilayah Utara (INTURA)";
        break;
case "03":
        echo "INTAN Wilayah Selatan (IKWAS)";
        break;
		   case "06":
        echo "INTAN Sabah";
        break;
		   case "07":
        echo "INTAN Sarawak";
        break;
    default:
        echo "Jabatan Perkhidmatan Awam, Putrajaya";
}
 ?></td>
                             </tr>
                             <tr>
                               <td bgcolor="#EAF2D3" class="alt"><strong>Keputusan</strong></td>
                               <td bgcolor="#FFFFFF"><?php  echo strtoupper($matched['KOD_STATUS_KELULUSAN']); ?></td>
                             </tr>
                           </table>
                           <?php if ($matched['KOD_STATUS_KELULUSAN'] == 'Lulus') { ?>
                           <form action="cetak.php" method="post" target="_blank">
                           
                           <input name="mykad" type="hidden" value="<?php echo $matched['NO_KAD_PENGENALAN'];?>"><br>

                          <button type="submit" class="btn btn-default">Cetak Sijil</button>
                           </form>
                           <?php } ?>
                         <hr />
                            
 <?php } } } ?>
  
                            </div>
                            </div>
                    </div>
                     
                </div>
                </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    &copy; 2017 INTAN | By : <a href="http://isac.intan.my/isac" target="_blank">isac</a>
                </div>

            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="validation/css/validationEngine.jquery.css" type="text/css"/>
	 
	<script src="validation/js/jquery-1.8.2.min.js" type="text/javascript">
	</script>
	<script src="validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
	</script>
	<script src="validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
	</script>
	<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#semak").validationEngine({autoHidePrompt:true});
		});
 
		function checkHELLO(field, rules, i, options){
			if (field.val() != "HELLO") {
				// this allows to use i18 for the error msgs
				return options.allrules.validate2fields.alertText;
			}
		}
	</script>
     <script type="text/javascript">
	
	
    function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
} 


    </script>
    
    
</body>
</html>
