<?php
include ('../../db.php');
$ic = $_POST['input_map_6461_11438'];
$sesi = $_POST['input_map_6461_11439'];

$mohon = "select a.id_permohonan from usr_isac.prs_permohonan a,usr_isac.pro_peserta b where a.id_peserta=b.id_peserta and (b.no_kad_pengenalan='".$ic."' or b.no_kad_pengenalan_lain='".$ic."') and a.id_sesi='".$sesi."' ";
$mohonRs = $myQuery->query($mohon,'SELECT');
$id_mohon = $mohonRs[0][0];

$mykad = "select a.id_peserta,a.nama_peserta,date_format(c.tarikh_sesi,'%d-%m-%Y'),
				(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='iac') 
				AND
				referencestatuscode='00' 
				AND referencecode=c.kod_iac),
				(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='tahap') 
				AND
				referencestatuscode='00' 
				AND referencecode=c.kod_tahap),
				concat(
				(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral WHERE mastercode='XXX' 
				AND description1='masa_mula') 
				AND
				referencestatuscode='00' 
				AND referencecode=c.kod_masa_mula),
				' - ',
				(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral WHERE mastercode='XXX' 
				AND description1='masa_tamat') 
				AND
				referencestatuscode='00' 
				AND referencecode=c.kod_masa_tamat)) AS 'Masa :',
				c.lokasi,
				(SELECT description2 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='iac') 
				AND
				referencestatuscode='00' 
				AND referencecode=c.kod_iac)
				from 
				usr_isac.pro_peserta a,
				usr_isac.prs_permohonan b,
				usr_isac.pro_sesi c
				
				where 
				a.id_peserta=b.id_peserta
				and
				b.id_sesi=c.id_sesi
				and
				b.id_permohonan='".$id_mohon."'";

$mykadRs = $myQuery->query($mykad,'SELECT');
$usr     = $mykadRs[0][0];
$nama    = $mykadRs[0][1];
$tarikh  = $mykadRs[0][2];
$iac     = $mykadRs[0][3];
$tahap   = $mykadRs[0][4];
$masa    = $mykadRs[0][5];
$lokasi  = $mykadRs[0][6];
$alamat_iac= $mykadRs[0][7];

$tugas = "select gelaran_ketua_jabatan, bahagian,
		  	(SELECT description1 FROM refgeneral 
				WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='jabatan') 
				AND
				referencestatuscode='00' 
				AND referencecode=b.kod_jabatan),
		  	(SELECT description1 FROM refgeneral 
			WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='kementerian') 
				AND
				referencestatuscode='00' 
				AND referencecode=b.kod_kementerian),b.kod_kementerian,
			b.alamat_1, b.alamat_2, b.alamat_3,b.poskod,b.bandar,b.nama_penyelia,
			(SELECT description1 FROM refgeneral 
			WHERE
				mastercode=(SELECT referencecode
				FROM refgeneral where mastercode='XXX' 
				AND description1='negeri') 
				AND
				referencestatuscode='00' 
				AND referencecode=b.kod_negeri)			
			from
			usr_isac.pro_peserta a, 
			usr_isac.pro_tempat_tugas b
			where 
			a.id_peserta=b.id_peserta
			and
			a.no_kad_pengenalan = '".$ic."' or a.no_kad_pengenalan_lain = '".$ic."' ";  

$tugas2 = $myQuery->query($tugas,'SELECT');
$gelaran = $tugas2[0][0];
$bahagian = $tugas2[0][1];
$jabatan = $tugas2[0][2];
$kementerian = $tugas2[0][3];
$kod_kementerian = $tugas2[0][4];
$alamat1 = $tugas2[0][5];
$alamat2 = $tugas2[0][6];
$alamat3 = $tugas2[0][7];
$poskod = $tugas2[0][8];
$bandar = $tugas2[0][9];
$penyelia = $tugas2[0][10];
$negeri = $tugas2[0][11];
$today = date("j - n - Y");
$rujukan = "INTAN 52/4/25 (4)";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style15
{
text-align: center;
padding-top: 2px;
padding-right: 2px;
padding-bottom: 2px;
padding-left: 2px;
/*background-color: #347ff4;
*/background-repeat: repeat-x;
background-image: url(img/content/header_bar1.jpg);
}
.style31 {font-family: Arial, Helvetica, sans-serif; font-size: 15px; font-weight: bold; }


@media print
{
input#btnPrint {
display: none;
}
}
.style54 {font-family: Arial, sans-serif}
.style55 {font-size: 14px; font-family: Arial, sans-serif; }
.style57 {font-family: Arial, sans-serif; font-size: 15px; font-weight: bold; }
.style75 {font-size: 16px}
.style76 {font-family: Arial, sans-serif; font-size: 16px; }
.style80 {font-size: 14px; font-family: Arial, sans-serif; font-weight: bold; }
.style83 {font-family: Arial, sans-serif; color: #003399; }
.style85 {font-family: Arial, sans-serif; color: #FF3300; }
-->
</style>
</head>

<body>
<table id="tableContent" cellspacing="0" cellpadding="0" border="0" width="850">
  <tr>
    <td ><table width="100%" border="0">
      <tr class="style15">
        <td>&nbsp;</td>
      </tr>
    </table>
      <table width="100%" border="0">
          <tr>
            <td width="12%" class="style55" valign="top" ><img src="g_logo.jpg" width="90" height="90" /></td>
            <td width="76%" class="style55" align="center"><span class="style83"><strong>INSTITUT TADBIRAN AWAM NEGARA (INTAN)</strong><br />
              Jabatan Perkhidmatan Awam Malaysia<br />
              Bukit Kiara, Jalan Bukit Kiara, 50480 Kuala Lumpur</span><br />
              <span class="style85">Tel:03-20847777 (20 talian),http://www.intanbk.intan.my</span> </td>
            <td width="12%" class="style55"><span class="style54"></span><span class="style54"></span><span class="style54"></span><span class="style54"></span><span class="style54"></span><img src="intan.jpg" width="70" height="90" /><span class="style54"></span></td>
          </tr>
        </table>
      <table width="99%" border="0" align="center">
          <tr>
            <td colspan="3" class="style54">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" class="style54"><span class="style54 style75"><?php echo $gelaran; ?><br />
                  <?php if ($jabatan!=""){
			echo $jabatan;?>
                  <br />
                  <?php } ?>
                  <?php if($kod_kementerian!='129' and $kod_kementerian!='372' and $kod_kementerian!='492') {
			  echo $kementerian; ?>
                  <br />
                  <?php } ?>
                  <?php if($bahagian!="") {
			  echo $bahagian; ?>
                  <br />
                  <?php } ?>
                  <?php echo $alamat1; ?><br />
                  <?php if($alamat2!="") {
			  echo $alamat2; ?>
                  <br />
                  <?php }?>
                  <?php if($alamat3!="") {
			  echo $alamat3; ?>
                  <br />
                  <?php } ?>
                  <?php echo $poskod; ?>, <?php echo $bandar; ?><br />
                  <?php echo $negeri; ?></span></td>
          </tr>
          <tr>
            <td colspan="3" class="style54">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" class="style54"><span class="style54 style75">(up : <?php echo $penyelia; ?>)</span></td>
          </tr>
          <tr>
            <td colspan="3" class="style54" height="30"></td>
          </tr>
          <tr>
            <td colspan="3" class="style54" height="30">Tarikh : <?php echo $today ;  ?></td>
          </tr>
          
          <tr>
            <td colspan="3" class="style54" height="30">Ruj Kami : <?php echo $rujukan ;  ?> </td>
          </tr>
          
          <tr>
            <td colspan="3" class="style54" height="30"><p>Tuan/Puan,</p>            </td>
          </tr>
          <tr>
            <td colspan="3" class="style54" height="30"></td>
          </tr>
          <tr>
            <td colspan="3" class="style54" height="30"><strong>Tawaran Penilaian ICT Skills Assessment And Certification (ISAC)</strong></td>
          </tr>
          <tr>
            <td colspan="3" class="style54">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" class="style54">Dengan hormatnya merujuk perkara di atas.</td>
          </tr>
          <tr>
            <td colspan="3" class="style54">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" class="style54"><p align="justify" class="style54"> 2. Adalah dimaklumkan bahawa pegawai tuan/puan telah ditawarkan untuk menduduki ujian Penilaian ICT Skills  Assessment and Certification (ISAC). Maklumat lengkap ujian adalah seperti berikut :-</p></td>
          </tr>
          <tr>
            <td colspan="3" class="style54">&nbsp;</td>
          </tr>
          <tr>
            <td width="14%" class="style57" height="30px" valign="bottom">Nama</td>
            <td width="1%" height="30px" valign="bottom"><div align="center" class="style76"><strong>:</strong></div></td>
            <td width="85%" height="30px" valign="bottom"><span class="style76"><?php echo $nama; ?></span></td>
        </tr>
          <tr>
            <td class="style57">No.Mykad</td>
            <td><div align="center" class="style76"><strong>:</strong></div></td>
            <td><span class="style76"><?php echo $ic; ?></span></td>
          </tr>
          <tr>
            <td class="style57">Tahap Penilaian</td>
            <td><div align="center" class="style76"><strong>:</strong></div></td>
            <td><span class="style76"><?php echo $tahap; ?></span></td>
          </tr>
          <tr>
            <td class="style57">Tarikh Penilaian</td>
            <td><div align="center" class="style76"><strong>:</strong></div></td>
            <td><span class="style76"><?php echo $tarikh; ?></span></td>
          </tr>
          <tr>
            <td class="style57">Masa</td>
            <td><div align="center" class="style76"><strong>:</strong></div></td>
            <td><span class="style76"><?php echo $masa; ?></span></td>
          </tr>
          <tr>
            <td class="style57">Pusat Penilaian</td>
            <td><div align="center" class="style76"><strong>:</strong></div></td>
            <td><span class="style76"><?php echo $iac; ?></span></td>
          </tr>
          <tr>
            <td class="style57">Lokasi</td>
            <td><div align="center" class="style76"><strong>:</strong></div></td>
            <td><span class="style76"><?php echo $lokasi; ?></span></td>
          </tr>
          <tr>
            <td rowspan="3" class="style57" height="30px" valign="top">Alamat</td>
            <td height="30px" valign="top"><div align="center" class="style76"><strong>:</strong></div></td>
            <td rowspan="3" height="30px" valign="top"><span class="style76"><?php echo $alamat_iac; ?></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="justify" class="style54" height="30px" valign="bottom">3. Sekiranya tuan/puan tidak dapat hadir pada tarikh penilaian, sila beri penjelasan melalui emel berikut : <strong>isachelp@intanbk.intan.my </strong>sebelum tarikh penilaian. Kegagalan untuk berbuat demikian akan mengakibatkan nama tuan/puan *DISENARAIHITAMKAN* daripada menduduki ujian penilaian di  masa akan datang.</td>
          </tr>
          <tr>
            <td colspan="3" class="style54">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="justify" class="style54">Sebarang kemusykilan/masalah, sila hubungi kami melalui emel: isachelp@intanbk.intan.my.</td>
          </tr>
          <tr>
            <td colspan="3" class="style54">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" class="style54">Sekian, terima kasih.</td>
          </tr>
          <tr>
            <td colspan="3" class="style54">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" class="style54"  height="30"><span class="style80">&quot;JPA Peneraju Perubahan Perkhidmatan Awam&quot;</span></td>
          </tr>
          <tr>
            <td colspan="3" class="style54"><span class="style80">&quot;1 Sentiasa di Hadapan&quot;</span></td>
          </tr>
          <tr>
            <td colspan="3" class="style54">&nbsp;</td>
          </tr>
      </table>
      <table width="100%" border="0">
          <tr>
            <td width="41%" valign="top" class="style55">
           <strong class="style55">MOGHIRATUNNAJAT HJ ZAKARIA</strong>
            <br/>
              Ketua Unit Penilaian, Portal dan Penerbitan<br />
              Program Perkhidmatan Aplikasi <br />              
              Institut Tadbiran Awam Negara (INTAN)<br />
              Kampus Utama Bukit Kiara <br />
            50480 Kuala Lumpur</td>
            <td width="30%" class="style55" valign="top" align="right">&nbsp;</td>
            <td width="29%" class="style55" valign="top" ><img src="cop.jpg" width="130" height="130" /></td>
          </tr>
          
          
          <tr>
            <td colspan="3" class="style55"><span class="style54"><strong>Ini adalah cetakan komputer. Tandatangan tidak diperlukan. </strong></span></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
      </table></td>
  </tr>
</table>
</body>
</html>