-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2014 at 08:32 PM
-- Server version: 5.5.27
-- PHP Version: 5.5.9

--
-- Table structure for table `db_prefix_apps`
--

DROP TABLE IF EXISTS `db_prefix_apps`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_apps` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `folder` varchar(200) NOT NULL,
  `author` varchar(50) NOT NULL,
  `type` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;
--

--
-- Dumping data for table `db_prefix_apps`
--

INSERT INTO `db_prefix_apps` (`id`, `name`, `folder`, `author`, `type`) VALUES
(1, 'Article', 'app_article', 'Fiyo CMS', 0),
(2, 'Comment', 'app_comment', 'Fiyo CMS', 2),
(3, 'User', 'app_user', 'Fiyo CMS', 0),
(4, 'Search', 'app_search', 'Fiyo CMS', 2),
(5, 'Contact', 'app_contact', 'Fiyo CMS', 1),
(6, 'Permalink', 'app_sef', 'Fiyo CMS', 2),
(7, 'Sitemap', 'app_sitemap', 'Fiyo CMS', 2);
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_article`
--

DROP TABLE IF EXISTS `db_prefix_article`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_article` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `category` int(5) NOT NULL,
  `article` text NOT NULL,
  `date` datetime NOT NULL,
  `author` varchar(250) NOT NULL,
  `author_id` int(5) NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `keyword` text NOT NULL,
  `featured` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `level` int(1) NOT NULL,
  `hits` int(10) NOT NULL,
  `parameter` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `editor` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=183 ;

--
-- --------------------------------------------------------
--


INSERT INTO `db_prefix_article` (`id`, `title`, `category`, `article`, `date`, `author`, `author_id`, `description`, `tags`, `keyword`, `featured`, `status`, `level`, `hits`, `parameter`, `updated`, `editor`) VALUES
(1, 'Fiyo CMS Hadir pada Tahun 2012', 1, '<p>Welcome :)</p>\r\n', '2012-01-04 14:54:58', 'First Ryan', 1, 'gyi', '', '', 1, 1, 99, 757, 'show_comment=0;\nshow_author=2;\nshow_date=2;\nshow_category=2;\nshow_tags=2;\nshow_hits=2;\nshow_rate=2;\nrate_value=47;\nrate_counter=11;\npanel_top=0;\npanel_bottom=1;\neditor_level=3;\nshow_title=0;\n', '2014-09-02 08:28:59', 1),
(4, 'Fitur Baru di V.1.2.0', 1, '<p>Meski sebenarnya belum rilis versi stabel, tetapi v.1.2.0 sudah bisa digunakan. Hanya saja butuh sedikit penyempurnaan. Apalagi versi ini hampir setengah codingnya berbeda dengan versi sebelumnya yang masih bersifat <em>jadul</em>.</p>\r\n\r\n<p>Berkat komentar dan masukan dari para ahlinya dan para sahabat ditambah para pengguna Fiyo yang antusias selalu memberikan kritik dan saran. Fiyo mengalami kemajuan dalam pengolahan data dan koding yang di kompres banyak dari versi sebelumnya.</p>\r\n\r\n<p>Installer yang hanya berjalan normal hanya di sebagian software localhost seperti di XAMPP dan WAMPP, tetapi tidak dapat mulus di Zend sudah sedikit diatasi di versi terbaru ini.</p>\r\n\r\n<hr id=''system-readmore'' />\r\n<p>Berikut Fitur tambahan dan log di versi terbaru <strong>Fiyo v.1.2.0</strong></p>\r\n\r\n<h4>AddOns Intaller</h4>\r\n\r\n<p>Anda dapat memasang AddOns yang tersedia di situs resmi <strong>Fiyo.Org&nbsp;</strong>dan menginstalnya langsung di situs anda. AddOns adalah sebuah ekstensi tambahan yang ada di FiyoCMS seperti,<em> theme, module, plugin, apps.&nbsp;</em>Tetapi Anda harus sabar jika ingin mengambil AddOns di situs resminya, karena belum tersedia secara langsung dan masih dalam tahap penyempurnaan untuk situs Fiyo.Org itu sendiri.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h4>Spot Position</h4>\r\n\r\n<p>Fitur ini memudahkan anda untuk mencari letak posisi modul pada theme anda, dengan hanya memilih gambar yang ada, dan tidak hanya tulisam saja. Fitur ini bisa anda temukan pada <strong>Module Manager</strong> dan <strong>Theme Manager.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Work Logs Fiyo CMS</strong></p>\r\n\r\n<ol>\r\n	<li>pembenahan posisi modul pada modul manager belum akurat<em><span class=''Apple-tab-span'' style=''white-space:pre''> </span>1.1.0<span class=''Apple-tab-span'' style=''white-space:pre''> </span>6-Jan-2012<span class=''Apple-tab-span'' style=''white-space: pre; ''> </span></em></li>\r\n	<li>merapikan tapilan tabel pada saat memilih &quot;single article&quot; di Menu Manager<span class=''Apple-tab-span'' style=''white-space: pre; ''> </span><em>1.1.0<span class=''Apple-tab-span'' style=''white-space: pre; ''> </span>6-Jan-2012</em></li>\r\n	<li>Penambahan menu AddOns Manager pada admin panel<span class=''Apple-tab-span'' style=''white-space:pre''> </span><em>1.2.0<span class=''Apple-tab-span'' style=''white-space:pre''> </span>7-Jan-2012</em></li>\r\n	<li>penambahan fitur AddOns Instaler<span class=''Apple-tab-span'' style=''white-space:pre''> </span><em>1.2.0<span class=''Apple-tab-span'' style=''white-space:pre''> </span>7-Jan-2012</em></li>\r\n	<li>penambahan fitur Apps AddOns<em><span class=''Apple-tab-span'' style=''white-space:pre''> </span>1.2.0<span class=''Apple-tab-span'' style=''white-space:pre''> </span>8-Jan-2012</em></li>\r\n	<li>penambahan fitur Modules AddOns<span class=''Apple-tab-span'' style=''white-space:pre''> </span><em>1.2.0<span class=''Apple-tab-span'' style=''white-space:pre''> </span>8-Jan-2012</em></li>\r\n	<li>penambahan fitur Themes AddOns<em><span class=''Apple-tab-span'' style=''white-space:pre''> </span>1.2.0<span class=''Apple-tab-span'' style=''white-space:pre''> </span>8-Jan-2012</em></li>\r\n</ol>\r\n\r\n<h4>Developer Logs Updated</h4>\r\n\r\n<ol>\r\n	<li>mark-up app_module untuk back-end<span class=''Apple-tab-span'' style=''white-space:pre''> </span><em>6-Jan-2012</em></li>\r\n	<li>mark-up app_menu untuk back-end<span class=''Apple-tab-span'' style=''white-space:pre''> </span><em>6-Jan-2012</em></li>\r\n	<li>penambahan fungsi extrak file zip -&gt; extractZip($file,$directory);<span class=''Apple-tab-span'' style=''white-space:pre''> </span><em>8-Jan-2012</em></li>\r\n	<li>penambahan fungsi hapus direktori dan isinya -&gt; delete_directory($dirname);<span class=''Apple-tab-span'' style=''white-space:pre''> </span><em>8-Jan-2012</em></li>\r\n</ol>\r\n\r\n<div>\r\n<h4>Issue</h4>\r\n\r\n<div>\r\n<ul>\r\n	<li>link kress (#) tidak berjalan&nbsp;<em><strong>solved</strong></em></li>\r\n	<li>posisi modul pada modul manager belum akurat&nbsp;<em><strong>solved</strong></em></li>\r\n	<li>Fiyo Installer tidak berjalan normal&nbsp;<em><strong>solved</strong></em></li>\r\n</ul>\r\n</div>\r\n</div>\r\n\r\n<p>&nbsp;</p>\r\n', '2012-02-04 11:13:29', '', 1, '', '', '', 0, 1, 99, 541, 'show_comment=2;\nshow_author=2;\nshow_date=2;\nshow_category=2;\nshow_tags=2;\nshow_hits=2;\nshow_rate=2;\nrate_value=19;\nrate_counter=3;\npanel_top=0;\npanel_bottom=0;\neditor_level=1;\n', '2014-09-01 13:38:19', 1),
(182, 'Fiyo CMS 1.5.7 3.0', 2, '<p>Fiyo 1.5.7 rev.3.0 merupakan check poin untuk minggu ini setelah revisi awal di tanggal 1 Januari. Ada beberapa perubahan untuk tampilan tema Curve. Sedikit menyesuaikan gaya simple modern. Dan penyesuaian untuk beberapa module yang akan dirilis, yaitu module Tabs.</p>\r\n\r\n<p>Ada perubahab core di plugin SEF, statistic dan Cache yang menjadi versi ini penting untuk di perbarui. Gambar avatar yang semula memuat gravatar akan disesuaikan apabila status server/PC terkoneksi dengan internet atau tidak supaya mempersingkat muat halaman.</p>\r\n\r\n<div style=''page-break-after: always;''><span style=''display: none;''>&nbsp;</span></div>\r\n\r\n<p>Telah ditambahkan juga modul revisi untuk Article List, Article Archive dan Article Related. Untuk modul Article Related ada posisi khusus agar bisa ditampilkan tepat dibawah artikel. Saat membuat modul baru pilih posisi <strong>article-mid</strong>&nbsp;supaya posisi module ditengah-tengah antara konten utama dan bagian komentar.</p>\r\n', '2014-01-04 22:47:30', '', 1, '', 'CMS,Review', '', 1, 1, 99, 11, 'show_comment=2;\nshow_author=2;\nshow_date=2;\nshow_category=2;\nshow_tags=2;\nshow_hits=2;\nshow_rate=2;\nrate_value=5;\nrate_counter=1;\npanel_top=2;\npanel_bottom=2;\neditor_level=3;\nshow_title=2;\n', '2014-09-03 03:31:58', 2),
(6, 'Fiyo 1.2.2 dengan Fitur Lebih Canggih', 1, '<p><span style=''line-height: 1.6em;''>Rilis kali ini mempunyai perubahan yang signifikan dari rilis-update sebelumnya. Kali ini fitur yang ingin ditambahkan dari awal pembuatan FiyoCMS baru bisa dirasakan di versi 1.2.2 ini.</span></p><div style=''page-break-after: always;'' contenteditable=''false'' class=''cke_pagebreak'' data-cke-display-name=''pagebreak'' aria-label=''Page Break'' title=''Page Break''></div><p>Yaitu fitur OneClickCange, dengan fitur ini mengatur artikel, menu dan modul terasa sangat mudah. Satu klik tanpa loading anda sudah bisa mengaktifkan atau menon-aktifkan artikel, modul atau menu yang anda inginkan.</p><p>Ditambah lagi di versi ini kita sudah bisa menyediakan module SlideShow, modul MultiFacebook, ImageScroll dan modul menarik lainya.</p><p>Pada versi ini juga ditambahkan Apps baru, yaitu App Contact. Anda bisa mengelola kontak para teman anda atau pegawai perusahaan.</p><p>Berikut Perubahan dan Fitur tambahan yang ada di Fiyo v 1.2.2</p><p><em><strong>Work Logs Fiyo CMS</strong></em></p><ul><li>penambahan plugins From Validator (JQuery)</li><li>penambahan plugins input limiter (JQuery)</li><li>fitur one click change pada Apps di AdminPanel&nbsp;&nbsp;(JQuery)</li><li>penyempurnaan plugin_sef</li><li>perbaikan : app_comment</li><li>perbaikan : app_article</li><li>penambahan : app_contact</li><li>perbaikan : app_user &nbsp;(Front Site)</li><li>perbaikan : app_module (Front Site)</li></ul><p><em><strong>Developer Logs Updates</strong></em></p><ul><li>Mengganti Field ''<strong>name</strong>'' dengan&nbsp;<strong>''title</strong>'' pada tabel Article</li><li>penambahan fungsi&nbsp;<strong>get_htmlTag()</strong>&nbsp;sebagai fungsi tag parse</li></ul><p><br></p>', '2012-02-19 13:00:29', '', 1, '', '', '', 1, 1, 99, 454, 'show_comment=2;\nshow_author=2;\nshow_date=2;\nshow_category=1;\nshow_tags=2;\nshow_hits=2;\nshow_rate=2;\nrate_value=31;\nrate_counter=7;\npanel_top=0;\npanel_bottom=0;\neditor_level=2;\nshow_title=0;\n', '2014-09-02 11:28:11', 1),
(7, 'Update checkpoint di versi 1.2.3', 1, '<p><span style=''line-height: 1.6em;''>Akhirnya setelah menunggu dan melakukan penambahan serta revisi dibagian system. Fiyo 1.2.3 dapat segera kami rilis. versi ini kami sebut dengan nama &nbsp;Fiyo one-two-three. Versi ini adalah yang terakhir untuk versi 1.2, yang berarti tidak akan ada lagi update untuk versi 1.2.x berikutnya.</span></p>\r\n\r\n<p>Walaupun masih ada beberapa fitur yang masih ingin ditambahkan seperti newsteller, dan fitur rating artikel. Tetapi ini diharap bisa menutup untuk versi 1.2 dan menjadikan Fiyo lebih dapat berkambang lebih canggih lagi.</p>\r\n\r\n<div style=''page-break-after: always;''><span style=''display: none;''>&nbsp;</span></div>\r\n\r\n<p>Ok, berikut adalah fitur baru yang dimiliki Fiyo one-two-three.</p>\r\n\r\n<h3>Add-Ons Manager Update</h3>\r\n\r\n<p>Fitur Add-Ons Manager memang sudah lama ada, tetapi ada beberapa yang belum kami aktifkan. Tapi untuk saat ini anda bisa menggunakan semua fitur yang ada di Add-Ons Manager. Fitur baru seperti Plugins Manager atau penyempurnaan pada Add-Ons Installer bisa anda coba disini.</p>\r\n\r\n<p>Update fitur ini adalah yang paling menonjol dan paling berpengaruh dalam update kali ini. Dengan sudah lengkapnya fitur pada Add-Ons Manager, diharapkan dapat mempermudah para developer khususnya untuk lebih mengembangkan Fiyo Add-Ons.</p>\r\n\r\n<h3>Folder Admin Scure</h3>\r\n\r\n<p>Anda pasti tahu jika FiyoCMS mendukung optimalisasi pengamanan folder admin. Dimana anda dapat mengganti nama folder admin sesuka anda. Tapi hal tersebut belum lengkap, karena masih harus dilakukan secara manual. Hal tersebut memang mudah dilakukan jika kita menjalankan FiyoCMS di server local (localhost), bagai mana jika di live server ? Pasti butuh proses yang panjang.</p>\r\n\r\n<p>Kali ini anda dapat mengganti nama folder admin anda melalui menu Web Configuration pada menu Admin Panel. Lalu pilih bagian pojok kiri Konfigurasi Admin-Panel untuk mengganti nama folder admin dengan nama baru.</p>\r\n\r\n<p>&nbsp;</p>\r\n', '2012-06-05 00:57:31', '', 1, '', '', '', 1, 1, 99, 101, 'show_comment=1;\nshow_author=1;\nshow_date=1;\nshow_category=1;\nshow_tags=1;\nshow_hits=1;\nshow_rate=1;\nrate_value=27;\nrate_counter=3;\npanel_top=2;\npanel_bottom=2;\neditor_level=1;\nshow_title=2;\n', '2014-09-02 11:28:10', 1),
(8, 'Membuat Template FiyoCMS', 1, '<p>Untuk memulai pembuatan tema perlu disiapkan file wajib dalam paket&nbsp;Fiyo Theme. File tersebut adalah sebagai berikut :</p>\r\n\r\n<ul>\r\n	<li>index.php</li>\r\n	<li>theme_details.php</li>\r\n	<li>theme_image.gif</li>\r\n	<li>spot_position.php (tambahan)</li>\r\n</ul>\r\n\r\n<h3>index.php</h3>\r\n\r\n<div style=''page-break-after: always;''><span style=''display: none;''>&nbsp;</span></div>\r\n\r\n<p><strong>index.php</strong> merupakan file utama untuk memuat seluruh file yang dibutuhkan. Untuk permulaan buat folder &#39;<strong>mytheme</strong>&#39; didalam folder root/themes/. Setelah itu buat file index.php dan sisipkan kode dibawah ini :</p>\r\n\r\n<pre class=''brush:php''>\r\n&lt;html&gt;\r\n    &lt;head&gt;&lt;title&gt;My Theme&lt;/title&gt;&lt;/head&gt;\r\n    &lt;body&gt;Text body&lt;/body&gt;\r\n&lt;/html&gt;</pre>\r\n\r\n<p>Setelah itu simpan dan set di Admin Panel untuk mengaktifkan mytheme sebagai tema utama. Apakah berhasil? Jika ya mungkin bisa kelangkah selanjutnya.</p>\r\n\r\n<p>Sekarang mulai untuk memuat system kedalam file tema. Sebelum itu kita perlu mengetahui fungsi dan konstanta yang bisa digunakan dalam membuat tema.</p>\r\n\r\n<ul>\r\n	<li><strong>FTitle </strong>: menampilkan judul situs sesuai format pada konfigurasi situs.</li>\r\n	<li><strong>FUrl </strong>: url utama atau url homepage.</li>\r\n	<li><strong>SiteName </strong>: nama situs.</li>\r\n	<li><strong>SiteTitle </strong>: judul situs.</li>\r\n	<li><strong>SiteLang </strong>: bahasa situs.</li>\r\n	<li><strong>MetaRobots </strong>: konfigurasi robots halaman.</li>\r\n	<li><strong>MetaDesc </strong>: deskripsi halaman.</li>\r\n	<li><strong>MetaKeys </strong>: katakunci halaman.</li>\r\n	<li><strong>FThemePath </strong>: direktori tema yang sedang digunakan.</li>\r\n	<li><strong>AdminPath </strong>: direktori tema AdminPanel.</li>\r\n	<li><strong>loadModule</strong>(&#39;posisi_modul&#39;) : memuat modul sesuai posisi dalam parameter.</li>\r\n	<li><strong>checkModule</strong>(&#39;posisi_modul&#39;) : digunakan apakah modul sesuai posisi parameter sedang aktif.</li>\r\n	<li><strong>loadApps</strong>() : memuat Apps.</li>\r\n	<li>\r\n	<div><strong><span style=''line-height: 1.6em;''>load</span></strong><span style=''line-height: 1.6em;''><strong>AppsCss</strong>() : fungsi untuk memuat seluruh css pada apps yang aktif.</span></div>\r\n	</li>\r\n	<li>\r\n	<div><strong><span style=''line-height: 1.6em;''>loadModuleCs</span></strong><span style=''line-height: 1.6em;''><strong>s</strong>() : fungsi untuk memuat seluruh module css yang aktif.</span></div>\r\n	</li>\r\n</ul>\r\n\r\n<p>Berikut adalah contoh potongan kode untuk bagian &lt;head&gt;.</p>\r\n\r\n<pre class=''brush:php''>\r\n&lt;!DOCTYPE html&gt;\r\n&lt;html lang=&quot;&lt;?php echo SiteLang; ?&gt;&quot;&gt;\r\n&lt;head&gt;\r\n    &lt;meta charset=&quot;utf-8&quot; /&gt;\r\n    &lt;title&gt;&lt;?php echo FTitle; ?&gt;&lt;/title&gt;\r\n    &lt;meta name=&quot;robots&quot; content=&quot;&lt;?php echo MetaRobots; ?&gt;&quot; /&gt;\r\n    &lt;meta name=&quot;keywords&quot; content=&quot;&lt;?php echo MetaKeys; ?&gt;&quot; /&gt;\r\n    &lt;meta name=&quot;description&quot; content=&quot;&lt;?php echo MetaDesc; ?&gt;&quot; /&gt;\r\n    &lt;meta name=&quot;generator&quot; content=&quot; Fiyo CMS Integrate Design Easily!&quot; /&gt;\r\n    &lt;?php loadAppsCss(); ?&gt;\r\n    &lt;?php loadModuleCss(); ?&gt;\r\n    &lt;link rel=&quot;shortcut icon&quot; type=&quot;image/x-icon&quot; href=&quot;&lt;?php echo FThemePath; ?&gt;/css/images/favicon.ico&quot; /&gt;\r\n    &lt;link rel=&quot;stylesheet&quot; href=&quot;&lt;?php echo FThemePath; ?&gt;/css/style.css&quot; type=&quot;text/css&quot; media=&quot;all&quot; /&gt;\r\n    &lt;script type=&quot;text/javascript&quot; src=&quot;&lt;?php echo FThemePath; ?&gt;/js/jquery-2.0.3.min.js&quot;&gt;&lt;/script&gt;\r\n&lt;/head&gt;</pre>\r\n\r\n<p>Pada potongan kode diatas hampir semua meta-tag sudah dipenuhi. fungsi loadCss(apps/modul) dimuat sebelum file css&nbsp;tema. Hal tersebut bertujuan agar css tema bisa mempengaruhi css modul/apps.&nbsp;</p>\r\n\r\n<p>Potongan kode diatas juga menunjukan bahwa terdapat folder css dan js yang menyimpan beberapa file pendukung. Disaranka untuk tidak memnuliskan javascript dalam mode inline atau langsung pada file index.php. Karena dapat merusak <em>module position</em>&nbsp;dari tema yang dibuat. pisahkan kedalam file tersendiri juga membuat struktur dan penulisan kode lebih rapi.</p>\r\n\r\n<p>Setelah bagian <em>head</em>&nbsp;selanjutnya bagian <em>body</em>. Perhatikan potongan kode berikut :</p>\r\n\r\n<pre class=''brush:php''>\r\n&lt;body&gt;\r\n   &lt;header id=&quot;header&quot;&gt;\r\n       &lt;div id=&quot;logo&quot;&gt;&lt;a href=&quot;&lt;?php echo FUrl; ?&gt;&quot;&gt;&lt;?php echo SiteName; ?&gt;&lt;/a&gt;\r\n       &lt;span&gt;&lt;?php echo SiteTitle; ?&gt;&lt;/span&gt;&lt;/div&gt;\r\n   &lt;/header&gt;\r\n   \r\n   &lt;nav id=&quot;navigation&quot;&gt;    \r\n      &lt;?php echo loadModule(&#39;mainmenu&#39;) ?&gt;\r\n   &lt;/nav&gt;\r\n   \r\n   &lt;div class=&quot;m-slider&quot;&gt;\r\n      &lt;?php loadModule(&#39;slide&#39;);?&gt;\r\n   &lt;/div&gt;        \r\n               \r\n   &lt;div class=&quot;main&quot;&gt;      \r\n&nbsp;      &lt;?php if(checkModule(&#39;right&#39;)) : ?&gt;  \r\n          &lt;div class=&quot;full&quot;&gt;\r\n&nbsp;            &lt;?php loadApps(); ?&gt;\r\n          &lt;/div&gt;\r\n&nbsp;      &lt;?php else : ?&gt;\r\n          &lt;div class=&#39;left&#39;&gt;\r\n&nbsp;            &lt;?php loadApps(); ?&gt;\r\n&nbsp;         &lt;/div&gt;\r\n&nbsp;         &lt;div class=&#39;right&#39;&gt;          \r\n             &lt;?php loadModule(&#39;right&#39;);?&gt;\r\n          &lt;/div&gt;\r\n&nbsp;      &lt;?php endif; ?&gt;\r\n   &lt;/div&gt;\r\n&lt;/body&gt;</pre>\r\n\r\n<p><span style=''line-height: 1.6em;''>Jika dilihat menurut potongan kode diatas terdapat posisi module mainmenu, slide dan right. Pada bagian konten akan tampil lebar jika module right tidak aktif. Dan akan dibagi menjadi dua bagian jika module right ada yang aktif sesuai kontrol checkModule().</span></p>\r\n\r\n<p>Setelah membuat file index.php secara lengkap sebenarnya sudah bisa digunakan secara utuh untuk Fiyo Theme. Namun, perlu theme_details.php sebagai informasi tema dan theme_image.gif sebagai gambar pendukung dari informasi tema.</p>\r\n\r\n<h3>theme_details.php</h3>\r\n\r\n<p>isi dan modifikasi bagian theme_details sesuai informasi tema yang diperlukan. Berikut contoh file theme_details.php.</p>\r\n\r\n<pre class=''brush:php''>\r\n$theme_name          =&#39;First Panel&#39;;\r\n$theme_version       =&#39;1.5.0&#39;;\r\n$theme_date          =&#39;17 August 2013&#39;;\r\n$theme_author        =&#39;Fiyo CMS&#39;;\r\n$theme_author_url    =&#39;http://portofolio.web.id&#39;;\r\n$theme_author_email  =&#39;firstryan@gmail.com&#39;;</pre>\r\n\r\n<h3>theme_image.gif</h3>\r\n\r\n<p>Buat screenshoot dari tema yang dibuat sebagai <em>thumbnail</em>&nbsp;(preview)&nbsp;tema. Rekomendasi berukuran 200x200 atau dengan ukuran yang presisi.</p>\r\n\r\n<h3>spot_position.php</h3>\r\n\r\n<p>Ini merupakan fitur dari Fiyo yaitu dapat memilih posisi modul dengan memilih dari preview tema. Pertama kita perlu menyiapkan terlebih dahulu gambar atau preview untuk&nbsp;spot_position. (misal spot_position.gif) Setelah itu gunakan dreamwaver untuk membuat imageMap sesuai modul yang dibuat.</p>\r\n\r\n<p>Hasil dari imageMap dari Dreamweaver contohnya seperti ini.</p>\r\n\r\n<pre class=''brush:php''>\r\n&lt;h3&gt;Fiyo Theme&lt;/h3&gt;\r\n&lt;img src=&quot;spot_position.gif&quot; width=&quot;600&quot; border=&quot;0&quot; usemap=&quot;#Map&quot; /&gt;\r\n&lt;map name=&quot;Map&quot; id=&quot;Map&quot;&gt;&lt;area  name=&quot;bottom-content&quot; shape=&quot;rect&quot; coords=&quot;66,80,379,171&quot; alt=&quot;slide&quot; /&gt;&lt;area  name=&quot;bottom-content&quot; shape=&quot;rect&quot; coords=&quot;279,183,379,229&quot; alt=&quot;top3&quot; /&gt;&lt;area  name=&quot;bottom-content&quot; shape=&quot;rect&quot; coords=&quot;173,183,270,230&quot; alt=&quot;top2&quot; /&gt;&lt;area  name=&quot;bottom-content&quot; shape=&quot;rect&quot; coords=&quot;68,183,164,229&quot; alt=&quot;top1&quot; /&gt;&lt;area  name=&quot;bottom-content&quot; shape=&quot;rect&quot; coords=&quot;66,447,380,480&quot; alt=&quot;bottom&quot; /&gt;\r\n  &lt;area shape=&quot;rect&quot; coords=&quot;65,485,532,501&quot; alt=&quot;breadchumb&quot; /&gt;\r\n  &lt;area shape=&quot;rect&quot; coords=&quot;392,78,536,468&quot; alt=&quot;right&quot; /&gt;\r\n  &lt;area shape=&quot;rect&quot; coords=&quot;391,9,532,29&quot; alt=&quot;search&quot; /&gt;\r\n  &lt;area shape=&quot;rect&quot; coords=&quot;67,43,537,67&quot; alt=&quot;mainmenu&quot;/&gt;\r\n&lt;/map&gt;</pre>\r\n\r\n<p>Setelah file utama dan file pendukung siap sekarang bisa terapkan tema yang sudah dibuat.</p>\r\n\r\n<h3>Membuat Paket Installer</h3>\r\n\r\n<p>Jika berniat untuk berbagi dari tema yang sudah dibuat anda perlu menyiapkan paket installer agar dapat diinstal melalui AddOns Installer.&nbsp;</p>\r\n\r\n<h3>installer.php</h3>\r\n\r\n<p>buat file installer.php satu folder dengan file index.php. Dan diingat bahwa file installer akan hilang otomatis jika paket Fiyo Theme berhasil diinstall. Berikut contoh file installer.php</p>\r\n\r\n<pre class=''brush:php''>\r\n$addons[&#39;name&#39;]   = &#39;My Theme&#39;;\r\n$addons[&#39;type&#39;]   = &#39;themes&#39;;\r\n$addons[&#39;folder&#39;] = &#39;mytheme&#39;;\r\n$addons[&#39;info&#39;]   = &#39;&lt;h1&gt;Ini tema buatan saya :)&lt;/h1&gt;&#39;;</pre>\r\n\r\n<p>Setelah file installer terbentuk pilih semua file yang ada pada folder tema yang dibuat lalu klik kanan dan pilih kompres sebagai zip.&nbsp;<span style=''line-height: 1.6em;''>Jadi sekarang selain terdapat file pendukung tema juga terdapat file .zip sebagai file installer yang telah dibuat.</span></p>\r\n', '2012-01-03 11:37:11', '', 1, '', '', '', 1, 1, 99, 246, 'show_comment=1;\nshow_author=1;\nshow_date=1;\nshow_category=1;\nshow_tags=1;\nshow_hits=1;\nshow_rate=1;\nrate_value=24;\nrate_counter=5;\npanel_top=2;\npanel_bottom=2;\neditor_level=3;\nshow_title=2;\n', '2014-09-02 08:29:37', 1),
(10, 'Fiyo CMS 1.3.0', 2, '<p>Tanggal s 16 October 2012, Fiyo CMS versi 1.3.0 resmi di rilis dan pertama kalo di unggah pada situs www.sourceforge.net. Seperti apa yang telah di sampaikan sebelumnya pada artikel Pre-release Fiyo 1.3.0&nbsp;ada beberapa update yang tidak sedikit di tambahkan dalam versi ini. Disamping vitur yang telah di sampaikan pada Pre-release, ada beberapa fitur tambahan yang memang di tambahkan karena kebutuhan. Mau tau apa saja fitur lengkap yang ada di Fiyo CMS 1.3.0? Berikut data lengjap tetang apa saja yang ada pada Fiyo CMS 1.3.0.</p>\r\n\r\n<p>Pada versi anyar ini, developer mencoba untuk melengkapi fitur multi bahasa yang ada untuk AdminPanel, dan melengkapi beberapa <em>helper&nbsp;</em>agar memudahkan user dalam membuat website. Jadi apabila anda kesulitan, anda bias membuka<em> helper&nbsp;</em>yang tersedia pada setiap halaman AdminPanel.</p>\r\n\r\n<div style=''page-break-after: always;''><span style=''display: none;''>&nbsp;</span></div>\r\n\r\n<p>Ada fitur <em><strong>Auto Tagging</strong></em>, jadi kita bisa memberikan tag pada artikel dan akan otomatis erbentuk ketika kita menekan koma atau enter, sehingga diharapkan mampu mengurangi kesalahan pada penulisan tag artikel.</p>\r\n\r\n<p>Fitur yang <em><strong>Global Default Page</strong></em> juga merupakan fitur baru, disini kita dapat menentukan halaman default untuk semua halaman yang tidak mempunyai halaman tetap. Jadi, halaman yang tidak mempunyai Page_ID akan mempunyai halaman dengan&nbsp;<em><strong>Global Default Page.</strong></em></p>\r\n\r\n<p>Serta ada fitur&nbsp;RSS Feed yang bisa anda dapatkan pada kategori artikel atau tag artikel pada bagian bawah halaman dengan icon khusus. Untuk daftar update dengan tanda <strong>Ready!&nbsp;</strong>belum sepenuhnya di aktifkan, karena itu bermain dengan <em>.htaccess.&nbsp;</em>Disarankan untuk merubah&nbsp;<em>.htaccess</em> untuk live server saja dan bukan server lokal. Anda bisa mengaktifkanya dengan merubah isi dari&nbsp;<em>.htaccess.</em></p>\r\n\r\n<p>Berikut daftar update untuk Fiyo CMS 1.3.0 :</p>\r\n\r\n<ul>\r\n	<li>Auto Generate Meta Description</li>\r\n	<li>Auto Generate Meta Keyword</li>\r\n	<li>Auto Generate Meta Robots</li>\r\n	<li>Auto Generate Meta Author</li>\r\n	<li>Optimize Page Title</li>\r\n	<li>GZiP <strong>Ready!</strong></li>\r\n	<li>SpeedUp Caching Server &amp; Browser <strong>Ready!</strong></li>\r\n	<li>Copressed Static File <strong>Ready!</strong></li>\r\n	<li>Scurity libwww (Library World Wide Web) via .httaccess<strong> Ready!</strong></li>\r\n	<li>RSS Feed</li>\r\n	<li>Auto Tagging</li>\r\n	<li>Default Global Page</li>\r\n</ul>\r\n\r\n<p>Fix Bug :</p>\r\n\r\n<ul>\r\n	<li>Scurity Media Manager</li>\r\n	<li>Auto Change AdminPanel</li>\r\n	<li>Auto Installer in LocalServer</li>\r\n	<li>MultiDeletation on Admin Panel</li>\r\n</ul>\r\n\r\n<p>Change Log :</p>\r\n\r\n<ul>\r\n	<li>Add new<em> data</em> for table <strong><em>_setting :</em></strong>\r\n\r\n	<ul>\r\n		<li>lang =&gt; language</li>\r\n		<li>backend_folder =&gt; Auto change AdminPanel</li>\r\n		<li>follow_link = Meta Robots</li>\r\n		<li>site_mail = Official Site Mail</li>\r\n	</ul>\r\n	</li>\r\n	<li>Add new <em>column</em>&nbsp;for table&nbsp;<strong><em>_article_category :</em></strong>\r\n	<ul>\r\n		<li>keyword =&gt; Meta Keyword category</li>\r\n	</ul>\r\n	</li>\r\n	<li>Add new&nbsp;<em>column</em>&nbsp;for table&nbsp;<strong><em>_menu :</em></strong>\r\n	<ul>\r\n		<li>global =&gt; Global default Page</li>\r\n	</ul>\r\n	</li>\r\n</ul>\r\n', '2013-01-09 14:20:50', '', 1, '', '', '', 1, 1, 99, 437, 'show_comment=1;\nshow_author=1;\nshow_date=1;\nshow_category=1;\nshow_tags=1;\nshow_hits=1;\nshow_rate=1;\nrate_value=19;\nrate_counter=5;\npanel_top=0;\npanel_bottom=1;\neditor_level=3;\nshow_title=0;\n', '2014-09-02 11:28:09', 1),
(12, 'Mengenal Lebih Dekat tentang Fiyo CMS', 1, '<p>Bagi yang masih penasaran dan bertanya-tanya apa itu Fiyo CMS? Buat apa sih Fiyo CMS? Atau, apalagi nih Fiyo CMS? Jangan jangan itu virus? Wah kagak minat ah!</p>\r\n\r\n<p>Tenang, tenang sabar dulu, langsung saja nih silahkan dibaca untuk lebih jelasnya.</p>\r\n\r\n<div style=''page-break-after: always;''><span style=''display: none;''>&nbsp;</span></div>\r\n\r\n<p>Fiyo CMS adalah sebuah Content Management System.</p>\r\n\r\n<blockquote>\r\n<p>Apalagi nih Content Management System ?</p>\r\n</blockquote>\r\n\r\n<p>Content Management System atau dalam bahasa Indonesia disebut Sistem Manajemen Konten (disingkat CMS), adalah software yang memungkinkan seseorang untuk menambahkan dan/atau memanipulasi (mengubah) isi dari suatu situs Web.<em style=''&amp;quote;font-size:''>&nbsp;(<a href=''http://id.wikipedia.org/wiki/Sistem_manajemen_konten''>http://id.wikipedia.org/wiki/Sistem_manajemen_konten</a>)</em></p>\r\n\r\n<p>Contoh lain CMS seperti Joomla, Wrodpress, bahkan Blogspot juga CMS looh. Gimana sudah bisa mengertikan apa itu CMS?</p>\r\n\r\n<blockquote>\r\n<p>Jadi sama aja antara Fiyo dengan CMS yang lain ?</p>\r\n</blockquote>\r\n\r\n<p>Ehmm, kalo dibilang sama sih iya, kan jenisanya juga sama-sama CMS. Tetapi Fiyo CMS juga pasti ada bedanya, apalagi dengan CMS yang sudah memiliki banyak developer (pengembang) seperti Joomla, Wrodpress, Drupal, dll.</p>\r\n\r\n<p>Tapi tenang saja, Fiyo CMS mempunyai fitur yang gak kalah canggihnya. dari mulai kemudahan membuat sebuah theme atau convert template gratisan ke Fiyo Theme dengan cara yang mudah.</p>\r\n\r\n<p>Ditambah lagi, developernya orang Indonesia yang ramah-ramah, jadi bisa mudah tanya jawab dengan mereka.</p>\r\n\r\n<blockquote>\r\n<p>Fiyo CMS free kan ?</p>\r\n</blockquote>\r\n\r\n<p>Oh, tentunya <em>free</em>! Karena disesuaikan dengan selera orang Indonesia, hahaha.</p>\r\n\r\n<p>Fiyo CMS juga boleh di <em>otak-atik&nbsp;</em>sesuai kebutuhan, tetapi jangan merubah nama Fiyo CMS dengan nama baru lho! Sangat dilarang dan tidak bijak. Alangkah baiknya jika kita saling menghargai karya orang lain.</p>\r\n\r\n<p>Yang terpenting adalah, kata free yang bararti bebas dan gratjs itu berbeda. Fiyo CMS adalah software free dalam arti <u>bebas</u>.</p>\r\n\r\n<blockquote>\r\n<p>Lisensinya gimana untuk Fiyo CMS ?</p>\r\n</blockquote>\r\n\r\n<p>Fiyo CMS menggunakan License&nbsp;GNU General Public License, version 3 (GPL-3.0) sebagai basis lisensinya.</p>\r\n\r\n<p>Jadi menurut keterangan untuk lisensi tersebut, adalah setiap orang dapat mengopy (mengunduh) dan mendisitribusikan kembali. Tetapi tidak diperbolehkan untuk melakukan perubahan terhadap sistem yang ada tanpa izin.</p>\r\n\r\n<blockquote>\r\n<p>Emang Fiyo CMS bisa dipake buat apa aja sih ?</p>\r\n</blockquote>\r\n\r\n<p>Fiyo CMS sengaja disiapkan untuk pengembangan yang lebih lanjut, meski dasarnya adalah CMS yang simple. Dari kategori yang umum digunakan oleh orang-orang, yaitu digunakan untuk <em>ngeblog</em>, buat toko online, website perkantoran, &nbsp;website pemerintahan, dan masih banyak lagi sesuai keinginan anda.</p>\r\n\r\n<p>Fiyo CMS yang berbasis Fiyo Framework juga telah dikembangkan untuk pembuatan sistem informasi berbasis website, seperti Sistem Administrasi Sekolah, Sistem Perkantoran, Sistem Keuangan, dan Sistem Database lainya.</p>\r\n\r\n<p>Jadi, meski simple pengembangan Fiyo CMS masihlah panjang karena akan ada banyak penambahan AddOns seiring berjalanya waktu.&nbsp;</p>\r\n\r\n<blockquote>\r\n<p>Wah jadi gak sabar pingin coba nih :)</p>\r\n</blockquote>\r\n\r\n<p>Waaaah, udah pingin nyobai nih? Langsung aja download Fiyo CMS versi terbaru.</p>\r\n\r\n<p>Sekian dulu ya artikel kali ini, semoga dapat menambah wawasan para pembaca.</p>\r\n\r\n<p><em>Dukung terus buatab Asli 100% Indonesia !</em></p>\r\n', '2012-05-01 22:35:31', '', 1, '', '', '', 1, 1, 99, 1115, 'show_comment=1;\nshow_author=1;\nshow_date=1;\nshow_category=1;\nshow_tags=1;\nshow_hits=1;\nshow_rate=1;\nrate_value=34;\nrate_counter=7;\npanel_top=2;\npanel_bottom=1;\neditor_level=1;\nshow_title=2;\n', '2014-09-02 11:29:26', 1),
(14, 'Fiyo CMS 1.5.0', 1, '<p>Semakin optimal peforma dari Fiyo CMS di versi 1.5.0 ini. Banyak perubahan dari sisi <em>system core</em> yang ada untuk mengoptimalkan Fiyo CMS. Kami ingin selalu menyajikan sebuah perangkat yang mudah digunakan, sangat mudah dan ringan diakses. Oleh karena itu kami akan terus melekukan perbaikan dan invoasi serta menerima saran dari para pengguna Fiyo CMS.</p><p>Merupakan penyempurnaan dari versi sebelumnya, yaitu Fiyo 1.4.0 dengan penambahan fitur yang banyak, Fiyo 1.5.0 lebih spesifik kepada penyempurnaan dari awal Fiyo CMS terbentuh hingga versi yang sekarang. Fungsi dari AdminPanel dan situs depan telah aktif secara keseluruhan.</p><hr id=''system-readmore''><h2>Edit Theme</h2><p>Fiyo 1.5.0 memiliki fitur baru dibagian <strong>Theme Manager</strong>, yaitu penambahan tombol <u>Edit Theme</u>. Dimana kita bisa mengedit file yang ada dalam <em>theme</em> yang dipilih.</p><p style=''text-align: center;''><img alt=''Edit Theme'' data-cke-saved-src=''/media/images/edit_theme.jpg'' src=''/media/images/edit_theme.jpg'' style=''width: 464px; height: 298px;''></p><p>Anda hanya perlu memilih file yang ingin di edit dan simpan dengan dengan mudah disisi kanan layar.</p><p style=''text-align: center;''><img alt=''Edit File Theme on Fiyo CMS'' data-cke-saved-src=''/media/images/file_theme.gif'' src=''/media/images/file_theme.gif'' style=''width: 600px; height: 323px;''></p><p>Dengan ini kita dengan mudah menambahkan tag custom apapun, seperti Google Analytics, file css, file javascript atau tag lainya.&nbsp;</p><h2>HTML Valid Ready!</h2><p>Memang semua bisa mengatakan bahwa mereka juga siap untuk menjadikan situs lulus uji validasi HTML. <u>Tetapi kami jauh lebih siap</u>&nbsp;Fiyo 1.5.0 akan membantu Anda untuk memuat semua file css didalam tag &lt;head&gt;. tinggal tambahkan kode berikut di setiap file tema yang digunakan,</p><div><span style=''font-family:courier new,courier,monospace;''>&lt;?php loadAppsCss(); ?&gt;</span></div><div><span style=''font-family:courier new,courier,monospace;''>&lt;?php loadModuleCss(); ?&gt;</span></div><div><br></div><h2 style=''text-align: center;''><em>Fiyo 1.5.0, More Stable, More Fast and More Elegant</em></h2>', '2013-08-01 21:26:08', '', 1, '', '', '', 1, 1, 99, 632, 'show_comment=2;\nshow_author=2;\nshow_date=2;\nshow_category=2;\nshow_tags=2;\nshow_hits=2;\nshow_rate=2;\nrate_value=5;\nrate_counter=1;\npanel_top=2;\npanel_bottom=2;\neditor_level=3;\nshow_title=2;\n', '2014-09-03 06:21:09', 1),
(17, 'Fiyo CMS 1.5.5', 1, '<p>Update yang sangat terasa untuk versi 1.5.x yaitu terlihat pada halaman installer dan login Admin Panel. Kami memberikan sentuhan lebih elegan agar lebih enak dipandang. Dan beberapa penyempurnaan untuk tampilan pada antar muka Admin Panel itu sendiri.</p>\r\n\r\n<p>Menu Admin Panel tampak lebih gelap dari versi sebelumnya dan tombol pun lebih enak dilihat. Selain dihalaman Admin Panel, theme untuk website juga ada sedikit sentuhan, menambahkan beberapa css untuk merubah notifikasi dan menu agar lebih pas di versi mobile.</p>\r\n\r\n<div style=''page-break-after: always;''><span style=''display: none;''>&nbsp;</span></div>\r\n\r\n<p>Pada bagian App User sudah bisa untuk aktifasi member melalui konfirmasi email ataupun pendaftaran otomatis aktif. Dan fitur lupa password menggunakan token yang dikirim melalui email.</p>\r\n\r\n<p>Fiyo 1.5.5 telah didukung fitur update otomatis. Jadi anda tidak perlu lagi mengupdate Fiyo installer secara penuh, hanya klik tombol otomatis maka Fiyo sudah update ke versi terbaru. Update ini juga bisa dilakukan secara manual melalui AddOns Installer. Fiyo&nbsp;1.5.5 juga menerapkan redirect www di Admin Panel, jadi www/non-www juga di filter pada Admin Panel.</p>\r\n\r\n<h3>New :&nbsp;</h3>\r\n\r\n<ul>\r\n	<li>User email activation</li>\r\n	<li>Update Otomatis</li>\r\n	<li>siteConfig(&#39;member_activation&#39;);</li>\r\n	<li>siteConfig(&#39;member_register&#39;);</li>\r\n	<li>siteConfig(&#39;member_group&#39;);</li>\r\n</ul>\r\n\r\n<h3>Update :</h3>\r\n\r\n<ul>\r\n	<li>User reminder</li>\r\n	<li>User register</li>\r\n	<li>Article</li>\r\n	<li>AdminPanel Login</li>\r\n	<li>Offline Theme</li>\r\n	<li>Curve Theme</li>\r\n	<li>Konfigurasi Situs</li>\r\n	<li>Bahasa App Contact</li>\r\n	<li>Bahasa App Comment</li>\r\n	<li>Bahasa App User</li>\r\n	<li>Merubah target pembaharuan :&nbsp;http://www.fiyo.org/update.xml</li>\r\n</ul>\r\n\r\n<h3>Fix :</h3>\r\n\r\n<ul>\r\n	<li>App Contact (personal-view)</li>\r\n	<li>App Article (featured,blog)</li>\r\n	<li>Plugin SEF (www redirection)</li>\r\n	<li>System Core :&nbsp;function.php -&gt; FUrl();</li>\r\n	<li>System Core :&nbsp;site.php -&gt; global</li>\r\n	<li>Dasboard Visitor Statistic</li>\r\n</ul>\r\n', '2013-12-01 21:24:24', '', 1, '', '', '/fiyo-sm-asdasdasdasd', 1, 1, 99, 961, 'show_comment=0;\nshow_author=0;\nshow_date=0;\nshow_category=0;\nshow_tags=0;\nshow_hits=0;\nshow_rate=0;\nrate_value=0;\nrate_counter=0;\npanel_top=0;\npanel_bottom=0;\neditor_level=3;\nshow_title=0;\n', '2014-09-02 11:28:11', 1),
(175, 'Fiyo CMS 1.4.0', 1, '<p>Setelah melalui masa percobaan untuk berbagai situs yang telah kembangkan, maka Fiyo 1.4.0 resmi dirilis pa;da tanggal 4 April 2013. Dengan mengusung judul <strong>Fiyo Go Store!&nbsp;</strong>dan pastinya Fi Store pun menjadi senjata andalan.6</p>\r\n\r\n<p>Fersi baru ini memiliki perbedaan dan perkembangan yang cukup signifikan. Karena update kali ini tidak hanya memperbaiki tetapi juga menambah beberapa modul dan apps baru, serta memodifikasi dasboard AdminPanel agar lebih informatif.</p>\r\n\r\n<div style=''page-break-after: always;''><span style=''display: none;''>&nbsp;</span></div>\r\n\r\n<p>Kita akan bahas satu-persatu mulai dari (belakang (AdminPanel)&nbsp;hingga sisi depan (Front Site).</p>\r\n\r\n<h3>Dasboard AdminPanel</h3>\r\n\r\n<p>Pada saat pertama kali login pada AdminPanel pasti akan diarahkan ke halaman Dasboard. Kali ini dasboard akan sedikit dirubah layoutnya dan penambahan fitur statistik agar AdminPanel lebih informatif.</p>\r\n\r\n<p>Berikut preview tampilan dasboard AdminPanel.</p>\r\n\r\n<p><img alt=''Dasboard Fiyo CMS'' longdesc=''Dasboard Fiyo CMS'' src=''/media/images/dasboard.jpg'' style=''width: 630px; height: 368px;'' /></p>\r\n\r\n<p>Gambar diatas pada sisi kiri menujukan statistik artikel terbaru dari semenjak Anda login terakhir kali di AdminPanel, komentar yang belum disetujui, jumlah user baru, dan versi Fiyo yang digunakan.</p>\r\n\r\n<p>Serta pada sisi kiri ada <em>line-chart</em>&nbsp;yang menunjukan jumlah pengunjung perhari dalam 7 hari terakhir. data pada warna biru menunjukan pengunjung unik untuk setiap <em>session</em>-nya dan untuk warna merah adalah pengujung unik setiap IP yang berbeda.</p>\r\n\r\n<p>Juga perombakan <em>shortcut icon</em> agar lebih fokus dikiri dan lebih rapih.</p>\r\n\r\n<h3>Fiyo Installer</h3>\r\n\r\n<p>Pada Fiyo 1.4.0 untuk installernya dibaerikan popup informasi tambahan sebagai panduan instalasi.</p>\r\n\r\n<p>Apakah itu server lokal yang tidak harus membuat database atau user terlebih daulu. Ataukan di server hosting yang mengharuskan untuk membuat user atau database terlebih dahulu.</p>\r\n\r\n<h3>Article System</h3>\r\n\r\n<p>Ada fitur baru yang mungkin wajib diketahui di bagian artikel. Pada bagian editor terdapat tombol baru di samping tombol &#39;Read More&#39;, yaitu tombol &#39;Attach File&#39; yang berguna untuk memanggil file yang disimpan di Media Manager. Tombol ini biasa digunakan untuk menautkan file yang siap diunduh oleh pengujung situs.</p>\r\n\r\n<p>Juga adanya pengaturan penanggalan yang berfungsi untuk mengatur penjadwalan artikel. Jadi, apabila artikel belum memasuki tanggal yang telah ditetapkan, maka artikel belom muncul atau bisa dikatakan belum aktif. Hal ini juga akan merubah input tanggal menjadi (Y-M-d H:i:s).</p>\r\n\r\n<p>Dan pengembangan baru untuk artikel adalah, penataan layout. Anda bisa memilih model layout melalui Menu, lalu seting parameter sesuai keinginan. Berikut gambaran layout urut mulai dari default, blog dan list.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3>User Management</h3>\r\n\r\n<p>Pada bagiang User Managemement juga ditambahkan fungsi baru untuk mengatur apakah situs menerima pendaftaran baru dari pengunjung atau tidak.&nbsp;</p>\r\n\r\n<p>Anda bisa menemukan tombol setting pada bagian atas di samping tombol simpan, hapus dan bantuan.</p>\r\n\r\n<h3>Comment System</h3>\r\n\r\n<p>Sistem komentar yang menggunakan Fi Comment juga turut diperbaharui. Anda bisa menggunakan dua pilihan <em>security code</em>&nbsp;atau yang lebih dikenal dengan <strong>captcha</strong>.&nbsp;</p>\r\n\r\n<p>Pada bagian konfigurasi komentar terdapat dua kolom untuk menampilkan reCaptcha. Apabila kolom tersebut salah atau tidak diisi maka Fi Comment akan menggunakan captcha matematika.</p>\r\n\r\n<p>Capthca matematika sendiri juga sudah diperbaharui, tidak lagi bersifat teks dan sekarang berbantuk gambar. Alasan memilih captcha matematika adalah untuk mengasah otak agar lebih aktif lagi dengan hitungan-hitungan sederhana.</p>\r\n\r\n<h3>Statistic System</h3>\r\n\r\n<p>Ada plugin baru yang ditanamkan didalam Fiyo 1.4.0 ini, yaitu sistem statistik untuk melihat detil pengujung. Sistem ini bekerja apabila ada yang mengakses website dan langsung akan tercatat IP, waktu, user id, platform, browser, negara dan kota yang tersimpan ditabel<em> _statistic</em></p>\r\n\r\n<p>Tabel tersebut bisa dimanfaatkan untuk membuat sebuah AddOn baru. Contoh AddOn dari pengembangan tabel tersebut adalah, statistik pengunjung di AdminPanel dan modul Ststistik yang menggantikan <em>Fi Tracker</em>.</p>\r\n\r\n<h3>Fiyo Store</h3>\r\n\r\n<p>Kali ini AddOn yang banyak ditunggu-tunggu adalah Fiyo Store atau dikenal dengan <strong>Fi Store</strong>. Tetapi Fi Store tidak disertakan secara langsung dalam paket instalasi versi terbaru ini. Anda harus megunduhnya dihalaman AddOns.</p>\r\n\r\n<p>Rilis untuk Fi Store waktunya sendiri tidak bersamaan dengan rislis Fiyo 1.4.0, karena senagja dijedakan beberapa hari untuk mengantisipasi update kecil pada Fiyo 1.4.0.</p>\r\n\r\n<h3>Sitemap XML Generator</h3>\r\n\r\n<p>Anda bisa melakukan pelacakan setiap url yang diciptakan dan merangkumnya dalam satu file XML yang bisa digunakan sebagai Sitemap. Fitur ini bisa digunakan dengan menggunakan <strong>Fi Sitemap</strong>.&nbsp;</p>\r\n\r\n<h3>Change Logs</h3>\r\n\r\n<ol>\r\n	<li>Penambahan fitur Sitemap &quot;XML&quot;.</li>\r\n	<li>Penambahan fitur perijinan regristrasi user baru.</li>\r\n	<li>Penambahan fitur reCaptcha dan captcha math.</li>\r\n	<li>Penambahan sistem rating untuk Article.</li>\r\n	<li>Penambahan biodata <em>Author</em> artikel (user).</li>\r\n	<li>Penambahan konfigurasi rating pada Article Parameter.</li>\r\n	<li>Penambahan konfigurasi layout artikel.</li>\r\n	<li>Penambahan fitur statistik.</li>\r\n	<li>Mengganti sistem penganggalan pada <em>Article</em>.</li>\r\n	<li>Mengganti nama fungsi&nbsp;<strong>dataConfig</strong>&nbsp;menjadi&nbsp;<strong>siteConfig</strong>.</li>\r\n	<li>Perbaikan fitur <strong>XML</strong> generat untuk <strong>RSS Feed.</strong></li>\r\n	<li>Perbaikan sistem Auto Installer.</li>\r\n</ol>\r\n', '2013-03-01 01:42:46', '', 1, '', 'Teknologi,CMS', '', 1, 1, 99, 34039, 'show_comment=2;\nshow_author=2;\nshow_date=2;\nshow_category=0;\nshow_tags=1;\nshow_hits=1;\nshow_rate=1;\nrate_value=10;\nrate_counter=2;\npanel_top=2;\npanel_bottom=2;\neditor_level=1;\nshow_title=2;\n', '2014-09-02 11:28:10', 1),
(183, 'Apa saja yang baru di Fiyo 2.0', 1, '<p>Lama sudah kami bertapa untuk melakukan perubahan yang cukup banyak pada Fiyo 2.0 ini. Dari versi sebelumnya Fiyo 1.5.7 kami langsung melakukan pengembangan ke versi terbaru dengan merubah banyak tampilan yang tentunya dengan tujuan yang lebih baik.</p>\r\n\r\n<p>Kita akan menerangkan beberapa hal yang ada pada Fiyo 2.0. Tapi sebelumnya Anda harus mencicipi versi sebelumnya agar tahu dimana perubahan yang kami lakukan hehe.</p>\r\n\r\n<p>Untuk perubahan kami melakukan 90% perubahan dari AdminPanel versi sebelumnya. Dari mulai tampilan dashboard, menu, footer-bar, header, dan tema dasar diubah semua dengan unsur warna elegant ditambah corak orange yang menjadi ciri khas Fiyo CMS.</p>\r\n\r\n<div style=''page-break-after: always;''><span style=''display: none;''>&nbsp;</span></div>\r\n\r\n<p>Dan untuk bagian sistem depan atau <em>front-site</em>&nbsp;tidak banyak melakukan banyak perubahan yang begitu terlihat. Tapi nanti bisa dirasakan sendiri bagaimana nikmatnya menggunakan Fiyo 2.0.</p>\r\n\r\n<p>Ok langsung saja kita mulai pembahasanya dari mulai halaman AdminPanel.</p>\r\n\r\n<h3>Halaman Login</h3>\r\n\r\n<p>Disini halaman Login masih menggunakan background 1.5.7 yg sebenarnya memang disiapkan untuk Fiyo 2.0. Tapi jangan salah dulu, background ini nanti bisa diubah menjadi apa yang Administrator ingin kan.</p>\r\n\r\n<p>Mau contohnya kan? ini nih...</p>\r\n\r\n<p style=''text-align: center;''><img alt=''Color Login Fiyo 2.0'' src=''/media/images/login-color.jpg'' style=''width: 600px; height: 383px;'' /><br />\r\nColor Login Fiyo 2.0</p>\r\n\r\n<p style=''text-align: center;''><img alt=''Default Theme Login Fiyo 2.0'' src=''/media/images/login-default.jpg'' style=''width: 600px; height: 383px;'' /><br />\r\nDefault Theme Login Fiyo 2.0</p>\r\n\r\n<p style=''text-align: center;''><img alt=''Night Blue Login Fiyo 2.0'' src=''/media/images/login-blue.jpg'' style=''width: 600px; height: 383px;'' /><br />\r\nNight Blue Login Fiyo 2.0</p>\r\n\r\n<p>Keren kan? hehe..</p>\r\n\r\n<p>Selanjutnya setelah login kita akan meilihat isi dari dashboard Fiyo 2.0.</p>\r\n\r\n<h3>Dashboard</h3>\r\n\r\n<p>Pada dashboard kita bisa memantau statistik pengunjung pada hari ini, bulan ini, total keseluruhan dan bahkan yang sedang online secara <em>realtime</em>.&nbsp;</p>\r\n\r\n<p>Ada juga statistik untuk artikel terakhir yang telah dibuat ataupun artikel favorit yang sering dibaca oleh pengunjung situs. Dan juga terdapat tombol singkat untuk langsung membuat artikel baru.</p>\r\n\r\n<p>Di bagian kanan terdapat kolom komentar yang juga terdapat tombol untuk langsung melakukan verifikasi komentar atau menyembunyikan komentar.</p>\r\n\r\n<p>Pada bagian bawah komentar terdapat kolom User yang menunjukan statistik user yang sedang login, user yang terakhir login dan user yang terakhir regristrasi.</p>\r\n\r\n<p style=''text-align: center;''><img alt=''Dashboard Fiyo 2.0'' src=''/media/images/dashboard.jpg'' style=''width: 800px;'' /><br />\r\nDashboard Fiyo 2.0</p>\r\n\r\n<h3>Manajemen Artikel</h3>\r\n\r\n<p>Untuk tampilan manajemen artikel menggunakan format tabel dengan daftar artikel yang telah di buat. Tidak ada perubahan yang signifikan disini. Hanya pada saat anda membuat artikel baru atau melakukan editing anda akan melihat layout baru dari kami. Dengan tombol tambahan <strong>simpan buat baru</strong> atau <strong>simpan sebagi duplikat</strong> bisa anda lakukan di Fiyo 2.0.</p>\r\n\r\n<p style=''text-align: center;''><img alt=''Edit Article Fiyo 2.0'' src=''/media/images/article.jpg'' style=''width: 700px; height: 387px;'' /><br />\r\nEdit Article Fiyo 2.0</p>\r\n\r\n<p>Ada perubahan format sub-menu di bawah menu <strong>Articles</strong>, yaitu tambahan dari menu <strong>Comments</strong> dan <strong>Tags</strong>&nbsp;yang masin-masing berguna untuk mengelola komentar artikel dan pelabelan artikel.&nbsp;<span style=''line-height: 1.6em;''>Ini akan memudahkan dalam mengelola apa lagi pelabelan yang teratur dengan referensi yang jelas.</span></p>\r\n\r\n<p><span style=''line-height: 1.6em;''>Untuk melakukan editing pada front-site Anda perlu klik 2 kali agar bisa masuk ke mode edit.</span></p>\r\n\r\n<h3>Fiyo Apps</h3>\r\n\r\n<p>Apps bawaan dari Fiyo 2.0 adalah Contact, Permalink (dulu : SEF), Sitemap. Ketiga itu merupakan bonus dan juga Aplikasi yang wajib dimiliki untuk seorang admionistrator website. Kecuali Contact yang digunakan pada organisasi atau perusahaan saja.</p>\r\n\r\n<p>Apps Permalink yang telah di sempurnakan bebarengan dengan Plugin SEF dan Sitemap yang siap digunakan akan membuat website lebih baik dalam memposisikan diri di situs pencari.</p>\r\n\r\n<h3>Manajemen Modul</h3>\r\n\r\n<p>Pada modul ada perbaikan lagi untuk pemilihan halaman ataupun pemilihan posisi modul. Fiyo 2.0 tidak membutuhkan lagi file spot_position.php atau spot_position.gif dalam tema untuk memuat posisi. Karena Fiyo 2.0 Sudah bisa melakukan <em>generate</em>&nbsp;otomatis untuk menampilkan posisi modul.</p>\r\n\r\n<p style=''text-align: center;''><img alt='''' src=''/media/images/module_position.jpg'' style=''width: 600px; height: 332px;'' /><br />\r\nPosisi Modul Fiyo 2.0</p>\r\n\r\n<h3>Menejemen Tema</h3>\r\n\r\n<p>Fiyo 2.0 menampilkan foto preview dari tema dalam daftar tema yang tersedia. Dan untuk tampilan lain tidak memiliki perubahan besar.</p>\r\n\r\n<p style=''text-align: center;''><img alt='''' src=''/media/images/edit_theme2.jpg'' style=''width: 600px; height: 383px;'' /><br />\r\nEdit Theme Fiyo 2.0</p>\r\n\r\n<p>Pengaturan, Instalasi dan Backup</p>\r\n\r\n<p>Mungkin memang fitur yang ini tidak ada di Fiyo sebelumnya. Ya, fitur backup baru saja kami tambahkan di Fiyo 2.0. Fitur ini bisa diakses pada menu <strong>Settings </strong>&gt; <strong>Backup &amp; Restore</strong>.&nbsp;</p>\r\n\r\n<p style=''text-align: center;''><img alt='''' src=''/media/images/backup-restore.jpg'' style=''width: 600px; height: 366px;'' /><br />\r\nBackup &amp; Restore Fiyo 2.0</p>\r\n\r\n<p>Terdapat 3 Pilihan mode backup yang nanti sedikit akan dibahas.</p>\r\n\r\n<ol>\r\n	<li><strong>Database Backup</strong> : Akan melakukan backup pada seluruh database yang digunakan.</li>\r\n	<li><strong>Backup Tables</strong> : Anda bisa melakukan backup sesuai tabel yang anda pilih.</li>\r\n	<li><strong>Backup Installer</strong> : Melakukan migrasi antar server atau dari offline ke online server? Anda bisa menggunakan fitur ini.</li>\r\n</ol>\r\n\r\n<p>Ok, semoga Fiyo 2.0 dapat diterima dengan baik dan banyak mendapat dukungan.</p>\r\n\r\n<p style=''text-align: center;''><strong>Terimakasih, Maju terus karya Indonesia!&nbsp;</strong></p>\r\n', '2014-09-03 10:27:30', '', 1, '', '', '', 1, 1, 99, 38, 'show_comment=2;\nshow_author=2;\nshow_date=2;\nshow_category=2;\nshow_tags=2;\nshow_hits=2;\nshow_rate=2;\nrate_value=0;\nrate_counter=0;\npanel_top=2;\npanel_bottom=2;\neditor_level=3;\nshow_title=2;\n', '2014-09-03 07:02:06', 1);


-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_article_category`
--

DROP TABLE IF EXISTS `db_prefix_article_category`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_article_category` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `parent_id` int(5) NOT NULL,
  `description` varchar(250) NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `level` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;
--

--
-- Dumping data for table `db_prefix_article_category`
--

INSERT INTO `db_prefix_article_category` (`id`, `name`, `parent_id`, `description`, `keywords`, `level`) VALUES
(1, 'Blog', 0, 'Blog', 'Blog', 99),
(2, 'News', 0, 'Berita Mengenai Kampus', 'Berita kampus', 99),
(3, 'Page', 0, '', '', 99),
(55, 'Tutorial', 0, '', '', 99);
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_article_tags`
--

DROP TABLE IF EXISTS `db_prefix_article_tags`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_article_tags` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `hits` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;
--

--
-- Dumping data for table `db_prefix_article_tags`
--

INSERT INTO `db_prefix_article_tags` (`id`, `name`, `description`, `hits`) VALUES
(49, 'Teknologi', '', 0),
(50, 'House', '', 0),
(76, 'CMS', '', 0),
(77, 'Android', '', 0),
(78, 'Review', '', 0);
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_comment`
--

DROP TABLE IF EXISTS `db_prefix_comment`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(250) NOT NULL,
  `user_id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  `status` int(1) NOT NULL,
  `apps` varchar(50) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `parent_user_email` varchar(50) NOT NULL,
  `thread_user_email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;
--

--
-- Dumping data for table `db_prefix_comment`
--

INSERT INTO `db_prefix_comment` (`id`, `link`, `user_id`, `name`, `email`, `website`, `date`, `comment`, `status`, `apps`, `parent_id`, `parent_user_email`, `thread_user_email`) VALUES
(133, '?app=article&view=item&id=12', 0, 'Andi Off', 'andi_of@gmail.com', '', '2014-09-02 17:59:32', 'Semakin kenal semakin bagus hehehe :)', 1, 'article', 1, '1', '1'),
(134, '?app=article&view=item&id=14', 0, 'Seem', 'seem@gmail.com', '', '2014-09-02 18:00:38', 'Semoga tambah jaya selalu min', 1, 'article', 1, '1', '1'),
(135, '?app=article&view=item&id=12', 1, 'Administrator', 'admin@admin.com', '', '2014-09-02 18:04:19', 'Benar juga gan!', 1, 'article', 1, '1', '1');
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_comment_setting`
--

DROP TABLE IF EXISTS `db_prefix_comment_setting`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_comment_setting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `value` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;
--

--
-- Dumping data for table `db_prefix_comment_setting`
--

INSERT INTO `db_prefix_comment_setting` (`id`, `name`, `value`) VALUES
(1, 'auto_submit', '0'),
(2, 'name_filter', 'Admin, Administrator'),
(3, 'email_filter', 'email'),
(4, 'word_filter', 'anj, ngsat, sial, njin'),
(6, 'recaptcha_privatekey', ''),
(5, 'recaptcha_publickey', '');
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_contact`
--

DROP TABLE IF EXISTS `db_prefix_contact`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_contact` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `job` varchar(100) NOT NULL,
  `photo` text NOT NULL,
  `web` varchar(30) NOT NULL,
  `ym` varchar(50) NOT NULL,
  `fb` varchar(50) NOT NULL,
  `tw` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `group_id` int(5) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
--

--
-- Dumping data for table `db_prefix_contact`
--

INSERT INTO `db_prefix_contact` (`id`, `name`, `gender`, `email`, `address`, `city`, `state`, `country`, `zip`, `phone`, `fax`, `job`, `photo`, `web`, `ym`, `fb`, `tw`, `description`, `group_id`, `status`) VALUES
(1, 'First Ryan', 1, 'firstryan@gmail.com', 'Jl. Selomulyo Mukti Timur VI\r\n\r\n\r\n\r\n444', 'Semarang', 'Jawa Tengah', 'Indonesia', '50195', '+62 898 578 578 7', '', '', '/fiyo_2.0/media/images/brush.png', 'firstryan.net', 'firstryan@ymail.com', 'firstryan', 'firstryan', '', 1, 1);
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_contact_group`
--

DROP TABLE IF EXISTS `db_prefix_contact_group`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_contact_group` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
--

--
-- Dumping data for table `db_prefix_contact_group`
--

INSERT INTO `db_prefix_contact_group` (`id`, `name`, `description`) VALUES
(1, 'Developer', 'Fiyo Developers ');
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_menu`
--

DROP TABLE IF EXISTS `db_prefix_menu`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `link` text NOT NULL,
  `app` varchar(100) NOT NULL,
  `parent_id` int(5) NOT NULL,
  `status` int(5) NOT NULL,
  `short` int(5) NOT NULL,
  `level` int(5) NOT NULL DEFAULT '3',
  `home` int(5) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL,
  `show_title` int(2) NOT NULL,
  `sub_name` varchar(100) NOT NULL,
  `class` varchar(200) NOT NULL,
  `style` text NOT NULL,
  `parameter` text NOT NULL,
  `global` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=106 ;
--

--
-- Dumping data for table `db_prefix_menu`
--

INSERT INTO `db_prefix_menu` (`id`, `category`, `name`, `link`, `app`, `parent_id`, `status`, `short`, `level`, `home`, `title`, `show_title`, `sub_name`, `class`, `style`, `parameter`, `global`) VALUES
(2, 'mainmenu', 'About', '?app=article&view=item&id=12', 'app_article', 0, 1, 3, 99, 0, '', 0, '', '', '', 'per_page=5;\nshow_panel=0;\nread_more=;\nimgW=120;\nimgH=100;\nformat=default;\nintro=5;\npanel_format=how_panel=0;\nshow_rss=1;\n', 0),
(3, 'mainmenu', 'Blog', '?app=article&view=category&id=1', 'app_article', 0, 1, 2, 99, 0, '', 0, '', '', '', 'per_page=5;\nshow_panel=1;\nread_more=;\nimgW=120;\nimgH=100;\nformat=blog;\nintro=5;\npanel_format=;\nshow_rss=1;\n', 1),
(8, 'mainmenu', 'Contact', '?app=contact&view=group&id=1', 'app_contact', 0, 1, 5, 99, 0, '', 1, '', '', '', 'per_page=10;\nshow_name=1;\nshow_group=1;\nshow_gender=0;\nshow_address=0;\nshow_phone=0;\nshow_email=0;\nshow_links=0;\nshow_job=0;\nshow_photo=0;\n', 0),
(23, 'mainmenu', 'Home', '?app=article&view=archives', 'app_article', 0, 1, 0, 99, 1, '', 0, '', '', '', 'per_page=3;\nshow_panel=1;\nread_more=;\nimgW=200;\nimgH=150;\nformat=blog;\nintro=4;\npanel_format=;\nshow_rss=1;\n', 0),
(41, 'mainmenu', 'Sub Child', '?app=article&view=category&id=1', 'app_article', 103, 1, 0, 99, 0, '', 1, '', '', '', 'per_page=5;\nshow_panel=0;\nread_more=;\nimgW=120;\nimgH=100;\nformat=default;\nintro=5;\npanel_format=;\nshow_rss=0;\n', 0),
(18, 'mainmenu', 'Category', '?app=article&view=category&id=1', 'app_article', 0, 1, 1, 99, 0, '', 0, '', '', '', 'per_page=5;\nshow_panel=0;\nread_more=;\nimgW=120;\nimgH=100;\nformat=default;\nintro=5;\npanel_format=;\nshow_rss=0;\n', 0),
(42, 'footer', 'First Ryan', '?app=article&view=item&id=5', 'app_article', 0, 0, 0, 99, 0, '', 1, '', '', '', 'per_page=5;\nshow_panel=0;\nread_more=;\nimgW=120;\nimgH=100;\nformat=default;\nintro=5;\npanel_format=;\nshow_rss=0;\n', 0),
(104, 'footer', 'About Foot', '?app=article&view=item&id=12', 'app_article', 0, 1, 0, 99, 0, '', 1, '', '', '', 'per_page=5;\nshow_panel=0;\nread_more=;\nimgW=120;\nimgH=100;\nformat=default;\nintro=5;\npanel_format=;\nshow_rss=0;\n', 0),
(55, 'adminpanel', 'Dashboard', 'index.php', 'link', 0, 1, 0, 3, 0, '', 1, '', 'icon-home', '', '', 0),
(56, 'adminpanel', 'Articles', '#', 'sperator', 0, 1, 1, 5, 0, '', 1, 'article', 'icon-file-text', '', '', 0),
(57, 'adminpanel', 'New Article', '?app=article&act=add', 'link', 56, 1, 0, 3, 0, '', 1, '', 'icon-plus', '', '', 0),
(63, 'adminpanel', 'Comments', '?app=article&view=comment', 'link', 56, 1, 3, 3, 0, '', 1, '', 'icon-comments', '', '', 0),
(61, 'adminpanel', 'Article List', '?app=article', 'link', 56, 1, 1, 99, 0, '', 1, '', 'icon-list-alt', '', '', 0),
(62, 'adminpanel', 'Categories', '?app=article&view=category', 'link', 56, 1, 2, 2, 0, '', 1, '', 'icon-book', '', '', 0),
(64, 'adminpanel', 'Tags', '?app=article&view=tag', 'link', 56, 1, 4, 3, 0, '', 1, '', 'icon-tag', '', '', 0),
(65, 'adminpanel', 'Apps', '#', 'sperator', 0, 1, 2, 3, 0, '', 1, 'apps', 'icon-star', '', '', 0),
(66, 'adminpanel', 'File Manager', '#', 'sperator', 0, 1, 5, 99, 0, '', 1, 'media', 'icon-folder-open', '', '', 0),
(67, 'adminpanel', 'Images', '?app=media', 'link', 66, 1, 1, 5, 0, '', 1, '', 'icon-picture', '', '', 0),
(68, 'adminpanel', 'Videos', '?app=media&type=flash', 'link', 66, 1, 1, 5, 0, '', 1, '', 'icon-facetime-video', '', '', 0),
(87, 'adminpanel', 'Backup & Restore', '?app=config&view=backup', 'link', 83, 1, 3, 1, 0, '', 1, '', 'icon-repeat', '', '', 0),
(69, 'adminpanel', 'Other Files', '?app=media&type=files', 'link', 66, 1, 2, 5, 0, '', 1, '', 'icon-file', '', '', 0),
(70, 'adminpanel', 'Menus', '#', 'sperator', 0, 1, 6, 2, 0, '', 1, 'menu', 'icon-list-ul', '', '', 0),
(71, 'adminpanel', 'New Menu', '?app=menu&view=add', 'link', 70, 1, 0, 2, 0, '', 1, '', 'icon-plus', '', '', 0),
(72, 'adminpanel', 'Menu List', '?app=menu', 'link', 70, 0, 1, 2, 0, '', 1, '', 'icon-list-alt', '', '', 0),
(73, 'adminpanel', 'Categories', '?app=menu&view=category', 'link', 70, 1, 2, 2, 0, '', 1, '', 'icon-book', '', '', 0),
(74, 'adminpanel', 'Modules', '?app=module', 'link', 0, 1, 7, 2, 0, '', 1, 'module', 'icon-inbox', '', '', 0),
(75, 'adminpanel', 'Themes', '#', 'sperator', 0, 1, 8, 2, 0, '', 1, 'theme', 'icon-magic', '', '', 0),
(76, 'adminpanel', 'Front End', '?app=theme', 'link', 75, 1, 0, 2, 0, '', 1, '', 'icon-desktop', '', '', 0),
(77, 'adminpanel', 'Admin Panel', '?app=theme&view=admin', 'link', 75, 1, 2, 2, 0, '', 1, '', 'icon-laptop', '', '', 0),
(78, 'adminpanel', 'Users', '#', 'sperator', 0, 1, 9, 2, 0, '', 1, 'user', 'icon-user', '', '', 0),
(79, 'adminpanel', 'New User', '?app=user&act=add', 'link', 78, 1, 0, 2, 0, '', 1, '', 'icon-plus', '', '', 0),
(80, 'adminpanel', 'User List', '?app=user', 'link', 78, 1, 2, 2, 0, '', 1, '', 'icon-list-alt', '', '', 0),
(81, 'adminpanel', 'User Group', '?app=user&view=group', 'link', 78, 1, 3, 2, 0, '', 1, '', 'icon-group', '', '', 0),
(82, 'adminpanel', 'Plugins', '?app=plugin', 'link', 0, 1, 10, 2, 0, '', 1, 'plugin', 'icon-bolt', '', '', 0),
(83, 'adminpanel', 'Settings', '#', 'sperator', 0, 1, 11, 2, 0, '', 1, 'config', 'icon-cog', '', '', 0),
(84, 'adminpanel', 'Configuration', '?app=config', 'link', 83, 1, 0, 2, 0, '', 1, '', 'icon-cogs', '', '', 0),
(85, 'adminpanel', 'Manages', '?app=config&view=apps', 'link', 83, 1, 2, 1, 0, '', 1, '', 'icon-th', '', '', 0),
(86, 'adminpanel', 'Install & Update', '?app=config&view=install', 'link', 83, 1, 3, 1, 0, '', 1, '', 'icon-download-alt', '', '', 0),
(89, 'adminpanel', 'Sitemap', '?app=sitemap', 'link', 65, 1, 20, 2, 0, '', 1, '', 'icon-sitemap', '', '', 0),
(90, 'adminpanel', 'Permalink', '?app=permalink', 'link', 65, 1, 0, 2, 0, '', 1, '', 'icon-link', '', '', 0),
(92, 'adminpanel', 'Contact', '?app=contact', 'link', 65, 1, 0, 99, 0, '', 1, '', 'icon-group', 'ooo', '', 0),
(103, 'mainmenu', 'Child Menu', '#', 'sperator', 18, 1, 0, 99, 0, '', 1, '', '', '', '', 0),
(105, 'mainmenu', 'Very Child', '#', 'sperator', 103, 1, 0, 99, 0, '', 1, '', '', '', '', 0);
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_menu_category`
--

DROP TABLE IF EXISTS `db_prefix_menu_category`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_menu_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_2` (`category`),
  UNIQUE KEY `category_3` (`category`),
  KEY `category` (`category`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;
--

--
-- Dumping data for table `db_prefix_menu_category`
--

INSERT INTO `db_prefix_menu_category` (`id`, `category`, `title`, `description`, `level`) VALUES
(1, 'mainmenu', 'Main Menu', 'Menu utama', 2),
(2, 'footer', 'Footer Menu', '', 99),
(9, 'adminpanel', 'Admin Panel', 'Menu for Admin Panel', 1);
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_module`
--

DROP TABLE IF EXISTS `db_prefix_module`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_module` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `folder` varchar(150) NOT NULL,
  `position` varchar(100) NOT NULL,
  `short` int(2) NOT NULL,
  `level` int(2) NOT NULL DEFAULT '3',
  `status` int(2) NOT NULL DEFAULT '1',
  `page` varchar(250) NOT NULL,
  `parameter` text NOT NULL,
  `class` varchar(200) NOT NULL,
  `style` text NOT NULL,
  `show_title` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=122 ;
--

--
-- Dumping data for table `db_prefix_module`
--

INSERT INTO `db_prefix_module` (`id`, `name`, `folder`, `position`, `short`, `level`, `status`, `page`, `parameter`, `class`, `style`, `show_title`) VALUES
(1, 'Menu', 'mod_menu', 'mainmenu', 0, 99, 1, '23,18,41,3,2,8,42', 'category=mainmenu;\ntype=2;\nsub_menu=1;\nsub_title=0;\n', '', '', 0),
(121, 'Tags', 'mod_article_tags', 'right', 2, 99, 1, '23,18,103,41,3,2,8,42,104', '', '', '', 1),
(118, 'Search', 'mod_search', 'search', 0, 99, 1, '23,18,41,3,2,8,42', '', '', '', 0),
(5, 'You are here : ', 'mod_breadcrumb', 'breadcrumb', 0, 99, 1, '23,18,41,36,49,3,2,8,42,40,43,48', '', '', '', 1),
(6, 'Comments', 'mod_comment', 'right', 2, 99, 1, '23,18,41,3,2,8,42', 'name=1;\ngravatar=1;\ntitle=1;\ncomment=0;\ndate=1;\ntext=100;\nitem=5;\n', '', '', 1),
(119, 'Statistic', 'mod_statistic', 'right', 3, 99, 1, '23,18,41,3,2,8,42', 'today=1;\nyesterday=1;\nthisweek=1;\nlastweek=1;\nthismonth=1;\nlastmonth=1;\nall=0;\ninfo=0;\n', '', '', 1),
(96, 'Next', 'mod_article_nextprev', 'article-mid', 0, 99, 1, '23,18,41,36,49,93,3,2,8,42,40,43,48,96,97,98', 'cat=1,2,3,55;\nfilter=;\n', '', '', 0),
(120, 'User Panel', 'mod_user', 'right', 0, 99, 1, '23,18,41,3,2,8,42', '', '', '', 1);
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_permalink`
--

DROP TABLE IF EXISTS `db_prefix_permalink`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_permalink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` text NOT NULL,
  `permalink` varchar(250) NOT NULL,
  `pid` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `locker` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permalink` (`permalink`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=262 ;
--

--
-- Dumping data for table `db_prefix_permalink`
--

INSERT INTO `db_prefix_permalink` (`id`, `link`, `permalink`, `pid`, `status`, `locker`) VALUES
(232, '?app=article&view=archives&feed=rss', 'archives.rss', 41, 1, 0),
(231, '?app=article&view=item&id=17', 'blog/fiyo-cms-1-5-5.html', 3, 1, 0),
(230, '?app=article&view=category&id=1', 'blog', 3, 1, 0),
(233, '?app=article&view=item&id=14', 'blog/fiyo-cms-1-5-0.html', 3, 1, 0),
(234, '?app=article&view=item&id=6', 'blog/fiyo-1-2-2-dengan-fitur-lebih-canggih.html', 3, 1, 0),
(235, '?app=article&view=item&id=175', 'blog/fiyo-cms-1-4-0.html', 3, 1, 0),
(240, '?app=user', 'user', 3, 1, 0),
(238, '?app=user&view=logout', 'user/logout', 3, 1, 0),
(241, '?app=user&view=edit', 'user/edit', 3, 1, 0),
(242, '?app=user&view=login', 'user/login', 3, 1, 0),
(243, '?app=user&view=register', 'user/register', 3, 1, 0),
(244, '?app=user&view=lost_password', 'user/remember', 3, 1, 0),
(245, '?app=search', 'search', 3, 1, 0),
(246, '?app=contact&view=group&id=1', 'contact/developer', 8, 1, 0),
(247, '?app=article&view=item&id=12', 'blog/mengenal-lebih-dekat-tentang-fiyo-cms.html', 3, 1, 0),
(248, '?app=contact&view=person&id=1', 'contact/developer/first-ryan.html', 3, 1, 0),
(249, '?app=article&tag=Home', 'tag/home', 3, 1, 0),
(250, '?app=article&tag=CMS', 'tag/cms', 3, 1, 0),
(251, '?app=article&view=item&id=182', 'news/fiyo-cms-1-5-7-3-0.html', 3, 1, 0),
(252, '?app=article&view=category&id=2', 'news', 3, 1, 0),
(253, '?app=article&view=item&id=10', 'news/fiyo-cms-1-3-0.html', 3, 1, 0),
(254, '?app=article&view=item&id=7', 'blog/update-checkpoint-di-versi-1-2-3.html', 3, 1, 0),
(255, '?app=article&tag=Review', 'tag/review', 3, 1, 0),
(256, '?app=article&tag=Review&feed=rss', 'tag/review.rss', 3, 1, 0),
(257, '?app=article&tag=Teknologi', 'tag/teknologi', 3, 1, 0),
(258, '?app=article&tag=Teknologi&feed=rss', 'tag/teknologi.rss', 3, 1, 0),
(259, '?app=article&view=category&id=2&feed=rss', 'news.rss', 3, 1, 0),
(260, '?app=article&tag=CMS&feed=rss', 'tag/cms.rss', 3, 1, 0),
(261, '?app=article&view=category&id=1&feed=rss', 'blog.rss', 3, 1, 0);
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_plugin`
--

DROP TABLE IF EXISTS `db_prefix_plugin`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_plugin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `folder` varchar(20) NOT NULL,
  `status` smallint(1) NOT NULL,
  `parameter` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `folder_2` (`folder`),
  KEY `folder` (`folder`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;
--

--
-- Dumping data for table `db_prefix_plugin`
--

INSERT INTO `db_prefix_plugin` (`id`, `folder`, `status`, `parameter`) VALUES
(1, 'plg_sef', 1, ''),
(2, 'plg_cache', 1, ''),
(3, 'plg_recaptcha', 1, ''),
(4, 'plg_statistic', 1, '');
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_session_login`
--

DROP TABLE IF EXISTS `db_prefix_session_login`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_session_login` (
  `user_id` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_setting`
--

DROP TABLE IF EXISTS `db_prefix_setting`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_setting` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;
--

--
-- Dumping data for table `db_prefix_setting`
--

INSERT INTO `db_prefix_setting` (`id`, `name`, `value`) VALUES
(1, 'site_theme', 'bluestrap_theme'),
(2, 'admin_theme', 'fiyo'),
(3, 'site_name', '_site_title'),
(4, 'site_keys', 'keyword 1, keyword two, 3rd key'),
(5, 'site_desc', '_site_desc'),
(6, 'site_title', 'Fast, Save & Elegant!'),
(7, 'site_url', 'localhost'),
(8, 'site_status', '1'),
(9, 'sef_url', '1'),
(10, 'file_allowed', 'swf flv avi mpg mpeg qt mov wmv asf rm rar zip exe msi iso'),
(11, 'file_size', '5120'),
(12, 'media_theme', 'oxygen'),
(13, 'title_type', '1'),
(14, 'title_divider', ' - '),
(15, 'sef_www', '1'),
(16, 'sef_ext', '.html'),
(17, 'site_mail', 'your@site.net'),
(18, 'backend_folder', 'dapur'),
(19, 'follow_link', '1'),
(20, 'member_registration', '1'),
(21, 'member_activation', '2'),
(22, 'member_group', '5'),
(23, 'version', '2.0 1.0'),
(24, 'lang', 'id'),
(25, 'timezone', 'Asia/Jakarta'),
(26, 'api_key', '500'),
(27, 'disk_space', '500');
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_statistic`
--

DROP TABLE IF EXISTS `db_prefix_statistic`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_statistic` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) NOT NULL,
  `user_id` int(10) NOT NULL,
  `time` datetime NOT NULL,
  `browser` varchar(30) NOT NULL,
  `platform` varchar(30) NOT NULL,
  `country` varchar(15) NOT NULL,
  `city` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--

-- --------------------------------------------------------

--
-- Table structure for table `db_prefix_statistic_online`
--

DROP TABLE IF EXISTS `db_prefix_statistic_online`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_statistic_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) NOT NULL,
  `url` tinytext NOT NULL,
  `time` int(11) NOT NULL,
  `browser` varchar(20) NOT NULL,
  `platform` varchar(20) NOT NULL,
  `country` varchar(30) NOT NULL,
  `city` varchar(50) NOT NULL,
  `key` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--

--
-- Table structure for table `db_prefix_user`
--

DROP TABLE IF EXISTS `db_prefix_user`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` int(2) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '3',
  `time_reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_log` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `about` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
--


--
-- Table structure for table `db_prefix_user_group`
--

DROP TABLE IF EXISTS `db_prefix_user_group`;
--
CREATE TABLE IF NOT EXISTS `db_prefix_user_group` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `level` int(2) NOT NULL,
  `description` text NOT NULL,
  `allowed_apps` varchar(200) NOT NULL,
  `default_apps` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `level` (`level`),
  KEY `group` (`group_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
--

--
-- Dumping data for table `db_prefix_user_group`
--

INSERT INTO `db_prefix_user_group` (`id`, `group_name`, `level`, `description`, `allowed_apps`, `default_apps`) VALUES
(1, 'Super Administrator', 1, 'Super Administrator', '', ''),
(2, 'Administrator', 2, 'Admin', '', ''),
(3, 'Editor', 3, 'Editor', '', ''),
(4, 'Publisher', 4, 'Publisher Konten', '', ''),
(5, 'Member', 5, 'Registered Member', '', '');
--
