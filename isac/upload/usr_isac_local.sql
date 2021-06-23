-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 09, 2009 at 03:35 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `usr_isac`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `name` varchar(200) default NULL,
  `ic` varchar(50) default NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`name`, `ic`, `id`) VALUES
('asdasd', '2313', 1),
('123213', '1232', 2),
('21323', '12321', 3),
('sdas', '123123', 4),
('dededed', '121212121', 5),
('dededed', '121212121', 6),
('dededed', '121212121', 7),
('dededed', '121212121', 8),
('testing', '123', 9),
('testing', '123', 12);

-- --------------------------------------------------------

--
-- Table structure for table `dummy`
--

CREATE TABLE IF NOT EXISTS `dummy` (
  `id_dummy` int(11) NOT NULL auto_increment,
  `ic` int(11) NOT NULL,
  `nama` text NOT NULL,
  `sesi` int(11) NOT NULL,
  `masa` varchar(20) NOT NULL,
  `Tarikh` text NOT NULL,
  `lokasi` text NOT NULL,
  `IAC` text NOT NULL,
  `makmal` text NOT NULL,
  `bil_peserta` varchar(10) NOT NULL,
  `hari_lahir` text NOT NULL,
  `bulan_lahir` text NOT NULL,
  `tahun_lahir` text NOT NULL,
  `jantina` text NOT NULL,
  `gelaran_jawatan` text NOT NULL,
  `peringkat` text NOT NULL,
  `klasifikasi_perkhidmatan` text NOT NULL,
  `gred_jawatan` text NOT NULL,
  `taraf_perjawatan` text NOT NULL,
  `jenis_perkhidmatan` text NOT NULL,
  `emel` text NOT NULL,
  `no_tel_pej` text NOT NULL,
  `no_tel_hp` text NOT NULL,
  `tujuan` text NOT NULL,
  `gelaran` text NOT NULL,
  `gelaran_kj` text NOT NULL,
  `bahagian_jabatan` text NOT NULL,
  `alamat_pej` text NOT NULL,
  `poskod` text NOT NULL,
  `bandar` text NOT NULL,
  `negeri` text NOT NULL,
  `negara` text NOT NULL,
  `nama_penyelia` text NOT NULL,
  `emel_penyelia` text NOT NULL,
  `no_tel_penyelia` text NOT NULL,
  `no_fax_penyelia` text NOT NULL,
  `nama_penyelaras` text NOT NULL,
  `emel_penyelaras` text NOT NULL,
  `kementerian_agensi` text NOT NULL,
  `cawangan_negeri` text NOT NULL,
  `no_tel_penyelaras` text NOT NULL,
  `no_fax_penyelaras` text NOT NULL,
  `status` text NOT NULL,
  `tarikh_lantikan` text NOT NULL,
  `jawapan1` text NOT NULL,
  `jawapan2` text NOT NULL,
  PRIMARY KEY  (`id_dummy`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `dummy`
--

INSERT INTO `dummy` (`id_dummy`, `ic`, `nama`, `sesi`, `masa`, `Tarikh`, `lokasi`, `IAC`, `makmal`, `bil_peserta`, `hari_lahir`, `bulan_lahir`, `tahun_lahir`, `jantina`, `gelaran_jawatan`, `peringkat`, `klasifikasi_perkhidmatan`, `gred_jawatan`, `taraf_perjawatan`, `jenis_perkhidmatan`, `emel`, `no_tel_pej`, `no_tel_hp`, `tujuan`, `gelaran`, `gelaran_kj`, `bahagian_jabatan`, `alamat_pej`, `poskod`, `bandar`, `negeri`, `negara`, `nama_penyelia`, `emel_penyelia`, `no_tel_penyelia`, `no_fax_penyelia`, `nama_penyelaras`, `emel_penyelaras`, `kementerian_agensi`, `cawangan_negeri`, `no_tel_penyelaras`, `no_fax_penyelaras`, `status`, `tarikh_lantikan`, `jawapan1`, `jawapan2`) VALUES
(1, 111, 'qqq', 1, '9.00-10.30', '09-09-2009', 'Hospital Sungai Buluh', 'HQ,INTAN Bukit Kiara', 'Makmal 1', '20', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(2, 222, 'aaa', 2, '2.30-4.00', '10-09-2009', '', 'IKWAS', 'Makmal 2', '15', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Pending', '', 'Keyboard', ''),
(3, 333, 'ccccc', 2, '9.00-10.30', '10-10-2009', 'Hospital Batu Pahat', 'IKWAS', 'Makmal 3', '11', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(4, 444, 'sssss', 1, '2.30-4.00', '09-10-2009', '', 'INTIM', 'Makmal 9', '22', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(5, 0, 'awww', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(6, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(7, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(8, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(9, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(10, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(11, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(12, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(13, 0, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(14, 2147483647, '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '', ''),
(15, 2147483647, 'ghgh', 0, '', '', '', '', '', '', '12', '12', '4545', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '', ''),
(16, 2147483647, 'cc', 0, '', '', '', '', '', '', '12', '11', '1967', '01', '', '', '', '', '', '', '', '', '', '', '01', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `dummy2`
--

CREATE TABLE IF NOT EXISTS `dummy2` (
  `id` int(11) NOT NULL,
  `kod_jaw` text NOT NULL,
  `ket_jaw` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dummy2`
--

INSERT INTO `dummy2` (`id`, `kod_jaw`, `ket_jaw`) VALUES
(1, 'BM', 'Betul'),
(2, 'BM', 'Salah'),
(3, 'BI', 'True'),
(4, 'BI', 'False');

-- --------------------------------------------------------

--
-- Table structure for table `log_penghantaran`
--

CREATE TABLE IF NOT EXISTS `log_penghantaran` (
  `ID_LOG_PENGHANTARAN` int(11) NOT NULL auto_increment,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `ID_PESERTA` int(11) default NULL,
  `ID_RUJUKAN` int(11) default NULL,
  PRIMARY KEY  (`ID_LOG_PENGHANTARAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `log_penghantaran`
--


-- --------------------------------------------------------

--
-- Table structure for table `pro_agensi`
--

CREATE TABLE IF NOT EXISTS `pro_agensi` (
  `ID_AGENSI` int(11) NOT NULL auto_increment,
  `KOD_KEMENTERIAN` varchar(20) default NULL,
  `KOD_JABATAN` varchar(20) default NULL,
  `BAHAGIAN` varchar(100) default NULL,
  `ALLAMAT_1` varchar(100) default NULL,
  `ALAMAT_2` varchar(100) default NULL,
  `ALAMAT_3` varchar(100) default NULL,
  `POSKOD` varchar(5) default NULL,
  `KOD_NEGERI` varchar(20) default NULL,
  `KOD_NEGARA` varchar(20) default NULL,
  PRIMARY KEY  (`ID_AGENSI`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pro_agensi`
--


-- --------------------------------------------------------

--
-- Table structure for table `pro_jawapan`
--

CREATE TABLE IF NOT EXISTS `pro_jawapan` (
  `ID_JAWAPAN` int(11) NOT NULL auto_increment,
  `ID_SOALAN` int(11) default NULL,
  `ID_SOALAN_PERINCIAN` int(11) default NULL,
  `SKEMA_JAWAPAN` text,
  `JAWAPAN_SUBJEKTIF` text,
  `MARKAH` int(11) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `TARIKH_CIPTA` varchar(20) default NULL,
  PRIMARY KEY  (`ID_JAWAPAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pro_jawapan`
--


-- --------------------------------------------------------

--
-- Table structure for table `pro_kawalan_sistem`
--

CREATE TABLE IF NOT EXISTS `pro_kawalan_sistem` (
  `ID_KAWALAN_SISTEM` int(11) NOT NULL auto_increment,
  `TEMPOH_TUTUP_TARIKH_PENILAIAN_INDIVIDU` varchar(20) default NULL,
  `TEMPOH_TUTUP_TARIKH_PENILAIAN_KUMPULAN` varchar(20) default NULL,
  `TEMPOH_KEBENARAN_PERMOHONAN_PESERTA_GAGAL` varchar(20) default NULL,
  `TEMPOH_KEBENARAN_PERMOHONAN_PESERTA_BLACKLIST` varchar(20) default NULL,
  PRIMARY KEY  (`ID_KAWALAN_SISTEM`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pro_kawalan_sistem`
--

INSERT INTO `pro_kawalan_sistem` (`ID_KAWALAN_SISTEM`, `TEMPOH_TUTUP_TARIKH_PENILAIAN_INDIVIDU`, `TEMPOH_TUTUP_TARIKH_PENILAIAN_KUMPULAN`, `TEMPOH_KEBENARAN_PERMOHONAN_PESERTA_GAGAL`, `TEMPOH_KEBENARAN_PERMOHONAN_PESERTA_BLACKLIST`) VALUES
(1, '10', '5', '30', '180');

-- --------------------------------------------------------

--
-- Table structure for table `pro_kemahiran`
--

CREATE TABLE IF NOT EXISTS `pro_kemahiran` (
  `ID_KEMAHIRAN` int(11) NOT NULL auto_increment,
  `ID_SOALAN` int(11) default NULL,
  `KOD_SET_SOALAN` varchar(20) default NULL,
  `KOD_BAHAGIAN_SOALAN` varchar(20) default NULL,
  `ARAHAN_UMUM` text,
  PRIMARY KEY  (`ID_KEMAHIRAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pro_kemahiran`
--


-- --------------------------------------------------------

--
-- Table structure for table `pro_pemilihan_soalan`
--

CREATE TABLE IF NOT EXISTS `pro_pemilihan_soalan` (
  `ID_PEMILIHAN_SOALAN` int(11) NOT NULL auto_increment,
  `NAMA_PEMILIHAN_SOALAN` varchar(100) default NULL,
  `KOD_TAHAP_SOALAN` varchar(20) default NULL,
  `NILAI_MARKAH_LULUS` int(11) default NULL,
  `NILAI_JUMLAH_MARKAH` int(11) default NULL,
  `MASA_PENILAIAN` varchar(20) default NULL,
  `JUMLAH_KESELURUHAN_SOALAN` int(11) default NULL,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `KOD_STATUS` int(11) default NULL,
  PRIMARY KEY  (`ID_PEMILIHAN_SOALAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `pro_pemilihan_soalan`
--

INSERT INTO `pro_pemilihan_soalan` (`ID_PEMILIHAN_SOALAN`, `NAMA_PEMILIHAN_SOALAN`, `KOD_TAHAP_SOALAN`, `NILAI_MARKAH_LULUS`, `NILAI_JUMLAH_MARKAH`, `MASA_PENILAIAN`, `JUMLAH_KESELURUHAN_SOALAN`, `TARIKH_CIPTA`, `ID_PENGGUNA`, `KOD_STATUS`) VALUES
(35, 'Pemilihan Set Soalan Tahap Basic', '01', 20, 20, NULL, 40, '2009-10-19', NULL, NULL),
(36, 'Pemilihan Set Soalan Tahap Advanced', '02', 20, 20, NULL, 40, '2009-10-19', NULL, NULL),
(37, '', '', 0, 0, NULL, 0, '2009-10-20', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pro_pemilihan_soalan_kumpulan`
--

CREATE TABLE IF NOT EXISTS `pro_pemilihan_soalan_kumpulan` (
  `ID_PEMILIHAN_SOALAN_KUMPULAN` int(11) NOT NULL auto_increment,
  `ID_PEMILIHAN_SOALAN` int(11) default NULL,
  `KOD_TAHAP_SOALAN` varchar(20) default NULL,
  `KOD_KATEGORI_SOALAN` varchar(20) default NULL,
  `NILAI_JUMLAH_SOALAN` int(11) default NULL,
  `KOD_JENIS_PEMILIHAN_SOALAN` varchar(20) default NULL,
  PRIMARY KEY  (`ID_PEMILIHAN_SOALAN_KUMPULAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `pro_pemilihan_soalan_kumpulan`
--

INSERT INTO `pro_pemilihan_soalan_kumpulan` (`ID_PEMILIHAN_SOALAN_KUMPULAN`, `ID_PEMILIHAN_SOALAN`, `KOD_TAHAP_SOALAN`, `KOD_KATEGORI_SOALAN`, `NILAI_JUMLAH_SOALAN`, `KOD_JENIS_PEMILIHAN_SOALAN`) VALUES
(45, 36, '02', '05', 8, NULL),
(41, 36, '02', '01', 8, NULL),
(42, 36, '02', '03', 8, NULL),
(43, 36, '01', '04', 8, NULL),
(44, 36, '01', '07', 8, NULL),
(37, 35, '01', '01', 10, NULL),
(38, 35, '01', '02', 10, NULL),
(39, 35, '01', '03', 10, NULL),
(40, 35, '01', '04', 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pro_pemilihan_soalan_perincian`
--

CREATE TABLE IF NOT EXISTS `pro_pemilihan_soalan_perincian` (
  `ID_PEMILIHAN_SOALAN_PERINCIAN` int(11) NOT NULL auto_increment,
  `ID_PEMILIHAN_SOALAN` int(11) default NULL,
  `ID_PEMILIHAN_SOALAN_KUMPULAN` int(11) default NULL,
  `ID_SOALAN` int(11) default NULL,
  PRIMARY KEY  (`ID_PEMILIHAN_SOALAN_PERINCIAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pro_pemilihan_soalan_perincian`
--


-- --------------------------------------------------------

--
-- Table structure for table `pro_pengawas`
--

CREATE TABLE IF NOT EXISTS `pro_pengawas` (
  `ID_PENGAWAS` int(11) NOT NULL auto_increment,
  `ID_AGENSI` int(11) default NULL,
  `ID_SESI` int(11) default NULL,
  PRIMARY KEY  (`ID_PENGAWAS`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pro_pengawas`
--


-- --------------------------------------------------------

--
-- Table structure for table `pro_pengetahuan`
--

CREATE TABLE IF NOT EXISTS `pro_pengetahuan` (
  `ID_PENGETAHUAN` int(11) NOT NULL auto_increment,
  `ID_SOALAN` int(11) default NULL,
  `KOD_JENIS_SOALAN` varchar(20) default NULL,
  `PENGETAHUAN_SOALAN` varchar(100) default NULL,
  `TOPIK_SOALAN` varchar(20) default NULL,
  `KOD_FORMAT_JAWAPAN` varchar(20) default NULL,
  PRIMARY KEY  (`ID_PENGETAHUAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `pro_pengetahuan`
--

INSERT INTO `pro_pengetahuan` (`ID_PENGETAHUAN`, `ID_SOALAN`, `KOD_JENIS_SOALAN`, `PENGETAHUAN_SOALAN`, `TOPIK_SOALAN`, `KOD_FORMAT_JAWAPAN`) VALUES
(1, 1001, '01', 'pengetahuan a', 'it', NULL),
(2, 1002, '01', 'pengetahuan b', 'it', NULL),
(3, 1003, '01', 'pengetahuan c', 'it', NULL),
(4, 1004, '02', 'pengetahuan d', 'it', NULL),
(5, 1005, '02', 'pengetahuan e', 'it', NULL),
(6, 1006, '02', 'pengetahuan f', 'it', NULL),
(7, 1007, '03', 'pengetahuan g', 'it', NULL),
(8, 1008, '03', 'pengetahuan h', 'it', NULL),
(9, 1009, '03', 'pengetahuan i', 'it', NULL),
(10, 10010, '03', 'pengetahuan j', 'it', NULL),
(11, NULL, NULL, 'testing', 'testing jgk', NULL),
(12, NULL, NULL, 'it skills', 'basic computer', NULL),
(13, NULL, NULL, 'try n error', 'try n error2', NULL),
(14, NULL, NULL, 'try n error', 'try n error2', NULL),
(15, NULL, NULL, 'try n error', 'try n error2', NULL),
(16, NULL, '02', 'penat1', 'penat2', NULL),
(17, 0, '02', 'lapar', 'lapar2', NULL),
(18, 32, '04', 'qq', 'qq', NULL),
(19, 33, '02', 'bgvjvchbgjfhjgfjnbfjgdhjf', 'fghfjhgkjhlk', NULL),
(20, 33, '02', 'bgvjvchbgjfhjgfjnbfjgdhjf', 'fghfjhgkjhlk', NULL),
(21, 35, '02', 'gg', 'ggg', NULL),
(22, 35, '02', 'gg', 'ggg', NULL),
(23, 37, '', 'test', 'test', NULL),
(24, 38, '', '', '', NULL),
(25, 39, '', '', '', NULL),
(26, 40, '', '', '', NULL),
(27, 41, '', '', '', NULL),
(28, 42, '', '', '', NULL),
(29, 43, '', '', '', NULL),
(30, 44, 'Fill in the blank', 'adasdas', 'adasdasd', NULL),
(31, 45, '', 'dsadasd', 'asdasdas', NULL),
(32, 44, 'Fill in the blank', 'adasdas', 'adasdasd', NULL),
(33, 47, 'Fill in the blank', 'asdasdd', 'sdsdsds', NULL),
(34, 48, 'Fill in the blank', 'adasdas', 'asdadas', NULL),
(35, 0, 'Subjective', 'asdadas', 'asdadasd', NULL),
(36, 0, 'Subjective', 'sdads', 'dasdasd', NULL),
(37, 0, 'Subjective', 'sdads', 'dasdasd', NULL),
(38, 0, 'Subjective', '123', '123', NULL),
(39, 0, 'Subjective', 'sada', 'sada', NULL),
(40, 54, 'Fill in the blank', 'test 1', 'test 1', NULL),
(41, 54, 'Fill in the blank', 'test 1', 'test 1', NULL),
(42, 0, 'Subjective', 'test 2', 'test 2', NULL),
(43, 0, 'Subjective', 'zzzzzzz', 'zzzzzzzzzz', NULL),
(44, 0, 'Subjective', 'cc', 'cc', NULL),
(45, 0, 'Subjective', 'xdxd', 'xxxx', NULL),
(46, 60, '', 'asdasda', 'dasdasda', NULL),
(47, 61, 'Subjective', '123', '123', NULL),
(48, 62, 'Fill in the blank', 'a', 's', NULL),
(49, 0, 'True or False', 'Ori', 'Gaji', NULL),
(50, 64, 'True or False', 'Ori', 'Gaji', NULL),
(51, 65, 'Fill in the blank', 'q', 'w', NULL),
(52, 65, 'Fill in the blank', 'q', 'w', NULL),
(53, 65, 'Fill in the blank', 'q', 'w', NULL),
(54, 68, 'Fill in the blank', 'q', 'w', NULL),
(55, 68, 'Fill in the blank', 'q', 'w', NULL),
(56, 70, 'Fill in the blank', 'adada', 'dsadsadas', NULL),
(57, 70, 'Fill in the blank', 'adada', 'dsadsadas', NULL),
(58, 72, 'Subjective', 'q', 'w', NULL),
(59, 73, 'Fill in the blank', 'adadas', 'asdadsad', NULL),
(60, 74, 'Fill in the blank', 'dasdad', 'asdadas', NULL),
(61, 75, 'Fill in the blank', 'dadasdasd', 'asdasdasdasdasdas', NULL),
(62, 75, 'Fill in the blank', 'dadasdasd', 'asdasdasdasdasdas', NULL),
(63, 75, 'Fill in the blank', 'dadasdasd', 'asdasdasdasdasdas', NULL),
(64, 78, 'Fill in the blank', 'asdasd', 'adsadas', NULL),
(65, 79, 'True or False', 'asdasd', 'asdasd', NULL),
(66, 80, '', 'sdasdas', 'dasdasdas', NULL),
(67, 80, '', 'sdasdas', 'dasdasdas', NULL),
(68, 82, 'Fill in the blank', 'saya', 'saya', NULL),
(69, 83, 'Fill in the blank', 'saya', 'saya', NULL),
(70, 84, 'Fill in the blank', 'asdasd', 'dasdasdas', NULL),
(71, 85, 'Fill in the blank', 'asdasd', 'dasdasdas', NULL),
(72, 86, 'Fill in the blank', '1', '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pro_penyelaras`
--

CREATE TABLE IF NOT EXISTS `pro_penyelaras` (
  `ID_PENYELARAS` int(11) NOT NULL auto_increment,
  `NAMA_PENYELARAS` varchar(100) default NULL,
  `EMEL_PENYELARAS` varchar(50) default NULL,
  `KOD_KEMENTERIAN` varchar(20) default NULL,
  `NO_TELEFON_PEJABAT` varchar(20) default NULL,
  `NO_TELEFON_BIMBIT` varchar(20) default NULL,
  `NO_FAX` varchar(20) default NULL,
  `LOG_ID_PENGGUNA` varchar(50) default NULL,
  `KATALALUAN` varchar(50) default NULL,
  `USERID` int(11) default NULL,
  PRIMARY KEY  (`ID_PENYELARAS`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `pro_penyelaras`
--

INSERT INTO `pro_penyelaras` (`ID_PENYELARAS`, `NAMA_PENYELARAS`, `EMEL_PENYELARAS`, `KOD_KEMENTERIAN`, `NO_TELEFON_PEJABAT`, `NO_TELEFON_BIMBIT`, `NO_FAX`, `LOG_ID_PENGGUNA`, `KATALALUAN`, `USERID`) VALUES
(1, 'qq', 'qq@gmail.com', '121', '121212', NULL, '432424', 'qq', '123', NULL),
(28, 'Mohd Farhan Isa', 'paan@gmail.com', '101', '0634566543', NULL, '0345677651', 'paan', '123', 43),
(5, 'Array', 'Array', 'Array', 'Array', NULL, 'Array', 'try', 'try', 31),
(6, 'Adibah af', 'diba@yahoo.com', '481', '035670001', NULL, '035670002', 'qusiah', '123', 32),
(20, 'qq', 'qq@gmail.com', '121', '121212', NULL, '432424', 'qq', 'qq', 38),
(21, 'ann', 'ann@gmail.com', '103', NULL, NULL, NULL, 'ann', '', 38),
(22, 'nor', 'aa@gmail.com', '103', NULL, NULL, NULL, 'nor', '123', 38),
(23, 'zz', 'zz', '482', NULL, NULL, NULL, 'zz', 'zz', 38),
(24, 'dd', 'dd', '123', '035678888', NULL, '032888888', 'dd', 'dd', 39),
(25, 'xx', 'xx', '482', '121212', NULL, '432424', 'xx', 'xx', 40),
(26, 'noraini md isa', 'ina@gmail.com', '103', '0311112222', NULL, '0322223333', 'noraini', '123', 41),
(27, 'jue', 'aa@gmail.com', '103', '0312344564', NULL, '0312344565', 'jue', '123', 42);

-- --------------------------------------------------------

--
-- Table structure for table `pro_peribadi`
--

CREATE TABLE IF NOT EXISTS `pro_peribadi` (
  `ID_PERIBADI` int(11) NOT NULL auto_increment,
  `NAMA_PERIBADI` varchar(100) default NULL,
  `NO_KAD_PENGENALAN` varchar(20) default NULL,
  `NO_KAD_PENGENALAN_LAIN` varchar(50) default NULL,
  `KOD_GELARAN` varchar(20) default NULL,
  `TARIKH_LAHIR_HARI` varchar(20) default NULL,
  `TARIKH_LAHIR_BULAN` varchar(20) default NULL,
  `TARIKH_LAHIR_TAHUN` varchar(20) default NULL,
  `KOD_JANTINA` varchar(20) default NULL,
  PRIMARY KEY  (`ID_PERIBADI`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `pro_peribadi`
--

INSERT INTO `pro_peribadi` (`ID_PERIBADI`, `NAMA_PERIBADI`, `NO_KAD_PENGENALAN`, `NO_KAD_PENGENALAN_LAIN`, `KOD_GELARAN`, `TARIKH_LAHIR_HARI`, `TARIKH_LAHIR_BULAN`, `TARIKH_LAHIR_TAHUN`, `KOD_JANTINA`) VALUES
(5, 'xxxxxxxx', '123456789', '', '02', '', '', '', ''),
(4, 'Nor Qusiah Bte Abdul Razak', '111', '', '10', '9', '09', '1986', '02'),
(10, 'maisarah', '55555555', '', '02', '', '', '', ''),
(9, 'aaaaa', '9999999999', '', '02', '', '', '', ''),
(11, '', '', '', '', '', '', '', ''),
(12, 'azazaa', '', '', '02', '', '', '', '02'),
(13, 'rerr', '', '', '15', '01', '01', '1992', '01'),
(14, 'dfdf', '', '', '03', '01', '01', '1986', '02'),
(15, 'ff', '', '', '', '', '', '', ''),
(16, 'ghgh', '', '', '15', '02', '01', '1990', '01'),
(17, 'zzzzzzzzzzzzzzzzzz', '', '', '', '', '', '', ''),
(18, 'ddd', '', '', '05', '01', '01', '', '02'),
(19, 'ss', '', '', '15', '', '', '', ''),
(20, '', '', '', '', '', '', '', ''),
(21, '', '', '', '', '', '', '', ''),
(22, '', '', '', '', '', '', '', ''),
(23, '', '', '', '', '', '', '', ''),
(24, '', '', '', '', '', '', '', ''),
(25, 'shidotta', '', '', '', '', '', '', ''),
(26, '', '', '', '', '', '', '', ''),
(27, '', '', '', '', '', '', '', ''),
(28, '', '', '', '', '', '', '', ''),
(29, 'sdgdfh', '', '', '', '', '', '', ''),
(30, 'sdg', '', '', '', '', '', '', ''),
(31, '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pro_perkhidmatan`
--

CREATE TABLE IF NOT EXISTS `pro_perkhidmatan` (
  `ID_PERKHIDMATAN` int(11) NOT NULL auto_increment,
  `KOD_GELARAN_JAWATAN` varchar(20) default NULL,
  `KOD_PERINGKAT` varchar(20) default NULL,
  `KOD_KLASIFIKASI_PERKHIDMATAN` varchar(20) default NULL,
  `KOD_GRED_JAWATAN` varchar(20) default NULL,
  `KOD_TARAF_PERJAWATAN` varchar(20) default NULL,
  `KOD_JENIS_PERKHIDMATAN` varchar(20) default NULL,
  `TARIKH_LANTIKAN` date default NULL,
  `ID_PESERTA` int(11) default NULL,
  PRIMARY KEY  (`ID_PERKHIDMATAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164 ;

--
-- Dumping data for table `pro_perkhidmatan`
--

INSERT INTO `pro_perkhidmatan` (`ID_PERKHIDMATAN`, `KOD_GELARAN_JAWATAN`, `KOD_PERINGKAT`, `KOD_KLASIFIKASI_PERKHIDMATAN`, `KOD_GRED_JAWATAN`, `KOD_TARAF_PERJAWATAN`, `KOD_JENIS_PERKHIDMATAN`, `TARIKH_LANTIKAN`, `ID_PESERTA`) VALUES
(74, 'ketua jj', '02', '19', '06', '01', '04', '2008-10-01', 78),
(85, NULL, NULL, 'Array', 'Array', NULL, NULL, NULL, 0),
(86, NULL, NULL, 'Array', 'Array', NULL, NULL, NULL, 0),
(87, NULL, NULL, 'Array', 'Array', NULL, NULL, NULL, 0),
(88, NULL, NULL, 'Array', 'Array', NULL, NULL, NULL, 0),
(89, '', '', '', '', '', '', '0000-00-00', 93),
(90, NULL, NULL, 'Array', 'Array', NULL, NULL, NULL, 0),
(91, 'na', '01', '06', '39', '01', '02', '2008-10-06', 94),
(92, 'ketua', '02', '18', '18', '01', '01', '2008-10-06', 96),
(93, '', '', '', '', '', '', '0000-00-00', 98),
(94, 'ketua', '01', '16', '', '', '02', '2008-10-06', 100),
(95, '', '', '', '', '', '', '0000-00-00', 102),
(96, 'drt', '01', '02', '02', '02', '03', '2009-10-06', 104),
(97, 'ewrew', '02', '18', '02', '02', '01', NULL, 106),
(98, NULL, NULL, 'Array', 'Array', NULL, NULL, NULL, 0),
(99, NULL, NULL, 'Array', 'Array', NULL, NULL, NULL, 0),
(68, 'ewrew', '02', '17', '17', '02', '01', '2009-10-20', 72),
(100, 'aa', '01', '18', '19', '01', '02', '2007-10-15', 109),
(101, NULL, NULL, 'Array', 'Array', NULL, NULL, NULL, 0),
(102, NULL, NULL, '18', '17', NULL, NULL, NULL, 0),
(103, NULL, NULL, '13', '11', NULL, NULL, NULL, 0),
(104, NULL, NULL, '05', '07', NULL, NULL, NULL, 0),
(40, 'Setiausaha', '02', '17', '44', '02', '03', '2009-10-07', 44),
(105, NULL, NULL, '03', '32', NULL, NULL, NULL, 0),
(78, 'ketua', '02', '19', '02', '02', '02', '2009-10-05', 78),
(67, 'Setiausaha', '01', '11', '37', '03', '01', '2008-10-07', 71),
(46, 'drt', '01', '18', '18', '01', '02', '2009-10-06', 50),
(114, 'fffffffffff', '', '', '', '', '', NULL, 117),
(115, 'Ketua Bahagian', '01', '11', '18', '03', '01', NULL, 118),
(116, NULL, NULL, '18', '18', NULL, NULL, NULL, 119),
(117, 'uuu', '02', '17', '18', '03', '02', '2009-10-06', 120),
(118, 'Ketua Jabatan', '03', '06', '03', '02', '01', '2006-10-02', 120),
(106, NULL, NULL, '18', '17', NULL, NULL, NULL, 111),
(107, NULL, NULL, '13', '11', NULL, NULL, NULL, 111),
(108, NULL, NULL, '05', '07', NULL, NULL, NULL, 111),
(109, NULL, NULL, '03', '32', NULL, NULL, NULL, 111),
(110, NULL, NULL, '16', '18', NULL, NULL, NULL, 112),
(113, 's/u', '01', '18', '17', '02', '02', '2009-10-20', 116),
(119, 'Setiausaha', '02', '4', '19', '01', '05', NULL, 122),
(120, 'Penolong Ketua Bahag', '03', '6', '17', '01', '01', '0000-00-00', 123),
(121, 'Ketua Pengarah', '01', '11', '03', '02', '01', '2004-10-04', 124),
(122, 'Pengarah', '02', '21', '01', '02', '05', NULL, 125),
(123, NULL, NULL, '19', '19', NULL, NULL, NULL, 126),
(124, NULL, NULL, '3', '19', NULL, NULL, NULL, 127),
(125, NULL, NULL, '19', '18', NULL, NULL, NULL, 128),
(126, NULL, NULL, '3', '55', NULL, NULL, NULL, 131),
(127, '', '', '', '', '', '', '0000-00-00', 132),
(128, NULL, NULL, '8', '55', NULL, NULL, NULL, 133),
(129, NULL, NULL, '20', '20', NULL, NULL, NULL, 134),
(130, NULL, NULL, '18', '55', NULL, NULL, NULL, 135),
(131, NULL, NULL, '6', '55', NULL, NULL, NULL, 136),
(132, NULL, NULL, '20', '20', NULL, NULL, NULL, 137),
(133, NULL, NULL, '20', '24', NULL, NULL, NULL, 138),
(134, '11111', '01', '17', '15', '02', '01', '0000-00-00', 139),
(135, NULL, NULL, '20', '20', NULL, NULL, NULL, 140),
(136, NULL, NULL, '20', '20', NULL, NULL, NULL, 141),
(137, NULL, NULL, '', '', NULL, NULL, NULL, 142),
(138, NULL, NULL, '7', '19', NULL, NULL, NULL, 143),
(139, '', '', '', '', '', '', '0000-00-00', 144),
(140, NULL, NULL, '13', '10', NULL, NULL, NULL, 145),
(141, NULL, NULL, '18', '23', NULL, NULL, NULL, 146),
(142, NULL, NULL, '18', '19', NULL, NULL, NULL, 147),
(143, NULL, NULL, '5', '12', NULL, NULL, NULL, 148),
(144, NULL, NULL, '12', '21', NULL, NULL, NULL, 149),
(145, NULL, NULL, '4', '22', NULL, NULL, NULL, 150),
(146, NULL, NULL, '', '', NULL, NULL, NULL, 151),
(147, NULL, NULL, '8', '5', NULL, NULL, NULL, 152),
(148, NULL, NULL, '2', '17', NULL, NULL, NULL, 153),
(149, NULL, NULL, '19', '18', NULL, NULL, NULL, 154),
(150, NULL, NULL, '3', '16', NULL, NULL, NULL, 155),
(151, NULL, NULL, '16', '18', NULL, NULL, NULL, 156),
(152, NULL, NULL, '18', '18', NULL, NULL, NULL, 157),
(153, NULL, NULL, '17', '18', NULL, NULL, NULL, 158),
(154, NULL, NULL, '18', '18', NULL, NULL, NULL, 159),
(155, NULL, NULL, '17', '17', NULL, NULL, NULL, 160),
(156, NULL, NULL, '17', '17', NULL, NULL, NULL, 161),
(157, '', '', '', '', '', '', '0000-00-00', 162),
(158, NULL, NULL, '21', '7', NULL, NULL, NULL, 163),
(159, 'Pembantu Makmal', '03', '04', '17', '02', '01', '2009-08-03', 164),
(160, 'ddd', '', '', '', '', '', '0000-00-00', 165),
(161, '', '', '', '', '', '', '0000-00-00', 166),
(162, '', '', '', '', '', '', '0000-00-00', 167),
(163, 'steno', '03', '12', '17', '02', '01', '2007-09-03', 168);

-- --------------------------------------------------------

--
-- Table structure for table `pro_peserta`
--

CREATE TABLE IF NOT EXISTS `pro_peserta` (
  `ID_PESERTA` int(11) NOT NULL auto_increment,
  `KOD_GELARAN` varchar(20) default NULL,
  `NAMA_PESERTA` varchar(100) default NULL,
  `TARIKH_LAHIR_HARI` varchar(20) default NULL,
  `TARIKH_LAHIR_BULAN` varchar(20) default NULL,
  `TARIKH_LAHIR_TAHUN` varchar(20) default NULL,
  `KOD_JANTINA` varchar(20) default NULL,
  `EMEL_PESERTA` varchar(50) default NULL,
  `KOD_KATEGORI_PESERTA` varchar(20) default NULL,
  `NO_KAD_PENGENALAN` varchar(20) default NULL,
  `NO_KAD_PENGENALAN_LAIN` varchar(20) default NULL,
  `NO_TELEFON_BIMBIT` varchar(20) default NULL,
  `NO_TELEFON_PEJABAT` varchar(20) default NULL,
  `ID_PENYELARAS` int(11) default NULL,
  PRIMARY KEY  (`ID_PESERTA`),
  UNIQUE KEY `NO_KAD_PENGENALAN` (`NO_KAD_PENGENALAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=169 ;

--
-- Dumping data for table `pro_peserta`
--

INSERT INTO `pro_peserta` (`ID_PESERTA`, `KOD_GELARAN`, `NAMA_PESERTA`, `TARIKH_LAHIR_HARI`, `TARIKH_LAHIR_BULAN`, `TARIKH_LAHIR_TAHUN`, `KOD_JANTINA`, `EMEL_PESERTA`, `KOD_KATEGORI_PESERTA`, `NO_KAD_PENGENALAN`, `NO_KAD_PENGENALAN_LAIN`, `NO_TELEFON_BIMBIT`, `NO_TELEFON_PEJABAT`, `ID_PENYELARAS`) VALUES
(78, '03', 'jajaaa', '19', '01', '1982', '02', 'ff@gmail.com', '02', '222', NULL, '0124455124', '0312345678', NULL),
(95, '65', 'nana', '01', '01', '1981', '02', 'nana@gmail.com', '01', '999', NULL, '0124455124', '0312345678', NULL),
(97, '50', 'nazrul fitri', '18', '12', '1979', '01', 'nazrul@gmail.com', '01', '333', NULL, '0124455144', '0312345699', NULL),
(101, '49', 'nazrin abd razak', '08', '07', '1980', '01', 'erer@gmail.com', '01', '444', NULL, '0124455124', '0312345678', NULL),
(44, '02', 'Nor Qusiah Bte Abdul Razak', '09', '09', '1986', '02', 'norqusiah@gmail.com', '01', '860909335666', '', '', '0312345678', NULL),
(109, '02', 'syar', '01', '01', '1980', '02', 'erer@gmail.com', '01', '3434', '', '0124455124', '0345352632', NULL),
(71, '02', 'nor izzatie ahmad', '08', '07', '1879', '02', 'izzatie@gmail.com', '01', '850708432314', NULL, '0124455124', '0345352632', NULL),
(72, '05', 'ddd', '03', '02', '1978', '02', 'aa@gmail.com', '01', '111', NULL, '0124455124', '0312345678', NULL),
(50, '02', 'maria ahmad', '02', '01', '1977', '02', 'maria@gmail.com', '01', '123', '', '0124455124', '0312345678', NULL),
(106, '02', 'nor hazira ahmad', '19', '01', '1982', '02', 'ff@gmail.com', '01', '', '555', '0124455124', '0312345678', NULL),
(105, '15', 'ahmad', '04', '02', '1983', '01', 'erer@gmail.com', '01', NULL, '1313', '0124455124', '0312345678', NULL),
(114, '', 'faiz sssssssssssssssss', '', '', '', '', '', '01', '1212', '', '', '', NULL),
(115, '52', 'hhh', '', '', '', '', '', '01', '7878', '', '', '', NULL),
(116, '02', 'martasha', '01', '02', '1986', '02', 'erer@gmail.com', '01', '860909', '', '1111111111', '0312345699', NULL),
(117, '', 'hjhjjjjhtrytry', '', '', '', '', '', '', '144', '', '', '', NULL),
(118, '02', 'Norsyahirah binti anuar', '24', '08', '1989', '02', 'irah@yahoo.com', '', '890824106147', '', '', '0388889999', NULL),
(119, NULL, 'ain', NULL, NULL, NULL, NULL, NULL, NULL, '841127035806', '1122334455', NULL, NULL, 6),
(120, '03', 'yuuu', '19', '02', '1980', '02', 'ff@gmail.com', '01', '88888888', '', '78788', '78789', NULL),
(121, '50', 'mohd faiz bin mohamad', '02', '12', '1988', '01', 'faiz@gmail.com', '', '881202145133', '', '', '0399992121', NULL),
(122, '65', 'nurul hidayah binti mohd salleh', '11', '10', '1985', '02', 'nur_ida@yahoo.com', '', '851011016146', '', '', '0377751119', NULL),
(123, '50', 'mohd izzat asyraf bin abu bakar', '11', '12', '1984', '01', 'ejat_acap@gmail.com', '', '841211105733', '', '', '0322998811', NULL),
(124, '03', 'siti hajar binti rasyid', '10', '10', '1970', '02', 'ajar_ras@yahoo.com', '01', '701010145230', '', '0122573146', '0322839309', NULL),
(125, '48', 'radzil bin apis', '02', '03', '1974', '01', 'zil@gmail.com', '', '740302146644', '', '', '0390902121', NULL),
(126, NULL, 'ain', NULL, NULL, NULL, NULL, NULL, NULL, '841127035811', '', NULL, NULL, 24),
(127, NULL, 'kkkkk', NULL, NULL, NULL, NULL, NULL, NULL, '909999', '', NULL, NULL, 24),
(128, NULL, 'nia', NULL, NULL, NULL, NULL, NULL, '02', '841127035812', '', NULL, NULL, 24),
(129, NULL, 'fyfy', NULL, NULL, NULL, NULL, NULL, '02', '980000', '', NULL, NULL, 27),
(130, NULL, 'ygyg', NULL, NULL, NULL, NULL, NULL, '02', '56566', '', NULL, NULL, 27),
(131, NULL, 'fikriah', NULL, NULL, NULL, NULL, NULL, '02', '4448888', '', NULL, NULL, 27),
(132, '', '', '', '', '', '', '', '01', '0909090909', '', '', '', NULL),
(133, NULL, 'asdasdasdas', NULL, NULL, NULL, NULL, NULL, '02', '444444444', '', NULL, NULL, 27),
(134, NULL, 'asdadasd', NULL, NULL, NULL, NULL, NULL, '02', '11111', '', NULL, NULL, 27),
(135, NULL, 'adadadas', NULL, NULL, NULL, NULL, NULL, '02', '12312312', '', NULL, NULL, 27),
(136, NULL, 'Mohd Farhan Isa', NULL, NULL, NULL, NULL, NULL, '02', '1234', '', NULL, NULL, 28),
(137, NULL, 'adasd', NULL, NULL, NULL, NULL, NULL, '02', 'adadasda', '', NULL, NULL, 28),
(138, NULL, 'asdada', NULL, NULL, NULL, NULL, NULL, '02', '1234567890', '', NULL, NULL, 28),
(139, '02', 'malas', '26', '11', '11', '01', '11111', '', '850217015777', '', '', '111', NULL),
(140, NULL, 'asdfghjhgfd', NULL, NULL, NULL, NULL, NULL, '02', '3214657898765', '', NULL, NULL, 28),
(141, NULL, 'adadadaaadadada', NULL, NULL, NULL, NULL, NULL, '02', '2133567865', '', NULL, NULL, 28),
(142, NULL, 'ghghghghhhhhhhhhh', NULL, NULL, NULL, NULL, NULL, '02', '676767', '', NULL, NULL, 28),
(143, NULL, 'amir', NULL, NULL, NULL, NULL, NULL, '02', '831224', '', NULL, NULL, 28),
(144, '65', 'norma', '', '', '', '', '', '01', '800909335438', '', '', '', NULL),
(145, NULL, 'roslan hamzah', NULL, NULL, NULL, NULL, NULL, '02', '871224', '', NULL, NULL, 28),
(146, NULL, 'Ghazali', NULL, NULL, NULL, NULL, NULL, '02', '998978789', '', NULL, NULL, 28),
(147, NULL, 'Tajuddin', NULL, NULL, NULL, NULL, NULL, '02', '7868999', '', NULL, NULL, 28),
(148, NULL, 'Hajar Asmad', NULL, NULL, NULL, NULL, NULL, '02', 'A567890', '', NULL, NULL, 28),
(149, NULL, 'Mohd Ali Napiah B Yusof', NULL, NULL, NULL, NULL, NULL, '02', '529622065271', '', NULL, NULL, 28),
(150, NULL, 'Robeah Bt Ismail', NULL, NULL, NULL, NULL, NULL, '02', '529622065272', '', NULL, NULL, 28),
(151, NULL, '', NULL, NULL, NULL, NULL, NULL, '02', '790909025661', '', NULL, NULL, 28),
(152, NULL, 'Amirul Azuan B Mohd Ali Napiah', NULL, NULL, NULL, NULL, NULL, '02', '801224145485', '', NULL, NULL, 28),
(153, NULL, 'Selamat Bin Burhan', NULL, NULL, NULL, NULL, NULL, '02', '801211106771', '', NULL, NULL, 28),
(154, NULL, 'sani', NULL, NULL, NULL, NULL, NULL, '02', '123456787898', '', NULL, NULL, 28),
(155, NULL, 'Rahim Bin Hamzah', NULL, NULL, NULL, NULL, NULL, '02', '720324106773', '', NULL, NULL, 28),
(156, NULL, 'sdsd', NULL, NULL, NULL, NULL, NULL, '02', '65666', '', NULL, NULL, 28),
(157, NULL, 'cgfg', NULL, NULL, NULL, NULL, NULL, '02', '67676', '', NULL, NULL, 28),
(158, NULL, 'gtttt', NULL, NULL, NULL, NULL, NULL, '02', '00099', '', NULL, NULL, 28),
(159, NULL, 'ddcadf', NULL, NULL, NULL, NULL, NULL, '02', '456666', '', NULL, NULL, 28),
(160, NULL, 'zjhdfhg', NULL, NULL, NULL, NULL, NULL, '02', '3462349', '', NULL, NULL, 28),
(161, NULL, 'sjdlfsj', NULL, NULL, NULL, NULL, NULL, '02', '270345927340', '', NULL, NULL, 28),
(162, '', 'umiey', '', '', '', '', '', '01', '860909335446', '', '', '', NULL),
(163, NULL, 'Mohd Amizan B Mohd Ali Napiah', NULL, NULL, NULL, NULL, NULL, '02', '900821065277', '', NULL, NULL, 28),
(164, '', '', '14', '09', '1978', '02', 'rus_mahmod@gmail.com', '01', '780914105152', '', '0192129292', '0388882929', NULL),
(165, '50', 'haris', '08', '09', '1985', '01', '', '01', '850908335437', '', '', '', NULL),
(166, '', 'gggggkkkkkkkk', '', '', '', '', '', '01', '56575', '', '', '', NULL),
(167, '18', '', '', '', '', '', '', '01', '678657', '', '', '', NULL),
(168, '02', 'syarafina', '09', '09', '1986', '02', 'aa@gmail.com', '01', '860909335226', '', '0124455124', '0312345678', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pro_pilihan_jawapan`
--

CREATE TABLE IF NOT EXISTS `pro_pilihan_jawapan` (
  `ID_PILIHAN_JAWAPAN` int(11) NOT NULL auto_increment,
  `ID_SOALAN` int(11) default NULL,
  `ID_PERINCIAN_SOALAN` int(11) default NULL,
  `KETERANGAN_JAWAPAN` text,
  `STATUS_JAWAPAN` varchar(20) default NULL,
  PRIMARY KEY  (`ID_PILIHAN_JAWAPAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=171 ;

--
-- Dumping data for table `pro_pilihan_jawapan`
--

INSERT INTO `pro_pilihan_jawapan` (`ID_PILIHAN_JAWAPAN`, `ID_SOALAN`, `ID_PERINCIAN_SOALAN`, `KETERANGAN_JAWAPAN`, `STATUS_JAWAPAN`) VALUES
(161, 80, NULL, 'dasdasdasdas', ''),
(100, 52, NULL, '1231', NULL),
(101, 52, NULL, '12313', NULL),
(102, 52, NULL, '31231', NULL),
(103, 52, NULL, '3123131', NULL),
(104, 53, NULL, 'q', NULL),
(105, 53, NULL, 'w', NULL),
(106, 53, NULL, 'e', NULL),
(107, 53, NULL, 'r', NULL),
(108, 54, NULL, 'test 1', NULL),
(109, 54, NULL, 'test 2', NULL),
(110, 54, NULL, 'test 1', NULL),
(111, 55, NULL, 'test 1', NULL),
(112, 55, NULL, 'test 2', NULL),
(113, 55, NULL, 'test 1', NULL),
(114, 56, NULL, 'asa', NULL),
(115, 56, NULL, 'asss', NULL),
(116, 56, NULL, 'asssss', NULL),
(117, 57, NULL, 'zzzzzzzzzzzz', NULL),
(118, 57, NULL, 'zzzzzzzzzzzzzzzzzzzz', NULL),
(119, 57, NULL, 'zzzzzzzzzzzzz', NULL),
(120, 58, NULL, 'ccc', NULL),
(121, 58, NULL, 'cccc', NULL),
(122, 58, NULL, 'cccc', NULL),
(123, 59, NULL, 'xxx', NULL),
(124, 59, NULL, 'xxxx', NULL),
(125, 59, NULL, 'xxxxxx', NULL),
(126, 60, NULL, 'adasdasdas', ''),
(127, 61, NULL, '1231231', NULL),
(128, 61, NULL, '123123123', NULL),
(129, 62, NULL, '2', NULL),
(130, 62, NULL, '3', NULL),
(131, 63, NULL, '1', ''),
(132, 64, NULL, '1', ''),
(133, 65, NULL, '1', NULL),
(134, 65, NULL, '2', NULL),
(135, 66, NULL, '1', NULL),
(136, 66, NULL, '2', NULL),
(137, 67, NULL, '1', NULL),
(138, 67, NULL, '2', NULL),
(139, 68, NULL, 'asdasdasda', NULL),
(140, 68, NULL, 'dsadasdadas', NULL),
(141, 69, NULL, 'asdasdasda', NULL),
(142, 69, NULL, 'dsadasdadas', NULL),
(143, 70, NULL, '12321312', NULL),
(144, 70, NULL, '312312313', NULL),
(145, 71, NULL, '12321312', NULL),
(146, 71, NULL, '312312313', NULL),
(147, 72, NULL, 'e', NULL),
(148, 72, NULL, 'r', NULL),
(149, 73, NULL, 'asdasd', NULL),
(150, 73, NULL, 'asdasda', NULL),
(151, 74, NULL, 'asd', NULL),
(152, 75, NULL, 'adadasdasd1232131', NULL),
(153, 75, NULL, '123123123asdasdadas', NULL),
(154, 76, NULL, 'adadasdasd1232131', NULL),
(155, 76, NULL, '123123123asdasdadas', NULL),
(156, 77, NULL, 'adadasdasd1232131', NULL),
(157, 77, NULL, '123123123asdasdadas', NULL),
(158, 78, NULL, 'asdasdas', NULL),
(159, 78, NULL, 'dasdsadas', NULL),
(160, 79, NULL, '1', ''),
(162, 81, NULL, 'dasdasdasdas', ''),
(163, 82, NULL, 'aya', NULL),
(164, 82, NULL, 'yaya', NULL),
(165, 83, NULL, 'aya', NULL),
(166, 83, NULL, 'yaya', NULL),
(167, 83, NULL, 'asdasdas', NULL),
(168, 84, NULL, 'dsadasdasdas', NULL),
(169, 85, NULL, 'dsadasdasdas', NULL),
(170, 86, NULL, '5', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pro_sesi`
--

CREATE TABLE IF NOT EXISTS `pro_sesi` (
  `ID_SESI` int(11) NOT NULL auto_increment,
  `KOD_SESI_PENILAIAN` varchar(20) default NULL,
  `TARIKH_SESI` date default NULL,
  `KOD_MASA_MULA` varchar(20) default NULL,
  `KOD_MASA_TAMAT` varchar(20) default NULL,
  `BILANGAN_PESERTA` int(11) default NULL,
  `KOD_KEMENTERIAN` varchar(20) default NULL,
  `LOKASI` varchar(100) default NULL,
  `KOD_IAC` varchar(20) default NULL,
  `KOD_STATUS` varchar(20) default NULL,
  `ID_PENGHANTARAN` varchar(20) default NULL,
  `KOD_JENIS_SESI` varchar(20) default NULL,
  `KOD_TAHAP` varchar(20) default NULL,
  `KOD_KATEGORI_PESERTA` varchar(20) default NULL,
  `KOD_STATUS_PENGESAHAN` varchar(20) NOT NULL,
  PRIMARY KEY  (`ID_SESI`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `pro_sesi`
--

INSERT INTO `pro_sesi` (`ID_SESI`, `KOD_SESI_PENILAIAN`, `TARIKH_SESI`, `KOD_MASA_MULA`, `KOD_MASA_TAMAT`, `BILANGAN_PESERTA`, `KOD_KEMENTERIAN`, `LOKASI`, `KOD_IAC`, `KOD_STATUS`, `ID_PENGHANTARAN`, `KOD_JENIS_SESI`, `KOD_TAHAP`, `KOD_KATEGORI_PESERTA`, `KOD_STATUS_PENGESAHAN`) VALUES
(16, '02', '2009-11-20', '01', '04', 11, NULL, NULL, '05', NULL, NULL, NULL, NULL, '01', '02'),
(12, '01', '2009-04-26', '01', '03', 20, NULL, NULL, '01', NULL, NULL, NULL, NULL, '02', '03'),
(13, '01', '2009-10-01', '01', '03', 19, NULL, NULL, '01', NULL, NULL, NULL, '01', '01', '02'),
(14, '03', '2009-11-11', '07', '08', 10, NULL, NULL, '03', NULL, NULL, NULL, NULL, '01', '01'),
(15, '01', '2009-12-20', '01', '04', 100, NULL, NULL, '03', NULL, NULL, NULL, NULL, '01', '03'),
(17, '01', '2009-12-20', '06', '07', 20, NULL, NULL, '02', NULL, NULL, NULL, NULL, '02', ''),
(18, '01', '2009-11-12', '07', '09', 20, '123', 'Putrajaya', '02', NULL, NULL, NULL, '01', '02', ''),
(19, '01', '2009-10-02', '14', '17', 10, NULL, NULL, '03', NULL, NULL, NULL, '01', NULL, ''),
(20, '', '2009-10-27', '11', '11', 30, NULL, NULL, '04', NULL, NULL, NULL, '01', NULL, ''),
(21, '01', '2009-10-27', '11', '11', 20, NULL, NULL, '06', NULL, NULL, NULL, '02', NULL, ''),
(22, '01', '2009-11-27', '05', '07', 20, '103', 'hospital sg. besi', '01', NULL, NULL, NULL, '01', '02', ''),
(23, '02', '2009-11-16', '05', '08', 30, NULL, NULL, '01', NULL, NULL, NULL, '01', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `pro_sesi_pemilihan_soalan`
--

CREATE TABLE IF NOT EXISTS `pro_sesi_pemilihan_soalan` (
  `ID_SESI_PEMILIHAN_SOALAN` int(11) NOT NULL auto_increment,
  `KOD_PENGGUNA` varchar(20) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `CATATAN_SESI_PEMILIHAN_SOALAN` varchar(20) default NULL,
  `ID_SESI` int(11) default NULL,
  `ID_PEMILIHAN_SOALAN` int(11) default NULL,
  PRIMARY KEY  (`ID_SESI_PEMILIHAN_SOALAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pro_sesi_pemilihan_soalan`
--


-- --------------------------------------------------------

--
-- Table structure for table `pro_sesi_peserta`
--

CREATE TABLE IF NOT EXISTS `pro_sesi_peserta` (
  `ID_SESI_PESERTA` int(11) NOT NULL,
  `ID_PESERTA` int(11) default NULL,
  `ID_SESI` int(11) default NULL,
  `ID_PENGHANTARAN` int(11) default NULL,
  PRIMARY KEY  (`ID_SESI_PESERTA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pro_sesi_peserta`
--


-- --------------------------------------------------------

--
-- Table structure for table `pro_soalan`
--

CREATE TABLE IF NOT EXISTS `pro_soalan` (
  `ID_SOALAN` int(11) NOT NULL auto_increment,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `TARIKH_KEMASKINI` varchar(20) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `NO_SOALAN` int(11) default NULL,
  `ARAHAN_SOALAN` text,
  `PENYATAAN_SOALAN` text,
  `NOTA_SOALAN` text,
  `KETERANGAN_SOALAN` text,
  `CATATAN_SOALAN` text,
  `KOD_STATUS` varchar(20) default NULL,
  `KOD_TAHAP_SOALAN` varchar(20) default NULL,
  `KOD_KATEGORI_SOALAN` varchar(20) default NULL,
  `KOD_FORMAT_SOALAN` varchar(20) default NULL,
  `TIP_SOALAN` text,
  `URL_SOALAN` varchar(50) default NULL,
  `NILAI_JAWAPAN_KESELURUHAN` varchar(20) default NULL,
  `KOD_SOALAN` varchar(20) default NULL,
  PRIMARY KEY  (`ID_SOALAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `pro_soalan`
--

INSERT INTO `pro_soalan` (`ID_SOALAN`, `TARIKH_CIPTA`, `TARIKH_KEMASKINI`, `ID_PENGGUNA`, `NO_SOALAN`, `ARAHAN_SOALAN`, `PENYATAAN_SOALAN`, `NOTA_SOALAN`, `KETERANGAN_SOALAN`, `CATATAN_SOALAN`, `KOD_STATUS`, `KOD_TAHAP_SOALAN`, `KOD_KATEGORI_SOALAN`, `KOD_FORMAT_SOALAN`, `TIP_SOALAN`, `URL_SOALAN`, `NILAI_JAWAPAN_KESELURUHAN`, `KOD_SOALAN`) VALUES
(1, NULL, NULL, NULL, 1, NULL, 'Perisian ialah ........ ', NULL, NULL, NULL, NULL, '01', '01', NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, 2, NULL, 'Antara yang berikut, manakah bahagian yang diibaratkan otak komputer. ', NULL, NULL, NULL, NULL, '01', '01', NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, 3, NULL, 'Tetikus adalah salah satu contoh peranti ______________. ', NULL, NULL, NULL, NULL, '01', '01', NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, 4, NULL, 'Komponen-komponen sokongan sistem komputer seperti ________________. ', NULL, NULL, NULL, NULL, '01', '02', NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, 5, NULL, 'Antara yang berikut manakah contoh perisian aplikasi. ', NULL, NULL, NULL, NULL, '01', '02', NULL, NULL, NULL, NULL, NULL),
(6, NULL, NULL, NULL, 6, NULL, 'Antara berikut, yang manakah PALSU ', NULL, NULL, NULL, NULL, '01', '02', NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, 7, NULL, 'Sistem rangkaian ialah ________________. ', NULL, NULL, NULL, NULL, '01', '03', NULL, NULL, NULL, NULL, NULL),
(8, NULL, NULL, NULL, 8, NULL, 'Setiap komputer atau peranti di dalam rangkaian dinamakan node.Bentuk susunan node atau cara node disambungkan untuk membentuk rangkaian dikenali sebagai topologi rangkaian.Pilih topologi rangkaian yang BETUL dibawah: ', NULL, NULL, NULL, NULL, '01', '03', NULL, NULL, NULL, NULL, NULL),
(9, NULL, NULL, NULL, 9, NULL, 'Perkakasan sistem rangkaian adalah terdiri daripada komponen-komponen fizikal yang membentuk satu sistem rangkaian.Semua sistem rangkaian memerlukan perkakasan-perkakasan sistem yang khusus.Di antara contoh di bawah pilih jawapan yang SALAH: ', NULL, NULL, NULL, NULL, '01', '03', NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, 10, NULL, 'Perisian sistem rangkaian terdiri daripada aturcara-aturcara yang dilancarkan oleh komputer-komputer yang dihubungkan kepada satu sistem rangkaian.Di antara contoh di bawah pilih jawapan yang BETUL : ', NULL, NULL, NULL, NULL, '01', '03', NULL, NULL, NULL, NULL, NULL),
(49, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	asdasdasdasdas</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(50, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	asdasdasdasdas</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(51, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	asdasdasdasdas</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(52, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	1231</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(53, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	adsadasdasd</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'Office Productivity ', NULL, NULL, NULL, NULL, NULL),
(54, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	test 1</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'Internet', NULL, NULL, NULL, NULL, NULL),
(55, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	test 1</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'Internet', NULL, NULL, NULL, NULL, NULL),
(56, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	test 2</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'Internet', NULL, NULL, NULL, NULL, NULL),
(57, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	zzzzzzzzzzzzzz</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'Electronic Mail', NULL, NULL, NULL, NULL, NULL),
(58, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	ccc</p>\r\n', NULL, NULL, NULL, NULL, 'Advanced', 'MSC', NULL, NULL, NULL, NULL, NULL),
(59, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	xxxx</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'Hardware', NULL, NULL, NULL, NULL, NULL),
(65, '2009-10-23', NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	qwe</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(60, NULL, NULL, NULL, NULL, 'Sila pilih satu jawapan sahaja. (Please choose only one answer)', '<p>\r\n	dasdadasdass</p>\r\n', NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL),
(61, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	12312313</p>\r\n', NULL, NULL, NULL, NULL, 'Advanced', 'ICT Security', NULL, NULL, NULL, NULL, NULL),
(62, NULL, NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	1</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(63, NULL, NULL, NULL, NULL, 'Sila pilih jawapan samada betul atau salah. (Please choose either true or false)', '', NULL, NULL, NULL, NULL, 'Advanced', 'EG', NULL, NULL, NULL, NULL, NULL),
(64, NULL, NULL, NULL, NULL, 'Sila pilih jawapan samada betul atau salah. (Please choose either true or false)', '', NULL, NULL, NULL, NULL, 'Basic', 'Electronic Mail', NULL, NULL, NULL, NULL, NULL),
(66, '2009-10-23', NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	qwe</p>\r\n', NULL, NULL, NULL, NULL, 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(67, '2009-10-23', NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	qwe</p>\r\n', NULL, NULL, NULL, 'Baru', 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(68, '2009-10-23', NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	asdadasdasdas</p>\r\n', NULL, NULL, NULL, 'Baru', 'Advanced', 'MSC', NULL, NULL, NULL, NULL, NULL),
(69, '2009-10-23', NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	asdadasdasdas</p>\r\n', NULL, NULL, NULL, '', 'Advanced', 'MSC', NULL, NULL, NULL, NULL, NULL),
(70, '2009-10-23', NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	asdasdsad12312312312</p>\r\n', NULL, NULL, NULL, '', 'Basic', 'Internet', NULL, NULL, NULL, NULL, NULL),
(71, '2009-10-23', NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	asdasdsad12312312312</p>\r\n', NULL, NULL, NULL, '', 'Basic', 'Internet', NULL, NULL, NULL, NULL, NULL),
(72, '2009-10-23', NULL, NULL, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	e</p>\r\n', NULL, NULL, NULL, 'Baru', 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(73, '2009-10-23', NULL, 0, NULL, 'Sila isi tempat kosong dengan ajawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	asdasdasd</p>\r\n', NULL, NULL, NULL, 'Baru', 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(74, '2009-10-23', NULL, 0, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	sadasdasda</p>\r\n', NULL, NULL, NULL, 'Baru', 'Basic', 'Electronic Mail', NULL, NULL, NULL, NULL, NULL),
(75, '2009-10-23', NULL, 1, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	adasdasdas213123123123</p>\r\n', NULL, NULL, NULL, 'Baru', 'Advanced', 'EG', NULL, NULL, NULL, NULL, NULL),
(76, '2009-10-23', NULL, 1, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	adasdasdas213123123123</p>\r\n', NULL, NULL, NULL, 'Baru', 'Advanced', 'EG', NULL, NULL, NULL, NULL, NULL),
(77, '2009-10-23', NULL, 1, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	adasdasdas213123123123</p>\r\n', NULL, NULL, NULL, 'Baru', 'Advanced', 'EG', NULL, NULL, NULL, NULL, NULL),
(78, '2009-10-24', NULL, 1, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	asdasdasd</p>\r\n', NULL, NULL, NULL, 'Baru', 'Advanced', 'Electronic Mail', NULL, NULL, NULL, NULL, NULL),
(79, '2009-10-25', NULL, 1, NULL, 'Sila pilih jawapan samada betul atau salah. (Please choose either true or false)', '', NULL, NULL, NULL, 'Baru', 'Basic', 'Electronic Mail', NULL, NULL, NULL, NULL, NULL),
(80, '2009-10-25', NULL, 1, NULL, 'Sila pilih satu jawapan sahaja. (Please choose only one answer)', '<p>\r\n	dasdasdasdasda</p>\r\n', NULL, NULL, NULL, 'Baru', '', '', NULL, NULL, NULL, NULL, NULL),
(81, '2009-10-25', NULL, 1, NULL, 'Sila pilih satu jawapan sahaja. (Please choose only one answer)', '<p>\r\n	dasdasdasdasda</p>\r\n', NULL, NULL, NULL, 'Baru', '', '', NULL, NULL, NULL, NULL, NULL),
(82, '2009-10-25', NULL, 1, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	saya</p>\r\n', NULL, NULL, NULL, 'Baru', 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(83, '2009-10-25', NULL, 1, NULL, 'Sila isi tempat kosong dengan jawapan yang sesuai. (Please fill in the blank with appropriate answer)', '<p>\r\n	saya</p>\r\n', NULL, NULL, NULL, 'Baru', 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL),
(84, '2009-10-29', NULL, 1, NULL, '', '<p>\r\n	asdasdsadasds</p>\r\n', NULL, NULL, NULL, 'Baru', 'Advanced', 'EG', NULL, NULL, NULL, NULL, NULL),
(85, '2009-10-29', NULL, 1, NULL, '', '<p>\r\n	asdasdsadasds</p>\r\n', NULL, NULL, NULL, 'Baru', 'Advanced', 'EG', NULL, NULL, NULL, NULL, NULL),
(86, '2009-10-29', NULL, 1, NULL, '3', '<p>\r\n	4</p>\r\n', NULL, NULL, NULL, 'Baru', 'Basic', 'EG', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pro_soalan_perician`
--

CREATE TABLE IF NOT EXISTS `pro_soalan_perician` (
  `ID_SOALAN_PERINCIAN` int(11) NOT NULL auto_increment,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `ID_SOALAN` int(11) default NULL,
  `TIP_SOALAN_PERINCIAN` text,
  `CATATAN_SOALAN_PERINCIAN` text,
  `PENYATAAN_SOALAN_PERINCIAN` text,
  `URL_SOALAN_PERINCIAN` varchar(50) default NULL,
  `KETERANGAN_SOALAN_PERINCIAN` text,
  `NOTA_SOALAN_PERINCIAN` text,
  `KOD_SAMBUNG_KETERANGAN` varchar(20) default NULL,
  PRIMARY KEY  (`ID_SOALAN_PERINCIAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `pro_soalan_perician`
--

INSERT INTO `pro_soalan_perician` (`ID_SOALAN_PERINCIAN`, `TARIKH_CIPTA`, `ID_PENGGUNA`, `ID_SOALAN`, `TIP_SOALAN_PERINCIAN`, `CATATAN_SOALAN_PERINCIAN`, `PENYATAAN_SOALAN_PERINCIAN`, `URL_SOALAN_PERINCIAN`, `KETERANGAN_SOALAN_PERINCIAN`, `NOTA_SOALAN_PERINCIAN`, `KOD_SAMBUNG_KETERANGAN`) VALUES
(1, NULL, NULL, 1, NULL, NULL, 'set arahan langkah demi langkah.', NULL, NULL, NULL, NULL),
(2, NULL, NULL, 1, NULL, NULL, 'set arahan yang mengarahkan komputer tentang apa yang perlu dilakukannya. ', NULL, NULL, NULL, NULL),
(3, NULL, NULL, 1, NULL, NULL, 'sekumpulan aturcara yang direkabentuk untuk melaksanakan tugas-tugas yang\r\n\r\nberkaitan. ', NULL, NULL, NULL, NULL),
(4, NULL, NULL, 1, NULL, NULL, 'aturcara yang dihasilkan bagi menyelesaikan sesuatu masalah dan tugas\r\n\r\npengguna. ', NULL, NULL, NULL, NULL),
(5, NULL, NULL, 2, NULL, NULL, 'Storan sekunder ', NULL, NULL, NULL, NULL),
(6, NULL, NULL, 2, NULL, NULL, 'ROM ', NULL, NULL, NULL, NULL),
(7, NULL, NULL, 2, NULL, NULL, 'Unit Pemprosesan Pusat ', NULL, NULL, NULL, NULL),
(8, NULL, NULL, 2, NULL, NULL, 'RAM ', NULL, NULL, NULL, NULL),
(9, NULL, NULL, 3, NULL, NULL, 'Input ', NULL, NULL, NULL, NULL),
(10, NULL, NULL, 3, NULL, NULL, 'Pengguna  ', NULL, NULL, NULL, NULL),
(11, NULL, NULL, 3, NULL, NULL, 'Output ', NULL, NULL, NULL, NULL),
(12, NULL, NULL, 3, NULL, NULL, 'Komputer super', NULL, NULL, NULL, NULL),
(13, NULL, NULL, 4, NULL, NULL, 'ROM ', NULL, NULL, NULL, NULL),
(14, NULL, NULL, 4, NULL, NULL, 'RAM ', NULL, NULL, NULL, NULL),
(15, NULL, NULL, 4, NULL, NULL, 'Modem ', NULL, NULL, NULL, NULL),
(16, NULL, NULL, 5, NULL, NULL, 'Microsoft Word ', NULL, NULL, NULL, NULL),
(17, NULL, NULL, 5, NULL, NULL, 'DOS', NULL, NULL, NULL, NULL),
(18, NULL, NULL, 5, NULL, NULL, 'UNIX', NULL, NULL, NULL, NULL),
(19, NULL, NULL, 5, NULL, NULL, 'Windows', NULL, NULL, NULL, NULL),
(20, NULL, NULL, 6, NULL, NULL, '1 bit bersamaan 8 bait ', NULL, NULL, NULL, NULL),
(21, NULL, NULL, 6, NULL, NULL, '1 bait bersamaan 8 bit ', NULL, NULL, NULL, NULL),
(22, NULL, NULL, 6, NULL, NULL, 'Bit merupakan unit terkecil data ', NULL, NULL, NULL, NULL),
(23, NULL, NULL, 6, NULL, NULL, '0 mewakili off', NULL, NULL, NULL, NULL),
(24, NULL, NULL, 7, NULL, NULL, 'Komputer yang berkongsi perkakasan ', NULL, NULL, NULL, NULL),
(25, NULL, NULL, 7, NULL, NULL, 'Sistem komputer yang berkongsi data di antara satu sama lain. ', NULL, NULL, NULL, NULL),
(26, NULL, NULL, 7, NULL, NULL, 'Sekumpulan komputer yang dihubungkan bagi membolehkan maklumat dan perkakasan lain dikongsi bersama. ', NULL, NULL, NULL, NULL),
(27, NULL, NULL, 7, NULL, NULL, 'Sistem komputer yang menggunakan perkakasan komunikasi ', NULL, NULL, NULL, NULL),
(28, NULL, NULL, 8, NULL, NULL, 'Bintang ', NULL, NULL, NULL, NULL),
(29, NULL, NULL, 8, NULL, NULL, 'Bulatan', NULL, NULL, NULL, NULL),
(30, NULL, NULL, 8, NULL, NULL, 'Segi tiga ', NULL, NULL, NULL, NULL),
(31, NULL, NULL, 1008, NULL, NULL, 'Bulan', NULL, NULL, NULL, NULL),
(32, NULL, NULL, 1009, NULL, NULL, 'Komputer', NULL, NULL, NULL, NULL),
(33, NULL, NULL, 1009, NULL, NULL, 'Kabel', NULL, NULL, NULL, NULL),
(34, NULL, NULL, 1009, NULL, NULL, 'Penyambung', NULL, NULL, NULL, NULL),
(35, NULL, NULL, 1009, NULL, NULL, 'Network Operating System (NOS) ', NULL, NULL, NULL, NULL),
(36, NULL, NULL, 10010, NULL, NULL, 'Network Driver ', NULL, NULL, NULL, NULL),
(37, NULL, NULL, 10010, NULL, NULL, 'Peranti', NULL, NULL, NULL, NULL),
(38, NULL, NULL, 10010, NULL, NULL, 'Network Interface Cards(NIC) ', NULL, NULL, NULL, NULL),
(39, NULL, NULL, 10010, NULL, NULL, 'Penyambung ', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pro_soalan_perincian_tajuk`
--

CREATE TABLE IF NOT EXISTS `pro_soalan_perincian_tajuk` (
  `ID_SOALAN_PERINCIAN_TAJUK` int(11) NOT NULL auto_increment,
  `NO_SOALAN_PERINCIAN_TAJUK` varchar(20) default NULL,
  `PENYATAAN_SOALAN_PERINCIAN_TAJUK` text,
  `ID_SOALAN_PERINCIAN` int(11) default NULL,
  PRIMARY KEY  (`ID_SOALAN_PERINCIAN_TAJUK`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pro_soalan_perincian_tajuk`
--


-- --------------------------------------------------------

--
-- Table structure for table `pro_tempat_tugas`
--

CREATE TABLE IF NOT EXISTS `pro_tempat_tugas` (
  `ID_TEMPAT_TUGAS` int(11) NOT NULL auto_increment,
  `ID_PESERTA` int(11) default NULL,
  `ID_PENYELARAS` int(11) default NULL,
  `GELARAN_KETUA_JABATAN` varchar(20) default NULL,
  `KOD_KEMENTERIAN` varchar(20) default NULL,
  `KOD_JABATAN` varchar(20) default NULL,
  `BAHAGIAN` varchar(100) default NULL,
  `ALAMAT_1` varchar(100) default NULL,
  `ALAMAT_2` varchar(100) default NULL,
  `ALAMAT_3` varchar(100) default NULL,
  `POSKOD` varchar(5) default NULL,
  `BANDAR` varchar(100) default NULL,
  `KOD_NEGERI` varchar(20) default NULL,
  `KOD_NEGARA` varchar(20) default NULL,
  `NAMA_PENYELIA` varchar(100) default NULL,
  `EMEL_PENYELIA` varchar(50) default NULL,
  `NO_TELEFON_PENYELIA` varchar(20) default NULL,
  `NO_FAX_PENYELIA` varchar(20) default NULL,
  PRIMARY KEY  (`ID_TEMPAT_TUGAS`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=138 ;

--
-- Dumping data for table `pro_tempat_tugas`
--

INSERT INTO `pro_tempat_tugas` (`ID_TEMPAT_TUGAS`, `ID_PESERTA`, `ID_PENYELARAS`, `GELARAN_KETUA_JABATAN`, `KOD_KEMENTERIAN`, `KOD_JABATAN`, `BAHAGIAN`, `ALAMAT_1`, `ALAMAT_2`, `ALAMAT_3`, `POSKOD`, `BANDAR`, `KOD_NEGERI`, `KOD_NEGARA`, `NAMA_PENYELIA`, `EMEL_PENYELIA`, `NO_TELEFON_PENYELIA`, `NO_FAX_PENYELIA`) VALUES
(59, NULL, NULL, NULL, NULL, 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', NULL, NULL, NULL, NULL),
(60, NULL, NULL, NULL, NULL, 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', NULL, NULL, NULL, NULL),
(61, NULL, NULL, NULL, NULL, 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', NULL, NULL, NULL, NULL),
(62, 85, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(63, 86, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(48, 71, NULL, 'ketua jabatan', '140', '103014', 'akaun', 'no.7, tingkat 3,', 'jln melati', 'kl', '52332', 'puchong', '14', 'MYS', 'en.ridhuan abu', 'rid@gmail.com', '0323456755', '0323456744'),
(49, 72, NULL, 'ggggggggg', '482', '135012', 'akaun', 'aa', 'eryeryu', 'eryery', '12222', 'asds', '16', 'MYS', 'ahmad', 'aaa@gmail.com', '0323456789', '0323456744'),
(21, 44, NULL, 'ketua jabatan', '103', '132004', 'akaun', 'no.9, tingkat 9,', 'jalan kasawari,', 'kl', '45454', 'cheras', '14', 'MYS', 'en.mahad ali', 'mahad@gmail.com', '0323456789', '2326457637'),
(64, 87, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(65, NULL, NULL, NULL, NULL, 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', NULL, NULL, NULL, NULL),
(66, NULL, NULL, NULL, NULL, 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', NULL, NULL, NULL, NULL),
(27, 50, NULL, 'ketua jabatan', '370', '117007', 'akaun', 'no.9, tingkat 9,', 'eryeryu', 'eryery', '12222', 'cheras', '14', 'MYS', 'ahmad', 'aaa@gmail.com', '0323456789', '20'),
(67, NULL, NULL, NULL, NULL, 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', NULL, NULL, NULL, NULL),
(68, NULL, NULL, NULL, NULL, 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', NULL, NULL, NULL, NULL),
(69, NULL, NULL, NULL, NULL, 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', NULL, NULL, NULL, NULL),
(70, 93, NULL, 'aaaa', '481', '131103', 'aaaa', 'aaaa', '', '', '', '', '', 'MYS', '', '', '', ''),
(71, NULL, NULL, NULL, NULL, 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', 'Array', NULL, NULL, NULL, NULL),
(72, 94, NULL, 'na', '121', '132004', 'na', 'no.7, tingkat 7,', 'jln melor', 'kl', '54666', 'puchong', '14', 'MYS', 'amy', 'amy@gmail.com', '0323456789', '0323456744'),
(73, 96, NULL, 'ketua bahagian ', '361', '117007', 'akaun', 'no.7, tingkat 23,', 'jalan wangsa,', 'kl', '12222', 'cheras', '14', 'MYS', 'en.ali', 'aaa@gmail.com', '0323456755', '0323456788'),
(55, 78, NULL, 'jj kkkk', '482', '201213', 'jj', 'tyj', 'tyjyt', 'tyjutyjty', '12222', 'yuy', '99', 'MWI', 'jj', 'jj', 'jj', 'jjj'),
(74, 98, NULL, 'zzzzzzz', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(75, 100, NULL, 'aa', '103', '136006', 'akaun', 'no.7, tingkat 23,', 'jalan wangsa,', 'kl', '12222', 'puchong', '14', 'MYS', 'ahmad', 'aaa@gmail.com', '0323456789', '0323456744'),
(76, 102, NULL, '', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(77, 104, NULL, 'ggggggggg', '123', '135012', 'akaun', 'no.7, tingkat 7,', 'eryeryu', 'fbgh', '12222', 'cheras', '02', 'MYS', 'ahmad', 'aaa@gmail.com', '0323456755', '0323456744'),
(78, 78, NULL, 'jjdfghfh', '482', '201213', 'jj', 'tyj', 'tyjyt', 'tyjutyjty', '12222', 'yuy', '99', 'MYS', 'jj', 'jj', 'jj', 'jjj'),
(129, NULL, 28, NULL, NULL, '133006', 'BTMK', 'Bangunan 3, Blok Barat', 'Parcel E', 'Tingkat 4, Putrajaya', '62000', 'Putrajaya', '16', 'MYS', NULL, NULL, NULL, NULL),
(128, 132, NULL, 'yyyyyyyyyyyy', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(81, 109, NULL, 'ggggggggg', '361', '131103', 'akaun', 'no.12, tingkat 7,', 'eryeryu', 'bandar tasik', '45454', 'cheras', '11', 'MYS', 'ahmad', 'aaa@gmail.com', '0323456755', '0323456744'),
(100, NULL, 6, NULL, NULL, '137102', 'btmk', 'aaa', 'bangunan hitam', 'cccc', '62000', 'putrajaya', '11', 'MYS', NULL, NULL, NULL, NULL),
(101, 114, NULL, 'sssssss', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(102, 115, NULL, 'hhhh', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(103, 116, NULL, 'mmmmmm', '482', '136006', 'aaa', 'no.12, tingkat 7,', 'eryeryu', 'bandar tasik', '45454', 'puchong', '10', 'MYS', 'dfgdf', 'amy@gmail.com', '0323456789', '0323456788'),
(104, NULL, 6, NULL, NULL, '', '', '', '', '', '', '', '', 'MYS', NULL, NULL, NULL, NULL),
(105, NULL, 6, NULL, NULL, '', '', '', '', '', '', '', '', 'MYS', NULL, NULL, NULL, NULL),
(106, NULL, 6, NULL, NULL, '', '', '', '', '', '', '', '', 'MYS', NULL, NULL, NULL, NULL),
(107, 117, NULL, 'yyyyyyyyyyyyyy', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(108, NULL, 6, NULL, NULL, '', '', '', '', '', '', '', '', 'MYS', NULL, NULL, NULL, NULL),
(109, NULL, 6, NULL, NULL, '', '', '', '', '', '', '', '', 'MYS', NULL, NULL, NULL, NULL),
(110, 118, NULL, 'Ketua', '135', '103006', 'Tajaan Biasiswa', 'Aras 5&6, Blok E14', 'Kompleks Kerajaan Parcel E', 'Pusat Pentadbiran Kerajaan Persekutuan', '62604', 'Putrajaya', '10', 'MYS', 'Noradibah binti ahmad', 'adibah@gmail.com', '0192299001', '039990009'),
(111, NULL, 6, NULL, NULL, '', '', '', '', '', '', '', '', 'MYS', NULL, NULL, NULL, NULL),
(112, NULL, 6, NULL, NULL, '123020', 'aaa', 'blok e11', 'kompleks e', 'parcel e', '62000', 'putrajaya', '16', 'MYS', NULL, NULL, NULL, NULL),
(113, NULL, 6, NULL, NULL, '131103', 'aaa', 'blok e11', 'kompleks e', 'cccc', '62000', 'putrajaya', '16', 'MYS', NULL, NULL, NULL, NULL),
(114, NULL, 6, NULL, NULL, '139402', 'audit', 'tingkat 3', 'vvv', 'jalan tar', '12345', 'hjkn', '15', 'MYS', NULL, NULL, NULL, NULL),
(115, 120, NULL, 'uiuiu', '137', '135012', 'jj', 'ui', 'iui', 'uiu', '78788', 'cheras', '12', 'MYS', 'uuu', 'aaa@gmail.com', '0323456755', '0323456744'),
(116, 120, NULL, 'Ketua', '136', '130006', 'Perkhidmatan', 'Aras 2, Blok C8', 'Kompleks Parcel C', 'Pusat Kerajaan Persekutuan', '62604', 'Putrajaya', '10', 'MYS', 'mohd hafiz bin mohamad shah', 'apeez@gmail.com', '0173329107', '0399991234'),
(127, NULL, 27, NULL, NULL, '135014', 'Pengarah', 'no23', 'jalan 14', 'putrajaya', '123', 'WP', '16', 'MYS', NULL, NULL, NULL, NULL),
(119, 122, NULL, 'Ketua', '112', '130006', 'Komunikasi', 'Aras 1, Blok E9', 'Kompleks Kerajaan Parcel E', 'Pusat Pentadbiran Kerajaan Persekutuan', '62604', 'Putrajaya', '10', 'MYS', 'Rohani Binti saadom', 'ani_saad@yahoo.com', '0377119900', '0377771111'),
(130, 139, NULL, '11111', '361', '139108', '1111', '111', '11', '11', '111', '11', '14', 'MYS', '111', '11', '11', '11'),
(122, 123, NULL, 'Ketua ', '103', '136009', 'Tajaan ', 'Aras 2&3, Blok E1', 'Kompleks Kerajaan Parcel E', 'Pusat Pentadbiran Kerajaan Persekutuan', '62604', 'Putrajaya', '10', 'MYS', 'Noor adilah binti zakaria', 'dilah@gmail.com', '0322211101', '0322220909'),
(123, 124, NULL, 'Ketua', '137', '137102', 'Pentadbiran', 'Level 3, Blok 3', 'Jalan Kasawari Medan', 'Pusat Pentadbiran Selayang', '64500', 'Selayang', '10', 'MYS', 'Mohamad bin faizal', 'moh@gmail.com', '0322445566', '0322226767'),
(124, 125, NULL, 'Ketua Pengarah', '123', '123016', 'Kanser ', 'Aras 3, Blok Sutera', 'Jalan 23 Sutera Ali', 'Seri Bandar Putra', '41200', 'Ayer Keroh', '04', 'MYS', 'siti shahidah binti ramli', 'ct@yahoo.com', '0322220099', '0329292929'),
(131, 144, NULL, 'ketua bahagian ', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(132, 162, NULL, 'ketua', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(133, 164, NULL, 'Pengarah', '141', '141008', '', '', '', '', '', '', '16', 'MYS', '', '', '', ''),
(134, 165, NULL, 'ketua bahagian ', '121', '132004', 'akaun', 'no.7, tingkat 3,', 'jalan kasawari2,', 'bandar tasik', '12222', 'cheras', '14', 'MYS', 'amy', 'amy@gmail.com', '0323456755', '0323456788'),
(135, 166, NULL, 'kkkkkkk', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(136, 167, NULL, '567u6', '', '', '', '', '', '', '', '', '', 'MYS', '', '', '', ''),
(137, 168, NULL, 'ketua jabatan', '123', '133006', 'akaun', 'no.23, tingkat 7,', 'wisma persekutuan,', 'bandar tasik', '12333', 'cheras', '14', 'MYS', 'marlia majid', 'marlia@gmail.com', '0324545454', '0324545455');

-- --------------------------------------------------------

--
-- Table structure for table `prs_penilaian`
--

CREATE TABLE IF NOT EXISTS `prs_penilaian` (
  `ID_PENILAIAN` int(11) NOT NULL auto_increment,
  `TARIKH_PENILAIAN` varchar(20) default NULL,
  `CATATAN_PENILAIAN` text,
  `MASA_MULA_PENILAIAN` varchar(20) default NULL,
  `MASA_TAMAT_PENILAIAN` varchar(20) default NULL,
  `ID_SESI` int(11) default NULL,
  PRIMARY KEY  (`ID_PENILAIAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `prs_penilaian`
--

INSERT INTO `prs_penilaian` (`ID_PENILAIAN`, `TARIKH_PENILAIAN`, `CATATAN_PENILAIAN`, `MASA_MULA_PENILAIAN`, `MASA_TAMAT_PENILAIAN`, `ID_SESI`) VALUES
(1, '2009-08-20', NULL, NULL, NULL, 13),
(2, '2009-10-26', NULL, NULL, NULL, 12),
(3, '2009-10-26', NULL, NULL, NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `prs_penilaian_pengawas`
--

CREATE TABLE IF NOT EXISTS `prs_penilaian_pengawas` (
  `ID_PENILAIAN_PENGAWAS` int(11) NOT NULL auto_increment,
  `ID_PENILAIAN` int(11) default NULL,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `KOD_JENIS_PENGAWAS` varchar(20) default NULL,
  `ID_PENGAWAS` int(11) default NULL,
  PRIMARY KEY  (`ID_PENILAIAN_PENGAWAS`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `prs_penilaian_pengawas`
--


-- --------------------------------------------------------

--
-- Table structure for table `prs_penilaian_peserta`
--

CREATE TABLE IF NOT EXISTS `prs_penilaian_peserta` (
  `ID_PENILAIAN_PESERTA` int(11) NOT NULL auto_increment,
  `KOD_STATUS_KEHADIRAN` varchar(20) default NULL,
  `KOD_PENGESAHAN_PESERTA` varchar(20) default NULL,
  `KOD_PENGESAHAN_PEPERIKSAAN` varchar(20) default NULL,
  `KOD_STATUS_KELULUSAN` varchar(20) default NULL,
  `KOD_CETAK_SLIP` varchar(20) default NULL,
  `TARIKH_CETAK_SLIP` varchar(20) default NULL,
  `KOD_CETAK_SIJIL` varchar(20) default NULL,
  `TARIKH_CETAK_SIJIL` varchar(20) default NULL,
  `SIJIL_DICETAK_OLEH` varchar(100) default NULL,
  `SLIP_DICETAK_OLEH` varchar(100) default NULL,
  `KOD_STATUS_MUATNAIK` varchar(20) default NULL,
  `TARIKH_MUATNAIK` varchar(20) default NULL,
  `MUATNAIK_OLEH` varchar(20) default NULL,
  `KATALALUAN_PESERTA` varchar(20) default NULL,
  `NO_SIJIL_PESERTA` varchar(20) default NULL,
  `ID_PENILAIAN` int(11) default NULL,
  `ID_PESERTA` int(11) default NULL,
  PRIMARY KEY  (`ID_PENILAIAN_PESERTA`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `prs_penilaian_peserta`
--

INSERT INTO `prs_penilaian_peserta` (`ID_PENILAIAN_PESERTA`, `KOD_STATUS_KEHADIRAN`, `KOD_PENGESAHAN_PESERTA`, `KOD_PENGESAHAN_PEPERIKSAAN`, `KOD_STATUS_KELULUSAN`, `KOD_CETAK_SLIP`, `TARIKH_CETAK_SLIP`, `KOD_CETAK_SIJIL`, `TARIKH_CETAK_SIJIL`, `SIJIL_DICETAK_OLEH`, `SLIP_DICETAK_OLEH`, `KOD_STATUS_MUATNAIK`, `TARIKH_MUATNAIK`, `MUATNAIK_OLEH`, `KATALALUAN_PESERTA`, `NO_SIJIL_PESERTA`, `ID_PENILAIAN`, `ID_PESERTA`) VALUES
(1, '02', NULL, NULL, 'gagal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 50),
(2, '01', NULL, NULL, 'lulus', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 44),
(3, '01', NULL, NULL, 'gagal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 71);

-- --------------------------------------------------------

--
-- Table structure for table `prs_penilaian_peserta_jawapan`
--

CREATE TABLE IF NOT EXISTS `prs_penilaian_peserta_jawapan` (
  `ID_PENIALIAN_PESERTA_JAWAPAN` int(11) NOT NULL auto_increment,
  `ID_SOALAN` int(11) default NULL,
  `ID_SOALAN_PERINCIAN` int(11) default NULL,
  `ID_JAWAPAN` int(11) default NULL,
  `KETERANGAN_JAWAPAN` text,
  `MARKAH` varchar(20) default NULL,
  `MASA_MULA` varchar(20) default NULL,
  `MASA_TAMAT` varchar(20) default NULL,
  PRIMARY KEY  (`ID_PENIALIAN_PESERTA_JAWAPAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `prs_penilaian_peserta_jawapan`
--


-- --------------------------------------------------------

--
-- Table structure for table `prs_permohonan`
--

CREATE TABLE IF NOT EXISTS `prs_permohonan` (
  `ID_PERMOHONAN` int(11) NOT NULL auto_increment,
  `TARIKH_PERMOHONAN` date default NULL,
  `ID_AGENSI` int(11) default NULL,
  `KOD_TUJUAN` varchar(20) default NULL,
  `ID_PENYELARAS` int(11) default NULL,
  `ID_PESERTA` int(11) default NULL,
  `KOD_STATUS_PERMOHONAN` varchar(20) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `TARIKH_TAWARAN` date default NULL,
  `ID_SESI` int(11) default NULL,
  `KOD_TAHAP` varchar(20) default NULL,
  `SEBAB_BATAL` varchar(100) default NULL,
  `TARIKH_BATAL_PERMOHONAN` date default NULL,
  PRIMARY KEY  (`ID_PERMOHONAN`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=191 ;

--
-- Dumping data for table `prs_permohonan`
--

INSERT INTO `prs_permohonan` (`ID_PERMOHONAN`, `TARIKH_PERMOHONAN`, `ID_AGENSI`, `KOD_TUJUAN`, `ID_PENYELARAS`, `ID_PESERTA`, `KOD_STATUS_PERMOHONAN`, `ID_PENGGUNA`, `TARIKH_TAWARAN`, `ID_SESI`, `KOD_TAHAP`, `SEBAB_BATAL`, `TARIKH_BATAL_PERMOHONAN`) VALUES
(53, '2009-10-15', NULL, '', NULL, 86, NULL, NULL, NULL, 13, '', NULL, NULL),
(54, '2009-10-25', NULL, '', NULL, 87, NULL, NULL, NULL, 15, '', NULL, NULL),
(171, '2009-10-29', NULL, '02', NULL, 120, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(163, '2009-10-29', NULL, '01', NULL, 116, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(159, '2009-10-27', NULL, '01', NULL, 109, NULL, NULL, NULL, 16, '02', '', '0000-00-00'),
(30, '2009-10-21', NULL, '02', NULL, 50, ' ', NULL, NULL, 16, '02', '', '0000-00-00'),
(43, '2009-10-15', NULL, '', NULL, 71, NULL, NULL, NULL, 13, '01', NULL, NULL),
(44, '2009-10-29', NULL, '01', NULL, 44, NULL, NULL, NULL, 14, '01', '', '0000-00-00'),
(160, '2009-10-28', NULL, '01', NULL, 114, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(165, '2009-10-29', NULL, '02', NULL, 120, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(162, '2009-10-29', NULL, '01', NULL, 115, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(49, '2009-10-24', NULL, '01', NULL, 78, 'active', NULL, NULL, 16, '01', NULL, NULL),
(52, '2009-10-25', NULL, '', NULL, 85, NULL, NULL, NULL, 15, '', NULL, NULL),
(172, '2009-10-29', NULL, '03', NULL, 122, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(173, '2009-10-29', NULL, '02', NULL, 123, NULL, NULL, NULL, 0, '01', 'Sakit', '2009-10-30'),
(174, '2009-10-29', NULL, '01', NULL, 124, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(175, '2009-10-29', NULL, '03', NULL, 125, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(176, '2009-10-29', NULL, '01', NULL, 132, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(177, NULL, NULL, NULL, NULL, 128, NULL, NULL, NULL, 14, '01', '', '0000-00-00'),
(178, '2009-10-30', NULL, '01', NULL, 139, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(179, '2009-10-30', NULL, '01', NULL, 144, NULL, NULL, NULL, 14, '01', NULL, NULL),
(180, '2009-10-30', NULL, 'Array', 28, NULL, NULL, NULL, NULL, NULL, 'Array', NULL, NULL),
(181, '2009-10-30', NULL, 'Array', 28, NULL, NULL, NULL, NULL, NULL, 'Array', NULL, NULL),
(182, '2009-10-30', NULL, 'Array', 28, NULL, NULL, NULL, NULL, NULL, 'Array', NULL, NULL),
(183, '2009-10-30', NULL, '01', NULL, 162, NULL, NULL, NULL, 14, '01', NULL, NULL),
(184, '2009-10-30', NULL, 'Array', 28, NULL, NULL, NULL, NULL, NULL, 'Array', NULL, NULL),
(185, '2009-10-30', NULL, 'Array', 28, NULL, NULL, NULL, NULL, NULL, 'Array', NULL, NULL),
(186, '2009-10-30', NULL, '01', NULL, 164, NULL, NULL, NULL, 13, '01', NULL, NULL),
(164, '2009-10-29', NULL, '01', NULL, 117, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(166, '2009-10-29', NULL, '02', NULL, 120, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(111, '2009-10-15', NULL, '01', NULL, 93, NULL, NULL, NULL, 13, '01', NULL, NULL),
(167, '2009-10-29', NULL, '02', NULL, 120, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(168, '2009-10-29', NULL, '02', NULL, 120, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(169, '2009-10-29', NULL, '01', NULL, 120, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(126, '2009-10-26', NULL, '01', NULL, 96, NULL, NULL, NULL, 14, '02', NULL, NULL),
(127, '2009-10-26', NULL, '01', NULL, 98, NULL, NULL, NULL, 14, '02', NULL, NULL),
(128, '2009-10-26', NULL, '02', NULL, 100, NULL, NULL, NULL, 16, '01', NULL, NULL),
(129, '2009-10-26', NULL, '01', NULL, 104, NULL, NULL, NULL, 16, '02', NULL, NULL),
(130, '2009-10-26', NULL, '01', NULL, 106, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(170, '2009-10-29', NULL, '01', NULL, 120, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(187, '2009-10-30', NULL, '01', NULL, 165, NULL, NULL, NULL, 14, '01', NULL, NULL),
(188, '2009-10-30', NULL, '01', NULL, 166, NULL, NULL, NULL, 16, '01', '', '0000-00-00'),
(189, '2009-10-30', NULL, '01', NULL, 167, NULL, NULL, NULL, 14, '01', NULL, NULL),
(190, '2009-10-30', NULL, '01', NULL, 168, NULL, NULL, NULL, 14, '01', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `prs_permohonan_peserta`
--

CREATE TABLE IF NOT EXISTS `prs_permohonan_peserta` (
  `ID_PERMOHONAN_PESERTA` int(11) NOT NULL auto_increment,
  `ID_PESERTA` int(11) default NULL,
  `ID_PERMOHONAN` int(11) default NULL,
  `KOD_STATUS` int(11) default NULL,
  PRIMARY KEY  (`ID_PERMOHONAN_PESERTA`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `prs_permohonan_peserta`
--

INSERT INTO `prs_permohonan_peserta` (`ID_PERMOHONAN_PESERTA`, `ID_PESERTA`, `ID_PERMOHONAN`, `KOD_STATUS`) VALUES
(59, 94, 112, NULL),
(60, 96, 112, NULL),
(61, 98, 127, NULL),
(62, 100, 128, NULL),
(63, 102, 129, NULL),
(64, 104, 129, NULL),
(65, 106, 130, NULL),
(75, 120, 165, NULL),
(76, 122, 172, NULL),
(77, 123, 173, NULL),
(78, 124, 174, NULL),
(79, 125, 175, NULL),
(80, 132, 176, NULL),
(81, 139, 178, NULL),
(82, 144, 179, NULL),
(83, 0, 0, NULL),
(84, 0, 0, NULL),
(85, 0, 0, NULL),
(86, 0, 0, NULL),
(87, 0, 0, NULL),
(88, 162, 183, NULL),
(66, 0, 0, NULL),
(67, 0, 0, NULL),
(68, 109, 159, NULL),
(69, 114, 160, NULL),
(70, 115, 161, NULL),
(71, 116, 163, NULL),
(72, 117, 164, NULL),
(73, 118, 165, NULL),
(74, 120, 169, NULL),
(89, 0, 0, NULL),
(90, 0, 0, NULL),
(91, 164, 186, NULL),
(92, 165, 187, NULL),
(93, 166, 188, NULL),
(94, 167, 189, NULL),
(95, 168, 190, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prs_permohonan_rayuan`
--

CREATE TABLE IF NOT EXISTS `prs_permohonan_rayuan` (
  `ID_PERMOHONAN_RAYUAN` int(11) NOT NULL auto_increment,
  `TARIKH_RAYUAN` varchar(20) default NULL,
  `CATATAN_PERMOHONAN_RAYUAN` varchar(100) default NULL,
  `KEPUTUSAN_PERMOHONAN_RAYUAN` varchar(50) default NULL,
  `TARIKH_KEPUTUSAN` varchar(20) default NULL,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `ID_PESERTA` int(11) default NULL,
  PRIMARY KEY  (`ID_PERMOHONAN_RAYUAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `prs_permohonan_rayuan`
--


-- --------------------------------------------------------

--
-- Table structure for table `ruj_bulan`
--

CREATE TABLE IF NOT EXISTS `ruj_bulan` (
  `KOD_BULAN` varchar(10) NOT NULL,
  `KET_BULAN` varchar(20) NOT NULL,
  PRIMARY KEY  (`KOD_BULAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_bulan`
--

INSERT INTO `ruj_bulan` (`KOD_BULAN`, `KET_BULAN`) VALUES
('01', 'Januari'),
('02', 'Febuari'),
('03', 'Mac'),
('04', 'April'),
('05', 'Mei'),
('06', 'Jun'),
('07', 'Julai'),
('08', 'Ogos'),
('09', 'September'),
('10', 'Oktober'),
('11', 'November'),
('12', 'Disember');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_gred_jawatan`
--

CREATE TABLE IF NOT EXISTS `ruj_gred_jawatan` (
  `KOD_GRED_JAWATAN` varchar(11) NOT NULL,
  `KET_GRED_JAWATAN` varchar(100) default NULL,
  PRIMARY KEY  (`KOD_GRED_JAWATAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_gred_jawatan`
--

INSERT INTO `ruj_gred_jawatan` (`KOD_GRED_JAWATAN`, `KET_GRED_JAWATAN`) VALUES
('1', 'Gred 01'),
('2', 'Gred 02'),
('3', 'Gred 03'),
('4', 'Gred 04'),
('5', 'Gred 05'),
('6', 'Gred 06'),
('7', 'Gred 07'),
('8', 'Gred 08'),
('9', 'Gred 09'),
('10', 'Gred 10'),
('11', 'Gred 11'),
('12', 'Gred 12'),
('13', 'Gred 13'),
('14', 'Gred 14'),
('15', 'Gred 15'),
('16', 'Gred 16'),
('17', 'Gred 17'),
('18', 'Gred 18'),
('19', 'Gred 19'),
('20', 'Gred 20'),
('21', 'Gred 21'),
('22', 'Gred 22'),
('23', 'Gred 23'),
('24', 'Gred 24'),
('25', 'Gred 25'),
('26', 'Gred 26'),
('27', 'Gred 27'),
('28', 'Gred 28'),
('29', 'Gred 29'),
('30', 'Gred 30'),
('31', 'Gred 31'),
('32', 'Gred 32'),
('33', 'Gred 33'),
('34', 'Gred 34'),
('35', 'Gred 35'),
('36', 'Gred 36'),
('37', 'Gred 37'),
('38', 'Gred 38'),
('39', 'Gred 39'),
('40', 'Gred 40'),
('41', 'Gred 41'),
('42', 'Gred 42'),
('43', 'Gred 43'),
('44', 'Gred 44'),
('45', 'Gred 45'),
('46', 'Gred 46'),
('47', 'Gred 47'),
('48', 'Gred 48'),
('49', 'Gred 49'),
('50', 'Gred 50'),
('51', 'Gred 51'),
('52', 'Gred 52'),
('53', 'Gred 53'),
('54', 'Gred 54 '),
('55', 'Gred 55'),
('56', 'VK5    '),
('57', 'VK6'),
('58', 'VK7     '),
('59', 'KSN'),
('60', 'Gred Utama Turus I'),
('61', 'Gred Utama Turus II'),
('62', 'Gred Utama Turus III'),
('63', 'VU5'),
('64', 'VU6'),
('65', 'VU7     '),
('66', 'Lain-lain');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_hari`
--

CREATE TABLE IF NOT EXISTS `ruj_hari` (
  `KOD_HARI` varchar(20) NOT NULL,
  `KET_HARI` varchar(20) default NULL,
  PRIMARY KEY  (`KOD_HARI`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_hari`
--

INSERT INTO `ruj_hari` (`KOD_HARI`, `KET_HARI`) VALUES
('01', '01'),
('02', '02'),
('03', '03'),
('04', '04'),
('05', '05'),
('06', '06'),
('07', '07'),
('08', '08'),
('09', '09'),
('10', '10'),
('11', '11'),
('12', '12'),
('13', '13'),
('14', '14'),
('15', '15'),
('16', '16'),
('17', '17'),
('18', '18'),
('19', '19'),
('20', '20'),
('21', '21'),
('22', '22'),
('23', '23'),
('24', '24'),
('25', '25'),
('26', '26'),
('27', '27'),
('28', '28'),
('29', '29'),
('30', '30'),
('31', '31');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_jabatan`
--

CREATE TABLE IF NOT EXISTS `ruj_jabatan` (
  `KOD_JABATAN` varchar(10) NOT NULL,
  `KET_JABATAN` varchar(100) NOT NULL,
  PRIMARY KEY  (`KOD_JABATAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_jabatan`
--

INSERT INTO `ruj_jabatan` (`KOD_JABATAN`, `KET_JABATAN`) VALUES
('101104', 'Jabatan Audit Negara'),
('101113', 'Bahagian Hal Ehwal Undang-Undang'),
('101119', 'Bahagian Keselamatan Negara'),
('101118', 'Bahagian Penyelidikan'),
('101107', 'Suruhanjaya Perkhidmatan Pendidikan'),
('131103', 'Agensi Anti Dadah Kebangsaan'),
('130106', 'Jabatan Imigresen Malaysia'),
('131104', 'Jabatan Pertahanan Awam Malaysia'),
('103102', 'Jabatan Akauntan Negara'),
('103401', 'Bank Negara Malaysia'),
('103009', 'Bahagian Pinjaman Perumahan'),
('104102', 'Jabatan Penerbangan Awam'),
('104101', 'Jabatan Pengangkutan Jalan'),
('104401', 'Lembaga Pelabuhan Kelang'),
('101001', 'Pejabat Y.A.B Perdana Menteri'),
('101002', 'Pejabat Y.A.B Timbalan Perdana Menteri'),
('101003', 'Pejabat Ketua Setiausaha Negara'),
('101004', 'Pejabat Y.B Menteri-Menteri, Timbalan -Timbalan Menteri dan Setiausaha-Setiausaha Parlimen'),
('101008', 'Unit Audit Dalam '),
('101009', 'Bahagian Kemajuan Wilayah Persekutuan dan Perancangan Lembah Kelang '),
('101101', 'Jabatan Parlimen  '),
('101102', 'Pejabat Penyimpan Mohor Besar Raja-Raja'),
('101103', 'Istana Negara'),
('101105', 'Suruhanjaya Pilihanraya'),
('101106', 'Suruhanjaya Perkhidmatan Awam'),
('101108', 'Jabatan Perkhidmatan Awam'),
('101109', 'Jabatan Perangkaan'),
('101110', 'Jabatan Peguam Negara'),
('101111', 'Badan Pencegah Rasuah'),
('101112', 'Pejabat Ketua Pendaftar Mahkamah Persekutuan'),
('101114', 'Institut Diplomasi dan Hubungan Luar Negeri (IDHL)'),
('101116', 'Unit Penyelarasan Pelaksanaan (UPP)'),
('101117', 'Unit Perancang Ekonomi (UPE)'),
('101120', 'Penasihat Sains  '),
('101121', 'Lembaga Penasihat  '),
('101401', 'Lembaga Tabung Haji  '),
('101402', 'Perbadanan Putrajaya '),
('130001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('130002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('130003', 'Bahagian Keselamatan & Ketenteraan Awam'),
('130004', 'Bahagian Imigresen dan Pendaftaran Negara'),
('130005', 'Bahagian Kawalan Penerbitan.Penapisan Filem dan Teks Al-Quran'),
('130006', 'Bahagian Pentadbiran'),
('130007', 'Bahagian Kewangan, Bekalan dan Pembangunan'),
('130008', 'Bahagian Akauntan Kanan Perbendaharaan'),
('130009', 'Bahagian Penyelidikan & Perancangan'),
('130010', 'Bahagian Peguam Kanan Persekutuan'),
('130011', 'Bahagian Audit Dalam'),
('131010', 'Ikatan Relawan Rakyat Malaysia'),
('131101', 'Polis DiRaja Malaysia'),
('131102', 'Jabatan Penjara Malaysia'),
('130101', 'Jabatan Pendaftaran Negara'),
('130103', 'Jabatan Pendaftaran Pertubuhan'),
('103001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('103002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('103003', 'Bahagian Undang-Undang'),
('103004', 'Unit Audit Dalam'),
('103005', 'Pejabat Perhubungan Awam'),
('103006', 'Bahagian Pentadbiran & Kewangan'),
('103007', 'Bahagian Pengurusan Perolehan Kerajaan'),
('103008', 'Bahagian Pengurusan Belanjawan'),
('103010', 'Perbendaharaan Malaysia, Sabah'),
('103011', 'Perbendaharaan Malaysia, Sarawak'),
('103012', 'Bahagian Pinjaman dan Dasar Kewangan'),
('103013', 'Bahagian Ekonomi & Antarabangsa'),
('103014', 'Bahagian Analisa Cukai'),
('103015', 'Bahagian Khidmat Nasihat Pengurusan Kewangan'),
('103016', 'Unit Kawalan Perbelanjaan'),
('103017', 'Bahagian Penyelarasan Syarikat MK (D), Penswastaan & Perusahaan Awam'),
('103101', 'Pesuruhjaya Khas Cukai Pendapatan'),
('103103', 'Jabatan Kastam Diraja Malaysia'),
('103104', 'Jabatan Penilaian & Perkhidmatan Harta'),
('103402', 'Khazanah Nasional Berhad'),
('103403', 'Suruhanjaya Sekuriti'),
('103404', 'Bank Simpanan Nasional'),
('103405', 'Kumpulan Wang Simpanan Pekerja'),
('103406', 'Lembaga Pembangunan Langkawi'),
('103407', 'Lembaga Pembangunan Labuan'),
('103408', 'Yayasan Tun Abdul Razak'),
('103409', 'Lembaga Totalisator Malaysia'),
('103410', 'Lembaga Hasil Dalam Negeri'),
('104001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('104002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('104003', 'Bahagian Maritim'),
('104004', 'Bahagian Udara'),
('104005', 'Bahagian Darat'),
('104006', 'Bahagian Perjawatan & Perkhidmatan'),
('104007', 'Bahagian Kerjasama Antarabangsa'),
('104008', 'Bahagian Kewangan'),
('104009', 'Bahagian Akaun'),
('104010', 'Unit Penasihat Undang-Undang '),
('104011', 'Unit Audit Dalam '),
('104012', 'Unit Teknologi Maklumat'),
('104013', 'Unit Pemantauan Projek'),
('104014', 'Bahagian Sumber Manusia'),
('104103', 'Jabatan Laut Semenanjung'),
('104104', 'Jabatan Laut Sabah'),
('104105', 'Jabatan Laut Sarawak'),
('104402', 'Lembaga Pelabuhan Bintulu'),
('104403', 'Lembaga Pelabuhan Kuantan'),
('104404', 'Lembaga Pelabuhan Johor'),
('104405', 'Lembaga Pelabuhan Kemaman'),
('104406', 'Suruhanjaya Lembaga Pelabuhan Pulau Pinang'),
('104407', 'Perbadanan Aset Keretapi'),
('105001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('105002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('105003', 'Unit Penasihat Undang-Undang'),
('105004', 'Unit Audit Dalaman'),
('105005', 'Perhubungan Awam'),
('105006', 'Bahagian Perancangan Jalan'),
('105007', 'Bahagian Pembangunan & Pelaksanaan'),
('105008', 'Bahagian Kewangan & Akaun'),
('105009', 'Bahagian Pengurusan Sumber Manusia'),
('105010', 'Cawangan Dasar & Pengurusan Korporat'),
('105011', 'Cawangan Pentadbiran & Penyenggaraan Bangunan'),
('105012', 'Cawangan Pembangunan Usahawan'),
('105013', 'Unit Teknologi Maklumat'),
('105101', 'Jabatan Kerja Raya Malaysia (JKR)'),
('132001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('132002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('132003', 'Penasihat Undang-Undang'),
('132004', 'Audit Dalam'),
('132005', 'Perhubungan Awam'),
('132006', 'Bahagian Pengurusan Pembangunan & Kewangan'),
('132007', 'Bahagian Teknologi Maklumat & Komunikasi'),
('132008', 'Bahagian Perhubungan Antarabangsa'),
('132009', 'Bahagian Kemajuan Industri Kayu-Kayan'),
('132010', 'Bahagian Kemajuan Industri Koko, Tembakau & Lada Hitam'),
('132011', 'Bahagian Peracangan Strategik & Korporat'),
('132012', 'Bahagian Kemajuan Industri Minyak Sayuran & Lemak'),
('132013', 'Bahagian Kemajuan Industri Getah'),
('132101', 'Jemaah Pemasaran Lada Hitam'),
('132401', 'Lembaga Perindustrian Kayu Malaysia (MTIB)'),
('132402', 'Lembaga Tembakau Negara Malaysia '),
('132403', 'Lembaga Koko Malaysia (MCB)'),
('132404', 'Lembaga Getah Malaysia (MRB)'),
('132405', 'Lembaga Minyak Sawit Malaysia (MPOB)'),
('133001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('133002', 'Pejabat Ketus Setiausaha Kementerian/Timbalan KSU Kementerian'),
('133003', 'Bahagian Audit Dalam'),
('133004', 'Bahagian Perundangan'),
('133005', 'Bahagian Pengurusan & Komunikasi Korporat'),
('133006', 'Bahagian Komunikasi Dan Multimedia'),
('133007', 'Bahagian Tenaga'),
('133008', 'Bahagian Teknologi Maklumat'),
('133101', 'Jabatan Bekalan Elektrik Dan Gas'),
('133102', 'Jabatan Pos'),
('133401', 'Suruhanjaya Komunikasi dan Multimedia Malaysia'),
('108001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('108002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('108003', 'Penasihat Undang-Undang'),
('108004', 'Unit Audit Dalam'),
('108005', 'Unit Perhubungan Awam'),
('108006', 'Bahagian Dasar & Penyelidikan'),
('108007', 'Bahagian Sumber Manusia, Kewangan & Teknologi Maklumat'),
('108008', 'Bahagian Pembangunan Industri'),
('108009', 'Bahagian Perdagangan Antarabangsa'),
('108401', 'Lembaga Kemajuan Perindustrian Malaysia (MIDA)'),
('108402', 'Perbadanan Pembangunan Perdagangan Luar Malaysia (MATRADE)'),
('108403', 'Lembaga Produktiviti Negara (NPC)'),
('108404', 'Perbadanan Pembangunan Industri Kecil dan Sederhana (SMIDEC)'),
('108405', 'Perbadanan Pembangunan Teknologi Malaysia (MTDC)'),
('134001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('134002', 'Pejabat Setiausaha Parlimen'),
('134003', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('134004', 'Penasihat Undang-Undang'),
('134005', 'Unir Audit Dalam'),
('134006', 'Unit Perhubungan Awam'),
('134101', 'Jabatan Pertanian Malaysia'),
('134102', 'Jabatan Perikanan Malaysia'),
('134103', 'Jabatan Perkhidmatan Haiwan (JPH)'),
('134401', 'Lembaga Pertubuhan Peladang (LPP)'),
('134402', 'Lembaga Pemasaran Pertanian Persekutuan (FAMA)'),
('134403', 'Lembaga Kemajuan Pertanian Muda (MADA)'),
('134404', 'Lembaga Kemajuan Pertanian Kemubu (KADA)'),
('134405', 'Lembaga Kemajuan Ikan Malaysia (LKIM)'),
('134406', 'Institut Penyelidikan dan Kemajuan Pertanian Malaysia (MARDI)'),
('134407', 'Bank Pertanian Malaysia (BPM)'),
('134408', 'Jemaah Pemasaran Lada Hitam (JPLH)'),
('110001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('110002', 'Pejabat Setiausaha Kementerian/Timbalan KSU Kementerian'),
('110003', 'Bahagian Nasihat Perundangan'),
('110004', 'Bahagian Audit Dalam'),
('110005', 'Unit Perhubungan Awam'),
('110006', 'Bahagian Pengurusan Am'),
('110007', 'Bahagian Pengurusan Sumber Manusia'),
('110008', 'Bahagian Khidmat Pengurusan dan Kewangan'),
('110009', 'Bahagian Perancangan & Pembangunan'),
('110010', 'Bahagian Teknologi Maklumat'),
('110011', 'Bahagian Harta Intelek'),
('110012', 'Bahagian Perdagangan Dalam Negeri'),
('110013', 'Bahagian Hal Ehwal Pengguna'),
('110014', 'Bahagian Penguatkuasa'),
('110015', 'Tribunal Tuntutan Pengguna'),
('110016', 'Pejabat Pendaftaran Syarikat'),
('110017', 'Pejabat Pendaftaran Perniagaan'),
('135001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('135002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('135003', 'Pejabat Ketua Pengarah Pendidikan Malaysia'),
('135004', 'Bahagian Audit Dalam'),
('135005', 'Bahagian Khidmat Pengurusan'),
('135007', 'Bahagian Kewangan'),
('135008', 'Bahagian Dasar & Pengurusan Korporat'),
('135009', 'Bahagian Perancangan & Penyelidikan Dasar Pendidikan'),
('135010', 'Bahagian Pembangunan, Penswastaan & Bekalan'),
('135011', 'Bahagian Hubungan Antarabangsa'),
('135012', 'Bahagian Audit Sekolah'),
('135013', 'Bahagian Biasiswa'),
('135014', 'Bahagian Teknologi Maklumat dan Komunikasi'),
('135015', 'Bahagian Teknologi Pendidikan'),
('135016', 'Bahagian Matrikulasi'),
('135101', 'Jemaah Nazir Sekolah-Sekolah'),
('135102', 'Lembaga Peperiksaan Malaysia'),
('135103', 'Institut Aminuddin Baki'),
('135104', 'Jabatan Sekolah'),
('135106', 'Jabatan Pendidikan Teknikal'),
('135108', 'Jabatan Pendidikan Islam & Moral'),
('135111', 'Jabatan Pendidikan Khas'),
('135401', 'Dewan Bahasa Dan Pustaka'),
('135402', 'Lembaga Akreditasi Negara'),
('135403', 'Majlis Peperiksaan Malaysia'),
('135405', 'Institut Terjemahan Negera Malaysia'),
('112001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('112002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('112003', 'Bahagian Pentadbiran'),
('112004', 'Unit Audit Dalam'),
('112005', 'Bahagian Perhubungan Awam'),
('112006', 'Cawangan Perbelanjaan'),
('112007', 'Cawangan Bekalan & Kontrak'),
('112008', 'Cawangan Akaun'),
('112009', 'Bahagian Perdagangan'),
('112010', 'Cawangan Perkhidmatan'),
('112011', 'Cawangan Perjawatan/Naik Pangkat/Tatatertib'),
('112012', 'Cawangan Khidmat Nasihat'),
('112013', 'Cawangan Latihan & Peperiksaan'),
('112014', 'Bahagian Perancangan/Penyelidikan & Pembangunan'),
('112015', 'Unit Teknologi Maklumat'),
('112016', 'Unit Pengurusan Isu'),
('112101', 'Jabatan Penyiaran'),
('112102', 'Jabatan Penerangan'),
('112103', 'Jabatan Hal Ehwal Khas (JHEK)'),
('112104', 'Jabatan Filem Negara'),
('112401', 'BERNAMA'),
('137403', 'Perbadanan Kemajuan Filem Nasional Malaysia (FINAS)'),
('138001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('138002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('138003', 'Bahagian Pelancongan'),
('138004', 'Bahagian Teknologi Maklumat'),
('138005', 'Bahagian Pembangunan'),
('138006', 'Pusat Pelancongan Malaysia'),
('138007', 'Bahagian Penguatkuasaan'),
('138008', 'Bahagian Pengurusan'),
('137007', 'Bahagian Dasar Kebudayaan'),
('137008', 'Bahagian Pembangunan Kebudayaan'),
('137101', 'Istana Budaya'),
('137102', 'Akademi Seni Kebangsaan'),
('137103', 'Jabatan Muzium '),
('137104', 'Jabatan Arkib Negara'),
('137401', 'Balai Seni Lukis Negara'),
('138401', 'Lembaga Penggalakan Pelancongan Malaysia'),
('114001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('114002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('114003', 'Unit Penasihat Undang-Undang'),
('114004', 'Unit Audit Dalam'),
('114005', 'Unit Atase Buruh di Geneva'),
('114006', 'Bahagian Pengurusan Pentadbiran'),
('114007', 'Bahagian Perancangan & Penyelidikan Dasar'),
('114008', 'Bahagian Tabung Pinjaman Pembangunan Kemahiran'),
('114111', 'Jabatan Tenaga Manusia'),
('114112', 'Jabatan Tenaga Kerja Semenanjung Malaysia'),
('114103', 'Jabatan Keselamatan dan Kesihatan Pekerjaan'),
('114104', 'Jabatan Perhubungan Perusahaan'),
('114105', 'Majlis Latihan Vokasional Kebangsaan'),
('114106', 'Jabatan Hal Ehwal Kesatuan Kerja'),
('114114', 'Jabatan Tenaga Kerja Sabah'),
('114108', 'Mahkamah Perusahaan Malaysia'),
('114113', 'Jabatan Tenaga Kerja Sarawak'),
('114110', 'Mahkamah Rayuan (Telah Bubar)'),
('114401', 'Pertubuhan Keselamatan Sosial (PERKESO)'),
('114402', 'Majlis Pembangunan Sumber Manusia'),
('114403', 'Lembaga Kumpulan Wang Perpindahan Malaysia (dibubar pada tahun 2000)'),
('114404', 'Lembaga Kumpulan Wang Buruh India Selatan (dibubar pada tahun 2000)'),
('114405', 'Lembaga Buruh Pelabuhan Pulau Pinang (telah dibubarkan pada 1.1.2002)'),
('139001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('139002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('139003', 'Unit Perhubungan Awam'),
('139004', 'Unit Penasihat Undang-Undang'),
('139005', 'Unit Audit Dalam'),
('139006', 'Bahagian Pentadbiran'),
('139007', 'Bahagian Perkhidmatan'),
('139008', 'Bahagian Kewangan'),
('139009', 'Bahagian Pembangunan'),
('139010', 'Bahagian Sains & Teknologi'),
('139011', 'Pusat Maklumat Sains & Teknologi (MASTIC)'),
('139012', 'Bahagian Antarabangsa'),
('139013', 'Bahagian Konservasi dan Pengurusan Alam Sekitar'),
('139101', 'Jabatan Kimia Malaysia'),
('139102', 'Institut Penyelidikan Teknologi Nuklear Malaysia (MINT)'),
('139103', 'Perkhidmatan Kajicuaca Malaysia'),
('139104', 'Jabatan Standard Malaysia'),
('139105', 'Pusat Sains Negara'),
('139106', 'Bahagian Kajian Sains Angkasa (BAKSA)'),
('139107', 'Pusat Remote Sensing Negara (MACRES)'),
('139108', 'Agensi Angkasa Negara (NSA)'),
('139109', 'Pejabat Penasihat Sains'),
('139110', 'Pusat Penggalakkan Keintelektualan dan Kemajuan Teknologi (CIPTA)'),
('139111', 'Kumpulan Industri Bagi Teknologi Malaysia (MIGHT)'),
('139401', 'Majlis Rekabentuk Malaysia'),
('139402', 'Akademi Sains Malaysia'),
('116001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('116002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('116003', 'Unit Perhubungan Awam'),
('116004', 'Unit Perundangan'),
('116005', 'Unit Audit Dalam'),
('116006', 'Bahagian Pentadbiran'),
('116007', 'Bahagian Pengurusan Sumber Manusia'),
('116008', 'Bahagian Kewangan'),
('116009', 'Bahagian Pengawasan & Penguatkuasaan'),
('116010', 'Bahagian Pelesenan & Khidmat Nasihat'),
('116011', 'Bahagian Teknologi Maklumat'),
('116012', 'Bahagian Perancangan Dasar & Pembangunan'),
('116101', 'Jabatan Bomba & Penyelamat Malaysia'),
('116102', 'Jabatan Landskap Negara'),
('116103', 'Jabatan Perumahan Negara'),
('116104', 'Jabatan Kerajaan Tempatan'),
('116105', 'Jabatan Perkhidmatan Pembentungan'),
('116106', 'Jabatan Perancangan Bandar dan Desa Semenanjung Malaysia'),
('117001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('117002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('117003', 'Pejabat Panglima Angkatan Tentera'),
('117004', 'Pejabat Ketua Hakim Peguam'),
('117005', 'Bahagian Undang-Undang'),
('117006', 'Bahagian Dasar'),
('117007', 'Bahagian Audit Dalam & Siasatan Am'),
('117008', 'Pejabat Sekretariat Majlis Angkatan Tentera'),
('117009', 'Institut Sains & Teknologi Pertahanan'),
('117010', 'Bahagian Pembangunan'),
('117011', 'Bahagian Perolehan'),
('117012', 'Bahagian Industri Pertahanan'),
('117013', 'Depoh Simpanan Pertahanan'),
('117014', 'Bahagian Kewangan & Akaun'),
('117015', 'Bahagian Perjawatan & Perkhidmatan'),
('117016', 'Bahagian Pentadbiran & P. Awam'),
('117017', 'Bahagian Teknologi Maklumat'),
('117018', 'Pejabat Cawangan KEMENTAH Sabah'),
('117019', 'Pejabat Cawangan KEMENTAH Sarawak'),
('117101', 'Jabatan Hal Ehwal Veteran'),
('117102', 'Markas ATM'),
('117103', 'Markas Tentera Darat '),
('117104', 'Markas Tentera Laut'),
('117105', 'Markas Tentera Udara'),
('117106', 'Jabatan Khidmat Negara'),
('140001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('140002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('140003', 'Unit Perhubungan Awam'),
('140004', 'Pejabat Penasihat Undang-Undang'),
('140005', 'Unit Audit Dalam'),
('140006', 'Bahagian Pembasmi Kemiskinan'),
('140007', 'Bahagian Ekonomi Desa'),
('140008', 'Perancangan Strategik'),
('140009', 'Bahagian Prasarana, Utiliti dan Ameniti Sosial'),
('140010', 'Bahagian Wilayah dan Kawasan'),
('140011', 'Bahagian Pelaburan dan Anak Syarikat'),
('140012', 'Bahagian Kewangan, Belanjawan dan Perolehan'),
('140013', 'Bahagian Pengurusan Sumber Manusia'),
('140101', 'Bahagian Kemajuan Masyarakat (KEMAS)'),
('140102', 'Jabatan Hal Ehwal Orang Asli (mulai 31 Jan 2001)'),
('140103', 'Institut Kemajuan Desa (INFRA)'),
('140401', 'Lembaga Kemajuan Johor Tenggara (KEJORA)'),
('140402', 'Lembaga Kemajuan Kelantan Selatan (KESEDAR)'),
('140403', 'Lembaga Kemajuan Terengganu Tengah (KETENGAH)'),
('140404', 'Lembaga Kemajuan Wilayah Kedah (KEDA)'),
('140406', 'Lembaga Kemajuan Wilayah Pulau Pinang (PERDA)'),
('140405', 'Pihak Berkuasa Kemajuan Pekebun Kecil Perusahaan Getah (RISDA)'),
('119001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('119002', 'Pejabat Utusan Khas Perdana Menteri'),
('119003', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('119004', 'Jabatan Hubungan Dua Hala Politik & Ekonomi'),
('119005', 'Jabatan Perancangan Dasar'),
('119006', 'Jabatan Perhubungan Antarabangsa Dan Ekonomi Pelbagai Hala (IOME)'),
('119007', 'Jabatan Pengurusan & Perkara-Perkara AM'),
('119008', 'Jabatan Kerjasama ASEAN'),
('119009', 'Jabatan Protokol'),
('119010', 'Bahagian Undang-Undang'),
('141001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen '),
('141002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('141003', 'Bahagian Dasar Dan Pembangunan'),
('141004', 'Bahagian Pentadbiran & Perkhidmatan'),
('141005', 'Bahagian Kewangan'),
('141006', 'Bahagian Teknologi Maklumat'),
('141101', 'Jabatan Ukur dan Pemetaan Malaysia (JUPEM)'),
('141102', 'Jabatan Ketua Pengarah Tanah Dan Galian (JKPTG)'),
('141103', 'Institut Tanah & Ukur Negara (INSTUN)'),
('141104', 'Jabatan Mineral dan Geosains Malaysia'),
('121001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('121002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('121003', 'Pejabat Pesuruhjaya Sukan'),
('121004', 'Bahagian Undang-Undang'),
('121005', 'Unit Audit Dalam & Siasatan Awam'),
('121006', 'Bahagian Pengurusan'),
('121007', 'Bahagian Penyelidikan Dasar'),
('121008', 'Bahagian Pembangunan Kemahiran'),
('121009', 'Urusetia Sukan Antarabangsa'),
('121101', 'Jabatan Belia Dan Sukan'),
('121401', 'Majlis Sukan Negara Malaysia'),
('121402', 'Perbadanan Stadium Merdeka'),
('143001', 'Pejabat Y.B Menteri/Timbalan Menteri'),
('143002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('143101', 'Jabatan Pembangunan Wanita'),
('143102', 'Jabatan Kebajikan Masyarakat Malaysia'),
('143103', 'Institut Sosial Malaysia'),
('123001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('123002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('123003', 'Pejabat Ketua Pengarah Kesihatan/Timbalan Ketua Pengarah Kesihatan'),
('123004', 'Pejabat Penasihat Undang-Undang'),
('123005', 'Pejabat Perhubungan Awam'),
('123006', 'Pejabat Audit Dalam'),
('123007', 'Bahagian Pengurusan'),
('123008', 'Bahagian Sumber Manusia'),
('123009', 'Bahagian Perancangan Tenaga Manusia & Latihan'),
('123010', 'Bahagian Teknologi Maklumat'),
('123011', 'Bahagian Kewangan Am'),
('123012', 'Bahagian Perolehan & Penswastaan'),
('123013', 'Bahagian Akaun'),
('123014', 'Bahagian Kesihatan Pergigian'),
('123015', 'Bahagian Kawalan Penyakit'),
('123016', 'Bahagian Pendidikan Kesihatan'),
('123017', 'Bahagian Kawalan Mutu Makanan'),
('123018', 'Bahagian Pembangunan Kesihatan Keluarga'),
('123019', 'Bahagian Perkembangan Perubatan'),
('123020', 'Bahagian Amalan Perubatan'),
('123021', 'Bahagian Perkhidmatan Farmasi'),
('123022', 'Bahagian Perkhidmatan Kejuruteraan'),
('123023', 'Bahagian Perancangan & Pembangunan'),
('123101', 'Jabatan Kesihatan Negeri Perlis'),
('123102', 'Jabatan Kesihatan Negeri Kedah'),
('123103', 'Jabatan Kesihatan Negeri Pulau Pinang'),
('123104', 'Jabatan Kesihatan Negeri Perak'),
('123105', 'Jabatan Kesihatan Negeri Selangor'),
('123106', 'Jabatan Kesihatan Negeri Sembilan'),
('123107', 'Jabatan Kesihatan Negeri Melaka'),
('123108', 'Jabatan Kesihatan Negeri Johor'),
('123109', 'Jabatan Kesihatan Negeri Pahang'),
('123110', 'Jabatan Kesihatan Negeri Terengganu'),
('123111', 'Jabatan Kesihatan Negeri Kelantan'),
('123112', 'Jabatan Kesihatan Negeri Sabah'),
('123113', 'Jabatan Kesihatan Negeri Sarawak'),
('123114', 'Hospital Kuala Lumpur'),
('123115', 'Institut Penyelidikan Perubatan'),
('123116', 'Biro Farmaseutikal Kebangsaan'),
('123117', 'Institut Kesihatan Umum'),
('123118', 'Institut Pengurusan Kesihatan'),
('123119', 'Sekolah Latihan Pegigian Pulau Pinang'),
('123120', 'Pusat Perkhidmatan Darah Negara'),
('123121', 'Hospital Selayang'),
('123122', 'Pergigian Wilayah Persekutuan'),
('142001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('142002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('142003', 'Unit Undang-Undang'),
('142004', 'Unit Audit Dalam'),
('142005', 'Unit Perhubungan Awam'),
('142006', 'Unit Perkhidmatan'),
('142007', 'Unit Pengurusan'),
('142008', 'Bahagian Prancais dan Vendor'),
('142009', 'Bahagian Pembangunan Perniagaan'),
('142010', 'Bahagian Latihan Keusahawanan'),
('142011', 'Bahagian Perancangan & Penilaian'),
('142012', 'Bahagian Program & Projek Pembangunan'),
('142013', 'Bahagian Pengurusan Maklumat'),
('142014', 'Lembaga Pelesenan Kenderaan Perdagangan Semenanjung Malaysia'),
('142015', 'Pusat Perkhidmatan Kontraktor'),
('201001', 'Pejabat Menteri Besar'),
('201002', 'Pejabat Setiausaha Kerajaan Negeri'),
('201201', 'Jabatan DiRaja Johor'),
('201202', 'Suruhanjaya Perkhidmatan Awam Negeri Johor'),
('201203', 'Dewan Negeri'),
('201204', 'Perbendaharaan Negeri'),
('201205', 'Jabatan Pertanian Johor'),
('201206', 'Jabatan Pengairan dan Saliran'),
('201207', 'Jabatan Perkhidmatan Haiwan'),
('201208', 'Pejabat Kebun Bunga Kerajaan'),
('201209', 'Jabatan Perancangan Bandar Dan Desa'),
('201210', 'Pejabat Tanah Dan Galian Johor'),
('201211', 'Jabatan Perhutanan Negeri'),
('201212', 'Jabatan Galian Johor'),
('201213', 'Jabatan Agama Islam Johor'),
('201214', 'Jabatan Kebajikan Masyarakat Johor'),
('201215', 'Jabatan Kerja Raya Johor'),
('201216', 'Pejabat Muzium DiRaja Johor'),
('201217', 'Mahkamah Syariah Johor'),
('201218', 'Mufti Negeri Johor'),
('201219', 'Jabatan Landskap Negeri Johor'),
('201220', 'Jabatan Penyelidikan & Penerangan Johor'),
('201221', 'Pejabat Daerah Johor Bahru'),
('201222', 'Pejabat Daerah Muar'),
('201223', 'Pejabat Daerah Batu Pahat'),
('201224', 'Pejabat Daerah Pontian'),
('201225', 'Pejabat Daerah Segamat'),
('201226', 'Pejabat Daerah Kluang'),
('201227', 'Pejabat Daerah Kota Tinggi'),
('201228', 'Pejabat Daerah Mersing'),
('201229', 'Pejabat Tanah Johor Bahru'),
('201230', 'Pejabat Tanah Muar'),
('201231', 'Pejabat Tanah Batu Pahat'),
('201232', 'Pejabat Tanah Pontian'),
('201233', 'Pejabat Tanah Segamat'),
('201234', 'Pejabat Tanah Kluang'),
('201235', 'Pejabat Tanah Kota Tinggi'),
('201236', 'Pejabat Tanah Mersing'),
('201501', 'Perbadanan Perpustakaan Awam Johor'),
('201502', 'Perbadanan Kemajuan Ekonomi Islam Johor'),
('201503', 'Yayasan Pelajaran Johor'),
('201504', 'Majlis Agama Islam Johor'),
('201505', 'Jabatan Pelancongan Johor'),
('201506', 'Perbadanan Kemajuan Ekonomi Negeri (PKEN)'),
('202001', 'Pejabat Menteri Besar'),
('202002', 'Pejabat Setiausaha Kerajaan Negeri'),
('202201', 'Jabatan Galian Negeri Kedah'),
('202202', 'Jabatan Haiwan Negeri Kedah'),
('202203', 'Jabatan Hal Ehwal Agama Islam Negeri Kedah'),
('202204', 'Jabatan Perhutanan Negeri Kedah'),
('202205', 'Jabatan Masyarakat Negeri Kedah'),
('202206', 'Jabatan Kerjaraya Negeri Kedah'),
('202207', 'Jabatan Pengairan dan Saliran Negeri Kedah'),
('202208', 'Pejabat Pengarah Tanah dan Galian Kedah'),
('202209', 'Pejabat Tanah Negeri Kedah'),
('202210', 'Pejabat Tanah Kota Setar'),
('202211', 'Pejabat Tanah Kuala Muda'),
('202212', 'Pejabat Tanah Kulim'),
('202213', 'Pejabat Tanah Baling'),
('202214', 'Pejabat Tanah Kubang Pasu'),
('202221', 'Pejabat Tanah Sik'),
('202222', 'Pejabat Tanah Pokok Sena'),
('202223', 'Pejabat Tanah Pendang'),
('202224', 'Pejabat Tanah Padang Terap'),
('202225', 'Pejabat Tanah Langkawi'),
('202226', 'Pejabat Tanah Bandar Baharu'),
('202227', 'Jabatan Perancangan Bandar dan Desa Kedah'),
('202228', 'Perbendaharaan Negeri Kedah'),
('202229', 'Jabatan Pertanian Negeri Kedah'),
('202230', 'Suruhanjaya Perkhidmatan Awam Negeri Kedah'),
('202231', 'Yayasan Islam Kedah'),
('202232', 'Pejabat Zakat Negeri Kedah'),
('202233', 'Pejabat Daerah Kota Setar'),
('202234', 'Pejabat Daerah Kuala Muda'),
('202235', 'Pejabat Daerah Kulim'),
('202236', 'Pejabat Daerah Baling'),
('202237', 'Pejabat Daerah Kubang Pasu'),
('202238', 'Pejabat Daerah Yan'),
('202239', 'Pejabat Daerah Sik'),
('202240', 'Pejabat Daerah Pendang'),
('202241', 'Pejabat Daerah Padang Terap'),
('202242', 'Pejabat Daerah Langkawi'),
('202243', 'Pejabat Daerah Bandar Baharu'),
('202501', 'Lembaga Kemajuan Penanam Padi Kedah'),
('202502', 'Lembaga Kesihatan Negeri Kedah'),
('202503', 'Perbadanan Kemajuan Negeri Kedah'),
('202504', 'Perbadanan Perpustakaan Awam Negeri Kedah'),
('202505', 'Suruhanjaya Perkhidmatan Awam Negeri Kedah'),
('202506', 'Perbadana Stadium Negeri Kedah'),
('202507', 'Lembaga Muzium Negeri Kedah'),
('202508', 'Lembaga Maktab Mahmud'),
('202509', 'Lembaga Kemajuan Tanah Negeri Kedah'),
('202510', 'Perbadanan Kemajuan Ekonomi Negeri Kedah (PKEN)'),
('203001', 'Pejabat Menteri Besar'),
('203002', 'Pejabat Setiausaha Kerajaan Negeri'),
('203201', 'Pejabat Sultan Kelantan'),
('203202', 'Pejabat Tanah dan Galian Kelantan'),
('203203', 'Pejabat Tanah dan Jajahan Kota Bharu'),
('203204', 'Pejabat Tanah dan Jajahan Tanah Merah'),
('203205', 'Pejabat Tanah dan Jajahan Pasir Mas'),
('203206', 'Pejabat Tanah dan Jajahan Gua Musang'),
('203207', 'Pejabat Tanah dan Jajahan Kuala Krai'),
('203208', 'Pejabat Tanah dan Jajahan Machang'),
('203209', 'Pejabat Tanah dan Jajahan Jeli'),
('203210', 'Pejabat Tanah dan Jajahan Tumpat'),
('203211', 'Pejabat Tanah dan Jajahan Pasir Puteh'),
('203212', 'Pejabat Tanah dan Jajahan Bachok'),
('203213', 'Pejabat Perbendaharaan Negeri Kelantan'),
('203214', 'Pejabat Mufti Negeri Kelantan'),
('203215', 'Pejabat Pembangunan Negeri Kelantan'),
('203216', 'Pejabat Kebajikan Masyarakat Negeri Kelantan'),
('203217', 'Pejabat Suruhanjaya Perkhidmatan Negeri Kelantan'),
('203218', 'Jabatan Perhutanan Negeri Kelantan'),
('203219', 'Jabatan Pertanian Negeri Kelantan'),
('203220', 'Jabatan Perkhidmatan Haiwan Negeri Kelantan'),
('203221', 'Jabatan Pengairan dan Saliran Negeri Kelantan'),
('203222', 'Jabatan Perancangan Bandar dan Desa Negeri Kelantan'),
('203223', 'Jabatan Hal Ehwal Agama Islam Negeri Kelantan'),
('203224', 'Jabatan Kerja Raya Negeri Kelantan'),
('203225', 'Jabatan Mineral & Geosains Negeri Kelantan'),
('203226', 'Jabatan Air Negeri Kelantan'),
('203227', 'Mahkamah Syariah Negeri Kelantan'),
('203501', 'Perbadanan Perpustakaan Negeri Kelantan'),
('203502', 'Majlis Agama Islam & Istiadat Melayu Kelantan'),
('203503', 'Perbadanan Kemajuan Iktisad Negeri Kelantan'),
('203504', 'Perbadanan Muzium Negeri Kelantan'),
('203505', 'Perbadanan Perpustakaan Awam Negeri Kelantan'),
('203506', 'Perbadanan Stadium Kelantan'),
('203507', 'Yayasan Kelantan Darul Naim'),
('203508', 'Perbadanan Kemajuan Ekonomi Negeri (PKEN)'),
('204001', 'Pejabat Setiausaha Kerajaan Negeri Melaka'),
('204002', 'Majlis Sukan Negeri'),
('204003', 'Unit Promosi Pelancongan'),
('204004', 'Tabung Amanah Pendidikan Negeri Melaka'),
('204201', 'Jabatan Ketua Menteri Melaka'),
('204202', 'Pejabat Penasihat Undang-Undang Negeri Melaka'),
('204203', 'Jabatan Kewangan dan Perbendaharaan Negeri Melaka'),
('204204', 'Pejabat Mufti Negeri Melaka'),
('204205', 'Mahkamah Tinggi Syariah Melaka'),
('204206', 'Pejabat Tanah dan Galian Negeri Melaka'),
('204207', 'Jabatan Kerja Raya Melaka'),
('204208', 'Pejabat Pembangunan Negeri Melaka'),
('204209', 'Pejabat Pertanian Negeri Melaka'),
('204210', 'Jabatan Agama Islam Negeri Melaka'),
('204211', 'Jabatan Kebajikan Masyarakat Negeri Melaka'),
('204212', 'Jabatan Perkhidmatan Haiwan Negeri Melaka'),
('204213', 'Jabatan Perancangan Bandar dan Desa Melaka'),
('204214', 'Jabatan Pengairan dan Saliran Negeri Melaka'),
('204215', 'Pejabat Tuan Terutama Yang Dipertua Negeri Melaka'),
('204216', 'Pejabat Hutan Negeri'),
('204217', 'Pejabat Daerah dan Tanah Melaka Tengah'),
('204218', 'Pejabat Daerah dan Tanah Alor Gajah'),
('204219', 'Pajabat Daerah dan Tanah Jasin'),
('204501', 'Perbadanan Kemajuan Negeri Melaka (PKNM)'),
('204502', 'Perbadanan Air Melaka (PAM)'),
('204503', 'Perbadanan Kemajuan Tanah Adat Melaka (PERTAM)'),
('204504', 'Yayasan Melaka'),
('204505', 'Perbadanan Muzium Melaka (PERZIM)'),
('204506', 'Kolej Islam Melaka (KIM)'),
('204507', 'Perbadanan Perpustakaan Awam Negeri Melaka (PERPUSTAM)'),
('204508', 'Majlis Agama Islam Melaka (MAIM)'),
('204509', 'Lembaga Wakaf, Zakat & Baitulmal Melaka'),
('204510', 'Institut Teknologi Seni Malaysia (ITSM)'),
('204511', 'Institut Pengurusan Melaka (IMM)'),
('204512', 'Institut Kajian Sejarah dan Patriotisme Malaysia (IKSEP)'),
('204513', 'Perbadanan Kemajuan Ekomoni Negeri (PKEN)'),
('205001', 'Pejabat Menteri Besar'),
('205002', 'Pejabat Setiausaha Kerajaan Negeri'),
('205201', 'Pejabat Kewangan Negeri'),
('205202', 'Jabatan Mufti'),
('205203', 'Jabatan Kehakiman Syariah'),
('205204', 'Pejabat Tanah dan Galian Negeri'),
('205205', 'Jabatan Pengairan & Saliran'),
('205206', 'Jabatan Kerja Raya Negeri Sembilan'),
('205207', 'Pejabat Pembangunan Negeri'),
('205208', 'Jabatan Bekalan Air'),
('205209', 'Jabatan Perhutanan'),
('205210', 'Jabatan Pertanian'),
('205211', 'Jabatan Perkhidmatan Haiwan'),
('205212', 'Jabatan Perancangan Bandar dan Desa'),
('205213', 'Jabatan Hal Ehwal Agama Islam'),
('205214', 'Jabatan Kebajikan Masyarakat'),
('205215', 'Pejabat Yang DiPertuan Besar Negeri Sembilan'),
('205216', 'Pejabat Daerah dan Tanah Seremban'),
('205217', 'Pejabat Daerah dan Tanah Kuala Pilah'),
('205218', 'Pejabat Daerah dan Tanah Tampin'),
('205219', 'Pejabat Daerah Kecil Gemas'),
('205220', 'Pejabat Daerah dan Tanah Jempol'),
('205221', 'Pejabat Daerah dan Tanah Port Dickson'),
('205222', 'Pejabat Daerah dan Tanah Jelebu'),
('205223', 'Pejabat Daerah dan Tanah Rembau'),
('205501', 'Yayasan Negeri Sembilan'),
('205502', 'Perbadanan Kemajuan Negeri Sembilan'),
('205503', 'Majlis Agama Islam Negeri Sembilan'),
('205504', 'Perbadanan Perpustakaan Awam Negeri Sembilan'),
('205505', 'Lembaga Muzium Negeri Sembilan'),
('205506', 'Perbadanan Kemajuan Ekonomi Negeri (PKEN)'),
('206001', 'Pejabat Menteri Besar'),
('206002', 'Pejabat Setiausaha Kerajaan Negeri'),
('206201', 'Pejabat Mufti Negeri Pahang'),
('206202', 'Jabatan Kehakiman Syariah Negeri Pahang'),
('206203', 'Pejabat Kewangan dan Perbendaharaan Negeri Pahang'),
('206204', 'Jabatan Kerja Raya Negeri Pahang'),
('206205', 'Pejabat Tanah dan Galian Negeri Pahang'),
('206206', 'Pejabat Perhutanan Negeri Pahang'),
('206207', 'Pejabat Pertanian Negeri Pahang'),
('206208', 'Jabatan Pengairan Dan Saliran Negeri Pahang'),
('206209', 'Pejabat Galian Negeri Pahang'),
('206210', 'Pejabat Perancang Bandar dan Desa Negeri Pahang'),
('206211', 'Jabatan Perkhidmatan Haiwan Negeri Pahang'),
('206212', 'Jabatan Hal Ehwal Agama Islam Negeri Pahang'),
('206213', 'Jabatan Bekalan Air Negeri Pahang'),
('206214', 'Jabatan Kebajikan Masyarakat Negeri Pahang'),
('206215', 'Pejabat KDYMM Sultan Pahang'),
('206216', 'Suruhanjaya Perkhidmatan Awam Negeri Pahang'),
('206217', 'Pejabat Tanah dan Daerah Kuantan'),
('206218', 'Pejabat Tanah dan Daerah Temerloh'),
('206219', 'Pejabat Tanah dan Daerah Bentong'),
('206220', 'Pejabat Tanah dan Daerah Lipis'),
('206221', 'Pejabat Tanah dan Daerah Raub'),
('206222', 'Pejabat Tanah dan Daerah Jerantut'),
('206223', 'Pejabat Tanah dan Daerah Pekan'),
('206224', 'Pejabat Tanah dan Daerah Maran'),
('206225', 'Pejabat Tanah dan Daerah Rompin'),
('206226', 'Pejabat Tanah dan Daerah Cameron Highlands'),
('206227', 'Pejabat Tanah dan Daerah Bera'),
('206501', 'Perbadanan Kemajuan Negeri Pahang'),
('206502', 'Lembaga Kemajuan Perusahaan Pertanian Negeri Pahang'),
('206503', 'Yayasan Pahang'),
('206504', 'Perbadanan Kemajuan Bukit Fraser'),
('206505', 'Majlis Agama Islam dan Adat Resam Melayu Negeri Pahang'),
('206506', 'Perbadanan Perpustakaan Awam Negeri Pahang'),
('206507', 'Lembaga Muzium Negeri Pahang'),
('206508', 'Perbadanan Stadium Darul Makmur'),
('206509', 'Kolej Islam Pahang'),
('206510', 'Lembaga Kemajuan Wilayah Jengka'),
('206511', 'Amanah Saham Pahang'),
('206512', 'Yayasan Basmi Kemiskinan Pahang'),
('206513', 'Pusat Pembangunan dan Kemahiran Pahang'),
('206514', 'Lembaga Pembangunan Tioman'),
('206515', 'Perbadanan Kemajuan Ekonomi Negeri (PKEN)'),
('207001', 'Pejabat Setiausaha Kerajaan Negeri'),
('207201', 'Jabatan Kewangan Negeri Pulau Pinang'),
('207202', 'Jabatan Kerja Raya Negeri Pulau Pinang'),
('207203', 'Jabatan Pengairan dan Saliran Negeri Pulau Pinang'),
('207204', 'Jabatan Bekalan Air Negeri Pulau Pinang'),
('207205', 'Jabatan Kehakiman Syariah Negeri Pulau Pinang'),
('207206', 'Pejabat Tanah dan Galian Negeri Pulau Pinang'),
('207207', 'Pejabat Mufti Negeri Pulau Pinang'),
('207208', 'Jabatan Hal Ehwal Agama Negeri Pulau Pinang'),
('207209', 'Pejabat Daerah Seberang Perai Tengah'),
('207210', 'Pejabat Daerah Seberang Perai Utara'),
('207211', 'Pejabat Daerah Seberang Perai Selatan'),
('207212', 'Pejabat Daerah Timur Laut'),
('207213', 'Pejabat Daerah Barat Daya'),
('207214', 'Jabatan Perancangan Bandar dan Desa Negeri Pulau Pinang'),
('207215', 'Jabatan Kebajikan Masyarakat Negeri Pulau Pinang'),
('207216', 'Jabatan Pertanian Negeri Pulau Pinang'),
('207217', 'Jabatan Perkhidmatan Veterinar Negeri Pulau Pinang '),
('207218', 'Pejabat Taman Dan Kebun Bunga Negeri Pulau Pinang'),
('207219', 'Jabatan Kedai-Kedai Tuak Negeri Pulau Pinang'),
('207220', 'Jabatan Perhutanan Negeri Pulau Pinang'),
('207221', 'Pejabat Tuan Yang Terutama Yang DiPertua Negeri Pulau Pinang'),
('207501', 'Perbadanan Pembangunan Pulau Pinang'),
('207502', 'Perbadanan Perpustakaan Awam'),
('207503', 'Lembaga Muzium Negeri'),
('207504', 'Majlis Agama Islam Pulau Pinang'),
('207505', 'Perbadanan Kemajuan Ekonomi Negeri (PKEN)'),
('208001', 'Pejabat DYMM Sultan Perak '),
('208002', 'Pejabat YAB Menteri Besar'),
('208003', 'Pejabat Setiausaha Kerajaan Negeri'),
('208201', 'Pejabat Penasihat Undang-Undang Negeri'),
('208202', 'Pejabat Kewangan Negeri Perak'),
('208203', 'Perbendaharaan Negeri Perak'),
('208204', 'Pejabat Pembangunan Negeri Perak'),
('208205', 'Pejabat Pengarah Keselamatan Negara, Negeri Perak'),
('208206', 'Pejabat Pengarah, Tanah dan Galian Perak'),
('208207', 'Jabatan Agama Islam Perak'),
('208208', 'Pejabat Mufti Negeri Perak'),
('208209', 'Jabatan Kehakiman Syariah Negeri Perak'),
('208210', 'Jabatan Kerja Raya, Perak'),
('208211', 'Suruhanjaya Perkhidmatan Awam, Perak'),
('208212', 'Jabatan Perhutanan Negeri Perak'),
('208213', 'Jabatan Pengairan dan Saliran Negeri Perak'),
('208214', 'Jabatan Pertanian Negeri Perak'),
('208215', 'Jabatan Perancangan Bandar dan Desa Perak'),
('208216', 'Jabatan Kebajikan Masyarakat Negeri Perak'),
('208217', 'Jabatan Perkhidmatan Haiwan Negeri Perak'),
('208218', 'Jabatan Galian Negeri Perak'),
('208219', 'Pejabat Daerah dan Tanah Kinta, Ipoh'),
('208220', 'Pejabat Daerah dan Tanah Kinta Barat, Baru Gajah'),
('208221', 'Pejabat Daerah dan Tanah Gopeng dan Kampar'),
('208222', 'Pejabat Daerah dan Tanah Batang Padang, Tapah'),
('208223', 'Pejabat Daerah dan Tanah Slim River'),
('208224', 'Pejabat Daerah dan Tanah Manjung'),
('208225', 'Pejabat Daerah dan Tanah Hilir Perak, Teluk Intan'),
('208226', 'Pejabat Daerah dan Tanah Hulu Perak, Gerik'),
('208227', 'Pejabat Daerah dan Tanah Pengkalan Hulu'),
('208228', 'Pejabat Daerah dan Tanah Daerah Kecil Lenggong'),
('208229', 'Pejabat Daerah dan Tanah Perak Tengah, Seri Iskandar'),
('208230', 'Pejabat Daerah dan Tanah Larut Matang, Taiping'),
('208231', 'Pejabat Daerah dan Tanah Selama'),
('208232', 'Pejabat Daerah dan Tanah Kuala Kangsar'),
('208233', 'Pejabat Daerah dan Tanah Daerah Kecil Sungai Siput'),
('208234', 'Pejabat Daerah dan Tanah Kampung Gajah'),
('208235', 'Pejabat Daerah dan Tanah Kerian'),
('208501', 'Perbadanan Kemajuan Ekonomi Negeri Perak (PKEN)'),
('208502', 'Perbadanan Pembangunan Pertanian Negeri Perak'),
('208503', 'Yayasan Perak'),
('208504', 'Lembaga Air Perak'),
('208505', 'Perbadanan Kemajuan Ekonomi Islam Negeri Perak '),
('208506', 'Perbadanan Perpustakaan Awam Negeri Perak'),
('208507', 'Yayasan Basmi Kemiskinan Negeri Perak'),
('208508', 'Majlis Agama Islam & Adat Melayu Perak'),
('209001', 'Pejabat Setiausaha Kerajaan Negeri'),
('209201', 'Pejabat Penasihat Undang-Undang Negeri'),
('209202', 'Pejabat Perbendaharaan Negeri Perlis'),
('209203', 'Jabatan Pengairan dan Saliran Negeri Perlis'),
('209204', 'Jabatan Kebajikan Masyarakat Negeri Perlis'),
('209205', 'Jabatan Perancangan Bandar dan Desa Negeri Perlis'),
('209206', 'Pejabat Pembangunan Negeri Perlis'),
('209207', 'Jabatan Tanah dan Galian Negeri Perlis'),
('209208', 'Jabatan Kerja Raya Negeri Perlis'),
('209209', 'Jabatan Perkhidmatan Haiwan Negeri Perlis'),
('209210', 'Jabatan Hal Ehwal Agama Islam Negeri Perlis'),
('209211', 'Jabatan Mufti Negeri Perlis'),
('209212', 'Mahkamah Syariah Negeri Perlis'),
('209213', 'Jabatan Pertanian Negeri Perlis'),
('209214', 'Jabatan Perhutanan Negeri Perlis'),
('209215', 'Pejabat DYMM Tuanku Raja Perlis'),
('209216', 'Pejabat Keselamatan Kerajaan Perlis'),
('209501', 'Yayasan Islam Negeri Perlis'),
('209502', 'Perbadanan Kemajuan Ekonomi Negeri Perlis (PKEN)'),
('209503', 'Baitulmal Negeri Perlis'),
('209504', 'Perbadanan Perpustakaan Awam Negeri Perlis'),
('209505', 'Pejabat Biro Bernama Negeri Perlis'),
('210001', 'Pejabat Setiausaha Kerajaan Negeri'),
('210201', 'Pejabat DYMM Sultan Selangor'),
('210202', 'Pejabat Kewangan Negeri'),
('210203', 'Pejabat Penasihat Undang-Undang Negeri'),
('210204', 'Pejabat Tanah dan Galian Selangor'),
('210205', 'Jabatan Perancangan Bandar dan Desa Negeri Selangor'),
('210206', 'Jabatan Agama Islam Selangor'),
('210207', 'Pejabat Mufti Negeri Selangor'),
('210208', 'Pejabat Suruhanjaya Perkhidmatan Awam Negeri Selangor'),
('210209', 'Mahkamah Tinggi Syariah Negeri Selangor'),
('210210', 'Jabatan Kerja Raya Negeri Selangor'),
('210211', 'Jabatan Perhutanan'),
('210212', 'Jabatan Pengairan dan Saliran Negeri Selangor'),
('210213', 'Jabatan Pertanian Negeri Selangor'),
('210214', 'Jabatan Kebajikan Masyarakat Negeri Selangor'),
('210215', 'Jabatan Perkhidmatan Haiwan Negeri Selangor'),
('210216', 'Jabatan Bekalan Air Selangor'),
('210217', 'Jabatan Perikanan Negeri Selangor'),
('210218', 'Pejabat Daerah dan Tanah Klang'),
('210219', 'Pejabat Daerah dan Tanah Petaling'),
('210220', 'Pejabat Daerah dan Tanah Kuala Langat'),
('210221', 'Pejabat Daerah dan Tanah Hulu Langat'),
('210222', 'Pejabat Daerah dan Tanah Gombak'),
('210223', 'Pejabat Daerah dan Tanah Hulu Selangor'),
('210224', 'Pejabat Daerah dan Tanah Sepang'),
('210225', 'Pejabat Daerah dan Tanah Sabak Bernam'),
('210501', 'Perbadanan Kemajuan Negeri Selangor (PKNS)'),
('210502', 'Perbadanan Kemajuan Pertanian Negeri Selangor (PKPS)'),
('210503', 'Perbadanan Muzium Negeri Selangor'),
('210504', 'Perbadanan Perpustakaan Negeri Selangor'),
('210505', 'Majlis Sukan Negeri (MSN)'),
('210506', 'Lembaga Urus Air Selangor (LUAS)'),
('210507', 'Majlis Agama Islam Negeri Selangor (MAIS)'),
('210508', 'Perbadanan Kemajuan Ekonomi Negeri (PKEN)'),
('211001', 'Pejabat Menteri Besar'),
('211002', 'Pejabat Setiausaha Kerajaan Terengganu'),
('211003', 'Pejabat Setiausaha Sulit DYMM Sultan Terengganu'),
('211201', 'Pejabat Penasihat Undang-Undang Negeri'),
('211202', 'Pejabat Kewangan Negeri'),
('211203', 'Pejabat Pengarah Tanah dan Galian'),
('211204', 'Pejabat Perancang Bandar dan Desa'),
('211205', 'Pejabat Akauntan Negeri'),
('211206', 'Jabatan Hal Ehwal Agama'),
('211207', 'Jabatan Kehakiman Syariah'),
('211208', 'Jabatan Kerja Raya'),
('211209', 'Jabatan Pengairan dan Saliran'),
('211210', 'Jabatan Pertanian'),
('211211', 'Jabatan Perhutanan'),
('211212', 'Jabatan Perkhidmatan Haiwan'),
('211213', 'Jabatan Kebajikan Masyarakat'),
('211214', 'Jabatan Mufti'),
('211215', 'Jabatan Bekalan Air (Kawalselia)'),
('211216', 'Suruhanjaya Perkhidmatan Negeri'),
('211217', 'Jabatan Galian Negeri'),
('211218', 'Pejabat Daerah dan Tanah Kuala Terengganu'),
('211219', 'Pejabat Daerah dan Tanah Besut'),
('211220', 'Pejabat Daerah dan Tanah Setiu'),
('211221', 'Pejabat Daerah dan Tanah Hulu Terengganu'),
('211222', 'Pejabat Daerah dan Tanah Dungun'),
('211223', 'Pejabat Daerah dan Tanah Kemaman'),
('211224', 'Pejabat Daerah dan Tanah Marang'),
('211501', 'Kolej Agama Sultan Zainal Abidin'),
('211502', 'Lembaga Muzium Negeri'),
('211503', 'Majlis Agama Islam Dan Adat Istiadat Melayu Terengganu'),
('211504', 'Perbadanan Memajukan Iktisad Negeri Terengganu'),
('211505', 'Perbadanan Perpustakaan Awam Terengganu'),
('211506', 'Yayasan Islam Terengganu'),
('211507', 'Yayasan Terengganu'),
('211508', 'Yayasan Pembangunan Usahawam'),
('211509', 'Yayasan Pembangunan Keluarga'),
('211510', 'Perbadanan Kemajuan Ekonomi Negeri (PKEN)'),
('361001', 'Pejabat Ketua Menteri Sabah'),
('361002', 'Unit Pemimpin Kemajuan Rakyat Negeri Sabah'),
('361003', 'Unit Pendidikan Negeri Sabah'),
('361004', 'Unit Pengesanan Projek Negeri Sabah'),
('361005', 'Unit Perancang Ekonomi Negeri'),
('361201', 'Jabatan Arkib Negeri Sabah'),
('361202', 'Jabatan Peguam Besar Negeri Sabah'),
('361203', 'Jabatan Cetak Kerajaan Sabah'),
('361204', 'Jabatan Perkhidmatan Awam Negeri Sabah'),
('361205', 'Jabatan Tanah & Ukur Negeri Sabah'),
('361206', 'Jabatan Perhutanan Sabah'),
('361207', 'Jabatan Hal Ehwal Agama Islam Negeri Sabah'),
('361208', 'Jabatan Kehakiman Syariah Negeri'),
('361301', 'Dewan Bandaraya Kota Kinabalu'),
('361501', 'Majlis Ugama Islam Negeri Sabah (MUIS)'),
('361502', 'Yayasan Sabah'),
('362001', 'Pejabat Kementerian Pembangunan Luar Bandar Sabah'),
('362201', 'Pejabat Daerah Penampang'),
('362202', 'Pejabat Daerah Papar'),
('362203', 'Pejabat Daerah Tuaran'),
('362204', 'Pejabat Daerah Kota Belud'),
('362205', 'Pejabat Daerah Ranau'),
('362206', 'Pejabat Daerah Kudat'),
('362207', 'Pejabat Daerah Kota Marudu'),
('362208', 'Pejabat Daerah Pitas'),
('362209', 'Pejabat Daerah Keningau'),
('362210', 'Pejabat Daerah Tambunan'),
('362211', 'Pejabat Daerah Nabawan'),
('362212', 'Pejabat Daerah Sipitang'),
('362213', 'Pejabat Daerah Tenom'),
('362214', 'Pejabat Daerah Beaufort'),
('362215', 'Pejabat Daerah Kuala Penyu'),
('362216', 'Pejabat Daerah Kinabatangan'),
('362217', 'Pejabat Daerah Beluran'),
('362218', 'Pejabat Daerah Semporna'),
('362219', 'Pejabat Daerah Lahad Datu'),
('362220', 'Pejabat Daerah Kunak'),
('362221', 'Pejabat Daerah Tongod'),
('362222', 'Pejabat Daerah Kecil Putatan'),
('362223', 'Pejabat Daerah Kecil Telupid'),
('362224', 'Pejabat Daerah Kecil Banggi'),
('362225', 'Pejabat Daerah Kecil Tamparuli'),
('362226', 'Pejabat Daerah Kecil Menumbok'),
('362227', 'Pejabat Daerah Kecil Membakut'),
('362228', 'Pejabat Daerah Kecil Matunggong'),
('362229', 'Pejabat Daerah Kecil Sook'),
('362230', 'Pejabat Daerah Kecil Kemabong'),
('363001', 'Pejabat Kementerian Kewangan Sabah'),
('363201', 'Jabatan Bendahari Negeri Sabah'),
('363202', 'Jabatan Perkhidmatan Komputer Negeri'),
('363501', 'Perbadanan Pinjaman Sabah'),
('364001', 'Pejabat Kementerian Pembangunan Luar Bandar Sabah'),
('364201', 'Jabatan Perikanan Sabah'),
('364202', 'Jabatan Perkhidmatan Haiwan dan Perusahaan Ternak Sabah'),
('364203', 'Jabatan Pengairan dan Saliran Sabah'),
('364204', 'Jabatan Pertanian Sabah'),
('364501', 'Lembaga Tabung Getah Sabah'),
('364502', 'Koperasi Pembangunan Desa (KPD)'),
('364503', 'Koperasi Kemajuan Perikanan dan Nelayan Sabah (KO-Nelayan)'),
('365001', 'Pejabat Kementerian Infrastruktur Sabah'),
('365201', 'Jabatan Air negeri Sabah'),
('365202', 'Jabatan Kerja Raya Sabah'),
('365203', 'Jabatan Keretapi Negeri Sabah'),
('365204', 'Jabatan Pelabuhan dan Dermaga Sabah'),
('365501', 'Lembaga Pelabuhan-Pelabuhan Sabah'),
('366001', 'Pejabat Kementerian Kerajaan Tempatan dan Perumahan Sabah'),
('366201', 'Jabatan Perancangan Bandar dan Wilayah Sabah'),
('366202', 'Pejabat Hal Ehwal Anak Negeri Sabah'),
('366301', 'Majlis Perbandaran Sandakan'),
('366302', 'Majlis Perbandaran Tawau'),
('366303', 'Lembaga Bandaran Kudat'),
('366304', 'Majlis Daerah Beaufort'),
('366305', 'Majlis Daerah Beluran'),
('366306', 'Majlis Daerah Keningau'),
('366307', 'Majlis Daerah Kinbatangan'),
('366308', 'Majlis Daerah Kota Belud'),
('366309', 'Majlis Daerah Kota Marudu'),
('366310', 'Majlis Daerah Kuala Penyu'),
('366311', 'Majlis Daerah Kunak'),
('366312', 'Majlis Daerah Lahad Datu'),
('366313', 'Majlis Daerah Nabawan'),
('366314', 'Majlis Daerah Papar'),
('366315', 'Majlis Daerah Penampang'),
('366316', 'Majlis Daerah Ranau'),
('366317', 'Majlis Daerah Semporna'),
('366318', 'Majlis Daerah Sipitang'),
('366319', 'Majlis Daerah Tambunan'),
('366320', 'Majlis Daerah Tenom'),
('366321', 'Majlis Daerah Tuaran'),
('366501', 'Lembaga Pembangunan Perumahan dan Bandar Sabah (LPPB)'),
('366502', 'Majlis Hal Ehwal Anak Negeri Sabah'),
('367001', 'Pejabat Kementerian Pembangunan Masyarakat & Hal-Ehwal Pengguna Sabah'),
('367201', 'Jabatan Perkhidmatan Kebajikan Am Sabah'),
('367202', 'Perpustakaan Negeri Sabah'),
('367203', 'Unit Hal Ehwal Wanita Sabah'),
('373001', 'Pejabat Kementerian Pelancongan, Alam Sekitar, Sains dan Teknologi Sabah'),
('373201', 'Jabatan Hidupan Liar'),
('373202', 'Jabatan Konservasi Alam Sekitar'),
('373203', 'Unit Sains dan Teknologi'),
('373501', 'Lembaga Pemegang Amanah Taman-Taman Sabah'),
('373502', 'Perbadanan Kemajuan Pelancongan Sabah'),
('369001', 'Pejabat Kementerian Pembangunan Perindustrian Sabah'),
('369201', 'Jabatan Pembangunan Perindustrian & Penyelidikan Sabah'),
('369501', 'Jabatan Pembangunan Ekonomi Negeri Sabah (SEDCO)'),
('370001', 'Pejabat Kementerian Kebudayaan, Belia dan Sukan Sabah'),
('370201', 'Jabatan Muzium Sabah'),
('370501', 'Lembaga Sukan Negeri Kedah'),
('370502', 'Lembaga Kebudayaan Negeri Sabah'),
('374001', 'Pejabat Kementerian Pembangunan Sumber Sabah'),
('374201', 'Jabatan Pembangunan Sumber Manusia'),
('374501', 'Lembaga Kemajuan Perhutanan Negeri Sabah (SAFODA)'),
('374502', 'Lembaga Kemajuan Tanah Negeri Sabah (LKTNS)'),
('372201', 'Istana Negeri'),
('372202', 'Pejabat Dewan Undangan Negeri Sabah'),
('372203', 'Suruhanjaya Perkhidmatan Awam Negeri Sabah'),
('481001', 'Pejabat Ketua Menteri Sarawak'),
('481002', 'Pejabat Setiausaha Kerajaan Negeri/Timbalan-Timbalan Setiausaha Kerajaan Negeri'),
('481003', 'Pejabat Setiausaha Kewangan Negeri'),
('481004', 'Bahagian Audit Dalam'),
('481005', 'Unit Pengerusuan Sumber Manusia'),
('481006', 'Unit Hal Ehwal Agama'),
('481007', 'Unit Pentadbiran Am'),
('481008', 'Unit Perancangan Negeri'),
('481009', 'Unit Pelaksanaan dan Pemantauan Projek'),
('481010', 'Unit Projek Khas'),
('481011', 'Unit Residen & District Office (Pembangunan)'),
('481012', 'Unit Pembangunan Sumber Manusia & Kualiti'),
('481013', 'Majlis Mesyuarat Kerajaan Negeri (MMKN)'),
('481014', 'Unit ICT (Information Communication Technology)'),
('481201', 'Suruhanjaya Perkhidmatan Awam Negeri (SPAN)'),
('481202', 'Dewan Undangan Negeri (DUN)'),
('481203', 'Pejabat TYT'),
('481204', 'Jabatan Agama Islam (JAIS)'),
('481205', 'Mahkamah Syariah'),
('481206', 'Pejabat Mufti'),
('481207', 'Majlis Islam'),
('481208', 'Majlis Adat Istiadat'),
('481209', 'Mahkamah Istiadat'),
('481210', 'Rumah Sarawak Kuala Lumpur'),
('481501', 'Lembaga Kemajuan Bintulu Sarawak'),
('481502', 'Yayasan Sarawak'),
('481503', 'Dewan Bandaraya Kuching Utara (DBKU)'),
('482001', 'Pejabat Kementerian Kewangan dan Kemudahan Awam'),
('482201', 'Jabatan Perbendaharaan Negeri'),
('482501', 'Perbadanan Pembekalan Letrik Sarawak'),
('482502', 'Lembaga Air Sarawak'),
('482503', 'Lembaga Air Sibu'),
('483001', 'Pejabat Kementerian Pembangunan Infrastruktur & Perhubungan Sarawak'),
('483201', 'Jabatan Kerja Raya'),
('483501', 'Lembaga Sungai-Sungai Sarawak'),
('483502', 'Perbadanan Urusan Kejuruteraan dan Limbongan Brooke'),
('483503', 'Lembaga Pelabuhan Kuching'),
('483504', 'Lembaga Pelabuhan Rajang'),
('483505', 'Lembaga Pelabuhan Miri'),
('484001', 'Pejabat Kementerian Perancangan dan Pengurusan Sumber Sarawak'),
('484201', 'Jabatan Hutan'),
('484202', 'Jabatan Tanah & Servei'),
('484501', 'Lembaga Pembangunan & Lindungan Tanah Sarawak'),
('484502', 'Perbadanan Perusahaan Kayu Sarawak'),
('484503', 'lembaga Sumber Asli & Persekitaran'),
('485001', 'Pejabat Kementerian Pertanian & Industri Makanan Sarawak'),
('485201', 'Jabatan Pertanian Sarawak'),
('493001', 'Pejabat Kementerian Pembangunan Sosial & Urbanisasi '),
('493201', 'Jabatan Muzium Sarawak'),
('493202', 'Jabatan Kebajikan Masyarakat Negeri'),
('493501', 'Perbadanan Stadium Negeri Sarawak (Sarawak Stadium Corporation)'),
('487001', 'Pejabat Kementerian Alam Sekitar dan Kesihatan Awam Sarawak'),
('487301', 'Majlis Bandaraya Kuching Selatan (MBKS)'),
('487302', 'Majlis Perbandaran Padawan'),
('487303', 'Majlis Perbandaran Sibu'),
('487304', 'Majlis Perbandaran Miri'),
('487305', 'Majlis Daerah Bau'),
('487306', 'Majlis Daerah Betong'),
('487307', 'Majlis Daerah Dalat dan Mukah'),
('487308', 'Majlis Daerah Kanowit'),
('487309', 'Majlis Daerah Kapit'),
('487310', 'Majlis Daerah Lawas'),
('487311', 'Majlis Daerah Limbang'),
('487312', 'Majlis Daerah Lubok Antu'),
('487313', 'Majlis Daerah Lundu'),
('487314', 'Majlis Daerah Maradong dan Julau'),
('487315', 'Majlis Daerah Marudi'),
('487316', 'Majlis Daerah Matu dan Daro'),
('487317', 'Majlis Daerah Saratok'),
('487318', 'Majlis Daerah Samarahan'),
('487319', 'Majlis Daerah Serian'),
('487320', 'Majlis Daerah Sarikei'),
('487321', 'Majlis Daerah Simunjan'),
('487322', 'Majlis Daerah Sri Aman'),
('487323', 'Majlis Daerah Subis'),
('487324', 'Majlis Daerah Luar Bandar Sibu'),
('488001', 'Pejabat Kementerian Perumahan Sarawak'),
('488501', 'Suruhanjaya Perumahan & Pembangunan Sarawak'),
('489001', 'Pejabat Kementerian Pembangunan Luar Bandar dan Kemajuan Tanah Sarawak'),
('489201', 'Jabatan Pengairan & Saliran'),
('489501', 'Lembaga Penyatuan dan Pemulihan Tanah Sarawak (Sarawak Land Consolidation & Rehabilation Authority'),
('490001', 'Pejabat Kementerian Pembangunan Perindustrian Sarawak'),
('490501', 'Perbadanan Pembangunan Ekonomi Sarawak (Sarawak Economic Development Corporation)'),
('491001', 'Pejabat Kementerian Pelancongan Sarawak'),
('491501', 'Lembaga Pelancongan Sarawak Sarawak (Sarawak Economic Development Corporation)'),
('142401', 'Majlis Amanah Rakyat (MARA)'),
('143401', 'Lembaga Penduduk dan Pembangunan Keluarga Negara (LPPKN)'),
('141106', 'Jabatan Alam Sekitar (JAS)');
INSERT INTO `ruj_jabatan` (`KOD_JABATAN`, `KET_JABATAN`) VALUES
('141105', 'Jabatan Perhutanan Semenanjung Malaysia(JPSM)'),
('141012', 'Pusat Infrastruktur Data Geospatial Negara (MaCGDI)'),
('141013', 'Projek E-Tanah'),
('141107', 'Jabatan Perlindungan Hidupan Liar dan Taman-Taman Negara (Perhilitan)'),
('141108', 'Jabatan Pengairan Dan Saliran'),
('141109', 'Institut Penyelidikan Perhutanan Malaysia (FRIM)'),
('141110', 'Institut Penyelidikan Hidraulik Kebangsaan Malaysia (NAHRIM)'),
('130104', 'Lembaga Penapisan Filem '),
('131001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('131002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('131003', 'Bahagian Keselamatan & Ketenteraan Awam'),
('131004', 'Bahagian Pentadbiran'),
('131005', 'Bahagian Kewangan, Bekalan dan Pembangunan'),
('131006', 'Bahagian Akauntan Kanan Perbendaharaan'),
('131007', 'Bahagian Penyelidikan & Perancangan'),
('131008', 'Bahagian Peguam Kanan Persekutuan'),
('131009', 'Bahagian Audit Dalam'),
('131105', 'Suruhanjaya Pasukan Polis'),
('103411', 'Danaharta Nasional '),
('105401', 'Lembaga Lebuhraya Malaysia (LLM) '),
('105402', 'Lembaga Pembangunan Perindustrian Malaysia (CIDB)'),
('133402', 'Suruhanjaya Tenaga  '),
('108406', 'Lembaga Kemajuan Perkhidmatan Perindustrian Malaysia (MISDA)'),
('110018', 'Bahagian Hal ehwal Korporat  '),
('110019', 'Bahagian Dasar dan Perancangan  '),
('110020', 'Bahagian Pembangunan Perniagaan '),
('110101', 'Suruhanjaya Syarikat Malaysia'),
('110401', 'Perbadanan Harta Intelek Malaysia'),
('137402', 'Kompleks Istana Budaya '),
('137001', 'Pejabat Y.B. Menteri / Pejabat Y.B. Timbalan Menteri/Setiausaha Parlimen '),
('137002', 'Pejabat Ketua Setiausaha Kementerian / Timbalan KSU Kementerian'),
('137003', 'Bahagian Teknologi Maklumat'),
('137004', 'Bahagian Pembangunan'),
('137005', 'Bahagian Penguatkuasaan'),
('137006', 'Bahagian Pengurusan'),
('139403', 'Perbadanan Pembangunan Multimedia (MDC)  '),
('139404', 'Perbadanan Pembangunan Teknologi Malaysia (MTDC)  '),
('139405', 'Lembaga Perlesenan Tenaga Atom (AELB)'),
('139406', 'Secretariat National Informatiom Technology Council (NITC) '),
('116013', 'Bahagian Perancangan '),
('116014', 'Bahagian Pembangunan'),
('116015', 'Bahagian Skim Pinjaman Perumahan'),
('116107', 'Tribunal Tuntutan Pembeli Rumah'),
('116108', 'MAHSURI'),
('117401', 'Lembaga Tabung Angkatan Tentera '),
('140014', 'Bahagian Pentadbiran Am'),
('140015', 'Bahagian Pemantauan dan Inspektorat'),
('140016', 'Bahagian Teknologi Maklumat dan InfoDesa'),
('140017', 'Unit Khidmat Teknikal  '),
('140407', 'FELCRA'),
('140408', 'Lembaga Kemajuan Tanah Sarawak'),
('140409', 'Lembaga Kemajuan Bintulu'),
('140410', 'Lembaga Penyatuan dan Pemulihan Tanah Sarawak (SALCRA)'),
('119011', 'Jabatan Hal Ehwal Pelbagai Hala  '),
('119012', 'Pusat Serantau Asia Tenggara bagi Mencegah Keganasan (SEARCCT)  '),
('141007', 'Bahagian Tanah Ukur dan Pemetaan'),
('141008', 'Bahagian Mineral dan Geosains'),
('141009', 'Bahagian Perhutanan'),
('141010', 'Bahagian Pengairan dan Saliran'),
('141011', 'Bahagian Pemuliharaan dan Pengurusan Alam Sekitar dan Taman Laut'),
('142016', 'Unit Koperasi'),
('142017', 'Bahagian Sumber Manusia'),
('142101', 'Jabatan Pembangunan Koperasi'),
('142403', 'Perbadanan Kemajuan Ekonomi Negeri-Negeri (PKEN)'),
('142404', 'Maktab Kerjasama Malaysia (MKM)'),
('142405', 'Bank Kerjasama Rakyat Malaysia'),
('127001', 'Pejabat Y.B Menteri/Timbalan Menteri//Setiausaha Parlimen'),
('127002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('127101', 'Bahagian Kemajuan Wilayah Persekutuan dan Urusetia Perancangan Lembah Kelang'),
('127102', 'Hal Ehwal Kepulauan (Outer Islands)'),
('127301', 'Dewan Bandaraya Kuala Lumpur (DBKL)'),
('127401', 'Perbadanan Labuan'),
('127402', 'Perbadanan Putrajaya '),
('137404', 'Perpustakaan Negara Malaysia'),
('136001', 'Pejabat Y.B Menteri/Timbalan Menteri/Setiausaha Parlimen'),
('136002', 'Pejabat Ketua Setiausaha Kementerian/Timbalan KSU Kementerian'),
('136016', 'Penasihat Undang-Undang'),
('136004', 'Unit Audit Dalam'),
('136011', 'Bahagian Penyelarasan Dasar'),
('136005', 'Bahagian Khidmat Pengurusan dan Korporat'),
('136102', 'Perbadanan Tabung Pendidikan Tinggi Nasional'),
('136103', 'Yayasan Tunku Abdul Rahman'),
('103018', 'Bahagian Kawalan & Pemantauan'),
('135112', 'Jabatan Pelajaran Swasta'),
('101403', 'Lembaga Kemajuan Tanah Persekutuan (FELDA)'),
('101122', 'Jabatan Setiausaha Persekutuan Sabah'),
('101123', 'Jabatan Setiausaha Persekutuan Sarawak'),
('101135', 'Jabatan Agama Islam Wilayah Persekutuan'),
('101136', 'Jabatan Zakat, Wakaf dan Urusan Haji'),
('101137', 'Jabatan Kemajuan Islam Malaysia'),
('101138', 'Jabatan Perpaduan Negara dan Integrasi Nasional'),
('101139', 'Tim Nukleus Agensi Penguatkuasaan Maritim Malaysia'),
('101140', 'Suruhanjaya Hak Asasi Manusia'),
('103105', 'Bursa Malaysia'),
('104015', 'Bahagian Korporat/Antarabangsa'),
('104106', 'Jabatan Keretapi (kawalselia)'),
('105014', 'Bahagian Kawalselia dan Penyenggaraan'),
('105015', 'Bahagian Kewangan'),
('105016', 'Bahagian Akaun'),
('105017', 'Bahagian Pengurusan dan Perancangan Korporat'),
('105018', 'Cawangan Pengurusan Pentadbiran'),
('112017', 'Bahagian Perancangan Dasar dan Penyelidikan'),
('112018', 'Pusat Pengurusan Maklumat Strategik'),
('112019', 'Bahagian Antarabangsa'),
('112020', 'Bahagian Khidmat Pengurusan'),
('112021', 'Pusat Sumber'),
('112022', 'Bahagian Kewangan'),
('112023', 'Bahagian Pengurusan Sumber Manusia'),
('114009', 'Bahagian Pentadbiran'),
('114010', 'Bahagian Pembangunan Sumber Manusia'),
('114011', 'Bahagian Kewangan'),
('114012', 'Bahagian Kawalselia dan Penguatkuasaan'),
('114013', 'Bahagian Dasar Perburuhan'),
('114014', 'Bahagian Dasar Sumber Manusai'),
('114015', 'Bahagian Teknologi Maklumat'),
('114016', 'Cawangan Antarabangsa'),
('117020', 'Bahagian Pengurusan Sumber Manusia'),
('117021', 'Bahagian Perisikan Pertahanan'),
('132014', 'Bahagian Pengurusan Sumber Manusia'),
('132015', 'Bahagian Perusahaan Perladangan'),
('133009', 'Bahagian Khidmat Pengurusan'),
('133010', 'Bahagian Komunikasi'),
('133011', 'Bahagian Air'),
('133013', 'Unit Implementasi Projek'),
('133103', 'Jabatan Perkhidmatan Pembentungan'),
('133104', 'Cawangan Bekalan Air'),
('134007', 'Bahagian Pemantauan dan Penilaian Projek'),
('134008', 'Pusat Latihan Pertanian Negara'),
('134009', 'Bahagian Industri Padi dan Beras'),
('134010', 'Bahagian Industri Tanaman, Ternakan dan Perikanan'),
('134011', 'Bahagian Khidmat Sokongan dan Pembangunan Industri'),
('134012', 'Bahagian Perancangan Strategik dan Antarabangsa'),
('134013', 'Bahagian Teknologi Maklumat'),
('134014', 'Bahagian Penggalakkan Pelaburan Pembangunan Perniagaan dan Penswastaan'),
('134015', 'Bahagian Khidmat Pengurusan'),
('137105', 'Jabatan Antikuiti'),
('139014', 'Unit Teknologi Maklumat'),
('139015', 'Direktorat Oseanografi Kebangsaan'),
('139016', 'Direktorat Bioteknologi Kebangsaan'),
('134409', 'Lembaga Perindustrian Nanas Malaysia '),
('101006', 'Pejabat Timbalan Ketua Setiausaha Kabinet'),
('101007', 'Pejabat Timbalan Ketua Setiausaha'),
('101010', 'Urus Setia Jawatankuasa Kerja Tanah Wilayah Persekutuan'),
('101011', 'Pejabat Tanah dan Galian Wilayah Persekutuan Putrajaya'),
('101012', 'Bahagian Pentadbiran dan Kewangan'),
('101013', 'Bahagian Pengurusan Perkhidmatan dan Sumber Manusia'),
('101014', 'Unit Kawal Selia FELDA'),
('101015', 'Bahagian Hal-Ehwal Kabinet'),
('101016', 'Bahagian Perlembagaan dan Perhubungan Antara Kerajaan'),
('101017', 'Bahagian Kabinet, Perlembagaan dan Perhubungan Antara Kerajaan'),
('101124', 'Bahagian Istiadat dan Urus Setia Antarabangsa'),
('101125', 'Bahagian Pengurusan Hartanah'),
('101126', 'Biro Pengaduan Awam'),
('101127', 'Biro Tatanegara'),
('101128', 'Institut Latihan Kehakiman dan Perundangan (ILKAP)'),
('101129', 'Pejabat Mufti Wilayah Persekutuan'),
('101130', 'Jabatan Kehakiman Syariah Malaysia (JKSM)'),
('101131', 'Pejabat Ketua Pegawai Keselamatan Kerajaan'),
('101132', 'Mahkamah Syariah Wilayah Persekutuan'),
('101005', 'Pejabat Ketua Setiausaha Kanan'),
('136013', 'Bahagian Pembangunan Manusia dan Latihan'),
('136014', 'Bahagian Teknologi Maklumat'),
('136015', 'Bahagian Perancangan dan Penyelidikan'),
('136017', 'Jabatan Pengurusan IPT'),
('136006', 'Bahagian Biasiswa'),
('136007', 'Bahagian Pengurusan Sumber Manusia'),
('136009', 'Bahagian Kewangan'),
('136010', 'Bahagian Pembangunan'),
('136101', 'Lembaga Akreditasi Negara'),
('136018', 'Jabatan Pengajian Politeknik dan Kolej Komuniti'),
('136401', 'Universiti Malaya'),
('136402', 'Universiti Kebangsaan Malaysia'),
('136403', 'Universiti Sains Malaysia'),
('136404', 'Universiti Teknologi Malaysia'),
('136405', 'Universiti Putra Malaysia'),
('136406', 'Universiti Islam Antarabangsa'),
('136407', 'Universiti Utara Malaysia'),
('136408', 'Universiti Malaysia Sabah'),
('136409', 'Universiti Malaysia Sarawak'),
('136410', 'Universiti Pendidikan Sultan Idris'),
('136411', 'Universiti Teknologi MARA'),
('136412', 'Universiti Darul Iman'),
('136413', 'Kolej Universiti Sains dan Teknologi Malaysia'),
('136414', 'Kolej Universiti Tun Hussein Onn'),
('136415', 'Kolej Universiti Teknikal Kebangsaan'),
('136416', 'Kolej Universiti Islam Malaysia'),
('136417', 'Kolej Universiti Kejuruteraan dan Teknologi Malaysia'),
('136418', 'Kolej Universiti Kejuruteraan Utara Malaysia'),
('101115', 'Unit Pemodenan Tadbiran & Perancangan Pengurusan Malaysia (MAMPU)'),
('103412', 'Busa Deratif Malaysia'),
('103413', 'Lembaga Kemajuan Pahang Tenggara'),
('103414', 'Lembaga Kemajuan Pulau Pinang'),
('103415', 'Lembaga Letrik Sabah'),
('101141', 'Agensi Penguatkuasaan Maritim Malaysia'),
('103416', 'Lembaga Kemajuan Tanah Sabah'),
('137405', 'Perbadanan Kemajuan Kraftangan Malaysia (bermula Mei 2004)'),
('114406', 'Perbadanan Tabung Pembangunan Kemahiran'),
('123123', 'Hospital Putrajaya'),
('143104', 'NAM Institute For The Empowerment of Women (NIEW)');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_jantina`
--

CREATE TABLE IF NOT EXISTS `ruj_jantina` (
  `KOD_JANTINA` varchar(10) NOT NULL,
  `KET_JANTINA` varchar(20) NOT NULL,
  PRIMARY KEY  (`KOD_JANTINA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_jantina`
--

INSERT INTO `ruj_jantina` (`KOD_JANTINA`, `KET_JANTINA`) VALUES
('01', 'Lelaki'),
('02', 'Perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_jenis_perkhidmatan`
--

CREATE TABLE IF NOT EXISTS `ruj_jenis_perkhidmatan` (
  `KOD_JENIS_PERKHIDMATAN` varchar(10) NOT NULL,
  `KET_JENIS_PERKHIDMATAN` varchar(50) NOT NULL,
  PRIMARY KEY  (`KOD_JENIS_PERKHIDMATAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_jenis_perkhidmatan`
--

INSERT INTO `ruj_jenis_perkhidmatan` (`KOD_JENIS_PERKHIDMATAN`, `KET_JENIS_PERKHIDMATAN`) VALUES
('01', 'Persekutuan'),
('02', 'Kerajaan Tempatan'),
('03', 'Negeri'),
('04', 'Badan Berkanun'),
('05', 'Swasta'),
('06', 'Lain-Lain');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_jenis_soalan`
--

CREATE TABLE IF NOT EXISTS `ruj_jenis_soalan` (
  `KOD_JENIS_SOALAN` varchar(10) NOT NULL,
  `KET_JENIS_SOALAN` varchar(100) NOT NULL,
  PRIMARY KEY  (`KOD_JENIS_SOALAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_jenis_soalan`
--

INSERT INTO `ruj_jenis_soalan` (`KOD_JENIS_SOALAN`, `KET_JENIS_SOALAN`) VALUES
('01', 'Single Choice'),
('02', 'Multiple Choice'),
('03', 'True or False'),
('04', 'Fill in the blank'),
('05', 'Ranking'),
('06', 'Subjective');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_kategori_soalan`
--

CREATE TABLE IF NOT EXISTS `ruj_kategori_soalan` (
  `KOD_KATEGORI_SOALAN` varchar(10) NOT NULL,
  `KET_KATEGORI_SOALAN` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_kategori_soalan`
--

INSERT INTO `ruj_kategori_soalan` (`KOD_KATEGORI_SOALAN`, `KET_KATEGORI_SOALAN`) VALUES
('01', 'MSC'),
('02', 'EG'),
('03', 'Hardware'),
('04', 'Software'),
('05', 'ICT Security'),
('06', 'Office Productivity Tools'),
('07', 'Internet'),
('08', 'Electronic Mail');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_kementerian`
--

CREATE TABLE IF NOT EXISTS `ruj_kementerian` (
  `KOD_KEMENTERIAN` varchar(10) NOT NULL,
  `KET_KEMENTERIAN` varchar(100) NOT NULL,
  PRIMARY KEY  (`KOD_KEMENTERIAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_kementerian`
--

INSERT INTO `ruj_kementerian` (`KOD_KEMENTERIAN`, `KET_KEMENTERIAN`) VALUES
('101', 'Jabatan Perdana Menteri'),
('103', 'Kementerian Kewangan'),
('104', 'Kementerian Pengangkutan'),
('105', 'Kementerian Kerja Raya'),
('108', 'Kementerian Perdagangan Antarabangsa Dan Industri'),
('110', 'Kementerian Perdagangan Dalam Negeri Dan Hal Ehwal Pengguna'),
('112', 'Kementerian Penerangan'),
('114', 'Kementerian Sumber Manusia'),
('116', 'Kementerian Perumahan Dan Kerajaan Tempatan'),
('117', 'Kementerian Pertahanan'),
('119', 'Kementerian Luar Negeri'),
('121', 'Kementerian Belia Dan Sukan'),
('123', 'Kementerian Kesihatan'),
('126', 'Kementerian Perusahaan Awam'),
('127', 'Kementerian Wilayah Persekutuan'),
('128', 'Kementerian Undang-Undang/Kehakiman'),
('129', 'Jabatan Yang Tiada Berkementerian'),
('130', 'Kementerian Hal Ehwal Dalam Negeri'),
('131', 'Kementerian Keselamatan Dalam Negeri'),
('132', 'Kementerian Perusahaan, Perladangan dan Komuditi'),
('133', 'Kementerian Tenaga, Air dan Komunikasi'),
('134', 'Kementerian Pertanian dan Industri Asas Tani'),
('135', 'Kementerian Pelajaran'),
('136', 'Kementerian Pengajian Tinggi'),
('137', 'Kementerian Kesenian, Kebudayaan Dan Warisan'),
('138', 'Kementerian Pelancongan'),
('139', 'Kementerian Sains, Teknologi Dan Inovasi'),
('140', 'Kementerian Kemajuan Luar Bandar dan Wilayah'),
('141', 'Kementerian Sumber Asli dan Alam Sekitar'),
('142', 'Kementerian Pembangunan Usahawan dan Koperasi'),
('143', 'Kementerian Pembangunan Wanita, Keluarga dan Masyarakat'),
('201', 'Pentadbiran Kerajaan Negeri Johor'),
('202', 'Pentadbiran Kerajaan Negeri Kedah'),
('203', 'Pentadbiran Kerajaan Negeri Kelantan'),
('204', 'Pentadbiran Kerajaan Negeri Melaka'),
('205', 'Pentadbiran Kerajaan Negeri Sembilan'),
('206', 'Pentadbiran Kerajaan Negeri Pahang'),
('207', 'Pentadbiran Kerajaan Pulau Pinang'),
('208', 'Pentadbiran Kerajaan Negeri Perak'),
('209', 'Pentadbiran Kerajaan Negeri Perlis'),
('210', 'Pentadbiran Kerajaan Negeri Selangor'),
('211', 'Pentadbiran Kerajaan Negeri Terengganu'),
('361', 'Jabatan Ketua Menteri Sabah'),
('362', 'Kementerian Pembangunan Luar Bandar Sabah'),
('363', 'Kementerian Kewangan Sabah'),
('364', 'Kementerian Pembangunan Pertanian dan Industri Pemakanan Sabah'),
('365', 'Kementerian Pembangunan Insfrastruktur Sabah'),
('366', 'Kementerian Kerajaan Tempatan dan Perumahan Sabah'),
('367', 'Kementerian Pembangunan Masyarakat & Hal-Ehwal Pengguna Sabah'),
('369', 'Kementerian Pembangunan Perindustrian Sabah'),
('370', 'Kementerian Kebudayaan, Belia dan Sukan Sabah'),
('372', 'Jabatan Sabah Yang Tiada Berkementerian'),
('373', 'Kementerian Pelancongan, Kebudayaan dan Alam Sekitar Sabah'),
('374', 'Kementerian Pembangunan Sumber dan Kemajuan Teknologi Maklumat Sabah'),
('481', 'Jabatan Ketua Menteri Sarawak'),
('482', 'Kementerian Kewangan dan Kemudahan Awam Sarawak'),
('483', 'Kementerian Pembangunan Infrastruktur & Perhubungan Sarawak'),
('484', 'Kementerian Perancangan dan Pengurusan Sumber Sarawak'),
('485', 'Kementerian Pertanian & Industri Makanan Sarawak'),
('487', 'Kementerian Alam Sekitar dan Kesihatan Awam Sarawak'),
('488', 'Kementerian Perumahan Sarawak'),
('489', 'Kementerian Pembangunan Luar Bandar dan Kemajuan Tanah Sarawak'),
('490', 'Kementerian Pembangunan Perindustrian Sarawak'),
('491', 'Kementerian Pelancongan Sarawak'),
('492', 'Jabatan Sarawak Yang Tiada Berkementerian'),
('493', 'Kementerian Pembangunan Sosial dan Urbanisasi Sarawak');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_klasifikasi_perkhidmatan`
--

CREATE TABLE IF NOT EXISTS `ruj_klasifikasi_perkhidmatan` (
  `KOD_KLASIFIKASI_PERKHIDMATAN` varchar(11) NOT NULL default '0',
  `KET_KLASIFIKASI_PERKHIDMATAN` varchar(100) default NULL,
  PRIMARY KEY  (`KOD_KLASIFIKASI_PERKHIDMATAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_klasifikasi_perkhidmatan`
--

INSERT INTO `ruj_klasifikasi_perkhidmatan` (`KOD_KLASIFIKASI_PERKHIDMATAN`, `KET_KLASIFIKASI_PERKHIDMATAN`) VALUES
('1', '(A) Pengangkutan'),
('2', '(B) Bakat dan Seni'),
('3', '(C) Sains'),
('4', '(D) Pendidikan'),
('5', '(E) Ekonomi'),
('6', '(F) Sistem Maklumat'),
('7', '(G) Pertanian'),
('8', '(J) Kejuruteraan'),
('9', '(K) Keselamatan dan Bomba'),
('10', '(L) Perundangan'),
('11', '(M) Tadbir dan Diplomatik'),
('12', '(N) Pentadbiran dan Sokongan'),
('13', '(Q) Penyelidikan dan Pembangunan'),
('14', '(R) Mahir/Separuh Mahir/Tidak Mahir'),
('15', '(S) Sosial'),
('16', '(U) Perubatan dan Kesihatan'),
('17', '(W) Kewangan'),
('18', '(X) Penguatkuasaan Maritim'),
('19', '(Y) Polis'),
('20', '(Z) Tentera'),
('21', 'Lain-lain');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_negara`
--

CREATE TABLE IF NOT EXISTS `ruj_negara` (
  `kod_negara` varchar(20) NOT NULL,
  `ket_negara` varchar(100) default NULL,
  PRIMARY KEY  (`kod_negara`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_negara`
--

INSERT INTO `ruj_negara` (`kod_negara`, `ket_negara`) VALUES
('ABW', 'Aruba'),
('AFG', 'Afghanistan'),
('AGO', 'Angola'),
('AIA', 'Anguilla'),
('ALB', 'Albania'),
('AND', 'Andorra'),
('ANT', 'Netherlands Antilles'),
('ARE', 'United Arab Emirates'),
('ARG', 'Argentina'),
('ARM', 'Armenia'),
('ASM', 'American Samoa'),
('ATA', 'Antarctica'),
('ATF', 'French Southern Territories'),
('ATG', 'Antigua And Barbuda'),
('AUS', 'Australia'),
('AUT', 'Austria'),
('AZE', 'Azerbaijan'),
('BDI', 'Burundi'),
('BEL', 'Belgium'),
('BEN', 'Benin'),
('BFA', 'Burkina Faso'),
('BGD', 'Bangladesh'),
('BGR', 'Bulgaria'),
('BHR', 'Bahrain'),
('BHS', 'Bahamas'),
('BIH', 'Bosnia And Herzegovina'),
('BLR', 'Belarus'),
('BLZ', 'Belize'),
('BMU', 'Bermuda'),
('BOL', 'Bolivia'),
('BRA', 'Brazil'),
('BRB', 'Barbados'),
('BRN', 'Brunei Darussalam'),
('BTN', 'Bhutan'),
('BVT', 'Bouvet Island'),
('BWA', 'Botswana'),
('CAF', 'Central African Republic'),
('CAN', 'Canada'),
('CCK', 'Cocos (Keeling) Islands'),
('CHE', 'Switzerland'),
('CHL', 'Chile'),
('CHN', 'China'),
('CIV', 'Cote Divoire'),
('CMR', 'Cameroon'),
('COD', 'Congo, The Democratic Rupblic Of The'),
('COG', 'Congo (Zaire)'),
('COK', 'Cook Islands'),
('COL', 'Colombia'),
('COM', 'Comoros'),
('CPV', 'Cape Verde'),
('CRI', 'Costa Rica'),
('CUB', 'Cuba'),
('CXR', 'Christmas Island'),
('CYM', 'Cayman Islands'),
('CYP', 'Cyprus'),
('CZE', 'Czech Republic'),
('DEU', 'Germany'),
('DJI', 'Djibouti'),
('DMA', 'Dominia'),
('DNK', 'Denmark'),
('DOM', 'Dominican Republic'),
('DZA', 'Algeria'),
('ECU', 'Ecuador'),
('EGY', 'Egypt'),
('ERI', 'Eritrea'),
('ESH', 'Western Sahara'),
('ESP', 'Spain'),
('EST', 'Estonia'),
('ETH', 'Ethiopia'),
('FIN', 'Finland'),
('FJI', 'Fiji'),
('FLK', 'Falkland Islands (Malvinas)'),
('FRA', 'France'),
('FRO', 'Faroe Islands'),
('FSM', 'Micronesia, Federated States Of'),
('GAB', 'Gabon'),
('GBR', 'United Kingdom'),
('GEO', 'Georgia'),
('GHA', 'Ghana'),
('GIB', 'Gibraltar'),
('GIN', 'Guinea'),
('GLP', 'Guadeloupe'),
('GMB', 'Gambia'),
('GNB', 'Guinea-Bissau'),
('GNQ', 'Equatorial Guinea'),
('GRC', 'Greece'),
('GRD', 'Grenada'),
('GRL', 'Greenland'),
('GTM', 'Guatemala'),
('GUF', 'French Guiana'),
('GUM', 'Guam'),
('GUY', 'Guyana'),
('HKG', 'Hong Kong'),
('HMD', 'Heard Island And Mcdonald Islands'),
('HND', 'Honduras'),
('HRV', 'Croatia'),
('HTI', 'Haiti'),
('HUN', 'Hungary'),
('IDN', 'Indonesia'),
('IND', 'India'),
('IOT', 'British Indian Ocean Territory'),
('IRL', 'Ireland'),
('IRN', 'Iran, Islamic Republic Of'),
('IRQ', 'Iraq'),
('ISL', 'Iceland'),
('ISR', 'Israel'),
('ITA', 'Italy'),
('JAM', 'Jamaica'),
('JOR', 'Jordan'),
('JPN', 'Japan'),
('KAZ', 'Kazakstan'),
('KEN', 'Kenya'),
('KGZ', 'Kyrgyzstan'),
('KHM', 'Cambodia'),
('KIR', 'Kiribati'),
('KNA', 'Saint Kitts And Nevis'),
('KOR', 'Korea, Republic Of'),
('KWT', 'Kuwait'),
('LAO', 'Lao People Democratic Republic'),
('LBN', 'Lebanon'),
('LBR', 'Liberia'),
('LBY', 'Libyan Arab Jamahiriya'),
('LCA', 'Saint Lucia'),
('LIE', 'Liechtenstein'),
('LKA', 'Sri Lanka'),
('LSO', 'Lesotho'),
('LTU', 'Lithuania'),
('LUX', 'Luxembourg'),
('LVA', 'Latvia'),
('MAC', 'Macau'),
('MAR', 'Morocco'),
('MCO', 'Monaco'),
('MDA', 'Moldova, Republic Of'),
('MDG', 'Madagascar'),
('MDV', 'Maldives'),
('MEX', 'Mexico'),
('MHL', 'Marshall Islands'),
('MKD', 'Macedonia, The Former Yugoslav Republic Of'),
('MLI', 'Mali'),
('MLT', 'Malta'),
('MMR', 'Myanmar'),
('MNG', 'Mongolia'),
('MNP', 'Northern Mariana Islands'),
('MOZ', 'Mozambique'),
('MRT', 'Mauritania'),
('MSR', 'Montserrat'),
('MTQ', 'Martinique'),
('MUS', 'Mauritius'),
('MWI', 'Malawi'),
('MYS', 'Malaysia'),
('MYT', 'Mayotte'),
('NAM', 'Namibia'),
('NCL', 'New Caledonia'),
('NER', 'Niger'),
('NFK', 'Norfolk Island'),
('NGA', 'Nigeria'),
('NIC', 'Nicaragua'),
('NIU', 'Niue'),
('NLD', 'Netherlands'),
('NOR', 'Norway'),
('NPL', 'Nepal'),
('NRU', 'Nauru'),
('NZL', 'New Zealand'),
('OMN', 'Oman'),
('PAK', 'Pakistan'),
('PAN', 'Panama'),
('PCN', 'Pitcairn'),
('PER', 'Peru'),
('PHL', 'Philippines'),
('PLS', 'Palestinian Territory'),
('PLW', 'Palau'),
('PNG', 'Papua New Guinea'),
('POL', 'Poland'),
('PRI', 'Puerto Rico'),
('PRK', 'Korea, Democratic Peoples Republic Of'),
('PRT', 'Portugal'),
('PRY', 'Paraguay'),
('PYF', 'French Polynesia'),
('QAT', 'Qatar'),
('REU', 'Reunion'),
('ROM', 'Romania'),
('RUS', 'Russian Federation'),
('RWA', 'Rwanda'),
('SAU', 'Saudi Arabia'),
('SDN', 'Sudan'),
('SEN', 'Senegal'),
('SGP', 'Singapore'),
('SGS', 'South Georgia And The South Sandwich Islands'),
('SHN', 'Saint Helena'),
('SJM', 'Svalbard And Jan Mayen'),
('SLB', 'Solomon Islands'),
('SLE', 'Sierra Leone'),
('SLV', 'El Salvador'),
('SMR', 'San Marino'),
('SOM', 'Somalia'),
('SPM', 'Saint Pierre And Miquelon'),
('STP', 'Sao Tome And Principe'),
('SUR', 'Suriname'),
('SVK', 'Slovakia'),
('SVN', 'Slovenia'),
('SWE', 'Sweden'),
('SWZ', 'Swaziland'),
('SYC', 'Seychelles'),
('SYR', 'Syrian Arab Republic'),
('TCA', 'Turks And Caicos Islands'),
('TCD', 'Chad'),
('TGO', 'Togo'),
('THA', 'Thailand'),
('TJK', 'Tajikistan'),
('TKL', 'Tokelau'),
('TKM', 'Turkmenistan'),
('TMP', 'East Timor'),
('TON', 'Tonga'),
('TTO', 'Trinidad And  Tobago'),
('TUN', 'Tunisia'),
('TUR', 'Turkey'),
('TUV', 'Tuvalu'),
('TWN', 'Taiwan, Province Of China'),
('TZA', 'Tanzania, United Republic Of'),
('UGA', 'Uganda'),
('UKR', 'Ukraine'),
('UMI', 'United States Minor Outlying Islands'),
('URY', 'Uruguay'),
('USA', 'United States'),
('UZB', 'Uzbekistan'),
('VAT', 'Holy See (Vatican City State)'),
('VCT', 'Saint Vincent And The Grenadines'),
('VEN', 'Venezuela'),
('VGB', 'Virgin Islands, British'),
('VIR', 'Virgin Islands, U.S'),
('VNM', 'Viet Nam'),
('VUT', 'Vanuatu'),
('WLF', 'Wallis And Futuna'),
('WSM', 'Samoa'),
('YEM', 'Yemen'),
('YUG', 'Yugoslavia'),
('ZAF', 'South Africa'),
('ZMB', 'Zambia'),
('ZWE', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_negeri`
--

CREATE TABLE IF NOT EXISTS `ruj_negeri` (
  `KOD_NEGERI` varchar(10) NOT NULL,
  `KET_NEGERI` varchar(100) NOT NULL,
  PRIMARY KEY  (`KOD_NEGERI`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_negeri`
--

INSERT INTO `ruj_negeri` (`KOD_NEGERI`, `KET_NEGERI`) VALUES
('01', 'Johor'),
('02', 'Kedah'),
('03', 'Kelantan'),
('04', 'Melaka'),
('05', 'Negeri Sembilan'),
('06', 'Pahang'),
('07', 'Pulau Pinang'),
('08', 'Perak'),
('09', 'Perlis'),
('10', 'Selangor'),
('11', 'Terengganu'),
('12', 'Sabah'),
('13', 'Sarawak'),
('14', 'Wilayah Persekutuan Kuala Lumpur'),
('15', 'Wilayah Persekutuan Labuan'),
('16', 'Wilayah Persekutuan Putrajaya'),
('98', 'Luar Negeri'),
('99', 'Lain-lain');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_peringkat`
--

CREATE TABLE IF NOT EXISTS `ruj_peringkat` (
  `KOD_PERINGKAT` varchar(10) NOT NULL,
  `KET_PERINGKAT` varchar(50) NOT NULL,
  PRIMARY KEY  (`KOD_PERINGKAT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_peringkat`
--

INSERT INTO `ruj_peringkat` (`KOD_PERINGKAT`, `KET_PERINGKAT`) VALUES
('01', 'Peringkat Pengurusan Tertinggi'),
('02', 'Peringkat Pengurusan dan Profesional'),
('03', 'Peringkat  Perkhidmatan Sokongan');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_taraf_perjawatan`
--

CREATE TABLE IF NOT EXISTS `ruj_taraf_perjawatan` (
  `KOD_TARAF_PERJAWATAN` varchar(10) NOT NULL,
  `KET_TARAF_PERJAWATAN` text NOT NULL,
  PRIMARY KEY  (`KOD_TARAF_PERJAWATAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_taraf_perjawatan`
--

INSERT INTO `ruj_taraf_perjawatan` (`KOD_TARAF_PERJAWATAN`, `KET_TARAF_PERJAWATAN`) VALUES
('01', 'Dalam Percubaan'),
('02', 'Tetap'),
('03', 'Kontrak'),
('04', 'Sementara'),
('05', 'Lain-lain');

-- --------------------------------------------------------

--
-- Table structure for table `ruj_tujuan_permohonan`
--

CREATE TABLE IF NOT EXISTS `ruj_tujuan_permohonan` (
  `KOD_TUJUAN` varchar(10) NOT NULL,
  `KET_TUJUAN` varchar(50) default NULL,
  PRIMARY KEY  (`KOD_TUJUAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruj_tujuan_permohonan`
--

INSERT INTO `ruj_tujuan_permohonan` (`KOD_TUJUAN`, `KET_TUJUAN`) VALUES
('01', 'Kenaikan Pangkat'),
('02', 'Pengesahan Jawatan'),
('03', 'Lain-lain');

-- --------------------------------------------------------

--
-- Table structure for table `tra_notifikasi`
--

CREATE TABLE IF NOT EXISTS `tra_notifikasi` (
  `ID_NOTIFIKASI` int(11) NOT NULL,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `ID_RUJUKAN` int(11) default NULL,
  `KOD_JENIS_NOTIFIKASI` int(11) default NULL,
  `SKEMA_PANGKALAN_DATA` varchar(100) default NULL,
  `ID_PESERTA` int(11) default NULL,
  PRIMARY KEY  (`ID_NOTIFIKASI`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tra_notifikasi`
--


-- --------------------------------------------------------

--
-- Table structure for table `tra_penghantaran`
--

CREATE TABLE IF NOT EXISTS `tra_penghantaran` (
  `ID_PENGHANTARAN` int(11) NOT NULL,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `KOD_STATUS` varchar(50) default NULL,
  PRIMARY KEY  (`ID_PENGHANTARAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tra_penghantaran`
--


-- --------------------------------------------------------

--
-- Table structure for table `tra_status_peserta`
--

CREATE TABLE IF NOT EXISTS `tra_status_peserta` (
  `ID_STATUS_PESERTA` int(11) NOT NULL,
  `TARIKH_CIPTA` varchar(20) default NULL,
  `ID_PENGGUNA` int(11) default NULL,
  `TARIKH_STATUS_PESERTA` varchar(20) default NULL,
  `KOD_STATUS_PESERTA` int(11) default NULL,
  `ID_PESERTA` int(11) default NULL,
  PRIMARY KEY  (`ID_STATUS_PESERTA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tra_status_peserta`
--

